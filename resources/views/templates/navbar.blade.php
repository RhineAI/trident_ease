  <!-- Navbar -->
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css "> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script> --}}
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
              {{-- <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
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
              </div>  --}}
              <!-- Example split danger button -->
                {{-- <div class="btn-group">
                    <button type="button" class="btn btn-danger">{{ auth()->user()->nama }}</button>
                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div> --}}
          </li>
      </ul>
  </nav>
  <!-- /.navbar -->