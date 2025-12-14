<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Note;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return Inertia::render('NotesIndex', ['notes' => $notes]);
    }

    public function show(Note $note)
    {
        $this->authorizeNote($note);
        return Inertia::render('NoteDetail', ['note' => $note]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'nullable|string',
        ]);

        Note::create([
            'user_id' => auth()->id(),
            'titre' => $request->titre,
            'contenu' => $request->contenu,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Note $note)
    {
        $this->authorizeNote($note);
        $note->update($request->only('titre', 'contenu'));
        return redirect()->back();
    }

    private function authorizeNote(Note $note)
    {
        if ($note->user_id !== auth()->id()) abort(403);
    }
}
