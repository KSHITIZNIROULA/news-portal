<?php $__env->startSection('content'); ?>
    <div class="container mx-auto p-6 max-w-6xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Manage Articles</h1>
            <a href="<?php echo e(route('admin.articles.create')); ?>"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-base">Create New Article</a>
        </div>
        <?php if($articles->isEmpty()): ?>
            <p class="text-center text-gray-500 text-lg py-6">No articles available at the moment.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse bg-white shadow rounded-lg text-base">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-3 text-left">Thumbnail</th>
                            <th class="p-3 text-left">Title</th>
                            <th class="p-3 text-left">Category</th>
                            <th class="p-3 text-left">Author</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Published At</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">
                                    <?php if($article->images->isNotEmpty()): ?>
                                        <img src="<?php echo e(asset('storage/' . $article->images->first()->path)); ?>"
                                            alt="<?php echo e($article->title); ?>" class="w-16 h-16 object-cover rounded">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400 text-sm">No Image</span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3">
                                    <a href="<?php echo e(route('articles.show', $article->slug)); ?>"
                                        class="text-blue-600 hover:underline font-medium">
                                        <?php echo e($article->title); ?>

                                    </a>
                                </td>
                                <td class="p-3"><?php echo e($article->category->name); ?></td>
                                <td class="p-3"><?php echo e($article->author->name); ?></td>
                                <td class="p-3">
                                    <span
                                        class="inline-block px-3 py-1 rounded text-sm font-semibold <?php echo e($article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                        <?php echo e(ucfirst($article->status)); ?>

                                    </span>
                                </td>
                                <td class="p-3">
                                    <?php echo e($article->published_at ? $article->published_at->format('M d, Y H:i') : 'N/A'); ?>

                                </td>
                                <td class="p-3 flex space-x-2">
                                    <a href="<?php echo e(route('articles.show', $article->slug)); ?>"
                                        class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300">View</a>
                                    <a href="<?php echo e(route('admin.articles.edit', $article)); ?>"
                                        class="bg-blue-200 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-300">Edit</a>
                                    <form action="<?php echo e(route('admin.articles.destroy', $article)); ?>" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                            class="bg-red-200 text-red-700 px-3 py-1 rounded text-sm hover:bg-red-300">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                <?php echo e($articles->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bishnulimbu/Desktop/coding/news-portal/news-portal/resources/views/admin/articleIndex.blade.php ENDPATH**/ ?>