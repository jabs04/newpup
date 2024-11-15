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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::model($setting_data,['method' => 'POST','route'=>'privacy-policy-save', 'data-toggle'=>"validator" ] )); ?>

                        <?php echo e(Form::hidden('id')); ?>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <?php echo e(Form::label('privacy_policy',__('messages.privacy_policy'), ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::textarea('value', null, ['class'=> 'form-control tinymce-privacy_policy' , 'placeholder'=> __('messages.privacy_policy') ])); ?>

                            </div>
                        </div>
                        <?php echo e(Form::submit( __('messages.save'), ['class'=>'btn btn-md btn-primary float-right'])); ?>

                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('bottom_script'); ?>
    <script>
        (function($) {
            $(document).ready(function(){
                tinymceEditor('.tinymce-privacy_policy',' ',function (ed) {

                }, 450)
            
            });

        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23)): ?>
<?php $component = $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23; ?>
<?php unset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\newpup\resources\views/setting/privacy_policy_form.blade.php ENDPATH**/ ?>