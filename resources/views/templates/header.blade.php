<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@yield('title')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
{{-- <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
<link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="icon" href="{{ $cPerusahaan->logo }}" type="image/png">

{{-- Bootstrap Icon --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/bootstrap-icons.svg">

{{-- Toastr --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- MDI --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">

<style>
  #bgBlueLightWhiteColor {
    background: #4195D5; 
  }

  #bgBlueLightWhiteColor a, #bgBlueLightWhiteColor span, #bgBlueLightWhiteColor p {
    color: white; 
  }
  
  #bgBlueLightWhiteColor a:hover, #bgBlueLightWhiteColor span:hover, #bgBlueLightWhiteColor p:hover {
    background:  #4178D5;
  }

  .divider {
    border-top: 1px solid white;
    border-bottom: 1px solid white;
    padding-top: 10px;
    padding-bottom: 10px;
  }
</style>
@stack('styles')