@extends('templates.layout')

@section('title')
    <title>Kas Keluar | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Kas Keluar
@endsection

@section('breadcrumb')
@parent
    Kas Keluar
@endsection

@push('styles')
    
@endpush

@section('contents')
  
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box">
    
                <div class="box-header with-border mb-3">
                    <button onclick="addForm('{{ route('admin.kas-keluar.store') }}')" class="btn btn-primary mx-2 my-3"><i
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
                                            <th width="2.5%" class="text-center">No</th>
                                            <th width="2.5%" class="text-center">Tanggal</th>
                                            <th width="4.9%" class="text-center">Jumlah</th>
                                            <th width="10%" class="text-center">Keperluan</th>
                                            <th width="5.8%" class="text-center">Oleh</th>
                                            <th width="6%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
@includeIf('kas.kas-keluar.form')
</section>
@endsection

@push('scripts')
<script>
    // $('body').addClass('sidebar-collapse');

    $('document').ready(function() {
        
        // if(jumlah)
    })

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
            $('#modal-form .modal-title').text('Tambah Kas Keluar');

            // $('#modal-form').on('submit', '#jumlah', function() {
            //     // let jumlah = );
            //     // let harga = ;
            //     let biaya = String($('#jumlah').val()).replaceAll(".", '');
            //     let jumlah_kas = String($('#jumlah_kas').val()).replaceAll(".", '');
            //     // console.log(juml);

            //     if(biaya >= jumlah_kas) {
            //         Swal.fire('Pengeluaran melebihi pemasukan!')
            //         return false;
            //     }
            // })

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
                url: "{{ route('admin.kas-keluar.data') }}",
                type: "POST",
                data: {  
                    _token: '{{ csrf_token() }}'
                }
            },
            columns: [
                {data:'DT_RowIndex', searchable: false, sortable: false},
                {data:'tgl'},
                {data:'jumlah'},
                {data:'keperluan'},
                {data:'nama_user'},
                {data:'action', searchable: false, sortable: false},
            ]
        });
        
        $(document).on('click', '.edit', function (event) {
            let jumlah = $(this).data('jumlah')
            let keperluan = $(this).data('keperluan')
            let url = $(this).data('route')

            // $(document).ready(function() {
            //     $("#jumlah_kas").click(function() {
            //         let jumlah_kas = ($(this).val());
            //     });
            // })

            let data = {
                keperluan : keperluan,
                jumlah : jumlah,
                url: url
            }

            editForm(data)
        })
        
        function editForm(data) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Kas Keluar');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', data.url);
            $('#modal-form [name=_method]').val('put');

            let data_kas = $('#jumlah_kas').val();
            var parse = String(data_kas).replaceAll(".", '');
            let perhitungan = data.jumlah + parseInt(parse);
            // let addDot = '.'+String(perhitungan).substr(3.1);
            // let addDot2 = String(perhitungan).substring(0.3);
            // // let add = addDot+'.';
            // console.log(addDot)
            // console.log(addDot2)
            let jumlah_kas = perhitungan.toLocaleString("id-ID", {
                                style:"currency", 
                                currency:"IDR", 
                                maximumSignificantDigits: (perhitungan + '').replace('.', '').length
                            });
            
            $('#modal-form [name=jumlah_kas]').val(jumlah_kas);
            $('#modal-form [name=keperluan]').val(data.keperluan);
            $('#modal-form [name=jumlah]').val(data.jumlah);
            $('#modal-form [name=jumlah]').attr("readonly", "readonly");
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
                            text: 'Data Kas Keluar berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }) 
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Data Kas Keluar gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Kas Keluar batal dihapus',
                        icon: 'warning',
                    })
                }
            })
        }

</script>
<script>
    $('#keperluan').on('keypress', function(e){
        restrictChar(e);
    });
    $('#jumlah').on('keypress', function(e){
        restrictWord(e);
    });
</script>
@endpush