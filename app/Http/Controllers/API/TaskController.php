<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les tasks
        $task = Task::with([
            'user' => fn (Relation $query) => $query->select(User::$VISIBLE)
        ]);
        $task = Task::paginate(10);

        // On retourne les informations des utilisateurs en JSON
        return $task;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'title' => 'required'
        ]);

        $task = Task::create([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'title' => $request->title
        ]);

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // La validation de données
        $this->validate($request, [
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'title' => 'required'
        ]);

        // On modifie les informations de l'utilisateur
        $task->update([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'title' => $request->title
        ]);

        // On retourne la réponse JSON
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json();
    }
}
