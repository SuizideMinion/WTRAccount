<?php

namespace Modules\TimeManagment\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use http\Env\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\TimeManagment\Entities\TimeTracking;

class StatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $Times = TimeTracking::where('user_id', auth()->user()->id)->get();
        $user = User::whereId(auth()->user()->id)->first();
        $userData = UserData::where('user_id', auth()->user()->id)->get()->pluck('value', 'key');
        $userDatasUrlaubstage = UserData::where('user_id', auth()->user()->id)->where('key', 'like', 'urlaubstage.%')->sum('value');

        return view('timemanagment::statistik.index', compact('Times', 'user', 'userDatasUrlaubstage', 'userData'));
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
        $tt = new TimeTracking;

        $tt->user_id = $request->user_id;
        $tt->stamped = $request->day;
        $tt->stamped_out = $request->day + $request->time;
        $tt->status = $request->status;
        $tt->time_worked = $request->time;

        $tt->save();

        return response()->json($tt);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $Times = TimeTracking::where('user_id', $id)->get();
        $userData = UserData::where('user_id', $id)->get()->pluck('value', 'key');
        $userDatasUrlaubstage = UserData::where('user_id', $id)->where('key', 'like', 'urlaubstage.%')->sum('value');
        $user = User::whereId($id)->first();

//        dd($user->userDataLike('urlaubstage.%'));

        return view('timemanagment::statistik.index', compact('id', 'user', 'Times', 'userDatasUrlaubstage', 'userData'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if(!isset($_GET['set'])) return redirect()->back();
        if(!isset($_GET['time'])) return redirect()->back();

        $tt = new TimeTracking;

//        $tt->stamped = strtotime(date('Y-m-d', time() - ( 86400 * $i )) . ' 00:00:00')

//        return view('timemanagment::edit');
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
