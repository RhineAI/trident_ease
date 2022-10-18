<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Terima Kasih</title>
</head>
<body>
    <div class="jumbotron text-center">
        <h1 class="display-3">Terima Kasih Telah Mendaftar!</h1>
        <p class="lead"><strong>Silahkan Cek Email</strong> Untuk melanjutkan ke halaman login.</p>
        <hr>
        <p>
          Ada Masalah? <a href="https://wa.wizard.id/31a293">Contact us</a>
        </p>
        <p class="lead">
          <a class="btn btn-primary btn-sm" href="{{ route('login') }}" role="button">Melanjutkan Ke halaman <strong>Login</strong></a>
        </p>
      </div>

      {{-- Toastr --}}
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

     <script>
         @if(session()->has('success'))
             toastr.success('{{ session('success') }}', 'TERIMA KASIH!'); 
 
         @elseif(session()->has('error'))
 
             toastr.error('{{ session('error') }}', 'GAGAL!'); 
         @endif
     </script>
</body>
</html>