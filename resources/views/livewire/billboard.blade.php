<?php

use function Livewire\Volt\{state};
use App\Models\Movie;

state([
    'billboard' => Movie::inRandomOrder()->first(),
]);

?>

<div>
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
            </div>
        </div>
        
    </div>
</div>