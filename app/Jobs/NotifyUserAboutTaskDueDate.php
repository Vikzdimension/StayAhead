<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NotifyUserAboutTaskDueDate implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tasks = Task::where('due_date', '=', now()->addDays(2)->toDateString())
            ->where('status', '!=', 'completed')
            ->get();

        foreach ($tasks as $task) {
            NotifyUserAboutTaskDueDate::dispatch($task);
        }

        Log::info('Notifications dispatched for tasks due in 2 days.');
    }
}