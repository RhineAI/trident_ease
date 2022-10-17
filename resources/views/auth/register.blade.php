<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Au Register Forms by Colorlib</title>

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

</head>

<body>
    <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Registration Info</h2>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('register') }}">
                        @csrf
                        @method('post')
                        <div class="input-group">
                            <input class="input--style-1" required type="text" placeholder="NAMA PERUSAHAAN" name="nama">
                        </div>
                        <div class="input-group">
                            <input class="input--style-1" required type="text" placeholder="ALAMAT PERUSAHAAN" name="alamat">
                        </div>
                        <div class="input-group">
                            <input class="input--style-1" required type="email" placeholder="EMAIL PERUSAHAAN" name="email">
                        </div>
                        <div class="input-group">
                            <input class="input--style-1" required type="number" placeholder="NPWP" name="npwp">
                        </div>
             
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" required type="text" placeholder="NAMA PEMILIK" name="pemilik">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" required maxlength="13" type="text" placeholder="TELEPON" name="telepon">
                                </div>
                            </div>
                        </div>

                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="bank" required>
                                            <option disabled="disabled" selected="selected">BANK</option>
                                            <option>Bank BRI</option>
                                            <option>Bank BNI</option>
                                            <option>Bank BJB</option>
                                            <option>Bank BCA</option>
                                            <option>Bank Permata</option>
                                            <option>Bank Muamalat</option>
                                            <option>Other</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" required type="number" placeholder="NO. REKENING" name="no_rekening">
                                </div>
                            </div>
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
                                <input class="input--style-1" type="text" placeholder="SLOGAN (OPSIONAL)" name="slogan">
                            </div>

                            <div class="form-group row mb-2">
                                <div class="mb-3">
                                    <p style="color:#636060;">LOGO PERUSAHAAN</p><br>
                                    <input class="form-control" type="file" id="image" name="logo" onchange="previewImage()">
                                </div>
                            </div>
                            <br>
                            <img class="img-preview img-fluid my-3 col-sm-5" width="250" >
                            <br>
                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" type="submit">Submit</button>
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

    <!-- Main JS-->
    <script src="{{ asset('templates') }}/js/global.js"></script>

    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
    </script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->
