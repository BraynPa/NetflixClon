<?php 

use function Laravel\Folio\name;
use function Laravel\Folio\middleware;

name('profiles');
middleware('auth');
?>
<x-layouts.dashboard>
    <div class="flex h-full min-h-screen items-center justify-center">
        <div class="flex flex-col">
            <h1 class="text-center text-3xl text-white md:text-6xl">¿Quién está viendo?</h1>
            <div class="mt-10 flex items-center justify-center gap-8">
                <a href="{{route('dashboard')}}" wire:navigate>
                    <div class="group mx-auto w-44 flex-row">
                        <div
                            class="flex h-44 w-44 items-center justify-center overflow-hidden rounded-md border-2 border-transparent group-hover:cursor-pointer group-hover:border-white"
                        >
                            <img class="h-max w-max object-contain" src="/images/default-blue.png" alt="" />
                        </div>
                        <div class="mt-4 text-center text-2xl text-gray-400 group-hover:text-white">
                            {{ auth()->user()->name }}
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
