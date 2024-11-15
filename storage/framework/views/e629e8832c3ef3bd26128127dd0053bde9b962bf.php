<?php if (isset($component)) { $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\MasterLayout::class, []); ?>
<?php $component->withName('master-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <h5 class="font-weight-bold"><?php echo e($pageTitle ?? __('messages.list')); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body setting-pills"> 
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <ul class="nav flex-column nav-pills nav-fill tabslink" id="tabs-text" role="tablist">
                                    <?php if(in_array( $page,['profile_form','password_form','time_slot'])): ?>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" data-href="<?php echo e(route('layout_page')); ?>?page=profile_form" data-target=".paste_here" class="nav-link <?php echo e($page=='profile_form'?'active':''); ?>"  data-toggle="tabajax" rel="tooltip"> <?php echo e(__('messages.profile')); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" data-href="<?php echo e(route('layout_page')); ?>?page=password_form" data-target=".paste_here" class="nav-link <?php echo e($page=='password_form'?'active':''); ?>"  data-toggle="tabajax" rel="tooltip"> <?php echo e(__('messages.change_password')); ?> </a>
                                        </li>
                                    
                                        <?php if(auth()->check() && auth()->user()->hasRole('provider')): ?>
                                            <li class="nav-item">
                                                <a href="javascript:void(0)" data-href="<?php echo e(route('layout_page')); ?>?page=time_slot" data-target=".paste_here" class="nav-link <?php echo e($page=='time_slot'?'active':''); ?>"  data-toggle="tabajax" rel="tooltip"> <?php echo e(__('messages.slot')); ?> </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if(auth()->check() && auth()->user()->hasAnyRole('admin|demo_admin|Registrar')): ?>
                                            <li class="nav-item">
                                                <a href="javascript:void(0)" data-href="<?php echo e(route('layout_page')); ?>?page=general-setting" data-target=".paste_here" class="nav-link <?php echo e($page=='general-setting'?'active':''); ?>"  data-toggle="tabajax" rel="tooltip"> <?php echo e(__('messages.general_settings')); ?></a>
                                            </li>
                                          
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="tab-content" id="pills-tabContent-1">
                                    <div class="tab-pane active p-1" >
                                        <div class="paste_here"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php $__env->startSection('bottom_script'); ?>
        <script>
            // (function($) {
            //     "use strict";
                $(document).ready(function(event)
                {
                    var $this = $('.nav-item').find('a.active');
                    loadurl = '<?php echo e(route('layout_page')); ?>?page=<?php echo e($page); ?>';

                    targ = $this.attr('data-target');
                    
                    id = this.id || '';

                    $.post(loadurl,{ '_token': $('meta[name=csrf-token]').attr('content') } ,function(data) {
                        $(targ).html(data);
                    });

                    $this.tab('show');
                    return false;
                });
            // });
        </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23)): ?>
<?php $component = $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23; ?>
<?php unset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\newpup\resources\views/setting/index.blade.php ENDPATH**/ ?>