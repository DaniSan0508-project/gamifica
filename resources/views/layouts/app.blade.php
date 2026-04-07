<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-surface text-on-surface">
        <div class="min-h-screen" x-data="{ open: false }">
            <!-- Navigation -->
            <nav class="bg-surface-lowest shadow-sm relative z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <span class="text-2xl font-display font-bold text-primary-500 tracking-tighter">Gamifica</span>
                            </div>

                            <!-- Desktop Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex font-label">
                                @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-semibold leading-5 transition duration-150 ease-in-out">
                                        {{ __('Dashboard') }}
                                    </a>
                                    <a href="{{ route('admin.missions.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.missions.*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-semibold leading-5 transition duration-150 ease-in-out">
                                        {{ __('Missões') }}
                                    </a>
                                    <a href="{{ route('admin.rewards.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.rewards.*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-semibold leading-5 transition duration-150 ease-in-out">
                                        {{ __('Loja') }}
                                    </a>
                                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.orders.*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-semibold leading-5 transition duration-150 ease-in-out">
                                        {{ __('Pedidos') }}
                                    </a>
                                    <a href="{{ route('admin.feedbacks.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.feedbacks.*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-semibold leading-5 transition duration-150 ease-in-out">
                                        {{ __('Kudos') }}
                                    </a>
                                @else
                                    <a href="{{ route('player.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('player.dashboard') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-semibold leading-5 transition duration-150 ease-in-out">
                                        {{ __('Início') }}
                                    </a>
                                    <a href="{{ route('player.shop.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('player.shop.index') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-semibold leading-5 transition duration-150 ease-in-out">
                                        {{ __('Loja') }}
                                    </a>
                                    <a href="{{ route('player.orders.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('player.orders.index') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-semibold leading-5 transition duration-150 ease-in-out">
                                        {{ __('Meus Resgates') }}
                                    </a>
                                    <a href="{{ route('player.feedbacks.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('player.feedbacks.*') ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-semibold leading-5 transition duration-150 ease-in-out">
                                        {{ __('Meus Kudos') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- User Profile & Logout (Desktop) -->
                        <div class="hidden sm:flex sm:items-center space-x-4">
                            <a href="{{ route('profile') }}" class="flex items-center group">
                                @if (auth()->user()->avatar_path)
                                    <img class="h-8 w-8 rounded-full object-cover mr-2 group-hover:opacity-80 transition-opacity" src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="{{ auth()->user()->name }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-display font-bold uppercase mr-2 group-hover:bg-primary-200 transition-colors">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-on-surface font-label font-bold group-hover:text-primary-500 transition-colors">{{ auth()->user()->name }}</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-red-500 font-label font-semibold transition-colors" title="Sair">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </button>
                            </form>
                        </div>

                        <!-- Hamburger (Mobile) -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-primary-500 hover:bg-surface-low focus:outline-none transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu (Mobile) -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-surface-lowest border-t border-surface-low shadow-ambient">
                    <div class="pt-2 pb-3 space-y-1 px-4">
                        @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                            <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold {{ request()->routeIs('admin.dashboard') ? 'bg-primary-500/5 text-primary-600' : 'text-gray-600 hover:bg-surface-low' }}">
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('admin.missions.index') }}" class="block pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold {{ request()->routeIs('admin.missions.*') ? 'bg-primary-500/5 text-primary-600' : 'text-gray-600 hover:bg-surface-low' }}">
                                {{ __('Missões') }}
                            </a>
                            <a href="{{ route('admin.rewards.index') }}" class="block pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold {{ request()->routeIs('admin.rewards.*') ? 'bg-primary-500/5 text-primary-600' : 'text-gray-600 hover:bg-surface-low' }}">
                                {{ __('Loja') }}
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="block pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold {{ request()->routeIs('admin.orders.*') ? 'bg-primary-500/5 text-primary-600' : 'text-gray-600 hover:bg-surface-low' }}">
                                {{ __('Pedidos') }}
                            </a>
                            <a href="{{ route('admin.feedbacks.index') }}" class="block pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold {{ request()->routeIs('admin.feedbacks.*') ? 'bg-primary-500/5 text-primary-600' : 'text-gray-600 hover:bg-surface-low' }}">
                                {{ __('Kudos') }}
                            </a>
                        @else
                            <a href="{{ route('player.dashboard') }}" class="block pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold {{ request()->routeIs('player.dashboard') ? 'bg-primary-500/5 text-primary-600' : 'text-gray-600 hover:bg-surface-low' }}">
                                {{ __('Início') }}
                            </a>
                            <a href="{{ route('player.shop.index') }}" class="block pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold {{ request()->routeIs('player.shop.index') ? 'bg-primary-500/5 text-primary-600' : 'text-gray-600 hover:bg-surface-low' }}">
                                {{ __('Loja') }}
                            </a>
                            <a href="{{ route('player.orders.index') }}" class="block pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold {{ request()->routeIs('player.orders.index') ? 'bg-primary-500/5 text-primary-600' : 'text-gray-600 hover:bg-surface-low' }}">
                                {{ __('Meus Resgates') }}
                            </a>
                            <a href="{{ route('player.feedbacks.index') }}" class="block pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold {{ request()->routeIs('player.feedbacks.*') ? 'bg-primary-500/5 text-primary-600' : 'text-gray-600 hover:bg-surface-low' }}">
                                {{ __('Meus Kudos') }}
                            </a>
                        @endif
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-surface-low bg-surface-low/30">
                        <div class="px-7 py-3 flex items-center">
                            <a href="{{ route('profile') }}" class="flex items-center">
                                @if (auth()->user()->avatar_path)
                                    <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="{{ auth()->user()->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-display font-bold uppercase mr-3">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-label font-bold text-base text-on-surface">{{ auth()->user()->name }}</div>
                                    <div class="font-sans font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                            </a>
                        </div>

                        <div class="mt-3 space-y-1 px-4 pb-4">
                            <a href="{{ route('profile') }}" class="block w-full text-left pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold text-gray-600 hover:bg-surface-low transition-colors">
                                {{ __('Meu Perfil') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left pl-3 pr-4 py-3 rounded-xl text-base font-label font-bold text-red-500 hover:bg-red-50 transition-colors">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-surface-low/80 backdrop-blur-md sticky top-0 z-40">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
