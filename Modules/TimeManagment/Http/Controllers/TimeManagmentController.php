<?php

namespace Modules\TimeManagment\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\TimeManagment\Entities\TimeTracking;

class TimeManagmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $activeTime = TimeTracking::where('user_id', auth()->user()->id)->where('stamped_out', 0)->first();

        $lastWorkings = TimeTracking::where('user_id', auth()->user()->id)->where('stamped_out', '>', 0)->orderBy('created_at', 'DESC')->take(20)->get();
//        dd($lastWorkings);
        return view('timemanagment::index', compact('activeTime', 'lastWorkings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('timemanagment::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ( $request->stamped_in == 1 )
        {
            $Time = new TimeTracking;
            $Time->user_id = $request->user_id;
            $Time->stamped = round(time() / 60) * 60 + 3600;
            $Time->stamped_out = 0;
            $Time->time_worked = 0;

            $Time->save();
        } else {
            $Time = TimeTracking::where('user_id', $request->user_id)->orderBy('created_at', 'DESC')->first();

            $Time->stamped_out = round(time() / 60) * 60 + 3600;
            $Time->time_worked = round(time() / 60) * 60 + 3600 - $Time->stamped;

            $Time->save();
        }

        return Redirect::back();

        dd($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $user = User::whereId($id)->first();
        $activeTime = TimeTracking::where('user_id', $id)->where('stamped_out', 0)->first();

        $lastWorkings = TimeTracking::where('user_id', $id)->where('stamped_out', '>', 0)->orderBy('created_at', 'DESC')->take(20)->get();
//        dd($lastWorkings);
        return view('timemanagment::index', compact('activeTime', 'lastWorkings', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('timemanagment::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
