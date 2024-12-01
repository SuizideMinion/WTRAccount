<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\TimeManagment\Entities\TimeTracking;

class HolidayController extends Controller
{
    public function store(Request $request)
    {
        $time = strtotime($request->date) + 3600;
//        dd($request->date, $time);
        $Users = User::with('userDataRelation')->get();

        foreach($Users as $User) {
            $timeWorked = (($User->userDataRelation->pluck('value', 'key')['holidayStunden'] ?? 8) * 60) * 60;
            $stampedOut = $time + $timeWorked;

            if (env('APP_DEBUG', false)) {
                // Simulieren und ausgeben
                Log::info('Simulierte Eintragung für User:', [
                    'user_id' => $User->id,
                    'stamped' => $time,
                    'stamped_out' => $stampedOut,
                    'time_worked' => $timeWorked,
                    'status' => '2'
                ]);
            } else {
                // Tatsächliche Eintragung
                TimeTracking::create([
                    'user_id' => $User->id,
                    'stamped' => $time,
                    'stamped_out' => $stampedOut,
                    'time_worked' => $timeWorked,
                    'status' => '2'
                ]);
            }
        }
    }
}
