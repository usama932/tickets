<?php $__env->startSection('page', trans('ticketit::admin.index-title')); ?>

<?php $__env->startSection('ticketit_extra_content'); ?>
    <?php if($tickets_count): ?>
        <div class="card-deck mb-3">
            <div class="card bg-light">
                <div class="card-body row d-flex align-items-center">
                    <div class="col-3" style="font-size: 5em;">
                        <i class="fas fa-th"></i>
                    </div>
                    <div class="col-9 text-right">
                        <h1><?php echo e($tickets_count); ?></h1>
                        <div><?php echo e(trans('ticketit::admin.index-total-tickets')); ?></div>
                    </div>
                </div>
            </div>

            <div class="card bg-danger">
                <div class="card-body row d-flex align-items-center">
                    <div class="col-3" style="font-size: 5em;">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <div class="col-9 text-right">
                        <h1><?php echo e($open_tickets_count); ?></h1>
                        <div><?php echo e(trans('ticketit::admin.index-open-tickets')); ?></div>
                    </div>
                </div>
            </div>

            <div class="card bg-success">
                <div class="card-body row d-flex align-items-center">
                    <div class="col-3" style="font-size: 5em;">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <div class="col-9 text-right">
                        <h1><?php echo e($closed_tickets_count); ?></h1>
                        <span><?php echo e(trans('ticketit::admin.index-closed-tickets')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-8 mt-3">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
                        <div><i class="fas fa-chart-bar fa-fw"></i> <?php echo e(trans('ticketit::admin.index-performance-indicator')); ?></div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                <?php echo e(trans('ticketit::admin.index-periods')); ?>

                                <span class="caret"></span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="<?php echo e(action('\Kordy\Ticketit\Controllers\DashboardController@index', 2)); ?>">
                                    <?php echo e(trans('ticketit::admin.index-3-months')); ?>

                                </a>
                                <a class="dropdown-item" href="<?php echo e(action('\Kordy\Ticketit\Controllers\DashboardController@index', 5)); ?>">
                                    <?php echo e(trans('ticketit::admin.index-6-months')); ?>

                                </a>
                                <a class="dropdown-item" href="<?php echo e(action('\Kordy\Ticketit\Controllers\DashboardController@index', 11)); ?>">
                                    <?php echo e(trans('ticketit::admin.index-12-months')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="curve_chart" style="width: 100%; height: 350px"></div>
                    </div>
                </div>
                <div class="card-deck mt-3">
                    <div class="card ">
                        <div class="card-header">
                            <?php echo e(trans('ticketit::admin.index-tickets-share-per-category')); ?>

                        </div>
                        <div class="panel-body">
                            <div id="catpiechart" style="width: auto; height: 350;"></div>
                        </div>
                    </div>
                    <div class="card ">
                        <div class="card-header">
                            <?php echo e(trans('ticketit::admin.index-tickets-share-per-agent')); ?>

                        </div>
                        <div class="panel-body">
                            <div id="agentspiechart" style="width: auto; height: 350;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-3">
                <nav>
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($active_tab == "cat" ? "active" : ""); ?>" data-toggle="pill" href="#information-panel-categories">
                                <i class="fas fa-folder"></i>
                                <small><?php echo e(trans('ticketit::admin.index-categories')); ?></small>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($active_tab == "agents" ? "active"  : ""); ?>" data-toggle="pill" href="#information-panel-agents">
                                <i class="fas fa-user-secret"></i>
                                <small><?php echo e(trans('ticketit::admin.index-agents')); ?></small>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($active_tab == "users" ? "active" : ""); ?>" data-toggle="pill" href="#information-panel-users">
                                <i class="fas fa-users"></i>
                                <small><?php echo e(trans('ticketit::admin.index-users')); ?></small>
                            </a>
                        </li>
                    </ul>
                </nav>
                <br>
                <div class="tab-content">
                    <div id="information-panel-categories" class="list-group tab-pane fade <?php echo e($active_tab == "cat" ? "show active" : ""); ?>">
                        <a href="#" class="list-group-item list-group-item-action disabled">
                            <span><?php echo e(trans('ticketit::admin.index-category')); ?>

                                <span class="badge badge-pill badge-secondary"><?php echo e(trans('ticketit::admin.index-total')); ?></span>
                            </span>
                            <small class="pull-right text-muted">
                                <em>
                                    <?php echo e(trans('ticketit::admin.index-open')); ?> /
                                     <?php echo e(trans('ticketit::admin.index-closed')); ?>

                                </em>
                            </small>
                        </a>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="#" class="list-group-item list-group-item-action">
                        <span style="color: <?php echo e($category->color); ?>">
                            <?php echo e($category->name); ?> <span class="badge badge-pill badge-secondary"><?php echo e($category->tickets()->count()); ?></span>
                        </span>
                        <span class="pull-right text-muted small">
                            <em>
                                <?php echo e($category->tickets()->whereNull('completed_at')->count()); ?> /
                                 <?php echo e($category->tickets()->whereNotNull('completed_at')->count()); ?>

                            </em>
                        </span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $categories->render("pagination::bootstrap-4"); ?>

                    </div>
                    <div id="information-panel-agents" class="list-group tab-pane fade <?php echo e($active_tab == "agents" ? "show active" : ""); ?>">
                        <a href="#" class="list-group-item list-group-item-action disabled">
                            <span><?php echo e(trans('ticketit::admin.index-agent')); ?>

                                <span class="badge badge-pill badge-secondary"><?php echo e(trans('ticketit::admin.index-total')); ?></span>
                            </span>
                            <span class="pull-right text-muted small">
                                <em>
                                    <?php echo e(trans('ticketit::admin.index-open')); ?> /
                                    <?php echo e(trans('ticketit::admin.index-closed')); ?>

                                </em>
                            </span>
                        </a>
                        <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="#" class="list-group-item list-group-item-action">
                                <span>
                                    <?php echo e($agent->name); ?>

                                    <span class="badge badge-pill badge-secondary">
                                        <?php echo e($agent->agentTickets(false)->count()  +
                                         $agent->agentTickets(true)->count()); ?>

                                    </span>
                                </span>
                                <span class="pull-right text-muted small">
                                    <em>
                                        <?php echo e($agent->agentTickets(false)->count()); ?> /
                                         <?php echo e($agent->agentTickets(true)->count()); ?>

                                    </em>
                                </span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $agents->render("pagination::bootstrap-4"); ?>

                    </div>
                    <div id="information-panel-users" class="list-group tab-pane fade <?php echo e($active_tab == "users" ? "show active" : ""); ?>">
                        <a href="#" class="list-group-item list-group-item-action disabled">
                            <span><?php echo e(trans('ticketit::admin.index-user')); ?>

                                <span class="badge badge-pill badge-secondary"><?php echo e(trans('ticketit::admin.index-total')); ?></span>
                            </span>
                            <span class="pull-right text-muted small">
                                <em>
                                    <?php echo e(trans('ticketit::admin.index-open')); ?> /
                                    <?php echo e(trans('ticketit::admin.index-closed')); ?>

                                </em>
                            </span>
                        </a>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="#" class="list-group-item list-group-item-action">
                                <span>
                                    <?php echo e($user->name); ?>

                                    <span class="badge badge-pill badge-secondary">
                                        <?php echo e($user->userTickets(false)->count()  +
                                         $user->userTickets(true)->count()); ?>

                                    </span>
                                </span>
                                <span class="pull-right text-muted small">
                                    <em>
                                        <?php echo e($user->userTickets(false)->count()); ?> /
                                        <?php echo e($user->userTickets(true)->count()); ?>

                                    </em>
                                </span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $users->render("pagination::bootstrap-4"); ?>

                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card text-center">
            <?php echo e(trans('ticketit::admin.index-empty-records')); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <?php if($tickets_count): ?>
    
    <script type="text/javascript"
            src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }"></script>

    <script type="text/javascript">
        google.setOnLoadCallback(drawChart);

        // performance line chart
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["<?php echo e(trans('ticketit::admin.index-month')); ?>", "<?php echo implode('", "', $monthly_performance['categories']); ?>"],
                <?php $__currentLoopData = $monthly_performance['interval']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    ["<?php echo e($month); ?>", <?php echo implode(',', $records); ?>],
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ]);

            var options = {
                title: '<?php echo addslashes(trans('ticketit::admin.index-performance-chart')); ?>',
                curveType: 'function',
                legend: {position: 'right'},
                vAxis: {
                    viewWindowMode:'explicit',
                    format: '#',
                    viewWindow:{
                        min:0
                    }
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);

            // Categories Pie Chart
            var cat_data = google.visualization.arrayToDataTable([
              ['<?php echo e(trans('ticketit::admin.index-category')); ?>', '<?php echo addslashes(trans('ticketit::admin.index-tickets')); ?>'],
              <?php $__currentLoopData = $categories_share; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat_name => $cat_tickets): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    ['<?php echo addslashes($cat_name); ?>', <?php echo e($cat_tickets); ?>],
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ]);

            var cat_options = {
              title: '<?php echo addslashes(trans('ticketit::admin.index-categories-chart')); ?>',
              legend: {position: 'bottom'}
            };

            var cat_chart = new google.visualization.PieChart(document.getElementById('catpiechart'));

            cat_chart.draw(cat_data, cat_options);

            // Agents Pie Chart
            var agent_data = google.visualization.arrayToDataTable([
              ['<?php echo e(trans('ticketit::admin.index-agent')); ?>', '<?php echo addslashes(trans('ticketit::admin.index-tickets')); ?>'],
              <?php $__currentLoopData = $agents_share; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent_name => $agent_tickets): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    ['<?php echo addslashes($agent_name); ?>', <?php echo e($agent_tickets); ?>],
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ]);

            var agent_options = {
              title: '<?php echo addslashes(trans('ticketit::admin.index-agents-chart')); ?>',
              legend: {position: 'bottom'}
            };

            var agent_chart = new google.visualization.PieChart(document.getElementById('agentspiechart'));

            agent_chart.draw(agent_data, agent_options);

        }
    </script>
    <?php endif; ?>
<?php $__env->appendSection(); ?>

<?php echo $__env->make('ticketit::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/admin/index.blade.php ENDPATH**/ ?>