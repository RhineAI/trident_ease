@if (auth()->user()->hak_akses == 'super_admin') 
    @extends('templates.layout')

    @section('title')
        <title>Perusahaan | {{ $cPerusahaan->nama }}</title>
    @endsection

    @section('page')
        Perusahaan
    @endsection

    @section('breadcrumb')
    @parent
        Perusahaan
    @endsection

    @push('styles')
        <style>
            .tn {
                visibility: hidden;
            }
            .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 24px;
            }

            /* Style untuk slider */
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                border-radius: 24px;
                transition: .4s;
            }

            /* Style untuk menggeser slider saat toggle aktif */
            .slider:before {
                position: absolute;
                content: "";
                height: 16px;
                width: 16px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                border-radius: 50%;
                transition: .4s;
            }

            /* Style saat toggle aktif */
            input:checked + .slider {
                background-color: #2196F3;
            }

            /* Style saat toggle aktif dan slider digeser ke kanan */
            input:checked + .slider:before {
                    transform: translateX(16px);
            }

        </style>
    @endpush

    @section('contents')
    <section class="content">
        <div class="row mx-3">
            <div class="col-md-12 p-2 mb-3" style="background-color: white">
                <div class="box mb-4">
                    <div class="d-flex mr-3" style="float: right;">
                        <small class="my-1">Destroy Mode &nbsp;</small>
                        <label class="switch"> 
                            <input type="checkbox" id="toggleSwitch" onchange="showingDelete()" style="visibility: hidden;">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="box-body table-responsive ">
                        <h2 class="text-center mt-3 mb-4">Perusahaan</h2>
                        {{-- <button type="button" class="btn btn-primary ml-4 mb-4 mt-3 tn" data-toggle="modal" data-target="#formModalSatuan">
                            <i class="fas fa-plus"></i>&nbsp; Tambah Data
                        </button> --}}
                        <div class="col-lg-12">
                            <div class="table-responsive p-3">
                                <div class="box-body table-responsive">
                                    <table class="table table-hover dt-responsive text-center">
                                        <thead class="table-success">
                                            <tr>
                                                <td class="text-center" width="7.4%">ID</td>
                                                <td class="text-center">Perusahaan</td>
                                                <td class="text-center">Pemilik</td>
                                                <td class="text-center">Email</td>
                                                <td class="text-center">Telepon</td>
                                                <td class="text-center">Grade</td>
                                                <td class="text-center">Dibuat</td>
                                                <td class="text-center">Masa Berlaku</td>
                                                <td class="text-center">Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($perusahaan as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->pemilik }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->tlp }}</td>
                                                    @if ($item->grade == 1) 
                                                        <td><span class="badge badge-primary">Free</span></td>
                                                    @elseif($item->grade == 2) 
                                                        <td><span class="badge" style="background-color:#81d6b0;">Plus</span></td>
                                                    @elseif($item->grade == 3)
                                                        <td><span class="badge badge-danger">Pro</span></td>
                                                    @endif
                                                    <td>{{ $item->created_at->diffForHumans() }}</td>
                                                    @if ($item->expiredDate === '0000-00-00')
                                                        <td>-</td>
                                                    @else
                                                        <td>{{ $item->expiredDate }}</td>
                                                    @endif
                                                    <td>
                                                        <div class="btn-group">
                                                            <button data-mode ="edit"
                                                                    data-nama="{{ $item->nama }}" 
                                                                    data-pemilik="{{ $item->pemilik }}"
                                                                    data-tlp="{{ $item->tlp }}"
                                                                    data-npwp="{{ $item->npwp }}"
                                                                    data-email="{{ $item->email }}"
                                                                    data-grade="{{ $item->grade }}"
                                                                    data-expired_date="{{ $item->expiredDate }}"
                                                                    data-route="{{ route('super_admin.manage-perusahaan.update', $item->id) }}" class="mx-1 edit btn btn-xs btn-warning"><i class="fas fa-light fa-pencil-square"></i>
                                                            </button>
                                                            <button type="button" class="d-none btn btn-xs btn-danger delete" id="deleteButton" data-route="{{ route('super_admin.manage-perusahaan.destroy', $item->id) }}" data-nama="{{ $item->nama }}" data-id="{{ $item->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('super-admin.perusahaan.form')
    @endsection

    @push('scripts')
        <script>
            function showingDelete() {
                var slider = document.getElementById('toggleSwitch');

                if (slider.checked) {
                    $('#deleteButton').fadeIn(300)
                    $('#deleteButton').removeClass('d-none'); 
                } else {
                    $('#deleteButton').fadeOut(300)
                }
            }
           $('#expiredDate').on('change', function() {
                var inputDate = Date.parse($(this).val());
                var todayDate = Date.parse(new Date());

                if (inputDate <= todayDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal tidak valid!',
                        text: 'Tanggal Kadaluwarsa tidak boleh melebihi tanggal hari ini.',
                    }).then(function() {
                        var tomorrowDate = new Date(todayDate);
                        tomorrowDate.setDate(tomorrowDate.getDate() + 1);

                        var formattedDate = tomorrowDate.toISOString().slice(0, 10);
                        $('#expiredDate').val(formattedDate);
                    });
                }
            });

            const deleteData = async function(id, nama, route) {
                Swal.fire({
                    title: 'Hapus Perusahaan '+nama+'?',
                    icon: 'question',
                    iconColor: '#DC3545',
                    showDenyButton: true,
                    denyButtonColor: '#838383',
                    denyButtonText: 'Batal',
                    confirmButtonText: 'Hapus',
                    confirmButtonColor: '#DC3545'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.post(route, {
                            '_token': $('[name=csrf-token]').attr('content'),
                            '_method': 'delete',
                            'id' : id
                        })
                        .done((response) => {
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Perusahaan '+nama+' berhasil dihapus',
                                icon: 'success',
                                confirmButtonText: 'Lanjut',
                                confirmButtonColor: '#28A745'
                            }) 
                            location.reload();
                        })
                        .fail((errors) => {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi Kesalahan Server',
                                icon: 'error',
                                confirmButtonText: 'Kembali',
                                confirmButtonColor: '#DC3545'
                            })                       
                            return;
                        });
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: 'Perusahaan '+nama+' batal dihapus',
                            icon: 'warning',
                        })
                    }
                })
            }

            $(document).on('click', '.delete', function (e) {
                let id = $(this).data('id')
                let nama = $(this).data('nama')
                let route = $(this).data('route')
                deleteData(id, nama, route)
            })

            // $('.table').DataTable();
            $('body').addClass('sidebar-collapse');

            $('.table').DataTable({
                order: [[5, 'desc']]
            });
            // let table;
            //     table = $('.table').DataTable({
            //     processing: true,
            //     responsive: true,
            //     autoWidth: false,
            //     serverSide: true,
            //     ajax: {
            //         url: "",
            //         type: "POST",
            //         data: {  
            //             _token: '{{ csrf_token() }}'
            //         }
            //     },
            //     columns: [
            //         {data:'DT_RowIndex', searchable: false, sortable: false},
            //         {data:'nama'},
            //         {data:'pemilik'},
            //         {data:'email'},
            //         {data:'tlp'},
            //         {data:'grade'},
            //         {data:'created_at'},
            //         {data:'action', searchable: false, sortable: false},
            //     ]
            // });

            $(document).on('click', '.edit', function (event) {
                let nama = $(this).data('nama')
                let pemilik = $(this).data('pemilik')
                let grade = $(this).data('grade')
                let email = $(this).data('email')
                let tlp = $(this).data('tlp')
                let npwp = $(this).data('npwp')
                let expired_date = $(this).data('expired_date')
                let url = $(this).data('route')
                console.log(url)

                let data = {
                    nama : nama,
                    pemilik : pemilik,
                    grade : grade,
                    email : email,
                    tlp : tlp,
                    npwp : npwp,
                    url: url
                }

                $('#modal-form').modal('show')
                $('#modal-form .modal-title').text('Manage Perusahaan');

                // $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', data.url);
                $('#modal-form [name=_method]').val('patch');
                console.log(expired_date);

                $('#modal-form [name=nama]').val(data.nama);
                $('#modal-form [name=pemilik]').val(data.pemilik);
                $('#modal-form [name=grade]').val(data.grade);
                $('#modal-form [name=email]').val(data.email);
                $('#modal-form [name=tlp]').val(data.tlp);
                $('#modal-form [name=expiredDate]').val(data.expired_date);
            })
        </script>
    @endpush
