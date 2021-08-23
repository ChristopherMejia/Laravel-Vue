<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Notes/Index', [
            'notes' => Note::latest()
            ->where('excerpt', 'LIKE', "%$request->q%")
            ->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Notes/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'excerpt' => 'required',
            'description' =>'required',
        ]);

        $note = Note::create($request->all());
        return redirect()->route('notes.edit', $note->id)->with('status', 'Nota Creada');


    }
    public function show(Note $note)
    {
        return Inertia::render('Notes/Show', compact('note'));
    }

    public function edit(Note $note)
    {
        return Inertia::render('Notes/Edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'excerpt' => 'required',
            'description' =>'required',
        ]);
        $note->update($request->all());
        return redirect()->route('notes.index')->with('status', 'Nota Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('notes.index')->with('status', 'Nota eliminada');
    }
}
