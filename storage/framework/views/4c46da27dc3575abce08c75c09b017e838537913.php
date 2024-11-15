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
                            <h5 class="font-weight-bold">Add New Document</h5>
                            <?php if($auth_user->can('providerdocument list')): ?>
                                <a href="<?php echo e(route('providerdocument.index')); ?>" class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> <?php echo e(__('messages.back')); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo e(Form::model($provider_document,['method' => 'POST','route'=>'providerdocument.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'provider_document'] )); ?>

                            <?php echo e(Form::hidden('id')); ?>

                            <div class="row">
                               
                                <div class="form-group col-md-4">
                                    <?php echo e(Form::label('provider_id', __('messages.select_name',[ 'select' => 'Student' ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false)); ?>

                                    <br />
                                    <?php echo e(Form::select('provider_id', [optional($provider_document->providers)->id => optional($provider_document->providers)->display_name], optional($provider_document->providers)->id, [
                                        'class' => 'select2js form-group providers',
                                        'required',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => 'Student' ]),
                                        'data-ajax--url' => route('ajax-list', ['type' => 'provider']),
                                    ])); ?>

                                </div>
                        
                                <?php
                                    $is_required = optional($provider_document->document)->is_required == 1 ? '*' : '';
                                ?>

                                <div class="form-group col-md-4">
                                    <?php echo e(Form::label('name', __('messages.select_name',[ 'select' => __('messages.document') ]).' <span class="text-danger">* </span>',['class'=>'form-control-label'],false)); ?>

                                    <br />
                                    <?php echo e(Form::select('document_id', [optional($provider_document->document)->id => optional($provider_document->document)->name." ".$is_required], optional($provider_document->document)->id, [
                                            'class' => 'select2js form-group document_id',
                                            'id' => 'document_id',
                                            'required',
                                            'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.document') ]),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'documents']),
                                        ])); ?>

                                    <a href="<?php echo e(route('document.create')); ?>"><i class="fa fa-plus-circle mt-2"></i> <?php echo e(trans('messages.add_form_title',['form' => trans('messages.document')  ])); ?></a>
                                </div>
                               
                                <div class="form-group col-md-4">
                                    <?php echo e(Form::label('is_verified',trans('messages.is_verify').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false)); ?>

                                    <?php echo e(Form::select('is_verified',['1' => __('messages.verified') , '0' => __('messages.unverified') ],old('is_verified'),[ 'id' => 'is_verified' ,'class' =>'form-control select2js','required'])); ?>

                                </div>
                              

                                <div class="form-group col-md-4">
                                    <label class="form-control-label" for="provider_document"><?php echo e(__('messages.upload_document')); ?> <span class="text-danger" id="document_required"></span> </label>
                                    <div class="custom-file">
                                        <input type="file" id="provider_document" name="provider_document" class="custom-file-input" required>
                                        <label class="custom-file-label upload-label"><?php echo e(__('messages.choose_file',['file' =>  __('messages.document') ])); ?></label>
                                    </div>
                                    <!-- <span class="selected_file"></span> -->
                                </div>
                                <?php if(getMediaFileExit($provider_document, 'provider_document')): ?>
                                    <div class="col-md-2 mb-2">
                                        <?php
                                            $file_extention = config('constant.IMAGE_EXTENTIONS');
                                            $image = getSingleMedia($provider_document,'provider_document');
                                            
                                            $extention = in_array(strtolower(imageExtention($image)),$file_extention);
                                        ?>
                                            <?php if($extention): ?>   
                                                <img id="provider_document_preview" src="<?php echo e($image); ?>" alt="#" class="attachment-image mt-1" >
                                            <?php else: ?>
                                                <img id="provider_document_preview" src="<?php echo e(asset('images/file.png')); ?>" class="attachment-file">
                                            <?php endif; ?>
                                            <a class="text-danger remove-file" href="<?php echo e(route('remove.file', ['id' => $provider_document->id, 'type' => 'provider_document'])); ?>"
                                                data--submit="confirm_form"
                                                data--confirmation='true'
                                                data--ajax="true"
                                                title='<?php echo e(__("messages.remove_file_title" , ["name" =>  __("messages.image") ])); ?>'
                                                data-title='<?php echo e(__("messages.remove_file_title" , ["name" =>  __("messages.image") ])); ?>'
                                                data-message='<?php echo e(__("messages.remove_file_msg")); ?>'>
                                                <i class="ri-close-circle-line"></i>
                                            </a>
                                            <?php if($auth_user->can('download file')): ?>
                                            <a href="javascript:void(0)" class="d-block mt-2" id="download_click"><i class="fas fa-download "></i> <?php echo e(__('messages.download')); ?></a>
                                            <a href="<?php echo e($image); ?>" data-url="<?php echo e($image); ?>" class="d-block mt-2" download target="_blank" style="display: none !important;" id="download_file"><i class="fas fa-download "></i> <?php echo e(__('messages.download')); ?></a>
                                            <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php echo e(Form::submit( trans('messages.save'), ['class'=>'btn btn-md btn-primary float-right'])); ?>

                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>  
    <?php $__env->startSection('bottom_script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
            (function($) {
                "use strict";
                    $(document).ready(function(){ 
                        $('#download_click').click(function(){
                            Swal.fire({
                                title: "Enter your password",
                                text: "You won't be able to revert this!",
                                html: '<input type="password" class="form-control text-center" id="download_password" placeholder="Enter Password">',
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    
                                    var vdata = {
                                        password: $('#download_password').val()
                                    }
                                    $.ajax({
                                        type: 'GET',
                                        url: '<?php echo e(route("download.pass")); ?>',
                                        data: vdata,
                                        dataType: 'JSON',
                                        success: function(data) {
                                            if(data.status){
                                                var link = document.getElementById('download_file');
                                                link.click();
                                            }else{
                                                Swal.fire({
                                                    title: "Error!",
                                                    text: "Password is incorrect",
                                                    icon: "error"
                                                });
                                            }
                                        }
                                    });
                                    
                                }
                            });
                        })
                        
                        $(document).on('change' , '#document_id' , function (){
                            var data = $('#document_id').select2('data')[0];
                           
                            if(data.is_required == 1)
                            {
                                $('#document_required').text('*');
                                $('#provider_document').attr('required');
                            } else {
                                $('#document_required').text('');
                                $('#provider_document').attr('required', false);
                            }
                        })
                    })
            })(jQuery);
        </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23)): ?>
<?php $component = $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23; ?>
<?php unset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\newpup\resources\views/providerdocument/create.blade.php ENDPATH**/ ?>