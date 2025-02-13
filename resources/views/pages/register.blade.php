<?php
use function Laravel\Folio\name;
use function Laravel\Folio\middleware;
use function Livewire\Volt\state;
use function Livewire\Volt\rules;
use App\Models\User;

name('register');
middleware(['guest']);

state([
    'name' => '',
    'email' => '',
    'password' => '',
]);
rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255','unique:'.User::class],
    'password' => ['required', 'string'],
]);

$register = function (){
    $validated = $this->validate();
    $validated['password'] = Hash::make($validated['password']);
    $user = User::create($validated);

    Auth::login($user);

    $this->redirect(route('home', absolute:false), navigate:true);
};
?>
<x-layouts.auth title="Registrarse">
    @volt('pages.register')
    <div
        class="relative h-full min-h-screen w-full bg-cover bg-fixed bg-center bg-no-repeat"
        style="background-image: url('/images/hero.jpg')"
    >
        <div class="h-full min-h-screen w-full bg-black lg:bg-opacity-50">
            <nav class="px-12 py-5">
                <img src="/images/logo.png" class="h-12" alt="Logo" />
            </nav>
            <div class="flex justify-center">
                <div
                    class="mt-2 w-full self-center rounded-md bg-black bg-opacity-70 px-16 py-16 lg:w-2/5 lg:max-w-md"
                >
                    <h2 class="mb-8 text-4xl font-semibold text-white">Registrarse</h2>
                    <!-- Formulario de registro -->
                    <form wire:submit="register" class="mt-4">
                        <!-- Name -->
                        <div>
                            <x-input
                                id="name"
                                label="Nombre"
                                wire:model="name"
                                type="text"
                                name="name"
                                required
                                autofocus
                                autocomplete="name"
                            />
                            @error('name')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input
                                id="email"
                                wire:model="email"
                                label="Email"
                                type="email"
                                name="email"
                                required
                                autocomplete="username"
                            />
                            @error('email')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input
                                id="password"
                                wire:model="password"
                                label="Contraseña"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                            />

                            @error('password')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button class="mt-10 w-full rounded-md bg-red-600 py-3 text-white transition hover:bg-red-700">
                                Registrarse
                            </button>
                        </div>

                        <p class="mt-4 text-center text-white">
                            <a href="{{ route('login')}}" wire:navigate class="hover:underline ">¿Ya tienes una cuenta?</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.auth>