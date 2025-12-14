<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return Inertia::render('tasks/TasksIndex', [
            'tasks' => $tasks,
        ]);
    }

    public function show(Task $task)
    {
        $this->authorizeTask($task);
        return Inertia::render('tasks/TaskDetail', [
            'task' => $task,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Task::create([
            'user_id' => auth()->id(),
            'titre' => $request->titre,
            'description' => $request->description,
            'est_terminee' => false,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $task->update($request->only('titre', 'description', 'est_terminee'));
        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();
        return redirect()->back();
    }

    // Option simple pour sécuriser l'accès
    private function authorizeTask(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
