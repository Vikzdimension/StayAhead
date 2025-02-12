<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Task Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $task->title }}" required />
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

                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Update Task') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
