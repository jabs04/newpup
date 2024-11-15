<!DOCTYPE html>
<html  lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(session()->has('dir') ? session()->get('dir') : 'ltr'); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="baseUrl" content="<?php echo e(env('APP_URL')); ?>" />
        <title><?php echo e(config('app.name', 'Laravel')); ?></title>
        <link rel="shortcut icon" class="site_favicon_preview" href="<?php echo e(getSingleMedia(settingSession('get'),'site_favicon',null)); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('vendor/@fortawesome/fontawesome-free/css/all.min.css')); ?>">
        <link href="<?php echo e(asset('css/frontend.min.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(asset('css/frontend/slick.css')); ?>">
    </head>
    <script>
        window._locale = '<?php echo e($locale); ?>';
        window._translations = <?php echo cache('translations'); ?>;
    </script>
    <body>
        <div id="app">
            <Default></Default>
        </div>
        <script src="<?php echo e(asset('js/frontend.min.js')); ?>" defer></script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\newpup\resources\views/frontend/index.blade.php ENDPATH**/ ?>