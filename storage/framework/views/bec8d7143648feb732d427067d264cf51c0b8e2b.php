
<?php
$auth_user= authSession();
?>
<?php echo e(Form::open(['route' => ['provider.destroy', $provider->id], 'method' => 'delete','data--submit'=>'provider'.$provider->id])); ?>

<div class="d-flex justify-content-end align-items-center">
<?php if(!$provider->trashed()): ?>
<a class="mr-2" href="<?php echo e(route('provider.time-slot',['id' => $provider->id])); ?>" title="<?php echo e(__('messages.My_time_slot',['form' => __('messages.provider') ])); ?>"><i class="fa fa-clock text-primary "></i></a>
<a class="mr-2" href="<?php echo e(route('provider.getchangepassword',['id' => $provider->id])); ?>" title="<?php echo e(__('messages.change_password',['form' => __('messages.provider') ])); ?>"><i class="fa fa-lock text-success "></i></a>

    <?php if($auth_user->can('provider edit')): ?>
    <a class="mr-2" href="<?php echo e(route('provider.create',['id' => $provider->id])); ?>" title="<?php echo e(__('messages.update_form_title',['form' => __('messages.provider') ])); ?>"><i class="fas fa-pen text-secondary"></i></a>
    <?php endif; ?>
    <?php if($auth_user->can('provider delete')): ?>
    <a class="mr-2 text-danger" href="<?php echo e(route('provider.destroy', $provider->id)); ?>" data--submit="provider<?php echo e($provider->id); ?>" 
        data--confirmation='true'
        data--ajax="true"
        data-datatable="reload"
        data-title="<?php echo e(__('messages.delete_form_title',['form'=>  __('messages.provider') ])); ?>"
        title="<?php echo e(__('messages.delete_form_title',['form'=>  __('messages.provider') ])); ?>"
        data-message='<?php echo e(__("messages.delete_msg")); ?>'>
        <i class="far fa-trash-alt"></i>
    </a>
    <?php endif; ?>
<?php endif; ?>
<?php if(auth()->user()->hasAnyRole(['admin']) && $provider->trashed()): ?>
    <a href="<?php echo e(route('provider.action',['id' => $provider->id, 'type' => 'restore'])); ?>"
        title="<?php echo e(__('messages.restore_form_title',['form' => __('messages.provider') ])); ?>"
        data--submit="confirm_form"
        data--confirmation='true'
        data--ajax='true'
        data-title="<?php echo e(__('messages.restore_form_title',['form'=>  __('messages.provider') ])); ?>"
        data-message='<?php echo e(__("messages.restore_msg")); ?>'
        data-datatable="reload"
        class="mr-2">
        <i class="fas fa-redo text-secondary"></i>
    </a>
    <a href="<?php echo e(route('provider.action',['id' => $provider->id, 'type' => 'forcedelete'])); ?>"
        title="<?php echo e(__('messages.forcedelete_form_title',['form' => __('messages.provider') ])); ?>"
        data--submit="confirm_form"
        data--confirmation='true'
        data--ajax='true'
        data-title="<?php echo e(__('messages.forcedelete_form_title',['form'=>  __('messages.provider') ])); ?>"
        data-message='<?php echo e(__("messages.forcedelete_msg")); ?>'
        data-datatable="reload"
        class="mr-2">
        <i class="far fa-trash-alt text-danger"></i>
    </a>
<?php endif; ?>
</div>
<?php echo e(Form::close()); ?><?php /**PATH C:\xampp\htdocs\newpup\resources\views/provider/action.blade.php ENDPATH**/ ?>