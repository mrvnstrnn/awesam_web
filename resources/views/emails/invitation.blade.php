@component('mail::message')
Hi {{ $name }},

This is your invitation link from you company {{ $company }}.

@component('mail::button', ['url' => $url])
Accept invitation
@endcomponent

<hr>

If you’re having trouble clicking the "Accept invitation" button, copy and paste the URL below into your web browser:
 <a href="{{ $url }}">{{ $url }}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
