<nav class="bg-white shadow-sm py-3 mb-6">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <!-- Logo/Brand placeholder -->
        <div class="flex items-center space-x-8">
            {{-- <a href="{{ route('home') }}" class="text-gray-800 hover:text-blue-600 transition-colors font-medium">Home</a> --}}
        </div>

        <!-- Main Navigation Links (center-aligned) -->
        <div class="md:flex space-x-6">
            <a href="{{ route('articles.index') }}" class=" hover:text-blue-600 transition-colors font-medium">Articles</a>
        </div>

        <!-- Right-side actions -->
        <div class="flex items-center space-x-4">
            {{-- Create buttons --}}
            <div class="hidden md:flex space-x-3">
                {{-- <x-createRouteNav routeName="forms" class="btn-secondary">New Form</x-createRouteNav>
                <x-createRouteNav routeName="todos" class="btn-secondary">New Todo</x-createRouteNav> --}}
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
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                Sign out
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex space-x-3">
                        <a href="{{ route('login') }}" class="hover:text-black/50">Log in</a>
                        <a href="{{ route('register') }}" class="hover:text-black/50">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>