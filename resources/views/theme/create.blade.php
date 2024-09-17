<x-app-layout class="flex items-center justify-center">
    <x-card class="py-8 px-8 w-[500px]">
        <h1 class="mt-6 mb-12 text-center text-4xl font-medium text-my-beige">
            Create a new theme to discuss
        </h1>
        <form action="{{ route('theme.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-8">
                <x-label for="name" :required="true">Name</x-label>
                <x-text-input name="name" class="w-full" />
            </div>

            <div class="mb-8">
                <x-label for="description" :required="true">Description</x-label>
                <x-textarea name="description" class="w-full" type="textarea" />
            </div>

            <div class="mb-8">
                <x-label for="picture" :required="true">Upload picture</x-label>
                <input type="file" name="picture" accept=".jpg,.png">
            </div>
        

            <x-button class="w-full font-medium">Submit</x-button>
        </form>
    </x-card>

</x-app-layout>