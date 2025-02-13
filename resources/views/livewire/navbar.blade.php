<?php

use function Livewire\Volt\{state};


$logout = function () {
    Auth::guard('web')->logout();

    Session::invalidate();
    Session::regenerateToken();

    $this->redirect(route('home'), navigate: true);
};

?>

<nav
    x-data="{
        showBackground: false,
        handleScroll() {
            this.showBackground = window.scrollY >= 66
        },
    }"
    @scroll.window="handleScroll"
    class="fixed z-40 w-full"
>
    <div
        :class="{ 'bg-zinc-900 bg-opacity-90': showBackground }"
        class="flex flex-row items-center px-4 py-6 transition duration-500 md:px-16"
    >
        <img src="/images/logo.png" class="h-4 lg:h-7" alt="Logo" />
        <div class="ml-8 hidden flex-row gap-7 lg:flex">
        @php
            $navbarItems = [
                ['Inicio', route('dashboard'), true],
                ['Series de TV', '#', false],
                ['Películas', '#', false],
                ['Novedades', '#', false],
                ['Mi lista', '#', false],
                ['Buscar por idioma', '#', false],
            ];
        @endphp
        @foreach ($navbarItems as [$label,$url,$active])
            <a
                @class([
                    'transition hover:text-gray-300',
                    'text-white' => $active, // activo
                    'text-gray-200' => ! $active, // no activo
                ])
                href="{{ $url }}"
            >
                {{ $label }}
            </a>
        @endforeach
        </div>
        <div x-data="{ isActive: false }" class="relative ml-8 flex flex-row items-center gap-2 lg:hidden">
            <button x-on:click="isActive = !isActive" class="relative flex flex-row items-center gap-2">
                <div class="text-sm text-white">Explorar</div>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 fill-white text-white transition"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>

            <div
                class="absolute left-0 top-8 flex w-56 flex-col rounded border-2 border-gray-800 bg-black py-5"
                role="menu"
                x-cloak
                x-transition
                x-show="isActive"
                x-on:click.away="isActive = false"
                x-on:keydown.escape.window="isActive = false"
            >
            <div class="flex flex-col gap-4">
                @foreach ($navbarItems as [$label, $url])
                    <a href="{{ $url }}" class="px-3 text-center text-white hover:underline">{{ $label }}</a>
                @endforeach
            </div>
            </div>
        </div>
        <div class="ml-auto flex flex-row items-center gap-7">
            <button type="button" class="text-gray-200 transition hover:text-gray-300">
                <!-- icono de buscar -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                    />
                </svg>
            </button>
            <button type="button" class="text-gray-200 transition hover:text-gray-300">
                <!-- icono de notificaciones -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                    />
                </svg>
            </button>
            <div x-data="{ isActive: false }" class="relative">
                <button x-on:click="isActive = !isActive" type="button" class="relative flex flex-row items-center gap-2">
                    <div class="h-6 w-6 overflow-hidden rounded-md lg:h-10 lg:w-10">
                        <img src="/images/default-blue.png" alt="" />
                    </div>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 fill-white text-white transition"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>

                <div
                    class="absolute right-0 top-14 flex w-56 flex-col rounded border-2 border-gray-800 bg-black py-5"
                    role="menu"
                    x-cloak
                    x-transition
                    x-show="isActive"
                    x-on:click.away="isActive = false"
                    x-on:keydown.escape.window="isActive = false"
                >
                    <div class="flex flex-col gap-3">
                        <div class="group/item flex w-full flex-row items-center gap-3 px-3">
                            <img
                                class="w-8 rounded-md"
                                src="/images/default-blue.png"
                                alt="{{ auth()->user()->name }}"
                            />
                            <a href="#" class="text-sm text-white group-hover/item:underline">
                                {{ auth()->user()->name }}
                            </a>
                        </div>
                    </div>
                    <hr class="my-4 h-px border-0 bg-gray-800" />
                    <button wire:click="logout" type="button" class="w-full px-3 text-center text-sm text-white hover:underline">
                        Cerrar sesión
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>
