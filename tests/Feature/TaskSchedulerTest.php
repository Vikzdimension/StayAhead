<?php

namespace Tests\Feature;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskSchedulerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the scheduler schedules the notify-users-about-due-tasks command.
     */
    public function test_scheduler_schedules_notify_users_about_due_tasks_command()
    {
        $schedule = $this->app->make(Schedule::class);

        $found = false;
        foreach ($schedule->events() as $event) {
            if (strpos($event->command, 'app:notify-users-about-due-tasks') !== false) {
                $found = true;
                break;
            }
        }

        $this->assertTrue($found, 'The command app:notify-users-about-due-tasks was not scheduled to run daily.');
    }
}