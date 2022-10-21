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
                                        data-tgl="{{ $item->tgl }}" 
                                        data-nama_pelanggan="{{ $item->nama_pelanggan }}" 
                                        data-tlp="{{ $item->tlp }}" 
                                        data-total_harga="{{ $item->total_harga }}" 
                                        data-dp="{{ $item->dp }}" 
                                        data-sisa="{{ $item->sisa }}" 
                                        data-dismiss="modal"> <i class="fa fa-pencil"></i>
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
    $(document).ready(function(){
        $(document).on('click','.edit_pembayaran',function(){
            $('#formModalBayar').modal('show');
            // $('#tbl-data-bayar').DataTable();
        });

        $(document).on('click','.add_pembayaran',function(){
            $('#formModalBayar').modal('hide');
            // $('#tbl-data-bayar').DataTable();
        });

        $('#formModalBayar').on("show.bs.modal", function(e){
                const btn = $(e.relatedTarget)
                const id_penjualan = btn.data('id_penjualan')
                const tgl = btn.data('tgl')
                const nama_pelanggan = btn.data('nama_pelanggan')
                const tlp = btn.data('tlp')
                const total_harga = btn.data('total_harga')
                const dp = btn.data('dp')
                const sisa = btn.data('sisa')
                const mode = btn.data('mode')
                const modal = $(this)

                modal.find('#modal-title').text("Edit Data Pembayaran")
                modal.find('.modal-body #tgl').val(tgl)
                modal.find('.modal-body #id_penjualan').val(id_penjualan)
                modal.find('.modal-body #nama_pelanggan').val(nama_pelanggan)
                modal.find('.modal-body #tlp').val(tlp)
                modal.find('.modal-body #total_harga').val(total_harga)
                modal.find('.modal-body #dp').val(dp)
                modal.find('.modal-body #sisa').val(sisa)
                modal.find('.modal-footer #btn-submit').text('Update')
                modal.find('.modal-body form').attr('action', '/pembayaran/' + id_penjualan)
                modal.find('.modal-body #method').html('{{ method_field('PATCH') }}')
        });
    });
</script>
<script>
    // $('#tbl-data-pembayaran').DataTable();
</script>
    
@endpush
