<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $purchase_order -> invoice_number }}.pdf</title>
</head>
<style>
    .items, .items th, .items td,
    .notes_table, .notes_table th, .notes_table td
    {
        border: #0a0a0a 1px solid;
        border-collapse: collapse;
    }
    .footer-info td{
        padding-left: 10px;
    }
    .lightgrey
    {
        background-color: lightgrey;
    }
    .report-container {
        page-break-after:always;
    }
    .repair_order
    {
        padding: 5px 2px;
        border: 1px solid #000;
        text-align: center;
        width: 200px;
        margin: 0 auto;
    }
    body {

        direction: rtl;
        font-size: 10px;
    }
    @page {
        header: page-header;
        footer: page-footer;
    }
</style>
<body>

    <htmlpageheader name="page-header">
        <div class="header">
            <table width="100%" class="lightgrey">
                <tr>
                    <td align="center" colspan="2">فاتورة ضريبية</td>
                </tr>
                <tr>
                    <td align="center" colspan="2">Tax Invoice</td>
                </tr>
            </table>
            <br><br>
            @php
                $seller_name                = 'مركز الشيخ لصيانة السيارات';
                $vat_number                 = '300014551300003';
                $invoice_date               = $purchase_order -> created_at -> format('d/m/Y - h:i:s');
                $total_invoice_amount       = $purchase_order -> total_amount_due;
                $total_vat                  = $purchase_order -> total_vat;
                $generatedString = \App\Traits\HelperTrait::SETQRCODE($seller_name, $vat_number, $invoice_date, $total_invoice_amount,$total_vat);
            @endphp
            <table width="100%">
                <tr>
                    <td width="20%">
                        <div id="QRCode" style="/*color: red;*/ visibility: hidden; ">
                            <img src="{{ $generatedString }}" width="150">
                        </div>
                    </td>
                    <td align="center" width="20%">
                        <div>رقم الفاتورة</div><br>
                        <div>وقت اصدار الفاتورة</div><br>
                        <div>تاريخ اصدار الفاتورة</div><br>
                        <div>تاريخ التوريد</div>
                    </td>
                    <td align="center" width="20%">
                        <div>{{ $purchase_order -> invoice_number }}</div><br>
                        <div>{{ $purchase_order -> created_at -> format('h:i:s a') }}</div><br>
                        <div> {{ $purchase_order -> created_at -> format('d/m/Y') }}</div><br>
                        <div> {{ $purchase_order -> created_at -> format('d/m/Y') }}</div>
                    </td>
                    <td align="center" width="20%">
                        <div>Invoice Number</div><br>
                        <div>Invoice Issue Time</div><br>
                        <div>Invoice Issue Date</div><br>
                        <div>Date Of Supply</div>
                    </td>
                    <td align="left" width="20%">
                        <div class="logo">
                            <img src="storage/logo150x150.png" alt="logo">
                        </div> <!-- end logo -->
                    </td>
                </tr>
            </table>
            <br><br>
            <table width="100%">
                <tr class="lightgrey">
                    <th style="text-align: right" width="25%">بيانات العميل</th>
                    <th style="text-align: left" width="25%" colspan="2">supplier Info</th>
                    <th style="text-align: right" width="25%">بيانات المورد</th>
                    <th style="text-align: left" width="25%" colspan="2">Supplier Info</th>
                </tr>

                <tr><!-- Row 1 -->
                    <td width="16.66%" style="text-align: right">الاسم :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> supplier -> name }}</td>
                    <td width="16.66%" style="text-align: left">: Name</td>
                    <td width="16.66%" style="text-align: right">الاسم :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> branch -> name }}</td>
                    <td width="16.66%" style="text-align: left">: Name</td>
                </tr>
                <tr> <!-- Row 2 -->
                    <td width="16.66%" style="text-align: right">رقم المبنى :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> supplier -> building_number }}</td>
                    <td width="16.66%" style="text-align: left">: Building No</td>
                    <td width="16.66%" style="text-align: right">رقم المبنى :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> branch -> building_number }}</td>
                    <td width="16.66%" style="text-align: left">: Building No</td>
                </tr>
                <tr> <!-- Row 3 -->
                    <td width="16.66%" style="text-align: right">اسم الشارع :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> supplier -> street_name }}</td>
                    <td width="16.66%" style="text-align: left">: Street Name</td>
                    <td width="16.66%" style="text-align: right">اسم الشارع :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> branch -> street_name }}</td>
                    <td width="16.66%" style="text-align: left">: Street Name</td>
                </tr>
                <tr> <!-- Row 4 -->
                    <td width="16.66%" style="text-align: right">رقم الهاتف :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> supplier -> phone }}</td>
                    <td width="16.66%" style="text-align: left">: Phone Number</td>
                    <td width="16.66%" style="text-align: right">رقم الهاتف :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> branch -> phone }}</td>
                    <td width="16.66%" style="text-align: left">: Phone Number</td>
                </tr>
                <tr> <!-- Row 5 -->
                    <td width="16.66%" style="text-align: right">الحي :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> supplier -> district }}</td>
                    <td width="16.66%" style="text-align: left">: District</td>
                    <td width="16.66%" style="text-align: right">الحي :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> branch -> district }}</td>
                    <td width="16.66%" style="text-align: left">: District</td>
                </tr>
                <tr> <!-- Row 6 -->
                    <td width="16.66%" style="text-align: right">المدينة :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> supplier -> city }}</td>
                    <td width="16.66%" style="text-align: left">: City</td>
                    <td width="16.66%" style="text-align: right">المدينة :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> branch -> city }}</td>
                    <td width="16.66%" style="text-align: left">: City</td>
                </tr>
                <tr> <!-- Row 7 -->
                    <td width="16.66%" style="text-align: right">البلد :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> supplier -> country }}</td>
                    <td width="16.66%" style="text-align: left">: Country</td>
                    <td width="16.66%" style="text-align: right">البلد :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> branch -> country }}</td>
                    <td width="16.66%" style="text-align: left">: Country</td>
                </tr>
                <tr> <!-- Row 8 -->
                    <td width="16.66%" style="text-align: right">الرمز البريدى :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> supplier -> postal_code }}</td>
                    <td width="16.66%" style="text-align: left">: Postal Code</td>
                    <td width="16.66%" style="text-align: right">الرمز البريدى :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> branch -> postal_code }}</td>
                    <td width="16.66%" style="text-align: left">: Postal Code</td>
                </tr>
                <tr> <!-- Row 9 -->
                    <td width="16.66%" style="text-align: right">رقم تسجيل ضريبة القيمة المضافة :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> supplier -> vat_number }}</td>
                    <td width="16.66%" style="text-align: left">: Vat Number</td>
                    <td width="16.66%" style="text-align: right">رقم تسجيل ضريبة القيمة المضافة :</td>
                    <td width="16.66%" style="text-align: center">{{ $purchase_order -> branch -> vat_number }}</td>
                    <td width="16.66%" style="text-align: left">: Vat Number</td>
                </tr>
            </table>
        </div>
    </htmlpageheader>

    <div class="body">
        <table class="items" width="100%">
            <tr class="lightgrey">
                <th align="center">
                    <p>الكود</p>
                    <p>Code</p>
                </th>
                <th align="center">
                    <p>تفاصيل السلع او الخدمات</p>
                    <p>Goods Of Nature Or Services</p>
                </th>
                <th align="center">
                    <p>سعر الوحدة</p>
                    <p>price Unit</p>
                </th>
                <th align="center">
                    <p>الكمية</p>
                    <p>Quantity</p>
                </th>
                <th align="center">
                    <p>المبلغ الخاضع للضريبة</p>
                    <p>Amount Taxable</p>
                </th>
                <th align="center">
                    <p>الخصم</p>
                    <p>Discount</p>
                </th>
                <th align="center">
                    <p>نسبة الضريبة</p>
                    <p>Tax Rate</p>
                </th>
                <th align="center">
                    <p>مبلغ الضريبة</p>
                    <p>Tax Amount</p>
                </th>
                <th align="center">
                    <p>المبلغ شامل ضريبة القيمة المضافة</p>
                    <p>(Item Subtotal (Including VAT</p>
                </th>
            </tr>
            @foreach ($purchase_order -> purchaseOrderProducts as $product)
                <tr>
                    <td align="center">{{ $product -> item_code }}</td>
                    <td align="center">{{ $product -> item_name }}</td>
                    <td align="center">{{ $product -> item_price }} ريال</td>
                    <td align="center">{{ $product -> item_quantity }}</td>
                    <td align="center">{{ $product -> item_amount_taxable }} ريال</td>
                    <td align="center">{{ $product -> item_discount }} {{ $product -> item_discount ? $product -> item_discount_type == 0 ? ' ريال ' : ' % ' : ''}}</td>
                    <td align="center">15%</td>
                    <td align="center">{{ $product -> item_tax_amount }} ريال</td>
                    <td align="center">{{ $product -> item_sub_total }} ريال</td>
                </tr>
            @endforeach
            <tr class="lightgrey">
                <th colspan="4" align="right">اجمالى المبالغ</th>
                <th colspan="4" align="center">Total Amounts</th>
                <th></th>
            </tr>
            <tr>
                <td colspan="4">الاجمالى (غير شامل ضريبة القيمة المضافة)</td>
                <td align="center" colspan="4"> ( Total ( Excluding VAT</td>
                <td align="center">{{ $purchase_order -> total }} ريال</td>
            </tr>
            <tr>
                <td colspan="4">مجموع الخصومات</td>
                <td align="center" colspan="4">Discount</td>
                <td align="center">{{ $purchase_order -> discount }} ريال</td>
            </tr>
            <tr>
                <td colspan="4">الاجمالى الخاضع للضريبة (غير شامل ضريبة القيمة المضافة)</td>
                <td align="center" colspan="4"> ( Total Taxable Amount ( Excluding VAT</td>
                <td align="center">{{ $purchase_order -> taxable_amount }} ريال</td>
            </tr>
            <tr>
                <td colspan="4">مجموع ضريبة القيمة المضافة</td>
                <td align="center" colspan="4">Total VAT</td>
                <td align="center">{{ $purchase_order -> total_vat }} ريال</td>
            </tr>
            <tr>
                <td colspan="4">اجمالى المبلغ المستحق</td>
                <td align="center" colspan="4">Total Amount Due</td>
                <td align="center">{{ $purchase_order -> total_amount_due }} ريال</td>
            </tr>
            <tr>
                <td colspan="4">خصم المورد</td>
                <td align="center" colspan="4">Supplier Discount</td>
                <td align="center">{{ $purchase_order -> supplier_discount_amount ?? 0  }} ريال</td>
            </tr>
            <tr>
                <td colspan="4">المبلغ المدفوع</td>
                <td align="center" colspan="4">Amount Paid</td>
                <td align="center">{{ $purchase_order -> amount_paid + $purchase_order -> amount_paid_bank }} ريال</td>
            </tr>
            <tr>
                <td colspan="4">المبلغ المتبقي</td>
                <td align="center" colspan="4">Amount Due</td>
                <td align="center">{{ $purchase_order -> amount_due }} ريال</td>
            </tr>
        </table>
        @if ($purchase_order -> notes)
            <div class="notes" style="padding-top: 20px">
                <table class="notes_table" width="100%">
                    <tr>
                        <th align="center">ملاحظات</th>
                        <td align="center">{{ $purchase_order -> notes }}</td>
                    </tr>
                </table>
            </div>
        @endif
    </div>

    <htmlpagefooter name="page-footer">
        <hr style="border-top: 1px solid #000">
        <div class="footer-info" style=" margin-top: 10px; ">
            <table class="table table-borderless" align="center">
                <tbody>
                <tr>
                    <th></th>
                    <th align="right">فرع 1</th>
                    <th align="right">فرع 2</th>
                    <th align="right">فرع 3</th>
                    <th align="right">فرع 4</th>
                    <th align="right">فرع 5</th>
                    <th align="right">فرع 6</th>
                </tr>
                <tr>
                    <th></th>
                    <td align="right">صيانة BMW</td>
                    <td align="right">صيانة BMW</td>
                    <td align="right">صيانة سيارات أوروبية</td>
                    <td align="right">سمكرة وبوية</td>
                    <td align="right">قطع غيار مستعملة</td>
                    <td align="right">صيانة سيارات أوروبية</td>
                </tr>
                <tr>
                    <th align="right">الموقع</th>
                    <td align="right">مخرج 18 صناعية الدائرى</td>
                    <td align="right">حي الياسمين مخرج 5</td>
                    <td align="right">مخرج 17 الصناعية القديمة</td>
                    <td align="right">مخرج 18 بجوار الفرع الرئيسي</td>
                    <td align="right">مخرج 17 حي السلي</td>
                    <td align="right">مخرج 7 حي النرجس</td>
                </tr>
                <tr>
                    <th align="right">الهاتف</th>
                    <td align="right">0554773357</td>
                    <td align="right">0557267766</td>
                    <td align="right">0508196341</td>
                    <td align="right">0557367766</td>
                    <td align="right">0500681848</td>
                    <td align="right">0554884558</td>
                </tr>

                </tbody>
            </table>
        </div>
    </htmlpagefooter>
</body>
</html>