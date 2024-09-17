<x-app-layout>
    <x-theme-card :$theme>
        <div class="flex items-center space-x-4">
            @auth
                @if ($theme->user->id !== auth()->id())
                    @unless ($theme->isFollowedBy(auth()->user()))
                        <form action="{{ route('theme.follow', $theme) }}" method="POST">
                            @csrf
                            <x-button
                                class="rounded-md bg-my-black px-2.5 py-1.5 text-center text-sm font-semibold text-black shadow-sm hover:bg-my-purple-3 hover:text-black">
                                Follow this theme
                            </x-button>
                        </form>
                    @else
                        <form action="{{ route('theme.unfollow', $theme) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-button
                                class="rounded-md border border-red-700 bg-my-black px-2.5 py-1.5 text-center text-sm font-semibold text-black shadow-sm hover:bg-red-700 hover:text-black">
                                Unfollow this theme
                            </x-button>
                        </form>
                    @endunless
                @endif

                @can('update', $theme)
                    <x-link-button :href="route('theme.edit', $theme)">
                        Edit theme
                    </x-link-button>
                @endcan
            @else
                <p class="font-bold text-slate-400">
                    Log in for more!
                </p>
            @endauth
        </div>
    </x-theme-card>


    @can('create', App\Models\Discussion::class)
        <x-card class="mb-4 mx-auto mt-10 w-[750px]">
            <h1 class="mb-4 font-medium text-lg">
                Create a discussion about this theme
            </h1>
            <form action="{{ route('theme.discussions.store', $theme) }}" method="POST">
                @csrf
                <div class="mb-8">
                    <x-label for="title" :required="true">Title</x-label>
                    <x-text-input name="title" class="w-full" />
                </div>

                <div class="mb-8">
                    <x-label for="description" :required="true">Description</x-label>
                    <x-textarea name="description" class="w-full" type="textarea" />
                </div>

                <x-button class="w-full font-medium">Submit</x-button>
            </form>
        </x-card>
    @else
        <div class="flex justify-center items-center">
            <a href="{{ route('login') }}" class="font-bold text-my-blacktext-3xl text-center">
                Log in for discussion creation!
            </a>
        </div>
    @endcan

    @auth
        <div x-data="{ openTab: 1 }">
            <div class="flex space-x-4 text-sm font-medium text-center text-gray-500 ml-8 mt-8">
                <button @click="openTab = 1"
                    :class="openTab === 1 ? 'px-4 py-3 rounded-lg text-black bg-my-lilac active' :
                        'px-4 py-3 rounded-lg hover:text-gray-900 hover:bg-gray-100'">Discussions</button>

                <button @click="openTab = 3"
                    :class="openTab === 3 ? 'px-4 py-3 rounded-lg text-black bg-my-lilac active' :
                        'px-4 py-3 rounded-lg hover:text-gray-900 hover:bg-gray-100'">Posts</button>
            </div>

            <x-card class="mb-4" x-show="openTab === 1">
                <h2 class="mb-10 mt-2 text-xl font-medium">
                    Discussions about {{ $theme->name }}
                </h2>

                @foreach ($theme->discussions->sortByDesc('updated_at') as $discussion)
                    <x-discussion-card class="mb-4" :$discussion>
                        <x-link-button :href="route('discussion.show', $discussion)">
                            Show discussion
                        </x-link-button>
                    </x-discussion-card>
                @endforeach
            </x-card>


            <x-card class="mb-4" x-show="openTab === 3">
                <h2 class="mb-10 mt-2 text-xl font-medium">
                    Posts about {{ $theme->name }}
                </h2>

                @foreach ($theme->posts as $post)
                    <x-post-card :$post>
                        <x-link-button :href="route('posts.show', $post)">
                            Show post
                        </x-link-button>
                    </x-post-card>
                @endforeach
            </x-card>
        </div>
    @endauth
</x-app-layout>
