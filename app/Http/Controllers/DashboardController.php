<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\TimeManagment\Entities\RequestTimeChance;
use Modules\TimeManagment\Entities\TimeTracking;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ( !can('timeChanceAccept') ) return redirect()->route('timemanagment.index');

        $lastWorkings = TimeTracking::with('user')->orderBy('stamped', 'DESC')->get();
        $requestChance = RequestTimeChance::with('time')->orderBy('created_at', 'DESC')->get();

        $labels = [
            0 => '',
            1 => '',
            2 => 'FEIERTAG',
            3 => 'URLAUB',
            4 => 'KRANK',
            5 => 'UB Abbau',
        ];

        return view('dashboard', compact('lastWorkings', 'requestChance', 'labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
