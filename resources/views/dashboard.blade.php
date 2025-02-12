<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Button to Create a New Task -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('tasks.create') }}" class="inline-block px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                    Create a New Task
                </a>
            </div>

            <!-- Display Tasks -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-800">All Tasks</h3>
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
                            @forelse ($tasks as $task)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $task->title }}</td>
                                    <td class="px-4 py-2">{{ $task->status ? 'Completed' : 'Pending' }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <!-- Edit Button with border and hover effects -->
                                        <a href="{{ route('tasks.edit', $task) }}" class="px-3 py-1 border border-blue-500 text-blue-600 rounded-md hover:bg-blue-100 transition-colors duration-200 ease-in-out">
                                            Edit
                                        </a>

                                        <!-- Delete Button with border and hover effects -->
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 border border-red-500 text-red-600 rounded-md hover:bg-red-100 transition-colors duration-200 ease-in-out">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-center text-gray-600">No tasks found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
