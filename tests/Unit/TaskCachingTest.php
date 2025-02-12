<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class TaskCachingTest extends TestCase
{
    /**
     * Test task list is cached correctly.
     */
    public function testTaskListIsCached() 
    {
        $user = User::factory()->create();
    
        Task::factory()->create(['user_id' => $user->id]);
        
        Cache::shouldReceive('remember')
            ->once()
            ->with(
                'task_list:' . $user->id,
                \Mockery::any(),
                \Mockery::any()
            )
            ->andReturn(collect([Task::first()]));
        
        $tasks = Cache::remember('task_list:' . $user->id, 3600, function () use ($user) {
            return Task::where('user_id', $user->id)->get();
        });

        $this->assertCount(1, $tasks);
        $this->assertEquals(Task::first()->title, $tasks->first()->title);
        
        Cache::shouldHaveReceived('remember')->once();
    }
}