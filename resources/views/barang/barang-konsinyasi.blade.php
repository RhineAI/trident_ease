@extends('templates.layout')

@section('title')
<title>Produk Konsinyasi | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Produk Konsinyasi
@endsection

@section('breadcrumb')
@parent
Produk Konsinyasi
@endsection

@push('styles')

@endpush


@section('contents')

<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box">
    
                <div class="box-header with-border mb-3">
                    <button onclick="addForm('{{ route('admin.barang.store') }}')" class="btn btn-primary mx-2 my-3"><i
                            class="fa fa-plus-circle"></i>
                        Tambah</button>
                </div>
    
                <div class="box-body table-responsive">
                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush table-hover text-center" id="">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="6%" class="text-center">No</th>
                                            <th width="6%" class="text-center">Kode</th>
                                            <th width="15%" class="text-center">Nama</th>
                                            <th width="6%" class="text-center">Kategori</th>
                                            <th width="6%" class="text-center">Satuan</th>
                                            <th width="6%" class="text-center">Merek</th>
                                            {{-- <th width="6%" class="text-center">Pemasok</th> --}}
                                            <th width="6%" class="text-center">Stock</th>
                                            <th width="14%" class="text-center">Harga Beli</th>
                                            <th width="8%" class="text-center">Harga Jual</th>
                                            <th width="6%" class="text-center">Status</th>
                                            <th width="4%" class="text-center">Aksi</th>
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
@include('barang.form')
@endsection

