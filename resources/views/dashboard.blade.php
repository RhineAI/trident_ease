@extends('templates.layout')

@section('title')
    <title>Dashboard | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Dashboard
@endsection

@section('breadcrumb')
@parent
    Pemasok
@endsection

@push('styles')
    
@endpush
@section('contents')
    
<!-- Main content -->
<section class="content">
    <div class="row mb-3">
        <!-- New User Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-80">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Product Added</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $cardBarang }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> {{ $percentage_barang }}%</span>
                                <span>Since last Day (+{{ $totalBarangYesterday }})</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-80">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Earnings (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.{{ format_uang($penjualan) }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span>Since last month</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-80">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Sales</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_penjualan }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                                <span>Since last years</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-80">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Kas Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.{{ format_uang($kas) }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                <span>Since yesterday</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sharp fa-money-bill-1-wave fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Recap Report</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Level Now</h6>
                    @if ($check->grade == 1) 
                        <span class="badge badge-primary">Free</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-gray-500">Barang
                            <div class="small float-right"><b>{{ $cardBarang }} of 10 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $barang }}%" aria-valuenow="{{ $barang }}"
                                aria-valuemin="{{ $barang }}" aria-valuemax="10"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-gray-500">Transaksi 
                            <div class="small float-right"><b>{{ $total_penjualan }} of 10 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $total_penjualan }}%" aria-valuenow="{{ $total_penjualan }}"
                                aria-valuemin="0" aria-valuemax="10"></div>
                        </div>
                    </div>                    
                </div>


                    @elseif ($check->grade == 2)
                        <span class="badge badge-info">Intermediate</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-gray-500">Barang
                            <div class="small float-right"><b>{{ $cardBarang }} of 50 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $barang }}%" aria-valuenow="{{ $barang }}"
                                aria-valuemin="0" aria-valuemax="50"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-gray-500">Transaksi 
                            <div class="small float-right"><b>{{ $total_penjualan }} of 50 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $total_penjualan }}%" aria-valuenow="{{ $total_penjualan }}"
                                aria-valuemin="0" aria-valuemax="50"></div>
                        </div>
                    </div>                    
                </div>

                        
                    @elseif ($check->grade == 3)
                        <span class="badge badge-danger">Premium</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-gray-500">Barang
                            <div class="small float-right"><b>{{ $cardBarang }} of 1000 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $barang }}%" aria-valuenow="{{ $barang }}"
                                aria-valuemin="0" aria-valuemax="1000"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-gray-500">Transaksi 
                            <div class="small float-right"><b>{{ $total_penjualan }} of 1000 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $total_penjualan }}%" aria-valuenow="{{ $total_penjualan }}"
                                aria-valuemin="0" aria-valuemax="1000"></div>
                        </div>
                    </div>                    
                </div>
                @endif
                <div class="card-footer text-center">
                    <a class="m-0 small text-primary card-link" href="#">View More <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
       
    </div>
    <!--Row-->

    <div class="row">
        <div class="col-lg-12 text-center">
            <p>Do you like this template ? you can download from <a href="https://github.com/indrijunanda/RuangAdmin"
                    class="btn btn-primary btn-sm" target="_blank"><i class="fab fa-fw fa-github"></i>&nbsp;GitHub</a></p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        $('body').addClass('sidebar-collapse');
    </script>
@endpush