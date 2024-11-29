<?php

namespace App\Services;

use App\Models\TimeEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserWorkHours
{
    public function getTotalHoursWorked($userId, $month, $year)
    {
        // Get the start and end dates of the specified month
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Query the database for the user's time entries in that month
        $totalSeconds = TimeEntry::where('user_id', $userId)
            ->whereBetween('clock_in', [$startDate, $endDate])
            ->get()
            ->sum(function ($entry) {
                return $entry->clock_out ?
                    Carbon::parse($entry->clock_in)->diffInSeconds(Carbon::parse($entry->clock_out)) : 0;
            });

        return $this->formatDurationFromSeconds($totalSeconds);
    }

    public function getAllTimeEntriesByMonth($userId, $month, $year)
    {
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        return TimeEntry::where('user_id', $userId)
            ->whereBetween('clock_in', [$startDate, $endDate])
            ->get()
            ->map(function ($entry) {
                return [
                    'clock_in' => Carbon::parse($entry->clock_in)->format('Y-m-d H:i:s'),
                    'clock_out' => $entry->clock_out ? Carbon::parse($entry->clock_out)->format('Y-m-d H:i:s') : null,
                    'duration' => $entry->clock_out ?
                        $this->formatDuration($entry->clock_in, $entry->clock_out) : 'N/A',
                ];
            });
    }

    public function getTotalDaysWorked($userId, $month, $year)
    {
        return TimeEntry::where('user_id', $userId)
            ->whereMonth('clock_in', $month)
            ->whereYear('clock_in', $year)
            ->distinct()
            ->count('clock_in_date'); // Assuming clock_in_date is formatted
    }

    public function getMonthlyHoursSummary($userId, $month, $year)
    {
        $totalHours = DB::table('time_entries')
            ->where('user_id', $userId)
            ->whereMonth('clock_in', $month)
            ->whereYear('clock_in', $year)
            ->sum(DB::raw('TIMESTAMPDIFF(SECOND, clock_in, clock_out)'));

        $totalDays = DB::table('time_entries')
            ->where('user_id', $userId)
            ->whereMonth('clock_in', $month)
            ->whereYear('clock_in', $year)
            ->distinct('clock_in') // Change this to count distinct clock_in timestamps
            ->count('clock_in'); // Ensure you are counting the clock_in records

        return [
            'total_hours' => gmdate("H:i:s", $totalHours),
            'total_days' => $totalDays,
        ];
    }

    public function getTimeEntriesForSpecificDay($userId, $date)
    {
        return TimeEntry::where('user_id', $userId)
            ->whereDate('clock_in', $date)
            ->get()
            ->map(function ($entry) {
                return [
                    'clock_in' => Carbon::parse($entry->clock_in)->format('Y-m-d H:i:s'),
                    'clock_out' => $entry->clock_out ? Carbon::parse($entry->clock_out)->format('Y-m-d H:i:s') : null,
                    'duration' => $entry->clock_out ?
                        $this->formatDuration($entry->clock_in, $entry->clock_out) : 'N/A',
                ];
            });
    }

    public function getUsersWhoWorkedOnDate($date)
    {
        return TimeEntry::whereDate('clock_in', $date)
            ->distinct()
            ->pluck('user_id'); // Get unique user IDs
    }

    public function getUserWorkSummaryForCurrentMonth($userId)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return $this->getMonthlyHoursSummary($userId, $currentMonth, $currentYear);
    }

    public function deleteTimeEntry($entryId)
    {
        return TimeEntry::destroy($entryId); // Deletes the entry with the specified ID
    }

    private function formatDuration($clockIn, $clockOut)
    {
        $durationSeconds = Carbon::parse($clockIn)->diffInSeconds(Carbon::parse($clockOut));
        return $this->formatDurationFromSeconds($durationSeconds);
    }

    private function formatDurationFromSeconds($totalSeconds)
    {
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
