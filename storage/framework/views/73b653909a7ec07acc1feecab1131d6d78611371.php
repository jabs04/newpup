
<?php echo e(Form::model($flatArray,['method' => 'POST','route'=>'saveLangContent', 'data-toggle'=>"validator" ,'id'=>'flatArray'] )); ?>

<input type="hidden" value="<?php echo e($filename); ?>" name="filename"/>
<input type="hidden" value="<?php echo e($requestLang); ?>" name="requestLang"/>
<div class="table-responsive mb-0">
    <table class="table lang_table table-sm table-fixed">
        <thead>
            <tr class="text-secondary">
            <th scope="col"><?php echo e(__('messages.key')); ?></th>
            <th scope="col"><?php echo e(__('messages.value')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $flatArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                   <td><?php echo e($key); ?></td>
                   <td><input type = "text" class ="form-control" name ="<?php echo e($key); ?>" value="<?php echo e($val); ?>" /></td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php echo e(Form::submit( __('messages.save'), ['class'=>'btn btn-md btn-primary float-right'])); ?>

<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\newpup\resources\views/language/index.blade.php ENDPATH**/ ?>