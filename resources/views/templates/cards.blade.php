<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <?php
        use App\Models\Perusahaan;

        $perusahaan = Perusahaan::select('*')->where('id', auth()->user()->id_perusahaan)->first();

      ?>
      <title>Profile | {{ $perusahaan->nama }}</title>
      <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
      <style>
          @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
          *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
          }
          html,body{
            display: grid;
            height: 100%;
            width: 100%;
            place-items: center;
            background: linear-gradient(375deg, #1cc7d0, #2ede98);
          }
          ::selection{
            color: #fff;
            background: #1cc7d0;
          }
          .wrapper{
            height: 400px;
            width: 320px;
            position: relative;
            transform-style: preserve-3d;
          perspective: 1000px;
          }
          .wrapper .card{
            position: absolute;
            height: 100%;
            width: 100%;
            padding: 5px;
            background: #fff;
            border-radius: 10px;
            transform: translateY(0deg);
            transform-style: preserve-3d;
            backface-visibility: hidden;
            box-shadow: 0px 10px 15px rgba(0,0,0,0.1);
            transition: transform 0.7s cubic-bezier(0.4,0.2,0.2,1);
          }
          .wrapper:hover > .front-face{
            transform: rotateY(-180deg);
          }
          .wrapper .card img{
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
          }
          .wrapper .back-face{
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            flex-direction: column;
            transform: rotateY(180deg);
          }
          .wrapper:hover > .back-face{
            transform: rotateY(0deg);
          }
          .wrapper .back-face img{
            height: 150px;
            width: 150px;
            padding: 5px;
            border-radius: 50%;
            background: linear-gradient(375deg, #1cc7d0, #2ede98);
          }
          .wrapper .back-face .info{
            text-align: center;
          }
          .back-face .info .title{
            font-size: 30px;
            font-weight: 500;
          }
          .back-face ul{
            display: flex;
          }
          .back-face ul a{
            display: block;
            height: 40px;
            width: 40px;
            color: #fff;
            text-align: center;
            margin: 0 5px;
            line-height: 38px;
            border: 2px solid transparent;
            border-radius: 50%;
            background: linear-gradient(375deg, #1cc7d0, #2ede98);
            transition: all 0.5s ease;
          }
          .back-face ul a:hover{
            color: #1cc7d0;
            border-color: #1cc7d0;
            background: linear-gradient(375deg, transparent, transparent);
          }
          a {
            text-decoration: none;
            color:#1cc7d0;
          }
          .hover {
            margin : 0 auto;
            font-size: 30px;
            font-weight: 500;
            display: flex;
            position: relative;
            top: 45%;
            left: 25%;
          }
      </style>
   </head>
   <body>
      <div class="wrapper">
          <div class="card front-face">
            {{-- <img height="90%" src="{{ $cPerusahaan->logo }}"> --}}
              <div class="title text-center hover" style="margin: 0 auto;">
                  Hover me!
              </div>
          </div>
          <div class="card back-face">
              <div class="title">
                <h3>
                    Profile Cards
                </h3>
              </div>
              <img src="{{ $perusahaan->logo }}" style="background-color:white;">
              <div class="info mb-4">
                  <div class="title">
                      {{ $perusahaan->nama }}
                  </div>
                  <p>
                    {{ $perusahaan->email }}
                  </p>
                  <p style="margin:10px;">
                    {{ $perusahaan->slogan }}
                  </p>
                  {{-- <p>
                      Username : {{ str_replace(' ', '', $user->username) }}
                      <br>
                      Password = 12345
                  </p> --}}
              </div>
              <div></div>
              <p class="">
                  Any Problem?<a href="https://wa.wizard.id/31a293"> Contact us</a>
              </p>
              <p>
                {{-- <a class="text-center" href="{{ route('login') }}">Click to Login </a> --}}
              </p>
          </div>
      </div>
   </body>
</html>

