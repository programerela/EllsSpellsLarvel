<x-app-layout>
    @if ($discussions->isEmpty())
    <p class="text-lg font-semibold mt-4">You didn't create a discussion yet.</p>
    @else
    <x-card class="mb-4">
        {{-- <h2 class="mb-10 mt-2 text-xl font-medium">
            Discussions about {{ $discussions->first()->theme->name }}
        </h2> --}}

        @foreach ($discussions->sortByDesc('updated_at') as $discussion)
        <x-discussion-card class="mb-4" :$discussion>
            <x-link-button :href="route('discussion.show', $discussion)">
                Show discussion
            </x-link-button>
        </x-discussion-card>
        @endforeach
    </x-card>
    @endif
</x-app-layout>