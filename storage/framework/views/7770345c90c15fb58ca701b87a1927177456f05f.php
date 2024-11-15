<!DOCTYPE html>
<html>
<head>
    <title><?php echo e($mailSubject); ?></title>
</head>
<body>
    <h1><?php echo e($mailSubject); ?></h1>
    <p><?php echo e($mailMessage); ?></p>
    <p>Email: <?php echo e($mailEmail); ?></p>
    <p>Password: <?php echo e($mailPassword); ?></p>
    <?php if($mailLink): ?>
        <p>Click here to visit: <a href="<?php echo e($mailLink); ?>"><?php echo e($mailLink); ?></a></p>
    <?php endif; ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\newpup\resources\views/mails/sendMail.blade.php ENDPATH**/ ?>