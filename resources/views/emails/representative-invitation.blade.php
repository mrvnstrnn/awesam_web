@component('mail::message')
Hi {{ $name }},

You're added as a representative in a Joint Technical Site Survey of {{ $sitename }}

@component('mail::button', ['url' => $url ])
Yes! I'm part of this JTSS
@endcomponent

<hr>

If you’re having trouble clicking the "Accept invitation" button, copy and paste the URL below into your web browser:
<a href="{{ $url }}">{{ $url }}</a>

<hr>

If you’re not part of this survey or this email is incorrect. Please click the link
<a href="{{ $url }}">{{ $url }}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
