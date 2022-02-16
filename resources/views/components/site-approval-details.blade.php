<div class="table-responsive">
    <table class="table approval_table">
        <thead>
            <tr>
                <th>Activity Name</th>
                <th>Sub Activity</th>
                <th>Start Date</th>
                <th>Date Approved/Reject</th>
                <th>Approver Name</th>
                <th>Approver Profile</th>
                <th>Report Type</th>
                <th>Aging</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    var sam_id = "{{ $site[0]->sam_id }}";

    $(".approval_table").DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/site-approvals-per-site",
            type: 'POST',
            data : {
                sam_id : sam_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        columns: [
            { data: "activity_name" },
            { data: "sub_activity_name" },
            { data: "Activity_Start_Date" },
            { data: "Date_ApproveReject" },
            { data: "Approver_Name" },
            { data: "Approver_Profile" },
            { data: "report_type" },
            { data: "Aging" },
        ],
    });
</script>