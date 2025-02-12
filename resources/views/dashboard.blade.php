<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center space-x-4">
                <form id="search-form" method="GET" action="{{ route('dashboard') }}" class="flex space-x-4 w-full">
                    <div class="w-1/4">
                        <x-input-label for="search" :value="__('Search by Title')" />
                        <x-text-input id="search" name="search" class="mt-1 block w-full"
                            placeholder="Search tasks..." value="{{ request('search') }}" />
                    </div>

                    <div class="w-1/4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select name="status" id="status" class="mt-1 block w-full">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Completed</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <x-primary-button type="submit">{{ __('Search') }}</x-primary-button>
                    </div>
                </form>

                <a href="{{ route('tasks.create') }}">
                    <x-primary-button class="w-32 pt-2 mt-8">{{ __('Create Task') }}</x-primary-button>
                </a>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Priority</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Due Date</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr class="border-t hover:bg-gray-100 transition duration-300">
                                <td class="px-4 py-2 text-sm">{{ $task->title }}</td>
                                <td class="px-4 py-2 text-sm">{{ $task->status ? 'Completed' : 'Pending' }}</td>
                                <td class="px-4 py-2 text-sm">{{ ucfirst($task->priority) }}</td>
                                <td class="px-4 py-2 text-sm">
                                    {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('tasks.edit', $task) }}"
                                        class="px-2 py-1 text-blue-600 hover:text-blue-800">
                                        <x-primary-button>{{ __('Edit') }}</x-primary-button>
                                    </a>

                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-primary-button type="submit"
                                            class="bg-red-600 hover:bg-red-700">{{ __('Delete') }}</x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-4">
                    {{ $tasks->links() }}
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
