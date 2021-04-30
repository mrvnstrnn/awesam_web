@component('mail::message')
Hi {{ $name }},

This is your login invitation link from you company {{ $mode }}.

Email: {{ $email }}<br>
Password: {{ $password }}

@component('mail::button', ['url' => $url])
Login
@endcomponent

<hr>

If you’re having trouble clicking the "Login" button, copy and paste the URL below into your web browser:
 <a href="{{ $url }}">{{ $url }}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent