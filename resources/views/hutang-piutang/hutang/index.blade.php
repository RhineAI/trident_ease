@extends('templates.layout')

@section('title')
    <title>Data Hutang | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Data Hutang
@endsection

@section('breadcrumb')
@parent
    Data Hutang
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
                    <div class="col-lg-12 table-responsive">
                        <div class="button-group mb-5">          
                            @if (auth()->user()->hak_akses == 'admin')
                                <a href="{{ route('admin.transaksi-pembelian.index') }}" class="mx-4 mb-3 btn btn-sm btn-info text-end"><i class="fa fa-plus"></i> Transaksi Pembelian</a>
                            @endif
                        </div>
                        <div class="table-responsive dt-responsive p-3">
                            <table class="table table-hover table-responsive dt-responsive table-flush" style="width: 100%z" id="tbl-data-pembayaran">
                                <thead class="table-secondary">
                                    <tr>
                                        {{-- <td>No</td> --}}
                                        <td class="text-center" style="vertical-align: middle;" width="6%">No Penjualan</td>
                                        <td class="text-center" style="vertical-align: middle;" width="6%">Tanggal</td>
                                        <td class="text-center" style="vertical-align: middle;" width="10%">Pelanggan</td>
                                        <td class="text-center" style="vertical-align: middle;" width="15%">Total Beli</td>
                                        <td class="text-center" style="vertical-align: middle;" width="15%">Dibayar</td>
                                        <td class="text-center" style="vertical-align: middle;" width="15%">Sisa</td>
                                        <td class="text-center" style="vertical-align: middle;" width="8%">Status</td>
                                        <td class="text-center" style="vertical-align: middle;" width="7%">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <small style="display: none; visibility:hidden;">{{ $terbayar = 0 }}</small>
                                    @foreach ($pembayaran as $item)
                                        <tr>
                                            {{-- <td>{{ $i = (isset($i)?++$i:$i=1) }}</td> --}}
                                            <td class="text-center"><span class="badge badge-info">{{ $item->id_pembelian }}</span></td>
                                            <td>{{ $item->tgl }}</td>
                                            <td class="text-center">{{ $item->nama_supplier }}</td>
                                            <td>{{ 'Rp. '. format_uang($item->total_pembelian) }}</td>
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
                                                    data-id_pembelian="{{ $item->id_pembelian }}" 
                                                    data-tgl="{{ $cDate }}" 
                                                    data-nama_supplier="{{ $item->nama_supplier }}" 
                                                    data-id_supplier="{{ $item->id_supplier }}" 
                                                    data-tlp="{{ $item->tlp }}" 
                                                    data-total_bayar="{{ 'Rp. '. format_uang($jumlahTerbayar) }}" 
                                                    data-total_pembelian="{{ 'Rp. '. format_uang($item->total_pembelian) }}" 
                                                    data-dp="{{ $item->dp }}" 
                                                    data-sisa="{{ 'Rp. '.format_uang($item->sisa) }}" 
                                                    data-route="{{ route('admin.data-hutang.store')}}"
                                                    data-toggle="modal" data-target="#formModalPembayaranPBL" data-mode="edit"> <i class="fa fa-pencil"></i>
                                                    </button>
                                                @else 
                                                    <a href="{{ route('admin.data-hutang.print_nota', $item->id) }}" class="btn btn-xs btn-secondary rounded delete"><i class="fa-solid fa-print"></i></a>
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
    @include('hutang-piutang.hutang.formBayar')
@endsection

@push('scripts') 
<script>
    // var getSisa = $("#sisa").val();
    // var sisa = Math.ceil(parseInt(getSisa));
    // console.log(getSisa)
    $(document).on('keyup', '#bayar', function(e) {
        var tb = String($(this).val()).replaceAll(".", '');
        var sisa = String($("#sisaStatis").val()).replace(/Rp/g, '').replaceAll(".", '');
        // let dp = String($("#dp").val()).replace(/Rp/g, '').replaceAll(".", '');
        
        // let dp = getDp.replace(/Rp/g, '').replace('.', '');
        // let total_harga = $('#total_harga').val()
        // let total_harga = getTotal_harga.replace(/Rp/g, '').replaceAll('.', '');

        sisa = parseInt(sisa-tb)
        sisa_makerp = Number(sisa).toLocaleString("id-ID", {
                                style:"currency",
                                currency:"IDR",
                                maximumSignificantDigits: (sisa + '').replace('.', '').length
                            });
        
        if (sisa > 0) {
            $('#sisa').val(sisa_makerp)
        } else {
            $('#sisa').val('Lunas')
            $('#kolom_kembalian').removeAttr('style')
            $('#kembalian').val(String(sisa_makerp).replaceAll('-', ''))
        }

       
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
            let id_pembelian = $(this).data('id_pembelian')
            let id_supplier = $(this).data('id_supplier')
            let nama_supplier = $(this).data('nama_supplier')
            let tgl = $(this).data('tgl')
            let tlp = $(this).data('tlp')
            let jumlahTerbayar = $(this).data('total_bayar')
            let total_pembelian = $(this).data('total_pembelian')
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
            $('.modal-body #id_pembelian').val(id_pembelian)
            $('.modal-body #nama_supplier').val(nama_supplier)
            $('.modal-body #tlp').val(tlp)
            $('.modal-body #total_pembelian').val(total_pembelian)
            $('.modal-body #jumlahTerbayar').val(jumlahTerbayar)
            // console.log(sisa)
            $('.modal-body #sisa').val(sisa)
            $('.modal-body #sisaStatis').val(sisa)
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
