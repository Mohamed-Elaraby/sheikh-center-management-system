@php
    $pageType = __('trans.edit');
    $pageItem = __('trans.sale order')

@endphp
@extends('admin.layouts.app')

@section('title', $pageType.' '.$pageItem)

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div>
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
                        <div class="card-header">
                            <h3 class="text-center"><i class="fa fa-cart-arrow-down"></i> {{ $pageType .' '. $pageItem }}</h3>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="" id="branch_id" value="{{ $saleOrder -> branch_id }}">
                            {!! Form::open(['route' => ['admin.saleOrders.update', $saleOrder -> id], 'method' => 'put','id' => 'saleOrders']) !!}
                            {!! Form::hidden('invoice_date', $saleOrder -> invoice_date) !!}
                            {!! Form::hidden('branch_id', $saleOrder -> branch_id) !!}
                            {!! Form::hidden('client_id', $saleOrder -> client_id, ['id' => 'client_id']) !!}
                            {!! Form::hidden('check_id', $saleOrder -> check_id) !!}
                            <div style="margin: 0; padding: 0" class="col-xs-12 col-md-3 col-custom-style">
                                <div style="margin: 0; padding-left: 0; padding-right: 0;" class="col-xs-12">
                                    <div class="search_area" style="padding: 10px 0;"> <!-- search box -->
                                        <select id="search_by_category" class="form-control">
                                            <option value="" class="search_placeholder_color">-- بحث عن طريق القسم --</option>
                                            {{--                                            {{ $sub_categories }}--}}
                                            @foreach ($categories as $category)
                                                {{--                                                    <option value="{{ $category-> id }}">{{ $category-> name }}</option>--}}
                                                <optgroup label="{{ $category-> name }}">
                                                    @foreach ($category->subCategories as $sub)
                                                        <option value="{{ $sub -> id }}">{{ $sub -> name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach

                                        </select>
                                        <input type="search" name="" id="search_in_product_code" class="form-control" placeholder="-- بحث عن طريق الاسم او الكود --">
                                    </div>
                                </div> <!-- end search area -->
                                <div style="margin: 0; padding-left: 0; padding-right: 0;" class="col-xs-12">
                                    <div class="product_codes" style="border: #0a0a0a 1px solid; height: 320px; overflow-y: scroll; padding: 5px;">
                                        <table class="table table-responsive">
                                            <thead style="position: sticky; top: 0; background: #42a65a">
                                            <tr>
                                                <th>{{ __('trans.product code') }}</th>
                                                <th>{{ __('trans.product name') }}</th>
                                                <th>{{ __('trans.quantity') }}</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="product_code" class="product_code">

                                            </tbody>

                                        </table>
                                    </div>
                                </div> <!-- end codes area -->
                            </div> <!-- end col 4 -->
                            <div style="margin: 0; padding: 0" class="col-xs-12 col-md-9 col-custom-style">
                                <div class="sale_order_products" style="border: #0a0a0a 1px solid; height: 400px; overflow-y: scroll; padding: 5px; margin-top: 10px">
                                    <table class="table" id="sale_order_products">
                                        <thead style="position: sticky; top: 0; background: #42a65a">
                                        <tr>
                                            <th></th>
                                            <th>{{ __('trans.product code') }}</th>
                                            <th>{{ __('trans.product name') }}</th>
                                            <th>{{ __('trans.quantity') }}</th>
                                            <th>{{ __('trans.selling price') }}</th>
                                            <th>{{ __('trans.amount taxable') }}</th>
                                            <th>{{ __('trans.discount') }}</th>
                                            <th>{{ __('trans.tax amount'). ' (15%) ' }}</th>
                                            <th>{{ __('trans.item sub total including vat') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($saleOrder -> saleOrderProducts -> sortByDesc('id') as $key => $product)
                                            <tr class="{{ $product -> item_code }}">
                                                <input  type="hidden" class="product_quantity" value="">
                                                <td><div class="btn btn-danger btn-sm removeField"><i class="fa fa-trash"></i></div></td>
                                                <td><input id="item_code_{{ $key }}" name="product_data[{{ $key }}][item_code]" type="text" class="form-control item_code" value="{{ $product -> item_code }}" readonly></td>
                                                <td><input id="item_name_{{ $key }}" name="product_data[{{ $key }}][item_name]" type="text" class="form-control item_name" value="{{ $product -> item_name }}" readonly title="{{ $product -> item_name }}"></td>
                                                <td><input id="item_quantity_{{ $key }}" name="product_data[{{ $key }}][item_quantity]" type="text" class="form-control item_quantity onlyUsedForValidation" value="{{ $product -> item_quantity }}" autocomplete="off"><span class="item_quantity_error" style="color: red; display: none"></span></td>
                                                <td><input id="item_price_{{ $key }}" name="product_data[{{ $key }}][item_price]" type="text" class="form-control item_price momo onlyUsedForValidation" value="{{ $product -> item_price }}" autocomplete="off"><span class="item_price_error" style="color: red; display: none"></span></td>
                                                <input id="item_purchasing_price_{{ $key }}" name="product_data[{{ $key }}][item_purchasing_price]" type="hidden" class="form-control item_purchasing_price momo onlyUsedForValidation" value="{{ $product -> item_purchasing_price }}" value="'+productPrice+'" autocomplete="off">
                                                <td><input id="item_amount_taxable_{{ $key }}" name="product_data[{{ $key }}][item_amount_taxable]" type="text" class="form-control item_amount_taxable" value="{{ $product -> item_amount_taxable }}" readonly></td>
                                                <td>
                                                    <div class="input-group my-group">
                                                        <select id="discount_type_{{ $key }}" class="form-control discount_type" value="{{ $product -> item_discount_type }}" name="product_data[{{ $key }}][item_discount_type]">
                                                            <option value="0" {{ $product -> item_discount_type == 0 ? 'selected' : '' }}>ريال</option>
                                                            <option value="1" {{ $product -> item_discount_type == 1 ? 'selected' : '' }}>%</option>
                                                        </select>
                                                        <input id="item_discount_{{ $key }}" name="product_data[{{ $key }}][item_discount]" type="text" class="form-control item_discount" value="{{ $product -> item_discount }}" autocomplete="off">
                                                    </div>
                                                </td>
                                                <input  type="hidden" name="product_data[{{ $key }}][item_discount_amount]" class="item_discount_amount" value="{{ $product -> item_discount_amount }}">
                                                <input  type="hidden" name="product_data[{{ $key }}][item_sub_total_after_discount]" class="item_sub_total_after_discount" value="{{ $product -> item_sub_total_after_discount }}">
                                                <td><input id="item_tax_amount_{{ $key }}" name="product_data[{{ $key }}][item_tax_amount]" type="text" class="form-control item_tax_amount" value="{{ $product -> item_tax_amount }}" readonly></td>
                                                <td><input id="item_sub_total_{{ $key }}" name="product_data[{{ $key }}][item_sub_total]" type="text" class="form-control item_sub_total" value="{{ $product -> item_sub_total }}" readonly></td>
                                                <td><input id="item_id_{{ $key }}" name="product_data[{{ $key }}][product_id]" type="hidden" class="form-control product_id" value="{{ $product -> product_id }}" readonly></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- end col 8 -->
                            <div class="col-xs-12 col-custom-style">
                                <div class="form-group row">
                                    <label for="total" class="col-sm-4 col-form-label">الاجمالى (غير شامل ضريبة القيمة المضافة)</label>
                                    <div class="col-sm-2">
                                        <input readonly type="text" name="total" class="form-control total" id="total" value="{{ $saleOrder -> total }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="discount" class="col-sm-4 col-form-label">مجموع الخصومات</label>
                                    <div class="col-sm-2">
                                        <input readonly type="text" name="discount" class="form-control discount" id="discount" value="{{ $saleOrder -> discount }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="taxable_amount" class="col-sm-4 col-form-label">الاجمالى الخاضع للضريبة (غير شامل ضريبة القيمة المضافة)</label>
                                    <div class="col-sm-2">
                                        <input readonly type="text" name="taxable_amount" class="form-control taxable_amount" id="taxable_amount" value="{{ $saleOrder -> taxable_amount }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="total_vat" class="col-sm-4 col-form-label">مجموع ضريبة القيمة المضافة</label>
                                    <div class="col-sm-2">
                                        <input readonly type="text" name="total_vat" class="form-control total_vat" id="total_vat" value="{{ $saleOrder -> total_vat }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="total_amount_due" class="col-sm-4 col-form-label">اجمالى المبلغ المستحق</label>
                                    <div class="col-sm-2">
                                        <input readonly type="text" name="total_amount_due" class="form-control total_amount_due" id="total_amount_due" value="{{ $saleOrder -> total_amount_due }}">
                                    </div>
                                    <span id="rounding_amount" class="btn btn-success btn-sm">تقريب المبلغ</span>
                                </div>
                                <hr>
                                <div>
                                    <label for=""><b>طريقة الدفع</b></label>
                                    <div class="form-group">
                                        <input class="payment_method" type="checkbox" name="payment_method" id="cash" value="كاش" {{ $saleOrder -> payment_method ? 'checked': '' }}>
                                        <label for="cash">كاش</label>
                                    </div>

                                    <div class="form-group">
                                        <input class="payment_method" type="checkbox" name="payment_method_bank" id="bank_transfer" value="تحويل بنكى" {{ $saleOrder -> payment_method_bank == 'تحويل بنكى' ? 'checked': '' }}>
                                        <label for="bank_transfer">تحويل بنكى</label>

                                        <input class="payment_method" type="checkbox" name="payment_method_bank" id="network" value="شبكة" {{ $saleOrder -> payment_method_bank == 'شبكة' ? 'checked': '' }}>
                                        <label for="network">شبكة</label>

                                        <input class="payment_method" type="checkbox" name="payment_method_bank" id="stc_pay" value="STC-Pay" {{ $saleOrder -> payment_method_bank == 'STC-Pay' ? 'checked': '' }}>
                                        <label for="stc_pay">STC-Pay</label>
                                    </div>
                                    <span id="payment_method_error" style="color: red; display: none"></span>
                                </div>

                                <div id="amounts_group_field">
                                    @if ($saleOrder -> amount_paid)
                                        <div id="safe_amount_field" class="form-group row">
                                            <label for="amount_paid" class="col-sm-4 col-form-label">المبلغ المدفوع فى الخزنة</label>
                                            <div class="col-sm-2">
                                                <input type="text" name="amount_paid" class="form-control amount_paid" id="amount_paid" value="{{ $saleOrder -> amount_paid }}" autocomplete="off">
                                            </div>
                                        </div>
                                    @endif
                                    @if ($saleOrder -> amount_paid_bank)
                                        <div id="bank_field" class="form-group row">
                                            <label for="amount_paid_bank" class="col-sm-4 col-form-label">المبلغ المدفوع فى البنك</label>
                                            <div class="col-sm-2">
                                                <input type="text" name="amount_paid_bank" class="form-control amount_paid_bank" id="amount_paid_bank" value="{{ $saleOrder -> amount_paid_bank }}" autocomplete="off">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <label for="amount_due" class="col-sm-4 col-form-label">المبلغ المتبقى</label>
                                    <div class="col-sm-2">
                                        <input readonly type="text" name="amount_due" class="form-control amount_due" id="amount_due" value="{{ $saleOrder -> amount_due }}">
                                    </div>
                                    <span id="amount_due_error" style="color: red; display: none"></span>
                                </div>

                                <div>
                                    <label for="" class="text-center"><h3>تفاصيل الكارت</h3></label>
                                    <div class="form-group row">
                                        <label for="hand_labour" class="col-sm-4 col-form-label">تحديد مبلغ اجور اليد</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="hand_labour" class="form-control card_details hand_labour" id="hand_labour" value="{{ $saleOrder -> hand_labour }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="new_parts" class="col-sm-4 col-form-label">تحديد مبلغ القطع الجديدة</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="new_parts" class="form-control card_details new_parts" id="new_parts" value="{{ $saleOrder -> new_parts }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="used_parts" class="col-sm-4 col-form-label">تحديد مبلغ القطع المستعملة</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="used_parts" class="form-control card_details used_parts" id="used_parts" value="{{ $saleOrder -> used_parts }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="card_details_tax" class="col-sm-4 col-form-label">تحديد مبلغ الضريبة</label>
                                        <div class="col-sm-2">
                                            <input readonly type="text" name="card_details_tax" class="form-control card_details card_details_tax" id="card_details_tax" value="{{ $saleOrder -> total_vat }}">
                                        </div>
                                    </div>
                                    <span id="card_details_error" style="color: red; display: none"></span>

                                </div>

                            </div> <!-- end col 12 -->
                            <div class="col-xs-12 col-custom-style">
                                <div class="form-group">
                                    <lable><b>ملاحظات</b></lable>
                                    <textarea name="notes" id="note" rows="5" class="form-control" placeholder="ملاحظات">{{ $saleOrder -> notes }}</textarea>
                                </div>
                            </div> <!-- end col 12 -->
                            <div class="col-xs-12 col-custom-style">
                                <div  style="width: 50%; margin: 0 auto">
                                    <div class="form-inline" style="text-align: center">
                                        {!! Form::submit('تعديل', ['class' => 'form-control btn btn-primary', 'name' => 'soft_save']) !!}
                                        {!! Form::submit(' اصدار الفاتورة النهائية و اغلاق الفاتورة', ['class' => 'form-control btn btn-danger', 'name' => 'final_save']) !!}
                                    </div>
                                </div>
                            </div> <!-- end col 12 -->
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('links')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/dist/css/createPurchase&SalePages.css') }}">


    <style>
        .info th, .info td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .my-group .form-control{
            width:50%;
        }
    </style>
@endpush
@push('scripts')

    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <!-- Calculator Script -->
    <script src="{{ asset('js/calculatorScript_edit_page.js') }}"></script>

    <script src="{{ asset('js/jquryValidation/jquery.form.js') }}"></script>
    <script src="{{ asset('js/jquryValidation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/jquryValidation/additional-methods.min.js') }}"></script>

    @if (LaravelLocalization::getCurrentLocale() === 'ar')
        <!-- RTL Files -->
        <script src="{{ asset('js/jquryValidation/messages_ar.min.js') }}"></script>
    @endif
    <script>

        $('input[name="payment_method"]').on('change', function () {
            // checkPaymentMethodExist();
            if ($(this).is(':checked'))
            {
                if (!$('#safe_amount_field').length)
                {
                    let content =
                        '<div id="safe_amount_field" class="form-group row">\n' +
                        '<label for="amount_paid" class="col-sm-4 col-form-label">المبلغ المدفوع فى\n' +
                        'الخزنة</label>\n' +
                        '<div class="col-sm-2">\n' +
                        '<input type="text" name="amount_paid" class="form-control amount_paid"\n' +
                        'id="amount_paid" autocomplete="off">\n' +
                        '</div>\n' +
                        '</div>';
                    $('#amounts_group_field').prepend(content);
                }

            }else{
                if ($('#safe_amount_field').length)
                {
                    $('#safe_amount_field').remove();
                }
            }
        })

        // on change payment method create new field to pay into bank
        $('input[name="payment_method_bank"]').on('change', function () {
            $(this).siblings('input[type="checkbox"]').not(this).prop('checked', false);
            // checkPaymentMethodExist();
            if ($('input[name="payment_method_bank"]:checked').length > 0)
            {
                if (!$('#bank_field').length)
                {
                    let content =
                        '<div id="bank_field" class="form-group row">\n' +
                        '<label for="amount_paid_bank" class="col-sm-4 col-form-label">المبلغ المدفوع فى البنك</label>\n' +
                        '<div class="col-sm-2">\n' +
                        '<input type="text" name="amount_paid_bank"  class="form-control amount_paid_bank" id="amount_paid_bank" autocomplete="off">\n' +
                        '</div>\n'+
                        '</div>';
                    $('#amounts_group_field').append(content);
                }

            }else{
                if ($('#bank_field').length)
                {
                    $('#bank_field').remove();
                }
            }
        })

        // if page contain any class hasError stop submitted form
        $('input[type="submit"]').on('click', function (e) {
            if ($('.hasError').length > 0)
            {
                e.preventDefault();
            }
        })
        // editQuantity();
        function editQuantity() {

        }


        $(document).on('keyup', '.item_quantity', function () {
            let selectedRow = $(this).closest('tr');
            // let productQuantity = parseInt(selectedRow.find('.item_quantity').val());
            let productCode = selectedRow.find('.item_code').val();
            let selectedRowInProductCodesArea = $('#product_row_id_'+ productCode).closest('tr');
            let productQuantity_value_stored = selectedRowInProductCodesArea.find('.original_quantity').text();
            let productQuantity_inBranch_element = selectedRowInProductCodesArea.find('.product_quantity');
            let alert_message = 'الكمية التى تريد بيعها اكبر من الكمية الموجودة';

            let code_quantity_array = [];
            let all_item_code_inputs = $('input[value='+productCode+']');
            all_item_code_inputs.each(function (key, element) {
                let p_code = $(this).closest('tr').find('.item_code').val();
                let p_quantity = parseInt($(this).closest('tr').find('.item_quantity').val()) || 0;
                code_quantity_array [p_code] = code_quantity_array[p_code] ? parseInt(code_quantity_array[p_code]) + p_quantity : p_quantity;
                // console.log(p_quantity)
            })
            for(var key in code_quantity_array) {

                let productQuantity = code_quantity_array[key];

                productQuantity_inBranch_element.text(productQuantity ? productQuantity_value_stored - productQuantity : productQuantity_value_stored);
                if (productQuantity > productQuantity_value_stored)
                {
                    selectedRowInProductCodesArea.css('background-color', '#ff9292');
                    selectedRow.find('.item_quantity_error').addClass('hasError').css({'display': 'inline', 'font-size': 'x-small', 'font-style': 'italic', 'margin-bottom': '5px', 'font-weight': '700'}).text(alert_message);
                }
                else
                {
                    selectedRowInProductCodesArea.css('background-color', 'transparent');
                    selectedRow.find('.item_quantity_error').removeClass('hasError').css('display','none').text(alert_message);
                }
            }

        });


        // check if item quantity of product want to seling less than item quantity in branch
        // $(document).on('keyup', '.item_quantity', function () {
        //     let selectedRow = $(this).closest('tr');
        //     let productQuantity = parseInt(selectedRow.find('.item_quantity').val());
        //     let productCode = selectedRow.find('.item_code').val();
        //     let selectedRowInProductCodesArea = $('#product_row_id_'+ productCode).closest('tr');
        //     let productQuantity_value_stored = selectedRowInProductCodesArea.find('.original_quantity').text();
        //     let productQuantity_inBranch_element = selectedRowInProductCodesArea.find('.product_quantity');
        //     let alert_message = 'الكمية التى تريد بيعها اكبر من الكمية الموجودة';
        //
        //     productQuantity_inBranch_element.text(productQuantity ? productQuantity_value_stored - productQuantity : productQuantity_value_stored);
        //     if (productQuantity > productQuantity_value_stored)
        //     {
        //         selectedRowInProductCodesArea.css('background-color', '#ff9292');
        //         selectedRow.find('.item_quantity_error').addClass('hasError').css({'display': 'inline', 'font-size': 'x-small', 'font-style': 'italic', 'margin-bottom': '5px', 'font-weight': '700'}).text(alert_message);
        //     }
        //     else
        //     {
        //         selectedRowInProductCodesArea.css('background-color', 'transparent');
        //         selectedRow.find('.item_quantity_error').removeClass('hasError').css('display','none').text(alert_message);
        //     }
        // });

        // check if client balance less than amount due of invoice
        $(document).on('keyup', ':input', function () {
            let client_id = $('#client_id').val();
            // console.log(client_id)
            $.ajax({
                url: "{{ route('admin.getClientBalance') }}",
                method: 'GET',
                data: {client_id: client_id},
                success: function (balance_of_client) {
                    let client_balance = parseFloat(balance_of_client);
                    let amount_due = parseFloat($('#amount_due').val());
                    // console.log(amount_due)
                    // console.log(client_balance)
                    if(amount_due != 0 && client_balance < amount_due)
                    {
                        $('#amount_due_error').addClass('hasError').css({'display': 'inline', 'font-size': 'x-small', 'font-style': 'italic', 'margin-bottom': '5px', 'font-weight': '700'}).text('رصيد حساب العميل لا يغطى قيمة المبلغ المتبقى');
                    }
                    else
                    {
                        $('#amount_due_error').removeClass('hasError').css('display','none').text();
                    }
                }
            })
        })
    </script>

    <script>

        $(document).ready(function () {

            // JQuery Validation
            $('form').on('submit', function (e) {
                $('select.branch_id').each(function () {$(this).rules('add', {required: true});});
                $('input.invoice_date').each(function () {$(this).rules('add', {required: true});});
                $('input.item_quantity').each(function () {$(this).rules('add', {required: true, digits:true, range:[1,100000]});});
                $('input.item_price').each(function () {$(this).rules('add', {required: true, range:[0,1000000]});});
                $('input.item_discount').each(function () {$(this).rules('add', {number:true, range:[1,1000000]});});
                $('input#amount_paid').each(function () {$(this).rules('add', {number:true});});
                e.preventDefault();
            });
            // JQuery Validation
            $("#saleOrders").validate({
                submitHandler: function(form) {
                    form.submit();
                }
            });
            // ajax setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // set datepicker
            $("#invoice_date").datepicker().datepicker("setDate", new Date());

            getAllProductsInBranch();

            $('#branch_id, #search_by_category, #search_in_product_code').on('change keyup', function () {
                getAllProductsInBranch();
            })

            // get all product codes from elements id to excepted records code equal ids coming from database
            function getAllProductsInBranch ()
            {
                let html,
                    search,
                    count,
                    productRow,
                    productCode,
                    productName,
                    productPrice,
                    sale_order_id = '{{ $saleOrder -> id }}',
                    branch_id = $('#branch_id').val(),
                    category = $('#search_by_category').val(),
                    keyword = $('#search_in_product_code').val(),
                    productQuantity,
                    content;
                // console.log(sale_order_id);

                // ajax call to send search keyword to get all records like this keyword exception exceptCodes and append result to product_code area
                $.ajax({
                    url: "{{ route('admin.get_all_products_in_branch_edit') }}",
                    method: 'GET',
                    data: {keyword: keyword, category: category, branch_id: branch_id, sale_order_id: sale_order_id},
                    success: function (data) {
                        $('#product_code').empty();

                        // $('.sale_order_products tbody tr').each(function () {
                        //     let codes = $(this).find('.item_code').val();
                        //     let quantity = $(this).find('.item_quantity').val();
                        //     console.log(quantity)
                        // });

                        html = '';
                        $.each(data.result, function (index, element) {
                            let button = '';
                            let elementCode = element.code.replaceAll(' ', '_');
                            if (element.quantity > 0)
                            {
                                button = '<a href="" id="product_code_'+elementCode+'"  class="btn btn-success btn-sm addProduct"><i class="fa fa-plus"></i></a>';
                            }
                            html +=     '<tr id="product_row_id_'+elementCode+'">\n' +
                                '    <td class="product_code">'+ elementCode +'</td>\n' +
                                '    <td class="product_name">'+ element.name +'</td>\n' +
                                '    <td class="product_quantity">'+ element.quantity +'</td>\n' +
                                '    <td class="product_price" style="display: none">'+ element.price +'</td>\n' +
                                '    <td>'+button+'</td>\n' +
                                '    <td class="original_quantity" style="display: none">'+ element.quantity +'</td>\n' +
                                '    <td class="product_id" style="display: none">'+ element.id +'</td>\n' +
                                '</tr>';
                        })
                        $('#product_code').append(html);

                        // $('.sale_order_products tbody tr').each(function () {
                        //     let code = $(this).find('.item_code').val();
                        //     $('#product_code_'+ code).addClass('btn-default disabled').removeClass('btn-success');
                        // });
                    }
                })
            }
            count = $('#sale_order_products tbody').find('tr').length;

            // on click to add product button init product row and pass into side area
            $(document).on('click', '.addProduct',function (e) {
                e.preventDefault();
                productRow = $(this).closest('tr');
                productName = productRow.find('.product_name').text();
                productCode = productRow.find('.product_code').text().replaceAll(' ', '_');
                productPrice = productRow.find('.product_price').text();
                productQuantity = productRow.find('.product_quantity').text();
                productId = productRow.find('.product_id').text();
                html = '<tr class="'+productCode+'">\n' +
                    '<input  type="hidden" class="product_quantity" value="' + productQuantity + '">\n' +
                    '<td><div class="btn btn-danger btn-sm removeField"><i class="fa fa-trash"></i></div></td>\n' +
                    '<td><input id="item_code_' + count + '" name="product_data[' + count + '][item_code]" type="text" class="form-control item_code" value="'+productCode+'" readonly></td>\n' +
                    '<td><input id="item_name_' + count + '" name="product_data[' + count + '][item_name]" type="text" class="form-control item_name" value="'+productName+'" readonly title="'+productName+'"></td>\n' +
                    '<td><input id="item_quantity_' + count + '" name="product_data[' + count + '][item_quantity]" type="text" class="form-control item_quantity onlyUsedForValidation" autocomplete="off"><span class="item_quantity_error" style="color: red; display: none"></span></td>\n' +
                    '<td><input id="item_price_' + count + '" name="product_data[' + count + '][item_price]" type="text" class="form-control item_price momo onlyUsedForValidation" autocomplete="off"><span class="item_price_error" style="color: red; display: none"></span></td>\n' +
                    '<input id="item_purchasing_price_' + count + '" name="product_data[' + count + '][item_purchasing_price]" type="hidden" class="form-control item_purchasing_price momo onlyUsedForValidation" value="'+productPrice+'" autocomplete="off">\n' +
                    '<td><input id="item_amount_taxable_' + count + '" name="product_data[' + count + '][item_amount_taxable]" type="text" class="form-control item_amount_taxable" readonly></td>\n' +
                    '<td>' +
                    '    <div class="input-group my-group">\n' +
                    '        <select id="discount_type_' + count + '" class="form-control discount_type" name="product_data[' + count + '][item_discount_type]">\n' +
                    '            <option value="0">ريال</option>\n' +
                    '            <option value="1">%</option>\n' +
                    '        </select>\n' +
                    '       <input id="item_discount_' + count + '" name="product_data[' + count + '][item_discount]" type="text" class="form-control item_discount" autocomplete="off">\n' +
                    '    </div>\n'+
                    '</td>\n' +
                    '<input  type="hidden" name="product_data[' + count + '][item_discount_amount]" class="item_discount_amount">\n' +
                    '<input  type="hidden" name="product_data[' + count + '][item_sub_total_after_discount]" class="item_sub_total_after_discount">\n' +
                    '<td><input id="item_tax_amount_' + count + '" name="product_data[' + count + '][item_tax_amount]" type="text" class="form-control item_tax_amount" readonly></td>\n' +
                    '<td><input id="item_sub_total_' + count + '" name="product_data[' + count + '][item_sub_total]" type="text" class="form-control item_sub_total" readonly></td>\n' +
                    '<td><input id="item_id_' + count + '" name="product_data[' + count + '][product_id]" type="hidden" class="form-control product_id" value="'+productId+'"></td>\n' +
                    '</tr>';
                $('#sale_order_products tbody').prepend(html);
                // $(this).removeClass('btn-success').addClass('btn-default disabled');
                count++
            });
        }) // end ready function
    </script>

@endpush

