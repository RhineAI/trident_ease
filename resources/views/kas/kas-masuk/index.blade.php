@extends('templates.layout')

@section('title')
    <title>Kas Masuk | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Kas Masuk
@endsection

@section('breadcrumb')
@parent
    Kas Masuk
@endsection

@push('styles')
    
@endpush

@section('contents')
  
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box">
    
                <div class="box-header with-border mb-3">
                    <button data-mode="tambah" onclick="addForm('{{ route('kas-masuk.store') }}')" class="btn btn-primary mx-2 my-3"><i
                            class="fa fa-plus-circle"></i>
                        Tambah</button>
                </div>
    
                <div class="box-body table-responsive">
                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                            <div class="table-responsive ">
                                <table class="table align-items-center table-flush table-hover text-center" id="dataTableHover">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th width="3%" class="text-center">No</th>
                                            <th width="3.6%" class="text-center">Tanggal</th>
                                            <th width="10%" class="text-center">Jumlah</th>
                                            <th width="7%" class="text-center">Oleh</th>
                                            <th width="15%" class="text-center">Keterangan</th>
                                            <th width="7%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
@includeIf('kas.kas-masuk.form')
</section>
@endsection

@push('scripts')
<script>
    // $('body').addClass('sidebar-collapse');

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

        $(document).on('keyup', '#jumlah', function(e){
            generateRupiah(this);
        })


        function addForm(url) {
            // $('#modal-form').trigger('reset');
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Kas Masuk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=jumlah]').focus();
        }

        let table;
            table = $('.table').DataTable({
            processing: true,
            responsive: true,
            autoWidth: false,
            serverSide: true,
            ajax: {
                url: "{{ route('kas-masuk.data') }}",
                type: "POST",
                data: {  
                    _token: '{{ csrf_token() }}'
                }
            },
            columns: [
                {data:'DT_RowIndex', searchable: false, sortable: false},
                {data:'tgl'},
                {data:'jumlah'},
                {data:'nama_user'},
                {data:'keterangan'},
                {data:'action', searchable: false, sortable: false},
            ]
        });
        
        $(document).on('click', '.edit', function (event) {
            let jumlah = $(this).data('jumlah')
            let keterangan = $(this).data('keterangan')
            let url = $(this).data('route')
            var mode = $(this).data('mode')
            var tambah = $(this).data('tambah')
            // console.log(keterangan)

            var data = {
                jumlah : jumlah,
                keterangan : keterangan,
                url: url,
                mode: mode,
                tambah: tambah
            }

            editForm(data)
        })
        
        function editForm(data) {
           $('document').ready(function() {
                if (data.mode == 'edit') {
                    $('#modal-form').modal('show')
                    $('#modal-form .modal-title').text('Edit Kas Masuk');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', data.url);
                    $('#modal-form [name=_method]').val('put');
                    
                    $('#modal-form [name=jumlah]').val(data.jumlah);
                    $('#modal-form [name=jumlah]').attr("readonly", "readonly");
                    $('#modal-form [name=keterangan]').val(data.keterangan);

                } else {
                    $('#modal-form').modal('show')
                    $('#modal-form .modal-title').text('Tambah Kas Masuk');
                    $('#modal-form form').attr('action', data.tambah);
                    $('#modal-form [name=_method]').val('post');
                    
                    $('#modal-form [name=jumlah]').val();
                    $('#modal-form [name=keterangan]').val(); 
                }
           })
        }

        function deleteForm(url) {
            Swal.fire({
                title: 'Hapus Data yang dipilih?',
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
                            text: 'Data Kas Masuk berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }) 
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Data Kas Masuk gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Kas Masuk batal dihapus',
                        icon: 'warning',
                    })
                }
            })
        }


</script>
@endpush