<?php echo e(Form::open(['method' => 'POST','route' => ['envSetting'],'data-toggle'=>'validator'])); ?>


    <?php echo e(Form::hidden('id', null, ['class' => 'form-control'] )); ?>

    <?php echo e(Form::hidden('page', $page, ['class' => 'form-control'] )); ?>

    <?php echo e(Form::hidden('type', 'mail', ['class' => 'form-control'] )); ?>


    
    <div class="col-md-12 mt-20">
        <div class="row">
            <?php $__currentLoopData = config('constant.MAIL_SETTING'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label text-capitalize"><?php echo e(strtolower(str_replace('_',' ',$key))); ?></label>
                        <?php if( auth()->user()->hasRole('admin')): ?>
                            <input type="<?php echo e($key=='MAIL_PASSWORD'?'password':'text'); ?>" value="<?php echo e($value); ?>" name="ENV[<?php echo e($key); ?>]" class="form-control" placeholder="<?php echo e(config('constant.MAIL_PLACEHOLDER.'.$key)); ?>">
                        <?php else: ?>
                            <input type="<?php echo e($key=='MAIL_PASSWORD'?'password':'text'); ?>" value="" name="ENV[<?php echo e($key); ?>]" class="form-control" placeholder="<?php echo e(config('constant.MAIL_PLACEHOLDER.'.$key)); ?>">
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <?php echo e(Form::submit(__('messages.save'), ['class'=>"btn btn-md btn-primary float-md-right"])); ?>

    <?php echo e(Form::close()); ?><?php /**PATH C:\xampp\htdocs\newpup\resources\views/setting/mail-setting.blade.php ENDPATH**/ ?>