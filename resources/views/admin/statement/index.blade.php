@extends('admin.layouts.app')

@section('title', 'Statement')

@section('content')

        <div class="row">
            <div class="text-center">
                <div class="col-xs-offset-3 col-xs-6">
                    <div class="">
{{--                        <form>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="branch_id">اختر الفرع</label>--}}
{{--                                <select class="form-control" name="branch_id" id="branch_id">--}}
{{--                                    <option value=""></option>--}}
{{--                                    @foreach ($branch_list as $branch)--}}
{{--                                        <option value="{{ $branch -> id }}">{{ $branch -> display_name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="start_date">من تاريخ</label>--}}
{{--                                <input class="form-control" type="text" id="start_date" value="" placeholder="من تاريخ" autocomplete="off">--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="end_date">الى تاريخ</label>--}}
{{--                                <input class="form-control" type="text" id="end_date" value="" placeholder="الى تاريخ" autocomplete="off">--}}
{{--                            </div>--}}
{{--                            <button type="button" id="filter_date_button" class="btn btn-success">بحث <i class="fa fa-search"></i> </button>--}}
{{--                            <button type="reset" id="filter_date_button" class="btn btn-danger"><i class="fa fa-remove"></i> تفريغ خانات البحث </button>--}}
{{--                            --}}{{--                    <button type="button" id="refresh_date_button" class="btn btn-warning btn-xs">اعادة تحميل <i class="fa fa-refresh"></i> </button>--}}
{{--                        </form>--}}

<!-- Date and time range -->
                        <div class="row">
                            <div class="col-xs-12">
                                <form class="form-inline" style=" text-align: center; margin-top: 20px">
                                    <!-- Date and time range -->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                                <span>
                                                  <i class="fa fa-calendar"></i> اختر تاريخ البحث
                                                </span>
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                        </div>
                                        <div class="input-group">
                                            <select id="branch_id" class="form-control">
                                                @if(auth() -> user() -> branch_id === null)
                                                    <option value="">اختر الفرع</option>
                                                @endif
                                                @foreach ($branch_list as $branch)
                                                    <option value="{{ $branch -> id }}">{{ $branch -> display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.form group -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="show_data">

        </div>

@endsection
@push('links')
    <link rel="stylesheet" href="{{ asset('assets/receipt/css/orders.css') }}">
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
{{--    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">--}}
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/receipt/js/mainReceipt.js') }}"></script>

    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    <!-- date-range-picker -->
    <script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script>
        let startDate,
            endDate;
            //Date range as a button

            let branch_id = $('#branch_id').val();
            $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'اليوم': [moment(), moment()],
                        'امس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'اخر 7 ايام': [moment().subtract(6, 'days'), moment()],
                        'اخر 30 يوم': [moment().subtract(29, 'days'), moment()],
                        'الشهر الحالى': [moment().startOf('month'), moment().endOf('month')],
                        'الشهر الماضي': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                        'العام الحالى': [moment().startOf('year'), moment().endOf('year')],
                        'العام الماضي': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    startDate = start.format('YYYY-M-D');
                    endDate = end.format('YYYY-M-D');
                    getFilterResult(startDate, endDate);


                }
            );

        function getFilterResult(start_d, end_d) {
            start_d = startDate || '';
            end_d = endDate || '';
            branch_id = $('#branch_id').val();
            getStatementByBranchAndDate(start_d, end_d, branch_id);
            console.log(start_d, end_d, branch_id)

        }

        $('#branch_id').on('change', function () {
            getFilterResult();
        });

        function getStatementByBranchAndDate(startDate, endDate, branchId) {
            $.ajax({
                url: "{{ route('admin.statement.table') }}",
                method: 'GET',
                data: {startDate: startDate, endDate: endDate, branchId: branchId},
                success: function (data) {
                    let show_data = $('.show_data');
                    show_data.empty();
                    show_data.html(data);
                }
            })
        }
    </script>
@endpush
