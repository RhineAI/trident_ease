@extends('templates.layout')

@section('title')
    <title>Penjualan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Penjualan
@endsection

@section('breadcrumb')
@parent
    Penjualan
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

    .table-penjualan tbody tr:last-child {
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
  
        <div class="row mx-4">
            <div class="col-lg-12" style="background-color: white;">
                <div class="box-body">
        
                    <div class="box-body mx-2 my-2">
                            
                        <form class="form-produk">
                            @csrf
                            <div class="form-group row">
                                <label for="kode_produk" class="col-lg-2">Tambah Produk</label>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <input type="hidden" name="id_produk" id="id_produk">
                                        <input type="hidden" class="form-control" name="kode_produk" id="kode_produk">
                                        <input type="text" name="barcode" id="barcode" class="form-control" required autofocus readonly>
                                        <span class="input-group-btn tampil-produk">
                                            <button onclick="tambahProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                            <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
        
                        <table class="table table-striped table-bordered table-penjualan">
                            <thead>
                                <th width="4%">No</th>
                                <th width="10%" class="text-center">Barcode</th>
                                <th class="text-center">Nama</th>
                                <th width="15%"class="text-center">Harga</th>
                                <th width="12%" class="text-center">Jumlah</th>
                            
                                <th width="12%" class="text-center">Subtotal</th>
                                <th width="8%" class="text-center">Aksi</th>
                            </thead>
                        </table>
        
                        <div class="row mt-4">
                            <div class="col-lg-8">
                                <div class="tampil-bayar bg-default mb-4">Rp. 0 ,-</div>
                                <div class="tampil-terbilang">Nol Rupiah</div>
                            </div>
                            <div class="col-lg-4">
                                <form action="" class="form-pembelian" method="post">
                                    @csrf
                                    {{-- <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}"> --}}
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
                                                <input type="number" name="diskon" id="diskon" class="form-control" placeholder="" value="0" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        </div>
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bayar" class="col-lg-3 control-label">Total Bayar</label>
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
                        <button type="submit" class="btn btn-outline-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
                    </div>
                </div>
            </div>
        </div>
  
      </section>
      <!-- /.content -->
@endsection

@push('scripts')
<script>
    let table, table2;

    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-penjualan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'barcode'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
               
                {data: 'subtotal'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            bSort: false,
            paginate: false,
            searching: false,
            info: false
        })
        .on('draw.dt', function () {
            loadForm($('#diskon').val());
            setTimeout(() => {
                $('#diterima').trigger('input');
            }, 300);
        });
        table2 = $('.table-produk').DataTable();

        $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let jumlah = parseInt($(this).val());

            if (jumlah > 10000) {
                $(this).val(10000);
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Jumlah tidak boleh lebih dari 10K',
                    icon: 'warning',
                    confirmButtonText: 'Kembali',
                    confirmButtonColor: '#e80c29'
                })            
                return;
            }


            $.post(`{{ url('/transaksi') }}/${id}`, {
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
                    Swal.fire({
                    title: 'Gagal!',
                    text: 'Stok habis, silahkan pilih produk lain',
                    icon: 'warning',
                    confirmButtonText: 'Kembali',
                    confirmButtonColor: '#e80c29'
                })         
                });
        });

        $(document).on('input', '#diskon', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($(this).val());
        });

        // Fitur Buat Bayar + Kembalian

        $('#diterima').on('input', function() {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($('#diskon').val(), $(this).val());
        }).focus(function () {
            $(this).select();
        });

        $('.btn-simpan').on('click', function () {
            $('.form-pembelian').submit();
        });
    });

    function tampilProduk() {
        $('#modal-produk').modal('show');
    }

    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, kode) {
        // $('body').on('click', ('#selectProduct') function() {
        //     let checkProduct = $('#id_produk')
        // })

        $('#id_produk').val(id);
        $('#barcode').val(kode);
        hideProduk();

    }

    function tambahProduk() {
        
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
                    confirmButtonText: 'Omkey',
                    confirmButtonColor: '#DC3545'
                })
                return;
            });
    }

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

            $(document).on('keyup', '#diterima', function(e){
                generateRupiah(this);
            })

    function deleteData(url) {
        Swal.fire({
            title: 'Hapus Data Penjualan yang dipilih?',
            icon: 'question',
            iconColor: '#DC3545',
            showDenyButton: true,
            denyButtonColor: '#838383',
            denyButtonText: 'Batal',
            confirmButtonText: 'Hapus',
            confirmButtonColor: '#DC3545'
            }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Data Penjualan berhasil dihapus',
                        icon: 'success',
                        confirmButtonText: 'Lanjut',
                        confirmButtonColor: '#28A745'
                    }) 
                    table.ajax.reload();
                })
                .fail((errors) => {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Data Penjualan gagal dihapus',
                        icon: 'error',
                        confirmButtonText: 'Kembali',
                        confirmButtonColor: '#DC3545'
                    })                       
                    return;
                });
            } else if (result.isDenied) {
                Swal.fire({
                    title: 'Data Penjualan batal dihapus',
                    icon: 'warning',
                })
            }
        })
    }

    function loadForm(diskon = 0, diterima = 0) {
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
            .done(response => {
                $('#totalrp').val('Rp. '+ response.totalrp);
                $('#bayarrp').val('Rp. '+ response.bayarrp);
                $('#bayar').val(response.bayar);
                $('.tampil-bayar').text('Bayar : Rp. '+ response.bayarrp);
                $('.tampil-terbilang').text(response.terbilang);

                $('#kembali').val('Rp. '+ response.kembalirp);
                if ($('#diterima').val() != 0) {
                    $('.tampil-bayar').text('Kembali : Rp. '+ response.kembalirp);
                    $('.tampil-terbilang').text(response.kembali_terbilang);
                }
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            })
    }

