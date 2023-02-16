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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">

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
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

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
  /* .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 260px;
      background: #11101d;
      z-index: 100;
      transition: all 0.5s ease;
  } */

  #smol {
    font-size: 15px;
  }

  /* .sidebar.close {
      width: 78px;
  }

  .sidebar .logo-details {
      height: 60px;
      width: 100%;
      display: flex;
      align-items: center;
  }

  .sidebar .logo-details i {
      font-size: 30px;
      color: #fff;
      height: 50px;
      min-width: 78px;
      text-align: center;
      line-height: 50px;
  }

  .sidebar .logo-details .logo_name {
      font-size: 22px;
      color: #fff;
      font-weight: 600;
      transition: 0.3s ease;
      transition-delay: 0.1s;
  }

  .sidebar.close .logo-details .logo_name {
      transition-delay: 0s;
      opacity: 0;
      pointer-events: none;
  }

  .sidebar .nav-links {
      height: 100%;
      padding: 30px 0 150px 0;
      overflow: auto;
  }

  .sidebar.close .nav-links {
      overflow: visible;
  }

  .sidebar .nav-links::-webkit-scrollbar {
      display: none;
  }

  .sidebar .nav-links li {
      position: relative;
      list-style: none;
      transition: all 0.4s ease;
  }

  .sidebar .nav-links li:hover {
      background: #1d1b31;
  }

  .sidebar .nav-links li .iocn-link {
      display: flex;
      align-items: center;
      justify-content: space-between;
  }

  .sidebar.close .nav-links li .iocn-link {
      display: block
  }

  .sidebar .nav-links li i {
      height: 50px;
      min-width: 78px;
      text-align: center;
      line-height: 50px;
      color: #fff;
      font-size: 20px;
      cursor: pointer;
      transition: all 0.3s ease;
  }

  .sidebar .nav-links li.showMenu i.arrow {
      transform: rotate(-180deg);
  }

  .sidebar.close .nav-links i.arrow {
      display: none;
  }

  .sidebar .nav-links li a {
      display: flex;
      align-items: center;
      text-decoration: none;
  }

  .sidebar .nav-links li a .link_name {
      font-size: 18px;
      font-weight: 400;
      color: #fff;
      transition: all 0.4s ease;
  }

  .sidebar.close .nav-links li a .link_name {
      opacity: 0;
      pointer-events: none;
  }

  .sidebar .nav-links li .sub-menu {
      padding: 6px 6px 14px 80px;
      margin-top: -10px;
      background: #1d1b31;
      display: none;
  }

  .sidebar .nav-links li.showMenu .sub-menu {
      display: block;
  }

  .sidebar .nav-links li .sub-menu a {
      color: #fff;
      font-size: 15px;
      padding: 5px 0;
      white-space: nowrap;
      opacity: 0.6;
      transition: all 0.3s ease;
  }

  .sidebar .nav-links li .sub-menu a:hover {
      opacity: 1;
  }

  .sidebar.close .nav-links li .sub-menu {
      position: absolute;
      left: 100%;
      top: -10px;
      margin-top: 0;
      padding: 10px 20px;
      border-radius: 0 6px 6px 0;
      opacity: 0;
      display: block;
      pointer-events: none;
      transition: 0s;
  }

  .sidebar.close .nav-links li:hover .sub-menu {
      top: 0;
      opacity: 1;
      pointer-events: auto;
      transition: all 0.4s ease;
  }

  .sidebar .nav-links li .sub-menu .link_name {
      display: none;
  }

  .sidebar.close .nav-links li .sub-menu .link_name {
      font-size: 18px;
      opacity: 1;
      display: block;
  }

  .sidebar .nav-links li .sub-menu.blank {
      opacity: 1;
      pointer-events: auto;
      padding: 3px 20px 6px 16px;
      opacity: 0;
      pointer-events: none;
  }

  .sidebar .nav-links li:hover .sub-menu.blank {
      top: 50%;
      transform: translateY(-50%);
  }

  .sidebar .profile-details {
      position: fixed;
      bottom: 0;
      width: 260px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #1d1b31;
      padding: 12px 0;
      transition: all 0.5s ease;
  }

  .sidebar.close .profile-details {
      background: none;
  }

  .sidebar.close .profile-details {
      width: 78px;
  }

  .sidebar .profile-details .profile-content {
      display: flex;
      align-items: center;
  }

  .sidebar .profile-details img {
      height: 52px;
      width: 52px;
      object-fit: cover;
      border-radius: 16px;
      margin: 0 14px 0 12px;
      background: #1d1b31;
      transition: all 0.5s ease;
  }

  .sidebar.close .profile-details img {
      padding: 10px;
  }

  .sidebar .profile-details .profile_name,
  .sidebar .profile-details .job {
      color: #fff;
      font-size: 18px;
      font-weight: 500;
      white-space: nowrap;
  }

  .sidebar.close .profile-details i,
  .sidebar.close .profile-details .profile_name,
  .sidebar.close .profile-details .job {
      display: none;
  }

  .sidebar .profile-details .job {
      font-size: 12px;
  }

  .home-section {
      position: relative;
      background: #E4E9F7;
      height: 100vh;
      left: 260px;
      width: calc(100% - 260px);
      transition: all 0.5s ease;
  }

  .sidebar.close~.home-section {
      left: 78px;
      width: calc(100% - 78px);
  }

  .home-section .home-content {
      height: 60px;
      display: flex;
      align-items: center;
  }

  .home-section .home-content .bx-menu,
  .home-section .home-content .text {
      color: #11101d;
      font-size: 35px;
  }

  .home-section .home-content .bx-menu {
      margin: 0 15px;
      cursor: pointer;
  }

  .home-section .home-content .text {
      font-size: 26px;
      font-weight: 600;
  }

  @media (max-width: 400px) {
      .sidebar.close .nav-links li .sub-menu {
          display: none;
      }

      .sidebar {
          width: 78px;
      }

      .sidebar.close {
          width: 0;
      }

      .home-section {
          left: 78px;
          width: calc(100% - 78px);
          z-index: 100;
      }

      .sidebar.close~.home-section {
          width: 100%;
          left: 0;
      }
  } */
</style>
@stack('styles')