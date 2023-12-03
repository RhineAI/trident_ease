<!doctype html>
<html lang="en">

<head>
    <title>EASE</title>
    <meta charset="utf-8">
    <link rel="icon" href="{{ asset('assets') }}/img/easepos_logo/ease8.png" type="image/png">


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('login') }}/style.css">
    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> -->
    {{-- <link rel="stylesheet" href="css/style.css"> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* #bgBlueLightWhiteColor {
          background: #4178D5; 
        } */
        body {
            color: #000;
            overflow-x: hidden;
            height: 100%;
            background-color: #B0BEC5;
            background-repeat: no-repeat;
        }

        .card0 {
            box-shadow: 0px 4px 8px 0px #757575;
            border-radius: 0px;
        }

        .card2 {
            margin: 0px 40px;
        }

        .logo {
            width: 200px;
            height: 100px;
            margin-top: 20px;
            margin-left: 35px;
        }

        .text-below-image {
            font-family: 'Poppins', sans-serif;
            font-size: 22px;
            text-align: center;
            margin-top: 10px;
        }

        .highlight-text {
            color: #11529f;
            /* Warna teks */
            font-weight: bold;
            /* Bold */
        }



        .image {
            width: 360px;
            height: 280px;
        }

        .border-line {
            border-right: 1px solid #EEEEEE;
        }

        .facebook {
            background-color: #3b5998;
            color: #fff;
            font-size: 18px;
            padding-top: 5px;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer;
        }

        .twitter {
            background-color: #1DA1F2;
            color: #fff;
            font-size: 18px;
            padding-top: 5px;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer;
        }

        .linkedin {
            background-color: #2867B2;
            color: #fff;
            font-size: 18px;
            padding-top: 5px;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer;
        }

        .line {
            height: 1px;
            width: 45%;
            background-color: #E0E0E0;
            margin-top: 10px;
        }

        .or {
            width: 10%;
            font-weight: bold;
        }

        .text-sm {
            font-size: 14px !important;
        }

        ::placeholder {
            color: #BDBDBD;
            opacity: 1;
            font-weight: 300
        }

        :-ms-input-placeholder {
            color: #BDBDBD;
            font-weight: 300
        }

        ::-ms-input-placeholder {
            color: #BDBDBD;
            font-weight: 300
        }

        input,
        textarea {
            padding: 10px 12px 10px 12px;
            border: 1px solid lightgrey;
            border-radius: 2px;
            margin-bottom: 5px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            color: #2C3E50;
            font-size: 14px;
            letter-spacing: 1px;
        }

        input:focus,
        textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #304FFE;
            outline-width: 0;
        }

        button:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            outline-width: 0;
        }

        a {
            color: inherit;
            cursor: pointer;
        }

        .btn-blue {
            background-color: #11529f;
            width: 150px;
            color: #fff;
            border-radius: 2px;
        }

        .btn-blue:hover {
            background-color: #000;
            cursor: pointer;
        }

        .bg-blue {
            color: #fff;
            background-color: #11529f;
        }

        @media screen and (max-width: 991px) {
            .logo {
                margin-left: 0px;
            }

            .image {
                width: 300px;
                height: 220px;
            }

            .border-line {
                border-right: none;
            }

            .card2 {
                border-top: 1px solid #EEEEEE !important;
                margin: 0px 15px;
            }
        }
    </style>

</head>

<body style="height: 100%;" id="bgBlueLightWhiteColor">
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6">
                    <div class="card1 pb-5">
                        <div class="row">
                            <img style="width: 120px;"
                                src="{{ asset('assets') }}/img/trident_tech_logo/main_logo_trident.png" class="logo">
                        </div>
                        <div class="row px-3 justify-content-center mt-4 mb-5 border-line">
                            <img style="width: 330px;" src="{{ asset('assets') }}/img/easepos_logo/ease6.png" class="image">
                            <p class="text-below-image">EASE <span class="highlight-text">Grow Your Business With
                                    Us!</span></p>
                        </div>


                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <!-- <div class="row mb-4 px-3">
                        <h6 class="mb-0 mr-4 mt-2">Sign in with</h6> -->
                        <!-- <div class="facebook text-center mr-3"><div class="fa fa-facebook"></div></div>
                        <div class="twitter text-center mr-3"><div class="fa fa-twitter"></div></div> -->
                        <!-- <div class="whatsapp text-center mr-3"><div class="fa fa-whatsapp"></div></div>
                    </div> -->
                        <!-- <div class="row px-3 mb-4">
                        <div class="line"></div>
                        <small class="or text-center">Or</small>
                        <div class="line"></div>
                    </div> -->
                        <form action="{{ route('login') }}" method="POST" class="signin-form">
                            @csrf
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm">Username</h6>
                                </label>
                                <input class="mb-4" type="text" name="username" placeholder="username" required>
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm">Password</h6>
                                </label>
                                <input id="password-field" type="password" name="password" placeholder="Password"
                                    required>
                            </div>
                            <div class="row px-3 mb-4">
                                <!-- <div class="custom-control custom-checkbox custom-control-inline">
                            <input id="chk1" type="checkbox" name="chk" class="custom-control-input"> 
                            <label for="chk1" class="custom-control-label text-sm">Remember me</label>
                        </div> -->
                                <a href="#" class="ml-auto mb-0 text-sm">Lupa Password?</a>
                            </div>
                            <div class="row mb-3 px-3">
                                <button type="submit" class="btn btn-blue text-center">Login</button>
                            </div>
                            <div class="row mb-4 px-3">
                                <small class="font-weight-bold">Belum Punya Akun? <a class="text-danger"
                                        href="{{ route('register') }}">Register</a></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-blue py-4">
                <div class="row px-3">
                    <small class="ml-4 ml-sm-5 mb-2 mt-2">Copyright Trident Ease &copy; {{ date('Y') }}. All rights
                        reserved.</small>
                    <div class="social-contact ml-4 ml-sm-auto d-flex">
                        <p class="mr-5 pb-1">Hubungi kami</p>

                        <span class="fa fa-instagram mr-4 text-md mt-2"></span>
                        <a href="">
                            <span class="fa fa-whatsapp mr-4 mr-sm-5 text-md mt-2"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="{{ asset('login') }}/jquery.min.js"></script>
    <script src="{{ asset('login') }}/popper.js"></script>
    <script src="{{ asset('login') }}/bootstrap.min.js"></script>
    <script src="{{ asset('login') }}/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/6.1.1/esm/ionicons.min.js"></script> -->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(session()->has('error'))
        toastr.error('{{ session('
            error ') }}', 'GAGAL!');
        @endif
    </script>
</body>

</html>
