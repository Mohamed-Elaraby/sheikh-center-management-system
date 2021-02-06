<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Suggestion field using jQuery, PHP and MySQL - Learn infinity</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('assets/signature/css/bootstrap.css') }}" rel="stylesheet" />

    <!-- Font Awesome Css -->
    <link href="{{ asset('assets/signature/css/font-awesome.min.css') }}" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/signature/css/bootstrap-select.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('assets/signature/css/app_style.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>

        #btnSaveSign {
            color: #fff;
            background: #f99a0b;
            padding: 5px;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            margin-top: 10px;
        }
        #signArea{
            width:304px;
            margin: 15px auto;
        }
        .sign-container {
            width: 90%;
            margin: auto;
        }
        .sign-preview {
            width: 150px;
            height: 50px;
            border: solid 1px #CFCFCF;
            margin: 10px 5px;
        }
        .tag-ingo {
            font-family: cursive;
            font-size: 12px;
            text-align: left;
            font-style: oblique;
        }
        .center-text {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="all-content-wrapper">
    <!-- Top Bar -->
@include('admin.includes.header')
<!-- #END# Top Bar -->

    <section class="container">
        <div class="form-group custom-input-space has-feedback">
            <div class="page-heading">
                <h3 class="post-title">jQuery Signature Pad & Canvas Image - Learn infinity</h3>
            </div>
            <div class="page-body clearfix">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="panel panel-default">
                            <div class="panel-heading">Digital Signature:</div>
                            <div class="panel-body center-text">

                                <div id="signArea" >
                                    <h2 class="tag-ingo">Put signature below,</h2>
                                    <div class="sig sigWrapper" style="height:auto;">
                                        <div class="typed"></div>
                                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                                    </div>
                                </div>


                                <button id="btnSaveSign">Save Signature</button>
                                <button id="btnReset">Reset</button>

                                <div class="sign-container">
                                    @php
                                    $image_list = glob( public_path('assets/signature/doc_signs/*.png') );
                                    @endphp
                                    @foreach($image_list as $image)
                                            <img src="{{ $image }}" class="sign-preview" />
                                    @endforeach
                                </div>


                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
</div>

<!-- Jquery Core Js -->
<script src="{{ asset('assets/signature/js/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('assets/signature/js/bootstrap.min.js') }}"></script>

<!-- Bootstrap Select Js -->
<script src="{{ asset('assets/signature/js/bootstrap-select.js') }}"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<link href="{{ asset('assets/signature/css/jquery.signaturepad.css') }}" rel="stylesheet">
<script src="{{ asset('assets/signature/js/numeric-1.2.6.min.js') }}"></script>
<script src="{{ asset('assets/signature/js/bezier.js') }}"></script>
<script src="{{ asset('assets/signature/js/jquery.signaturepad.js') }}"></script>

<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
<script src="{{ asset('assets/signature/js/json2.min.js') }}"></script>

<script>

    $(document).ready(function(e){

        $(document).ready(function() {
            $('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
        });

        $("#btnSaveSign").click(function(e){

            html2canvas([document.getElementById('sign-pad')], {
                onrendered: function (canvas) {
                    var canvas_img_data = canvas.toDataURL('image/png');
                    var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
                    var url = '{{ route('admin.check.signature') }}';
                    console.log(canvas_img_data);
                    //ajax call to save image inside folder
                    $.ajax({
                        url: url,
                        data: { img_data:img_data },
                        type: 'get',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (response) {
                            window.location.reload();
                        }
                    });
                }
            });
        });

    });

    document.getElementById('btnReset').onclick = function () {
        var canvas = document.getElementById("sign-pad");
        var context = canvas.getContext('2d');
        context.clearRect(0, 0, canvas.width, canvas.height);

    }
</script>
</body>
</html>
