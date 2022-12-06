<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-primary elevation-4" id="bgBlueLightWhiteColor" style="position:fixed; overflow:auto; height:30em">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('assets') }}/img/ziepos.png" alt="AdminLTE Logo"
            class="brand-image img-circle  elevation-3 border border-white">
        <span class="brand-text">ZiePOS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex divider">
            <div class="image">
                @if ($cPerusahaan->logo == null)
                    <img src="{{ asset('assets') }}/img/admin.png" class="img-circle elevation-3 border border-white" style="opacity: .9;"
                        alt="User Image">
                @else
                    <img src="{{ $cPerusahaan->logo }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3 border border-white" style="opacity: .9">
                @endif
            </div>
            <div class="info">
                <a href="{{ route(Auth::user()->hak_akses.'.profile.cards') }}" class="d-block">{{ $cPerusahaan->nama }}</a>
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