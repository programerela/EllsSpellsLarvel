<x-card {{ $attributes->class(['rounded-md shadow-sm mb-2 p-2']) }}>
    <div class="flex items-center space-x-4 mb-4 space-y-1">
        <img src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" class="w-10 h-10 rounded-full">
        <div>
            <div class="flex items-center space-x-2">
                <h3 class="font-semibold text-lg">{{ $reply->user->name }}</h3>
                
            </div>
            <p class="text-gray-600 text-sm">{{ $reply->created_at->diffForHumans() }}</p>
        </div>
    </div>

    <p class="text-sm">{{ $reply->content }}</p>

    {{ $slot }}
</x-card>