<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/js/bootstrap.min.js">

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('templates') }}/fonts/material-icon/css/material-design-iconic-font.min.css">
    
    {{-- Bootstrap Icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/bootstrap-icons.svg">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('templates') }}/css/style.css">
</head>
<body>

    <div class="main">

        <!-- Sing in  Form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="form-group">
                                <label for="nama">
                                    <i class="fa-solid fa-signature"></i>
                                </label>
                                <input type="text" name="nama" id="nama" placeholder="Nama Perusahaan"/>
                            </div>

                            <div class="form-group">
                                <label for="alamat">
                                    <i class="fa-solid fa-building"></i>
                                </label>
                                <input type="text" name="alamat" id="alamat" placeholder="Alamat Perusahaan"/>
                            </div>

                            <div class="form-group">
                                <label for="telepon">
                                    <i class="fa-solid fa-building"></i>
                                </label>
                                <input type="text" name="telepon" id="telepon" placeholder="No. Telepon"/>
                            </div>

                            <div class="form-group">
                                <label for="owner">
                                    <i class="fa-solid fa-building"></i>
                                </label>
                                <input type="text" name="owner" id="owner" placeholder="Pemilik Perusahaan"/>
                            </div>

                            <div class="form-group">
                                <label for="alamat">
                                    <i class="fa-solid fa-building"></i>
                                </label>
                                <input type="text" name="alamat" id="alamat" placeholder="Alamat Perusahaan"/>
                            </div>

                           <div class="form-group">
                            <input type="text">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                              </select>
                           </div>

                            <div class="form-group">
                                <select class="form-select form-select-lg" name="bank" id="bank">
                                    <option selected>Pilih Bank</option>
                                    <option value="bri">Bank BRI</option>
                                    <option value="bni">Bank BNI</option>
                                    <option value="bca">Bank BCA</option>
                                    <option value="bjb">Bank BJB</option>
                                    <option value="bjb">Bank BJB</option>
                                    <option value="permata">Bank Permata</option>
                                    <option value="muamalat">Bank Muamalat</option>
                                </select>
                            </div>



                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="{{ asset('templates') }}/images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="#" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="{{ asset('templates') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('templates') }}/js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>

        