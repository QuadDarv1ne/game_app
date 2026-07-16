<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased selection:bg-red-600 selection:text-white">

<main class="w-full min-h-screen flex flex-col">
    {{ $slot }}
</main>
@persist('toast')
<flux:toast.group>
    <flux:toast class="!bg-zinc-900 !border-red-900/40 !text-zinc-100" />
</flux:toast.group>
@endpersist

@fluxScripts
</body>
</html>
