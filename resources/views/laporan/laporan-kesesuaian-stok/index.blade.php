@extends('templates.layout')

@section('title')
<title>Laporan Kesesuaian Stok | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Laporan Kesesuaian Stok
@endsection

@section('breadcrumb')
@parent
Laporan Kesesuaian Stok
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
                        <form action="{{ route('admin.laporan-kesesuaian-stok.index') }}" method="get" id="form-search">
                    @elseif(auth()->user()->hak_akses == 'owner')             
                        <form action="{{ route('owner.laporan-kesesuaian-stok.index') }}" method="get" id="form-search">
                    @endif  
                        <div class="form-group row mt-4 ml-3">
                            <label for="tanggal_awal" class="col-lg-1 control-label mr-3">Tanggal Awal</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="flatpickr form-control" required autofocus readonly value="{{ request('tanggal_awal') }}" style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>
                            
                            <h5 class="mr-5 mx-3 my-2 mt-3" for="" class="col-md-2"><small class="mr-2"><b>s/d</b></small></h5>

                            <label for="tanggal_akhir" class="col-lg-1 mr-2 control-label">Tanggal Akhir</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="flatpickr form-control" required readonly value="{{ request('tanggal_akhir') }}" style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>

                        <div class="form-group row mt-4 ml-3">
                            <label for="tanggal_awal" class="col-lg-1 control-label mr-3">Pilih Merek</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <select name="merek" id="merek" class="form-control" required>
                                    <option value="">Pilih Merek</option>
                                    @foreach ($merek as $item )
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>   
                                    @endforeach
                                </select>
                                <span class="help-block with-errors"></span>
                            </div>
                            
                            <h5 class="mr-5 mx-5 my-2 mt-3" for="" class="col-md-2"><b></b></h5>

                            <label for="tanggal_akhir" class="col-lg-1 mr-2 control-label">Pilih Kategori</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $item )
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
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
                            <a href="{{ route('admin.laporan-kesesuaian-stok.print', [$tanggalAwal, $tanggalAkhir, $merk, $category]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('admin.laporan-kesesuaian-stok.download', [$tanggalAwal, $tanggalAkhir, $merk, $category] ) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>       
                            <a class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end" data-text="Download Template" href="{{ route('admin.download.laporanStockOpname', [$tanggalAwal, $tanggalAkhir, $merk, $category]) }}" ><i class="fa fa-download"></i> Download Excel</a>        
                        @elseif(auth()->user()->hak_akses == 'owner') 
                            <a href="{{ route('owner.laporan-kesesuaian-stok.print', [$tanggalAwal, $tanggalAkhir, $merk, $category]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('owner.laporan-kesesuaian-stok.download', [$tanggalAwal, $tanggalAkhir, $merk, $category] ) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>                
                            <a class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end" data-text="Download Template" href="{{ route('owner.download.laporanStockOpname', [$tanggalAwal, $tanggalAkhir, $merk, $category]) }}" ><i class="fa fa-download"></i> Download Excel</a>        
                        @endif            
                    </div>

                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <h5 style="text-align:center;">Laporan Kesesuaian Stok {{ tanggal_indonesia($tanggalAwal, false) }}</h5>
                    <h5 style="text-align:center;" >s/d {{ tanggal_indonesia($tanggalAkhir, false) }}</h5>
                    <br>
                {{-- <a href="{{ route('admin.list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive table-kesesuaian-stok" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr class="">
                                        <th width="7%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">No</th>
                                        {{-- <th width="15%" class="text-center" style="margin:auto; text-align:center;">No</th> --}}
                                        <th width="7%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Kode</th>
                                        <th width="16%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Nama Barang</th>
                                        <th width="10%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Merek</th>
                                        <th width="12%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Kategori</th>
                                        <th width="5%" class="text-center">Stok Sistem</th>
                                        <th width="5%" class="text-center">Stok Baru</th>
                                        <th width="5%" class="text-center" style="vertical-align:middle;">Selisih</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

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
            let merek = $('#merek').val();
            let kategori = $('#kategori').val();
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

            if(merek == "") {
                Swal.fire('Isi Merek!')
                return false;
            } else {
                $('#merek').val();
            }

            if(kategori == "") {
                Swal.fire('Isi Kategori!')
                return false;
            } else {
                $('#kategori').val();
            }
            document.getElementById('form-search').submit();
        });

    let firstdate = $('.firstdate').val();
    $('#tanggalAwal').val(firstdate);

    let lastdate = $('.lastdate').val();
    $('#tanggalAkhir').val(lastdate);

    @if(auth()->user()->hak_akses == 'owner') 
        var kesesuaian = "{{ route('owner.laporan-kesesuaian-stok.data', [$tanggalAwal, $tanggalAkhir, $merk, $category]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var kesesuaian = "{{ route('admin.laporan-kesesuaian-stok.data', [$tanggalAwal, $tanggalAkhir, $merk, $category]) }}";
    @endif
   let table;
        table = $('.table-kesesuaian-stok').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: kesesuaian,
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            // {data:'tgl'},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'merek'},
            {data:'kategori'},
            {data:'stock_awal'},
            {data:'stock_baru'},
            {data:'selisih'},
        ]
    });

</script>
@endpush