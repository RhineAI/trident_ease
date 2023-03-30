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
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                 @endif
                <div class="box-body table-responsive ">
                    <h2 class="text-center mt-3 mb-4">Data Pelanggan</h2>
                  <button type="button" class="btn btn-primary ml-4" data-toggle="modal" data-target="#formModalPelanggan">
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

        $('#formPelanggan').on('submit', function(){
            const nama = $('#nama').val()
            const alamat = $('#alamat').val()
            const tlp = $('#tlp').val()
            const jenis_kelamin = $('#jenis_kelamin').val()

            if(nama == "") {
                Swal.fire('Nama Pelanggan Harus Diisi!')
                return false;
            } else {
                $('#nama').val();
            }

            if(alamat == "") {
                Swal.fire('Alamat Pelanggan Harus Diisi!')
                return false;
            } else {
                $('#alamat').val();
            }

            if(tlp == "") {
                Swal.fire('Telepon Pelanggan Harus Diisi!')
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
        })
    </script>
    <script>
        $(document).ready(function(){
        $('#formModalPelanggan').on("show.bs.modal", function(e){
            e.backdrop = 'static'
            e.keyboard = false
            const btn = $(e.relatedTarget)
            const id_pelanggan = btn.data('id_pelanggan')
            const nama_pelanggan = btn.data('nama_pelanggan')
            const alamat = btn.data('alamat')
            const tlp = btn.data('tlp')
            const jenis_kelamin = btn.data('jenis_kelamin')
            const id_perusahaan = btn.data('id_perusahaan')
            const mode = btn.data('mode')
            const modal = $(this)
            const url = btn.data('route')
        
            if(mode === 'edit'){
                modal.find('#modal-title').text("Edit Data pelanggan")
                modal.find('.modal-body #nama').val(nama_pelanggan)
                modal.find('.modal-body #alamat').val(alamat)
                modal.find('.modal-body #tlp').val(tlp)
                modal.find('.modal-body #jenis_kelamin').val(jenis_kelamin)
                modal.find('.modal-footer #btn-submit').text('Update')
                $('#formModalPelanggan form').attr('action', url);
                modal.find('.modal-body #method').html('{{ method_field('PATCH') }}')
            } else {
                $('#formModalPelanggan form')[0].reset();
                // $('#formModalPelanggan form').attr('action', url);
                $('#formModalPelanggan [name=_method]').val('post');
                modal.find('#modal-title').text("Tambah Data pelanggan")
                modal.find('.modal-body #id_pelanggan').val('')
                modal.find('.modal-body #nama_pelanggan').val('')
                modal.find('.modal-footer #btn-submit').text('Submit')
                modal.find('.modal-body #method').html('')
            }
          });
        });

        // function addForm(url) {
        //     // $('#modal-form').trigger('reset');
        //     $('#modal-form').modal('show');
        //     $('#modal-form .modal-title').text('Tambah Pelanggan');

        //     $('#modal-form form')[0].reset();
        //     $('#modal-form form').attr('action', url);
        //     $('#modal-form [name=_method]').val('post');
        //     $('#modal-form [name=nama]').focus();
        // }

        // $(document).on('click', '.edit', function (event) {
        //     let nama_pelanggan = $(this).data('nama_pelanggan')
        //     let alamat = $(this).data('alamat')
        //     var tlp = $(this).data('tlp')
        //     var jenis_kelamin = $(this).data('jenis_kelamin')
        //     let url = $(this).data('route')
        //     // console.log(keterangan)

        //     var data = {
        //         nama_pelanggan : nama_pelanggan,
        //         alamat : alamat,
        //         tlp: tlp,
        //         jenis_kelamin: jenis_kelamin,
        //         url: url
        //     }

        //     editForm(data)
        // })
        
        // function editForm(data) {
        //     $('#modal-form').modal('show')
        //     $('#modal-form .modal-title').text('Edit Pelanggan');
        //     $('#modal-form form')[0].reset();
            
        //     $('#modal-form [name=nama]').val(data.nama_pelanggan);
        //     $('#modal-form [name=alamat]').val(data.alamat);
        //     $('#modal-form [name=tlp]').val(data.tlp);
        //     $('#modal-form [name=jenis_kelamin]').val(data.jenis_kelamin);

        //     $('#modal-form form').attr('action', data.url);
        //     $('#modal-form').setAttribute("method", "PUT");
        // }
         
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
        $('#tlp').on('keypress', function(e){
            restrictWord(e);
        });
    </script>
@endpush