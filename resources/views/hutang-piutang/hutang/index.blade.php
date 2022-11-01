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
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table table-striped table-bordered" id="tbl-data-pembayaran">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>No Pembelian</td>
                                        <td>Tanggal</td>
                                        <td>Supplier</td>
                                        <td>Total Bayar</td>
                                        <td>DP</td>
                                        <td>Sisa</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembayaran as $item)
                                        <tr>
                                            <td>{{ $i = (isset($i)?++$i:$i=1) }}</td>
                                            <td><span class="badge badge-info">{{ $item->id_pembelian }}</span></td>
                                            <td>{{ $item->tgl }}</td>
                                            <td>{{ $item->nama_supplier }}</td>
                                            <td>{{ $item->total_bayar }}</td>
                                            <td>{{ $item->dp }}</td>
                                            <td>{{ $item->sisa  }}</td>
                                            <td>
                                                @if ($item->sisa > 0 && $item->jenis_pembayaran === 2)
                                                    <button type="button" class="btn btn-info edit_pembayaran" 
                                                    data-id_pembelian="{{ $item->id_pembelian }}" 
                                                    data-tgl="{{ $cDate }}" 
                                                    data-nama_supplier="{{ $item->nama_supplier }}" 
                                                    data-id_supplier="{{ $item->id_supplier }}" 
                                                    data-tlp="{{ $item->tlp }}" 
                                                    data-total_bayar="{{ $item->total_bayar }}" 
                                                    data-dp="{{ $item->dp }}" 
                                                    data-sisa="{{ $item->sisa }}" 
                                                    data-route="{{ route('pembayaran-pembelian.store')}}"
                                                    data-toggle="modal" data-target="#formModalPembayaranPBL" data-mode="edit"> <i class="fa fa-pencil"></i>
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
    @include('hutang-piutang.hutang.formBayar')
@endsection

@push('scripts') 
<script>
    $(document).on('change', '#bayar', function(e) {
        var tb = $(this).val();
        var sisa = $("#sisa").val();
        var dp = $("#dp").val();
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
                let id_pembelian = $(this).data('id_pembelian')
                let id_supplier = $(this).data('id_supplier')
                let nama_supplier = $(this).data('nama_supplier')
                let tgl = $(this).data('tgl')
                let tlp = $(this).data('tlp')
                let total_bayar = $(this).data('total_bayar')
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
                $('.modal-body #id_pembelian').val(id_pembelian)
                $('.modal-body #nama_supplier').val(nama_supplier)
                $('.modal-body #tlp').val(tlp)
                $('.modal-body #total_pembelian').val(total_pembelian)
                $('.modal-body #dp').val(dp)
                $('.modal-body #sisa').val(sisa)
        });
    });
</script>
<script>
    $('#tbl-data-pembayaran').DataTable();
</script>
    
@endpush
