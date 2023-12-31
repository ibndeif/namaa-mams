<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>



    <x-section>
        <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
            @csrf

            <h2 class="text-xl mb-4">{{ __('Create Article') }}</h2>

            <!-- Title -->
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" autofocus autocomplete="title" />
                <x-input-error :messages="$errors->first('title')" class="mt-2" />
            </div>

            <!-- Body -->
            <div class="mt-4">
                <x-input-label for="editor" :value="__('Body')" />
                <x-text-area id="editor" class="block mt-1 w-full" name="body" :value="old('body')" />
                <x-input-error :messages="$errors->first('body')" class="mt-2" />
            </div>

            <!-- Image -->
            <div class="mt-4">
                <x-input-label for="image" :value="__('Image')" />
                <x-text-input type="file" id="image" class="block mt-1 w-full" name="image" />
                <x-input-error :messages="$errors->first('image')" class="mt-2" />
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </x-section>
</x-app-layout>
