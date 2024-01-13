 @php
    $grade = auth()->user()->perusahaan->grade;
 @endphp
 {{-- DASHBOARD --}}
 <li class="nav-item">
    <a href="{{ route('admin.dashboard') }}" class="nav-link">
        <i class="nav-icon fas fa-solid fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
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
        @if ($grade !== 1)
            <li class="nav-item">
                <a href="{{ route('admin.perusahaan.index') }}" class="nav-link">
                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                    <p id="smol">Set Perusahaan</p>
                </a>
            </li>
        @endif
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

@if ($grade !== 1)
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
@endif

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

@if ($grade !== 1)
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
@endif

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
                <p id="smol">Pembelian Barang (Restock)</p>
            </a>
        </li>
        @if ($grade >= 3)
            <li class="nav-item">
                <a href="{{ route('admin.list-pembelian.index') }}" class="nav-link">
                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                    <p id="smol">Riwayat Pembelian</p>
                </a>
            </li>
        @endif
        @if ($grade !== 1)
            <li class="nav-item">
                <a href="{{ route('admin.data-hutang.index') }}" class="nav-link">
                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                    <p id="smol">Riwayat Hutang</p>
                </a>
            </li>
            <hr>
        @endif
        <li class="nav-item">
            <a href="{{ route('admin.transaksi-penjualan.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p id="smol">Transaksi Penjualan</p>
            </a>
        </li>
        @if ($grade >= 3)
            <li class="nav-item">
                <a href="{{ route('admin.list-transaksi.index') }}" class="nav-link">
                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                    <p id="smol">Riwayat Penjualan</p>
                </a>
            </li>
        @endif
        @if ($grade !== 1)
            <li class="nav-item">
                <a href="{{ route('admin.data-piutang.index') }}" class="nav-link">
                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                    <p id="smol">Riwayat Piutang</p>
                </a>
            </li>
        @endif
    </ul>
</li>

@if ($grade !== 1)
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
                <a href="{{ route('admin.retur-pembelian.index') }}" class="nav-link">
                    <p id="smol">Retur Pembelian</p>
                </a>
            </li>
            @if ($grade >= 3)
                <li class="nav-item">
                    <a href="{{ route('admin.list-retur-pembelian.index') }}" class="nav-link">
                        <p id="smol" >Riwayat Retur Pembelian</p>
                    </a>
                </li>
                <hr>
            @endif
            <li class="nav-item">
                <a href="{{ route('admin.retur-penjualan.index') }}" class="nav-link">
                    <p>Retur Penjualan</p>
                </a id="smol">
            </li>
            @if ($grade >= 3)
                <li class="nav-item">
                    <a href="{{ route('admin.list-retur-penjualan.index') }}" class="nav-link">
                        <p id="smol">Riwayat Retur Penjualan</p>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif


@if ($grade >= 3)
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

    {{-- Stock Opname --}}
    <li class="nav-item">
        <a href="{{ route('admin.stockOpname') }}" class="nav-link">
            <i class="nav-icon fas fa-solid fa-gear"></i>
            <p>
                Stock Opname
            </p>
        </a>
    </li>
@endif

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
        @if ($grade !== 1)
            <li class="nav-item">
                <a href="{{ route('admin.laporan-harian.index') }}" class="nav-link">
                    <p id="smol">Laporan Harian</p>
                </a>
            </li>
        @endif
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
        @if ($grade !== 1)  
            <li class="nav-item">
                <a href="{{ route('admin.list-b-pelanggan.index') }}" class="nav-link">
                    <p id="smol">Laporan Pelanggan Terbaik</p>
                </a>
            </li>
        @endif
        @if ($grade >= 3)
            <li class="nav-item">
                <a href="{{ route('admin.laporan-kas.index') }}" class="nav-link">
                    <p class="smol">Laporan Kas</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.laporan-hutang.index') }}" class="nav-link">
                    <p class="smol">Laporan Hutang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.laporan-piutang.index') }}" class="nav-link">
                    <p class="smol">Laporan Piutang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.laporan-stok.index') }}" class="nav-link">
                    <p class="smol">Laporan Stok</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.laporan-kesesuaian-stok.index') }}" class="nav-link">
                    <p class="smol">Laporan Kesesuaian Stok</p>
                </a>
            </li>
        @endif
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-solid fa-right-from-bracket"></i>
        <p>Logout</p>
    </a>
</li>