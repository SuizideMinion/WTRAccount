<?php

namespace Modules\Notepad\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Notepad\Entities\Notepad;

class NotepadController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $Notes = Notepad::where('user_id', auth()->user()->id)->get();

        return view('notepad::index', compact('Notes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('notepad::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $notiz = new Notepad;
        $notiz->user_id = auth()->user()->id;
        $notiz->title = $request->title;
        $notiz->text = $request->text;

        $notiz->save();

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $Notiz = Notepad::whereId($id)->first();

        return view('notepad::show', compact('Notiz'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $Notiz = Notepad::whereId($id)->first();

        return view('notepad::edit', compact('Notiz'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $Notiz = Notepad::whereId($id)->first();

        $Notiz->title = $request->title;
        $Notiz->text = $request->text;

        $Notiz->save();

        return redirect()->route('notepad.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Notepad::whereId($id)->delete();

        return redirect()->back();
    }
}
