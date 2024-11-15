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
                            <h5 class="font-weight-bold"><?php echo e($pageTitle ?? __('messages.list')); ?></h5>
                            <a href="<?php echo e(route('user.index')); ?>" class="float-right btn btn-sm btn-primary"><i
                                    class="fa fa-angle-double-left"></i> <?php echo e(__('messages.back')); ?></a>
                            <?php if($auth_user->can('user list')): ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo e(Form::model($customerdata,['method' => 'POST','route'=>'user.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'user'] )); ?>

                        <?php echo e(Form::hidden('id')); ?>

                        <?php echo e(Form::hidden('user_type','user')); ?>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('first_name',__('messages.first_name').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false )); ?>

                                <?php echo e(Form::text('first_name',old('first_name'),['placeholder' => __('messages.first_name'),'class' =>'form-control','required'])); ?>

                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('last_name',__('messages.last_name').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false )); ?>

                                <?php echo e(Form::text('last_name',old('last_name'),['placeholder' => __('messages.last_name'),'class' =>'form-control','required'])); ?>

                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('username',__('messages.username').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false )); ?>

                                <?php echo e(Form::text('username',old('username'),['placeholder' => __('messages.username'),'class' =>'form-control','required'])); ?>

                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('user_type',__('messages.user_type').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false )); ?>

                                <select class='form-control select2js' id='user_type' name="user_type">
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value->name); ?>" data-type="<?php echo e($value->id); ?>"
                                        <?php echo e($customerdata->user_type == $value->name ? 'selected' : ''); ?>>
                                        <?php echo e($value->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="departmentContainer" style="display: none;">
                                <?php echo e(Form::label('department','Departement'.' <span class="text-danger">*</span>',['class'=>'form-control-label'], false )); ?>

                                <select class='form-control select2js' id='department' name="department">
                                    <?php $userDepartment = $customerdata->department; ?>
                                    <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dept->name); ?>" data-type="<?php echo e($dept->id); ?>"
                                        
                                        <?php echo e($dept->name == $userDepartment ? 'selected' : ''); ?>>
                                        <?php echo e($dept->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('email', __('messages.email').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false)); ?>

                                <?php echo e(Form::email('email', old('email'), ['placeholder' => __('messages.email'), 'class' => 'form-control', 'required', 'pattern' => '[^@]+@[^@]+\.[a-zA-Z]{2,}', 'title' => 'Please enter a valid email address'])); ?>

                                <small class="help-block with-errors text-danger"></small>
                            </div>


                            <?php if(!isset($customerdata->id) || $customerdata->id == null): ?>
                            <div class="form-group col-md-4" style="display: none;">
                                <?php echo e(Form::label('password', __('messages.password').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false)); ?>

                                <?php echo e(Form::password('password', ['class' => 'form-control', 'placeholder' => __('messages.password'), 'autocomplete' => 'new-password'])); ?>

                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <?php endif; ?>


                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('contact_number',__('messages.contact_number').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false )); ?>

                                <?php echo e(Form::text('contact_number',old('contact_number'),['placeholder' => __('messages.contact_number'),'class' =>'form-control','required'])); ?>

                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('status',__('messages.status').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false)); ?>

                                <?php echo e(Form::select('status',['1' => __('messages.active') , '0' => __('messages.inactive') ],old('status'),[ 'class' =>'form-control select2js','required'])); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('address',__('messages.address'), ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::textarea('address', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('messages.address') ])); ?>

                            </div>
                            <div class="col-md-12" id="area" style="display: none;">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <?php echo e(Form::label('country_id', __('messages.select_name',[ 'select' => __('messages.country') ]),['class'=>'form-control-label'],false)); ?>

                                        <br />
                                        <?php echo e(Form::select('country_id', [$country_id => $country_name], $country_id, [
                                                'class' => 'select2js form-group country',
                                                'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.country') ]),
                                                'data-ajax--url' => route('ajax-list', ['type' => 'country']),
                                                'disabled' => 'true',
                                            ])); ?>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <?php echo e(Form::label('state_id', __('messages.select_name',[ 'select' => __('messages.state') ]),['class'=>'form-control-label'],false)); ?>

                                        <br />
                                        <?php echo e(Form::select('state_id', [], old('state_id'), [
                                                'class' => 'select2js form-group state_id',
                                                'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.state') ]),
                                            ])); ?>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <?php echo e(Form::label('city_id', __('messages.select_name',[ 'select' => 'Area' ]),['class'=>'form-control-label'],false)); ?>

                                        <br />
                                
                                            <select class="select2js form-group city_id" id="city_id" name="aa" placeholder="<?php echo e(__('messages.city')); ?>" multiple>
                                                
                                            </select>
                                            <input type="hidden" id="areaArray" name="area"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php echo e(Form::submit( __('messages.save'), ['class'=>'btn btn-md btn-primary float-right'])); ?>

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
<?php endif; ?>
<script>
    $(document).on('keyup', '.contact_number', function() {
        var contactNumberInput = document.getElementById('contact_number');
        var inputValue = contactNumberInput.value;
        inputValue = inputValue.replace(/[^0-9+\- ]/g, '');
        if (inputValue.length > 15) {
            inputValue = inputValue.substring(0, 15);
            $('#contact_number_err').text('Contact number should not exceed 15 characters');
        } else {
                $('#contact_number_err').text('');
        }
        contactNumberInput.value = inputValue;
        if (inputValue.match(/^[0-9+\- ]+$/)) {
            $('#contact_number_err').text('');
        } else {
            $('#contact_number_err').text('Please enter a valid mobile number');
        }
    });
 
    $(document).ready(function() {
        var country_id = "<?php echo e(isset($customerdata->country_id) ? $customerdata->country_id : 173); ?>";
        var state_id = "<?php echo e(isset($customerdata->state_id) ? $customerdata->state_id : 0); ?>";
        var city_id = "<?php echo e(isset($customerdata->city_id) ? $customerdata->city_id : 0); ?>";

        var provider_id = "<?php echo e(isset($customerdata->id) ? $customerdata->id : ''); ?>";
       

        // if(provider_id){
        //     $('#area').show();
        // }else{
        //     $('#area').hide();
        // }
        stateName(country_id, state_id);
        $(document).on('change', '#country_id', function() {
            var country = $(this).val();
            $('#state_id').empty();
            $('#city_id').empty();
            stateName(country);
        })
        $(document).on('change', '#state_id', function() {
            var state = $(this).val();
            $('#city_id').empty();
            console.log(state)
            cityName(state, city_id);
        })
        $(document).on('change', '#user_type', function(){
            var depot = $(this).val();
            if(depot == "Student"){
                $('#departmentContainer').show();
            }else{
                $('#departmentContainer').hide();
            }
        })
        
        $(document).on('change', '#city_id', function() {
            var country = $(this).val();
            var haba = country.length
            var gege = country.toString();
            var e = gege.split(',');
            var text = "";
            // e.forEach(get =>{
            //     text += "'"+get.toString()+"',"
            // });
            // text = text.slice(0, -1);
            // $('#areaArray').val(text.toString())
            var text = "";
            e.forEach(get =>{
                text += get.toString()+','
            });
            text = text.slice(0, -1);
            $('#areaArray').val(text.toString())
        })
    })
 
    function stateName(country, state = "") {
        var state_route = "<?php echo e(route('ajax-list', [ 'type' => 'state','country_id' =>''])); ?>" + country;
        state_route = state_route.replace('amp;', '');

        $.ajax({
            url: state_route,
            success: function(result) {
                $('#state_id').select2({
                    width: '100%',
                    placeholder: "<?php echo e(trans('messages.select_name',['select' => trans('messages.state')])); ?>",
                    data: result.results
                });
                if (state != null) {
                    $("#state_id").val(state).trigger('change');
                }
            }
        });
    }

    function cityName(state, city = "") {
        var city_route = "<?php echo e(route('ajax-list', [ 'type' => 'city' ,'state_id' =>''])); ?>" + state;
        city_route = city_route.replace('amp;', '');

        $.ajax({
            url: city_route,
            success: function(result) {
                $('#city_id').select2({
                    width: '100%',
                    placeholder: "<?php echo e(trans('messages.select_name',['select' => trans('messages.city')])); ?>",
                    data: result.results
                });
                if (city != null || city != 0) {
                    $("#city_id").val(city).trigger('change');
                }
            }
        });
    }
</script><?php /**PATH C:\xampp\htdocs\newpup\resources\views/customer/create.blade.php ENDPATH**/ ?>