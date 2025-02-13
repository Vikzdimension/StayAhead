<?php

use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskDueDateNotification;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', [TaskController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tasks', TaskController::class);
});

Route::get('/test-email', function () {
    $task = new Task();
    $task->title = 'Test Task';
    $task->due_date = now()->addDays(2);
    $task->status = '0';

    Mail::to('recipient@example.com')->send(new TaskDueDateNotification($task));

    return 'Test email sent!';
});

require __DIR__.'/auth.php';