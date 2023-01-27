@extends('templates.layout')

@section('title')
    <title>Data Piutang | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Data Piutang
@endsection

@section('breadcrumb')
@parent
    Data Piutang
@endsection

@push('styles')

@endpush

@section('contents')
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
                <div class="box-body table-responsive ">
                    <!-- DataTable with Hover -->
                    <div class="button-group mb-5">          
                        @if (auth()->user()->hak_akses == 'admin')
                            <a href="{{ route('admin.transaksi-penjualan.index') }}" class="mx-4 mb-3 btn btn-sm btn-info text-end"><i class="fa fa-plus"></i> Transaksi Penjualan</a>
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table table-hover dt-responsive" style="width: 100%;" id="tbl-data-pembayaran">
                                <thead class="table-secondary">
                                    <tr>
                                        {{-- <td class="text-center" style="vertical-align: middle;" width="4%">No</td> --}}
                                        <td class="text-center" style="vertical-align: middle;" width="6%">No Penjualan</td>
                                        <td class="text-center" style="vertical-align: middle;" width="6%">Tanggal</td>
                                        <td class="text-center" style="vertical-align: middle;" width="5%">Pelanggan</td>
                                        <td class="text-center" style="vertical-align: middle;" width="10%">Total Harga</td>
                                        <td class="text-center" style="vertical-align: middle;" width="10%">Dibayar</td>
                                        <td class="text-center" style="vertical-align: middle;" width="10%">Sisa</td>
                                        <td class="text-center" style="vertical-align: middle;" width="8%">Status</td>
                                        <td class="text-center" style="vertical-align: middle;" width="1%">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembayaran as $item)
                                        <tr>
                                            {{-- <td class="text-center">{{ $i = (isset($i)?++$i:$i=1) }}</td> --}}
                                            <td><span class="badge badge-info">{{ $item->id_penjualan }}</span></td> 
                                            <td>{{ $item->tgl }}</td>
                                            <td class="text-center">{{ $item->nama_pelanggan }}</td>
                                            <td>{{ 'Rp. '. format_uang($item->total_harga) }}</td>
                                            <td>{{ 'Rp. '. format_uang($item->total_bayar) }}</td>
                                            <td>{{ 'Rp. '. format_uang($item->sisa)  }}</td>
                                            <td class="text-center">
                                                @if ($item->sisa <= 0)
                                                    <span class="badge badge-success">Lunas</span>
                                                @else
                                                    <span class="badge badge-danger">Belum Lunas</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->sisa > 0 && $item->jenis_pembayaran === 2)
                                                    <button type="button" class="btn btn-info edit_pembayaran" 
                                                    data-id_penjualan="{{ $item->id_penjualan }}" 
                                                    data-tgl="{{ $cDate }}" 
                                                    data-nama_pelanggan="{{ $item->nama_pelanggan }}" 
                                                    data-id_pelanggan="{{ $item->id_pelanggan }}" 
                                                    data-tlp="{{ $item->tlp }}" 
                                                    data-total_harga="{{ 'Rp. '. format_uang($item->total_harga) }}" 
                                                    data-dp="{{ 'Rp. '. format_uang($item->dp) }}" 
                                                    data-sisa="{{ 'Rp. '. format_uang($item->sisa) }}" 
                                                    @if (auth()->user()->hak_akses == 'admin')
                                                        data-route="{{ route('admin.data-piutang.store')}}"
                                                    @elseif(auth()->user()->hak_akses == 'kasir')
                                                        data-route="{{ route('kasir.data-piutang.store')}}"
                                                    @endif
                                                    data-toggle="modal" data-target="#formModalPelanggan" data-mode="edit"> <i class="fa fa-pencil"></i>
                                                    </button>
                                                @else 
                                                    @if (auth()->user()->hak_akses == 'admin')
                                                        <a href="{{ route('admin.data-piutang.print_nota', $item->id) }}" class="btn btn-xs btn-secondary rounded delete"><i class="fa-solid fa-print"></i></a>
                                                    @elseif(auth()->user()->hak_akses == 'kasir')
                                                        <a href="{{ route('kasir.data-piutang.print_nota', $item->id) }}" class="btn btn-xs btn-secondary rounded delete"><i class="fa-solid fa-print"></i></a>
                                                    @endif
                                                @endif
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
    @include('hutang-piutang.piutang.formBayar')    
