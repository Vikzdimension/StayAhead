<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task()
    {
        $user = User::factory()->create();

        $taskData = [
            'title' => 'New Task',
            'status' => 1,
            'priority' => 'medium',
            'due_date' => '2025-12-01',
        ];

        $response = $this->actingAs($user)->post(route('tasks.store'), $taskData);

        $this->assertDatabaseHas('tasks', $taskData);
        $response->assertRedirect(route('dashboard'));
    }

    public function test_can_update_task()
    {
        $user = User::factory()->create();

        $task = Task::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'title' => 'Updated Task Title',
            'status' => 0,
            'priority' => 'high',
            'due_date' => '2025-11-01',
        ];

        $response = $this->actingAs($user)->put(route('tasks.update', $task), $updatedData);

        $this->assertDatabaseHas('tasks', $updatedData);
        $response->assertRedirect(route('dashboard'));
    }

    public function test_can_delete_task()
    {
        $user = User::factory()->create();

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $response->assertRedirect(route('dashboard'));
    }
}