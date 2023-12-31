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

@endpush

@section('contents')
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
              <h2 class="text-center mt-3 mb-5">Set Perusahaan</h2>
                <div class="box-body table-responsive d-flex">
                    <div class="col-lg-12 justify-content-center">
                        @if (Auth::user()->hak_akses == 'owner') 
                            <form action="{{ route('owner.perusahaan.store') }}" method="POST" enctype="multipart/form-data" id="form-perusahaan">
                        @elseif ((Auth::user()->hak_akses == 'admin'))
                            <form action="{{ route('admin.perusahaan.store') }}" method="POST" enctype="multipart/form-data" id="form-perusahaan">
                        @endif
                            @csrf
                            <input type="hidden" name="id" value="{{ $cPerusahaan->id }}">
                            <div class="form-group row">
                                <div class="form-group" style="width: 95%; margin: auto;">
                                    <label for="nama">Nama Perusahaan</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Perusahaan" name="nama"
                                        value="{{ $cPerusahaan->nama }}">
                                    <input type="hidden" id="namaAwal" value="{{ $cPerusahaan->nama }}">
                                    <input type="hidden" id="check">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="form-group" style="width: 95%; margin: auto;">
                                    <label for="alamat">Alamat Perusahaan</label>
                                    <textarea type="text" class="form-control" id="alamat" placeholder="Alamat Perusahaan" cols="6" rows="3"
                                        name="alamat" value="">{{ $cPerusahaan->alamat }}</textarea>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="form-group col-md-5" style="width: 95%; margin: auto;">
                                    <label for="pemilik">Pemilik Perusahaan</label>
                                    <input type="text" class="form-control" id="pemilik" placeholder="Pemilik Perusahaan"
                                        name="pemilik" value="{{ $cPerusahaan->pemilik }}">
                                </div>
                                <div class="form-group col-md-6" style="width: 95%; margin: auto;">
                                    <label for="tlp">Telepon Perusahaan</label>
                                    <input type="number" class="form-control" id="tlp" placeholder="Telepon Perusahaan" name="tlp"
                                        value="{{ $cPerusahaan->tlp }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="form-group col-md-5" style="width: 95%; margin: auto;">
                                    <label for="email">Email Perusahaan</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email Perusahaan" name="email"
                                        value="{{ $cPerusahaan->email }}">
                                </div>
                                <div class="form-group col-md-6" style="width: 95%; margin: auto;">
                                    <label for="npwp">NPWP Perusahaan</label>
                                    <input type="text" class="form-control" id="npwp" placeholder="NPWP Perusahaan" name="npwp"
                                        value="{{ $cPerusahaan->npwp }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="form-group col-md-5" style="width: 95%; margin: auto;">
                                    <label for="bank">Bank Perusahaan</label>
                                    <div class="input-group">
                                        {{-- <select name="bank" id="bank" class="form-control" required value="{{ $cPerusahaan->bank }}">
                                            <option disabled="disabled" selected="selected">BANK</option>
                                            <option value="Bank BRI">Bank BRI</option>
                                            <option value="Bank BNI">Bank BNI</option>
                                            <option value="Bank BJB">Bank BJB</option>
                                            <option value="Bank BCA">Bank BCA</option>
                                            <option value="Bank Permata">Bank Permata</option>
                                            <option value="Bank Muamalat">Bank Muamalat</option>
                                            <option value="Other">Other</option>
                                        </select> --}}
                                        <select name="bank" id="bank" class="form-control" required>
                                            <option disabled selected>BANK</option>
                                            @php
                                                $banks = ['Bank BRI', 'Bank BNI', 'Bank BJB', 'Bank BCA', 'Bank Permata', 'Bank Muamalat'];
                                                $isOther = !in_array($cPerusahaan->bank, $banks);
                                            @endphp
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank }}" {{ $cPerusahaan->bank == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                            @endforeach
                                            <option value="Other" {{ $isOther ? 'selected' : '' }}>Other</option>
                                            <input type="hidden" id="isOther" value="{{ $isOther }}">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6" style="width: 95%; margin: auto;">
                                    <label for="no_rekening">No Rekening Perusahaan</label>
                                    <input type="text" class="form-control" id="no_rekening" placeholder="No Rekening Perusahaan"
                                        name="no_rekening" value="{{ $cPerusahaan->no_rekening }}">
                                </div>
                            </div>

                            <div class="form-group row other">
                                <div class="form-group" style="width: 95%; margin:auto;">
                                    <label for="other">Bank Lainnya</label>
                                    {{-- <input type="text" name="other" id="other" class="form-control" placeholder="BANK PERUSAHAAN" class="input--style-1"> --}}
                                    <input type="text" name="other" id="other" class="form-control" placeholder="BANK PERUSAHAAN" class="input--style-1" value="{{ $isOther ? $cPerusahaan->bank : '' }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="form-group" style="width: 95%; margin: auto;">
                                    <label for="slogan">Slogan Perusahaan</label>
                                    <input type="text" class="form-control" id="slogan" placeholder="Slogan Perusahaan"
                                        name="slogan" value="{{ $cPerusahaan->slogan }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="file">Logo Sebelumnya</label>
                                    <br>
                                    <img src="{{ asset('storage/img/' . $cPerusahaan->logo) }}" alt="{{ $cPerusahaan->nama }}" width="200">
                                    <input type="file" name="logo" id="file" style="display: none;" class="form-control">
            
                                </div>
                                <div class="col-md-6">
                                    <label>Logo Baru | <a href="#" id="fileSelect">Pilih Logo Baru</a></label>
                                    <div id="fileDisplay" style="margin-top: 15px;">
                                        <i style="font-size:14px;">Logo Baru Belum Dipilih</i>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 mt-2"></div>
                            <div class="mt-3 mb-2 mx-5" style="float: right;">
                                <button type="button" id="tombol" class="btn btn-primary" style="display: none; margin-left: 0,25rem; margin-right: 10px;">Reset Image</a>
                                <button type="submit" class="btn btn-outline-primary" id="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="/assets/js/previewImage.js"></script>
