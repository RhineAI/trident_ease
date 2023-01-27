@extends('templates.layout')

@section('title')
<title>Produk Utama | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Produk Utama
@endsection

@section('breadcrumb')
@parent
Produk Utama
@endsection

@push('styles')
<style>
    @import "bourbon";
    @import url(https://fonts.googleapis.com/css?family=Lato:400,700,300);
    body {
        font-family: 'Lato', sans-serif;
    }
    /* .form {
        width: 400px;
    } */
    .file-upload-wrapper-download {
        position: relative;
        width: 90%;
        height: 60px;
        margin-top: 20px;
        margin-left: 20px;
        background: #ffe;
    }
    .file-upload-wrapper-download:after {
        content: attr(data-text);
        font-size: 18px;
        position: absolute;
        top: 0;
        left: 0;
        background: #ffe;
        padding: 10px 15px;
        display: block;
        width: calc(100% - 60px);
        pointer-events: none;
        z-index: 20;
        height: 40px;
        line-height: 40px;
        color: #999;
        border-radius: 5px 10px 10px 5px;
        font-weight: 300;
    }
    .file-upload-wrapper-download:before {
        content: 'Download';
        position: absolute;
        top: 0;
        right: 0;
        display: inline-block;
        height: 60px;
        background: #4daf7c;
        color: #fff;
        font-weight: 500;
        z-index: 25;
        font-size: 14px;
        font-family: 'Poppins';
        line-height: 60px;
        padding: 0 7.5px;
        text-transform: uppercase;
        pointer-events: none;
        border-radius: 0 5px 5px 0;
    }
    .file-upload-wrapper-download:hover:before {
        background: #3d8c63;
    }
    .file-upload-wrapper-download input {
        opacity: 0;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 99;
        height: 40px;
        margin: 0;
        padding: 0;
        display: block;
        cursor: pointer;
        width: 100%;
    }
</style>

<style>
    @import "bourbon";
    @import url(https://fonts.googleapis.com/css?family=Lato:400,700,300);
    body {
        font-family: 'Lato', sans-serif;
    }
    /* .form {
        width: 400px;
    } */
    .file-upload-wrapper-upload {
        position: relative;
        width: 90%;
        height: 60px;
        margin-top: 20px;
        margin-left: 20px;
        background: #ffe;
    }
    .file-upload-wrapper-upload:after {
        content: attr(data-text);
        font-size: 18px;
        position: absolute;
        top: 0;
        left: 0;
        background: #ffe;
        padding: 10px 15px;
        display: block;
        width: calc(100% - 40px);
        pointer-events: none;
        z-index: 20;
        height: 40px;
        line-height: 40px;
        color: #999;
        border-radius: 5px 10px 10px 5px;
        font-weight: 300;
    }
    .file-upload-wrapper-upload:before {
        content: 'Upload';
        position: absolute;
        top: 0;
        right: 0;
        display: inline-block;
        height: 60px;
        background: #4daf7c;
        color: #fff;
        font-weight: 500;
        z-index: 25;
        font-size: 14px;
        font-family: 'Poppins';
        line-height: 60px;
        padding: 0 7.5px;
        text-transform: uppercase;
        pointer-events: none;
        border-radius: 0 5px 5px 0;
    }
    .file-upload-wrapper-upload:hover:before {
        background: #3d8c63;
    }
    .file-upload-wrapper-upload input {
        opacity: 0;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 99;
        height: 40px;
        margin: 0;
        padding: 0;
        display: block;
        cursor: pointer;
        width: 100%;
    }
</style>
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
                    <button class="btn btn-success mx-2 my-3" data-toggle="modal" data-target="#importBarang"><i class="fa fa-plus-circle"></i>
                        Import</button>
                    {{-- <button type="button" class="btn btn-success mx-2 my-3" data-toggle="modal" data-target="#importBarang">
                        Import Barang
                    </button> --}}
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
                                            <th width="8%" class="text-center">Jenis</th>
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
@include('barang.formImport')
{{-- @include('barang.formImport') --}}
@endsection

@push('scripts')
<script>
    $('#tbl-data-barang').DataTable({
        scrollX: true,
    });

    $('body').addClass('sidebar-collapse');

    $(document).on('keyup', '#harga_beli', function (e) {
            var keuntungan = $("#keuntungan").val();
            var hj;
            var hb = String($(this).val()).replaceAll(".", '');

            if(keuntungan == 0){
                hj = hb;
            } else if(keuntungan > 0){
                hj = parseFloat(hb) + parseFloat(hb) * keuntungan/100;
            }
            $("#harga_jual").val(hj)
    });

    $(document).on('keyup', '#keuntungan', function (e) {
            var keuntungan = $(this).val();
            var hb = String($("#harga_beli").val()).replaceAll(".", '');
            var hj;
            console.log(hb)

            if(hb == 0){
                hj = 0 * keuntungan;
            } else if(hb > 0){
                hj = parseFloat(hb) + parseFloat(hb) * keuntungan/100;
            }
            $("#harga_jual").val(hj)
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
                url: "{{ route('admin.barang.data') }}",
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

{{-- Form JS --}}
<script>
    $("form").on("change", ".file-upload-field", function(){ 
        $(this).parent(".file-upload-wrapper").attr("data-text",        
        $(this).val().replace(/.*(\/|\\)/, '') );
    });
    function _(el) {
        return document.getElementById(el);
    }

    function uploadFile() {
        var file = _("file1").files[0];
        // alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();
        formdata.append("file1", file);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "file_upload_parser.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
        //use file_upload_parser.php from above url
        ajax.send(formdata);
    }

    function progressHandler(event) {
        _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
        var percent = (event.loaded / event.total) * 100;
        _("progressBar").value = Math.round(percent);
        _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
    }

    function completeHandler(event) {
        _("status").innerHTML = event.target.responseText;
        _("progressBar").value = 0; //wil clear progress bar after successful upload
    }

    function errorHandler(event) {
        _("status").innerHTML = "Upload Failed";
    }

    function abortHandler(event) {
        _("status").innerHTML = "Upload Aborted";
    }
</script>

{{-- <script>
    const dropArea = document.querySelector(".drop_box"),
            button = dropArea.querySelector("button"),
            dragText = dropArea.querySelector("header"),
            input = dropArea.querySelector("input");
    let file;
    var filename;

    button.onclick = () => {
        input.click();
    };

    input.addEventListener("change", function (e) {
    var fileName = e.target.files[0].name;
    let filedata = `
        <form action="" method="post">
        <div class="form">
        <h4>${fileName}</h4>
        <input type="email" placeholder="Enter email upload file">
        <button class="btn">Upload</button>
        </div>
        </form>`;
    dropArea.innerHTML = filedata;
    });

</script> --}}

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