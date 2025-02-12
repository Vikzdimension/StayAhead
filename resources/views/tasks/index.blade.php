<!-- resources/views/tasks/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">All Tasks</h1>
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Create New Task</a>
        </div>
        
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $task->title }}</td>
                            <td class="px-4 py-2">{{ $task->status ? 'Completed' : 'Pending' }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('tasks.edit', $task) }}" class="px-2 py-1 text-blue-600">Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 text-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
