@extends('templates.layout')

@section('title')
    <title>Pembelian | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Pembelian
@endsection

@section('breadcrumb')
@parent
    Pembelian
@endsection

@push('styles')
    
@endpush


@section('contents')
  
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Pembelian</h3>
  
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
                <!-- Button trigger modal -->
                @if(session('success'))
                    <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                @endif
                @if(session('delete'))
                    <div class="alert alert-danger" role="alert" id="success-danger">
                    {{ session('delete') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                @endif
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
                <div class="col-lg-12 mb-3" style="background-color: white;">
                    <div class="box">
                        <div class="box-body mx-2 my-2">
                            <form class="form-supplier">
                                @csrf
                                <div class="form-group row">
                                    <label for="nama" class="col-lg-2">Supplier</label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <input type="hidden" name="id_supplier" id="id_supplier">
                                            <input type="text" name="nama" id="nama" class="form-control" required autofocus readonly>
                                            <span class="input-group-btn tampil-Supplier">
                                                <button onclick="tampilSupplier()" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kode_supplier" class="col-lg-2">Telepon Supplier</label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <input type="hidden" name="id_Supplier" id="id_supplier">
                                            <input type="text" name="tlp" id="tlp" class="form-control" required  readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <form class="form-produk">
                                @csrf
                                <div class="form-group row">
                                    <label for="kode_produk" class="col-lg-2">Produk</label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <input type="hidden" name="id_produk" id="id_produk">
                                            <input type="text" name="barcode" id="barcode" class="form-control" required autofocus readonly>
                                            <span class="input-group-btn tampil-produk">
                                                <button onclick="tambahProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                                <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                
                            <table class="table table-striped table-bordered table-pembelian">
                                <thead>
                                    <th width="4%">No</th>
                                    <th width="10%" class="text-center">Barcode</th>
                                    <th class="text-center">Nama</th>
                                    <th width="15%" class="text-center">Harga</th>
                                    <th width="12%" class="text-center">Jumlah</th>
                                    <th width="12%" class="text-center">Subtotal</th>
                                    <th width="8%"  class="text-center">Aksi</th>
                                </thead>
                            </table>
                
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="tampil-bayar bayar mb-4 ">Rp. 0 ,-</div>
                                    <div class="tampil-terbilang terbilang">Nol Rupiah</div>
                                </div>
                                <div class="col-lg-4">
                                    <form action="{{ route('admin.pembelian.store') }}" class="form-pembelian" method="post">
                                        @csrf
                                        <input type="hidden" name="id_pembelian">
                                        <input type="hidden" name="total" id="total">
                                        <input type="hidden" name="total_item" id="total_item">
                                        <input type="hidden" name="bayar" id="bayar">
                
                                        <div class="form-group row">
                                            <label for="totalrp" class="col-lg-3 control-label">Total</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="totalrp" class="form-control" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row ">
                                            <label for="diskon" class="control-label col-lg-3">Diskon</label>
                                            <div class="col-lg-3">
                                                    <input type="number" name="diskon" id="diskon" class="form-control" placeholder="" value="0" min="0" max="100" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            </div>
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                        </div>
                                          
                                        <div class="form-group row">
                                            <label for="bayar" class="col-lg-3 control-label">Bayar</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="bayarrp" class="form-control" readonly>
                                            </div>
                                        </div>
                
                                        <div class="form-group row">
                                            <label for="diterima" class="col-lg-3 control-label">Uang Diterima</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="diterima" class="form-control" name="diterima" value="{{ $penjualan->diterima ?? 0 }}">
                                            </div>
                                        </div>
                
                                        <div class="form-group row">
                                            <label for="kembali" class="col-lg-3 control-label">Kembalian</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="kembali" name="kembali" class="form-control" value="0" readonly>
                                            </div>
                                        </div>
                
                                    </form>
                                </div>
                            </div>
                        </div>
                
                        <div class="box-footer mb-4 btn-submit">
                            {{-- <a href=""{{ route('admin.pembelian.cancel', $pembelian->id_pembelian ) }} class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-cart-shopping"></i> Batalkan Transaksi</a> --}}
                            <button type="submit" class="btn btn-outline-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
                        </div>
                    </div>
                </div>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      @include('pembelian.formSupplier')
      @include('pembelian.formBarang')
      <!-- /.content -->
@endsection

@push('scripts')
<script>
    $('.tbl-data-supplier').DataTable();
    
    function tampilSupplier() {
        $('#formModalSupplier').modal('show');
    }

    function pilihSupplier(id_supplier, nama, tlp) {
        $('#id_supplier').val(id_supplier);
        $('#nama').val(nama);
        $('#tlp').val(tlp);
        hideSupplier();
    }

    function hideSupplier() {
        $('#formModalSupplier').modal('hide');
    }
</script>
<script>
    $('.tbl-data-barang-pembelian').DataTable();
    
    function tampilProduk() {
        $('#formModalBarangPembelian').modal('show');
    }

    function pilihProduk(id_produk, barcode) {
        $('#id_produk').val(id_produk);
        $('#barcode').val(barcode);
        hideProduk();
    }

    function tambahProduk() {
        $.post("{{ route('admin.pembelian.store') }}", $('.form-produk').serialize())
            .done(response => {
                $('#barcode').focus();
                table.ajax.reload(() => loadForm($('#diskon').val()));
                $('#barcode').val('');
            })
            .fail(errors => {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Input Produk terlebih dahulu!',
                    icon: 'warning',
                    iconColor:'#DC3545',
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#DC3545'
                })
                return;
            });
    }

    function hideProduk() {
        $('#formModalBarangPembelian').modal('hide');
    }
</script>
<script>
    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-pembelian').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('admin.pembelian.data', $id_pembelian) }}",
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'barcode'},
                {data: 'nama_produk'},
                {data: 'harga_beli'},
                {data: 'jumlah'},
                {data: 'subtotal'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            bSort: false,
            paginate: false,
            paginate: false,
            searching: false,
            info: false
        })
        .on('draw.dt', function () {
            loadForm($('#diskon').val());
        });

        table.buttons('.buttonsToHide').nodes().addClass('hidden');

        table2 = $('.table-produk').DataTable();

        $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let jumlah = parseInt($(this).val());

            // if (jumlah < 1) {
            //     $(this).val(1);
            //     Swal.fire({
            //         title: 'Gagal!',
            //         text: 'Jumlah tidak boleh kurang dari 1',
            //         icon: 'error',
            //         confirmButtonText: 'Kembali',
            //         confirmButtonColor: '#e80c29'
            //     })    
            //     return;
            // }
            if (jumlah > 10000) {
                $(this).val(10000);
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Jumlah tidak boleh lebih dari 10K',
                    icon: 'error',
                    confirmButtonText: 'Kembali',
                    confirmButtonColor: '#e80c29'
                })            
                return;
            }

            $.post(`{{ url('/pembelian_detail') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': jumlah
                })
                .done(response => {
                    $(this).on('mouseout', function () {
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    });
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        });

        $(document).on('input', '#diskon', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($(this).val());
        });


        // Fitur Buat Bayar + Kembalian

        // $('#diterima').on('input', function() {
        //     if ($(this).val() == "") {
        //         $(this).val(0).select();
        //     }

        //     loadForm($('#diskon').val(), $(this).val());
        // }).focus(function () {
        //     $(this).select();
        // });

        $('.btn-simpan').on('click', function () {
            $('.form-pembelian').submit();
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
</script>
@endpush