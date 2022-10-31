@extends('templates.layout')

@section('title')
    <title>Pelanggan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Pelanggan
@endsection

@section('breadcrumb')
@parent
    Pelanggan
@endsection

@push('styles')
    
@endpush

@section('contents')
  
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
                <div class="box-body table-responsive ">
                    <h3 class="text-center mt-3 mb-2">Data Pelanggan</h3>
                  <button type="button" class="btn btn-primary ml-4 mb-4 mt-3" data-toggle="modal" data-target="#formModalPelanggan">
                      <i class="fas fa-plus"></i>&nbsp; Tambah Data
                  </button>
                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            @include('pelanggan.data')
                        </div>
                    </div>
                </div>
  
            </div>
        </div>
    </div>
</section>
@include('pelanggan.form')
@endsection

@push('scripts')
    <script>
        $('#tbl-data-pelanggan').DataTable();
    </script>
    <script>
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