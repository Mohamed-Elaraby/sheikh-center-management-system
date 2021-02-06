@extends('admin.layouts.app')

@section('title', __('trans.all engineers list'))

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
                            <h3 style="margin: 0; padding: 0; display: inline">{{ request('branch_id')?__('trans.all engineers list').'['.$branchName.']': __('trans.all engineers list')}}</h3>
                        </div>
                        <div class="col-xs-6">
                            @if (Auth::user()->hasPermission('create-engineers'))
                                <a href="{{ route('admin.engineers.create') }}" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{ __('trans.create') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! $dataTable->table(['class' => 'table table-bordered table-striped']) !!}
{{--                    <table id="engineers_table" class="table table-bordered table-striped">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>#</th>--}}
{{--                            <th>{{ __('trans.engineer name') }}</th>--}}
{{--                            <th>{{ __('trans.branch name') }}</th>--}}
{{--                            <th>{{ __('trans.last update') }}</th>--}}
{{--                            <th>{{ __('trans.action') }}</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @foreach ($engineers as $index => $engineer)--}}
{{--                            <tr>--}}
{{--                                <td>{{ $index + 1 }}</td>--}}
{{--                                <td>{{ $engineer -> name }}</td>--}}
{{--                                <td>{{ $engineer -> branch -> name }}</td>--}}
{{--                                <td style="direction:ltr; {!! LaravelLocalization::getCurrentLocale() == 'ar'?"float:right":"float:left" !!}">--}}
{{--                                    {{ $engineer -> updated_at -> format('d/m/Y - h:i:s a') }}--}}
{{--                                </td>                                <td>--}}
{{--                                    @if (Auth::user()->hasPermission('update-engineers'))--}}
{{--                                        <a href="{{ route('admin.engineers.edit', $engineer->id) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> {{ __('trans.edit') }}</a>--}}
{{--                                    @endif--}}
{{--                                    @if (Auth::user()->hasPermission('delete-engineers'))--}}
{{--                                        {!! Form::open(['route' => ['admin.engineers.destroy', $engineer->id], 'method' => 'delete', 'style' => 'display:inline']) !!}--}}
{{--                                        <button class="btn btn-sm btn-danger" onclick="return showDeleteMessage()"> <i class="fa fa-remove"></i> {{ __('trans.delete') }}</button>--}}
{{--                                        {!! Form::close() !!}--}}
{{--                                    @endif--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('links')
    <!-- Datatable Bootstrap Css Files -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/datatableButtonsCssFiles/buttons.dataTables.min.css') }}">
    @if (LaravelLocalization::getCurrentLocale() === 'ar')
        <style>
            .date_dir_setting
            {
                direction:ltr;
                text-align: right;
            }
        </style>
    @endif

@endpush

@push('scripts')
    <!-- Datatable Bootstrap JavaScript Files -->
    <script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    {!! $dataTable->scripts() !!}
    <!-- Datatable Bootstrap Options -->
<!--    <script>
        $('#engineers_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "order": [[ 3, "desc" ]],
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "scrollX": true,
            dom: 'lBfrtip',
            "aLengthMenu": [[5,10,25,50,100,-1], [5,10,25,50,100,"All"]],
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
                {
                    extend: 'copy',
                    text: 'Copy',
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                },{
                    extend: 'pdf',
                    text: 'PDF',
                },
                {
                    extend: 'print',
                    text: 'Print',
                },
            ]
        });
    </script>-->
    <!-- Custom Function -->
    <script>

        // Show Confirm Message For Delete Any Item
        function showDeleteMessage (){
            let deleteMessage = '{{ __('trans.are you sure delete this') }}';
            return confirm(deleteMessage);
        }
    </script>
@endpush


