<?php 

use function Laravel\Folio\name;
use function Laravel\Folio\middleware;

name('watch.movie');
middleware('auth');
?>
<x-layouts.dashboard>
    <div class="h-screen w-screen bg-black">
        <nav class="fixed z-10 flex w-full flex-row items-center gap-8 bg-black bg-opacity-70 p-4">
            <a href="{{ route('dashboard' )}}" wire:navigate>
                <!-- Icono de regreso -->
                <svg
                    class="w-4 cursor-pointer text-white transition hover:opacity-80 md:w-10"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z"
                        clip-rule="evenodd"
                    />
                </svg>
            </a>
            <p class="text-1xl font-bold text-white md:text-3xl">
                <span class="font-light">Viendo:</span>
                {{ $movie->title }}
            </p>
        </nav>
        <video class="h-full w-full" autoplay controls src="{{ $movie->video_url }}"></video>
    </div>
</x-layouts.dashboard>