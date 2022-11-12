<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-primary elevation-4" id="bgBlueLightWhiteColor">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        @if ($cPerusahaan->logo == null)
        <img src="{{ asset('assets') }}/img/buildings.png" alt="AdminLTE Logo"
            class="brand-image img-circle  elevation-3 border border-white" style="opacity: .8">
        @else
        <img src="{{ $cPerusahaan->logo }}" alt="AdminLTE Logo"
            class="brand-image img-circle  elevation-3 border border-white" style="opacity: .8">
        @endif
        <span class="brand-text">{{ $cPerusahaan->nama }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex divider">
            <div class="image">
                <img src="{{ asset('assets') }}/img/admin.png" class="img-circle elevation-2 border border-white"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->nama }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- @yield('templates.menu.sidebar-admin') --}}
                @if(auth()->user()->hak_akses == 'super_admin')
                    {{-- DASHBOARD --}}
                    <li class="nav-item">
                        <a href="{{ route('super_admin.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    {{-- Manage Perusahaan --}}
                    <li class="nav-item">
                        <a href="{{ route('super_admin.manage-perusahaan.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-people-roof"></i>
                            <p>
                                Manage Perusahaan
                            </p>
                        </a>
                    </li>
                @endif
                

                @if(auth()->user()->hak_akses == 'owner')

                    {{-- DASHBOARD --}}
                    <li class="nav-item">
                        <a href="{{ route('owner.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    {{-- LAPORAN --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-list-check"></i>
                            <p>
                                Laporan
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4 ml-4">
                            <li class="nav-item">
                                <a href="{{ route('owner.stockOpname') }}" class="nav-link">
                                    <p>Stock Opname</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.laporan-harian.index') }}" class="nav-link">
                                    <p>Laporan Harian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.laporan-kas.index') }}" class="nav-link">
                                    <p>Laporan Kas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.laporan-penjualan.index') }}" class="nav-link">
                                    <p>Laporan Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.laporan-hutang.index') }}" class="nav-link">
                                    <p>Laporan Hutang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.laporan-piutang.index') }}" class="nav-link">
                                    <p>Laporan Piutang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.laporan-stok.index') }}" class="nav-link">
                                    <p>Laporan Stok</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.laporan-kesesuaian-stok.index') }}" class="nav-link">
                                    <p>Laporan Kesesuaian Stok</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.list-b-pelanggan.index') }}" class="nav-link">
                                    <p>Laporan Pelanggan Terbaik</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                     {{-- PEGAWAI --}}
                     <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-user"></i>
                            <p>
                                Pegawai
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('owner.pegawai2') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Tambah Pegawai</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.users.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Data Pegawai</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                

                @if (auth()->user()->hak_akses == 'admin')

                    {{-- DASHBOARD --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    {{-- PRODUK --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-store"></i>
                            <p>
                                Produk
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('admin.barang2') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Tambah Produk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.barang.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Data Produk</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- PEGAWAI --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-user"></i>
                            <p>
                                Pegawai
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('admin.pegawai2') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Tambah Pegawai</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Data Pegawai</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- SUPPLIER --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-truck-moving"></i>
                            {{-- <i class="nav-icon fas fa-solid fa-cart-plus"></i> --}}
                            <p>
                                Supplier
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('admin.supplier2') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Tambah Supplier</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.supplier.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Data Supplier</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- PELANGGAN --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-user"></i>
                            <p>
                                Pelanggan
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('admin.pelanggan2') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Tambah Pelanggan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.pelanggan.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Data Pelanggan</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- TRANSAKSI --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                            <p>
                                Transaksi
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('admin.transaksi-pembelian.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Transaksi Pembelian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.list-pembelian.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Data Pembelian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.data-hutang.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Data Hutang</p>
                                </a>
                            </li>
                            <hr>
                            <li class="nav-item">
                                <a href="{{ route('admin.transaksi-penjualan.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Transaksi Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.list-transaksi.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Data Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.data-piutang.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Data Piutang</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- KAS --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-money-bill-wave"></i>
                            <p>
                                Kas
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4 ml-4">
                            <li class="nav-item">
                                <a href="{{ route('admin.kas-masuk.index') }}" class="nav-link">
                                    <p>Kas Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.kas-keluar.index') }}" class="nav-link">
                                    <p>Kas Keluar</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- LAPORAN --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-list-check"></i>
                            <p>
                                Laporan
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4 ml-4">
                            <li class="nav-item">
                                <a href="{{ route('admin.stockOpname') }}" class="nav-link">
                                    <p>Stock Opname</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan-harian.index') }}" class="nav-link">
                                    <p>Laporan Harian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan-kas.index') }}" class="nav-link">
                                    <p>Laporan Kas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan-penjualan.index') }}" class="nav-link">
                                    <p>Laporan Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan-hutang.index') }}" class="nav-link">
                                    <p>Laporan Hutang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan-piutang.index') }}" class="nav-link">
                                    <p>Laporan Piutang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan-stok.index') }}" class="nav-link">
                                    <p>Laporan Stok</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.laporan-kesesuaian-stok.index') }}" class="nav-link">
                                    <p>Laporan Kesesuaian Stok</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.list-b-pelanggan.index') }}" class="nav-link">
                                    <p>Laporan Pelanggan Terbaik</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- RETUR --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-rotate-left"></i>
                            <p>
                                Retur
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4 ml-4">
                            <li class="nav-item">
                                <a href="{{ route('admin.retur-penjualan.index') }}" class="nav-link">
                                    <p>Tambah Retur Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.list-retur-penjualan.index') }}" class="nav-link">
                                    <p>Data Retur Penjualan</p>
                                </a>
                            </li>
                            <hr>
                            <li class="nav-item">
                                <a href="{{ route('admin.retur-pembelian.index') }}" class="nav-link">
                                    <p>Tambah Retur Pembelian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.list-retur-pembelian.index') }}" class="nav-link">
                                    <p>Data Retur Pembelian</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- SETUP PERUSAHAAN --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-cog"></i>
                            <p>
                                Setup Perusahaan
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('admin.perusahaan.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Set Perusahaan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.keuntungan') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Set Keuntungan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.kategori.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Set Kategori</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.merek.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Set Merek</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.satuan.index') }}" class="nav-link">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Set Satuan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                


                @if(auth()->user()->hak_akses == 'kasir') 
                    {{-- DASHBOARD --}}
                    <li class="nav-item">
                        <a href="{{ route('kasir.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    {{-- TRANSAKSI --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                            <p>
                                Transaksi
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4 ml-4">
                            <li class="nav-item">
                                <a href="{{ route('kasir.transaksi-penjualan.index') }}" class="nav-link">
                                    <p>Transaksi Baru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kasir.list-transaksi.index') }}" class="nav-link">
                                    <p>Data Transaksi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kasir.data-piutang.index') }}" class="nav-link">
                                    <p>Tunggakan</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- RETUR --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-rotate-left"></i>
                            <p>
                                Retur
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4 ml-4">
                            <li class="nav-item">
                                <a href="{{ route('kasir.retur-penjualan.index') }}" class="nav-link">
                                    <p>Tambah Retur Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kasir.list-retur-penjualan.index') }}" class="nav-link">
                                    <p>Data Retur Penjualan</p>
                                </a>
                            </li>
                            </ul>
                    </li>

                    {{-- LAPORAN
                    <li class="nav-item">
                        <a href="{{ route('list-b-pelanggan.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-list-check"></i>
                                <p>Pelanggan Terbaik</p>
                            </a>      
                        </a>
                    </li> --}}

                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>