<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index()
    {
        $tasks = auth()->user()->tasks()->paginate(10);

        return view('dashboard', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        auth()->user()->tasks()->create([
            'title' => $request->title,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $this->authorize('update', $task);

        $task->update($validated);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    }
    
    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully.');
    }
}