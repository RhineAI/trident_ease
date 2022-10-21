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
                    <button onclick="addForm('{{ route('kas-masuk.store') }}')" class="btn btn-primary mx-2 my-3"><i
                            class="fa fa-plus-circle"></i>
                        Tambah</button>
                </div>
    
                <div class="box-body table-responsive">
                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                            <div class="table-responsive ">
                                <table class="table table-bordered table-striped align-items-center table-flush table-hover text-center" id="dataTableHover">
                                    <thead class="thead-secondary">
                                        <tr>
                                            <th width="3%" class="text-center">No</th>
                                            <th width="4%" class="text-center">Tanggal</th>
                                            <th width="10%" class="text-center">Jumlah</th>
                                            <th width="10%" class="text-center">Oleh</th>
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
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Kas Masuk');
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
                {data:'action', searchable: false, sortable: false},
            ]
        });
        
        $(document).on('click', '.edit', function (event) {
            let jumlah = $(this).data('jumlah')
            let url = $(this).data('route')

            let data = {
                jumlah : jumlah,
                url: url
            }

            editForm(data)
        })
        
        function editForm(data) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Kas Masuk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', data.url);
            $('#modal-form [name=_method]').val('put');
            
            $('#modal-form [name=jumlah]').val(data.jumlah);
        }

</script>
@endpush