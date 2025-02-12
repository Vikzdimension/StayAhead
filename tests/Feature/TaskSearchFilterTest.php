<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskSearchFilterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_search_and_filter_tasks()
    {
        $user = User::factory()->create();
    
        Task::factory()->create(['user_id' => $user->id, 'title' => 'Task One']);
        Task::factory()->create(['user_id' => $user->id, 'title' => 'Task Two']);
    
        $response = $this->actingAs($user)->get(route('dashboard', ['search' => 'Task One']));
    
        $response->assertSee('Task One');
        $response->assertDontSee('Task Two');
        $response->assertStatus(200);
    }
    
    public function test_can_filter_tasks_by_status()
    {
        $user = User::factory()->create();
        
        $task1 = Task::factory()->create(['user_id' => $user->id, 'status' => 0]);
        $task2 = Task::factory()->create(['user_id' => $user->id, 'status' => 1]);
        
        $response = $this->actingAs($user)->getJson(route('tasks.index', ['status' => 1]));
        
        $response->assertStatus(200);

    }
    
    
    
}