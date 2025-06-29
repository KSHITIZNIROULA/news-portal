<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Publisher Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    <style>
        .sidebar {
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 50;
                height: 100vh;
                transform: translateX(-100%);
            }

            .sidebar-open {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Mobile Menu Button (hidden on desktop) -->
    <button id="mobileMenuButton" class="md:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-md shadow">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <div id="sidebar" class="sidebar w-64 bg-white shadow-md flex-shrink-0">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800">Publisher Portal</h1>
            </div>
            <nav class="flex flex-col h-[calc(100%-65px)]">
                <div class="flex-1 overflow-y-auto">
                    <a href="{{ route('publisher.articles.dashboard') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('publisher.articles.dashboard') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('publisher.articles.create') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('publisher.articles.create') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Create Article
                    </a>
                    <a href="{{ route('subscribers.list') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    Subscribers List
                    </a>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-auto border-t border-gray-200">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-3 text-left text-gray-700 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <h2 class="text-lg font-semibold text-gray-800">
                            @yield('page-title', 'Dashboard')
                        </h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                                alt="User" class="w-8 h-8 rounded-full">
                            <div class="relative p-2" x-data="{ open: false }">
                                @auth
                                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                        <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                                        <svg class="w-4 h-4 text-gray-500 transition-transform"
                                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 py-1 z-50">
                                        <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                            <div>Logged in as</div>
                                            <div class="font-medium">{{ Auth::user()->email }}</div>
                                        </div>
                                        @if (Auth::user()->hasRole('admin'))
                                            <a href="{{ route('admin.articles.index') }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                Admin Dashboard
                                            </a>
                                        @endif
                                        @if (Auth::user()->hasRole('publisher'))
                                            <a href="{{ route('publisher.articles.dashboard') }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                Publisher Dashboard
                                            </a>
                                        @endif
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="flex space-x-3">
                                        <a href="{{ route('login') }}"
                                            class="text-gray-700 font-bold hover:text-blue-600 transition-colors">Log
                                            in</a>
                                        <a href="{{ route('register') }}"
                                            class="text-gray-700 font-bold hover:text-blue-600 transition-colors">Register</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="container mx-auto p-4 md:p-6">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @include('components.alerts')
    <!-- Mobile Menu Toggle Script -->
    <script>
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('sidebar-open');
        });
    </script>
</body>

</html>
