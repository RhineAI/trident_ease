@extends('templates.layout')

@section('title')
    <title>Satuan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Satuan
@endsection

@section('breadcrumb')
@parent
    Satuan
@endsection

@push('styles')
    
@endpush

@section('contents')
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
                <div class="box-body table-responsive ">
                    <h2 class="text-center mt-3 mb-2">Set Satuan</h2>
                    <button type="button" class="btn btn-primary ml-4 mb-4 mt-3" data-toggle="modal" data-target="#formModalSatuan">
                        <i class="fas fa-plus"></i>&nbsp; Tambah Data
                    </button>
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            @include('satuan.data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('satuan.form')
@endsection

@push('scripts')
    <script>
        $('#tbl-data-satuan').DataTable();
        $('#nama').on('keypress', function(e){
            restrictChar(e);
        });
    </script>
    <script>
        $(document).ready(function(){
          $('#formModalSatuan').on("show.bs.modal", function(e){
            const btn = $(e.relatedTarget)
            const id_satuan = btn.data('id_satuan')
            const nama_satuan = btn.data('nama_satuan')
            const mode = btn.data('mode')
            const modal = $(this)
            const url = btn.data('route')
        
            if(mode === 'edit'){
                modal.find('#modal-title').text("Edit Data Satuan")
                modal.find('.modal-body #nama').val(nama_satuan)
                modal.find('.modal-footer #btn-submit').text('Update')
                $('#formModalSatuan form').attr('action', url);
                // modal.find('.modal-body form').attr('action', '/satuan/' + id_satuan)
                modal.find('.modal-body #method').html('{{ method_field('PATCH') }}')
            } else {
                $('#formModalSatuan form')[0].reset();
                $('#formModalSatuan [name=_method]').val('post');
                modal.find('#modal-title').text("Tambah Data Satuan")
                modal.find('.modal-body #id_satuan').val('')
                modal.find('.modal-body #nama').val('')
                modal.find('.modal-footer #btn-submit').text('Submit')
                modal.find('.modal-body #method').html('')
            }
          });
        });

        function deleteData(url) {
            Swal.fire({
                title: 'Hapus Satuan yang dipilih?',
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
                            text: 'Satuan berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }) 
                        location.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Satuan tidak bisa dihapus karena masih digunakan oleh produk',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Satuan batal dihapus',
                        icon: 'warning',
                    })
                }
            })
        }
      </script>
      {{-- <script>
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
      </script> --}}
@endpush