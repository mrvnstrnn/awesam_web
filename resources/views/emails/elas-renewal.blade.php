@component('mail::message')
Greetings!

We are requesting eLAS with the following details:

Reference No: {{ $reference_number }}
Filing Date: {{ $filing_date }}

@component('mail::button', ['url' => route('elas_approval', [$token, $sam_id, $program_id, $site_category, $activity_id, 'true']) ])
Approve
@endcomponent

@component('mail::button', ['url' => route('elas_approval', [$token, $sam_id, $program_id, $site_category, $activity_id, 'false']) ])
Reject
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
