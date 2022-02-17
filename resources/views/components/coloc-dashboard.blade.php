{{-- @php
    $get_user_program_active = \Auth::user()->get_user_program_active()->program_id;
@endphp --}}

<x-home-dashboard-milestone :programid="$programid" />
<x-home-dashboard-productivity />
<div class="divider"></div>