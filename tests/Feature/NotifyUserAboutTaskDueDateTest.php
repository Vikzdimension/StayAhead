<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\NotifyUserAboutTaskDueDate;
use App\Models\Task;
use App\Models\User; // Add User model
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotifyUserAboutTaskDueDateTest extends TestCase
{
    use RefreshDatabase;

    public function test_to_dispatches_notifications_for_due_tasks()
    {
        $user = User::factory()->create();

        $task = Task::create([
            'title' => 'Test Task',
            'due_date' => now()->addDays(2),
            'status' => 1,
            'user_id' => $user->id,
        ]);

        Queue::fake();

        NotifyUserAboutTaskDueDate::dispatch($task);

        Queue::assertPushed(NotifyUserAboutTaskDueDate::class, function ($job) use ($task) {
            return $job->getTask()->id === $task->id;
        });
    }
}