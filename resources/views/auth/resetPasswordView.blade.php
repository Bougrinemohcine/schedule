<!doctype html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>Login | Qovex - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/css/app.min.css')}}" id="app-style"  rel="stylesheet" type="text/css" />
    </head>
<body>

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">Reset Password</h5>
                                <p class="text-white-50 mb-0">Re-Password with Qovex.</p>

                                <a class="logo logo-admin mt-4">
                                    <img src="assets/images/logo-sm-dark.png" alt="" height="30">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">

                                <form class="form-horizontal" method="POST" action="{{route('resetPassword')}}" >
                                    @csrf
                                    @if(session('success'))
                                    <div class="alert alert-success text-center mb-4" role="alert">{{session('success')}}</div>
                                    @endif
                                    @if($errors->any())
                                    <div class="alert alert-danger">
                                         @foreach ($errors->all() as $error)
                                             <li>{{ $error }}</li>
                                         @endforeach
                                 </div>
                                 @endif
                                    <div class="mb-3">
                                        <label class="form-label" for="useremail">Email</label>
                                        <input type="email" class="form-control" id="useremail"
                                           name="email" placeholder="Enter email">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="useremail">New passeword</label>
                                        <input type="passeword" class="form-control" id="useremail"
                                           name="password" placeholder="Enter email">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="useremail">confirme passeword</label>
                                        <input type="passeword" class="form-control" id="useremail"
                                           name="passwordConfirme" placeholder="Enter email">
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light"
                                                type="submit">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <p>Remember It ? <a href="{{route('login')}}" class="fw-medium text-primary"> Sign In
                                here</a> </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

   <!-- JAVASCRIPT -->
    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('assets/libs/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
</body>

</html>
