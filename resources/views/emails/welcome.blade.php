@component('mail::message')
# Welcome to Our Service

Hello {{ $user->name }}!!,

We are excited to welcome you to our platform. Below are your login details:

- **Username**: {{ $user->email }}
- **Password**: {{ $user->mobile_no }}

You can now log in and start using our services.

@component('mail::button', ['url' => config('app.url') . '/login'])
    Log in
@endcomponent

Thanks for choosing us!

Regards,
{{ config('app.name') }}
@endcomponent
