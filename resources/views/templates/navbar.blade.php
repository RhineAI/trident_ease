  <!-- Navbar -->
<style>
    .dropdowns {
        position: relative;
        display: inline-block;
    }

    .dropdowns-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 190px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        margin-top: 18px;
        padding: 8px 1px;
        z-index: 1;
    }

    #dropdowns-toggle {
        outline: none;
        box-shadow: 0 0 0 0.125rem white;
    }

    /* .dropdowns:onclick .dropdowns-content {
        display: block;
    } */
/* 
    input[type=button]:onclick .dropdowns-content {
        display: block;
    } */
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav col-md-10">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    {{-- <div class="dropdowns">
        <button class="btn" type="button">
            {{ ucFirst(auth()->user()->nama) }}
        </button>
        <div class="dropdowns-content" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
          </div>
    </div> --}}
    <div class="nav-item dropdowns" id="dropdowns">
        <button class="btn nav-link dropdown-toggle" id="dropdowns-toggle" style="margin-top:-20px;" type="button">
            <img class="img-profile rounded-circle" src="{{ asset('assets') }}/img/admin.png"
            style="max-width: 35px;">
            @if (auth()->user()->nama == NULL) 
                <span class="ml-2 d-none d-lg-inline text-dark small" style="font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">User</span>
            @else 
                <span class="ml-2 d-none d-lg-inline text-dark small" style="font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">{{ ucFirst(auth()->user()->nama) }}</span>
            @endif
        </button>
        <div class="dropdowns-content shadow animated--grow-in" id="dropdowns-content" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{{ route('profile') }}">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
            </a>
            <a class="dropdown-item" href="{{ route('changePW') }}">
                <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                 Ganti Password
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
        </div>
    </div>
</nav>
<!-- /.navbar -->

{{-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <div class="col-md-10">
        <ul class="navbar-nav">
            <li class="nav-item my-2">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

            <div class="col-md-12" >
                    
                <div id="MyClockDisplay" class="clock" onload="showTime()"></div>

            </div>

        </ul>
        
    </div>

    <div class="col-md-2">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
               
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu open">
                    <a href="#" class="" data-toggle="dropdown">
                        <img src="{{ asset('images/'.Auth::user()->foto) }}" class="user-image images-profile"
                            alt="User Image">
                    </a>
                    <span class="hidden-xs">{{ auth()->user()->username }}</span>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('images/'.Auth::user()->foto) }}" class="img-circle images-profile"
                                alt="User Image">
    
                            <p>
                                <b>Username</b> : {{ auth()->user()->username }}
                                <br>
                                <b>Email</b> : {{ auth()->user()->email }}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="">
                                <a href="{{ route('user.profile') }}" class="btn btn-success btn-flat btn-sm rounded"><i class="fa fa-pen-to-square"></i> Update Profile</a>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="#" class="btn btn-danger btn-flat btn-sm rounded"
                                    onclick="$('#logout-form').submit()"><i class="fa fa-arrow-right-from-bracket"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav> --}}

<script>
    // $(document).on('click', '.dropdowns', function() {
    //     $('.dropdowns-content').style.display="block";
    // })

    var button = document.getElementById('dropdowns-toggle');
    var content = document.getElementById('dropdowns-content');

    button.addEventListener('click', function() {
        if(content.style.display == "none"){
            content.style.display="block";
        } else {
            content.style.display = "none";
        }
    })
</script>
