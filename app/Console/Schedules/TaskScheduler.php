<?php

namespace App\Console\Schedules;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\NotifyUsersAboutDueTasks;

class TaskScheduler
{
    /**
     * Register the task schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function register(Schedule $schedule)
    {
        $schedule->command('app:notify-users-about-due-tasks')->daily();
    }
}