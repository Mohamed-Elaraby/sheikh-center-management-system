@extends('admin.layouts.app')

@section('title', __('trans.all car images'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="error_messages text-center">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('delete'))
                        <div class="alert alert-danger">
                            {{ session('delete') }}
                        </div>
                    @endif
                </div>
                <div class="card-header" style="margin: 20px 0">
                    <div class="row">
                        <div class="col-xs-6">

                            <h3 style="margin: 0; padding: 0; display: inline"> <i class="fa fa-check"></i> {{ request('type') == 2? __('trans.device report') :__('trans.all car images') }}</h3>
                        </div>
                        <div class="col-xs-6">
                            <a href="{{ url()->previous() }}" class="btn btn-success btn-sm pull-right"><i class="fa fa-backward"></i> {{ __('trans.go back') }}</a>
                        </div>
                        {{--<div class="col-xs-6">
                            @if (Auth::user()->hasPermission('create-check'))
                                <a href="{{ route('admin.check.create') }}" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{ __('trans.create') }}</a>
                            @endif
                        </div>--}}
                    </div>
                </div>
                <div class="card-body">
                    <table id="images_table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ request('type') == 2? __('trans.device report') :__('trans.all car images') }}</th>
                            <th>{{ __('trans.last update') }}</th>
                            <th>{{ __('trans.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($images as $index => $image)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><img class="img-thumbnail" src="{{ asset($image -> check_images_path)}}" alt="" height="150" width="150"></td>
                                <td style="direction:ltr; {!! LaravelLocalization::getCurrentLocale() == 'ar'?"float:right":"float:left" !!}">
                                    {{ $image -> updated_at -> format('d/m/Y - h:i:s a') }}
                                </td>
                                <td>
                                    <button class="printButton btn btn-warning" data-link="{{ asset($image -> check_images_path)}}"> <i class="fa fa-print"></i> </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('links')
    <!-- Datatable Bootstrap Css Files -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/datatableButtonsCssFiles/buttons.dataTables.min.css') }}">
@endpush

@push('scripts')
    <!-- Datatable Bootstrap JavaScript Files -->
    <script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <!-- Datatable Bootstrap Options -->
    <script>
        $('#images_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "order": [[ 2, "desc" ]],
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "scrollX": true,
            dom: 'lBfrtip',
            "aLengthMenu": [[5,10,25,50,100,-1], [5,10,25,50,100,"All"]],
        });
    </script>
    <!-- Custom Function -->
    <script>
        // Show Confirm Message For Delete Any Item
        function showDeleteMessage (){
            let deleteMessage = '{{ __('trans.are you sure delete this') }}';
            return confirm(deleteMessage);
        }
    </script>
    <script>
        // Print Image Function
        $(document).ready(function (){
            $('.printButton').click(function () {
                let image_path = $(this).attr('data-link');
                let printWindow = window.open(image_path,'_blank');
                printWindow.window.print();
            })
        });
    </script>
@endpush

