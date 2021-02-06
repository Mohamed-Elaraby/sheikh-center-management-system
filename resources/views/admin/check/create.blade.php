@php
$pageType = __('trans.create');
$pageItem = __('trans.check');
@endphp
@extends('admin.layouts.app')

@section('title', $pageType.' '.$pageItem)

@section('content')

    <!-- Multi step form -->
    <div id="multiStepForm" class="multiStepForm">

        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 form-box">
                    <!-- Open Form -->
                {!! Form::open(['route' => 'admin.check.store', 'method' => 'post', 'files' => true, 'class' => 'f1', 'role'=>'form']) !!}
                {!! Form::hidden('client_id', $targetClient -> id) !!}
                @if ($targetBranch != '')
                    {!! Form::hidden('branch_id', $targetBranch -> id) !!}
                @endif
                    <h2 style="background-color: #3C8DBC; color: #fff">{{ __('trans.sheikh center group') }}</h2>
                    <p>{{ __('trans.create check') }}</p>
                    <div class="f1-steps">
                        <div class="f1-progress">
                            <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 16.66%;"></div>
                        </div>
                        <div class="f1-step active">
                            <div class="f1-step-icon"><i class="fa fa-car"></i></div>
                            <p>{{ __('trans.car data') }}</p>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-wrench"></i></div>
                            <p>{{ __('trans.repairs needed') }}</p>
                        </div>
                        <div class="f1-step ">
                            <div class="f1-step-icon"><i class="fa fa-upload"></i></div>
                            <p>{{ __('trans.car images') }}</p>
                        </div>
                    </div>

                    <fieldset>
                        <h4 class="text-center">{{ __('trans.car data') }}</h4>
                        <div class="form-group">
                            {!! Form::label('counter_number', __('trans.counter number'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::text('counter_number', null, [ 'class' => 'form-control', 'placeholder' => __('trans.counter number')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('structure_number', __('trans.structure number'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::text('structure_number', null, [ 'class' => 'form-control', 'placeholder' => __('trans.structure number')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('plate_number', __('trans.plate number'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::text('plate_number', null, [ 'class' => 'form-control', 'placeholder' => __('trans.plate number')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_type_id', __('trans.car type'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::select('car_type_id', $carTypes, null, [ 'class' => 'form-control', 'placeholder' => __('trans.car type')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_model_id', __('trans.model'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::select('car_model_id', $carModels, null, [ 'class' => 'form-control', 'placeholder' => __('trans.model')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_size_id', __('trans.car size'), ['class' => 'control-label sr-only']) !!}
                            <select class="form-control" name="car_size_id" id="car_sizes_id" disabled>
                                <option value="">{{ __('trans.car size') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_engine_id', __('trans.car engine'), ['class' => 'control-label sr-only']) !!}
                            <select class="form-control" name="car_engine_id" id="car_engine_id" disabled>
                                <option value="">{{ __('trans.engine number') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_development_code_id', __('trans.car development code'), ['class' => 'control-label sr-only']) !!}
                            <select class="form-control" name="car_development_code_id" id="car_development_code_id" disabled>
                                <option value="">{{ __('trans.car development code') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_color', __('trans.car color'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::text('car_color', null, [ 'class' => 'form-control', 'placeholder' => __('trans.car color')]) !!}
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-3">
                                    {!! Form::label('fuel_level', __('trans.fuel level'), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-xs-9">
                                    <input name="fuel_level" type="range" value="50" min="0" max="100"
                                    oninput="this.nextElementSibling.value = this.value+'%'">
                                    <output>50%</output>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('driver_name', __('trans.driver name'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::text('driver_name', null, ['class' => 'form-control', 'placeholder' => __('trans.driver name')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('technical_id', __('trans.technical name'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::select('technical_id', $technicals, null, [ 'class' => 'form-control', 'placeholder' => __('trans.technical name')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('engineer_id', __('trans.engineer name'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::select('engineer_id', $engineers, null, [ 'class' => 'form-control', 'placeholder' => __('trans.engineer name')]) !!}
                        </div>
                        <div class="f1-buttons">
                            <button type="button" class="btn btn-next">{{ __('trans.next') }}</button>
                        </div>
                    </fieldset>

                    <fieldset>
                        <h4 class="text-center">{{ __('trans.repairs needed') }}</h4>
                        <div class="form-group">
                            {!! Form::label('car_status_report', __('trans.repairs needed'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::textarea('car_status_report', null, ['class' => 'form-control', 'placeholder' => __('trans.repairs needed')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_status_report_note', __('trans.notes when entering the car'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::textarea('car_status_report_note', null, ['class' => 'form-control', 'placeholder' => __('trans.notes when entering the car')]) !!}
                        </div>
                        <div class="f1-buttons">
                            <button type="button" class="btn btn-previous">{{ __('trans.previous') }}</button>
                            <button type="button" class="btn btn-next">{{ __('trans.next') }}</button>
                        </div>
                    </fieldset>

                    <fieldset>
                        <h4 class="text-center">{{ __('trans.car images') }}</h4>
                        <div class="form-group">
                            <label for="upload_button" class="upload_button">
                                <span> أختر الصور </span>
                                <i class="fa fa-upload fa-2x"></i>
                                {!! Form::file('car_images[]', ['multiple', 'id'=> 'upload_button']) !!}

                            </label>
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_images_note', __('trans.car images note'), ['class' => 'control-label sr-only']) !!}
                            {!! Form::textarea('car_images_note', null, ['class' => 'form-control', 'placeholder' => __('trans.car images note')]) !!}
                        </div>
                        <div class="f1-buttons">
                            <button type="button" class="btn btn-previous">{{ __('trans.previous') }}</button>
                            <button type="submit" class="btn btn-submit">{{ __('trans.create') }}</button>
                        </div>
                    </fieldset>
                {!! Form::close() !!}
                <!-- Close Form -->
            </div>
        </div>
    </div>
    <!-- End Multi step form -->
@endsection
@push('links')
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/wizardForm/css/form-elements.css') }}">

    @if( LaravelLocalization::getCurrentLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('assets/wizardForm/css/style_ar.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/wizardForm/css/style_en.css') }}">
    @endif
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom File Inputs -->
    <link rel="stylesheet" href="{{ asset('assets/wizardForm/css/customFileInput.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('scripts')
    <!-- Javascript -->

    <script src="{{ asset('assets/wizardForm/js/jquery.backstretch.min.js') }}"></script>
    <script src="{{ asset('assets/wizardForm/js/retina-1.1.0.min.js') }}"></script>
    <script src="{{ asset('assets/wizardForm/js/scripts.js') }}"></script>

    <!--[if lt IE 10]>
    <script src="{{ asset('assets/wizardForm/js/placeholder.js') }}"></script>
    <![endif]-->
    <!-- Custom File Inputs -->

    <script>
        $(document).ready(function () {
            $('select[name=car_type_id]').on('change', function () {
                let car_type_id = $(this).children(':selected').val();
                let car_size_element = $('#car_sizes_id');
                let car_engine_element = $('#car_engine_id');
                let car_development_code_element = $('#car_development_code_id');
                if (car_type_id == ''){
                    car_size_element.html('<option value="">'+'{{ __('trans.car size') }}'+'</option>');
                    car_size_element.prop('disabled', true);

                    car_engine_element.html('<option value="">'+'{{ __('trans.engine number') }}'+'</option>');
                    car_engine_element.prop('disabled', true);

                    car_development_code_element.html('<option value="">'+'{{ __('trans.car development code') }}'+'</option>');
                    car_development_code_element.prop('disabled', true);
                }else {
                    car_size_element.prop('disabled', false);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('admin.check.getCarSizesByAjax') }}',
                        method: 'POST',
                        data: {car_type_id:car_type_id},
                        success: function (data) {
                            if (!data.error)
                            {
                                car_size_element.empty();
                                car_size_element.append('<option value="">'+'{{ __('trans.car size') }}'+'</option>');
                                $.each(data, function (index, element){
                                    car_size_element.append('<option value="'+element.id+'">'+element.name+'</option>');
                                })
                            }
                        }
                    })
                }
            })
        })
    </script>

    <script>
        $(document).ready(function () {
            $('select[name=car_size_id]').on('change', function () {
                let car_size_id = $(this).children(':selected').val();
                let car_engine_element = $('#car_engine_id');
                let car_development_code_element = $('#car_development_code_id');
                if (car_size_id == ''){
                    car_engine_element.html('<option value="">'+'{{ __('trans.engine number') }}'+'</option>');
                    car_engine_element.prop('disabled', true);

                    car_development_code_element.html('<option value="">'+'{{ __('trans.car development code') }}'+'</option>');
                    car_development_code_element.prop('disabled', true);
                }else {
                    car_engine_element.prop('disabled', false);
                    car_development_code_element.prop('disabled', false);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('admin.check.getCarDevCodeAndEnginesByAjax') }}',
                        method: 'POST',
                        data: {car_size_id},
                        success: function (data) {
                            if (!data.error)
                            {
                                car_engine_element.empty();
                                $.each(data.carEngines, function (index, element){
                                    car_engine_element.append('<option value="'+element.id+'">'+element.name+'</option>');
                                })

                                car_development_code_element.empty();
                                $.each(data.carDevelopmentCodes, function (index, element){
                                    car_development_code_element.append('<option value="'+element.id+'">'+element.name+'</option>');
                                })
                            }
                        }
                    })
                }
            })
        })
    </script>


@endpush
