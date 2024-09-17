<x-card class="mt-4 bg-opacity-70 w-full mx-auto">
    <div class="w-full flex space-x-6">

        <img src="{{ $theme->picture }}" alt="Theme picture" class="w-[480px]">


        <div class="w-[450] space-y-20 justify-between">
            <div class="space-y-4">
                <div>
                    <div class="flex space-x-3">
                        <img src="{{ $theme->user->avatar }}" alt="{{ $theme->user->name }}"
                            class="w-10 h-10 mt-2 rounded-full">
                        <div class="">
                            <h3 class="font-semibold pt-2 uppercase">{{ $theme->user->name }}</h3>
                            <p class="text-gray-600 text-sm">
                                @if ($theme->created_at)
                                    {{ $theme->created_at->diffForHumans() }}
                                @else
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="mb-4 text-xl text-black font-semibold">{{ $theme->name }}</h2>
                    <p class="mb-4 text-gray-600">{{ $theme->description }}</p>
                </div>
            </div>
            <div class="mt-auto">
                {{ $slot }}
            </div>
        </div>

    </div>
</x-card>
