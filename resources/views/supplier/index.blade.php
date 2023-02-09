@extends('templates.layout')

@section('title')
    <title>Supplier | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Supplier
@endsection

@section('breadcrumb')
@parent
    Supplier
@endsection

@push('styles')
    
@endpush

@section('contents')
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
                <div class="box-body table-responsive ">
                <h2 class="text-center mt-3 mb-2">Data Supplier</h2>
                  <button type="button" class="btn btn-primary ml-4 mb-4 mt-3" data-toggle="modal" data-target="#formModalSupplier">
                      <i class="fas fa-plus"></i>&nbsp; Tambah Data
                  </button>
                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            @include('supplier.data')
                        </div>
                    </div>
                </div>
  
            </div>
        </div>
    </div>
</section>
@include('supplier.form')
@endsection

@push('scripts')
    <script>
        $('#tbl-data-supplier').DataTable();

        $('body').addClass('sidebar-collapse');
    </script>
    <script>
        $(document).ready(function(){
          $('#formModalSupplier').on("show.bs.modal", function(e){
            const btn = $(e.relatedTarget)
            const id_supplier = btn.data('id_supplier')
            const nama = btn.data('nama')
            const alamat = btn.data('alamat')
            const tlp = btn.data('tlp')
            const salesman = btn.data('salesman')
            const bank = btn.data('bank')
            const no_rekening = btn.data('no_rekening')
            const id_perusahaan = btn.data('id_perusahaan')
            const mode = btn.data('mode')
            const modal = $(this)
            const url = btn.data('route')
        
            if(mode === 'edit'){
                modal.find('#modal-title').text("Edit Data supplier")
                modal.find('.modal-body #nama').val(nama)
                modal.find('.modal-body #alamat').val(alamat)
                modal.find('.modal-body #tlp').val(tlp)
                modal.find('.modal-body #salesman').val(salesman)
                modal.find('.modal-body #bank').val(bank)
                modal.find('.modal-body #no_rekening').val(no_rekening)
                modal.find('.modal-body #id_perusahaan').val(id_perusahaan)
                modal.find('.modal-footer #btn-submit').text('Update')
                $('#formModalSupplier form').attr('action', url);
                // modal.find('.modal-body form').attr('action', '/supplier/' + id_supplier)
                modal.find('.modal-body #method').html('{{ method_field('PATCH') }}')
            } else {
                $('#formModalSupplier form')[0].reset();
                // $('#formModalSupplier form').attr('action', url);
                $('#formModalSupplier [name=_method]').val('post');
                modal.find('#modal-title').text("Tambah Data supplier")
                modal.find('.modal-body #id_supplier').val('')
                modal.find('.modal-body #nama_supplier').val('')
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
        <script>
            $('div.other').hide();
            $(document).on('change', '#bank', function () {  
                var isiSelect = $("#bank").val();

                // console.log(isiSelect)
                if (isiSelect == 'Other') {
                    // console.log(isiSelect)
                    $('div.other').show();
                } else {
                    $('div.other').hide();
                }
            });
            $('#nama').on('keypress', function(e){
                restrictChar(e);
            });
            $('#alamat').on('keypress', function(e){
                restrictChar(e);
            });
            $('#salesman').on('keypress', function(e){
                restrictChar(e);
            });
            $('#other').on('keypress', function(e){
                restrictChar(e);
            });
            $('#no_rekening').on('keypress', function(e){
                restrictWord(e);
            });
            $('#tlp').on('keypress', function(e){
                restrictWord(e);
            });
        </script>
@endpush