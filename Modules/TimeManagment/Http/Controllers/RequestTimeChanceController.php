<?php

namespace Modules\TimeManagment\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\TimeManagment\Entities\RequestTimeChance;
use Modules\TimeManagment\Entities\TimeTracking;

class RequestTimeChanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('timemanagment::index');
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
//        dd($request);
        $toDel = RequestTimeChance::where('time_id', $request->time_id)->delete();
        $time = TimeTracking::where('id', $request->time_id)->first();

        $time->stamped = $request->stamped;
        $time->user_id = $request->user_id;
        $time->stamped_out = $request->stamped_out;
        $time->time_worked = $request->stamped_out - $request->stamped;

        $time->save();

        return redirect()->back()->withErrors('Erfolgreich Geändert');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $time = TimeTracking::with('user')->where('id', $id)->first();

        $users = User::get();

        $timeChances = RequestTimeChance::where('time_id', $id)->get();

        return view('timemanagment::requesttimechance.show', compact('time', 'timeChances', 'users'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $stamped = mktime(
                (int)explode(':', $request->stamped)[0],
                (int)explode(':', $request->stamped)[1],
                (int)(explode(':', $request->stamped)[2] ?? 00),
                (int)explode('.', $request->stamped_date)[1],
                (int)explode('.', $request->stamped_date)[0],
                (int)explode('.', $request->stamped_date)[2]
            ) + 3600;
        $stamped_out = mktime(
                (int)explode(':', $request->stamped_out)[0],
                (int)explode(':', $request->stamped_out)[1],
                (int)(explode(':', $request->stamped_out)[2] ?? 00),
                (int)explode('.', $request->stamped_out_date)[1],
                (int)explode('.', $request->stamped_out_date)[0],
                (int)explode('.', $request->stamped_out_date)[2]
            ) + 3600;

        $time = new RequestTimeChance;
        $time->user_id = $request->user_id;
        $time->time_id = $id;
        $time->stamped = $stamped;
        $time->stamped_out = $stamped_out;

        $time->save();

        return redirect()->back()->withErrors('Wurde zum überprüfen Gesendet');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $timeChance = RequestTimeChance::findOrFail($id);
        dd($id, $timeChance);
        $timeChance->delete();

        return redirect()->back()->withErrors('Eintrag erfolgreich gelöscht');
    }
}
