<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Aplikasi POS</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('templates') }}/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('templates') }}/css/style.css">
    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    {{-- @if(session('success'))
        <div class="alert alert-success" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </div>
    @endif --}}
    <style>
        /* Logo Terbaru 1 */
    img{
        width: 100%;
        height: 310px;
        background-color:white;
        margin-left:8.5%;
    }

        background: url(.png);

    </style>

    <div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container" style="border: 0.3px solid black">
                <div class="signin-content">
                    {{-- <div class="signin-image"> --}}
                        {{-- <figure><img src="{{ asset('templates') }}/img/zielogin.jpg" alt="sing up image"></figure> --}}
                        <figure><img src="{{ asset('assets') }}/img/zielogin.png" alt="sing up image"></figure>
                    {{-- </div>s --}}

                    <div class="signin-form">
                        <h2 class="form-title">Sign in</h2>
                        <form method="POST" class="register-form mb-5" id="login-form">
                            @csrf
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Username"/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        <p>
                            Don't Have Account?<a href="{{ route('reg') }}" style="color:burlywood" > Create one for free!</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="{{ asset('templates') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('templates') }}/js/main.js"></script>
    <script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/dist/js/adminlte.min.js"></script>
    {{-- <script src="{{ asset('assets') }}/dist/js/demo.js"></script> --}}
    <script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="{{ asset('js') }}/sweetalert2.all.min.js"></script>
    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(session()->has('success'))
            toastr.success('{{ session('success') }}', 'TERIMA KASIH!'); 

        @elseif(session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!'); 
        @endif
    </script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>