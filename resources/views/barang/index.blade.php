@extends('templates.layout')

@section('title')
<title>Barang | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Barang
@endsection

@section('breadcrumb')
@parent
Barang
@endsection

@push('styles')

@endpush


@section('contents')

<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box">
                <div class="box-header with-border">
                    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#formModalBarang">
                        <i class="fas fa-plus"></i>&nbsp; Tambah Data
                    </button>
                </div>

                <div class="box-body table-responsive">
                    @include('barang.data')
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

    // $(document).on('click', '.edit', function (event) {
    //         let kode = $(this).data('kode')
    //         let nama_barang = $(this).data('nama_barang')
    //         let barcode = $(this).data('barcode')
    //         let id_kategori = $(this).data('id_kategori')
    //         let url = $(this).data('route')

    //         let data = {
    //             product_name : product_name,
    //             category_id : category_id,
    //             purchase : purchase,
    //             sell : sell,
    //             stock : stock,
    //             url: url
    //         }

    //         editForm(data)
    //     })
        
    //     function editForm(data) {
    //         $('#modal-form').modal('show')
    //         $('#modal-form .modal-title').text('Edit Produk');

    //         $('#modal-form form')[0].reset();
    //         $('#modal-form form').attr('action', data.url);
    //         $('#modal-form [name=_method]').val('put');
            
    //         $('#modal-form [name=product_name]').val(data.product_name);
    //         $('#modal-form [name=category_id]').val(data.category_id);
    //         $('#modal-form [name=purchase]').val(data.purchase);
    //         $('#modal-form [name=sell]').val(data.sell);
    //         $('#modal-form [name=stock]').val(data.stock);
    //     }

</script>
<script>

    

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
</script>
<script>
    $('.delete-data').on('click', function (e) {
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