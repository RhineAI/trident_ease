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
                  @include('templates.menu.sidebar-super-admin')
                @endif
                

                @if(auth()->user()->hak_akses == 'owner')
                    @include('templates.menu.sidebar-owner')
                @endif
                

                @if (auth()->user()->hak_akses == 'admin')
                    @include('templates.menu.sidebar-admin')
                @endif
                


                @if(auth()->user()->hak_akses == 'kasir') 
                   @include('templates.menu.sidebar-kasir')
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>