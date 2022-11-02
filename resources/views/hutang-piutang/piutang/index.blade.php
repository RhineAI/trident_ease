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
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table table-striped table-bordered dt-responsive" style="width: 100%;" id="tbl-data-pembayaran">
                                <thead>
                                    <tr>
                                        <td class="text-center" width="4%">No</td>
                                        <td class="text-center" width="9%">No Penjualan</td>
                                        <td class="text-center" width="8%">Tanggal</td>
                                        <td class="text-center" width="4%">Pelanggan</td>
                                        <td class="text-center" width="9%">Total Pembayaran</td>
                                        <td class="text-center" width="8%">DP</td>
                                        <td class="text-center" width="8%">Sisa</td>
                                        <td class="text-center" width="8%">Status</td>
                                        <td class="text-center" width="2%">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembayaran as $item)
                                        <tr>
                                            <td class="text-center">{{ $i = (isset($i)?++$i:$i=1) }}</td>
                                            <td><span class="badge badge-info">{{ $item->id_penjualan }}</span></td> 
                                            <td>{{ $item->tgl }}</td>
                                            <td>{{ $item->nama_pelanggan }}</td>
                                            <td>{{ 'Rp. '. format_uang($item->total_bayar) }}</td>
                                            <td>{{ $item->dp }}</td>
                                            <td>{{ $item->sisa  }}</td>
                                            <td>
                                                @if ($item->sisa <= 0)
                                                    <span class="badge badge-success">Lunas</span>
                                                @else
                                                    <span class="badge badge-danger">Belum Lunas</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->sisa > 0 && $item->jenis_pembayaran === 2)
                                                    <button type="button" class="btn btn-info edit_pembayaran" 
                                                    data-id_penjualan="{{ $item->id_penjualan }}" 
                                                    data-tgl="{{ $cDate }}" 
                                                    data-nama_pelanggan="{{ $item->nama_pelanggan }}" 
                                                    data-id_pelanggan="{{ $item->id_pelanggan }}" 
                                                    data-tlp="{{ $item->tlp }}" 
                                                    data-total_harga="{{ $item->total_harga }}" 
                                                    data-dp="{{ $item->dp }}" 
                                                    data-sisa="{{ $item->sisa }}" 
                                                    data-route="{{ route('pembayaran.store')}}"
                                                    data-toggle="modal" data-target="#formModalPelanggan" data-mode="edit"> <i class="fa fa-pencil"></i>
                                                    </button>
                                                @else 
                                                    <button type="button" class="btn btn-danger"><i class="fa-solid fa-print"></i></button>
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
        var tb = $(this).val();
        var sisa = $("#sisa").val();
        var dp = $("#dp").val();
        console.log(sisa, tb, sisa-tb)
        var total_harga = $('#total_harga').val()
        // var harga = String(dp).replaceAll(".", '');
        // console.log(harga)
        // tanpa memakai sisa dari table penjualan
        // $('#kembalian').val(tb-(total_harga - dp));
        // $('#sisa').val((total_harga - dp)-tb)
        $('#kembalian').val(tb-sisa);
        $('#sisa').val(sisa-tb)
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
            console.log($('#tgl').val());
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
                
                $('#modal-title').text("Edit Data Pembayaran")
                $('.modal-body #tgl').val(today)
                $('.modal-body #id_penjualan').val(id_penjualan)
                $('.modal-body #nama_pelanggan').val(nama_pelanggan)
                $('.modal-body #tlp').val(tlp)
                $('.modal-body #total_harga').val(total_harga)
                $('.modal-body #dp').val(dp)
                $('.modal-body #sisa').val(sisa)
        });
    });
</script>
<script>
    $('#tbl-data-pembayaran').DataTable();
</script>
    
@endpush
