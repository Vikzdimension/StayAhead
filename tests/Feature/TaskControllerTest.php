<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);

        Session::start();
    }
        
    /**
     * Test to check if tasks can be filtered by title.
     */
    public function test_can_search_tasks_by_title()
    {
        $user = User::factory()->create();
    
        Task::factory()->create(['user_id' => $user->id, 'title' => 'Buy groceries']);
        Task::factory()->create(['user_id' => $user->id, 'title' => 'Complete homework']);
    
        $response = $this->actingAs($user)->get(route('dashboard', ['search' => 'Buy groceries']));
    
        $response->assertStatus(200)
                 ->assertSee('Buy groceries')
                 ->assertDontSee('Complete homework');
    }

    /**
     * Test to check if tasks can be filtered by status.
     */
    public function test_can_filter_tasks_by_status()
    {
        $user = User::factory()->create();
    
        $task1 = Task::factory()->create(['user_id' => $user->id, 'status' => 0, 'title' => 'Task with status 0']);
        $task2 = Task::factory()->create(['user_id' => $user->id, 'status' => 1, 'title' => 'Complete homework']);
        $task3 = Task::factory()->create(['user_id' => $user->id, 'status' => 1, 'title' => 'Buy groceries']);
    
        $response = $this->actingAs($user)->get(route('dashboard', ['status' => 1]));
    
        $response->assertStatus(200)
                 ->assertSeeText($task2->title)
                 ->assertSeeText($task3->title)
                 ->assertDontSeeText($task1->title);
    }

    /**
     * Test to check pagination when there are many tasks.
     */
    public function test_tasks_are_paginated()
    {
        $user = User::factory()->create();
    
        $tasks = Task::factory()->count(25)->create(['user_id' => $user->id]);
    
        $response = $this->actingAs($user)->get(route('dashboard'));
    
        $response->assertStatus(200);
    
        $response->assertSeeText($tasks[0]->title) 
                 ->assertSeeText($tasks[9]->title)
                 ->assertDontSeeText($tasks[10]->title);
    
        $response->assertSee('Next &raquo;');
    }

    /**
     * Test if tasks are cached.
     */
    public function test_tasks_are_cached()
    {
        $user = User::factory()->create();
        $tasks = Task::factory()->count(2)->create(['user_id' => $user->id]);

        $cacheKey = 'tasks_' . $user->id . '_search_' . md5('') . '_status_all';

        $cc = Cache::shouldReceive('remember')
             ->once()
             ->with($cacheKey, Mockery::any(), Mockery::any())
             ->andReturn(collect($tasks));

        $response = $this->actingAs(user: $user)->get(route('dashboard'));
        $response->assertSeeText($tasks[0]->title);
        $response->assertSeeText($tasks[1]->title);
    
        Cache::shouldHaveReceived('remember')->once();
    }
}