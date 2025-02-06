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
    <div class="mx-auto mt-10 max-w-sm">
        <h1 class="font-medium">Iniciar Sesión</h1>

        <form class="mt-4" wire:submit="login">
            <!-- Email Address -->
            <div>
                <label for="email">Email</label>
                <input
                    id="email"
                    wire:model="email"
                    class="mt-1 block w-full border-zinc-200"
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
                <label for="password">Contraseña</label>

                <input
                    id="password"
                    wire:model="password"
                    class="mt-1 block w-full border-zinc-200"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />
                @error('password')
                    <p class="mt-2 text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <button class="w-full border border-zinc-200 px-4 py-2 hover:bg-zinc-200">Iniciar Sesión</button>
            </div>

            <p class="mt-4 text-center">
                <a href="{{ route('register') }}" wire:navigate class="hover:underline">¿No tienes una cuenta?</a>
            </p>
        </form>
    </div>
@endvolt
</x-layouts.auth>