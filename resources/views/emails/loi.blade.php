@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => asset('files/' .$file)])
Download PDF
@endcomponent

@for ($i = 0; $i < count($file_array); $i++)
    <a href="{{ asset('files/' .$file_array[$i]) }}">{{ $file_array[$i] }}</a>
@endfor

Thanks,<br>
{{ config('app.name') }}
@endcomponent
