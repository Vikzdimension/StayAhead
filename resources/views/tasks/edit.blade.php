<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <form method="POST" action="{{ route('tasks.update', $task) }}" class="p-6">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Task Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title', $task->title) }}" required autofocus/>
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select name="status" id="status" class="mt-1 block w-full">
                            <option value="0" {{ $task->status == 0 ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $task->status == 1 ? 'selected' : '' }}>Completed</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="priority" :value="__('Priority')" />
                        <select name="priority" id="priority" class="mt-1 block w-full">
                            <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('priority')" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="due_date" :value="__('Due Date')" />
                        <x-text-input
                            id="due_date"
                            name="due_date"
                            type="date"
                            class="mt-1 block w-full"
                            value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A') }}"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
                    </div>
                    
                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Update Task') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
