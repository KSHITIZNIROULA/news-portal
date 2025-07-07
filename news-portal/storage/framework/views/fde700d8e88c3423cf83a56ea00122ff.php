<?php $__env->startSection('content'); ?>
    <div class="container mx-auto p-4 max-w-lg">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Create New Article</h1>
        
    

        <form action="<?php echo e(route('publisher.articles.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="block text-gray-700 font-medium text-sm mb-1">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                    value="<?php echo e(old('title')); ?>" 
                    required 
                    placeholder="Enter article title"
                >
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Content -->
            <div class="mb-3">
                <label for="content" class="block text-gray-700 font-medium text-sm mb-1">Content</label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="8" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                    required 
                    placeholder="Write your article content here..."
                ><?php echo e(old('content')); ?></textarea>
                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category_id" class="block text-gray-700 font-medium text-sm mb-1">Category</label>
                <select 
                    name="category_id" 
                    id="category_id" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                    <option value="" <?php echo e(old('category_id') ? '' : 'selected'); ?> disabled>Select a category</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="block text-gray-700 font-medium text-sm mb-1">Status</label>
                <select 
                    name="status" 
                    id="status" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                >
                    <option value="draft" <?php echo e(old('status', 'draft') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                    <option value="published" <?php echo e(old('status') == 'published' ? 'selected' : ''); ?>>Published</option>
                </select>
                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Publish Date -->
            <div class="mb-3">
                <label for="published_at" class="block text-gray-700 font-medium text-sm mb-1">Publish Date (Optional)</label>
                <input 
                    type="datetime-local" 
                    name="published_at" 
                    id="published_at" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                    value="<?php echo e(old('published_at') ? old('published_at') : now()->format('Y-m-d\TH:i')); ?>"
                >
                <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p class="text-gray-500 text-xs mt-1">Leave blank for drafts or set to current/future date for published articles.</p>
            </div>

            <!-- Exclusive Checkbox -->
            <div class="mb-3">
                <label for="is_exclusive" class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_exclusive" 
                        id="is_exclusive" 
                        value="1" 
                        class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                        <?php echo e(old('is_exclusive') ? 'checked' : ''); ?>

                    >
                    <span class="text-gray-700 font-medium text-sm">Mark as Exclusive (Subscribers Only)</span>
                </label>
                <?php $__errorArgs = ['is_exclusive'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p class="text-gray-500 text-xs mt-1">Exclusive articles are only visible to your subscribers or admins.</p>
            </div>

            <!-- Images -->
            <div class="mb-3">
                <label for="images" class="block text-gray-700 font-medium text-sm mb-1">Images (Optional, max 5MB each)</label>
                <input 
                    type="file" 
                    name="images[]" 
                    id="images" 
                    class="w-full border rounded p-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                    multiple 
                    accept="image/jpeg,image/png"
                >
                <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p class="text-gray-500 text-xs mt-1">Upload up to 3 images (JPEG, PNG, max 5MB each).</p>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-2">
                <a href="<?php echo e(route('publisher.articles.dashboard')); ?>" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded hover:bg-gray-300 text-sm transition-colors">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 text-sm transition-colors">Create Article</button>
            </div>
        </form>
    </div>

<script>
    document.getElementById('status').addEventListener('change', function () {
        if (this.value === 'published') {
            const input = document.getElementById('published_at');
            if (!input.value) {
                const now = new Date();
                input.value = now.toISOString().slice(0, 16);
            }
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.publisher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bishnulimbu/Desktop/coding/news-portal/news-portal/resources/views/publisher/articleCreate.blade.php ENDPATH**/ ?>