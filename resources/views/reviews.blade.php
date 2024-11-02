@extends('layouts.app')

@section('content')
    <main class="mt-6">

        <h2 class="text-center mb-6">Reviews ({{request()->category ? request()->category->title : request()->url->title}}) - {{models_count(request()->category ? request()->category : request()->url)['reviews']}}</h2>

        <div class="flex items-center justify-start mb-6 gap-4">
            <a href="{{route('home')}}">
                <x-primary-button>
                    {{ __('Home') }}
                </x-primary-button>
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
            @forelse($reviews as $review)
                <div
                    class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                >
                    <div class="pt-3 sm:pt-5">
                        <p class="text-xl font-semibold text-black dark:text-white">{{$review->review}}</p>

                        <p class="mt-4 block rounded-full bg-gradient-to-r from-blue-500 to-blue-700 text-white my-4 text-xs font-semibold shadow-md">
                            Order: {{$review->order}}
                        </p>

                        <p class="mt-4 block rounded-full bg-gradient-to-r from-blue-500 to-blue-700 text-white my-4 text-xs font-semibold shadow-md">
                            Rate: {{$review->rate}}
                        </p>

                        <p class="mt-4 block rounded-full bg-gradient-to-r from-blue-500 to-blue-700 text-white my-4 text-xs font-semibold shadow-md">
                            Category Duration: {{$review->category_duration}}
                        </p>

                        <p class="mt-4 block rounded-full bg-gradient-to-r from-blue-500 to-blue-700 text-white my-4 text-xs font-semibold shadow-md">
                            Url Duration: {{$review->url_duration}}
                        </p>

                        <p class="mt-4 block rounded-full bg-gradient-to-r from-blue-500 to-blue-700 text-white my-4 text-xs font-semibold shadow-md">
                            By: {{$review->user->name}}
                        </p>
                    </div>

                </div>
            @empty
            <div class="flex items-center gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
            >
                <p class="mt-6 mb-6 text-sm/relaxed">
                    There is no views
                </p>
            </div>
            @endforelse
        </div>

        <div class="row mt-6">
            {{$reviews->links()}}
        </div>
    </main>
@endsection
