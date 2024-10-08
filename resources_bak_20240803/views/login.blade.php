<html lang="en"><head>
        
        <meta charset="utf-8">
        <title>DID | SCMT</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin &amp; Dashboard Template" name="description">
        <meta content="Themesdesign" name="author">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link rel="stylesheet" href="{{asset('resources/css/bootstrap/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('resources/css/app.min.css')}}">

        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
        <link rel="icon" href="{{asset('resources/img/minitok.jpeg?v20240701')}}">
    </head>

    <body class="auth-body-bg" style="background-color:#EE1C25; background: rgba(51,51,51,.97);">
        <div class="wrapper-page">
            <div class="row h-100">
                <div class="col-sm-12 d-flex justify-content-center">
                        <div class="card mx-auto my-auto" style="width:500px;">
                            <div class="card-body">

                                <!-- <div class="text-center mt-4">
                                    <div class="mb-1">
                                        <a href="" class="auth-logo">
                                            <img src="{{asset('resources/img/logo-telkom.png')}}" height="100">
                                        </a>
                                    </div>
                                </div> -->

                                <h4 class="text-center font-size-20" style="color: #EE1C25;"><b><img src="{{asset('resources/img/minitok.jpeg')}}" width="120px" height="120px"></b></h4>
                                <div class="text-center">
                                    <span>
                                        <span class="font-weight-bold" style="font-size:17px;">Minimum Stock</span><br>
                                        The Ultimate Novelty Tools As Solutions
                                    </span>
                                </div>

                                <hr>

            
                                <div class="p-3">
                                    <form class="form-horizontal mt-3" action="{{URL('proses_login')}}" method="POST" enctype="multipart/form-data">
                                     @csrf
                                        <div class="form-group mb-3 row">
                                            <div class="col-12">
                                                <input class="form-control" type="text" name="username" required="" placeholder="Username">
                                            </div>
                                        </div>
            
                                        <div class="form-group mb-3 row">
                                            <div class="col-12">
                                                <input class="form-control" type="password" name="password" required="" placeholder="Password">
                                            </div>
                                        </div>
            
                                        <div class="form-group mb-3 text-center row mt-3 pt-1">
                                            <div class="col-12">
                                                <button class="btn btn-info w-100 waves-effect waves-light" id="btn_login" type="submit">Log In</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end -->
                            </div>
                            <!-- end cardbody -->
                        </div>
                        <!-- end card -->
                </div>

            </div>
            <!-- end container -->
        </div>
        <!-- end -->

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <script src="assets/js/app.js"></script>
        <script src="assets/js/custom2.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>