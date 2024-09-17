<x-app-layout>
    <div class="mb-1 h-[650px] bg-cover bg-no-repeat" style="background-image: url('/images/background2.jpg');">
        <div class="flex justify-center items-center text-my-black hover:bg-my-white hover:bg-opacity-50 focus:outline-none focus:bg-my-lilac transition duration-1250 ease-in-out w-250 h-full pt-5">
            <div class="flex flex-col justify-center items-center">
                <h1 class="text-my-black font-palatino text-4xl">Become the best YOU that you can be</h1>
                <a href="{{ route('theme.index') }}" class="m-4">Browse Topics -></a>
            </div>
        </div>
    </div>
    <div class="mb-1 h-[650px] bg-cover bg-no-repeat" style="background-image: url('/images/background.jpg');">
        <div class="flex justify-center items-center text-my-black hover:bg-my-white hover:bg-opacity-50 focus:outline-none focus:bg-my-lilac transition duration-1250 ease-in-out w-250 h-full pt-5">
            <div class="flex flex-col justify-center items-center">
                <h1 class="text-my-black font-palatino text-4xl">Get into conversations that interest you</h1>
                <a href="{{ route('login') }}" class="m-4">Log in -> </a>
            </div>
        </div>
    </div>
</x-app-layout>