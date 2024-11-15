<?php if (isset($component)) { $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\MasterLayout::class, []); ?>
<?php $component->withName('master-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
        <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold"><?php echo e($pageTitle ?? trans('messages.list')); ?></h5>
                            <?php if($auth_user->can('document list')): ?>
                                <a href="<?php echo e(route('document.index')); ?>" class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> <?php echo e(__('messages.back')); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <?php echo e(Form::model($documentdata,['method' => 'POST','route'=>'document.store', 'data-toggle'=>"validator" ,'id'=>'documents'] )); ?>

                            <?php echo e(Form::hidden('id')); ?>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <?php echo e(Form::label('name',trans('messages.name').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false )); ?>

                                    <?php echo e(Form::text('name',old('name'),['placeholder' => trans('messages.name'),'class' =>'form-control','required'])); ?>

                                    <small class="help-block with-errors text-danger"></small>
                                </div>

                                <div class="form-group col-md-12">
                                    <?php echo e(Form::label('status',trans('messages.status').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false)); ?>

                                    <?php echo e(Form::select('status',['1' => __('messages.active') , '0' => __('messages.inactive') ],old('status'),[ 'id' => 'status' ,'class' =>'form-control select2js','required'])); ?>

                                </div>

                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <?php echo e(Form::checkbox('is_required', $documentdata->is_required, null, ['class' => 'custom-control-input' , 'id' => 'is_required' ])); ?>

                                        <label class="custom-control-label" for="is_required"><?php echo e(__('messages.is_required')); ?>

                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php echo e(Form::submit( trans('messages.save'), ['class'=>'btn btn-md btn-primary float-right'])); ?>

                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23)): ?>
<?php $component = $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23; ?>
<?php unset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\newpup\resources\views/document/create.blade.php ENDPATH**/ ?>