  <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="ml-2 d-none d-lg-inline text-success small">{{ auth()->user()->nama }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ url('profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="{{ url('changePW') }}">
                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                    Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-items">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item active bg-white"
                            style="font-weight: bold">Logout</button>
                    </form>
                </a>
            </div>
        </li>
    </ul>
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