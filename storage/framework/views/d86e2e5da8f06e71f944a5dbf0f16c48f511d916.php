
<?php
    $auth_user= authSession();
?>
<?php echo e(Form::open(['route' => ['document.destroy', $document->id], 'method' => 'delete','data--submit'=>'document'.$document->id])); ?>

<div class="d-flex justify-content-end align-items-center">
    <?php if(!$document->trashed()): ?>
        <!-- <?php if($auth_user->can('document edit')): ?>
        <a class="mr-2" href="<?php echo e(route('document.create',['id' => $document->id])); ?>" title="<?php echo e(__('messages.update_form_title',['form' => __('messages.document') ])); ?>"><i class="fas fa-pen text-primary"></i></a>
        <?php endif; ?> -->

        <?php if($auth_user->can('document delete')): ?>
        <a class="mr-3" href="<?php echo e(route('document.destroy', $document->id)); ?>" data--submit="document<?php echo e($document->id); ?>" 
            data--confirmation='true' 
            data--ajax="true"
            data-datatable="reload"
            data-title="<?php echo e(__('messages.delete_form_title',['form'=>  __('messages.document') ])); ?>"
            title="<?php echo e(__('messages.delete_form_title',['form'=>  __('messages.document') ])); ?>"
            data-message='<?php echo e(__("messages.delete_msg")); ?>'>
            <i class="far fa-trash-alt text-danger"></i>
        </a>
        <?php endif; ?>
    <?php endif; ?>
    <?php if(auth()->user()->hasAnyRole(['admin']) && $document->trashed()): ?>
        <a href="<?php echo e(route('document.action',['id' => $document->id, 'type' => 'restore'])); ?>"
            title="<?php echo e(__('messages.restore_form_title',['form' => __('messages.document') ])); ?>"
            data--submit="confirm_form"
            data--confirmation='true'
            data--ajax='true'
            data-title="<?php echo e(__('messages.restore_form_title',['form'=>  __('messages.document') ])); ?>"
            data-message='<?php echo e(__("messages.restore_msg")); ?>'
            data-datatable="reload"
            class="mr-2">
            <i class="fas fa-redo text-secondary"></i>
        </a>
        <a href="<?php echo e(route('document.action',['id' => $document->id, 'type' => 'forcedelete'])); ?>"
            title="<?php echo e(__('messages.forcedelete_form_title',['form' => __('messages.document') ])); ?>"
            data--submit="confirm_form"
            data--confirmation='true'
            data--ajax='true'
            data-title="<?php echo e(__('messages.forcedelete_form_title',['form'=>  __('messages.document') ])); ?>"
            data-message='<?php echo e(__("messages.forcedelete_msg")); ?>'
            data-datatable="reload"
            class="mr-2">
            <i class="far fa-trash-alt text-danger"></i>
        </a>
    <?php endif; ?>
<?php echo e(Form::close()); ?><?php /**PATH C:\xampp\htdocs\newpup\resources\views/document/action.blade.php ENDPATH**/ ?>