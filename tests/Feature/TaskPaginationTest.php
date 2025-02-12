<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskPaginationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_tasks_are_paginated()
    {
        $user = User::factory()->create();
    
        Task::factory()->count(15)->create(['user_id' => $user->id]);
    
        $response = $this->actingAs($user)->get(route('dashboard'));
    
        $response->assertSee('Next');
        $response->assertStatus(200);
    }
    
}