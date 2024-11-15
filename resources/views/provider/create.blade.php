<x-master-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">{{ $pageTitle ?? __('messages.list') }}</h5>
                            <a href="{{ route('provider.index') }}" class="float-right btn btn-sm btn-primary"><i
                                    class="fa fa-angle-double-left"></i> {{ __('messages.back') }}</a>
                            @if($auth_user->can('provider list'))
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($providerdata,['method' => 'POST','route'=>'provider.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'provider'] ) }}
                        {{ Form::hidden('id') }}
                        {{ Form::hidden('user_type','provider') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                {{ Form::label('first_name',__('messages.first_name').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                {{ Form::text('first_name',old('first_name'),['placeholder' => __('messages.first_name'),'class' =>'form-control','required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('last_name',__('messages.last_name').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                {{ Form::text('last_name',old('last_name'),['placeholder' => __('messages.last_name'),'class' =>'form-control','required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('username',__('messages.username').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                {{ Form::text('username',old('username'),['placeholder' => __('messages.username'),'class' =>'form-control','required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('email', __('messages.email').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::email('email', old('email'), ['placeholder' => __('messages.email'), 'class' => 'form-control', 'required', 'pattern' => '[^@]+@[^@]+\.[a-zA-Z]{2,}', 'title' => 'Please enter a valid email address']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            @if (!isset($providerdata->id) || $providerdata->id == null)
                            <div class="form-group col-md-4">
                                {{ Form::label('password', __('messages.password').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('messages.password'), 'required', 'autocomplete' => 'new-password']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            @endif

                            <div class="form-group col-md-4">
                                {{ Form::label('designation',__('messages.designation'),['class'=>'form-control-label'], false ) }}
                                {{ Form::text('designation',old('designation'),['placeholder' => __('messages.designation'),'class' =>'form-control']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('providertype_id', __('messages.select_name',[ 'select' => __('messages.providertype') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('providertype_id', [optional($providerdata->providertype)->id => optional($providerdata->providertype)->name], optional($providerdata->providertype)->id, [
                                        'class' => 'select2js form-group providertype',
                                        'required',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.providertype') ]),
                                        'data-ajax--url' => route('ajax-list', ['type' => 'providertype']),
                                    ]) }}
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('country_id', __('messages.select_name',[ 'select' => __('messages.country') ]),['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('country_id', [$country_id => $country_name], $country_id, [
                                        'class' => 'select2js form-group country',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.country') ]),
                                        'disabled' => 'true',
                                        'data-ajax--url' => route('ajax-list', ['type' => 'country']),
                                    ]) }}
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('state_id', __('messages.select_name',[ 'select' => __('messages.state') ]),['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('state_id', [], [
                                        'class' => 'select2js form-group state_id',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.state') ]),
                                    ]) }}
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('city_id', __('messages.select_name',[ 'select' => __('messages.city') ]),['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('city_id', [], old('city_id'), [
                                        'class' => 'select2js form-group city_id',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.city') ]),
                                    ]) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('name', __('messages.select_name',[ 'select' => __('messages.tax') ]),['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('tax_id[]', [], old('tax_id'), [
                                        'class' => 'select2js form-group tax_id',
                                        'id' =>'tax_id',
                                        'multiple' => 'multiple',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.tax') ]),
                                    ]) }}
                                <!-- 'multiple' => 'multiple', -->
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('contact_number',__('messages.contact_number').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                {{ Form::text('contact_number',old('contact_number'),['placeholder' => __('messages.contact_number'),'class' =>'form-control contact_number','required']) }}
                                <small class="help-block with-errors text-danger" id="contact_number_err"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('status',__('messages.status').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                {{ Form::select('status',['1' => __('messages.active') , '0' => __('messages.inactive') ],old('status'),[ 'class' =>'form-control select2js','required']) }}
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-control-label" for="profile_image">{{ __('messages.profile_image') }}
                                </label>
                                <div class="custom-file">
                                    <input type="file" name="profile_image" class="custom-file-input" accept="image/*">
                                    <label
                                        class="custom-file-label upload-label">{{  __('messages.choose_file',['file' =>  __('messages.profile_image') ]) }}</label>
                                </div>
                                <!-- <span class="selected_file"></span> -->
                            </div>

                            @if(getMediaFileExit($providerdata, 'profile_image'))
                            <div class="col-md-2 mb-2">
                                <img id="profile_image_preview" src="{{getSingleMedia($providerdata,'profile_image')}}"
                                    alt="#" class="attachment-image mt-1">
                                <a class="text-danger remove-file"
                                    href="{{ route('remove.file', ['id' => $providerdata->id, 'type' => 'profile_image']) }}"
                                    data--submit="confirm_form" data--confirmation='true' data--ajax="true"
                                    data-toggle="tooltip"
                                    title='{{ __("messages.remove_file_title" , ["name" =>  __("messages.image") ]) }}'
                                    data-title='{{ __("messages.remove_file_title" , ["name" =>  __("messages.image") ]) }}'
                                    data-message='{{ __("messages.remove_file_msg") }}'>
                                    <i class="ri-close-circle-line"></i>
                                </a>
                            </div>
                            @endif

                            <div class="form-group col-md-12">
                                {{ Form::label('address',__('messages.address'), ['class' => 'form-control-label']) }}
                                {{ Form::textarea('address', null, ['class'=>"form-control textarea" , 'rows'=>1  , 'placeholder'=> __('messages.address') ]) }}
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div id="neoAccordion">
                                    <div class="card">
                                        <div class="card-header" id="neoAcjabs">
                                            <h5 class="mb-0">
                                                <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseAccjabs" aria-expanded="true" aria-controls="collapseAccjabs">
                                                    Name: 
                                                </button>
                                                <button type="button" class="btn btn-danger float-right" onClick="removeUpline('id');">
                                                    Remove
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseAccjabs" class="collapse " aria-labelledby="neoAcjabs" data-parent="#neoAccordion">
                                            <div class="card-body">
                                                <span><b></b></span><br>
                                                <span>Name: </span><br>
                                                <span>Contact no.: </span><br>
                                                <span>Email: </span><br>
                                                <span>Address: </span><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="">
                                    <div class="">
                                        <div class="d-flex p-3 ">
                                                <h5 class="font-weight-bold">Search Neopreneur</h5>
                                        </div>
                                        @if(isset($providerdata->sp_neo_id))
                                            @php $getUpline = Illuminate\Support\Facades\DB::table('users')->where('id', $providerdata->sp_neo_id)->first(); @endphp
                                            @php $getProviderUpline = Illuminate\Support\Facades\DB::table('users')->where('id', $getUpline->neo_neo_id)->first(); @endphp
                                        @endif
                                        <div class="input-group ml-2 mb-2">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-search"></i></span>
                                            <input type="text" class="form-control " placeholder="Search..." id="searchNeo" value="{{ isset($getUpline->display_name) ? $getUpline->display_name : '' }}">
                                            <input type="hidden" name="neo" id="neoReferralCode">
                                            <input type="hidden" name="neoUpline" id="neouplineCode">

                                            <input type="hidden" name="neo_id" id="neo_id">
                                            <input type="hidden" name="upline_neo_id" id="upline_neo_id">
                                        </div>
                                        <div id="pangError" class="ml-2">
                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="">
                                    <div class="">
                                        <div class="d-flex p-3 ">
                                                <h5 class="font-weight-bold">Search Upline</h5>
                                        </div>
                                        <div class="input-group ml-2 mb-2">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-search"></i></span>
                                            <input type="text" class="form-control " placeholder="Search..." id="searchUpline" value="{{ isset($getProviderUpline->display_name) ? $getProviderUpline->display_name : '' }}">
                                            <input type="hidden" name="spNeoUpline" id="uplineReferralCode">
                                        </div>
                                        <div id="pangErrorUpline" class="ml-2">
                            
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="custom-control custom-switch custom-control-inline ">
                                    {{ Form::checkbox('is_featured', $providerdata->is_featured, null, ['class' => 'custom-control-input' , 'id' => 'is_featured' ]) }}
                                    <label class="custom-control-label"
                                        for="is_featured">{{ __('messages.set_as_featured')  }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        {{ Form::submit( __('messages.save'), ['class'=>'btn btn-md btn-primary float-right']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
    $data = $providerdata->providerTaxMapping->pluck('tax_id')->implode(',');
    @endphp
    @section('bottom_script')
    <script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function() {
            var country_id = "{{ isset($providerdata->country_id) ? $providerdata->country_id : 173 }}";
            var state_id = "{{ isset($providerdata->state_id) ? $providerdata->state_id : 0 }}";
            var city_id = "{{ isset($providerdata->city_id) ? $providerdata->city_id : 0 }}";

            var provider_id = "{{ isset($providerdata->id) ? $providerdata->id : '' }}";
            var provider_tax_id = "{{ isset($data) ? $data : [] }}";

            getTax(provider_id, provider_tax_id)
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
                cityName(state, city_id);
            })
        })

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

    $('#searchNeo').on('keyup', () => {
        var data = {
            name: $('#searchNeo').val()
        }
        $.ajax({
            type: 'GET',
            url: '{{ route("booking.sp_search_neo") }}',
            data: data,
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                var nData = data.data;
                console.log(nData)
                if(data.status == "error"){
                   $('#pangError').html("") 
                   $('#pangError').append(`<label class="text-danger ml-2">Email not found !</label>`)
                   $("#neoReferralCode").val("");
                   $('#searchUpline').val("");
                   $('#neoReferralCode').val("")
                   $('#pangErrorUpline').html("")
                   $('#neo_id').val("");
                   $('#upline_neo_id').val("");
                   $('#searchUpline').attr('disabled', true)
                   
                }else{
                    $('#pangError').html("");
                    $('#pangError').append(`<label class="text-success ml-2">Email matched !</label>`)
                    $("#neoReferralCode").val(nData.referal_code);
                    $("#neouplineCode").val(nData.upline);
                    $('#searchUpline').val(data.uplineEmail);

                    $('#neo_id').val(nData.id);
                    $('#upline_neo_id').val(nData.neo_neo_id);

                    $('#pangErrorUpline').html("");
                   
                    console.log('pasok')
                    if(data.uplineEmail == ""){
                        $('#pangErrorUpline').html("");
                        $("#uplineReferralCode").val("");
                        console.log('pasok2')
                    }else{
                        console.log('pasok3')
                        $("#uplineReferralCode").val(data.ref_neo);
                        $('#pangErrorUpline').append(`<label class="text-success ml-2">Email matched !</label>`)
                        $('#searchUpline').attr('disabled', true)
                    }
                    // $('#neoReferralCode').val(nData.upline)
                    
                 
                }
            }
        })
    })
    $('#searchUpline').on('keyup', () => {
        var data = {
            name: $('#searchUpline').val(),
            refid: $('#neoReferralCode').val()
        }
        $.ajax({
            type: 'GET',
            url: '{{ route("booking.sp_search_upline") }}',
            data: data,
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                var nData = data.data;
                console.log(data)
                if(data.status == "error"){
                    $('#pangErrorUpline').html("") 
                    $('#pangErrorUpline').append(`<label class="text-danger ml-2">Email not found !</label>`)
                    $("#uplineReferralCode").val("");
                }else{
                    $('#pangErrorUpline').html("");
                    $('#pangErrorUpline').append(`<label class="text-success ml-2">Email matched !</label>`)
                    $("#uplineReferralCode").val(nData.referal_code);
                }
            }
        })
    })
        function stateName(country, state = "") {
            var state_route = "{{ route('ajax-list', [ 'type' => 'state','country_id' =>'']) }}" + country;
            state_route = state_route.replace('amp;', '');

            $.ajax({
                url: state_route,
                success: function(result) {
                    $('#state_id').select2({
                        width: '100%',
                        placeholder: "{{ trans('messages.select_name',['select' => trans('messages.state')]) }}",
                        data: result.results
                    });
                    if (state != null) {
                        $("#state_id").val(state).trigger('change');
                    }
                }
            });
        }

        function cityName(state, city = "") {
            var city_route = "{{ route('ajax-list', [ 'type' => 'city' ,'state_id' =>'']) }}" + state;
            city_route = city_route.replace('amp;', '');

            $.ajax({
                url: city_route,
                success: function(result) {
                    $('#city_id').select2({
                        width: '100%',
                        placeholder: "{{ trans('messages.select_name',['select' => trans('messages.city')]) }}",
                        data: result.results
                    });
                    if (city != null || city != 0) {
                        $("#city_id").val(city).trigger('change');
                    }
                }
            });
        }

        function getTax(provider_id, provider_tax_id = "") {
            var provider_tax_route = "{{ route('ajax-list', [ 'type' => 'provider_tax','provider_id' =>'']) }}" +
                provider_id;
            provider_tax_route = provider_tax_route.replace('amp;', '');

            $.ajax({
                url: provider_tax_route,
                success: function(result) {
                    $('#tax_id').select2({
                        width: '100%',
                        placeholder: "{{ trans('messages.select_name',['select' => trans('messages.tax')]) }}",
                        data: result.results
                    });
                    if (provider_tax_id != "") {
                        $('#tax_id').val(provider_tax_id.split(',')).trigger('change');
                    }
                }
            });
        }
    })(jQuery);
    </script>
    @endsection
</x-master-layout>