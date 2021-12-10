@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => asset('files/' .$file)])
Download PDF
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
