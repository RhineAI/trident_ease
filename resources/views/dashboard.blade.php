@extends('templates.layout')

@section('title')
    <title>Dashboard | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Dashboard
@endsection

@section('breadcrumb')
@parent
    Dashboard
@endsection

@push('styles')
    <style>
        span .text-success {
            margin-left: 30px;
            vertical-align: middle;
            -webkit-transition: all 0.2s linear;
            transition: all 0.2s linear; 
        }
    </style>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Produk Ditambahkan</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800 count" id="count" data-val="{{ $cardBarang }}">{{ $cardBarang }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                @if($todaybarang >= $cekupordownbarang) 
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>{{ $percentage_barang }}%</span>
                                    <span>Since last Added </span>
                                        {{-- (+{{ $totalBarangYesterday }}) --}}
                                @elseif($todaybarang <= $cekupordownbarang)
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i>{{ $percentage_barang }}%</span>
                                    <span>Since last Added </span>
                                    {{-- (-{{ $cekupordownbarang - $totalBarangYesterday }}) --}}
                                @else
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>{{ $percentage_barang }}%</span>
                                    <span>Since last Added</span>
                                    {{-- (+{{ $totalBarangYesterday }}) --}}
                                @endif
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Pendapatan (Bulanan)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP. {{ format_uang($penjualan) }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                @if($upordownpenghasilan >= $cekupordownpenghasilan) 
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>{{ $percentage_penghasilan }}%</span>
                                    <span>Since last Month</span>
                                @elseif($upordownpenghasilan <= $cekupordownpenghasilan)
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i>{{ $percentage_penghasilan }}%</span>
                                    <span>Since last Month</span>
                                @else
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>{{ $percentage_penghasilan }}%</span>
                                    <span>Since last Month</span>
                                @endif
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Penjualan (Hari Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 count" id="count" data-val="{{ $cardPenjualan }}">0</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                @if($upordowntransaksi >= $cekupordowntransaksi) 
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up" ></i>{{ $percentage_transaksi }}%</span>
                                    <span>Since last transaction</span>
                                     {{-- (+{{ $totalTransaksiYesterday }}) --}}
                                @elseif($upordowntransaksi <= $cekupordowntransaksi)
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i>{{ $percentage_transaksi }}%</span>
                                    <span>Since last transaction </span>
                                    {{-- (-{{ $cekupordowntransaksi - $totalTransaksiYesterday }}) --}}
                                @else
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>{{ $percentage_transaksi }}%</span>
                                    <span>Since last transaction</span>
                                     {{-- (+{{ $totalTransaksiYesterday }}) --}}
                                @endif
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Kas Masuk (Bulanan)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{ format_uang($kas) }}</div>          
                            <div class="mt-2 mb-0 text-muted text-xs">
                                @if($upordownkasmasuk >= $cekupordownkasmasuk) 
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>{{ $percentage_kas_masuk }}%</span>
                                    <span>Since last Month</span>
                                @elseif($upordownkasmasuk <= $cekupordownkasmasuk)
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i>{{ $percentage_kas_masuk }}%</span>
                                    <span>Since last Month</span>
                                @else
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>{{ $percentage_kas_masuk }}%</span>
                                    <span>Since last Month</span>
                                @endif
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
                    <h6 class="m-0 font-weight-bold text-primary">Pendapatan Bulanan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <input type="hidden" id="bulan1" value="{{ $bulan1 }}">
                        <input type="hidden" id="bulan2" value="{{ $bulan2 }}">
                        <input type="hidden" id="bulan3" value="{{ $bulan3 }}">
                        <input type="hidden" id="bulan4" value="{{ $bulan4 }}">
                        <input type="hidden" id="bulan5" value="{{ $bulan5 }}">
                        <input type="hidden" id="bulan6" value="{{ $bulan6 }}">
                        <input type="hidden" id="bulan7" value="{{ $bulan7 }}">
                        <input type="hidden" id="bulan8" value="{{ $bulan8 }}">
                        <input type="hidden" id="bulan9" value="{{ $bulan9 }}">
                        <input type="hidden" id="bulan10" value="{{ $bulan10 }}">
                        <input type="hidden" id="bulan11" value="{{ $bulan11 }}">
                        <input type="hidden" id="bulan12" value="{{ $bulan12 }}">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Level Saat Ini</h6>
                    @if ($check->grade == 1) 
                        <span class="badge badge-primary">Free</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-gray-500">Barang
                            <div class="small float-right"><b>{{ $barangHarian }} of 5 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $barangHarian*20 }}%" aria-valuenow="{{ $barangHarian }}"
                                aria-valuemin="0" aria-valuemax="5"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-gray-500">Transaksi 
                            <div class="small float-right"><b>{{ $penjualanHarian }} of 5 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $penjualanHarian*20 }}%" aria-valuenow="{{ $penjualanHarian }}"
                                aria-valuemin="0" aria-valuemax="5"></div>
                        </div>
                    </div>                    
                </div>


                    @elseif ($check->grade == 2)
                        <span class="badge" style="background-color:#81d6b0;">Intermediate</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-gray-500">Barang
                            <div class="small float-right"><b>{{ $barangHarian }} of 50 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $barangHarian*2 }}%" aria-valuenow="{{ $barangHarian }}"
                                aria-valuemin="0" aria-valuemax="50"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-gray-500">Transaksi 
                            <div class="small float-right"><b>{{ $penjualanHarian }} of 50 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $penjualanHarian*2 }}%" aria-valuenow="{{ $penjualanHarian }}"
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
                            <div class="small float-right"><b>{{ $barangHarian }} of 10000 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $barangHarian/100 }}%" aria-valuenow="{{ $barangHarian }}"
                                aria-valuemin="0" aria-valuemax="10000"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="small text-gray-500">Transaksi 
                            <div class="small float-right"><b>{{ $penjualanHarian }} of 10000 Items</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $penjualanHarian/100 }}%" aria-valuenow="{{ $penjualanHarian }}"
                                aria-valuemin="0" aria-valuemax="10000"></div>
                        </div>
                    </div>                    
                </div>
                @endif
                <div class="card-footer text-center">
                    <a class="m-0 small text-primary card-link" href="#">&nbsp</a>
                </div>
            </div>
        </div>
       
    </div>
    <!--Row-->

</section>
@endsection

@push('scripts')
    <script>
        $('body').addClass('sidebar-collapse');
    </script>
    <script src="{{ asset('assets') }}/vendor/chart.js/Chart.min.js"></script>
    <script src="{{ asset('assets') }}/js/chart-area-demo.js"></script> 
    <script>
        let valueDisplays = document.querySelectorAll('#count');
        let interval = 500;

        valueDisplays.forEach((valueDisplay) => {
            let startValue = 0;
            let endValue = parseInt(valueDisplay.getAttribute("data-val"));
            if(endValue == 0) {
                return false;
                // let duration = Math.floor(interval / 1);
            } else {
                let duration = Math.floor(interval / endValue);
                let counter = setInterval(function() {
                startValue += 1;
                valueDisplay.textContent = startValue;
                if(startValue == endValue) {
                    clearInterval(counter);
                    }
                }, duration);
            }
           
        });

        // Counter Number
        // console.log($('#count').val());
        // $('.count').each(function () {
        //     $(this).prop('Counter',0).animate({
        //         Counter: $(this).text()
        //     }, {
        //         duration: 300,
        //         easing: 'swing',
        //         step: function (now) {
        //             $(this).text(Math.ceil(now));
        //         }
        //     });
        // });
    </script>
  
@endpush