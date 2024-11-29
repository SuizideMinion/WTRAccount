<?php

namespace App\Http\Controllers;
use App\Models\TimeEntry;
use App\Models\LeaveRequest;
use App\Services\UserWorkHours;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeTrackingController extends Controller
{

    private function findCurrentEntry($userId)
    {
        return TimeEntry::where('user_id', $userId)
            ->whereNull('clock_out')
            ->first(); // Modify according to your logic
    }
    protected $userWorkHoursService;

    public function __construct(UserWorkHours $userWorkHoursService)
    {
        $this->userWorkHoursService = $userWorkHoursService;
    }

    public function pause(Request $request)
    {
        // Assuming you have a method to find the current entry
        $entry = $this->findCurrentEntry($request->user()->id);

        if ($entry && !$entry->paused_at) {
            $entry->paused_at = Carbon::now();
            $entry->save();

            return response()->json(['message' => 'Paused successfully.']);
        }

        return response()->json(['message' => 'No active entry to pause.'], 400);
    }

    public function resume(Request $request)
    {
        $entry = $this->findCurrentEntry($request->user()->id);

        if ($entry && $entry->paused_at) {
            $pausedDuration = Carbon::now()->diffInSeconds($entry->paused_at);
            $entry->paused_duration += $pausedDuration;
            $entry->paused_at = null; // Reset paused_at
            $entry->save();

            return response()->json(['message' => 'Resumed successfully.']);
        }

        return response()->json(['message' => 'No paused entry to resume.'], 400);
    }

    public function showUserTimeEntries(Request $request)
    {
        $userId = auth()->id(); // Assume you get user ID from request
        $month = 11; // For March
        $year = 2024; // For the year 2024

        // Get total hours worked
        $totalHours = $this->userWorkHoursService->getTotalHoursWorked($userId, $month, $year);

        // Get all time entries
        $timeEntries = $this->userWorkHoursService->getAllTimeEntriesByMonth($userId, $month, $year);

        return view('user_time_entries', [
            'userId' => $userId,
            'totalHours' => $totalHours,
            'timeEntries' => $timeEntries,
        ]);
    }

    public function showTimeTracking()
    {
        $user = auth()->user();
        $isClockedIn = $user->timeEntries()->whereNull('clock_out')->exists();
        $timeEntries = $user->timeEntries()->orderBy('clock_in', 'desc')->get();

        return view('time_tracking', compact('isClockedIn', 'timeEntries'));
    }
    public function clockIn()
    {
        $user = auth()->user();
        $timeEntry = $user->timeEntries()->create([
            'clock_in' => Carbon::now(),
        ]);
        return response()->json(['message' => 'Clocked in', 'entry' => $timeEntry]);
    }

    public function clockOut(Request $request)
    {
        // Find the current entry
        $entry = $this->findCurrentEntry($request->user()->id);

        if ($entry) {
            $entry->clock_out = Carbon::now();

            // Calculate the total worked seconds
            $workedSeconds = Carbon::parse($entry->clock_in)->diffInSeconds($entry->clock_out);
            // Subtract the paused duration
            $totalSeconds = $workedSeconds - $entry->paused_duration;

            // If totalSeconds is negative, set it to zero
            $totalSeconds = max($totalSeconds, 0);

            // Save the total duration in hours:minutes:seconds format
            $entry->total_duration = gmdate("H:i:s", $totalSeconds);
//            $entry->paused_duration = 0; // Reset paused duration after clocking out
            $entry->save();

            return response()->json(['message' => 'Clocked out successfully.', 'total_duration' => $entry->total_duration]);
        }

        return response()->json(['message' => 'No active entry to clock out.'], 400);
    }

    public function requestLeave(Request $request)
    {
        $request->validate([
            'type' => 'required|in:vacation,sick',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $leaveRequest = auth()->user()->leaveRequests()->create($request->only('type', 'start_date', 'end_date'));

        return response()->json(['message' => 'Leave requested', 'request' => $leaveRequest]);
    }
    public function getSummary(Request $request, $userId)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $summary = $this->userWorkHoursService->getMonthlyHoursSummary($userId, $month, $year);

        return response()->json($summary);
    }

    public function getEntries(Request $request, $userId)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        return response()->json($this->userWorkHoursService->getAllTimeEntriesByMonth($userId, $month, $year));
    }

    public function deleteEntry($entryId)
    {
        $this->userWorkHoursService->deleteTimeEntry($entryId);
        return response()->json(['message' => 'Entry deleted successfully']);
    }
}
