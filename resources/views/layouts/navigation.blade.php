<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Klant Home link (Zichtbaar voor Klant en Admin) -->
                    @if(auth()->check() && in_array(strtolower(auth()->user()->rolename ?? ''), ['klant', 'admin']))
                        <x-nav-link :href="route('klant.index')" :active="request()->routeIs('klant.index')">
                            {{ __('Klant Home') }}
                        </x-nav-link>
                    @endif

                    <!-- Admin Home link (Alleen voor Admin) -->
                    @if(auth()->check() && strtolower(auth()->user()->rolename ?? '') === 'admin')
                        <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                            {{ __('Admin Home') }}
                        </x-nav-link>
                    @endif

                    <!-- Magazijn Home link (Alleen voor Magazijnmedewerker) -->
                    @if(auth()->check() && strtolower(auth()->user()->rolename ?? '') === 'magazijnmedewerker')
                        <x-nav-link :href="route('magazijnmedewerker.index')" :active="request()->routeIs('magazijnmedewerker.index')">
                            {{ __('Magazijn Home') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>