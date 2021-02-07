@php
    $pageType = __('trans.edit');
    $pageItem = __('trans.check')
@endphp
@extends('admin.layouts.app')

@section('title', $pageType.' '.$pageItem)

@section('content')
    <div class="row">
        <div class="col-xs-6 center-block" style="float: none">
            <div class="card card-primary mt-5">
                <div class="error_messages">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="card-header">
                    <h3 class="text-center"><i class="fa fa-user"></i> {{ $pageType .' '. $pageItem }}</h3>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => ['admin.check.update', $check -> id], 'method' => 'put', 'files'=> true]) !!}
                        <div class="form-group">
                            {!! Form::label('counter_number', __('trans.counter number'), ['class' => 'control-label']) !!}
                            {!! Form::text('counter_number', $check -> counter_number, [ 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('structure number', __('trans.structure number'), ['class' => 'control-label']) !!}
                            {!! Form::text('structure number', $check -> structure_number, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('plate number', __('trans.plate number'), ['class' => 'control-label']) !!}
                            {!! Form::text('plate number', $check -> plate_number, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_type_id', __('trans.car type'), ['class' => 'control-label']) !!}
                            {!! Form::select('car_type_id', [''=> __('trans.car type')]+$carTypes, array_key_exists($check -> car_type_id, $carTypes)? $check -> car_type_id: '', [ 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('car_model_id', __('trans.model'), ['class' => 'control-label']) !!}
                            {!! Form::select('car_model_id', $carModels, array_key_exists($check -> car_model_id, $carModels)? $check -> car_model_id: '', [ 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('car_size_id', __('trans.car size'), ['class' => 'control-label']) !!}
                            {!! Form::select('car_size_id', [''=> __('trans.car size')]+$carSizes, array_key_exists($check -> car_size_id, $carSizes)? $check -> car_size_id: '', [ 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('car_engine_id', __('trans.engine number'), ['class' => 'control-label']) !!}
                            {!! Form::select('car_engine_id', $carEngines, array_key_exists($check -> car_engine_id, $carEngines)? $check -> car_engine_id: '', [ 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('car_development_code_id', __('trans.car development code'), ['class' => 'control-label']) !!}
                            {!! Form::select('car_development_code_id', $carDevelopmentCode, array_key_exists($check -> car_development_code_id, $carDevelopmentCode)? $check -> car_development_code_id: '', [ 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('car color', __('trans.car color'), ['class' => 'control-label']) !!}
                            {!! Form::text('car color', $check -> car_color, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-3">
                                    {!! Form::label('fuel_level', __('trans.fuel level'), ['class' => 'control-label']) !!}
                                </div>
                                <div class="col-xs-9">
                                    <input name="fuel_level" type="range" value="{{ $check -> fuel_level }}" min="0" max="100"
                                           oninput="this.nextElementSibling.value = this.value+'%'">
                                    <output>{{ $check -> fuel_level }}%</output>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('driver_name', __('trans.driver name'), ['class' => 'control-label']) !!}
                            {!! Form::text('driver_name', $check -> driver_name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_status_report', __('trans.repairs needed'), ['class' => 'control-label']) !!}
                            {!! Form::textarea('car_status_report', $check -> getOriginal('car_status_report'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('technical_id', __('trans.technical name'), ['class' => 'control-label']) !!}
                            {!! Form::select('technical_id', $technicals, array_key_exists($check -> technical_id, $technicals)?$check -> technical_id:'', [ 'class' => 'form-control', 'placeholder' => __('trans.technical name')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('engineer_id', __('trans.engineer name'), ['class' => 'control-label']) !!}
                            {!! Form::select('engineer_id', $engineers, array_key_exists($check -> engineer_id, $engineers)?$check -> engineer_id:'', [ 'class' => 'form-control', 'placeholder' => __('trans.engineer name')]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_status_report_note', __('trans.notes when entering the car'), ['class' => 'control-label']) !!}
                            {!! Form::textarea('car_status_report_note', $check -> getOriginal('car_status_report_note'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('car_images_note', __('trans.car images note'), ['class' => 'control-label']) !!}
                            {!! Form::textarea('car_images_note', $check -> getOriginal('car_images_note'), ['class' => 'form-control']) !!}
                        </div>
                    <div class="form-group">
                        {!! Form::submit($pageType, ['class' => 'form-control btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('links')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('scripts')
    <script>
        $(document).ready(function () {
            $('select[name=car_type_id]').on('change', function () {
                let car_type_id = $(this).children(':selected').val();
                let car_size_element = $('#car_size_id');
                let car_model_element = $('#car_model_id');
                let car_engine_element = $('#car_engine_id');
                let car_development_code_element = $('#car_development_code_id');
                if (car_type_id == ''){
                    car_size_element.html('<option value="">'+'{{ __('trans.car size') }}'+'</option>');
                    car_size_element.prop('disabled', true);

                    car_model_element.html('<option value="">'+'{{ __('trans.model') }}'+'</option>');
                    car_model_element.prop('disabled', true);

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
                                    let value = '';
                                    if (element.id == {{ $check ->car_size_id }})
                                        value = 'selected';
                                    car_size_element.append('<option '+value+' value="'+element.id+'">'+element.name+'</option>');
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
                let car_model_element = $('#car_model_id');
                let car_engine_element = $('#car_engine_id');
                let car_development_code_element = $('#car_development_code_id');
                if (car_size_id == ''){
                    car_model_element.html('<option value="">'+'{{ __('trans.model') }}'+'</option>');
                    car_model_element.prop('disabled', true);

                    car_engine_element.html('<option value="">'+'{{ __('trans.engine number') }}'+'</option>');
                    car_engine_element.prop('disabled', true);

                    car_development_code_element.html('<option value="">'+'{{ __('trans.car development code') }}'+'</option>');
                    car_development_code_element.prop('disabled', true);
                }else {
                    car_model_element.prop('disabled', false);
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
                                car_model_element.empty();
                                $.each(data.carModels, function (index, element){
                                    let value = '';
                                    if (element.id == {{ $check ->car_model_id }})
                                        value = 'selected';
                                    car_model_element.append('<option '+ value +' value="'+element.id+'">'+element.name+'</option>');
                                })
                                car_engine_element.empty();
                                $.each(data.carEngines, function (index, element){
                                    let value = '';
                                    if (element.id == {{ $check ->car_engine_id }})
                                        value = 'selected';
                                    car_engine_element.append('<option '+ value +' value="'+element.id+'">'+element.name+'</option>');
                                })

                                car_development_code_element.empty();
                                $.each(data.carDevelopmentCodes, function (index, element){
                                    let value = '';
                                    if (element.id == {{ $check ->car_development_code_id }})
                                        value = 'selected';
                                    car_development_code_element.append('<option '+ value +' value="'+element.id+'">'+element.name+'</option>');
                                })
                            }
                        }
                    })
                }
            })
        })
    </script>
@endpush
