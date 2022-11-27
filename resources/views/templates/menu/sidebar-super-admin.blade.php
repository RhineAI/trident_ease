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


<li class="nav-item">
    <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-solid fa-right-from-bracket"></i>
        <p>Logout</p>
    </a>
</li>