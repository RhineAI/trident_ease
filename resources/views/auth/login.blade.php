<!doctype html>
<html lang="en">

<head>
    <title>ZIE Pos</title>
    <meta charset="utf-8">
    <link rel="icon" href="{{ asset('assets') }}/img/buildings.png" type="image/png">


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('login') }}/style.css">
    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    {{-- <link rel="stylesheet" href="css/style.css"> --}}
    <style>
        #bgBlueLightWhiteColor {
          background: #4178D5; 
        }
    </style>

</head>

<body style="height: 100%;" id="bgBlueLightWhiteColor">
    <section class="ftco-section" id="bgBlueLightWhiteColor">
        <div class="container" id="bgBlueLightWhiteColor">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-3">
                    {{-- <h2 class="heading-section">ZIE POS</h2> --}}
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <img src="{{ asset('assets') }}/img/easepos_logo/ease6.png" alt="" class="text-center mb-4 rounded-circle" style="width: 5.5em; height:5em; display: block; margin-left: auto; margin-right: auto;">
                        <form action="{{ route('login') }}" method="POST" class="signin-form">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" name="password" class="form-control" placeholder="Password"
                                    required>
                                <span toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password" style="color: #736f66"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Masuk</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <a href="https://smkn1cianjur.sch.id/" target="_blank" style="color: #fff">Informasi Lebih Lanjut</a>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="{{ route('reg') }}" style="color: #eee">Buat Akun?</a>
                                </div>
                            </div>
                        </form>
                        <p class="w-100 h-25 text-center">&mdash; Selamat Datang &mdash;</p>
                        <div class="social d-flex text-center p-0">
                            {{-- <a href="https://wa.wizard.id/17fae7" target="_blank" class="px-2 py-2 mr-md-1 rounded"><i class="bi bi-whatsapp"></i>
                                Whatsapp</a> --}}
                            {{-- <a href="https://smkn1cianjur.sch.id/" target="_blank" class="btn px-2 ml-md-1 rounded"><i class="bi bi-browser-firefox"></i>
                                Website</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('login') }}/jquery.min.js"></script>
    <script src="{{ asset('login') }}/popper.js"></script>
    <script src="{{ asset('login') }}/bootstrap.min.js"></script>
    <script src="{{ asset('login') }}/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/6.1.1/esm/ionicons.min.js"></script>
</body>

</html>
