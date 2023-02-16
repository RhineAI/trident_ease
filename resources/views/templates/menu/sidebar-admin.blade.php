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
                <p id="smol">Tambah Produk</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.barang.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Data Produk Utama</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.barang.indexKonsinyasi') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Data Produk Konsinyasi</p>
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
                <p id="smol">Tambah Pegawai</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Data Pegawai</p>
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
                <p id="smol">Tambah Supplier</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.supplier.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Data Supplier</p>
            </a>
        </li>
    </ul>
</li>

{{-- PELANGGAN --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-solid fa-users"></i>
        <p>
            Pelanggan
            <i class="right fas fa-angle-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview ml-4">
        <li class="nav-item">
            <a href="{{ route('admin.pelanggan2') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Tambah Pelanggan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.pelanggan.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Data Pelanggan</p>
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
                <p id="smol">Transaksi Pembelian</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.list-pembelian.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Data Pembelian</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.data-hutang.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Data Hutang</p>
            </a>
        </li>
        <hr>
        <li class="nav-item">
            <a href="{{ route('admin.transaksi-penjualan.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Transaksi Penjualan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.list-transaksi.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Data Penjualan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.data-piutang.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Data Piutang</p>
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
            </a id="smol">
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.list-retur-penjualan.index') }}" class="nav-link">
                <p id="smol">Data Retur Penjualan</p>
            </a>
        </li>
        <hr>
        <li class="nav-item">
            <a href="{{ route('admin.retur-pembelian.index') }}" class="nav-link">
                <p id="smol">Tambah Retur Pembelian</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.list-retur-pembelian.index') }}" class="nav-link">
                <p id="smol" >Data Retur Pembelian</p>
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
            </a id="smol">
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.kas-keluar.index') }}" class="nav-link">
                <p id="smol">Kas Keluar</p>
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
                <p id="smol">Stock Opname</p>
            </a id="smol">
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan-harian.index') }}" class="nav-link">
                <p id="smol">Laporan Harian</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan-kas.index') }}" class="nav-link">
                <p id="smol">Laporan Kas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan-penjualan.index') }}" class="nav-link">
                <p id="smol">Laporan Penjualan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan-pembelian.index') }}" class="nav-link">
                <p id="smol">Laporan Pembelian</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan-hutang.index') }}" class="nav-link">
                <p id="smol">Laporan Hutang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan-piutang.index') }}" class="nav-link">
                <p id="smol">Laporan Piutang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan-stok.index') }}" class="nav-link">
                <p id="smol">Laporan Stok</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan-kesesuaian-stok.index') }}" class="nav-link">
                <p id="smol">Laporan Kesesuaian Stok</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.list-b-pelanggan.index') }}" class="nav-link">
                <p id="smol">Laporan Pelanggan Terbaik</p>
            </a>
        </li>
    </ul>
</li>

{{-- SETUP PERUSAHAAN --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-solid fa-gears"></i>
        <p>
            Setup Perusahaan
            <i class="right fas fa-angle-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview ml-4">
        <li class="nav-item">
            <a href="{{ route('admin.perusahaan.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Set Perusahaan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.keuntungan') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Set Keuntungan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.kategori.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Set Kategori</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.merek.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Set Merek</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.satuan.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Set Satuan</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-solid fa-right-from-bracket"></i>
        <p>Logout</p>
    </a>
</li>