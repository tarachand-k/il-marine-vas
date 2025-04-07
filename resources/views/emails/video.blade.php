@component('mail::message')
Hello **{{ $user->name }}**!!,

We have shared a video resource **{{ $video->title }}** with you. Below are your login details:

- **Username**: {{ $user->email }}
- **Password**: {{ $user->mobile_no }} (If you haven't changed your password!)

Please log in and view the resource on our platform.
@component('mail::button', ['url' => 'http://marinevas.com/dashboard/#/auth/login'])
    Log in
@endcomponent

Thanks for choosing us!

Regards, <br>
{{ config('app.name') }}
@endcomponent

