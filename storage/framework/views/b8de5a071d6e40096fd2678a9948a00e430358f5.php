<?php $__env->startSection('page', trans('ticketit::lang.create-ticket-title')); ?>
<?php $__env->startSection('page_title', trans('ticketit::lang.create-new-ticket')); ?>

<?php $__env->startSection('ticketit_content'); ?>
    <?php echo CollectiveForm::open([
                    'route'=>$setting->grab('main_route').'.store',
                    'method' => 'POST'
                    ]); ?>

        <div class="form-group row">
            <?php echo CollectiveForm::label('subject', trans('ticketit::lang.subject') . trans('ticketit::lang.colon'), ['class' => 'col-lg-2 col-form-label']); ?>

            <div class="col-lg-10">
                <?php echo CollectiveForm::text('subject', null, ['class' => 'form-control', 'required' => 'required']); ?>

                <small class="form-text text-muted"><?php echo trans('ticketit::lang.create-ticket-brief-issue'); ?></small>
            </div>
        </div>
        <div class="form-group row">
            <?php echo CollectiveForm::label('content', trans('ticketit::lang.description') . trans('ticketit::lang.colon'), ['class' => 'col-lg-2 col-form-label']); ?>

            <div class="col-lg-10">
                <?php echo CollectiveForm::textarea('content', null, ['class' => 'form-control summernote-editor', 'rows' => '5', 'required' => 'required']); ?>

                <small class="form-text text-muted"><?php echo trans('ticketit::lang.create-ticket-describe-issue'); ?></small>
            </div>
        </div>
        <div class="form-row mt-5">
            <div class="form-group col-lg-4 row">
                <?php echo CollectiveForm::label('priority', trans('ticketit::lang.priority') . trans('ticketit::lang.colon'), ['class' => 'col-lg-6 col-form-label']); ?>

                <div class="col-lg-6">
                    <?php echo CollectiveForm::select('priority_id', $priorities, null, ['class' => 'form-control', 'required' => 'required']); ?>

                </div>
            </div>
            <div class="form-group offset-lg-1 col-lg-4 row">
                <?php echo CollectiveForm::label('category', trans('ticketit::lang.category') . trans('ticketit::lang.colon'), ['class' => 'col-lg-6 col-form-label']); ?>

                <div class="col-lg-6">
                    <?php echo CollectiveForm::select('category_id', $categories, null, ['class' => 'form-control', 'required' => 'required']); ?>

                </div>
            </div>
            <?php echo CollectiveForm::hidden('agent_id', 'auto'); ?>

        </div>
        <br>
        <div class="form-group row">
            <div class="col-lg-10 offset-lg-2">
                <?php echo link_to_route($setting->grab('main_route').'.index', trans('ticketit::lang.btn-back'), null, ['class' => 'btn btn-link']); ?>

                <?php echo CollectiveForm::submit(trans('ticketit::lang.btn-submit'), ['class' => 'btn btn-primary']); ?>

            </div>
        </div>
    <?php echo CollectiveForm::close(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('ticketit::tickets.partials.summernote', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->appendSection(); ?>
<?php echo $__env->make('ticketit::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/tickets/create.blade.php ENDPATH**/ ?>