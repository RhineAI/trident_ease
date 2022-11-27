{{-- @if(Auth::check() && auth()->user()->hak_akses == NULL)
{{ 'auth.login' }}
@else 
	<script>window.location = "{{ url('errors/404') }}";</script>
@endif --}}
{{-- @if(Auth::check() != NULL) --}}
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>404 Page POS</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="/assets/css/style.css" />

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->

	</head>

	<body>

		<div id="notfound">
			<div class="notfound">
				<div class="notfound-404">
					<div></div>
					<h1>404</h1>
				</div>
				<h2>Halaman Tidak Ditemukan</h2>
				<p>Halaman yang Anda cari mungkin telah dihapus jika namanya diubah atau untuk sementara tidak tersedia.</p>
				<a href="javascript:history.back()">Kembali</a>
				<a href="{{ route('logout') }}">Ke Halaman Login</a>

					{{-- <a href="{{ route('login') }}">Home page</a> --}}
				{{-- @if(Auth::check() && auth()->user()->hak_akses == 'super_admin') --}}
					{{-- <a href="{{ route('super_admin.dashboard') }}">Home page</a> --}}
				{{-- @elseif(Auth::check() && auth()->user()->hak_akses == 'owner') --}}
					{{-- <a href="{{ route('admin.dashboard') }}">Home page</a> --}}
				{{-- @elseif(Auth::check() && auth()->user()->hak_akses == 'admin') --}}
					{{-- <a href="{{ route('admin.dashboard') }}">Home page</a> --}}
				{{-- @elseif(Auth::check() && auth()->user()->hak_akses == 'kasir') --}}
					{{-- <a href="{{ route('kasir.dashboard') }}">Home page</a> --}}
				{{-- @endif --}}
			</div>
		</div>

	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
{{-- @else  --}}
{{-- <script>window.location = "{{ route('login') }}";</script> --}}
{{-- @endif --}}
