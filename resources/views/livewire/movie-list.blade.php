<?php

use function Livewire\Volt\{state};
use function Livewire\Volt\on;
use App\Models\Movie;

$getMovies = function () {
    if($this->type === 'trending'){
        return $this->movies = Movie::all();
    }
    return $this->movies = Auth::user()->favoriteMovies;

};

state(['type' => 'trending','movies' => $getMovies]);

on(['toggled-favorite' => $getMovies]);

$toggleFavorite = function (Movie $movie) {
    Auth::user()->favoriteMovies()->toggle($movie);

    $this->dispatch('toggled-favorite');
};

?>

<div class="mt-4 space-y-8 px-4 md:px-12">
    <p class="mb-4 text-base font-semibold text-white md:text-xl lg:text-2xl">{{$type === 'trending' ? 'En tendencia': 'Mi lista'}}</p>
    <div class="grid grid-cols-4 gap-2">
        @foreach ($movies as $movie)
        <div x-data="{ showModal: false }" class="group relative h-[12vw] bg-zinc-900">
            <a href="{{ route('watch.movie', ['movie' => $movie]) }}">
                <img
                    src="{{ $movie->thumbnail_url }}"
                    alt="{{ $movie->title }}"
                    class="duration h-[12vw] w-full rounded-md object-cover shadow-xl transition delay-300 group-hover:opacity-90 sm:group-hover:opacity-0"
                />
            </a>
            <div
                class="invisible absolute top-0 z-10 w-full scale-0 opacity-0 transition delay-300 duration-200 group-hover:-translate-y-[6vw] group-hover:translate-x-[2vw] group-hover:scale-110 group-hover:opacity-100 sm:visible"
            >
                <a href="#">
                    <img
                        src="{{ $movie->thumbnail_url }}"
                        alt="{{ $movie->title }}"
                        class="duration h-[12vw] w-full rounded-t-md object-cover shadow-xl transition"
                    />
                </a>
                <div class="absolute z-10 w-full rounded-b-md bg-zinc-800 p-2 shadow-md transition lg:p-4">
                    <div class="flex flex-row items-center gap-3">
                        <a
                            href="{{ route('watch.movie', ['movie' => $movie]) }}"
                            class="flex h-6 w-6 items-center justify-center rounded-full bg-white transition hover:bg-neutral-300 lg:h-10 lg:w-10"
                        >
                            <!-- icon de play -->
                            <svg
                                class="ml-1 w-4 text-black lg:w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 16 16"
                                fill="currentColor"
                            >
                                <path
                                    d="M3 3.732a1.5 1.5 0 0 1 2.305-1.265l6.706 4.267a1.5 1.5 0 0 1 0 2.531l-6.706 4.268A1.5 1.5 0 0 1 3 12.267V3.732Z"
                                />
                            </svg>
                        </a>
                        <button
                            wire:click="toggleFavorite({{ $movie->id }})"
                            class="group/item flex h-6 w-6 items-center justify-center rounded-full border-2 border-white transition hover:border-neutral-300 lg:h-10 lg:w-10"
                        >
                            @if ($movie->favoritedBy->contains(Auth::user()))
                                <svg
                                    class="w-4 text-white group-hover/item:text-neutral-300 lg:w-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m4.5 12.75 6 6 9-13.5"
                                    />
                                </svg>
                            @else
                                <svg
                                    class="w-4 text-white group-hover/item:text-neutral-300 lg:w-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 4.5v15m7.5-7.5h-15"
                                    />
                                </svg>
                            @endif
                        </button>
                        <button
                            @click="showModal = true"
                            class="group/item ml-auto flex h-6 w-6 cursor-pointer items-center justify-center rounded-full border-2 border-white transition hover:border-neutral-300 lg:h-10 lg:w-10"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-4 text-white group-hover/item:text-neutral-300 lg:size-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19.5 8.25-7.5 7.5-7.5-7.5"
                                />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-4 font-semibold text-green-400">
                        Nuevo
                        <span class="text-white">2024</span>
                    </p>
                    <div class="mt-4 flex flex-row items-center gap-2">
                        <p class="text-[10px] text-white lg:text-sm">{{ $movie->duration }}</p>
                    </div>
                    <div class="mt-4 flex flex-row items-center gap-2 text-[8px] text-white lg:text-sm">
                        <p>{{ $movie->genre }}</p>
                    </div>
                </div>
            </div>
            <div @keydown.escape.window="showModal = false">
                <div x-show="showModal"  x-cloak x-transition.opacity class="fixed inset-0 z-50 bg-black/50"></div>
                <div x-show="showModal" x-cloak x-transition class="fixed inset-0 z-50 grid place-content-center">
                    <div class="max-w-3xl overflow-hidden rounded-md bg-gray-900">
                        <div>
                            <div class="relative h-96">
                                <video
                                    poster="{{ $movie->thumbnail_url }}"
                                    autoplay
                                    muted
                                    loop
                                    src="{{ $movie->video_url }}"
                                    class="h-full w-full object-cover brightness-[60%]"
                                ></video>
                                <button
                                    @click="showModal = false"
                                    class="absolute right-3 top-3 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-black bg-opacity-70"
                                >
                                    <!-- icono de cerrar -->
                                    <svg
                                        class="size-6 text-white"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-[10%] left-10">
                                    <p class="mb-8 h-full text-3xl font-bold text-white md:text-4xl lg:text-5xl">
                                        {{ $movie->title }}
                                    </p>
                                    <div class="flex flex-row items-center gap-4">
                                        <a
                                            href="{{ route('watch.movie', ['movie' => $movie]) }}"
                                            wire:navigate
                                            class="flex h-6 w-6 items-center justify-center rounded-full bg-white transition hover:bg-neutral-300 lg:h-10 lg:w-10"
                                        >
                                            <svg
                                                class="ml-1 w-4 text-black lg:w-6"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 16 16"
                                                fill="currentColor"
                                            >
                                                <path
                                                    d="M3 3.732a1.5 1.5 0 0 1 2.305-1.265l6.706 4.267a1.5 1.5 0 0 1 0 2.531l-6.706 4.268A1.5 1.5 0 0 1 3 12.267V3.732Z"
                                                />
                                            </svg>
                                        </a>
                                        <button
                                            wire:click="toggleFavorite({{ $movie->id }})"
                                            class="group/item flex h-6 w-6 items-center justify-center rounded-full border-2 border-white transition hover:border-neutral-300 lg:h-10 lg:w-10"
                                        >
                                            @if ($movie->favoritedBy->contains(Auth::user()))
                                                <svg
                                                    class="w-4 text-white group-hover/item:text-neutral-300 lg:w-6"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="m4.5 12.75 6 6 9-13.5"
                                                    />
                                                </svg>
                                            @else
                                                <svg
                                                    class="w-4 text-white group-hover/item:text-neutral-300 lg:w-6"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M12 4.5v15m7.5-7.5h-15"
                                                    />
                                                </svg>
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="px-12 py-8">
                                <div class="mb-8 flex flex-row items-center gap-2">
                                    <p class="text-lg font-semibold text-green-400">Nuevo</p>
                                    <p class="text-lg text-white">{{ $movie->duration }}</p>
                                    <p class="text-lg text-white">{{ $movie->genre }}</p>
                                </div>
                                <p class="text-lg text-white">{{ $movie->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
