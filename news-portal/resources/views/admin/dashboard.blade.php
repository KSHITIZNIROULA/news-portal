<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="flex items-center h-16 px-4 border-b border-gray-200">
                    <h1 class="text-lg font-semibold text-gray-800">Admin Panel</h1>
                </div>
                <nav class="flex-1 px-2 py-4 space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md group">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <div>
                        <div class="relative" x-data="{ open: false }">
    <button @click="open = !open" 
            class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md group"
            aria-haspopup="true"
            :aria-expanded="open">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <span>Articles</span>
        </div>
        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
             :class="{ 'rotate-90': open }" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.away="open = false"
         class="ml-8 mt-1 space-y-1">
        <!-- List Articles -->
        <a href="{{ route('admin.articles.index') }}" 
           class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-md transition-colors">
            View All Articles
        </a>
        
        <!-- Create Article -->
        <a href="{{ route('admin.articles.create') }}" 
           class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-md transition-colors">
            Create New Article
        </a>
        
        <!-- Categories (optional) -->
        <a href="{{ route('admin.categories.index')}}" 
           class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-md transition-colors">
            Manage Categories
        </a>
        
        <!-- Drafts (optional) -->
        <a href="{{ route('admin.articles.index', ['status' => 'draft']) }}" 
           class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-md transition-colors">
            View Drafts
        </a>
    </div>
</div>
                    </div>
                    <a href="#"
                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md group">
                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Publishers
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md group">
                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md group">
                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <header class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-white">
                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <button @click="open = !open" class="md:hidden text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="ml-2 text-lg font-medium text-gray-900">Dashboard</h2>
                </div>
                <div class="relative" x-data="{ open: false }">
                    @auth
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none group"
                            aria-haspopup="true" :aria-expanded="open">
                            <!-- User avatar placeholder (can replace with actual avatar) -->
                            <div
                                class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">
                                {{ Auth::user()->name }}
                            </span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95" @click.away="open = false"
                            @keydown.escape.window="open = false"
                            class="absolute right-0 mt-2 w-56 origin-top-right bg-white rounded-lg shadow-lg ring-1 ring-gray-100 focus:outline-none z-50 divide-y divide-gray-100"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                            tabindex="-1">

                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-500" role="none">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                    {{ Auth::user()->email }}</p>
                            </div>

                            <div class="py-1" role="none">
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                                    role="menuitem">
                                    Your Profile
                                </a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                                    role="menuitem">
                                    Settings
                                </a>
                            </div>

                            <div class="py-1" role="none">
                                <form method="POST" action="{{ route('logout') }}" role="none">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                                        role="menuitem">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-auto p-4 bg-gray-50">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="mt-5">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
