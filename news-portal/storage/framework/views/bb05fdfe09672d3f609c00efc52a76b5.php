<!-- resources/views/publisher/articleShow.blade.php -->


<?php $__env->startSection('content'); ?>
    <div class="container mx-auto p-4 max-w-3xl">
        <h1 class="text-3xl font-bold mb-4 text-gray-900"><?php echo e($article->title); ?></h1>
        <div class="flex items-center mb-4 text-sm text-gray-600">
            <span>Category: <?php echo e($article->category->name); ?></span>
            <span class="mx-2">•</span>
            <span>Status: 
                <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold <?php echo e($article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                    <?php echo e(ucfirst($article->status)); ?>

                </span>
            </span>
            <span class="mx-2">•</span>
            <span>Published: <?php echo e($article->published_at ? $article->published_at->format('M d, Y H:i') : 'N/A'); ?></span>
        </div>
        
        <?php if($article->images->count() > 0): ?>
            <div class="mb-4">
                <h2 class="text-lg font-semibold mb-2 text-gray-800">Images</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/' . $image->path)); ?>" alt="<?php echo e($article->title); ?> Image" class="w-full h-48 object-cover rounded-lg shadow-md">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="prose max-w-none mb-4">
            <?php echo $article->content; ?>

        </div>

        <div class="flex space-x-4">
            <a href="<?php echo e(route('publisher.articles.dashboard')); ?>" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded hover:bg-gray-300 text-sm">Back to Dashboard</a>
            <a href="<?php echo e(route('publisher.articles.edit', $article)); ?>" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 text-sm">Edit</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.publisher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bishnulimbu/Desktop/coding/news-portal/news-portal/resources/views/publisher/articleShow.blade.php ENDPATH**/ ?>