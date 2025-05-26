<?php $__env->startSection('content'); ?>
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-2xl font-bold mb-4 text-gray-900">Publisher Dashboard</h1>

        <!-- Success/Error Messages -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded mb-4 text-sm">
                <?php echo e(session('success')); ?>

            </div>
        <?php elseif(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded mb-4 text-sm">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800">Total Articles</h2>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($totalArticles); ?></p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800">Published Articles</h2>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($publishedArticles); ?></p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800">Exclusive Articles</h2>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($exclusiveArticles); ?></p>
            </div>
        </div>

        <!-- Articles Table -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Your Articles</h2>
            <a href="<?php echo e(route('publisher.articles.create')); ?>" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 text-sm transition-colors">Create New Article</a>
        </div>

        <?php if($articles->isEmpty()): ?>
            <div class="text-center py-8 bg-white rounded-lg shadow-sm">
                <p class="text-gray-500 text-sm mb-2">You haven't created any articles yet.</p>
                <a href="<?php echo e(route('publisher.articles.create')); ?>" class="text-blue-600 text-sm hover:underline">Start by creating your first article!</a>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto bg-white shadow-sm rounded-lg">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-3 text-left font-semibold">Title</th>
                            <th class="p-3 text-left font-semibold">Category</th>
                            <th class="p-3 text-left font-semibold">Status</th>
                            <th class="p-3 text-left font-semibold">Exclusive</th>
                            <th class="p-3 text-left font-semibold">Published At</th>
                            <th class="p-3 text-left font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">
                                    <a href="<?php echo e(route('publisher.articles.show', $article)); ?>" class="text-blue-600 hover:underline"><?php echo e($article->title); ?></a>
                                    <?php if($article->images->isNotEmpty()): ?>
                                        <img src="<?php echo e(asset('storage/' . $article->images->first()->path)); ?>" alt="Thumbnail" class="w-12 h-12 object-cover inline-block ml-2 rounded">
                                    <?php endif; ?>
                                </td>
                                <td class="p-3"><?php echo e($article->category ? $article->category->name : 'Uncategorized'); ?></td>
                                <td class="p-3">
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold <?php echo e($article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                        <?php echo e(ucfirst($article->status)); ?>

                                    </span>
                                </td>
                                <td class="p-3">
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold <?php echo e($article->is_exclusive ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'); ?>">
                                        <?php echo e($article->is_exclusive ? 'Yes' : 'No'); ?>

                                    </span>
                                </td>
                                <td class="p-3"><?php echo e($article->published_at ? $article->published_at->format('M d, Y H:i') : 'Draft'); ?></td>
                                <td class="p-3 flex space-x-2">
                                    <a href="<?php echo e(route('publisher.articles.show', $article)); ?>" class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs hover:bg-gray-300 transition-colors" title="View article">View</a>
                                    <a href="<?php echo e(route('publisher.articles.edit', $article)); ?>" class="bg-blue-200 text-blue-700 px-2 py-1 rounded text-xs hover:bg-blue-300 transition-colors" title="Edit article">Edit</a>
                                    <form action="<?php echo e(route('publisher.articles.destroy', $article)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="bg-red-200 text-red-700 px-2 py-1 rounded text-xs hover:bg-red-300 transition-colors" title="Delete article">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <?php echo e($articles->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.publisher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bishnulimbu/Desktop/coding/news-portal/news-portal/resources/views/publisher/dashboard.blade.php ENDPATH**/ ?>