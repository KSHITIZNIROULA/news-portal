<?php $__env->startSection('content'); ?>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Welcome, <?php echo e(Auth::user()->name); ?>

                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>You're logged in as
                                    <?php echo e(Auth::user()->hasRole('admin') ? 'an admin' : 'a publisher'); ?>.</p>
                            </div>
                        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bishnulimbu/Desktop/coding/news-portal/news-portal/resources/views/dashboard.blade.php ENDPATH**/ ?>