@php
$pageType = __('trans.upload');
$pageItem = __('trans.device report');

@endphp
@extends('admin.layouts.app')

@section('title', $pageType.' '.$pageItem)

@section('content')
    <div class="row">
        <div class="col-xs-6 center-block" style="float: none">
            <div class="card card-success">
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
                    <h3 class="text-center"><i class="fa fa-user-secret"></i> {{ $pageType .' '. $pageItem }}</h3>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'admin.check.storeDeviceReport', 'method' => 'post', 'files' => true]) !!}
                        {!! Form::hidden('check_id', $check_id) !!}
                        {!! Form::hidden('check_number', $check_number) !!}
                        <div class="form-group">
                            {!! Form::label('report_device', __('trans.device report'), ['class' => 'control-label']) !!}
                            {!! Form::file('report_device[]', ['class' => 'form-control','multiple']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                            {!! Form::submit($pageType, ['class' => 'form-control btn btn-success']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

