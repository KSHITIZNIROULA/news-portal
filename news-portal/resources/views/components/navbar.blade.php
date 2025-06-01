<nav class="bg-white shadow-sm py-3 mb-6">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <!-- Logo/Brand -->
        <div class="flex items-center space-x-8">
            <a href="/" class="text-2xl font-bold text-gray-800 hover:text-blue-600 transition-colors">
                News Portal
            </a>
        </div>

        <!-- Main Navigation Links (center-aligned) -->
        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ route('articles.index') }}" class="text-gray-800 hover:text-blue-600 transition-colors font-medium">All Articles</a>

            <!-- Categories Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 text-gray-800 hover:text-blue-600 transition-colors font-medium focus:outline-none">
                    <span>Categories</span>
                    <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 py-1 z-50">
                    @foreach(\App\Models\Category::all() as $category)
                        <a href="{{ route('articles.index') }}?category={{ $category->id }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Portals Dropdown (for multi-portal support) -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 text-gray-800 hover:text-blue-600 transition-colors font-medium focus:outline-none">
                    <span>Portals</span>
                    <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 py-1 z-50">
                    @if(session('current_portal_id'))
                        @foreach(\App\Models\Portal::all() as $portal)
                            <a href="{{ route('switch.portal', $portal->id) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                {{ $portal->name }} {{ $portal->id === session('current_portal_id') ? '(Current)' : '' }}
                            </a>
                        @endforeach
                    @else
                        <span class="block px-4 py-2 text-sm text-gray-500">No portals available</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right-side actions -->
        <div class="flex items-center space-x-4">
            <!-- Search Icon -->
<!-- Replace your current search icon with this -->
<div class="relative" x-data="{ searchOpen: false }">
    <!-- Search Icon (toggles the input) -->
    <button @click="searchOpen = true" x-show="!searchOpen" class="text-gray-700 hover:text-blue-600 transition-colors focus:outline-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </button>

    <!-- Search Form (appears when clicked) -->
    <div x-show="searchOpen" @click.away="searchOpen = false" class="absolute right-0 mt-2 bg-white rounded-md shadow-lg z-50" x-transition>
        <form action="{{ route('articles.search') }}" method="GET" class="flex items-center">
            <input 
                type="text" 
                name="q" 
                placeholder="Search articles..." 
                class="py-2 px-4 w-64 rounded-l-md border-0 focus:ring-2 focus:ring-blue-500"
                x-ref="searchInput"
                x-on:keydown.escape="searchOpen = false"
                @click.stop
            >
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-r-md hover:bg-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </form>
    </div>
</div>

            <!-- User dropdown -->
            <div class="relative" x-data="{ open: false }">
                @auth
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
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
                        @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('admin.articles.index') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                Admin Dashboard
                            </a>
                        @endif
                        @if(Auth::user()->hasRole('publisher'))
                            <a href="{{ route('publisher.articles.dashboard') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                Publisher Dashboard
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                Sign out
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex space-x-3">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="md:hidden focus:outline-none" @click="mobileMenuOpen = !mobileMenuOpen">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden" x-data="{ mobileMenuOpen: false }" x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false">
        <div class="bg-white shadow-sm py-3">
            <div class="container mx-auto px-4 flex flex-col space-y-3">
                <a href="{{ route('articles.index') }}" class="text-gray-800 hover:text-blue-600 transition-colors font-medium">All Articles</a>
                
                <!-- Categories for Mobile -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-1 text-gray-800 hover:text-blue-600 transition-colors font-medium focus:outline-none">
                        <span>Categories</span>
                        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="mt-2 w-full bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 py-1">
                        @foreach(\App\Models\Category::all() as $category)
                            <a href="{{ route('articles.index') }}?category={{ $category->id }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Portals for Mobile -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-1 text-gray-800 hover:text-blue-600 transition-colors font-medium focus:outline-none">
                        <span>Portals</span>
                        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="mt-2 w-full bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 py-1">
                        @if(session('current_portal_id'))
                            @foreach(\App\Models\Portal::all() as $portal)
                                <a href="{{ route('switch.portal', $portal->id) }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    {{ $portal->name }} {{ $portal->id === session('current_portal_id') ? '(Current)' : '' }}
                                </a>
                            @endforeach
                        @else
                            <span class="block px-4 py-2 text-sm text-gray-500">No portals available</span>
                        @endif
                    </div>
                </div>

                <!-- Search Link for Mobile -->
<form action="{{ route('articles.search') }}" method="GET" class="px-4 py-2">
    <div class="flex items-center">
        <input 
            type="text" 
            name="q" 
            placeholder="Search articles..." 
            class="py-2 px-3 w-full rounded-l-md border border-gray-300 focus:ring-2 focus:ring-blue-500"
        >
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-r-md hover:bg-blue-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>
    </div>
</form>
            </div>
        </div>
    </div>
</nav>