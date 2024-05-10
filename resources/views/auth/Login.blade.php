<!doctype html>
<html lang="en" >
<head>
    <meta charset="utf-8" />
    <title>Login | OFPPT </title>
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
                                <h5 class="text-white font-size-20">Bienvenue !</h5>
                                <p class="text-white-50 mb-0">Connectez-vous pour continuer</p>
                                <a  href="{{route('create-account')}}" class="logo logo-admin mt-4">
                                    <img src="assets/images/logo-sm-dark.png" alt="" height="30">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">
                                <form class="form-horizontal"method="post" action="{{route('login_into_account')}}" >
                                    @csrf
                                    {{-- start --}}
                                    @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                  @endif

                                  @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                    <div class="mb-3">
                                        <label class="form-label" for="username">Matricule</label>
                                        <input type="test" name="id" class="form-control" id="username" placeholder="Enter Matricule ">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Mot de passe</label>
                                        <div class="input-group">
                                            <input style="border:none !importent;"ype="password" name="password" class="form-control" id="userpassword" placeholder="Enter Mot de passe">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="mdi mdi-eye"></i>
                                            </button>
                                        </div>
                                    </div>



                                    <div class="mt-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="{{route('ForgotPassword')}}" class="text-muted"><i
                                                class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>Don't have an account ? <a href="{{route('create-account')}}"
                                class="fw-medium text-primary"> Signup now </a> </p>
                        <p>©
                            <script>document.write(new Date().getFullYear())</script> OFPPT<i
                                class="mdi mdi-heart text-danger"></i> by ISTA BEN M'SIK
                        </p>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.querySelector("#togglePassword");
            const password = document.querySelector("#userpassword");

            togglePassword.addEventListener("click", function() {
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);
                this.classList.toggle("active");
            });
        });
    </script>

</body>

</html>