@endsection

@push('scripts') 
<script>
    $(document).on('change', '#bayar', function(e) {
        var tb = String($(this).val()).replaceAll(".", '');
        var sisa = String($("#sisa").val()).replaceAll(".", '').replace(/Rp /g, '');
        console.log(tb)
        console.log(sisa)
        var dp = $("#dp").val();
        // console.log(sisa, tb, sisa-tb)
        var total_harga = $('#total_harga').val()
        // var harga = String(dp).replaceAll(".", '');
        // console.log(harga)
        // tanpa memakai sisa dari table penjualan
        // $('#kembalian').val(tb-(total_harga - dp));
        // $('#sisa').val((total_harga - dp)-tb)
        $('#kembalian').val(parseInt(tb)-parseInt(sisa));
        $('#sisa').val(parseInt(sisa)-parseInt(tb))
    })

    $(document).ready(function(){
        $(document).on('click','.edit_pembayaran',function(){
            $('#formModalBayar').modal('show');
            // $('#tbl-data-bayar').DataTable();
        });

        // $(document).on('click','.add_pembayaran',function(){
        //     $('#formModalBayar').modal('hide');
             // $('#tbl-data-bayar').DataTable();
        // });
        $(document).on('change', '#tgl', function(){
            // console.log($('#tgl').val());
        })

        let nama_pelanggan = $(this).data('nama_pelanggan')
        $(document).on('click', '.edit_pembayaran', function (e) {
                let id_penjualan = $(this).data('id_penjualan')
                let id_pelanggan = $(this).data('id_pelanggan')
                let nama_pelanggan = $(this).data('nama_pelanggan')
                let tgl = $(this).data('tgl')
                let tlp = $(this).data('tlp')
                let total_harga = $(this).data('total_harga')
                let dp = $(this).data('dp')
                let sisa = $(this).data('sisa')
                let url = $(this).data('route')
                var now = new Date();
                var day = ("0" + now.getDate()).slice(-2)
                var month = ("0" + (now.getMonth() + 1)).slice(-2)
                var today = now.getFullYear()+"-"+(month)+"-"+(day) 

                $('.modal-footer #btn-submit').text('Update')
                $('.modal-body form')[0].reset();
                $('.modal-body form').attr('action', url);
                
                $('#modal-title').text("Form Pembayaran")
                $('.modal-body #tgl').val(today)
                $('.modal-body #id_penjualan').val(id_penjualan)
                $('.modal-body #nama_pelanggan').val(nama_pelanggan)
                $('.modal-body #tlp').val(tlp)
                $('.modal-body #total_harga').val(total_harga)
                $('.modal-body #dp').val(dp)
                console.log(sisa)
                $('.modal-body #sisa').val(sisa)
        });
    });

    function formatRupiah(angka, prefix){
        var number_string   = angka.replace(/[^,\d]/g, '').toString(),
            split               = number_string.split(','),
            sisa                = split[0].length % 3,
            rupiah              = split[0].substr(0, sisa),
            ribuan              = split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }

    function generateRupiah(elemValue) {
        return $(elemValue).val(formatRupiah($(elemValue).val(), 'Rp. '))
    }

    $(document).on('keyup', '#bayar', function(e){
        generateRupiah(this);
    })
</script>
<script>
    $('#tbl-data-pembayaran').DataTable({
        order: [[7, 'desc']]
    });
</script>
    
@endpush
