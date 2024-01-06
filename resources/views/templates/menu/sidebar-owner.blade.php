 {{-- DASHBOARD --}}
 <li class="nav-item">
    <a href="{{ route('owner.dashboard') }}" class="nav-link">
        <i class="nav-icon fas fa-solid fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>

@if (auth()->user()->perusahaan->grade >= 3)
    {{-- Stock Opname --}}
    <li class="nav-item">
        <a href="{{ route('owner.stockOpname') }}" class="nav-link">
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
        @if (auth()->user()->perusahaan->grade !== 1)
            <li class="nav-item">
                <a href="{{ route('owner.laporan-harian.index') }}" class="nav-link">
                    <p id="smol">Laporan Harian</p>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a href="{{ route('owner.laporan-penjualan.index') }}" class="nav-link">
                <p id="smol">Laporan Penjualan</p>
            </a>
        </li>
        @if (auth()->user()->perusahaan->grade !== 1)
            <li class="nav-item">
                <a href="{{ route('owner.laporan-pembelian.index') }}" class="nav-link">
                    <p id="smol">Laporan Pembelian</p>
                </a>
            </li>   
            <li class="nav-item">
                <a href="{{ route('owner.list-b-pelanggan.index') }}" class="nav-link">
                    <p id="smol">Laporan Pelanggan Terbaik</p>
                </a>
            </li>
        @endif
        @if (auth()->user()->perusahaan->grade >= 3)
            <li class="nav-item">
                <a href="{{ route('owner.laporan-kas.index') }}" class="nav-link">
                    <p class="smol">Laporan Kas</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('owner.laporan-hutang.index') }}" class="nav-link">
                    <p class="smol">Laporan Hutang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('owner.laporan-piutang.index') }}" class="nav-link">
                    <p class="smol">Laporan Piutang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('owner.laporan-stok.index') }}" class="nav-link">
                    <p class="smol">Laporan Stok</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('owner.laporan-kesesuaian-stok.index') }}" class="nav-link">
                    <p class="smol">Laporan Kesesuaian Stok</p>
                </a>
            </li>
        @endif
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
                <p class="smol">Tambah Pegawai</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('owner.users.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p class="smol">Data Pegawai</p>
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
        @if (auth()->user()->perusahaan->grade !== 1)
            <li class="nav-item">
                <a href="{{ route('owner.perusahaan.index') }}" class="nav-link">
                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                    <p class="smol">Set Perusahaan</p>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a href="{{ route('owner.keuntungan') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p class="smol">Set Keuntungan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('owner.kategori.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p class="smol">Set Kategori</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('owner.merek.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p class="smol">Set Merek</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('owner.satuan.index') }}" class="nav-link">
                {{-- <i class="far fa-circle nav-icon"></i> --}}
                <p class="smol">Set Satuan</p>
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