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
<body class="bg-background text-on-background font-sans antialiased">
    <!-- SideNavBar -->
    <nav class="hidden md:flex flex-col h-full p-stack-md gap-stack-sm bg-surface-container-lowest border-r border-outline-variant fixed left-0 top-0 w-[280px] z-40">
        <div class="flex items-center gap-stack-md px-stack-sm mb-stack-lg mt-stack-sm">
            <span class="material-symbols-outlined text-h1 text-primary">work</span>
            <div>
                <h1 class="text-h3 font-h3 text-primary">HR Portal</h1>
                <p class="text-label-sm font-label-sm text-on-surface-variant">Enterprise Suite</p>
            </div>
        </div>
        <div class="flex flex-col gap-unit">
            @if(auth()->user()->role === 'ADMIN')
                <a class="flex items-center gap-stack-md p-stack-sm {{ request()->routeIs('admin.dashboard') ? 'text-primary font-bold bg-secondary-container' : 'text-on-surface-variant hover:bg-surface-container-high' }} rounded-lg text-label-md font-label-md transition-colors" href="{{ route('admin.dashboard') }}">
                    <span class="material-symbols-outlined" style="{{ request()->routeIs('admin.dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
                    Dashboard Admin
                </a>
                <a class="flex items-center gap-stack-md p-stack-sm text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-lg text-label-md font-label-md" href="{{ route('admin.employees.index') }}">
                    <span class="material-symbols-outlined">badge</span>
                    Data Pegawai
                </a>
                <a class="flex items-center gap-stack-md p-stack-sm text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-lg text-label-md font-label-md" href="{{ route('admin.approvals.index') }}">
                    <span class="material-symbols-outlined">move_to_inbox</span>
                    Persetujuan Cuti
                </a>
                <a class="flex items-center gap-stack-md p-stack-sm text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-lg text-label-md font-label-md" href="{{ route('admin.leavetypes.index') }}">
                    <span class="material-symbols-outlined">calendar_month</span>
                    Jenis Cuti
                </a>
                <a class="flex items-center gap-stack-md p-stack-sm text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-lg text-label-md font-label-md" href="{{ route('admin.reports.index') }}">
                    <span class="material-symbols-outlined">assessment</span>
                    Laporan
                </a>
                <div class="my-2 border-t border-surface-container-highest"></div>
                <a class="flex items-center gap-stack-md p-stack-sm text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-lg text-label-md font-label-md" href="{{ route('admin.users.create-admin') }}">
                    <span class="material-symbols-outlined">shield_person</span>
                    Tambah Admin
                </a>
            @else
                <a class="flex items-center gap-stack-md p-stack-sm {{ request()->routeIs('employee.dashboard') ? 'text-primary font-bold bg-secondary-container' : 'text-on-surface-variant hover:bg-surface-container-high' }} rounded-lg text-label-md font-label-md transition-colors" href="{{ route('employee.dashboard') }}">
                    <span class="material-symbols-outlined" style="{{ request()->routeIs('employee.dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
                    Dashboard
                </a>
                <a class="flex items-center gap-stack-md p-stack-sm text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-lg text-label-md font-label-md" href="{{ route('employee.leave-requests.create') }}">
                    <span class="material-symbols-outlined">event_busy</span>
                    Pengajuan Cuti
                </a>
                <a class="flex items-center gap-stack-md p-stack-sm text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-lg text-label-md font-label-md" href="{{ route('employee.leave-requests.index') }}">
                    <span class="material-symbols-outlined">history</span>
                    Riwayat Cuti
                </a>
            @endif
        </div>
    </nav>

    <!-- TopNavBar -->
    <header class="fixed top-0 right-0 w-full md:w-[calc(100%-280px)] h-16 bg-surface border-b border-outline-variant shadow-sm flex justify-between items-center px-margin-mobile md:px-margin-desktop z-30">
        <div class="flex items-center gap-stack-md">
            <button class="md:hidden text-on-surface"><span class="material-symbols-outlined">menu</span></button>
            <h2 class="text-h2 font-h2 font-bold text-primary hidden md:block">HR Portal</h2>
        </div>
        <div class="flex items-center gap-stack-lg">
            <div class="flex items-center gap-stack-md">
                @if(auth()->user()->role === 'EMPLOYEE')
                <a href="{{ route('employee.leave-requests.create') }}" class="bg-primary-container text-on-primary-container px-stack-md py-2 rounded-lg text-label-md font-label-md hover:opacity-80 transition-opacity hidden sm:block">
                    Pengajuan Baru
                </a>
                @endif
                <div class="flex items-center gap-2">
                    <div class="text-right hidden sm:block">
                        <p class="text-label-md font-bold text-on-surface">{{ auth()->user()->name }}</p>
                        <p class="text-label-sm text-on-surface-variant">{{ auth()->user()->role }}</p>
                    </div>
                    <!-- Dropdown for Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="ml-4">
                        @csrf
                        <button type="submit" class="text-on-surface-variant hover:text-error transition-colors p-unit rounded-full hover:bg-surface-container-high" title="Logout">
                            <span class="material-symbols-outlined">logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="ml-0 md:ml-[280px] pt-[88px] pb-margin-desktop px-margin-mobile md:px-margin-desktop min-h-screen">
        {{ $slot }}
    </main>
</body>
</html>
