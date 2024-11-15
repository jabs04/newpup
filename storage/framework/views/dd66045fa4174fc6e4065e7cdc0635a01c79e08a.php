<?php echo e(Form::model($setting_value, ['method' => 'POST','route' => ['configUpdate'],'enctype'=>'multipart/form-data','data-toggle'=>'validator'])); ?>


    <?php echo e(Form::hidden('id', null, ['class' => 'form-control'] )); ?>

    <?php echo e(Form::hidden('page', $page, ['class' => 'form-control'] )); ?>

    

    <div class="row">
        <?php $__currentLoopData = $setting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12 col-sm-12 card config-info-card shadow mb-10">
                <div class="card-header">
                    <h4><?php echo e($key); ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_keys => $sub_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $data=null;
                                foreach($setting_value as $v){

                                    if($v->key==($key.'_'.$sub_keys)){
                                        $data = $v;
                                    }
                                }
                                $class = 'col-md-4';
                                $type = 'text';
                                switch ($key){
                                    case 'COLOR' : 
                                        $type = 'color';
                                        break;
                                    case 'DISTANCE' :
                                        $type = 'number';
                                        break;
                                    default : break;
                                }
                                $distance_label = '';

                                $distance = '';
                                $distance_type = '';
                                if(isset($data) && $data->value != null && $sub_keys == 'TYPE' )
                                {
                                    $distance_type = $data->value;
                                }
                                if($key == 'DISTANCE' && $sub_keys == 'RADIOUS')
                                {
                                    $distance = 50;
                                }

                            ?>
                            <div class=" <?php echo e($class); ?> col-sm-12">
                                <div class="form-group">
                                    <label for="<?php echo e($key.'_'.$sub_keys); ?>"><?php echo e(str_replace('_',' ',$sub_keys)); ?> </label>
                                    <?php echo e(Form::hidden('type[]', $key , ['class' => 'form-control'] )); ?>

                                    <input type="hidden" name="key[]" value="<?php echo e($key.'_'.$sub_keys); ?>">
                                    <?php if($key == 'CURRENCY' && $sub_keys == 'COUNTRY_ID'): ?>
                                        <?php echo e(Form::select('value[]', isset($data->country) ? [optional($data->country)->id => optional($data->country)->name ." ( ". optional($data->country)->symbol ." ) " ] : [], isset($data->country) ? optional($data->country)->id : null , [
                                            'class' => 'select2js form-group country',
                                            'id' => $key.'_'.$sub_keys,
                                            'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.country') ]),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'currency']),
                                            ])); ?>

                                    <?php elseif($key == 'CURRENCY' && $sub_keys == 'POSITION'): ?>
                                    <?php echo e(Form::select('value[]',['left' => __('messages.left') , 'right' => __('messages.right') ], isset($data) ? $data->value : 'left',[ 'class' =>'form-control select2js'])); ?>

                                    <?php elseif($key == 'DISTANCE' && $sub_keys == 'TYPE'): ?>
                                    <?php echo e(Form::select('value[]',['km' => __('messages.km') , 'mile' => __('messages.mile') ], $distance_type,[ 'class' =>'form-control select2js'])); ?>

                                    <?php else: ?>
                                        <input type="<?php echo e($type); ?>" name="value[]" value="<?php echo e(isset($data) ? $data->value : $distance); ?>" id="<?php echo e($key.'_'.$sub_keys); ?>" <?php echo e($type == 'number' ? "min=0 step='any'" : ''); ?> class="form-control" placeholder="<?php echo e(str_replace('_',' ',$sub_keys)); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-12">
                            <?php echo Form::submit('Save',['class'=>'btn btn-md btn-primary']); ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php echo e(Form::submit(__('messages.save'), ['class'=>"btn btn-md btn-primary float-md-right"])); ?>

<?php echo e(Form::close()); ?>


<script>
    $(document).ready(function() {
        $('.select2js').select2();
    });
</script>
<?php /**PATH C:\xampp\htdocs\newpup\resources\views/setting/config-setting.blade.php ENDPATH**/ ?>