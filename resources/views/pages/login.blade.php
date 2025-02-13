<?php
use function Laravel\Folio\name;
use function Laravel\Folio\middleware;
use function Livewire\Volt\state;
use function Livewire\Volt\rules;
use function Livewire\Volt\protect;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Lockout;
use App\Models\User;

name('login');

middleware('guest');

state([
    'email' => '',
    'password' => '',
]);
rules(['email'=> 'required|email', 'password' => 'required']);

$login = function () {
    $this->validate();

    $this->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('home', absolute: false), navigate: true);
};

$authenticate = function () {
    $this->ensureIsNotRateLimited();

    if (! Auth::attempt($this->only(['email', 'password']), true)) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    RateLimiter::clear($this->throttleKey());
};

$ensureIsNotRateLimited = protect(function () {
    if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
        return;
    }

    event(new Lockout(request()));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
        'email' => trans('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]),
    ]);
});

$throttleKey = protect(function () {
    return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
});
?>
<x-layouts.auth title="Iniciar Sesión">
@volt('pages.login')
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
        <h2 class="mb-8 text-4xl font-semibold text-white">Iniciar Sesión</h2>

        <form class="mt-4" wire:submit="login">
            <!-- Email Address -->
            <div>
                <x-input
                    id="email"
                    wire:model="email"
                    label="Email"
                    type="email"
                    name="email"
                    required
                    autofocus
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
                    autocomplete="current-password"
                />
                @error('password')
                    <p class="mt-2 text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div >
                <button class="mt-10 w-full rounded-md bg-red-600 py-3 text-white transition hover:bg-red-700">
                    Iniciar Sesión
                </button>
            </div>

            <p class="mt-4 text-center text-white">
                <a href="{{ route('register') }}" wire:navigate class="hover:underline">¿No tienes una cuenta?</a>
            </p>
        </form>
        </div>
            </div>
        </div>
    </div>
@endvolt
</x-layouts.auth>