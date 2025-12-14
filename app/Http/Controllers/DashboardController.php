<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Idea;
use App\Models\Note;
use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $userId = auth()->id();

        // Tâches
        $totalTasks = Task::where('user_id', $userId)->count();
        $completedTasks = Task::where('user_id', $userId)->where('est_terminee', true)->count();
        $pendingTasks = $totalTasks - $completedTasks;

        // Idées : nombre par jour sur les 7 derniers jours
        $ideasPerDay = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $ideasPerDay[$date->format('Y-m-d')] = Idea::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->count();
        }

        // Notes : nombre par jour sur les 7 derniers jours
        $notesPerDay = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $notesPerDay[$date->format('Y-m-d')] = Note::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->count();
        }

        return Inertia::render('Dash', [
            'kpi' => [
                'tasks' => [
                    'total' => $totalTasks,
                    'completed' => $completedTasks,
                    'pending' => $pendingTasks,
                    'completionRate' => $totalTasks ? round(($completedTasks / $totalTasks) * 100, 2) : 0,
                ],
                'ideas' => [
                    'total' => array_sum($ideasPerDay),
                    'perDay' => $ideasPerDay,
                ],
                'notes' => [
                    'total' => array_sum($notesPerDay),
                    'perDay' => $notesPerDay,
                ],
            ],
        ]);
    }
}
