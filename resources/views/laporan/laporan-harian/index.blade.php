@extends('templates.layout')

@section('title')
<title>Laporan Harian | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Laporan Harian
@endsection

@section('breadcrumb')
@parent
Laporan Harian
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
                        <form action="{{ route('admin.laporan-harian.index') }}" method="get" id="form-search">
                    @elseif(auth()->user()->hak_akses == 'owner') 
                        <form action="{{ route('owner.laporan-harian.index') }}" method="get" id="form-search">
                    @endif  
                        <div class="form-group row mt-4 ml-3 ">
                            <label for="tanggal_awal" class="col-lg-1 control-label mr-3">Tanggal Awal</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="flatpickr form-control" required autofocus readonly value="{{ request('tanggal_awal') }}" style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>
                            
                            <h5 class="mr-5 mx-3 my-2 mt-3" for="" class="col-md-2"><b>s/d</b></h5>

                            <label for="tanggal_akhir" class="col-lg-1 mr-2 control-label">Tanggal Akhir</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="flatpickr form-control" required readonly value="{{ request('tanggal_akhir') }}" style="border-radius: 0 !important;">
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
                            <a href="{{ route('admin.laporan-harian.print', [$tanggalAwal, $tanggalAkhir]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('admin.laporan-harian.download', [$tanggalAwal, $tanggalAkhir] ) }}" class="mb-3 ml-2 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>    
                            <a class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end" data-text="Download Template" href="{{ route('admin.download.laporanHarian', [$tanggalAwal, $tanggalAkhir]) }}" ><i class="fa fa-download"></i> Download Excel</a>        
                        @elseif(auth()->user()->hak_akses == 'owner') 
                            <a href="{{ route('owner.laporan-harian.print', [$tanggalAwal, $tanggalAkhir]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('owner.laporan-harian.download', [$tanggalAwal, $tanggalAkhir] ) }}" class="mb-3 ml-2 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>           
                            <a class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end" data-text="Download Template" href="{{ route('owner.download.laporanHarian', [$tanggalAwal, $tanggalAkhir]) }}" ><i class="fa fa-download"></i> Download Excel</a>        
                        @endif          
                    </div>
                {{-- <a href="{{ route('list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}
                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <h5 style="text-align:center;">Laporan Harian {{ tanggal_indonesia($tanggalAwal) }}</h5>
                    <h5 style="text-align:center;" >s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>
                    <br>
                {{-- <a href="{{ route('list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-2">
                            <h5 class="mb-3">Penjualan Barang</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive table-penjualan" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="15%" class="text-center">Tanggal</th>
                                        <th width="9%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="14%" class="text-center">Omset</th>
                                        <th width="11%" class="text-center">Keuntungan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="5"><b>Total Penjualan</b></td>
                                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalO) }}</td>
                                        <td id="totalU" class="text-center">{{ 'Rp. '. format_uang($totalU) }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <h5 class="mt-4 mb-3">Pembelian Barang</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive table-pembelian" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="15%" class="text-center">Tanggal</th>
                                        <th width="8%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="17%" class="text-center">Total Pembelian</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="5"><b>Total Pembelian</b></td>
                                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalBeli) }}</td>
                                        
                                    </tr>
                                </tfoot>
                            </table>

                            <h5 class="mt-4 mb-3">Retur Penjualan</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive table-retur-penjualan" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="10.5%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="13%" class="text-center">Total Retur</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="4"><b>Total Retur Penjualan</b></td>
                                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalReturPenjualan) }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <h5 class="mt-4 mb-3">Retur Pembelian</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive table-retur-pembelian" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="10.5%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="13%" class="text-center">Total Retur</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="4"><b>Total Retur Pembelian</b></td>
                                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalReturPembelian) }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <h5 class="mt-4 mb-3">Hutang</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive table-hutang" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="6%" class="text-center">Invoice</th>
                                        <th width="11%" class="text-center">Tanggal</th>
                                        <th width="16%" class="text-center">Nama Supplier</th>
                                        <th width="9%" class="text-center">Status</th>
                                        <th width="13%" class="text-center">Total Dibayar</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="5"><b>Total Hutang</b></td>
                                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalHutang) }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <h5 class="mt-4 mb-3">Piutang</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive table-piutang" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="6%" class="text-center">Invoice</th>
                                        <th width="11%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Nama Pelanggan</th>
                                        <th width="9%" class="text-center">Status</th>
                                        <th width="13%" class="text-center">Total Dibayar</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="5"><b>Total Piutang</b></td>
                                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalPiutang) }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <h5 class="mt-4 mb-3">Kas Masuk</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive table-kas-masuk" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="13%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Keterangan</th>
                                        <th width="14%" class="text-center">Oleh</th>
                                        <th width="14%" class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="4"><b>Total Kas Masuk</b></td>
                                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalKasMasuk) }}</td> 
                                    </tr>
                                </tfoot>
                            </table>

                            <h5 class="mt-4 mb-3">Kas Keluar</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive table-kas-keluar" id="dataTableHover">
                                <thead class="table-info">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="13%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Keperluan</th>
                                        <th width="14%" class="text-center">Oleh</th>
                                        <th width="14%" class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="4"><b>Total Kas Keluar</b></td>
                                        <td id="totalO" class="text-center">{{ 'Rp. '. format_uang($totalKasKeluar) }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <span style="visibility: hidden" class="url-penjualan-admin">
        {{ route('admin.laporan-penjualan.data', [$tanggalAwal, $tanggalAkhir]) }}
    </span>
    <span style="visibility: hidden" class="url-penjualan-owner">
        {{ route('owner.laporan-penjualan.data', [$tanggalAwal, $tanggalAkhir]) }}
    </span> --}}
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

    @if(auth()->user()->hak_akses == 'owner') 
        var penjualan = "{{ route('owner.laporan-penjualan.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var penjualan = "{{ route('admin.laporan-penjualan.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif
    let table_penjualan;
        table = $('.table-penjualan').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: penjualan,
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'qty'},
            {data:'total_penjualan'},
            {data:'keuntungan'},
        ]
    });

    @if(auth()->user()->hak_akses == 'owner') 
        var pembelian = "{{ route('owner.laporan-pembelian.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var pembelian = "{{ route('admin.laporan-pembelian.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif
    let table_pembelian;
        table = $('.table-pembelian').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: pembelian,
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'qty'},
            {data:'total_pembelian'},
        ]
    });


    @if(auth()->user()->hak_akses == 'owner') 
        var retur_penjualan = "{{ route('owner.laporan-retur-penjualan.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var retur_penjualan = "{{ route('admin.laporan-retur-penjualan.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif
    let table_retur_penjualan;
        table = $('.table-retur-penjualan').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: retur_penjualan,
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'qty'},
            {data:'total_retur'},
        ]
    });

    @if(auth()->user()->hak_akses == 'owner') 
        var retur_pembelian = "{{ route('owner.laporan-retur-pembelian.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var retur_pembelian = "{{ route('admin.laporan-retur-pembelian.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif
    let table_retur_pembelian;
        table = $('.table-retur-pembelian').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: retur_pembelian,
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'qty'},
            {data:'total_retur'},
        ]
    }); 



    @if(auth()->user()->hak_akses == 'owner') 
        var hutang = "{{ route('owner.laporan-hutang.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var hutang = "{{ route('admin.laporan-hutang.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif
    let table_hutang;
        table = $('.table-hutang').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: hutang,
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'no_pembelian'},
            {data:'tgl'},
            {data:'nama_supplier'},
            {data:'status'},
            {data:'total_bayar'},
        ]
    });


    @if(auth()->user()->hak_akses == 'owner') 
        var piutang = "{{ route('owner.laporan-piutang.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var piutang = "{{ route('admin.laporan-piutang.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif
    let table_piutang;
        table = $('.table-piutang').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: piutang,
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'no_penjualan'},
            {data:'tgl'},
            {data:'nama_pelanggan'},
            {data:'status'},
            {data:'total_bayar'},
        ]
    });




    @if(auth()->user()->hak_akses == 'owner') 
        var kas_masuk = "{{ route('owner.laporan-kas-masuk.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var kas_masuk = "{{ route('admin.laporan-kas-masuk.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif
    let table_kas_masuk;
        table = $('.table-kas-masuk').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: kas_masuk,
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'keterangan'},
            {data:'oleh'},
            {data:'jumlah'},
        ]
    });


    @if(auth()->user()->hak_akses == 'owner') 
        var kas_keluar = "{{ route('owner.laporan-kas-keluar.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var kas_keluar = "{{ route('admin.laporan-kas-keluar.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif
    let table_kas_keluar;
        table = $('.table-kas-keluar').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: kas_keluar,
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'keperluan'},
            {data:'oleh'},
            {data:'jumlah'},
        ]
    });

</script>
@endpush