@push('scripts')
<script>
    $('#tbl-data-barang').DataTable({
        scrollX: true,
    });

    function roundToThousands(value) {
        return Math.ceil(value / 1000) * 1000;
    }

    $('#formBarang').on('submit', function(){
        const product_name = $('#product_name').val()
        const barcode = $('#barcode').val()
        const kode = $('#kode').val()
        const id_kategori = $('#id_kategori').val()
        const id_satuan = $('#id_satuan').val()
        // const id_supplier = $('#id_supplier').val()
        const id_merek = $('#id_merek').val()
        const stock = $('#stock').val()
        const stock_minimal = $('#stock_minimal').val()
        const harga_beli = $('#harga_beli').val()
        const keuntungan = $('#keuntungan').val()
        const status = $('#status').val()
        const keterangan = $('#keterangan').val()
        // tampung data input ke variabel javascript

        // pengecekan jika ada salah satu input yang tidak diisi
        if(product_name == "") {
            Swal.fire('Nama Produk Harus Diisi!')
            return false;
        } else {
            $('#product_name').val();
        }

        if(kode == "") {
            Swal.fire('Kode Barang Harus Diisi!')
            return false;
        } else {
            $('#kode').val();
        }

        if(id_kategori == null) {
            Swal.fire('Kategori Harus Diisi!')
            return false;
        } else {
            $('#id_kategori').val();
        }

        if(id_satuan == null) {
            Swal.fire('Satuan Harus Diisi!')
            return false;
        } else {
            $('#id_satuan').val();
        }

        if(id_merek == null) {
            Swal.fire('Merek Harus Diisi!')
            return false;
        } else {
            $('#id_merek').val();
        }

        if(stock == "") {
            Swal.fire('Stock Harus Diisi!')
            return false;
        } else {
            $('#stock').val();
        }

        if(stock_minimal == "") {
            Swal.fire('Stock Minimal Harus Diisi!')
            return false;
        } else {
            $('#stock_minimal').val();
        }

        if(harga_beli == "") {
            Swal.fire('Harga Beli Harus Diisi!')
            return false;
        } else {
            $('#harga_beli').val();
        }

        if(keuntungan == "") {
            Swal.fire('Keuntungan Harus Diisi!')
            return false;
        } else {
            $('#keuntungan').val();
        }

        if(status == null) {
            $('#status').val(1);
        }

        if(keterangan == null) {
            Swal.fire('Keterangan Harus Diisi!')
            return false;
        } else {
            $('#keterangan').val();
        }
    })

    $('body').addClass('sidebar-collapse');

    $(document).on('keyup change', '#harga_beli', function (e) {
        var keuntungan = $("#keuntungan").val();
        var hb = $(this).val().replaceAll(".", '');
        var hargaBeli = parseFloat(hb);

        if (keuntungan > 0) {
            var hargaJual = hargaBeli + (hargaBeli * keuntungan / 100);
            $("#harga_jual").val(hargaJual.toLocaleString());
        } else {
            $("#harga_jual").val(hargaBeli.toLocaleString());
        }
    });

    function removeThousandsSeparator(value) {
        return value.replaceAll(".", '');
    }

    $(document).on('keyup change', '#keuntungan', function (e) {
        var keuntungan = $(this).val();
        var hb = removeThousandsSeparator($("#harga_beli").val());
        var hj;

        if (hb == 0) {
            hj = 0 * keuntungan;
        } else if (hb > 0) {
            hj = parseFloat(hb) + parseFloat(hb) * keuntungan / 100;
        }

        $("#harga_jual").val(hj.toLocaleString());
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

        $(document).on('keyup', '#harga_beli', function(e){
            generateRupiah(this);
        })


        function addForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Tambah Produk Baru');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama]').focus();
        }

        let table;
            table = $('.table').DataTable({
            processing: true,
            responsive: true,
            autoWidth: false,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.barang.dataKonsinyasi') }}",
                type: "POST",
                data: {  
                    _token: '{{ csrf_token() }}'
                }
            },
            columns: [
                {data:'DT_RowIndex', searchable: false, sortable: false},
                {data:'kode'},
                {data:'nama'},
                {data:'nama_kategori'},
                {data:'nama_satuan'},
                {data:'nama_merek'},
                {data:'stock'},
                {data:'harga_beli'},
                {data:'harga_jual'},
                {data:'status'},
                {data:'action', searchable: false, sortable: false},
            ]
        });
        
        $(document).on('click', '.edit', function (event) {
            let kode = $(this).data('kode')
            let nama = $(this).data('nama')
            let barcode = $(this).data('barcode')
            let id_kategori = $(this).data('id_kategori')
            let id_satuan = $(this).data('id_satuan')
            let id_supplier = $(this).data('id_supplier')
            let id_merek = $(this).data('id_merek')
            let id_perusahaan = $(this).data('id_perusahaan')
            let stock = $(this).data('stock')
            let stock_minimal = $(this).data('stock_minimal')
            let harga_beli = $(this).data('harga_beli')
            let keuntungan = $(this).data('keuntungan')
            let keterangan = $(this).data('keterangan')
            let status = $(this).data('status')
            let url = $(this).data('route')

            let data = {
                kode : kode,
                nama : nama,
                barcode : barcode,
                id_kategori : id_kategori,
                id_satuan : id_satuan,
                id_supplier : id_supplier,
                id_merek : id_merek,
                id_perusahaan : id_perusahaan,
                stock : stock,
                stock_minimal : stock_minimal,
                harga_beli : harga_beli,
                keuntungan : keuntungan,
                keterangan : keterangan,
                status : status,
                url: url
            }

            editForm(data)
        })
        
        function editForm(data) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Barang');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', data.url);
            $('#modal-form [name=_method]').val('put');
            
            $('#modal-form [name=kode]').val(data.kode);
            $('#modal-form [name=nama]').val(data.nama);
            $('#modal-form [name=barcode]').val(data.barcode);
            $('#modal-form [name=id_kategori]').val(data.id_kategori);
            $('#modal-form [name=id_satuan]').val(data.id_satuan);
            $('#modal-form [name=id_supplier]').val(data.id_supplier);
            $('#modal-form [name=id_merek]').val(data.id_merek);
            $('#modal-form [name=id_perusahaan]').val(data.id_perusahaan);
            $('#modal-form [name=stock]').val(data.stock);
            $('#modal-form [name=harga_beli]').val(data.harga_beli);
            $('#modal-form [name=stock_minimal]').val(data.stock_minimal);
            $('#modal-form [name=keuntungan]').val(data.keuntungan);
            $('#modal-form [name=keterangan]').val(data.keterangan);
            $('#modal-form [name=status]').val(data.status);
        }

        function deleteForm(url) {
            let nama = $(this).data('nama_barang');
            Swal.fire({
                title: 'Hapus Produk yang dipilih?',
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
                            text: 'Data Produk berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }) 
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Data Produk gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Produk batal dihapus',
                        icon: 'warning',
                    })
                }
            })
        }

</script>
@endpush