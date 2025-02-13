<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div id="flash-message"
                    class="mb-4 p-4 @if (session('delete')) bg-red-200 border border-red-400 text-red-700 @else bg-green-200 border border-green-400 text-green-700 @endif rounded-md shadow-lg transition-opacity opacity-100"
                    role="alert" aria-live="assertive" aria-atomic="true" aria-hidden="false">
                    <div class="flex justify-between items-center">
                        <p>{{ session('success') }}</p>
                        <button id="close-btn" class="text-xl ml-4 text-gray-500 hover:text-gray-700"
                            aria-label="Close notification">&times;</button>
                    </div>
                </div>
            @endif

            <div class="mb-6 flex items-center justify-between space-x-4">
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
                        <x-primary-button type="submit" id="search-btn" class="w-full md:w-auto">
                            <span id="search-spinner" class="hidden mr-2 spinner"></span>{{ __('Search') }}
                        </x-primary-button>
                    </div>
                </form>

                <a href="{{ route('tasks.create') }}"
                    class="inline-flex items-center mt-7 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <button type="submit" class="leading-normal w-28 h-8">{{ __('Create Task') }}</button>
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
                    {{ $tasks->appends(request()->except('page'))->links() }}
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const flashMessage = document.getElementById('flash-message');
            const closeButton = document.getElementById('close-btn');

            if (flashMessage) {
                console.log('Flash message found, fading out in 2 seconds');
                setTimeout(() => {
                    flashMessage.style.transition =
                        'opacity 0.7s ease-out, filter 0.7s ease-out';
                    flashMessage.style.opacity = '0';
                    flashMessage.style.filter = 'blur(3px)';
                    setTimeout(() => flashMessage.style.display = 'none', 500);
                    console.log('Flash message faded out and blurred');
                }, 2000);
            }

            if (closeButton) {
                console.log('Close button found');
                closeButton.addEventListener('click', () => {
                    if (flashMessage) {
                        console.log('Manually closing flash message');
                        flashMessage.style.transition =
                            'opacity 0.7s ease-out, filter 0.7s ease-out';
                        flashMessage.style.opacity = '0';
                        flashMessage.style.filter = 'blur(3px)';
                        setTimeout(() => flashMessage.style.display = 'none', 500);
                    }
                });
            }

            const searchForm = document.getElementById('search-form');
            const searchButton = document.getElementById('search-btn');
            const searchSpinner = document.getElementById('search-spinner');

            if (searchForm && searchButton && searchSpinner) {
                searchForm.addEventListener('submit', function() {
                    searchButton.disabled = true;
                    searchSpinner.classList.remove('hidden');
                    console.log('Search initiated...');
                });
            }
        });
    </script>
</x-app-layout>
