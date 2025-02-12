<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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

            <!-- Button to Create a New Task -->
            <div class="flex justify-end">
                <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Create a New Task</a>
            </div>

        </div>
    </div>
</x-app-layout>
