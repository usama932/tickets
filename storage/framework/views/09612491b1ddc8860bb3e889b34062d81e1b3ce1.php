<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo e(config('app.name')); ?></title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .version {
                font-size: 0.4em;
                position: absolute;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/home')); ?>">Home</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>">Login</a>

                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content">
                <div class="title m-b-md">
                    <?php echo e(config('app.name')); ?>

                    
                    
                    
                    <?php
                        $packages = collect(json_decode(file_get_contents(base_path('composer.lock')))->packages);
                    ?>
                    <span class="version">
                        <?php echo e(substr($packages->where('name', 'kordy/ticketit')->first()->version, 1)); ?>

                    </span>
                </div>
                <div class="subtitle m-b-md">
                    Powered by Laravel
                    <?php echo e(substr($packages->where('name', 'laravel/framework')->first()->version, 1)); ?>

                </div>


                <div class="links">
                    <a href="https://github.com/thekordy/ticketit/wiki">Documentation</a>
                    <a href="https://github.com/thekordy/ticketit/issues">Bug reports</a>
                    <a href="https://github.com/thekordy/ticketit/">GitHub</a>
                    <a href="https://laravel.com/">Laravel</a>
                </div>
            </div>
        </div>
    </body>
</html>
<?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\resources\views/welcome.blade.php ENDPATH**/ ?>