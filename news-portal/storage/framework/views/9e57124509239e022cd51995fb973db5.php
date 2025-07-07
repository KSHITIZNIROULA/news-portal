<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="font-sans antialiased">
    <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-72 border-r border-gray-200 bg-white">
                <div class="flex items-center h-20 px-6 border-b border-gray-200">
                    <h1 class="text-xl font-semibold text-gray-800">Admin Panel</h1>
                </div>
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                        class="flex items-center px-5 py-3 text-base font-medium text-gray-700 bg-gray-100 rounded-lg group">
                        <svg class="w-6 h-6 mr-4 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <!-- Articles Dropdown -->
                    <div class="relative" x-data="{ open: true }">
                        <button @click="open = !open"
                            class="flex items-center justify-between w-full px-5 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 rounded-lg group"
                            aria-haspopup="true" :aria-expanded="open">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span>Articles</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-200"
                                :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition @click.away="open = false" class="ml-10 mt-2 space-y-2">
                            <a href="<?php echo e(route('admin.articles.index')); ?>"
                                class="block px-5 py-2.5 text-base text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">View
                                All Articles</a>
                            <a href="<?php echo e(route('admin.articles.create')); ?>"
                                class="block px-5 py-2.5 text-base text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">Create
                                New Article
                            </a>
                            <a href="<?php echo e(route('fake')); ?>"
                                class="block px-5 py-2.5 text-base text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                                Check Fake News
                            </a>
                        </div>
                    </div>
                    <!-- Other Links -->
                    <a href="<?php echo e(route('admin.publishers.index')); ?>"
                        class="flex items-center px-5 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 rounded-lg group">
                        <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Publishers
                    </a>
                    <a href="<?php echo e(route('admin.users.index')); ?>"
                        class="flex items-center px-5 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 rounded-lg group">
                        <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </a>
                    <a href="<?php echo e(route('admin.categories.index')); ?>"
                        class="flex items-center px-5 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 rounded-lg group">
                        <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Category Management
                    </a>
                    <a href="<?php echo e(route('admin.list')); ?>"
                        class="flex items-center px-5 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 rounded-lg group">
                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-600 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        Subscriptions
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <header class="flex items-center justify-between h-20 px-6 border-b border-gray-200 bg-white">
                <div class="flex items-center">
                    <button @click="open = !open" class="md:hidden text-gray-500 focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="ml-3 text-xl font-medium text-gray-900">Dashboard</h2>
                </div>
                <div class="relative" x-data="{ open: false }">
                    <?php if(auth()->guard()->check()): ?>
                        <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none group"
                            aria-haspopup="true" :aria-expanded="open">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                                <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                            </div>
                            <span class="text-base font-medium text-gray-700 group-hover:text-gray-900 transition-colors">
                                <?php echo e(Auth::user()->name); ?>

                            </span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition @click.away="open = false"
                            class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="w-full text-left px-5 py-3 text-base text-gray-700 hover:bg-gray-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
                <?php echo $__env->yieldContent('content'); ?>

            </main>
        </div>
    </div>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</body>
</html>
<?php /**PATH /home/bishnulimbu/Desktop/coding/news-portal/news-portal/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>