<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Inertia\Inertia;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index()
    {
        $ideas = Idea::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return Inertia::render('ideas/IdeasIndex', ['ideas' => $ideas]);
    }

    public function show(Idea $idea)
    {
        $this->authorizeIdea($idea);
        return Inertia::render('ideas/IdeaDetail', ['idea' => $idea]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Idea::create([
            'user_id' => auth()->id(),
            'titre' => $request->titre,
            'description' => $request->description,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Idea $idea)
    {
        $this->authorizeIdea($idea);
        $idea->update($request->only('titre', 'description'));
        return redirect()->back();
    }

    private function authorizeIdea(Idea $idea)
    {
        if ($idea->user_id !== auth()->id()) abort(403);
    }
}
