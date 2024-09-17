<x-app-layout>
    <x-card>
        <div class="flex items-center justify-center">
            <h1 class="text-2xl font-bold text-black ">{{ $post->title }}</h1>
        </div>
        <p class="text-my-blackpt-4 px-10">{{ $post->content }}</p>
    </x-card>
</x-app-layout>
