@component('mail::message')

Etto Lending

Reset Password
 
We heard that you lost your  password. Sorry about that!

Password :  {{ $password }}

we recommended to change your password.

Thanks,<br>
{{ config('app.name') }}
@endcomponent