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
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold"><?php echo e($pageTitle ?? trans('messages.list')); ?></h5>
                            <?php if($auth_user->can('permission add')): ?>
                                <a href="<?php echo e(route('permission.add',['type'=>'permission'])); ?>" class="float-right btn btn-sm btn-primary loadRemoteModel"><i class="fa fa-plus-circle"></i> <?php echo e(trans('messages.add_form_title',['form' => trans('messages.permission')  ])); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-md-12">
                <?php echo e(Form::open(['route' => 'permission.store','method' => 'post'])); ?>

                    <div class="accordion cursor" id="permissionList">
                        <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $a = str_replace("_"," ",$key);
                                $k = ucwords($a);
                            ?>
                            <div class="card mb-2">
                                <div class="card-header d-flex justify-content-between collapsed btn" id="heading_<?php echo e($key); ?>" data-toggle="collapse" data-target="#pr_<?php echo e($key); ?>" aria-expanded="false" aria-controls="pr_<?php echo e($key); ?>">
                                    <div class="header-title">
                                        <h6 class="mb-0 text-capitalize permission-text"> <i class="fa fa-plus mr-10"></i> <?php echo e($data->name); ?><span class="badge badge-secondary"></span></h6>
                                    </div>
                                </div>
                                <div id="pr_<?php echo e($key); ?>" class="collapse bg_light_gray" aria-labelledby="heading_<?php echo e($key); ?>" data-parent="#permissionList">
                                    <div class="card-body table-responsive">
                                        <table class="table text-center table-bordered bg_white">
                                            <tr>
                                                <th><?php echo e(trans('messages.name')); ?></th>
                                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th><?php echo e(ucwords(str_replace('_',' ',$role->name))); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                            <?php $__currentLoopData = $data->subpermission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="text-capitalize"><?php echo e($p->name); ?></td>
                                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <td>
                                                            <input class="checkbox no-wh permission_check" id="permission-<?php echo e($role->id); ?>-<?php echo e($p->id); ?>" type="checkbox" name="permission[<?php echo e($p->name); ?>][]" value='<?php echo e($role->name); ?>' <?php echo e((checkRolePermission($role,$p->name)) ? 'checked' : ''); ?> <?php if($role->is_hidden): ?> disabled <?php endif; ?> >
                                                        </td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </table>
                                        <input type="submit" name="Save" value="Save" class="btn btn-md btn-primary float-right mall-10">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('bottom_script'); ?>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function(){
                $(document).on('click','#permissionList .card-header',function(){
                    if($(this).find('i').hasClass('fa-minus')){
                        $('#permissionList .card-header i').removeClass('fa-plus').removeClass('fa-minus').addClass('fa-plus');
                        $(this).find('i').addClass('fa-plus').removeClass('fa-minus');
                    }else{
                        $('#permissionList .card-header i').removeClass('fa-plus').removeClass('fa-minus').addClass('fa-plus');
                        $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
                    }
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23)): ?>
<?php $component = $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23; ?>
<?php unset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\newpup\resources\views/permission/index.blade.php ENDPATH**/ ?>