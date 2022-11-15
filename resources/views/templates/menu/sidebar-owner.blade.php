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
            <a href="{{ route('owner.laporan-pembelian.index') }}" class="nav-link">
                <p>Laporan Pembelian</p>
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