<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Learning;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Récupère les apprentissages de l'utilisateur, triés par prochaine révision
        $learnings = auth()->user()->learnings()
            ->orderBy('next_review_at', 'asc') // Les apprentissages à réviser en premier
            ->get();

        return Inertia::render('learning/Index', [
            'learnings' => $learnings,
        ]);
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
     // 1. Validation Professionnelle et Sécurisée
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:10000'],
            'source_url' => ['nullable', 'url', 'max:2048'],
            'topic' => ['nullable', 'string', 'max:100'],
        ]);

        // 2. Création de l'enregistrement
        Learning::create([
            'user_id' => auth()->id(),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'source_url' => $request->input('source_url'),
            'topic' => $request->input('topic'),
            
            // Initialisation du système de révision
            'last_reviewed_at' => now(), 
            'next_review_at' => now()->addDays(1), // Ex: Première révision le lendemain
        ]);
        
        // 3. Réponse Inertia (Redirection vers la liste)
        return redirect()->route('learnings.index')->with('success', 'Connaissance enregistrée!');
    }
  

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
