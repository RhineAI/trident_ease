@component('mail::message')
# Pendaftaran Perusahaan

Terima Kasih Sudah Mendaftar, Silahkan Login Menggunakan Username dan Password dibawah ini... 
@php
    use app\Models\User;
    $user = User::latest()->first();
@endphp

Username = {{ str_replace(' ', '', $user->username) }}
<br>
Password = {{ $user->nama . '123' }}

@component('mail::button', ['url' => 'http://youtube.com' ])
Silahkan Klik Disini 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