</script>
        $(document).ready(function(){
          $('#formModalPelanggan').on("show.bs.modal", function(e){
            const btn = $(e.relatedTarget)
            const id_pelanggan = btn.data('id_pelanggan')
            const nama_pelanggan = btn.data('nama_pelanggan')
            const alamat = btn.data('alamat')
            const tlp = btn.data('tlp')
            const jenis_kelamin = btn.data('jenis_kelamin')
            const id_perusahaan = btn.data('id_perusahaan')
            const mode = btn.data('mode')
            const modal = $(this)
        
            if(mode === 'edit'){
                modal.find('#modal-title').text("Edit Data pelanggan")
                modal.find('.modal-body #nama').val(nama_pelanggan)
                modal.find('.modal-body #alamat').val(alamat)
                modal.find('.modal-body #tlp').val(tlp)
                modal.find('.modal-body #jenis_kelamin').val(jenis_kelamin)
                modal.find('.modal-footer #btn-submit').text('Update')
                modal.find('.modal-body form').attr('action', '/pelanggan/' + id_pelanggan)
                modal.find('.modal-body #method').html('{{ method_field('PATCH') }}')
            } else {
                modal.find('#modal-title').text("Tambah Data pelanggan")
                modal.find('.modal-body #id_pelanggan').val('')
                modal.find('.modal-body #nama_pelanggan').val('')
                modal.find('.modal-footer #btn-submit').text('Submit')
                modal.find('.modal-body #method').html('')
            }
          });
        });
      </script>
      <script>
          $('.delete-data').on('click', function(e){
            e.preventDefault();
            Swal.fire({
            title: 'Apakah Kamu Yakin Menghapus Data Ini?',
            text: "Data tidak akan bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus data ini!'
            }).then((result) => {
            if (result.isConfirmed) {
                $(e.target).closest('form').submit()
            } else {
                swal.close()
            }
            })
          });
      </script>
@endpush