<?php 

use function Laravel\Folio\name;
use function Laravel\Folio\middleware;
use function Livewire\Volt\component;

name('dashboard');
middleware('auth');
?>
<x-layouts.dashboard>
    <livewire:billboard />
</x-layouts.dashboard>
