<div class="table-responsive">
    <table class="table approval_table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Activity</th>
                <th>Created By</th>
                <th>Approved By</th>
            </tr>
        </thead>
        @php
            $site_approvals = \App\Models\SubActivityValue::join('sub_activity', 'sub_activity.sub_activity_id', 'sub_activity_value.sub_activity_id')
                                                ->join('stage_activities', 'stage_activities.activity_id', 'sub_activity.activity_id')
                                                ->join('users', 'users.id', 'sub_activity_value.approver_id')
                                                ->where('sub_activity_value.sam_id', $site[0]->sam_id)->get();
        @endphp
        
        <tbody>
            @foreach ($site_approvals as $site_approval)
            <tr>
                <td>{{ $site_approval->status }}</td>
                <td>
                    <div class="font-weight-bold">{{ $site_approval->activity_name }}</div>
                    <small>{{ $site_approval->sub_activity_name }}</small>
                </td>
                <td>
                    @php
                        $user = \App\Models\User::select('name')->where('id', $site_approval->user_id)->first();
                    @endphp
                    <div class="font-weight-bold">{{ $user->name }}</div>
                    <small>{{ date('M d, Y h:m:s', strtotime($site_approval->date_created)) }}</small>
                </td>
                <td>{{ $site_approval->name }}
                    <div class="font-weight-bold">{{ $site_approval->name }}</div>
                    <small>{{ date('M d, Y h:m:s', strtotime($site_approval->date_approved)) }}</small>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(".approval_table").DataTable();
</script>