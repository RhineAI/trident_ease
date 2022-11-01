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
                                  <p>Data Produk</p>
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
                                  <p>Data Pegawai</p>
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
                                  <p>Data Supplier</p>
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
                                  <p>Data Pelanggan</p>
                              </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{ route('list-b-pelanggan.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Pelanggan Terbaik</p>
                            </a>
                        </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                          <p>
                              Transaksi
                              <i class="right fas fa-angle-right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">                     
                          <li class="nav-item">
                              <a href="{{ route('transaksi-pembelian.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Tambah Pembelian</p>
                              </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{ route('list-pembelian.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{ route('pembayaran-pembelian.index') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p style="font-size: 13px;">Bayar Tunggakan Pembelian</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transaksi-penjualan.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('list-transaksi.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pembayaran.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p style="font-size: 13px;">Bayar Tunggakan Penjualan</p>
                            </a>
                        </li>
                      </ul>
                  </li>

                    {{-- PRODUK --}}
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
                                    <p>Data Produk</p>
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
                                    <p>Data Pegawai</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- SUPPLIER --}}
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
                                    <p>Data Supplier</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- PELANGGAN --}}
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
                                    <p>Data Pelanggan</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- TRANSAKSI --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                            <p>
                                Transaksi
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">                     
                            <li class="nav-item">
                                <a href="{{ route('transaksi-pembelian.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Transaksi Pembelian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('list-pembelian.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Pembelian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('data-hutang.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Hutang</p>
                                </a>
                            </li>
                            <hr>
                            <li class="nav-item">
                                <a href="{{ route('transaksi-penjualan.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Transaksi Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('list-transaksi.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Transaksi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('data-hutang.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data 3,14 utang</p>
                                </a>
                                {{-- π --}}
                            </li>
                        </ul>
                    </li>

                    {{-- KAS --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-money-bill-wave"></i>
                            <p>
                                Kas
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('kas-masuk.index') }}" class="nav-link">
                                    <p>Kas Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kas-keluar.index') }}" class="nav-link">
                                    <p>Kas Keluar</p>
                                </a>
                            </li>
                        </ul>
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
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('stockOpname') }}" class="nav-link">
                                    <p>Stock Opname</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('laporan-harian.index') }}" class="nav-link">
                                    <p>Laporan Harian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('laporan-kas.index') }}" class="nav-link">
                                    <p>Laporan Kas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('laporan-penjualan.index') }}" class="nav-link">
                                    <p>Laporan Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('laporan-stok.index') }}" class="nav-link">
                                    <p>Laporan Stok</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('list-b-pelanggan.index') }}" class="nav-link">
                                    <p>Laporan Pelanggan Terbaik</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- RETUR --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-rotate-left"></i>
                            <p>
                                Retur Penjualan
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('retur-penjualan.index') }}" class="nav-link">
                                    <p>Tambah Retur</p>
                                </a>
                            </li>
                            <li class="nav-item">
                            <a href="{{ route('list-retur-penjualan.index') }}" class="nav-link">
                                <p>Lihat Data Retur</p>
                            </a>
                        </li>
                        </ul>
                    </li>

                    {{-- SETUP PERUSAHAAN --}}
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
                                <a href="{{ route('perusahaan.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Set Perusahaan</p>
                                </a>
                            </li>
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

                  @elseif(auth()->user()->hak_akses == 2)

                    {{-- DASHBOARD --}}
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    {{-- TRANSAKSI --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-cart-plus"></i>
                            <p>
                                Transaksi
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">                     
                            <li class="nav-item">
                                <a href="{{ route('transaksi-penjualan.index') }}" class="nav-link">
                                    <p>Transaksi Baru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('list-transaksi.index') }}" class="nav-link">
                                    <p>Data Transaksi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pembayaran.index') }}" class="nav-link">
                                    <p>Tunggakan</p>
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