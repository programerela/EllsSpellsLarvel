<x-app-layout>
    <div class="flex items-center justify-between w-full">
        <h2 class="text-3xl font-medium my-6"></h2>

        @can('create', App\Models\Theme::class)
        <x-link-button class="text-base" :href="route('theme.create')">
            Create a new theme
        </x-link-button>
        @endcan
    </div>

    @foreach ($themes->sortByDesc('updated_at') as $theme)
    <x-theme-card class="mb-4" :$theme>
        <x-link-button :href="route('theme.show', $theme)">
            Show conversations from this theme
        </x-link-button>
    </x-theme-card>
    @endforeach
</x-app-layout>