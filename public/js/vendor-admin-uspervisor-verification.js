$(document).ready(() => {
    $('#employee-agents-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $('#employee-agents-table').attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function(row, data) {
            $(row).addClass('getListAgent');
            $(row).attr('data-id', data.user_id);
        },
        columns: [
            { data: "user_id" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "email" },
            { data: "number_agent" },
        ],
    });

    $('#employee-agents-table tbody').on('click', 'tr', function () {
        $("#modal-employee-verification").modal("show");

        $(".content-data ul").remove();

        var data_id = $(this).attr("data-id");

        // $(".modal-footer.assign-profile-footer").addClass("d-none");
        $.ajax({
            url: "/get-agent-of-supervisor/"+data_id,
            method: "GET",
            success: function(resp) {
                if(!resp.error) {
                    $(".content-data").append(
                        '<ul class="list-group"></ul>'
                    );
                    resp.message.forEach(element => {
                        $(".content-data ul").append(
                            '<li class="list-group-item"><i class="fa-2x pe-7s-user icon-gradient bg-malibu-beach"></i> '+element.firstname+ " "+element.lastname+ ' | '+element.region+' '+element.province+' '+element.lgu+'</span></li>'
                        );
                    });
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function(resp) {
                toastr.error(resp.message, "Error");
            }
        });
    });


});