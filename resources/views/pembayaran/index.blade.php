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
        <div class="box-body table-responsive">
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
                            <button type="button" class="btn btn-info add_barang" 
                                data-id_penjualan="{{ $item->id }}" 
                                data-tgl="{{ $item->tgl }}" 
                                data-nama_pelanggan="{{ $item->nama_pelanggan }}" 
                                data-total_harga="{{ $item->total_harga }}" 
                                data-dp="{{ $item->dp }}" 
                                data-sisa="{{ $item->sisa }}" 
                                data-dismiss="modal"> <i class="fa fa-plus"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
  
        @include('pembayaran.formBarang')
        {{-- @include('pembayaran.formSupplier') --}}
      </section>
      <!-- /.content -->
@endsection

@push('scripts') 
@endpush
