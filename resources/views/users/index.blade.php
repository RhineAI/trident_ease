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
                <h2 class="text-center mt-3 mb-2">Data Pegawai</h2>
                @if (auth()->user()->hak_akses == 'admin')
                    <button onclick="addForm('{{ route('admin.users.store') }}')" class="btn btn-primary mx-2 my-3"><i
                        class="fa fa-plus-circle"></i>
                    Tambah</button>
                @elseif(auth()->user()->hak_akses == 'owner')             
                    <button onclick="addForm('{{ route('owner.users.store') }}')" class="btn btn-primary mx-2 my-3"><i
                        class="fa fa-plus-circle"></i>
                    Tambah</button>
                @endif  
                
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
{{-- $(document).ready(function(){
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
  }); --}}

@push('scripts')
    <script>
        $('#tbl-data-pegawai').DataTable();
    </script>
    <script>

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Pegawai Baru');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
        }

        $(document).on('click', '#edit', function(event) {
            let id = $(this).data('id_pegawai')
            let nama = $(this).data('nama')
            let alamat = $(this).data('alamat')
            let tlp = $(this).data('tlp')
            let jenis_kelamin = $(this).data('jenis_kelamin')
            let hak_akses = $(this).data('hak_akses')
            let username = $(this).data('username')
            let password = $(this).data('password')
            let url = $(this).data('route')

            let data = {
                nama : nama,
                alamat : alamat,
                tlp : tlp,
                jenis_kelamin : jenis_kelamin,
                hak_akses : hak_akses,
                username : username,
                password : password,
                url: url
            }

            editForm(data)
        })


        function editForm(data) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Pegawai');

            $('#modal-form form')[0].reset();
            $('.modal-body form').attr('action', data.url);
            $('.modal-body #method').html('{{ method_field('PUT') }}');

            $('#modal-form [name=nama]').val(data.nama);
            $('#modal-form [name=alamat]').val(data.alamat);
            $('#modal-form [name=tlp]').val(data.tlp);
            $('#modal-form [name=jenis_kelamin]').val(data.jenis_kelamin);
            $('#modal-form [name=hak_akses]').val(data.hak_akses);
            $('#modal-form [name=username]').val(data.username);
            $('#modal-form [name=password]').attr("type", "hidden");
            $('#modal-form [name=password_confirmation]').attr("type", "hidden");
            
            $('[id=pass]').hide();
            // alert(password);
            // $('#modal-form .password').style.visibility="hidden";
            // modal.find('.modal-body form').attr('action', data.url);
            // modal.find('.modal-body #method').html('{{ method_field('PATCH') }}');
        }
           

       
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