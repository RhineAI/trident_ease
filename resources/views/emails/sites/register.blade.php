@component('mail::message')
<p style="text-align: center; font-size:20px">
    # Pendaftaran Perusahaan
</p>

Terima Kasih Sudah Mendaftar, Silahkan Login Menggunakan Username dan Password dibawah ini... 

@php
    use app\Models\User;
    use app\Models\Perusahaan;
    $user = User::select('*')->orderBy('id', 'DESC')->first();
    $perusahaan = perusahaan::select('*')->orderBy('id', 'DESC')->first();
@endphp

Username = {{ str_replace(' ', '', $user->username) }}
<br>
Password = {{ $perusahaan->npwp }}

<b>Pastikan username dan password untuk segera diganti!</b>
<br><br>
Jika Ada Masalah<a href="https://wa.wizard.id/31a293" style="text-decoration:none; color:#3cded8;"> Hubungi Kami</a>

<div class="button" style="  background-color: black; /* Green */
    border: none;
    color: white;
    padding: 8px 11.5px;
    text-align: center;
    align-items:center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius:20px;
    margin: 4px 2px;
    cursor: pointer;">
        <a href="{{ url('/login') }}" style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; padding-top:20px; color:white;  text-decoration:none;">
            Silahkan Klik Disini Untuk Melanjutkan
        </a>
    </div>
<br><br>
{{-- @component('mail::button', ['url' => "{{ url('/') }}" ])
Silahkan Klik Disini Untuk Melanjutkan
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
