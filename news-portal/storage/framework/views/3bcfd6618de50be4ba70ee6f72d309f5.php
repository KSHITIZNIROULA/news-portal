<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-4 py-6 max-w-7xl">
        <!-- Search Form -->
        <div class="mb-8">
            <form action="<?php echo e(route('articles.search')); ?>" method="GET" class="max-w-2xl mx-auto">
                <div class="relative flex items-center">
                    <input 
                        type="text" 
                        name="q" 
                        value="<?php echo e($query ?? ''); ?>" 
                        placeholder="Search articles by title, content, category or author..." 
                        class="w-full border border-gray-300 rounded-lg px-5 py-3 pr-12 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        autocomplete="off"
                        autofocus
                    >
                    <button 
                        type="submit" 
                        class="absolute right-3 text-gray-500 hover:text-blue-600 transition-colors"
                        aria-label="Search"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
                <?php if($query): ?>
                    <p class="mt-2 text-sm text-gray-500">
                        Showing <?php echo e($articles->total()); ?> result<?php echo e($articles->total() === 1 ? '' : 's'); ?> for "<?php echo e($query); ?>"
                    </p>
                <?php endif; ?>
            </form>
        </div>

        <!-- Search Results -->
        <?php if($query): ?>
            <h1 class="text-2xl font-bold mb-6 text-gray-900">
                Search Results for "<?php echo e($query); ?>"
            </h1>
        <?php else: ?>
            <h1 class="text-2xl font-bold mb-6 text-gray-900">
                Browse All Articles
            </h1>
        <?php endif; ?>

        <?php if($articles->isEmpty()): ?>
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No articles found</h3>
                <p class="mt-1 text-gray-500">
                    <?php if($query): ?>
                        Try different search terms or browse our <a href="<?php echo e(route('articles.index')); ?>" class="text-blue-600 hover:underline">article collection</a>.
                    <?php else: ?>
                        There are currently no published articles available.
                    <?php endif; ?>
                </p>
            </div>
        <?php else: ?>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="flex flex-col bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden h-full">
                        <a href="<?php echo e(route('articles.show', $article->slug)); ?>" class="block">
                            <?php if($article->images->isNotEmpty()): ?>
                                <div class="w-full h-48">
                                    <img 
                                        src="<?php echo e(asset('storage/' . $article->images->first()->path)); ?>" 
                                        alt="<?php echo e($article->title); ?>" 
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                    >
                                </div>
                            <?php else: ?>
                                <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="p-4 flex flex-col flex-grow">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full">
                                    <?php echo e($article->category ? $article->category->name : 'Uncategorized'); ?>

                                </span>
                                <time datetime="<?php echo e($article->published_at); ?>" class="text-gray-500 text-xs">
                                    <?php echo e($article->published_at ? $article->published_at->format('M d, Y') : 'Draft'); ?>

                                </time>
                            </div>
                            <h2 class="text-lg font-semibold mb-2 leading-tight">
                                <a href="<?php echo e(route('articles.show', $article->slug)); ?>" class="text-gray-900 hover:text-blue-600 transition-colors">
                                    <?php echo e($article->title); ?>

                                </a>
                            </h2>
                            <p class="text-gray-600 text-sm mb-3">
                                By <?php echo e($article->author ? $article->author->name : 'Unknown Author'); ?>

                            </p>
                            <p class="text-gray-700 text-sm mb-4 line-clamp-2 flex-grow">
                                <?php echo e(\Illuminate\Support\Str::limit(strip_tags($article->content), 120)); ?>

                            </p>
                            <a href="<?php echo e(route('articles.show', $article->slug)); ?>" class="inline-flex items-center text-blue-600 text-sm font-medium hover:underline mt-auto">
                                Read more
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                <?php echo e($articles->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bishnulimbu/Desktop/coding/news-portal/news-portal/resources/views/article/search.blade.php ENDPATH**/ ?>