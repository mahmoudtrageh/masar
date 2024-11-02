<x-app-layout>
    <style>
        p {
            color: #fff;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Favourites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                @foreach($favourites as $favourite)
                        <div class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                            <div class="pt-3 sm:pt-5">
                                <div class="flex justify-between items-center">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">
                                        <a href="{{ route('url.favourites', $favourite->id) }}">
                                            {{ $favourite->title }}
                                        </a>
                                    </h2>
                                    <a href="#" class="ml-4">
                                        @if(auth()->user()->favourites()->where(['favouritable_id' => $favourite->id, 'favouritable_type' => App\Models\Category::class])->exists())
                                            <form action="{{ route('favourites.destroy', ['type' => 'category', 'id' => $favourite->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                    <path
                                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                                        fill="red"
                                                    />
                                                </svg></button>
                                            </form>
                                        @else
                                            <form action="{{ route('favourites.store', ['type' => 'category', 'id' => $favourite->id]) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-blue-500"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                    <path
                                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                                        fill="grey"
                                                    />
                                                </svg></button>
                                            </form>
                                        @endif

                                    </a>
                                </div>

                                <p class="mt-4 text-sm/relaxed">
                                    {{ $favourite->description }}
                                </p>

                                <div class="mt-4 flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="@if(calculate_review( $favourite->reviews->sum('rate'),  $favourite->reviews->count()) >= $i) #eabf42 @else #e5e5e5 @endif" viewBox="0 0 20 20">
                                            <path d="M10 15.27L16.18 20l-1.64-7.03L20 8.24l-7.19-.61L10 1 7.19 7.63 0 8.24l5.46 4.73L3.82 20z"/>
                                        </svg>
                                    @endfor
                                    <a href="{{ route('category.reviews', $favourite) }}" class="ml-2 text-gray-600">({{  $favourite->reviews->count() }} reviewers)</a>
                                </div>
                                @if(calculate_average( $favourite->reviews->sum('category_duration'),  $favourite->reviews->count()) != 0)
                                    <p class="mt-4 text-sm/relaxed">Average Duration: {{ calculate_average( $favourite->reviews->sum('category_duration'),  $favourite->reviews->count()) }} Months</p>
                                @endif
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
