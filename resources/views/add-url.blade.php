@extends('layouts.app')

@section('content')
    <main class="mt-6">
        <div class="flex items-center justify-start">
            <a href="{{route('home')}}">
                <x-primary-button>
                    {{ __('Home') }}
                </x-primary-button>
            </a>
        </div>
        <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
            <div class="mt-6 gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                <h3 class="text-center my-6">Add Url</h3>
                <form method="POST" action="{{ route('add.url') }}">
                    @csrf

                    <div class="mt-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full"
                                        type="text"
                                        name="title"
                                        required autocomplete="off" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="url" :value="__('Url')" />
                        <x-text-input id="url" class="block mt-1 w-full"
                                        type="text"
                                        name="url"
                                        required autocomplete="off" />
                        <x-input-error :messages="$errors->get('url')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" class="block mt-1 w-full rounded" name="description" required autofocus autocomplete="name" rows="4">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category" :value="__('Category')" />

                        <select id="category" name="category_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="" disabled selected>Select category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('average_duration')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="average_duration" :value="__('Duration')" />
                        <x-text-input id="average_duration" class="block mt-1 w-full"
                                        type="number"
                                        name="average_duration"
                                        required autocomplete="off" />
                        <x-input-error :messages="$errors->get('average_duration')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Add') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

