@component('mail::message')
# Pendaftaran Perusahaan

Terima Kasih Sudah Mendaftar, Silahkan Login Menggunakan Username dan Password dibawah ini... 
@php
    use app\Models\User;
    $user = User::latest()->first();
@endphp

Username = {{ str_replace(' ', '', $user->username) }}
<br>
Password = 12345

Pastikan username dan password default untuk segera diganti!

@component('mail::button', ['url' => '{{ url('/') }}' ])
Silahkan Klik Disini 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
