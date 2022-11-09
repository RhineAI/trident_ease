<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

@yield('title')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
{{-- <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
<link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
@if ($cPerusahaan->logo == null)
  <link rel="icon" href="{{ asset('assets') }}/img/buildings.png" type="image/png">
@else
  <link rel="icon" href="{{ $cPerusahaan->logo }}" type="image/png">
@endif
{{-- Bootstrap v5.2 --}}
<!-- CSS only -->
{{-- Bootstrap Icon --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/bootstrap-icons.svg"> --}}
{{-- Bootstrap Validator --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.min.css"> --}}
{{-- Toastr --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- MDI --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
<!-- FlatPickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/js/bootstrap.min.js"></script> --}}
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