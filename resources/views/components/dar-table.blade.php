@php
$profile_id = \Auth::user()->profile_id;
$user_id = \Auth::user()->id;

// dd($profile_id);

if($profile_id === "2"){
    $dar = \DB::table('agent_dar')
                ->where('agent_dar.agent_user_id', "=", $user_id)
                ->where('program_id', 1)
                ->get();                            

} 
elseif($profile_id === "3"){
    $dar = \DB::table('agent_dar')
                ->where('agent_dar.IS_id', "=", $user_id)
                ->where('program_id', 1)
                ->get();                            

} 
else {
    $dar = \DB::table('agent_dar')
                ->where('program_id', 1)
                ->get();                            
}

@endphp
<table id="dar_table" class="table table-hover table-striped table-bordered dataTable dtr-inline">
    <thead>
        <tr>
            <td>Vendor</td>
            <td>Date</td>
            <td>Program</td>
            <td>Site</td>
            <td>Agent</td>
            <td>Action</td>
            <td>Time</td>
        </tr>
    </thead>
    <tbody>
    @foreach ($dar as $d)
        <tr>
            <td>{{ $d->vendor_name }}</td>
            <td>{{ date_format(date_create($d->date_created), 'Y-m-d') }}</td>
            <td>{{ $d->program_name }}</td>
            <td>
                <div>{{ $d->site_name }}</div>
                <div><small>{{ $d->sam_id }}</small></div>
            </td>
            <td>{{ $d->agent_firstname . " " . $d->agent_middlename . " " . $d->agent_lastname }}</td>
            <td>
                <div>{{ $d->sub_activity_action }}</div>
                <div><small>{{ $d->sub_activity_name }}</small></div>                                        
            </td>
            <td>{{ date_format(date_create($d->date_created), 'H:i:s') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