<script>
    var isOther = $('#isOther').val()

    if(isOther == false){
        $('div.other').hide();
    }
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

    var namaAwal = $('#namaAwal').val()
    var namaBaru = $('#nama').val()

    $('#messageTrue').hide()
    $('#messageFalse').hide()

    $('#nama').on('change', function(){
        namaBaru = $('#nama').val()
        $.ajax({
            type: 'POST',
            url:  '/getPerusahaan',
            data: {
                _token: "{{ csrf_token() }}",
                nama: $('#nama').val()
            },
            cache: false,
            success: function(response){
                // console.log($('#nama').val())
                if(response === 'true'){
                    $('#messageTrue').show()
                    $('#messageFalse').hide()
                    $('#check').val("true")
                } else {  
                    if(namaAwal != namaBaru){
                        Swal.fire({
                            icon: 'error',
                            title: 'Nama Perusahaan telah digunakan!',
                            text: 'Coba tambahkan karakter unik, seperti nama Daerah',
                        })
                        $('#check').val("false")
                    }                     
                    $('#check').val("true")
                }
            }
        })
    });

    $('#form-perusahaan').on('submit', function(){
            const check = $('#check').val()
            const nama = $('#nama').val()
            const alamat = $('#alamat').val()
            const email = $('#email').val()
            const npwp = $('#npwp').val()
            const pemilik = $('#pemilik').val()
            const telepon = $('#telepon').val()
            const rekening = $('#rekening').val()
            let bank = $('#bank').val()
            const other = $('#other').val()
            const slogan = $('#slogan').val()

            if(check === "false") {
                if(namaAwal != namaBaru){
                    Swal.fire({
                        icon: 'error',
                        title: 'Nama Perusahaan telah digunakan!',
                        text: 'Coba tambahkan karakter unik, seperti nama Daerah',
                    })
                    return false;
                }
                $('#nama').val();
            } else {
                $('#nama').val();
            }

            if(nama == "") {
                Swal.fire('Nama Perusahaan Harus Diisi!')
                return false;
            } else {
                $('#nama').val();
            }

            if(alamat == "") {
                Swal.fire('Alamat Perusahaan Harus Diisi!')
                return false;
            } else {
                $('#alamat').val();
            }

            if(email == "") {
                Swal.fire('Email Perusahaan Harus Diisi!')
                return false;
            } else {
                $('#email').val();
            }

            if(telepon == "") {
                Swal.fire('Telepon Perusahaan Harus Diisi!')
                return false;
            } else {
                $('#telepon').val();
            }

            // if(npwp == "") {
            //     Swal.fire('NPWP Harus Diisi!')
            //     return false;
            // } else {
            //     $('#npwp').val();
            // }

            if(pemilik == "") {
                Swal.fire('Nama Owner Harus Diisi!')
                return false;
            } else {
                $('#pemilik').val();
            }

            // if(bank == null) {
            //     Swal.fire('Kolom Bank Harus Diisi!')
            //     return false;
            // } else if(bank == "Other") {
            //     if(other == ""){
            //         Swal.fire('Kolom Bank Harus Diisi!')
            //         return false;
            //     } else {
            //         $('#other').val()
            //     }
            // } else {
            //     $('#bank').val();
            // }

            // if(rekening == "") {
            //     Swal.fire('No Rekening Harus Diisi!')
            //     return false;
            // } else {
            //     $('#rekening').val();
            // }
        });

    $('#nama').on('keypress', function(e){
        restrictChar(e);
    });
    $('#alamat').on('keypress', function(e){
        restrictChar(e);
    });
    $('#pemilik').on('keypress', function(e){
        restrictChar(e);
    });
    $('#email').on('keypress', function(e){
        restrictChar(e);
    });
    $('#other').on('keypress', function(e){
        restrictChar(e);
    });
    $('#slogan').on('keypress', function(e){
        restrictChar(e);
    });
    $('#tlp').on('keypress', function(e){
        restrictWord(e);
    });
    $('#no_rekening').on('keypress', function(e){
        restrictWord(e);
    });
    $('#npwp').on('keypress', function(e){
        restrictWord(e);
    });
</script>
@endpush