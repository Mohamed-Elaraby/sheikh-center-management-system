@extends('admin.layouts.app')

@section('title', __('trans.details data for examination'))

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
                            <div class="row">
                                <div class="col-xs-6">
                                    <h3 style="margin: 0; padding: 0; display: inline"> <i class="fa fa-check"></i> {{ __('trans.details data for examination') }}</h3>
                                </div>
                                <div class="col-xs-6">
                                    @if (Auth::user()->hasPermission('update-check'))
                                        <a href="{{ route('admin.check.edit', $check->id) }}" class="btn btn-sm btn-primary " title="تعديل بيانات الفحص"> <i class="fa fa-edit"></i> {{ __('trans.edit check') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <a href="{{ url()->previous() }}" class="btn btn-success btn-sm pull-right"><i class="fa fa-backward"></i> {{ __('trans.go back') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="text-center">[ {{ __('trans.check number') .' - '. $check -> check_number}} ]</h2>
                    <table id="check_table" class="table table-bordered table-striped">
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.editor') }} :</th>
                            <td>{{ $check -> user -> name }}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.branch') }} :</th>
                            <td>{{ $check -> branch -> name }}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.client name') }} :</th>
                            <td>{{ $check -> client -> name }}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.phone') }} :</th>
                            <td>{{ $check -> client -> phone }}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.counter number') }} :</th>
                            <td>{{ $check -> counter_number }}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.structure number') }} :</th>
                            <td>{{ $check -> structure_number }}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.plate number') }} :</th>
                            <td>{{ $check -> plate_number }}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.car color') }} :</th>
                            <td>{{ $check -> car_color }}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.car type') }} :</th>
                            <td>{{ $check -> carType? $check -> carType ->name: '' }}</td>
                        </tr>

                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.car size') }} :</th>
                            <td>{{ $check -> carSize? $check -> carSize -> name: '' }}</td>
                        </tr>

                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.model') }} :</th>
                            <td>{{ $check -> carModel ->name ?? ''  }}</td>
                        </tr>

                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.engine number') }} :</th>
                            <td>{{ $check -> carEngine ->name ?? ''  }}</td>
                        </tr>

                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.car development code') }} :</th>
                            <td>{{ $check -> carDevelopmentCode ->name ?? ''  }}</td>
                        </tr>

                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.driver name') }} :</th>
                            <td>{{ $check -> driver_name }}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.fuel level') }} :</th>
                            <td>{{ $check -> fuel_level }}%</td>
                        </tr>

                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.technical name') }} :</th>
                            <td>{{ $check -> technical?$check -> technical -> name:'' }}</td>
                        </tr>

                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.engineer name') }} :</th>
                            <td>{{ $check -> engineer?$check -> engineer -> name:'' }}</td>
                        </tr>

                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.status') }} :</th>
                            <td>{{ $check -> checkStatus? $check -> checkStatus -> name: '' }}</td>
                        </tr>

                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.repairs needed') }} :</th>
                            <td>{!! $check -> car_status_report !!}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.notes when entering the car') }} :</th>
                            <td>{!! $check -> car_status_report_note !!}</td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.car images note') }} :</th>
                            <td>{!! $check -> car_images_note !!}</td>
                        </tr>

                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.car entry date') }} :</th>
                            <td style="direction:ltr; {!! LaravelLocalization::getCurrentLocale() == 'ar'?"float:right":"float:left" !!}">
                                {{ $check -> created_at -> format('d/m/Y - h:i:s a') }}
                            </td>
                        </tr>
                        <tr>
                            <th width="30%" class="bg-gray">{{ __('trans.car exit date') }} :</th>
                            <td style="direction:ltr; {!! LaravelLocalization::getCurrentLocale() == 'ar'?"float:right":"float:left" !!}">
                                {{ $check -> car_exit_date?$check -> car_exit_date -> format('d/m/Y - h:i:s a'):'' }}
                            </td>
                        </tr>
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
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <!-- Datatable Bootstrap Options -->
    <script>
        $('#check_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "order": [[ 8, "desc" ]],
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
    </script>
    <!-- Custom Function -->
    <script>

        // Show Confirm Message For Delete Any Item
        function showDeleteMessage (){
            let deleteMessage = '{{ __('trans.are you sure delete this') }}';
            return confirm(deleteMessage);
        }
    </script>
@endpush

