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
                                                <option value="">اختر الفرع</option>
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
        {{--<table border="1" width="100%" style="font-size: 20px" class="text-center">

            <colgroup style="background-color:#56bffa">
                <col>
                <col>
                <col>
            </colgroup>
            <colgroup style="background-color:#aeaeae">
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <colgroup style="background-color:#56bffa">
                <col>
                <col>
            </colgroup>
            <colgroup style="background-color:#aeaeae">
                <col>
                <col>
            </colgroup>
            <col style="background-color:#56bffa">
            <colgroup style="background-color:#aeaeae">
                <col>
                <col>
            </colgroup>
            <col>
            <thead>
            <tr>
                <th colspan="15">تاريخ اليومية</th>
            </tr>
            <tr>
                <th colspan="3">الوارد</th>
                <th colspan="4">تفاصيل الكارت</th>
                <th colspan="2">مصروفات</th>
                <th colspan="2">عهدة من الادارة</th>
                <th rowspan="2">نقدى الى الادارة</th>
                <th colspan="2">سلف ورواتب</th>
                <th rowspan="2">البيان</th>
            </tr>
            <tr>
                <td>كاش</td>
                <td>شبكة</td>
                <td>تحويل</td>

                <td>اجور اليد</td>
                <td>قطع جديدة</td>
                <td>قطع مستعملة</td>
                <td>ضريبة 15%</td>

                <td>كاش</td>
                <td>شبكة</td>

                <td>كاش</td>
                <td>شبكة</td>


                <td>كاش</td>
                <td>شبكة</td>

            </tr>

            </thead>
            <tbody>
                @foreach($statements as $statement)
                    <tr>
                        <td>{{ $statement -> imports_cash }}</td>
                        <td>{{ $statement -> imports_network }}</td>
                        <td>{{ $statement -> imports_bank_transfer }}</td>
                        <td>{{ $statement -> card_details_hand_labour }}</td>
                        <td>{{ $statement -> card_details_new_parts }}</td>
                        <td>{{ $statement -> card_details_used_parts }}</td>
                        <td>{{ $statement -> card_details_tax }}</td>
                        <td>{{ $statement -> expenses_cash }}</td>
                        <td>{{ $statement -> expenses_network }}</td>
                        <td>{{ $statement -> custody_administration_cash }}</td>
                        <td>{{ $statement -> custody_administration_network }}</td>
                        <td>{{ $statement -> cash_to_administration }}</td>
                        <td>{{ $statement -> advances_and_salaries_cash }}</td>
                        <td>{{ $statement -> advances_and_salaries_network }}</td>
                        <td>{{ $statement -> notes }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>{{ $total_imports_cash }}</th>
                    <th>{{ $total_imports_network }}</th>
                    <th>{{ $total_imports_bank_transfer }}</th>
                    <th>{{ $total_card_details_hand_labour }}</th>
                    <th>{{ $total_card_details_new_parts }}</th>
                    <th>{{ $total_card_details_used_parts }}</th>
                    <th>{{ $total_card_details_tax }}</th>
                    <th>{{ $total_expenses_cash }}</th>
                    <th>{{ $total_expenses_network }}</th>
                    <th>{{ $total_custody_administration_cash }}</th>
                    <th>{{ $total_custody_administration_network }}</th>
                    <th rowspan="2">{{ $total_cash_to_administration }}</th>
                    <th>{{ $total_advances_and_salaries_cash }}</th>
                    <th>{{ $total_advances_and_salaries_network }}</th>
                    <th rowspan="2">{{ __('trans.total') }}</th>
                </tr>

                <tr>
                    <th colspan="3">{{ $total_imports }}</th>
                    <th colspan="4">{{ $total_card_details }}</th>
                    <th colspan="2">{{ $total_expenses }}</th>
                    <th colspan="2">{{ $total_custody_administration }}</th>
                    <th colspan="2">{{ $total_advances_and_salaries }}</th>

                </tr>
            </tbody>
        </table>
        <table border="1" width="50%" style="font-size: 20px; background-color:#aeaeae; margin: 0 auto" class="text-center">
            <tbody>
            <tr>
                <th colspan="2">تاريخ اليومية</th>
            </tr>
            <tr>
                <td width="30%">{{ $moneySafeOpeningBalance }}</td>
                <td width="70%">رصيد سابق</td>
            </tr>
            <tr>
                <td width="30%">{{ $total_imports }}</td>
                <td width="70%">اجمالى الوارد</td>
            </tr>
            <tr>
                <td width="30%">{{ $total_custody_administration_cash }}</td>
                <td width="70%">عهدة من الادارة</td>
            </tr>
            <tr>
                <td width="30%">{{ $total_expenses_cash }}</td>
                <td width="70%">مصروفات</td>
            </tr>
            <tr>
                <td width="30%">{{ $total_advances_and_salaries_cash }}</td>
                <td width="70%">سلف ورواتب</td>
            </tr>
            <tr>
                <td width="30%">{{ $total_cash_to_administration }}</td>
                <td width="70%">نقدى للادارة</td>
            </tr>
            <tr>
                <td width="30%">{{ $total_imports_network + $total_imports_bank_transfer }}</td>
                <td width="70%">بنك تحويل وشبكة</td>
            </tr>
            <tr>
                <td width="30%">
                    {{
                        $moneySafeOpeningBalance +
                        $total_imports_cash -
                        $total_expenses +
                        $total_custody_administration -
                        $total_cash_to_administration -
                        $total_advances_and_salaries
                    }}
                </td>
                <td width="70%">الرصيد الحالى</td>
            </tr>

            </tbody>
        </table>--}}
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

{{--    <script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>--}}

    {{--<script>
        $('#start_date').datepicker({
            autoclose: true,
            todayBtn: "linked",
            format: "yyyy-mm-dd"
        });
        $('#end_date').datepicker({
            autoclose: true,
            todayBtn: "linked",
            format: "yyyy-mm-dd"
        });


        // $('#filter_date_button').on('click', function () {
        $(document).on('change', 'input, select', function () {
            let start_date = $('#start_date').val();
            let end_date    = $('#end_date').val();
            let branch_id    = $('#branch_id').val();
            getStatementByBranchAndDate(start_date, end_date, branch_id);

        });

        function getStatementByBranchAndDate(startDate, endDate, branchId) {
            // console.log(startDate, endDate, branchId);

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

    </script>--}}

    <!-- date-range-picker -->
    <script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script>
        let startDate,
            endDate;
            // branch_selected_name,
            // table = $('#filter_result'),
            // title_table = $('#title_result');

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
                    // $(document).on('change', 'input, select', function () {
                    // function getFilterResultByDate() {
                    startDate = start.format('YYYY-M-D');
                    endDate = end.format('YYYY-M-D');
                    getFilterResult(startDate, endDate);
                    // $('#daterange-btn span').text(start.format('YYYY-M-D') + ' - ' + end.format('YYYY-M-D'));
                    // getStatementByBranchAndDate(startDate, endDate, branch_id);
                    // });

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
            // console.log(startDate, endDate, branchId);

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
