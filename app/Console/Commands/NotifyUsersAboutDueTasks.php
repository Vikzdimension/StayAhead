<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use App\Jobs\NotifyUserAboutTaskDueDate;

class NotifyUsersAboutDueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-users-about-due-tasks';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users about tasks that are due in two days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('due_date', '=', now()->addDays(2)->toDateString())
                     ->where('status', 1)
                     ->get();

        foreach ($tasks as $task) {
            NotifyUserAboutTaskDueDate::dispatch($task);
        }

        $this->info('Notifications dispatched for due tasks.');
    }
}