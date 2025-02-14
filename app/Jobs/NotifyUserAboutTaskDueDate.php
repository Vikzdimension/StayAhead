<?php

namespace App\Jobs;

use App\Models\Task;
use App\Mail\TaskDueDateNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserAboutTaskDueDate implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    
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
        Mail::to($this->task->user->email)
            ->send(new TaskDueDateNotification($this->task));
        
        Log::info('Notification dispatched for task due in 2 days: Task ID ' . $this->task->id);
    }

    public function getTask()
    {
        return $this->task;
    }
}