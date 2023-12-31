<!-- Main Sidebar Container -->
<style>
 .bgDarkWhiteColor {
    background: #0e0e0e;
  }

  .bgDarkWhiteColor a, .bgDarkWhiteColor span, .bgDarkWhiteColor p {
    color: white; 
  }

  .bgDarkWhiteColor a:hover, .bgDarkWhiteColor span:hover, .bgDarkWhiteColor p:hover {
    background: black;
  }
</style>
<aside class="main-sidebar sidebar-primary elevation-4" id="bgBlueLightWhiteColor" style="position:fixed; overflow:auto; height:30em">
    <!-- Brand Logo -->
    <a href="#" class="brand-link ">
        <img src="{{ asset('assets') }}/img/easepos_logo/ease8.png" alt="AdminLTE Logo" class="brand-image  ">
        <span class="brand-text">EASE</span>
    </a>
   

    <!-- Sidebar -->
    <div class="sidebar">
        
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-1 pb-3 mb-1 d-flex divider">
            <div class="image">
                <img 
                    @if ($cPerusahaan->logo == null)
                        src="{{ asset('assets') }}/img/easepos_logo/ease6.png" 
                    @elseif ($cPerusahaan->id == 1)
                        src="{{ asset('assets') }}/img/trident_tech_logo/blue trident black bg.png" 
                    @else
                        src="{{ url('storage/img/'. $cPerusahaan->logo) }}" alt="AdminLTE Logo"
                    @endif
                class="brand-image img-circle elevation-3 border border-white" style="opacity: .9">
            </div>
            <div class="info">
                <a href="{{ route(Auth::user()->hak_akses.'.profile.cards') }}" class="d-block" style="text-decoration: none;">{{ $cPerusahaan->nama }}</a>
            </div>
        </div>

        {{-- <a href="" class="brand-link divider mt-3 mb-3 pb-2" style="text-decoration: none;">
            @if ($cPerusahaan->logo == null)
                <img src="{{ asset('assets') }}/img/admin.png" class="img-circle elevation-3 border border-white" style="opacity: .9;"
                    alt="User Image">
            @else
                <img src="{{ $cPerusahaan->logo }}" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3 border border-white" style="opacity: .9">
            @endif
            <span class="brand-text"></span>
        </a> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="mb-5 nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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