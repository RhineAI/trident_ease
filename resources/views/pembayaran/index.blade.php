@extends('templates.layout')

@section('title')
    <title>Pembayaran | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Pembayaran
@endsection

@section('breadcrumb')
@parent
    Pembayaran
@endsection

@push('styles')
<style>
    .tampil-bayar {
        font-size: 3em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        color: white;
        background: #615d5d;
    }

    .table-pembelian tbody tr:last-child {
        display: none;
    }

    .btn-simpan {
        float: right;
        margin-top: 10px;
        margin-right: 30px;
        margin-bottom: 40px;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush

@section('contents')
  
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Tunggakan</h3>
  
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="box-body table-responsive" style="background-color: white;">
                <table class="table table-striped table-bordered" id="tbl-data-pembayaran">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>No Penjualan</td>
                            <td>Tanggal</td>
                            <td>Pelanggan</td>
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
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->tgl }}</td>
                                <td>{{ $item->nama_pelanggan }}</td>
                                <td>{{ $item->total_harga }}</td>
                                <td>{{ $item->dp }}</td>
                                <td>{{ $item->sisa }}</td>
                                <td>
                                    <button type="button" class="btn btn-info edit_pembayaran" 
                                        data-id_penjualan="{{ $item->id }}" 
                                        data-tgl="{{ $cDate }}" 
                                        data-nama_pelanggan="{{ $item->nama_pelanggan }}" 
                                        data-id_pelanggan="{{ $item->id_pelanggan }}" 
                                        data-tlp="{{ $item->tlp }}" 
                                        data-total_harga="{{ $item->total_harga }}" 
                                        data-dp="{{ $item->dp }}" 
                                        data-sisa="{{ $item->sisa }}" 
                                        data-route="{{ route('pembayaran.update', $item->id_pembayaran)}}"
                                        data-toggle="modal" data-target="#formModalPelanggan" data-mode="edit"> <i class="fa fa-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card --> 
        @include('pembayaran.formBayar')
  
      </section>
      <!-- /.content -->
@endsection

@push('scripts') 
<script>
    $(document).on('keyup', '#bayar', function(e) {
        var tb = $(this).val();
        var sisa = $("#sisa").val();
        var dp = $("#dp").val();
        var total_harga = $('#total_harga').val()
        // var harga = String(dp).replaceAll(".", '');
        // console.log(harga)
        $('#kembalian').val(tb-(total_harga - dp));
        $('#sisa').val((total_harga - dp)-tb)
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
    // $('#tbl-data-pembayaran').DataTable();
</script>
    
@endpush