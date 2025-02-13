<?php

use function Livewire\Volt\{state};
use function Livewire\Volt\on;
use App\Models\Movie;

state([
    'billboard' => Movie::inRandomOrder()->first(),
]);

$toggleFavorite = function (Movie $movie) {
    Auth::user()->favoriteMovies()->toggle($movie);

    $this->dispatch('toggled-favorite');
};

?>

<div x-data="{ showModal: false}">
    <div class="relative h-[56.25vw]">
        <video
            poster="{{ $billboard->thumbnail_url }}"
            class="h-[56.25vw] w-full object-cover brightness-[60%] transition duration-500"
            autoplay
            muted
            loop
            src="{{ $billboard->video_url }}"
        ></video>
        <div class="absolute top-[30%] ml-4 md:top-[40%] md:ml-16">
            <p class="h-full w-[50%] text-xl font-bold text-white drop-shadow-xl md:text-5xl lg:text-6xl">
                {{ $billboard->title }}
            </p>
            <p class="mt-3 w-[90%] text-[8px] text-white drop-shadow-xl md:mt-8 md:w-[80%] md:text-lg lg:w-[50%]">
                {{ $billboard->description }}
            </p>
            <div class="mt-3 flex flex-row items-center gap-3 md:mt-4">
                <a
                    href="{{ route('watch.movie', ['movie' => $billboard]) }}"
                    wire:navigate
                    class="flex w-auto flex-row items-center rounded-md bg-white px-2 py-1 text-xs font-semibold text-gray-950 transition hover:bg-neutral-300 md:px-4 md:py-2 lg:text-lg"
                >
                    <!-- Icono de reproducción -->
                    <svg
                        class="mr-1 size-4 text-black md:size-7"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                    >
                        <path
                            d="M3 3.732a1.5 1.5 0 0 1 2.305-1.265l6.706 4.267a1.5 1.5 0 0 1 0 2.531l-6.706 4.268A1.5 1.5 0 0 1 3 12.267V3.732Z"
                        />
                    </svg>
                    Reproducir
                </a>
                <button
                    @click="showModal = true"
                    class="flex w-auto flex-row items-center rounded-md bg-white bg-opacity-30 px-2 py-1 text-xs font-semibold text-white transition hover:bg-opacity-20 md:px-4 md:py-2 lg:text-lg"
                >
                    <!-- icono de información -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="mr-1 w-4 md:w-7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"
                        />
                    </svg>

                    Más información
                </button>
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
                            poster="{{ $billboard->thumbnail_url }}"
                            autoplay
                            muted
                            loop
                            src="{{ $billboard->video_url }}"
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
                                {{ $billboard->title }}
                            </p>
                            <div class="flex flex-row items-center gap-4">
                                <a
                                    href="{{ route('watch.movie', ['movie' => $billboard]) }}"
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
                                    wire:click="toggleFavorite({{ $billboard->id }})"
                                    class="group/item flex h-6 w-6 items-center justify-center rounded-full border-2 border-white transition hover:border-neutral-300 lg:h-10 lg:w-10"
                                >
                                    @if ($billboard->favoritedBy->contains(Auth::user()))
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
                            <p class="text-lg text-white">{{ $billboard->duration }}</p>
                            <p class="text-lg text-white">{{ $billboard->genre }}</p>
                        </div>
                        <p class="text-lg text-white">{{ $billboard->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>