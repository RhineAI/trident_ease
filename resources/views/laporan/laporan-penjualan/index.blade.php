@extends('templates.layout')

@section('title')
<title>Laporan Penjualan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Laporan Penjualan
@endsection

@section('breadcrumb')
@parent
Laporan Penjualan
@endsection

@push('styles')
@endpush

@section('contents')

<!-- Main content -->
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
                <div class="box-body table-responsive ">
                    @if (auth()->user()->hak_akses == 'admin')
                        <form action="{{ route('admin.laporan-penjualan.index') }}" method="get" id="form-search">
                    @elseif(auth()->user()->hak_akses == 'owner')             
                        <form action="{{ route('owner.laporan-penjualan.index') }}" method="get" id="form-search">
                    @endif   
                    {{-- @csrf  --}}
                        <div class="form-group row mt-4 ml-3 ">
                            <label for="tanggal_awal" class="col-lg-1 control-label mr-3">Tanggal Awal</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="flatpickr form-control" required autofocus readonly style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>
                            
                            <h5 class="mr-5 mx-3 my-2 mt-3" for="" class="col-md-2"><small><b>s/d</b></small></h5>

                            <label for="tanggal_akhir" class="col-lg-1 mr-2 control-label">Tanggal Akhir</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="flatpickr form-control" required readonly style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>

                            <div class="form-group row ml-3 mb-3 mt-3">
                                <button type="button" id="search" class="btn btn-xs btn-primary"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </form>

                    <div class="print text-center p-2 mb-1 d-flex justify-content-start" style=" border-bottom: 1px solid grey;">
                        <small style="color:gray;" class="">Print Section</small>
                        {{-- <hr style="height:2px"> --}}
                    </div>
                    
                    <div class="button-group mb-2">  
                        @if (auth()->user()->hak_akses == 'admin')
                            <a href="{{ route('admin.laporan-penjualan.print', [$tanggalAwal, $tanggalAkhir]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('admin.laporan-penjualan.download', [$tanggalAwal, $tanggalAkhir] ) }}" class="mb-3 ml-2 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>  
                            <a class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end" data-text="Download Template" href="{{ route('admin.download.laporanPenjualan', [$tanggalAwal, $tanggalAkhir]) }}" ><i class="fa fa-download"></i> Download Excel</a>        
                        @elseif(auth()->user()->hak_akses == 'owner') 
                            <a href="{{ route('owner.laporan-penjualan.print', [$tanggalAwal, $tanggalAkhir]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('owner.laporan-penjualan.download', [$tanggalAwal, $tanggalAkhir] ) }}" class="mb-3 ml-2 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>    
                            <a class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end" data-text="Download Template" href="{{ route('owner.download.laporanPenjualan', [$tanggalAwal, $tanggalAkhir]) }}" ><i class="fa fa-download"></i> Download Excel</a>              
                        @endif               
                                 
                    </div>
                {{-- <a href="{{ route('admin.list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}
                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <small style="visibility: hidden">
                        @php
                            // $awal = strtotime("-1day", strtotime($tanggalAwal));
                            // $awal = date('Ymd', strtotime($awal));
                        @endphp
                    </small>
                    <h5 style="text-align:center;">Laporan Penjualan {{ tanggal_indonesia($tanggalAwal) }}</h5>
                    <h5 style="text-align:center;" >s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>
                    <br>

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <h5 class="mb-3">Penjualan</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive table-penjualan" id="dataTableHover">
                                <thead class="table-dark">
                                    <tr>
                                        {{-- <th width="5%" class="text-center">No</th> --}}
                                        <th width="15%" class="text-center">Tanggal</th>
                                        <th width="9%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="14%" class="text-center">Omset</th>
                                        <th width="11%" class="text-center">Keuntungan</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @if ($detPenjualan != NULL)
                                        @foreach ($detPenjualan as $dp)
                                            <tr>
                                                <td class="text-center">{{ tanggal_indonesia($dp->tgl,false) }}</td>
                                                <td class="text-center"><span class="badge" style="background-color:#2f3d57; color:white;">{{ $dp->kode }}</span></td>
                                                <td class="text-center">{{ $dp->nama_barang }}</td>
                                                <td class="text-center">{{ $dp->qty }}</td>
                                                <td class="text-center" id="omset">{{ 'Rp.' . format_uang($dp->qty * $dp->harga_jual) }}</td>
                                                @if ($dp->diskon == 0)
                                                    <td class="text-center ">{{ 'Rp. ' . format_uang(($dp->harga_jual - $dp->harga_beli) * $dp->qty) }}</td>
                                                @else 
                                                    <td class="text-center" >{{ 'Rp. ' . format_uang((($dp->harga_jual - $dp->harga_beli) * $dp->qty) - ( ($dp->harga_jual - $dp->harga_beli) * $dp->qty) * $dp->diskon/100) }}</td>
                                                @endif
                                            </tr>
                                        @endforeach 
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center" style="color:grey; font-size:17px;">Tidak ada data</td>    
                                        </tr>  
                                    @endif
                                {{-- @else --}}
                                    {{-- @if ($detPenjualan != NULL)
                                        @foreach ($detPenjualan as $dp)
                                            <tr>
                                                <td class="text-center">{{ tanggal_indonesia($dp->tgl,false) }}</td>
                                                <td class="text-center"><span class="badge" style="background-color:#2f3d57; color:white;">{{ $dp->kode }}</span></td>
                                                <td class="text-center">{{ $dp->nama_barang }}</td>
                                                <td class="text-center">{{ $dp->qty }}</td>
                                                <td class="text-center" id="omset">{{ 'Rp.' . format_uang($dp->qty * $dp->harga_jual) }}</td>
                                                @if ($dp->diskon == 0)
                                                    <td class="text-center ">{{ 'Rp. ' . format_uang(($dp->harga_jual - $dp->harga_beli) * $dp->qty) }}</td>
                                                @else 
                                                    <td class="text-center" >{{ 'Rp. ' . format_uang((($dp->harga_jual - $dp->harga_beli) * $dp->qty) - ( ($dp->harga_jual - $dp->harga_beli) * $dp->qty) * $dp->diskon/100) }}</td>
                                                @endif
                                            </tr>
                                        @endforeach 
                                    @else
                                    @endif --}}
                                {{-- @endif --}}
                                        
                                </tbody> 
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="4"><b>Total</b></td>
                                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalO) }}</td>
                                        <td id="totalU" class="text-center">{{ 'Rp. '. format_uang($totalU) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- <span class="untung">10000</span> --}}
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(".flatpickr").flatpickr({
        enableTime: false,
        dateFormat: "d-m-Y",
        autoclose: true,
    });

    $('#search').on('click', function(){   
            let tanggal_awal = $('#tanggal_awal').val();
            let tanggal_akhir = $('#tanggal_akhir').val();
            if(tanggal_awal == "") {
                Swal.fire('Isi Tanggal Awal!')
                return false;
            } else {
                $('#tanggal_awal').val();
            }

            if(tanggal_akhir == "") {
                Swal.fire('Isi Tanggal Akhir!')
                return false;
            } else {
                $('#tanggal_akhir').val();
            }
            document.getElementById('form-search').submit();
        });

    // $('.table-penjualan').DataTable({
    //     searching: false,
    //     info: false,
    //     paging:false,
    //     processing:false,
    //     language: {
    //         emptyTable: "Tidak Ada Data"
    //     }
    // });


    // let get = document.getElementsByClassName('keuntungan');
    // let val = get.attr('val');
    // let val = $(this).closest('tr').find('.keuntungan').val();
    // console.log(get)
    // let value = $('.total').text();
    // console.log(value);
    // let value2 = document.querySelectorAll('#omset');
    // value2.forEach((value2) => {
    //     let value = parseInt(value2.getAttribute("data-val"));
    // });
    // console.log(val);
    // let value = value2.val() 
    // let remove = value.replaceAll(".", '').replace(/Rp/g, '');
    // let sum = value.reduce((partialSum, a) => partialSum + a, 0);
    // let sum = [1000, 2000, 3000]
    // console.log(value.reduce(reducer));

    // $('.total_omset').text(make_num);

    @if(auth()->user()->hak_akses == 'owner') 
        var penjualan = "{{ route('owner.laporan-penjualan.data', [$tanggalAwal, $tanggaltanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var penjualan = "{{ route('admin.laporan-penjualan.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif


//    let table_penjualan
//         table : $('.table-penjualan').DataTable({
//         searching: false,
//         info: false,
//         paging:false,
//         bFilter:false,
//         processing: false,
//         responsive: true,
//         autoWidth: false,
//         serverSide: true,
//         ajax: {
//             url: penjualan,
//             type: "POST",
//             data: {  
//                 _token: '{{ csrf_token() }}',
//             }
//         },
//         columns: [
//             // {data:'DT_RowIndex', searchable: false, sortable: false},
//             {data:'tgl'},
//             {data:'kode'},
//             {data:'nama_barang'},
//             {data:'qty'},
//             {data:'total_penjualan'},
//             {data:'keuntungan'},
//             // {data:'totals'},
//         ],
//     });

    // $(document).ready(function() {
    //     let value = $('span.untung').text();
    //     console.log(value);
    // })

</script>
@endpush