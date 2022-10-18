  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-primary elevation-4" id="bgBlueLightWhiteColor">
      <!-- Brand Logo -->
      <a href="{{ asset('assets') }}/index3.html" class="brand-link">
          <img src="{{ $cPerusahaan->logo }}" alt="AdminLTE Logo"
              class="brand-image img-circle  elevation-3 border border-white" style="opacity: .8">
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
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">

                  @if (auth()->user()->hak_akses == 1)
                  <li class="nav-item">
                      <a href="{{ route('dashboard') }}" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-home"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-store"></i>
                          <p>
                              Produk
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('barang2') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Tambah Produk</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('barang.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lihat Data Produk</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-user"></i>
                          <p>
                              Pegawai
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('pegawai2') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Tambah Pegawai</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('users.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lihat Data Pegawai</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-truck-moving"></i>
                          {{-- <i class="nav-icon fas fa-solid fa-cart-plus"></i> --}}
                          <p>
                              Supplier
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('supplier2') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Tambah Supplier</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('supplier.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lihat Data Supplier</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-user"></i>
                          <p>
                              Pelanggan
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('pelanggan2') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Tambah Pelanggan</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('pelanggan.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lihat Data Pelanggan</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                          <p>
                              Pembelian
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Tambah Produk</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lihat Data Produk</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-calculator"></i>
                          <p>
                              Pembayaran
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Tambah Produk</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lihat Data Produk</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                          <p>
                              Penjualan
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('transaksi-penjualan.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Transaksi Baru</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-cog"></i>
                          <p>
                              Setup Perusahaan
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('keuntungan') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Set Keuntungan</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('kategori.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Set Kategori</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('perusahaan.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Set Perusahaan</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('merek.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Set Merek</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('satuan.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Set Satuan</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  @else
                  <li class="nav-item">
                      <a href="{{ route('dashboard') }}" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-home"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                          <p>
                              Pembelian
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Tambah Produk</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lihat Data Produk</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-calculator"></i>
                          <p>
                              Pembayaran
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Tambah Produk</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lihat Data Produk</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                          <p>
                              Penjualan
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Tambah Produk</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lihat Data Produk</p>
                              </a>
                          </li>
                      </ul>
                  </li>


                  @endif
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>