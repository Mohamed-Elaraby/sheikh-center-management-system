@php
    $pageType = __('trans.edit');
    $pageItem = __('trans.user');
    $profile_picture_path = $user -> image_name == 'default.png' ? 'storage' .DIRECTORY_SEPARATOR. 'default.png' : $user -> profile_picture_path
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
                    {!! Form::open(['route' => ['admin.users.update', $user -> id], 'method' => 'put', 'files'=> true]) !!}
                    <div class="form-group">
                        {!! Form::label('name', __('trans.username'), ['class' => 'control-label']) !!}
                        {!! Form::text('name', $user -> name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', __('trans.email'), ['class' => 'control-label']) !!}
                        {!! Form::email('email', $user -> email, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('job_title_id', __('trans.job title'), ['class' => 'control-label']) !!}
                        {!! Form::select('job_title_id', $jobTitle, array_key_exists($user->job_title_id, $jobTitle)?$user->job_title_id:'', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', __('trans.password'), ['class' => 'control-label']) !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', __('trans.password confirmation'), ['class' => 'control-label']) !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('role_id', __('trans.role'), ['class' => 'control-label']) !!}
                        {!! Form::select('role_id', [''=> '-- أختر واحد --']+$roles , array_key_exists($user -> role_id, $roles)?$user -> role_id:'' , ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('branch_id', __('trans.branch'), ['class' => 'control-label']) !!}
                        {!! Form::select('branch_id', [''=> '-- أختر واحد --']+$branches , array_key_exists($user -> branch_id, $branches)?$user -> branch_id:'' , ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('profile_picture', __('trans.profile picture'), ['class' => 'control-label']) !!}
                        {!! Form::file('profile_picture', ['class' => 'form-control', 'id' => 'myImg']) !!}
                    </div>
                    <div class="form-group">
                        <img class="img-thumbnail" id="imagePreview" src="{{ asset($profile_picture_path) }}" height="100px" width="100px">
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
@push('scripts')
    @include('admin.includes.imagePreviewJQueryCode')
@endpush
