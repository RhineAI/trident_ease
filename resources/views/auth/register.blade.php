<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="ZiePOS">
    <meta name="author" content="ZiePOS">
    <meta name="keywords" content="ZiePOS">
    <link rel="icon" href="{{ asset('assets') }}/img/ziepos.png" type="image/png">


    <!-- Title Page-->
    <title>Register | Aplikasi POS</title>

    <!-- Icons font CSS-->
    <link href="{{ asset('templates') }}/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="{{ asset('templates') }}/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="{{ asset('templates') }}/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="{{ asset('templates') }}/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('templates') }}/css/main.css" rel="stylesheet" media="all">

    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #bgBlueLightWhiteColor {
          background: #4178D5; 
        }
    </style>
</head>

<body id="bgBlueLightWhiteColor">
    <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w500">
            <div class="card card-1">
                <div class="card-heading text-center">
                    {{-- <img src="/assets/img/register.png" alt="" width="200" class="align-items-center"> --}}
                </div>
                <div class="card-body">
                    <h2 class="title">Form Registrasi</h2>
                    <form method="POST" id="form-register" enctype="multipart/form-data" action="{{ route('register') }}">
                        @csrf
                        @method('post')
                        <div class="input-group">
                            <input class="input--style-1" id="nama" type="text" placeholder="NAMA PERUSAHAAN" name="nama">
                            {{-- <small id="messageTrue" style="color:green;">Nama Perusahaan Tersedia</small>
                            <small id="messageFalse" style="color:red;">Nama Perusahaan Telah Digunakan, Coba Tambahkan Nama Daerah</small> --}}
                            <input type="hidden" id="check">
                        </div>
                        <div class="input-group">
                            <input class="input--style-1" id="alamat" type="text" placeholder="ALAMAT PERUSAHAAN" name="alamat">
                        </div>
                        <div class="input-group">
                            <input class="input--style-1" id="email" type="email" placeholder="EMAIL PERUSAHAAN" name="email">
                        </div>
                        <div class="input-group">
                            <input class="input--style-1" id="npwp" minlength="6" type="number" placeholder="NPWP" name="npwp">
                        </div>
             
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" id="pemilik" type="text" placeholder="NAMA PEMILIK" name="pemilik">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" id="telepon" maxlength="13" type="number" placeholder="TELEPON" name="telepon">
                                </div>
                            </div>
                        </div>

                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="bank" id="bank">
                                            <option disabled="disabled" selected="selected">BANK</option>
                                            <option value="Bank BRI">Bank BRI</option>
                                            <option value="Bank BNI">Bank BNI</option>
                                            <option value="Bank BJB">Bank BJB</option>
                                            <option value="Bank BCA">Bank BCA</option>
                                            <option value="Bank Permata">Bank Permata</option>
                                            <option value="Bank Muamalat">Bank Muamalat</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" id="rekening" type="number" placeholder="NO. REKENING" name="no_rekening">
                                </div>
                            </div>
                        </div>
                        <div class="input-group other" style="padding-top:-50px;">
                            <input type="text" name="other" id="other" placeholder="BANK PERUSAHAAN" class="input--style-1">
                        </div>
                        {{-- <div class="input-group">
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select name="class">
                                    <option disabled="disabled" selected="selected">CLASS</option>
                                    <option>Class 1</option>
                                    <option>Class 2</option>
                                    <option>Class 3</option>
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                        </div> --}}
                            <div class="input-group" style="padding-top:-50px;">
                                <input class="input--style-1" id="slogan" type="text" placeholder="SLOGAN (OPSIONAL)" name="slogan">
                            </div>

                            <div class="form-group row mb-2">
                                <div class="mb-3">
                                    <p style="color:#636060;">LOGO PERUSAHAAN</p><br>
                                    <input class="form-control" type="file" id="image" name="logo" onchange="previewImage()">
                                    <small style="color:grey; font-size:11px;" class="text-muted">Max 4mb</small>
                                </div>
                            </div>
                            <br>
                            <img class="img-preview img-fluid my-3 col-sm-5" width="250" >
                            <br>
                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" type="submit" id="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('templates') }}/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="{{ asset('templates') }}/vendor/select2/select2.min.js"></script>
    <script src="{{ asset('templates') }}/vendor/datepicker/moment.min.js"></script>
    <script src="{{ asset('templates') }}/vendor/datepicker/daterangepicker.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Main JS-->
    <script src="{{ asset('templates') }}/js/global.js"></script>

    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $('#form-register').on('submit', function(){
            const check = $('#check').val()
            const nama = $('#nama').val()
            const alamat = $('#alamat').val()
            const email = $('#email').val()
            const npwp = $('#npwp').val()
            const pemilik = $('#pemilik').val()
            const telepon = $('#telepon').val()
            const rekening = $('#rekening').val()
            const bank = $('#bank').val()
            const other = $('#other').val()
            const slogan = $('#slogan').val()

            if(check === "false") {
                Swal.fire({
                    icon: 'error',
                    title: 'Nama Perusahaan telah digunakan!',
                    text: 'Coba tambahkan karakter unik, seperti nama Daerah',
                })
                return false;
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

            if(npwp == "") {
                Swal.fire('NPWP Harus Diisi!')
                return false;
            } else {
                $('#npwp').val();
            }

            if(pemilik == "") {
                Swal.fire('Nama Owner Harus Diisi!')
                return false;
            } else {
                $('#pemilik').val();
            }

            if(bank == null || other == "") {
                Swal.fire('Kolom Bank Harus Diisi!')
                return false;
            } else {
                $('#bank').val();
            }

            if(rekening == "") {
                Swal.fire('No Rekening Harus Diisi!')
                return false;
            } else {
                $('#rekening').val();
            }
        });

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

        $('#messageTrue').hide()
        $('#messageFalse').hide()

        $('#nama').on('change', function(){
            $.ajax({
                type: 'POST',
                url:  '/getPerusahaan',
                data: {
                    _token: "{{ csrf_token() }}",
                    nama: $('#nama').val()
                },
                cache: false,
                success: function(response){
                    console.log(response)
                    if(response === 'true'){
                        $('#messageTrue').show()
                        $('#messageFalse').hide()
                        $('#check').val("true")
                    } else {                       
                        Swal.fire({
                            icon: 'error',
                            title: 'Nama Perusahaan telah digunakan!',
                            text: 'Coba tambahkan karakter unik, seperti nama Daerah',
                        })
                        $('#check').val("false")
                    }
                }
            })
        });
    </script>

    <script>
        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');
    
            imgPreview.style.display = 'block';
    
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
    
            oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
      }

        @if(session()->has('success'))
            toastr.success('{{ session('success') }}', 'TERIMA KASIH!'); 

        @elseif(session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!'); 
        @endif

        $('#nama').on('keypress', function(e){
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
        $('#pemilik').on('keypress', function(e){
            restrictChar(e);
        });
        $('#telepon').on('keypress', function(e){
            restrictWord(e);
        });
        $('#npwp').on('keypress', function(e){
            restrictWord(e);
        });
        $('#rekening').on('keypress', function(e){
            restrictWord(e);
        });

        function restrictChar(e) {
            const input = e.target;
            const regex = new RegExp("^[<>?/|$=:;+}([){#]*$");

            input.addEventListener("beforeinput", (event) => {
            if (event.data != null && regex.test(event.data)) 
                event.preventDefault();
            });
        }
        
        function restrictWord(e) {
            const input = e.target;
            const regex = new RegExp("^[0-9_ ]*$");

            input.addEventListener("beforeinput", (event) => {
            if (event.data != null && !regex.test(event.data)) 
                event.preventDefault();
            });
        }

    </script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->
