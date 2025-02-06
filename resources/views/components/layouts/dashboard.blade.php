@props(['title' => ''])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title ?: config('app.name', 'laravel')}}</title>
    {{$head ?? ''}}
    @vite('resources/css/app.css')
</head>
<body class="h-full overflow-x-hidden bg-gray-900 font-sans text-white antialiased">
    <main class="h-full">
        {{ $slot }}
    </main>
</body>
</html>