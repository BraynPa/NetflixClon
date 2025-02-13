<?php 

use function Laravel\Folio\name;
use function Laravel\Folio\middleware;
use function Livewire\Volt\component;

name('dashboard');
middleware('auth');
?>
<x-layouts.dashboard>
    <x-slot name="header">
        <livewire:navbar />
    </x-slot>
    <livewire:billboard />
    <div class="pt-5 pb-40">
        <livewire:movie-list type="trending" />
        <livewire:movie-list type="favorites"/>
    </div>
</x-layouts.dashboard>
