@extends('templates.layout')

@section('title')
    <title>Pegawai | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Pegawai
@endsection

@section('breadcrumb')
@parent
    Pegawai
@endsection

@section('contents')
  
<section class="content">
  <div class="row mx-3">
      <div class="col-md-12 p-2 mb-3" style="background-color: white">
          <div class="box mb-4">
              <div class="box-body table-responsive">
                <h3 class="text-center mt-3 mb-2">Data Pegawai</h3>
                <button type="button" class="btn btn-primary ml-4 mb-4 mt-3" data-toggle="modal" data-target="#formModalPegawai">
                    <i class="fas fa-plus"></i>&nbsp; Tambah Data
                </button>
                  <!-- DataTable with Hover -->
                  <div class="col-lg-12">
                      <div class="table-responsive p-3">
                          @include('users.data')
                      </div>
                  </div>
              </div>

          </div>
      </div>
  </div>
</section>
@include('users.form')
@endsection

@push('scripts')
    <script>
        $('#tbl-data-pegawai').DataTable();
    </script>
    <script>
        $(document).ready(function(){
          $('#formModalPegawai').on("show.bs.modal", function(e){
            const btn = $(e.relatedTarget)
            const id_pegawai = btn.data('id_pegawai')
            const nama = btn.data('nama')
            const alamat = btn.data('alamat')
            const tlp = btn.data('tlp')
            const hak_akses = btn.data('hak_akses')
            const jenis_kelamin = btn.data('jenis_kelamin')
            const username = btn.data('username')
            const password = btn.data('password')
            const mode = btn.data('mode')
            const modal = $(this)
        
            if(mode === 'edit'){
                modal.find('#modal-title').text("Edit Data pegawai")
                modal.find('.modal-body #nama').val(nama)
                modal.find('.modal-body #alamat').val(alamat)
                modal.find('.modal-body #tlp').val(tlp)
                modal.find('.modal-body #hak_akses').val(hak_akses)
                modal.find('.modal-body #jenis_kelamin').val(jenis_kelamin)
                modal.find('.modal-body #username').val(username)
                modal.find('.modal-body #password').val(password)
                document.getElementById('hpsUsername').style.display = "none"
                document.getElementById('hpsPassword').style.display = "none"
                document.getElementById('hpsPassword2').style.display = "none"
                modal.find('.modal-footer #btn-submit').text('Update')
                modal.find('.modal-body form').attr('action', '/users/' + id_pegawai)
                modal.find('.modal-body #method').html('{{ method_field('PATCH') }}')
            } else {
                modal.find('#modal-title').text("Tambah Data pegawai")
                modal.find('.modal-body #id_pegawai').val('')
                modal.find('.modal-body #nama_pegawai').val('')
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