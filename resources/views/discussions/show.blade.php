<x-app-layout>
    
        <x-discussion-card :$discussion>
            @can('update', $discussion)
            <x-link-button :href="route('discussions.edit', $discussion)">
                Edit this discussion
            </x-link-button>
            @endcan
        </x-discussion-card>
    
        @can('create', App\Models\Comment::class)
        <x-card class="mt-4 w-[450px]">
            <h1 class="mb-4 font-medium text-lg">
                Add a comment:
            </h1>
            <form action="{{ route('discussion.comments.store', $discussion) }}" method="POST">
                @csrf
    
                <div class="mb-8">
                    <x-textarea name="content" class="w-full" type="textarea" placeholder="Write a comment..." />
                </div>
    
                <x-button class="w-full font-medium">Submit</x-button>
            </form>
        </x-card>
    
    @else
    <x-card class="mb-4">
        <p class="font-bold text-slate-400">
            Log in to discuss!
        </p>
    </x-card>
    @endcan

    <x-card class="mb-4">
        <h2 class="mb-4 text-lg font-medium">
            Comments about {{ $discussion->title }}:
        </h2>

        @foreach ($discussion->comments->sortByDesc('created_at') as $comment)
        <x-comment-card class="mb-4" :$comment>
            @can('create', App\Models\Reply::class)
            <form action="{{ route('comment.replies.store', $comment) }}" method="POST" class=" flex flex-col my-8">
                @csrf
                <x-textarea class="" name="content" placeholder="Write a reply..." type="textarea" />

                <x-button class="font-medium text-sm w-fit self-end py-0.5 mt-2">Reply</x-button>
            </form>
            @else
            <p class="font-bold text-slate-400 my-8">
                Log in so you can join in on this disscussion
            </p>
            @endcan
            @foreach ($comment->replies->sortByDesc('updated_at') as $reply)
            <x-reply-card class="mb-4 w-fit ml-12" :$reply />
            @endforeach
        </x-comment-card>
        @endforeach
    </x-card>
</x-app-layout>