<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--    <title>{{ $employee_salary_log -> check_number }}.pdf</title>--}}
</head>
<style>
    /*.salary_table th, .salary_table tr, .salary_table td*/
    /*{*/
    /*    border: #0a0a0a 1px solid;*/
    /*    border-collapse: collapse;*/
    /*    text-align: center;*/
    /*    height: 50px;*/
    /*    vertical-align: middle;*/
    /*}*/
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
        padding: 20px;
        text-align: center;
        width: 200px;
        margin: 0 auto;
        font-size: 20px;
    }
    body {
        direction: rtl;
        font-size: 20px;
        border: 1px solid #000000;
    }
    @page {
        header: page-header;
        footer: page-footer;
    }
    @media print {
        .signatures td img{
            border: #9e0505 1px solid;
            height: 100px;
        }
    }
</style>
<body>

{{--<htmlpageheader name="page-header">
    <div class="header">
        <table width="100%">
            <tr>
                <td width="40%">
                    <img src="storage/logo150x150.png" alt="logo">
                </td>
                <td width="60%">
                    <div class="company_name_inside_elements">
                        <h2>مركز اس كي بي للاصلاح الميكانيكي</h2>
                        <br>
                        <h3 style="margin-right: 5px;">SKB AUTO MECHANICAL REPAIR L.L.C</h3>
                    </div>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td class="lightgrey" width="100%" style="text-align: center;"><h5 class="repair_order">بطاقة راتب</h5></td>
            </tr>
            <tr>
                <td class="lightgrey" width="100%" style="text-align: center;"><h5 class="repair_order"> شهر {{ $month .'-'. $year }} </h5></td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr class="lightgrey">
                <th style="text-align: right" width="25%">بيانات الموظف</th>
                <th style="text-align: left" width="25%" colspan="2">Employee Information</th>
            </tr>

            <tr><!-- Row 1 -->
                <td width="25%" style="text-align: right">الاسم :</td>
                <td width="50%" style="text-align: center">{{ $employee_salary_log -> employee -> name }}</td>
                <td width="25%" style="text-align: left">: Name</td>
            </tr>

            <tr><!-- Row 2 -->
                <td width="25%" style="text-align: right">الفرع :</td>
                <td width="50%" style="text-align: center">{{ $employee_salary_log -> employee -> branch ->name }}</td>
                <td width="25%" style="text-align: left">: Branch</td>

            </tr>

        </table>
        <hr><br>
        <h5 class="lightgrey terms_of_repair_title">تاريخ القبض : {{ \Carbon\Carbon::parse($employee_salary_log->updated_at)->format('d-m-Y') }}</h5>
    </div>
</htmlpageheader>--}}
<br>
<div class="body_content">
    <table class="" width="100%" style="text-align: center">
        <tr>
            <td width="50%" align="center">
                <div>
                    <h3>مركز الشيخ</h3>
                    <h3>لصيانة السيارات الاوروبية</h3>
                </div>
{{--                <p>مركز اس كي بي للاصلاح الميكانيكي</p>--}}
{{--                <br>--}}
{{--                <p style="margin-right: 5px;">SKB AUTO MECHANICAL REPAIR L.L.C</p>--}}
            </td>
            <td width="50%" style="border-bottom: 1px solid #000; font-weight: bold; font-size: xx-large">سند استلام سلفة</td>
            <td width="50%">
                <img src="storage/logo150x150.png" alt="logo">
            </td>
        </tr>
    </table>
    <br><br><br><br>
    <div class="receipt_body">
        <table style="width: 100%">
            <tr>
                <td>اقر انا الموظف:</td>
                <td>{{ $advance -> employee -> name }}</td>
            </tr>
            <tr>
                <td>اعمل في فرع:</td>
                <td>{{ $advance -> employee -> branch -> display_name }}</td>
            </tr>
            <tr>
                <td style="width: 30%">اننى استلمت مبلغ وقدره:</td>
                <td style="width: 70%">{{ $advance -> amount }} ريال</td>
            </tr>
            <tr>
                <td style="width: 30%">عن طريق :</td>
                <td style="width: 70%">{{ $advance -> payment_method }}</td>
            </tr>
            <tr>
                <td>وذلك عن:</td>
                <td>{{ $advance -> notes ? $advance -> notes : '-----------' }}</td>
            </tr>
            <tr>
                <td>بتاريخ:</td>
                <td>{{ $advance -> created_at -> format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <br><br><br><br>
    <div class="receipt_footer">
        <table style="width: 100%; text-align: center">
            <tr>
                <td style="width: 50%"><h6 class="text-center" style="font-weight: bold">توقيع المستلم</h6></td>
                <td style="width: 50%"><h6 class="text-center" style="font-weight: bold">الختم</h6></td>
            </tr>
            <tr>
                <td style="width: 50%" class="text-center">
{{--                    <img src="{{ asset('storage' . DIRECTORY_SEPARATOR . 'employees_signature' . DIRECTORY_SEPARATOR . 'advance_signature' . DIRECTORY_SEPARATOR . $advance -> id  . DIRECTORY_SEPARATOR . $employee_advance_signature -> image_name) }}" alt="" height="100" width="200">--}}
                    <p><img src="storage/employees_signature/advance_signature/{{ $advance -> id }}/{{ $employee_advance_signature -> image_name }}" alt="advance_signature" width="100"></p>

                </td>
                <td style="width: 50%"><p class="text-center">..........</p></td>
            </tr>
        </table>
    </div>
{{--    <table class="signatures" width="100%" style="text-align: center">--}}
{{--        <tr>--}}
{{--            <td width="50%">--}}
{{--                <p>توقيع المحاسب</p>--}}
{{--                <p>{{ auth()->user()->name }}</p>--}}
{{--            </td>--}}
{{--            <td width="50%">--}}
{{--                <br>--}}
{{--                <p>توقيع الموظف</p>--}}
{{--                <br>--}}
{{--                <p><img src="storage/employees_signature/salary_signature/{{ $employee_salary_log -> id }}/{{ $employee_salary_signature -> image_name }}" alt="employee_signature" width="100"></p>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}
</div>
</body>
</html>
