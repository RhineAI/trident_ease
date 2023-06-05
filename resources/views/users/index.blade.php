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

        @if(auth()->user()->hak_akses == 'admin') 
            var routeM = "{{ route('admin.getUsername') }}";
        @elseif(auth()->user()->hak_akses == 'kasir') 
            var routeM = "{{ route('owner.getUsername') }}";
        @endif
        
        $('#messageTrue').hide()
        $('#messageFalse').hide()

        $('#username').on('keyup', function(){
            $.ajax({
                type: 'POST',
                url: routeM,
                data: {
                    _token: "{{ csrf_token() }}",
                    username: $('#username').val()
                },
                cache: false,
                success: function(response){
                    console.log(response)
                    if(response === 'true'){
                        $('#messageTrue').show()
                        $('#messageFalse').hide()
                        $('#check').val("true")
                    } else {
                        $('#messageFalse').show()
                        $('#messageTrue').hide()
                        $('#check').val("false")
                    }
                }
            })
        });

        $('#username').on('keyup', function(){
            $.ajax({
                type: 'POST',
                url: routeM,
                data: {
                    _token: "{{ csrf_token() }}",
                    username: $('#username').val()
                },
                cache: false,
                success: function(response){
                    console.log(response)
                    if(response === 'true'){
                        $('#messageTrue').show()
                        $('#messageFalse').hide()
                        $('#check').val("true")
                    } else {
                        $('#messageFalse').show()
                        $('#messageTrue').hide()
                        $('#check').val("false")
                    }
                }
            })
        });

        $('#formPegawai').on('submit', function(){
            const nama = $('#nama').val()
            const alamat = $('#alamat').val()
            const tlp = $('#tlp').val()
            const salesman = $('#salesman').val()
            const jenis_kelamin = $('#jenis_kelamin').val()
            const username = $('#username').val()
            const password = $('#password').val()
            const password_confirmation = $('#password_confirmation').val()
            const hak_akses = $('#hak_akses').val()
            const check = $('#check').val()
            const mode = $('#mode').val()
            
            if(nama == "") {
                Swal.fire('Nama Pegawai Harus Diisi!')
                return false;
            } else {
                $('#nama').val();
            }

            if(alamat == "") {
                Swal.fire('Alamat Pegawai Harus Diisi!')
                return false;
            } else {
                $('#alamat').val();
            }

            if(tlp == "") {
                Swal.fire('Telepon Pegawai Harus Diisi!')
                return false;
            } else {
                $('#tlp').val();
            }

            if(jenis_kelamin == null) {
                Swal.fire('Jenis Kelamin Harus Diisi!')
                return false;
            } else {
                $('#jenis_kelamin').val();
            }

            if(username == "") {
                Swal.fire('Username Harus Diisi!')
                return false;
            } else {
                $('#username').val();
            }

            if(mode == "input"){
                if(password == "") {
                    Swal.fire('Password Harus Diisi!')
                    return false;
                } else {
                    $('#password').val();
                }

                if(password_confirmation == "") {
                    Swal.fire('Konfirmasi Password Harus Diisi!')
                    return false;
                } else {
                    $('#password_confirmation').val();
                }
            }
            

            if(hak_akses == "") {
                Swal.fire('Hak Akses Harus Diisi!')
                return false;
            } else {
                $('#hak_akses').val();
            }

            if(check === "false") {
                Swal.fire('Username telah digunakan!')
                return false;
            } else {
                $('#check').val();
            }
        })
    </script>
    <script>
        $('[id=pass]').hide();

        function addForm(url) {
            $('#modal-form').modal({backdrop: 'static', keyboard: false})
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Pegawai Baru');
            $('#mode').val('input')

            
            $('.modal-body form')[0].reset();
            $('.modal-body form').attr('action', url);
            $('[id=pass]').show();

            
            $('.modal-body [name=_method]').val('post');
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
            $('#modal-form').modal({backdrop: 'static', keyboard: false})
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Pegawai');
            $('#mode').val('edit')

            $('#modal-form form')[0].reset();
            $('.modal-body form').attr('action', data.url);
            $('.modal-body #method').html('{{ method_field('PUT') }}');

            $('#modal-form [name=nama]').val(data.nama);
            $('#modal-form [name=alamat]').val(data.alamat);
            $('#modal-form [name=tlp]').val(data.tlp);
            $('#modal-form [name=jenis_kelamin]').val(data.jenis_kelamin);
            $('#modal-form [name=hak_akses]').val(data.hak_akses);
            $('#modal-form [name=username]').val(data.username);
            
            $('[id=pass]').hide();
            $('form #messageTrue').show()
            $('form #messageFalse').hide()
            document.getElementById("password").required = false;
            document.getElementById("password_confirmation").required = false;
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
        <script>
            $('#nama').on('keypress', function(e){
                restrictChar(e);
            });
            $('#alamat').on('keypress', function(e){
                restrictChar(e);
            });
            $('#username').on('keypress', function(e){
                restrictChar(e);
            });
            $('#tlp').on('keypress', function(e){
                restrictWord(e);
            });
        </script>
@endpush