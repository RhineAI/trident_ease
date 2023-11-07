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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Vendor CSS-->
    <link href="{{ asset('templates') }}/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="{{ asset('templates') }}/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    {{-- <link href="{{ asset('templates') }}/css/main.css" rel="stylesheet" media="all"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.css" rel="stylesheet"/>
    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import '~mdb-ui-kit/css/mdb.min.css';
        #bgBlueLightWhiteColor {
          background: #4178D5; 
        }
    </style>
</head>

<body style="background-color: #4178D5;">
    <section class="vh-100" style="background-color: #4178D5;">
        <div class="container h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
              <div class="card text-black" style="border-radius: 25px;">
                <div class="card-body p-md-5">
                  <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-6 order-2 order-lg-1">
                      <p class="text-center h1 fw-bold mb-4 mx-1 mx-md-4">Register</p>

                      <form class="mx-1 mx-md-4" method="POST" id="form-register" enctype="multipart/form-data" action="{{ route('register') }}">
                        @csrf
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <input type="text" class="form-control" id="nama" name="nama" />
                            <label class="form-label" for="form3Example1c">Nama Perusahaan</label>
                            <input type="hidden" id="check">
                          </div>
                        </div>
                        {{-- <small id="messageTrue" style="color:green; margin-top: -200px;">Nama Perusahaan Tersedia</small>
                        <small id="messageFalse" style="color:red; margin-top: -200px;">Nama Perusahaan Telah Digunakan, Coba Tambahkan Nama Daerah</small> --}}

                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-map fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <input type="text" class="form-control" id="alamat" name="alamat" />
                            <label class="form-label" for="form3Example3c">Alamat</label>
                          </div>
                        </div>
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <input type="email" class="form-control" id="email" name="email"/>
                            <label class="form-label" for="form3Example4c">E-Mail</label>
                          </div>
                        </div>
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-id-card fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <input type="text" id="npwp" name="npwp" class="form-control" />
                        <label class="form-label" for="form3Example4cd">NPWP (Opsional)</label>
                          </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-user fa-lg me-3 mx-1 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <input type="text" id="pemilik" name="pemilik" class="form-control" />
                            <label class="form-label" for="form3Example4cd">Pemilik</label>
                          </div>

                          <i class="fas fa-phone fa-lg me-3 mx-2 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <input type="text" id="telepon" name="telepon" class="form-control" />
                            <label class="form-label" for="form3Example4cd">Telepon</label>
                          </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-building-columns mx-1 fa-lg me-3 fa-fw"></i>
                            <div class="form col-md-12 flex-fill mb-0">
                                <select name="bank" id="bank" class="form-select">
                                    <option disabled="disabled" selected="selected">Bank (Opsional)</option>
                                    <option value="Bank BRI">BRI</option>
                                    <option value="Bank BNI">BNI</option>
                                    <option value="Bank BJB">BJB</option>
                                    <option value="Bank BCA">BCA</option>
                                    <option value="Bank Permata">Permata</option>
                                    <option value="Bank Muamalat">Muamalat</option>
                                    <option value="Other">Lainnya</option>
                                </select>
                                <div class="select-dropdown"></div>
                            </div>

                            <i class="fas fa-key fa-lg me-3 mx-2 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                              <input type="text" id="rekening" name="no_rekening" class="form-control" />
                              <label class="form-label" for="rekening">Rekening (Opsional)</label>
                            </div>
                        </div>

                        <div id="displayOther">
                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-building-columns mx-1 fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                  <input type="text" id="other" name="other" class="form-control" placeholder="Bank Lainnya" />
                                  <label class="form-label" for="form3Example4cd">Bank Lainnya (Opsional)</label>
                                </div>
                            </div>
                        </div>
                       

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-quote-left fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                              <input type="text" id="slogan" name="slogan" class="form-control" />
                              <label class="form-label" for="form3Example4cd">Slogan (Opsional)</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-1">
                            <i class="fas fa-image fa-lg me-3 mx fa-fw"></i>
                            <div class="form flex-fill mb-0">
                                <input class="form-control" type="file" id="image" name="logo" onchange="previewImage()">
                                <small style="color:grey; font-size:11px;" class="text-muted">Max 4mb</small>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center mb-1">
                            <i class="fas fa-ke fa-lg me-3 mx-3 fa-fw"></i>
                            <div class="form flex-fill mb-0">
                                <img class="img-preview img-fluid my-3 col-sm-5" width="300" >
                            </div>
                        </div>
      
                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                          <button type="submit" class="btn btn-primary btn-lg">Daftar</button>
                        </div>
      
                      </form>
      
                    </div>
                    <div class="col-md-10 col-lg-6 col-xl-6 d-flex align-items-center order-1 order-lg-2">
      
                      <img src="assets/img/register.png"
                        class="img-fluid" alt="Sample image">
                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    <!-- Jquery JS-->
    <script src="{{ asset('templates') }}/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="{{ asset('templates') }}/vendor/select2/select2.min.js"></script>
    <script src="{{ asset('templates') }}/vendor/datepicker/moment.min.js"></script>
    <script src="{{ asset('templates') }}/vendor/datepicker/daterangepicker.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.js"></script>

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
            const pemilik = $('#pemilik').val()
            const telepon = $('#telepon').val()
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

            if(pemilik == "") {
                Swal.fire('Nama Owner Harus Diisi!')
                return false;
            } else {
                $('#pemilik').val();
            }
        });

        $('div#displayOther').hide();
        $(document).on('change', '#bank', function () {  
            var isiSelect = $("#bank").val();

            // console.log(isiSelect)
            if (isiSelect == 'Other') {
                // console.log(isiSelect)
                $('div#displayOther').show();
            } else {
                $('div#displayOther').hide();
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
</body>


</html>
<!-- end document-->
