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