<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-4 py-6 min-h-[calc(100vh-8rem)]"> <!-- Added min-height -->
        <div class="max-w-7xl mx-auto"> <!-- Constrain content width -->
            <h1 class="text-2xl font-bold mb-6 text-gray-900 border-b border-gray-200 pb-2">All Articles</h1>
            
            <?php if($articles->isEmpty()): ?>
                <div class="text-center py-12"> <!-- Better empty state spacing -->
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No articles found</h3>
                    <p class="mt-1 text-gray-500">There are currently no published articles available.</p>
                </div>
            <?php else: ?>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 pb-8"> <!-- Added bottom padding -->
                    <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full"> <!-- Added flex-col h-full -->
                            <a href="<?php echo e(route('articles.show', $article->slug)); ?>" class="block flex-shrink-0">
                                <?php if($article->images->isNotEmpty()): ?>
                                    <div class="w-full h-48"> <!-- Increased height -->
                                        <img src="<?php echo e(asset('storage/' . $article->images->first()->path)); ?>" 
                                             alt="<?php echo e($article->title); ?>" 
                                             class="w-full h-full object-cover"
                                             loading="lazy">
                                    </div>
                                <?php else: ?>
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center"> <!-- Increased height -->
                                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="p-4 flex flex-col flex-grow"> <!-- flex-grow for content -->
                                <div class="flex items-center justify-between mb-3"> <!-- Better spacing -->
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
                                <p class="text-gray-700 text-sm mb-4 line-clamp-2 flex-grow"> <!-- flex-grow for content -->
                                    <?php echo e(\Illuminate\Support\Str::limit(strip_tags($article->content), 120)); ?>

                                </p>
                                <a href="<?php echo e(route('articles.show', $article->slug)); ?>" class="inline-flex items-center text-blue-600 text-sm font-medium hover:underline mt-auto"> <!-- mt-auto for bottom alignment -->
                                    Read more
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <div class="mt-8 pb-8"> <!-- Added bottom padding -->
                    <?php echo e($articles->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bishnulimbu/Desktop/coding/news-portal/news-portal/resources/views/article/index.blade.php ENDPATH**/ ?>