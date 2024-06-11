<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request()->routeIs('notes.index') ? __('Notes') : __('Trash') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-alert-success>
                {{ session('success') }}
            </x-alert-success>

            @if(request()->routeIs('note.index'))
                <a href="{{ route('notes.create') }}" class="btn-link btn-lg mb-2">+ New Note</a>
            @endif

            @forelse ($notes as $note)
                <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                    <h2 class="font-bold text-2xl">
                        <?php /*<a href="{{ route('notes.show', $note->uuid) }}">{{ $note->title }}</a>*/ ?>

                        @if(request()->routeIs('note.index'))
                            <a href="{{ route('notes.show', $note) }}">{{ $note->title }}</a>
                        @else
                            <a href="{{ route('trashed.show', $note) }}">{{ $note->title }}</a>
                        @endif
                    </h2>

                    <p class="mt-2">
                        <!-- Str::limit is a helper function that limits the number of characters displayed -->
                        {{ Str::limit($note->text, 200) }}
                    </p>

                    <!-- carbon is a package that helps with dates -->
                    <span class="block mt-4 text-sm opacity-70"> {{ $note->updated_at->diffForHumans() }}</span>
                </div>
            @empty
                <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                    @if(request()->routeIs('note.index'))
                        <p class="text-lg">No notes yet. Create one now!</p>
                    @else
                        <p class="text-lg">No items in the Trash!</p>
                    @endif
                </div>
            @endforelse

            {{ $notes->links() }}

        </div>
    </div>
</x-app-layout>
