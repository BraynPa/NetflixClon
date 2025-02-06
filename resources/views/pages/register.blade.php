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
    <div class="mx-auto mt-10 max-w-sm">
        <h1 class="font-medium">Registrarse</h1>
        <form wire:submit="register" class="mt-4">
            <!-- Name -->
            <div>
                <label for="name">Nombre</label>
                <input
                    id="name"
                    wire:model="name"
                    class="mt-1 block w-full border-zinc-200"
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
                <label for="email">Email</label>
                <input
                    id="email"
                    wire:model="email"
                    class="mt-1 block w-full border-zinc-200"
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
                <label for="password">Contraseña</label>
                <input
                    id="password"
                    wire:model="password"
                    class="mt-1 block w-full border-zinc-200"
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
                <button class="w-full border border-zinc-200 px-4 py-2 hover:bg-zinc-200">Registrarme</button>
            </div>

            <p class="mt-4 text-center">
                <a href="{{ route('login')}}" wire:navigate class="hover:underline">¿Ya tienes una cuenta?</a>
            </p>
        </form>
    </div>
    @endvolt
</x-layouts.auth>