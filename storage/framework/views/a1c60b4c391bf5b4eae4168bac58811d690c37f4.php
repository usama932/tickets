<?php if($errors->first() != ''): ?>
    <div class="container">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><?php echo e(trans('ticketit::lang.flash-x')); ?></span></button>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<?php if(Session::has('warning')): ?>
    <div class="container">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><?php echo e(trans('ticketit::lang.flash-x')); ?></span></button>
            <?php echo e(session('warning')); ?>

        </div>
    </div>
<?php endif; ?>
<?php if(Session::has('status')): ?>
    <div class="container">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><?php echo e(trans('ticketit::lang.flash-x')); ?></span></button>
            <?php echo e(session('status')); ?>

        </div>
    </div>
<?php endif; ?>
<?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/shared/errors.blade.php ENDPATH**/ ?>