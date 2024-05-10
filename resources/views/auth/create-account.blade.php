<!doctype html>
<html lang="en" >

<head>

    <meta charset="utf-8" />
    <title>Register | OFPPT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->


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
                                <h5 class="text-white font-size-20">Free Register</h5>
                                <p class="text-white-50 mb-0">Creer votre compte et Geerer votre etablissement</p>
                                <a  href="{{route('login')}}" class="logo logo-admin mt-4">
                                    <img src="assets/images/logo-sm-dark.png" alt="" height="30">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="/insert" >
                                    @csrf
                                    <div class="mb-3">
                                        <labellass="form-label" for="useremail">Name</labellass=>
                                        <input  type="text" name="user_name" class="form-control" id="useremail"  placeholder="Enter name">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="useremail">Matricule</label>
                                        <input type="text" name="id" class="form-control" id="useremail" placeholder="Matricule">
                                    </div>
                                    <input style="display:none" value="admin" type="text" name='role'class="form-control" >

                                    <div class="mb-3">
                                        <label class="form-label" for="username">Email</label>
                                        <input type="email" name="email" class="form-control" id="username"
                                            placeholder="Enter email">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="username">Ista</label>
                                        <input type="text" name="name_establishment"  class="form-control" id="username"
                                            placeholder="Enter Ista name">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Mot de passe</label>
                                        <input type="password" name="password" class="form-control" id="userpassword"
                                            placeholder="Enter password">
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100 waves-effect waves-light"
                                            type="submit">Register</button>
                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>Already have an account ? <a href="{{route('login')}}" class="fw-medium text-primary">
                                Login</a> </p>
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

</body>

</html>
