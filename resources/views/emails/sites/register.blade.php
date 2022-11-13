@component('mail::message')
<p style="text-align: center; font-size:20px">
    # Pendaftaran Perusahaan
</p>

Terima Kasih Sudah Mendaftar, Silahkan Login Menggunakan Username dan Password dibawah ini... 

@php
    use app\Models\User;
    $user = User::latest()->first();
@endphp

Username = {{ str_replace(' ', '', $user->username) }}
<br>
Password = 12345

Pastikan username dan password default untuk segera diganti!
<br>
Jika Ada Masalah<a href="https://wa.wizard.id/31a293" style="text-decoration:none; color:#3cded8;"> Hubungi Kami</a>

<div class="button" style="background-color: black; padding:4px; border:1px solid black; border-radius:10%;">
    <a href="{{ url('/') }}" style="color:white; text-align:center; text-decoration:none;">
        Silahkan Klik Disini Untuk Melanjutkan
    </a>
</div>
<br>
@component('mail::button', ['url' => "{{ url('/') }}" ])
Silahkan Klik Disini Untuk Melanjutkan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
