
<?php
    $auth_user= authSession();
?>
<?php echo e(Form::open(['route' => ['providerdocument.destroy', $provider_document->id], 'method' => 'delete','data--submit'=>'providerdocument'.$provider_document->id])); ?>

<div class="d-flex justify-content-end align-items-center">
    <?php if(!$provider_document->trashed()): ?>
 

        <?php if($auth_user->can('providerdocument delete')): ?>
        <a class="mr-3" href="<?php echo e(route('providerdocument.destroy', $provider_document->id)); ?>" data--submit="providerdocument<?php echo e($provider_document->id); ?>" 
            data--confirmation='true' 
            data--ajax="true"
            data-datatable="reload"
            data-title="<?php echo e(__('messages.delete_form_title',['form'=>  __('messages.providerdocument') ])); ?>"
            title="<?php echo e(__('messages.delete_form_title',['form'=>  __('messages.providerdocument') ])); ?>"
            data-message='<?php echo e(__("messages.delete_msg")); ?>'>
            <i class="far fa-trash-alt text-danger"></i>
        </a>
        <?php endif; ?>
    <?php endif; ?>
    <?php if(auth()->user()->hasAnyRole(['admin']) && $provider_document->trashed()): ?>
        <a href="<?php echo e(route('providerdocument.action',['id' => $provider_document->id, 'type' => 'restore'])); ?>"
            title="<?php echo e(__('messages.restore_form_title',['form' => __('messages.providerdocument') ])); ?>"
            data--submit="confirm_form"
            data--confirmation='true'
            data--ajax='true'
            data-title="<?php echo e(__('messages.restore_form_title',['form'=>  __('messages.providerdocument') ])); ?>"
            data-message='<?php echo e(__("messages.restore_msg")); ?>'
            data-datatable="reload"
            class="mr-2">
            <i class="fas fa-redo text-secondary"></i>
        </a>
        <a href="<?php echo e(route('providerdocument.action',['id' => $provider_document->id, 'type' => 'forcedelete'])); ?>"
            title="<?php echo e(__('messages.forcedelete_form_title',['form' => __('messages.providerdocument') ])); ?>"
            data--submit="confirm_form"
            data--confirmation='true'
            data--ajax='true'
            data-title="<?php echo e(__('messages.forcedelete_form_title',['form'=>  __('messages.providerdocument') ])); ?>"
            data-message='<?php echo e(__("messages.forcedelete_msg")); ?>'
            data-datatable="reload"
            class="mr-2">
            <i class="far fa-trash-alt text-danger"></i>
        </a>
    <?php endif; ?>
<?php echo e(Form::close()); ?><?php /**PATH C:\xampp\htdocs\newpup\resources\views/providerdocument/action.blade.php ENDPATH**/ ?>