<!-- resources/views/tasks/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Task Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select name="status" id="status" class="mt-1 block w-full" required>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Create Task') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
