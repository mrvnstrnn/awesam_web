
@if(\Auth::user()->profile_id == 26)

    <x-newsites-dashboard-aepm />

@else

    <x-newsites-dashboard-globe />

@endif