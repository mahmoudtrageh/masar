@extends('layouts.app')

@section('content')
    <main class="mt-6">
        <a href="{{route('urls', $url->category->id)}}" class="flex items-center justify-start mb-6">
            <x-primary-button>
                {{ __('back to Roadmap') }}
            </x-primary-button>
        </a>
        <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
            <div class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                >
                    <div class="pt-3 sm:pt-5">
                        <h2 class="text-xl font-semibold text-black dark:text-white">{{$url->title}}</h2>

                        <p class="mt-4 text-sm/relaxed">
                            {{$url->description}}
                        </p>

                        <p class="mt-4">
                            <a href="{{$url->url}}" class="mt-4 text-sm/relaxed">
                                {{get_title_url($url->url)}}
                            </a>
                        </p>

                        <p class="mt-4 text-sm/relaxed">Average Duration: {{(int) $url->reviews->sum('url_duration') / (!empty($url->reviews->count()) ? $url->reviews->count() : 1)}} Months</p>
                        <!-- Reviews with Stars -->
                        <div class="mt-4 flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="@if(calculate_review($url->reviews->sum('rate'), $url->reviews->count()) >= $i) #eabf42 @else #e5e5e5 @endif" viewBox="0 0 20 20"><path d="M10 15.27L16.18 20l-1.64-7.03L20 8.24l-7.19-.61L10 1 7.19 7.63 0 8.24l5.46 4.73L3.82 20z"/></svg>
                            @endfor
                            <a href="{{route('url.reviews', $url)}}" class="ml-2 text-gray-600">({{ $url->reviews->count() }} reviewers)</a>
                        </div>

                        <!-- Order Badge -->
                        <p class="mt-4 inline-block rounded-full bg-gradient-to-r from-blue-500 to-blue-700 text-white my-4 text-xs font-semibold shadow-md">
                            Order: {{calculate_average($url->reviews->sum('order'), $url->reviews->count())}}
                        </p>

                        <p class="mt-4">By: {{$url->user? $url->user->name : '-'}}</p>
                    </div>
            </div>
        </div>
        @if(auth()->user() && !$reviewExists)
        <div class="mt-6">
            <h3 class="text-center my-6">Add Review</h3>
            <form method="POST" action="{{ route('create.review') }}">
                @csrf

                <input type="hidden" name="url_id" value="{{request()->url->id}}">
                <input type="hidden" name="category_id" value="{{request()->url->category_id}}">

                <div>
                    <x-input-label for="review" :value="__('Review')" />
                    <textarea id="review" class="block mt-1 w-full rounded" name="review" required autofocus autocomplete="name" rows="4">{{ old('review') }}</textarea>
                    <x-input-error :messages="$errors->get('review')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="rate" :value="__('Rate')" />
                    <x-text-input id="rate" class="block mt-1 w-full"
                                    type="number"
                                    name="rate"
                                    min="0"
                                    step="1"
                                    max="5"
                                    required autocomplete="off" />
                    <x-input-error :messages="$errors->get('rate')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="order" :value="__('Order')" />
                    <x-text-input id="order" class="block mt-1 w-full"
                                    type="number"
                                    name="order"
                                    min="0"
                                    step="1"
                                    required autocomplete="off" />
                    <x-input-error :messages="$errors->get('order')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="category_duration" :value="__('Category Duration')" />
                    <x-text-input id="category_duration" class="block mt-1 w-full"
                                    type="number"
                                    name="category_duration"
                                    required autocomplete="off" />
                    <x-input-error :messages="$errors->get('category_duration')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="url_duration" :value="__('Url Duration')" />
                    <x-text-input id="url_duration" class="block mt-1 w-full"
                                    type="number"
                                    name="url_duration"
                                    required autocomplete="off" />
                    <x-input-error :messages="$errors->get('url_duration')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Add') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        @endif
    </main>
@endsection

