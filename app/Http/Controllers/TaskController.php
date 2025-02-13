<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
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

        if ($request->get('status', 'all') !== 'all') {
            $tasksQuery->where('status', $request->status);
        }

        $cacheKey = $this->generateCacheKey($request);

        if ($request->wantsJson()) {
            return response()->json($tasksQuery->paginate(10));
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
        $this->validateTask($request);
    
        $task = auth()->user()->tasks()->create([
            'title' => $request->title,
            'status' => $request->status,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ]);
    
        $this->clearRelevantCacheKeys($request);
    
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
        $this->validateTask($request);
    
        $this->authorize('update', $task);
    
        $task->update($request->only(['title', 'status', 'priority', 'due_date']));
    
        $this->clearRelevantCacheKeys($request);
    
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
    
        $this->clearRelevantCacheKeys(request());
    
        return redirect()
            ->route('dashboard', [
                'search' => request('search'),
                'status' => request('status'),
            ])
            ->with('success', 'Task deleted successfully.')
            ->with('delete', true);
    }
    
    /**
     * Generate cache key based on request parameters.
     */
    protected function generateCacheKey(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search', '');

        return 'tasks_' . auth()->id() .
               '_search_' . md5($search) .
               '_status_' . $status;
    }

    /**
     * Clear relevant cache keys based on request parameters.
     */
    protected function clearRelevantCacheKeys(Request $request)
    {
        $statuses = ['0', '1', 'all'];
        $search = $request->get('search', '');

        foreach ($statuses as $status) {
            $cacheKey = 'tasks_' . auth()->id() .
                        '_search_' . md5($search) .
                        '_status_' . $status;
            Cache::forget($cacheKey);
        }
    }

    /**
     * Validate task data for store and update.
     */
    protected function validateTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|boolean',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after_or_equal:' . now()->toDateString(),
        ]);
    }
}