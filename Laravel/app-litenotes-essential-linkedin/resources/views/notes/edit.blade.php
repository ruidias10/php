<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                <form action="{{ route('notes.update', $note) }}" method="post">
                    @method('put')
                    @csrf
                    <x-input :value="@old('title', $note->title)" type="text" name="title" field="title" placeholder="Title" class="w-full" autocomplete="off"></x-input>

                    <x-textarea :value="@old('text', $note->text)" name="text" field="text" rows="10" placeholder="Text" class="w-full mt-6"></x-textarea>

                    <x-button class="mt-6">Save Note</x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
