@php
    $grade = auth()->user()->perusahaan->grade;
@endphp
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
                <p class="smol">Transaksi Baru</p>
            </a>
        </li>
        @if ($grade == 3)
            <li class="nav-item">
                <a href="{{ route('kasir.list-transaksi.index') }}" class="nav-link">
                    <p class="smol">Riwayat Transaksi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kasir.data-piutang.index') }}" class="nav-link">
                    <p class="smol">Tunggakan Customer</p>
                </a>
            </li>
        @endif
    </ul>
</li>

{{-- RETUR --}}
@if ($grade >= 2)
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
                    <p class="smol">Tambah Retur Penjualan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kasir.list-retur-penjualan.index') }}" class="nav-link">
                    <p class="smol">Data Retur Penjualan</p>
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
                <a href="{{ route('kasir.pelanggan2') }}" class="nav-link">
                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                    <p class="smol">Tambah Pelanggan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kasir.pelanggan.index') }}" class="nav-link">
                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                    <p class="smol">Data Pelanggan</p>
                </a>
            </li>
        </ul>
    </li>
@endif

<li class="nav-item">
    <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-solid fa-right-from-bracket"></i>
        <p>Logout</p>
    </a>
</li>
{{-- LAPORAN
<li class="nav-item">
    <a href="{{ route('list-b-pelanggan.index') }}" class="nav-link">
        <i class="nav-icon fas fa-solid fa-list-check"></i>
            <p>Pelanggan Terbaik</p>
        </a>      
    </a>
</li> --}}