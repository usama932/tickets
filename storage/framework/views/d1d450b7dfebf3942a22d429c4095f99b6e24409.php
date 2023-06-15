<?php $__env->startSection('page', trans('ticketit::lang.index-title')); ?>
<?php $__env->startSection('page_title', trans('ticketit::lang.index-my-tickets')); ?>


<?php $__env->startSection('ticketit_header'); ?>
<?php echo link_to_route($setting->grab('main_route').'.create', trans('ticketit::lang.btn-create-new-ticket'), null, ['class' => 'btn btn-primary']); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('ticketit_content_parent_class', 'pl-0 pr-0'); ?>

<?php $__env->startSection('ticketit_content'); ?>
    <div id="message"></div>
    <?php echo $__env->make('ticketit::tickets.partials.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<script src="https://cdn.datatables.net/v/bs4/dt-<?php echo e(Kordy\Ticketit\Helpers\Cdn::DataTables); ?>/r-<?php echo e(Kordy\Ticketit\Helpers\Cdn::DataTablesResponsive); ?>/datatables.min.js"></script>
	<script>
	    $('.table').DataTable({
	        processing: false,
	        serverSide: true,
	        responsive: true,
            pageLength: <?php echo e($setting->grab('paginate_items')); ?>,
        	lengthMenu: <?php echo e(json_encode($setting->grab('length_menu'))); ?>,
	        ajax: '<?php echo route($setting->grab('main_route').'.data', $complete); ?>',
	        language: {
				decimal:        "<?php echo e(trans('ticketit::lang.table-decimal')); ?>",
				emptyTable:     "<?php echo e(trans('ticketit::lang.table-empty')); ?>",
				info:           "<?php echo e(trans('ticketit::lang.table-info')); ?>",
				infoEmpty:      "<?php echo e(trans('ticketit::lang.table-info-empty')); ?>",
				infoFiltered:   "<?php echo e(trans('ticketit::lang.table-info-filtered')); ?>",
				infoPostFix:    "<?php echo e(trans('ticketit::lang.table-info-postfix')); ?>",
				thousands:      "<?php echo e(trans('ticketit::lang.table-thousands')); ?>",
				lengthMenu:     "<?php echo e(trans('ticketit::lang.table-length-menu')); ?>",
				loadingRecords: "<?php echo e(trans('ticketit::lang.table-loading-results')); ?>",
				processing:     "<?php echo e(trans('ticketit::lang.table-processing')); ?>",
				search:         "<?php echo e(trans('ticketit::lang.table-search')); ?>",
				zeroRecords:    "<?php echo e(trans('ticketit::lang.table-zero-records')); ?>",
				paginate: {
					first:      "<?php echo e(trans('ticketit::lang.table-paginate-first')); ?>",
					last:       "<?php echo e(trans('ticketit::lang.table-paginate-last')); ?>",
					next:       "<?php echo e(trans('ticketit::lang.table-paginate-next')); ?>",
					previous:   "<?php echo e(trans('ticketit::lang.table-paginate-prev')); ?>"
				},
				aria: {
					sortAscending:  "<?php echo e(trans('ticketit::lang.table-aria-sort-asc')); ?>",
					sortDescending: "<?php echo e(trans('ticketit::lang.table-aria-sort-desc')); ?>"
				},
			},
	        columns: [
	            { data: 'id', name: 'ticketit.id' },
	            { data: 'subject', name: 'subject' },
	            { data: 'status', name: 'ticketit_statuses.name' },
	            { data: 'updated_at', name: 'ticketit.updated_at' },
            	{ data: 'agent', name: 'users.name' },
	            <?php if( $u->isAgent() || $u->isAdmin() ): ?>
		            { data: 'priority', name: 'ticketit_priorities.name' },
	            	{ data: 'owner', name: 'users.name' },
		            { data: 'category', name: 'ticketit_categories.name' }
	            <?php endif; ?>
	        ]
	    });
	</script>
<?php $__env->appendSection(); ?>

<?php echo $__env->make('ticketit::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/index.blade.php ENDPATH**/ ?>