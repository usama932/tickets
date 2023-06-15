<nav>
    <ul class="nav nav-pills">
        <li role="presentation" class="nav-item">
            <a class="nav-link <?php echo $tools->fullUrlIs(route(Kordy\Ticketit\Models\Setting::grab('main_route') . '.index')) ? "active" : ""; ?>"
                href="<?php echo e(route(Kordy\Ticketit\Models\Setting::grab('main_route') . '.index')); ?>"><?php echo e(trans('ticketit::lang.nav-active-tickets')); ?>

                <span class="badge badge-pill badge-secondary ">
                     <?php 
                        if ($u->isAdmin()) {
                            echo Kordy\Ticketit\Models\Ticket::active()->count();
                        } elseif ($u->isAgent()) {
                            echo Kordy\Ticketit\Models\Ticket::active()->agentUserTickets($u->id)->count();
                        } else {
                            echo Kordy\Ticketit\Models\Ticket::userTickets($u->id)->active()->count();
                        }
                    ?>
                </span>
            </a>
        </li>
        <li role="presentation" class="nav-item">
            <a class="nav-link <?php echo $tools->fullUrlIs(route(Kordy\Ticketit\Models\Setting::grab('main_route') . '-complete')) ? "active" : ""; ?>"
                 href="<?php echo e(route(Kordy\Ticketit\Models\Setting::grab('main_route') . '-complete')); ?>"><?php echo e(trans('ticketit::lang.nav-completed-tickets')); ?>

                <span class="badge badge-pill badge-secondary">
                    <?php 
                        if ($u->isAdmin()) {
                            echo Kordy\Ticketit\Models\Ticket::complete()->count();
                        } elseif ($u->isAgent()) {
                            echo Kordy\Ticketit\Models\Ticket::complete()->agentUserTickets($u->id)->count();
                        } else {
                            echo Kordy\Ticketit\Models\Ticket::userTickets($u->id)->complete()->count();
                        }
                    ?>
                </span>
            </a>
        </li>

        <?php if($u->isAdmin()): ?>
            <li role="presentation" class="nav-item">
                <a class="nav-link <?php echo $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\DashboardController@index')) || Request::is($setting->grab('admin_route').'/indicator*') ? "active" : ""; ?>"
                    href="<?php echo e(action('\Kordy\Ticketit\Controllers\DashboardController@index')); ?>"><?php echo e(trans('ticketit::admin.nav-dashboard')); ?></a>
            </li>

            <li role="presentation" class="nav-item dropdown">

                <a class="nav-link dropdown-toggle <?php echo $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\StatusesController@index').'*') ||
                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\PrioritiesController@index').'*') ||
                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\AgentsController@index').'*') ||
                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\CategoriesController@index').'*') ||
                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\ConfigurationsController@index').'*') ||
                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\AdministratorsController@index').'*')
                    ? "active" : ""; ?>"
                    data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo e(trans('ticketit::admin.nav-settings')); ?>

                </a>
                <div class="dropdown-menu">
                    <a  class="dropdown-item <?php echo $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\StatusesController@index').'*') ? "active" : ""; ?>"
                        href="<?php echo e(action('\Kordy\Ticketit\Controllers\StatusesController@index')); ?>"><?php echo e(trans('ticketit::admin.nav-statuses')); ?></a>
                    
                    <a  class="dropdown-item <?php echo $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\PrioritiesController@index').'*') ? "active" : ""; ?>"
                        href="<?php echo e(action('\Kordy\Ticketit\Controllers\PrioritiesController@index')); ?>"><?php echo e(trans('ticketit::admin.nav-priorities')); ?></a>
                    
                    <a  class="dropdown-item <?php echo $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\AgentsController@index').'*') ? "active" : ""; ?>"
                        href="<?php echo e(action('\Kordy\Ticketit\Controllers\AgentsController@index')); ?>"><?php echo e(trans('ticketit::admin.nav-agents')); ?></a>
                    
                    <a  class="dropdown-item <?php echo $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\CategoriesController@index').'*') ? "active" : ""; ?>"
                        href="<?php echo e(action('\Kordy\Ticketit\Controllers\CategoriesController@index')); ?>"><?php echo e(trans('ticketit::admin.nav-categories')); ?></a>
                   
                    <a  class="dropdown-item <?php echo $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\ConfigurationsController@index').'*') ? "active" : ""; ?>"
                        href="<?php echo e(action('\Kordy\Ticketit\Controllers\ConfigurationsController@index')); ?>"><?php echo e(trans('ticketit::admin.nav-configuration')); ?></a>
                    
                    <a  class="dropdown-item <?php echo $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\AdministratorsController@index').'*') ? "active" : ""; ?>"
                        href="<?php echo e(action('\Kordy\Ticketit\Controllers\AdministratorsController@index')); ?>"><?php echo e(trans('ticketit::admin.nav-administrator')); ?></a>
                    
                </div>
            </li>
        <?php endif; ?>

    </ul>
</nav><?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/shared/nav.blade.php ENDPATH**/ ?>