<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Button to Create a New Task -->
            <div class="mb-6 text-right">
                <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create New Task</a>
            </div>

            <!-- Task List -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Priority</th>
                            <th class="px-4 py-2 text-left">Due Date</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $task->title }}</td>
                                <td class="px-4 py-2">{{ $task->status ? 'Completed' : 'Pending' }}</td>
                                <td class="px-4 py-2">{{ ucfirst($task->priority) }}</td>
                                <td class="px-4 py-2">{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}</td>                                
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

                <!-- Pagination Links -->
                <div class="px-6 py-4">
                    {{ $tasks->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
