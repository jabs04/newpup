<div class="page-title-wrap mb-3 p-3">
    <h2 class="page-title"><?php echo e(__('messages.provider_detail')); ?></h2>
</div>


<div class="mb-3 ms-2">
    <ul class="nav nav--tabs nav--tabs__style2 provider-detail-tab">
        <li class="nav-item <?php echo e(request()->routeIs('provider.show') ? 'active' : ''); ?>">
            <a class="nav-link" href="<?php echo e(route('provider.show',$providerdata->id)); ?>"> <?php echo e(__('messages.overview')); ?></a>
        </li>
        <li class="nav-item <?php echo e(request()->routeIs('service.show') ? 'active' : ''); ?>">
            <a class="nav-link" href="<?php echo e(route('service.show',$providerdata->id)); ?>"> <?php echo e(__('messages.plan')); ?></a>
        </li>
        <li class="nav-item <?php echo e(request()->routeIs('booking.details') ? 'active' : ''); ?>">
            <a class="nav-link" href="<?php echo e(route('booking.details',$providerdata->id)); ?>"> <?php echo e(__('messages.Bookings')); ?></a>
        </li>
        <li class="nav-item <?php echo e(request()->routeIs('handyman.show') ? 'active' : ''); ?>">
            <a class="nav-link" href="<?php echo e(route('handyman.show',$providerdata->id)); ?>"><?php echo e(__('messages.handyman')); ?></a>
        </li>
        <li class="nav-item <?php echo e(request()->routeIs('setting.comission') ? 'active' : ''); ?>">
            <a class="nav-link" href="<?php echo e(route('setting.comission',$providerdata->id)); ?>"><?php echo e(__('messages.Settings')); ?></a>
        </li>
        <li class="nav-item <?php echo e(request()->routeIs('bank.show') ? 'active' : ''); ?>">
            <a class="nav-link" href="<?php echo e(route('bank.show',$providerdata->id)); ?>"><?php echo e(__('messages.Bank_info')); ?></a>
        </li>
        <li class="nav-item <?php echo e(request()->routeIs('provider.review') ? 'active' : ''); ?>">
            <a class="nav-link" href="<?php echo e(route('provider.review',$providerdata->id)); ?>"><?php echo e(__('messages.Reviews')); ?></a>
        </li>
    </ul>
</div><?php /**PATH C:\xampp\htdocs\newpup\resources\views/partials/_provider.blade.php ENDPATH**/ ?>