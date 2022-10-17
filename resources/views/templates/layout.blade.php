<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @yield('title')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="icon" href="{{ $cPerusahaan->logo }}" type="image/png">
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
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            {{-- <img class="img-profile rounded-circle" src="{{ asset('assets') }}/dist/img/AdminLTELogo.png" width="30">--}}
            <span class="ml-2 d-none d-lg-inline text-success small">{{ auth()->user()->nama }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{{ url('profile') }}">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
            </a>
            <a class="dropdown-item" href="{{ url('changePW') }}">
              <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
              Change Password
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-items">
              <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="dropdown-item active bg-white" style="font-weight: bold">Logout</button>
              </form>
            </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-primary elevation-4" id="bgBlueLightWhiteColor">
    <!-- Brand Logo -->
    <a href="{{ asset('assets') }}/index3.html" class="brand-link">
      <img src="{{ $cPerusahaan->logo }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 border border-white" style="opacity: .8">
      <span class="brand-text">{{ $cPerusahaan->nama }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex divider">
        <div class="image">
          <img src="{{ asset('assets') }}/img/admin.png" class="img-circle elevation-2 border border-white" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->nama }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @if (auth()->user()->hak_akses === "admin")
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-home"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-store"></i>
                <p>
                  Produk
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('barang2') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Produk</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('barang') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lihat Data Produk</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-user"></i>
                <p>
                  Pegawai
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('pegawai2') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Pegawai</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('users') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Pegawai</p>
                      </a>
                  </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-truck-moving"></i>
                {{-- <i class="nav-icon fas fa-solid fa-cart-plus"></i> --}}
                <p>
                  Supplier
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('supplier2') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Supplier</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('supplier') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Supplier</p>
                      </a>
                  </li>   
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-user"></i>
                <p>
                  Pelanggan
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('pelanggan2') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Pelanggan</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('pelanggan') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Pelanggan</p>
                      </a>
                  </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                <p>
                  Pembelian
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Produk</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Produk</p>
                      </a>
                  </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-calculator"></i>
                <p>
                  Pembayaran
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Produk</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Produk</p>
                      </a>
                  </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                <p>
                  Penjualan
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Produk</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Produk</p>
                      </a>
                  </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-cog"></i>
                <p>
                  Setup Perusahaan
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('keuntungan') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Set Keuntungan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('kategori') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Set Kategori</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('perusahaan') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Set Perusahaan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('merek') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Set Merek</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('satuan') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Set Satuan</p>
                  </a>
                </li>
              </ul>
            </li>
          @elseif (auth()->user()->hak_akses === "kasir")
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-home"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                <p>
                  Pembelian
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Produk</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Produk</p>
                      </a>
                  </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-calculator"></i>
                <p>
                  Pembayaran
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Produk</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Produk</p>
                      </a>
                  </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                <p>
                  Penjualan
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Produk</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Produk</p>
                      </a>
                  </li>
              </ul>
            </li>
          @elseif(auth()->user()->hak_akses === "owner")
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                <p>
                  Laporan Pembelian
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Produk</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Produk</p>
                      </a>
                  </li>
              </ul>
            </li>
            {{-- <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-calculator"></i>
                <p>
                  Laporan Pembayaran
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Produk</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Produk</p>
                      </a>
                  </li>
              </ul>
            </li> --}}
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                <p>
                  Laporan Penjualan
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Produk</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Lihat Data Produk</p>
                      </a>
                  </li>
              </ul>
            </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('contents')
  </div>
  <!-- /.content-wrapper -->

  @include('templates.footer')
