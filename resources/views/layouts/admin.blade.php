<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin · Lady's On Go</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200">

<div class="drawer lg:drawer-open">
    <input id="drawer-admin" type="checkbox" class="drawer-toggle">

    <div class="drawer-content flex flex-col">
        {{-- Topbar --}}
        <header class="navbar bg-base-100 shadow-sm lg:hidden">
            <div class="flex-none">
                <label for="drawer-admin" class="btn btn-ghost btn-square">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </label>
            </div>
            <div class="flex-1 font-bold">Admin · Lady's On Go</div>
        </header>

        <main class="p-4 sm:p-6 lg:p-8">
            @if (session('status'))
                <div role="alert" class="alert alert-success mb-4">
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('contenido')
        </main>
    </div>

    {{-- Sidebar --}}
    <aside class="drawer-side z-40">
        <label for="drawer-admin" class="drawer-overlay"></label>
        <div class="bg-base-100 w-64 min-h-full flex flex-col border-r border-base-300">
            <div class="p-4 border-b border-base-300">
                <div class="font-bold text-lg bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">
                    Lady's On Go
                </div>
                <div class="text-xs text-base-content/60">Panel Administrativo</div>
            </div>

            <ul class="menu flex-1 p-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'menu-active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.usuarias') }}" class="{{ request()->routeIs('admin.usuarias') || request()->routeIs('admin.usuaria.*') ? 'menu-active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Usuarias
                    </a>
                </li>
            </ul>

            <div class="p-4 border-t border-base-300">
                <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                <div class="text-xs text-base-content/60 mb-3">{{ auth()->user()->email }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-ghost btn-sm w-full justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </aside>
</div>

</body>
</html>