<?php echo e(Form::model($payment,['method' => 'POST','route' => ['advanceEarningSetting'],'enctype'=>'multipart/form-data','data-toggle'=>'validator'])); ?>


<?php echo e(Form::hidden('id', null, array('placeholder' => 'id','class' => 'form-control'))); ?>

<?php echo e(Form::hidden('page', $page, array('placeholder' => 'id','class' => 'form-control'))); ?>


<div class="row">
    <div class="form-group col-md-12">
        <label for="enable_cod"><?php echo e(__('messages.advance_payment_setting')); ?></label>
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="value" id="enable_cod" <?php echo e(!empty($payment->value) ? 'checked' : ''); ?>>
            <label class="custom-control-label" for="enable_cod"></label>
        </div>
    </div>
</div>

<?php echo e(Form::submit(__('messages.save'), ['class'=>"btn btn-md btn-primary float-md-right"])); ?>

<?php echo e(Form::close()); ?>


<?php /**PATH C:\xampp\htdocs\newpup\resources\views/setting/advance-payment-setting.blade.php ENDPATH**/ ?>