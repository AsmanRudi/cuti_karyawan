<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HR Portal') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .shadow-soft {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-on-background bg-background antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="flex items-center gap-stack-md px-stack-sm mb-stack-lg mt-stack-sm">
            <span class="material-symbols-outlined text-h1 text-primary" style="font-size: 48px;">work</span>
            <div>
                <h1 class="text-h1 font-h1 text-primary">HR Portal</h1>
                <p class="text-label-md font-label-md text-on-surface-variant">Enterprise Suite</p>
            </div>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-surface-container-lowest shadow-soft overflow-hidden sm:rounded-xl border border-outline-variant">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
