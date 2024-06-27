<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login CMS</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Mega Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords"
        content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="codedthemes" />
    <!-- Favicon icon -->

    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/css/bootstrap/css/bootstrap.min.css') }}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('backend/pages/waves/css/waves.min.css') }}"
        type="text/css" media="all">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/icon/themify-icons/themify-icons.css') }}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/icon/icofont/css/icofont.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/icon/font-awesome/css/font-awesome.min.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/style.css') }}">
</head>

<body themebg-pattern="theme1">

    <!-- Pre-loader end -->



    <section class="login-block">

        <!-- Container-fluid starts -->
        <div class="container">
            <div class="log" style="background-color:white;border-radius:16px;height:565px;">
                <div class="row">
                    <div class="col-md-5">

                        <div class="block-login"></div>
                    </div>

                    <div class="col-md-7">
                        <!-- Authentication card start -->

                        <form class="md-float-material form-material" action="{{ route('login') }}"
                            method="POST">
                            @csrf

                            <div class="auth-box">
                                <div class="card-block" style="padding:5rem;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="crmMainTitle mb-5"
                                                style="margin-left:0px!important; font-weight:600;"><span
                                                    style="color:#f6b619;text-transform:capitalize; font-weight:500!important;">Tech</span>CRM
                                            </h2>
                                            <h4 class="mt-3 mb-3" style=color:black;font-weight:600;>Login</h4>
                                            <p>Enter your details below to continue</p>
                                        </div>
                                    </div>
                                    <!-- <h4 class="crmMainTitle mt-3 mb-5"><b> Login</b></h4> -->
                                    <div class="form-group form-primary mt-3">
                                        <input type="text" name="username" class="form-control mt-3" required="">
                                        <span class="form-bar"></span>
                                        <label class="float-label"> <i class="fa fa-user-o mr-1" aria-hidden="true"></i>
                                            User Name</label>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" name="password" class="form-control mt-3" required="">
                                        <span class="form-bar"></span>
                                        <label class="float-label"> <i class="fa fa-eye mr-1"></i> Password</label>
                                    </div>
                                    <div class="row m-t-25 text-left">
                                        <div class="col-12">
                                            <div class="checkbox-fade fade-in-primary d-">
                                                <!-- <label>
                                                    <input type="checkbox" value="">
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span class="text-inverse">Remember me</span>
                                                </label> -->
                                            </div>


                                            <div class="forgot-phone text-right f-right">
                                                <a href="#pwdModal" data-toggle="modal"> Forgot Password?</a>
                                            </div>



                                            <div id="pwdModal" class="modal fade" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">×</button>
                                                            <h1 class="text-center">What's My Password?</h1>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-body">
                                                                        <div class="text-center">

                                                                            <p>If you have forgotten your password you
                                                                                can reset it here.</p>
                                                                            <div class="panel-body">
                                                                                <fieldset>
                                                                                    <div class="form-group">
                                                                                        <input
                                                                                            class="form-control input-lg"
                                                                                            placeholder="E-mail Address"
                                                                                            name="email" type="email">
                                                                                    </div>
                                                                                    <input
                                                                                        class="btn btn-lg btn-primary btn-block"
                                                                                        value="Send My Password"
                                                                                        type="submit">
                                                                                </fieldset>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="col-md-12">
                                                                <button class="btn" data-dismiss="modal"
                                                                    aria-hidden="true">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                class="btn btn-primary btn-md btn-block waves-effect waves-light shadow-lg m-auto">Login</button>
                                        </div>
                                    </div>
                                    <hr />
                                    <h6 style="text-align:center;">Don’t have an account?<span style="color:#f6b619;">
                                            Sign up here.</span></h6>
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                    <!-- end of col-sm-12 -->
                </div>
                <!-- end of row -->
            </div>
            <!-- end of container-fluid -->
        </div>
    </section>
    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>
    <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
    <!-- waves js -->
    <script src="assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js "></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="assets/js/SmoothScroll.js"></script>
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js "></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="bower_components/i18next/js/i18next.min.js"></script>
    <script type="text/javascript" src="bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript"
        src="bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
    <script type="text/javascript" src="assets/js/common-pages.js"></script>
</body>

</html>
