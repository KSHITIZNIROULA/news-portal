<?php $__env->startSection('content'); ?>
    <div class="container mx-auto p-4 max-w-lg">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Edit Article</h1>

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

        <form action="<?php echo e(route('publisher.articles.update', $article)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

<?php if($errors->any()): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded mb-4 text-sm">
        <strong class="block mb-1">Please fix the following errors:</strong>
        <ul class="list-disc list-inside text-sm">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
            <!-- Title -->
            <div class="mb-4">
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
                    value="<?php echo e(old('title', $article->title)); ?>" 
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
            <div class="mb-4">
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
                ><?php echo e(old('content', $article->content)); ?></textarea>
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
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-medium text-sm mb-1">Category (Optional)</label>
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
                    <option value="" <?php echo e(old('category_id', $article->category_id) ? '' : 'selected'); ?>>No category</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $article->category_id) == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
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
            <div class="mb-4">
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
                    required
                >
                    <option value="draft" <?php echo e(old('status', $article->status) == 'draft' ? 'selected' : ''); ?>>Draft</option>
                    <option value="published" <?php echo e(old('status', $article->status) == 'published' ? 'selected' : ''); ?>>Published</option>
                </select>
                <?php $__errorArgs = ['status'];
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

            <!-- Publish Date -->
            <div class="mb-4">
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
                    value="<?php echo e(old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '')); ?>"
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
            <div class="mb-4">
                <label for="is_exclusive" class="block text-gray-700 font-medium text-sm mb-1">Exclusive (Subscriber-Only)</label>
                <input 
                    type="checkbox" 
                    name="is_exclusive" 
                    id="is_exclusive" 
                    value="1" 
                    class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                    <?php echo e(old('is_exclusive', $article->is_exclusive) ? 'checked' : ''); ?>

                >
                <span class="text-gray-600 text-sm">Check to make this article exclusive to subscribers.</span>
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
            </div>

            <!-- Images -->
            <div class="mb-4">
                <label for="images" class="block text-gray-700 font-medium text-sm mb-1">Add Images (Optional, Max 3)</label>
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
                <p class="text-gray-500 text-xs mt-1">Upload up to 3 images (JPEG/PNG, max 5MB each).</p>
                <?php if($article->images->count() > 0): ?>
                    <div class="mt-3">
                        <p class="text-gray-700 text-sm mb-2">Existing Images:</p>
                        <div class="flex flex-wrap gap-3" id="image-previews">
                            <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="relative" data-image-path="<?php echo e($image->path); ?>">
                                    <img src="<?php echo e(asset('storage/' . $image->path)); ?>" alt="Article Image" class="w-20 h-20 object-cover rounded border">
                                    <button 
                                        type="button" 
                                        onclick="removeImage('<?php echo e($image->path); ?>', this)" 
                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600"
                                    >×</button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        
                    </div>
                <?php endif; ?>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-2">
                <a href="<?php echo e(route('publisher.articles.dashboard')); ?>" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded hover:bg-gray-300 text-sm transition-colors">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 text-sm transition-colors">Update Article</button>
            </div>
        </form>
    </div>

    <script>
        function removeImage(path, button) {
            if (confirm('Are you sure you want to remove this image?')) {
                // Create a new hidden input for the removed image path
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_images[]';
                input.value = path;
                document.querySelector('form').appendChild(input);

                // Remove the image preview
                button.closest('[data-image-path]').remove();
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.publisher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bishnulimbu/Desktop/coding/news-portal/news-portal/resources/views/publisher/articleEdit.blade.php ENDPATH**/ ?>