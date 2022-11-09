@extends('templates.layout')

@section('title')
<title>Produk | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Produk
@endsection

@section('breadcrumb')
@parent
Produk
@endsection

@push('styles')

@endpush


@section('contents')

<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box">
    
                <div class="box-header with-border mb-3">
                    <button onclick="addForm('{{ route('barang.store') }}')" class="btn btn-primary mx-2 my-3"><i
                            class="fa fa-plus-circle"></i>
                        Tambah</button>
                </div>
    
                <div class="box-body table-responsive">
                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush table-hover text-center" id="dataTableHover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="6%" class="text-center">No</th>
                                            <th width="6%" class="text-center">Kode</th>
                                            <th width="15%" class="text-center">Nama</th>
                                            <th width="6%" class="text-center">Kategori</th>
                                            <th width="6%" class="text-center">Satuan</th>
                                            <th width="6%" class="text-center">Merek</th>
                                            <th width="6%" class="text-center">Pemasok</th>
                                            <th width="6%" class="text-center">Stock</th>
                                            <th width="80%" class="text-center">Harga Beli</th>
                                            <th width="8%" class="text-center">Keterangan</th>
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

    $('body').addClass('sidebar-collapse');

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
                url: "{{ route('barang.data') }}",
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
                {data:'nama_supplier'},
                {data:'stock'},
                {data:'harga_beli'},
                {data:'keterangan'},
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
            // console.log(nama);
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
{{-- <script>

    

    $(document).ready(function () {
        $('#formModalBarang').on("show.bs.modal", function (e) {
            const btn = $(e.relatedTarget)
            const id_barang = btn.data('id_barang')
            const kode = btn.data('kode')
            const nama_barang = btn.data('nama_barang')
            const barcode = btn.data('barcode')
            const id_kategori = btn.data('id_kategori')
            const id_supplier = btn.data('id_supplier')
            const id_satuan = btn.data('id_satuan')
            const id_merek = btn.data('id_merek')
            const id_perusahaan = btn.data('id_perusahaan')
            const stock = btn.data('stock')
            const stock_minimal = btn.data('stock_minimal')
            const harga_beli = btn.data('harga_beli')
            const keuntungan = btn.data('keuntungan')
            const keterangan = btn.data('keterangan')
            const status = btn.data('status')
            const mode = btn.data('mode')
            const route = btn.data('route')
            const modal = $(this)

            if (mode === 'edit') {
                modal.find('#modal-title').text("Edit Data barang")
                modal.find('.modal-body #kode').val(kode)
                modal.find('.modal-body #nama').val(nama_barang)
                modal.find('.modal-body #barcode').val(barcode)
                modal.find('.modal-body #id_kategori').val(id_kategori)
                modal.find('.modal-body #id_supplier').val(id_supplier)
                modal.find('.modal-body #id_satuan').val(id_satuan)
                modal.find('.modal-body #id_merek').val(id_merek)
                modal.find('.modal-body #id_perusahaan').val(id_perusahaan)
                modal.find('.modal-body #stock').val(stock)
                modal.find('.modal-body #stock_minimal').val(stock_minimal)
                modal.find('.modal-body #harga_beli').val(harga_beli)
                modal.find('.modal-body #keuntungan').val(keuntungan)
                modal.find('.modal-body #keterangan').val(keterangan)
                modal.find('.modal-body #status').val(status)
                modal.find('.modal-footer #btn-submit').text('Update')
                modal.find('.modal-body form').attr('action', '/barang/' + id_barang)
                modal.find('.modal-body #method').html('{{ method_field('PATCH') }}')
                // $('#modal-form form')[0].reset();
                // $('#modal-form form').attr('action', data.route);
                // $('#modal-form [name=_method]').val('put');
            } else {
                modal.find('.modal-title').text("Tambah Data barang")
                modal.find('.modal-body #id_barang').val('')
                modal.find('.modal-body #nama_barang').val('')
                modal.find('.modal-footer #btn-submit').text('Submit')
                modal.find('.modal-body #method').html('')
            }
        });
    });
</script> --}}

@endpush