@else
    @section('contents')
    <style>
        body {
            background-color: #eee
        }

        .card {
            border: none;
            border-radius: 10px
        }

        .c-details span {
            font-weight: 300;
            font-size: 13px
        }

        .icon {
            width: 50px;
            height: 50px;
            background-color: #eee;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 39px
        }

        .badge span {
            background-color: #fffbec;
            width: 60px;
            height: 25px;
            padding-bottom: 3px;
            border-radius: 5px;
            display: flex;
            color: #fed85d;
            justify-content: center;
            align-items: center
        }

        .progress {
            height: 10px;
            border-radius: 10px
        }

        .progress div {
            background-color: red
        }

        .text1 {
            font-size: 14px;
            font-weight: 600
        }

        .text2 {
            color: #a5aec0
        }

    </style>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <div class="container mt-5 mb-3">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <div class="card p-3 mb-2">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <div class="icon"> <i class="bx bxs-info-circle"></i> </div>
                            {{-- <div class="ms-2 c-details">
                                <h6 class="mb-0">Dribbble</h6> <span>4 days ago</span>
                            </div> --}}
                        </div>
                        <div class="badge text-danger"> <span class="text-danger">Sorry</span> </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="heading text-center">You Don't Have<br>Permission to Access this page</h3>
                        <div class="mt-5">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            {{-- <div class="mt-3"> <span class="text1">42 Applied <span class="text2">of 70 capacity</span></span> </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    @endsection
@endif