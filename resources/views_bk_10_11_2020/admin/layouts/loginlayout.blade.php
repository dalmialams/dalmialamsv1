
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Dalmia-LAMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN CORE CSS FRAMEWORK -->
        <link href="{{URL::asset('assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" media="screen"/>
        <link href="{{URL::asset('assets/plugins/boostrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{URL::asset('assets/plugins/boostrapv3/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{URL::asset('assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{URL::asset('assets/css/animate.min.css')}}" rel="stylesheet" type="text/css"/>

        <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{URL::asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{URL::asset('assets/css/custom-icon-set.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{URL::asset('assets/css/custom_style.css')}}" rel="stylesheet" type="text/css"/>
        <!-- END CSS TEMPLATE -->

    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="error-body no-top lazy body_login" data-original="{{URL::asset('assets/img/login_bg.jpg')}}" style="background-image: url('assets/img/login_bg.jpg'); background-size:100% 100%;">  
        <div class="pull-right dalmia_login_logo"><img src="{{URL::asset('assets/img/dalmia_logo.png')}}" alt="Dalmia Lams" /></div>
        <div class="dalmia_logo"><img src="{{URL::asset('assets/img/dal_lams.png')}}" alt="Dalmia Lams" /></div>
        <div class="container custom_login_wrapper"> 
            <div class="row login-container animated fadeInUp">  
                <div class="tiles white no-padding box-shadow_log">

                    <div class="light_grey p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10"> 

                        <h2 class="normal">Sign in to LMS</h2>

                        <p class="login_text">Access to and use of this Site is subject to the Terms and Conditions as set out herein and all applicable laws.</p>
                        <!-- <p class="p-b-20">Sign up Now! for webarch accounts, it's free and always will be..</p> -->

                    </div>
                    <div class="grey p-t-20 p-b-20 text-black">
                        {!! Form::open(['url' => '','id' => 'frm_login','class' => 'animated fadeIn login-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}
                        <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10 clerfix">
                            <div class="form-group">  
                                <div class="col-md-12 col-sm-12">
                                    {{ Form::text('user_name', '', array('class'=>'form-control required','id' => 'login_username','placeholder' => 'User Name')) }}
                                </div>
                            </div>
                            <div class="form-group">  
                                <div class="col-md-12 col-sm-12">
                                    <input name="password" id="login_pass" type="password"  class="form-control required" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 col-md-12 error-msg help-block" style="display: none;">

                                </div>
                            </div>
                            <div class="form-group">  
                                <div class="col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-cons pull-right no_margin  pull-right" id="login_toggle">Login</button>
                                    <a class="pull-right forgot_password" href="<?= url('forgot-password') ?>">Forgot password?</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>   
                </div>   
            </div>
        </div>
        <style>
            .help-block{
                color: #a94442!important;
            }
        </style>
        <!-- END CONTAINER -->
        <!-- BEGIN CORE JS FRAMEWORK-->
        <!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script> -->-->
       <script src="{{URL::asset('assets/js/jquery-2.1.1.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/boostrapv3/js/bootstrap.min.js')}}" type="text/javascript"></script>
<!--        <script src="{{URL::asset('assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>--->
        <script src="{{URL::asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/jquery-lazyload/jquery.lazyload.min.js')}}" type="text/javascript"></script>
        <!-- BEGIN CORE TEMPLATE JS -->
        <!-- END CORE TEMPLATE JS -->
        <script>
$(function () {
    $(".lazy").lazyload({
        effect: "fadeIn"
    });
    $(".login-form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
                errorPlacement: function (error, element) {
                    var place = element.closest('.input-group');
                    if (!place.get(0)) {
                        place = element;
                    }
                    if (place.get(0).type === 'checkbox') {
                        place = element.parent();
                    }
                    if (error.text() !== '') {
                        place.after(error);
                    }
                },
        errorClass: 'help-block',
        rules: {
//            email: {
//                required: true,
//                email: true,
//                remote: {
//                    url: '<?= url('check-valid-user') ?>',
//                    type: "get",
//                    complete: function (data) {
//                        if (data.responseText !== 'false') {
//                            $('#login_username-error').html('');
//                        }
//                    }
//                },
//            },
            user_name: {
                required: true,
                remote: {
                    url: '<?= url('check-valid-user') ?>',
                    type: "get",
                    complete: function (data) {
                        if (data.responseText !== 'false') {
                            $('#login_username-error').html('');
                        }
                    }
                },
            },
            password: {
                required: true,
                //password: true,
            },
        },
        messages: {
//            email: {
//                required: "This field is required",
//                email: "Please enter a valid email address",
//                remote: function () {
//                    return $.validator.format("{0} either does not exist or not an active user", $("#login_username").val())
//                }
//            },
            user_name: {
                required: "This field is required",
                // user_name: "Please enter a valid user name",
                remote: function () {
                    //alert($("#login_username").val());
                    return $.validator.format($("#login_username").val() + " either does not exist or not an active user", $("#login_username").val())
                }
            },
            password: {
                required: "This field is required",
            },
        },
        highlight: function (label) {
            $(label).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function (label) {
            $(label).closest('.form-group').removeClass('has-error');
            label.remove();
        },
        submitHandler: function (form) {
            // form.submit();
            //alert('sdcvzc');
            $.ajax({
                url: '<?= url('validate-user-login') ?>',
                type: 'POST',
                data: {
                    '_token': '<?= csrf_token() ?>',
                    'user_name': $('#login_username').val(),
                    'password': $('#login_pass').val(),
                },
                error: function () {
                    // $('#info').html('<p>An error has occurred</p>');
                },
                // dataType: 'json',
                success: function (data) {
                     //console.log(data);//exit;
                    if (data == 1) {
                        var url = '<?= url('dashboard') ?>';
                        window.location = url;
                    } else if (data == 2) {
                        $('.login-form').find('.error-msg').html('Active period has been expired for this user').css('display', 'inline');
                    }
		    else if (data == 5) {
                        $('.login-form').find('.error-msg').html('Password Expired').css('display', 'inline');
                    }

                    else {
                        $('.login-form').find('.error-msg').html('Incorrect credentials given').css('display', 'inline');
                    }

                },
            });
            return false;
        }
    });

});
        </script>
    </body>

</html>