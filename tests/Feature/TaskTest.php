<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to create a task.
     */
    public function test_can_create_task()
    {
        $user = User::factory()->create();
        $taskData = [
            'title' => 'New Task',
            'status' => 1,
            'priority' => 'high',
            'due_date' => now()->addDays(1)->toDateString(),
        ];

        $response = $this->actingAs($user)->post(route('tasks.store'), $taskData);

        $this->assertDatabaseHas('tasks', $taskData);
        $response->assertRedirect(route('dashboard', [
            'status' => 1,
        ]));
    }

    /**
     * Test to update a task.
     */
    public function test_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['status' => 0]);

        $updatedData = [
            'title' => 'Updated Task',
            'status' => 0,
            'priority' => 'medium',
            'due_date' => now()->addDays(2)->toDateString(),
        ];

        $response = $this->actingAs($user)->put(route('tasks.update', $task), $updatedData);

        $this->assertDatabaseHas('tasks', $updatedData);
        $response->assertRedirect(route('dashboard', [
            'status' => 0,
        ]));
    }

    /**
     * Test to delete a task.
     */
    public function test_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $response->assertRedirect(route('dashboard'));
    }
}