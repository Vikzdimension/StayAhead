<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        $tasksQuery = auth()->user()->tasks();
    
        if ($request->has('search') && $request->search !== '') {
            $tasksQuery->where('title', 'like', '%' . $request->search . '%');
        }
    
        if ($request->has('status') && in_array($request->status, ['0', '1'])) {
            $tasksQuery->where('status', $request->status);
        }
    
        $cacheKey = 'tasks_' . auth()->id() . '_search_' . md5($request->get('search', '')) . '_status_' . md5($request->get('status', ''));
    
        if ($request->wantsJson()) {
            $tasks = $tasksQuery->paginate(10);
            return response()->json($tasks);
        }
    
        $tasks = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($tasksQuery) {
            return $tasksQuery->paginate(10);
        });
    
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
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after_or_equal:' . now()->toDateString(),
        ]);
    
        $task = auth()->user()->tasks()->create([
            'title' => $request->title,
            'status' => $request->status,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ]);
    
        $cacheKey = 'tasks_' . auth()->id() . 
                    '_search_' . md5($request->get('search', '')) . 
                    '_status_' . md5($request->get('status', ''));
    
        Cache::forget($cacheKey);
    
        return redirect()
            ->route('dashboard', [
                'search' => $request->search, 
                'status' => $request->status
            ])
            ->with('success', 'Task created successfully.');
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
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after_or_equal:' . now()->toDateString(),
        ]);
    
        $this->authorize('update', $task);
    
        $task->update($validated);
    
        $cacheKey = 'tasks_' . auth()->id() . 
                    '_search_' . md5($request->get('search', '')) . 
                    '_status_' . md5($request->get('status', ''));
    
        Cache::forget($cacheKey);
    
        return redirect()
            ->route('dashboard', [
                'search' => $request->search, 
                'status' => $request->status
            ])
            ->with('success', 'Task updated successfully!');
    }
    

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
    
        $cacheKey = 'tasks_' . auth()->id() . 
                    '_search_' . md5(request('search', '')) . 
                    '_status_' . md5(request('status', ''));
    
        Cache::forget($cacheKey);
    
        return redirect()
            ->route('dashboard', [
                'search' => request('search'),
                'status' => request('status'),
            ])
            ->with('success', 'Task deleted successfully.')
            ->with('delete', true);
    }
    
    
}