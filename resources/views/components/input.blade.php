@props(['label'])

<div class="relative">
    <input
        placeholder=" "
        {{ $attributes->merge(['class' => 'border-0 text-base invalid:border-b-1 peer block w-full appearance-none rounded-md bg-neutral-700 px-6 pb-1 pt-6 text-white focus:outline-none focus:ring-0']) }}
    />
    <label
        for="{{ $attributes->get('id') }}"
        class="absolute left-6 top-4 z-10 origin-[0] -translate-y-3 scale-75 transform text-base text-zinc-400 duration-150 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-3 peer-focus:scale-75"
    >
        {{ $label }}
    </label>
</div>