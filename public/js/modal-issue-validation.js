$('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
    e.preventDefault();

    $.ajax({
        url: "/get-site-issue-details/" + $(this).attr("data-issue_id") + "/" + $(this).attr("data-what_table"),
        method: "GET",
        success: function (resp) {
            console.log(resp);
            if (!resp.error) {
                $('.table_div').html("");
                htmllist = '<div class="table-responsive table_issue_parent">' +
                    '<table class="table_issue align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                        '<thead>' +
                            '<tr>' +
                                '<th style="width: 5%">#</th>' +
                                '<th>Filename</th>' +
                                '<th style="width: 35%">Status</th>' +
                                '<th>Date Uploaded</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>' +
                '</div>';

                $('.table_div').html(htmllist);
                $(".table_issue").attr("id", "table_issue_child_"+resp.issue_id);

                // if (! $.fn.DataTable.isDataTable("#table_uploaded_files_"+sub_activity_id) ){
                //     $("#table_uploaded_files_"+sub_activity_id).DataTable({
                //         processing: true,
                //         serverSide: true,
                //         ajax: {
                //             url: "/get-my-sub_act_value/"+sub_activity_id+"/"+sam_id,
                //             type: 'GET',
                //             headers: {
                //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //             },
                //         },
                //         dataSrc: function(json){
                //             return json.data;
                //         },
                //         'createdRow': function( row, data, dataIndex ) {
                //             $(row).attr('data-value', data.value);
                //             $(row).attr('data-status', data.status);
                //             $(row).attr('data-id', data.id);
                //             $(row).attr('data-sub_activity_id', data.sub_activity_id);
                //             $(row).attr('style', 'cursor: pointer');
                //         },
                //         columns: [
                //             { data: "id" },
                //             { data: "value" },
                //             { data: "status" },
                //             { data: "date_created" },
                //         ],
                //     });
                // } else {
                //     $("#table_uploaded_files_"+sub_activity_id).DataTable().ajax.reload();
                // }

                $.unblockUI();
                $('#viewIssueModal').modal('show');
            } else {
                toastr.error(resp, "Error");
            }
        },
        error: function (resp) {
            toastr.error(resp, "Error");
        }
    });

});

$(document).on( 'click', '.resolve_issue', function (e) {
    e.preventDefault();

    var table = $(this).attr("data-what_table");
    $.ajax({
        url: "/resolve-issue/" + $("#hidden_issue_id").val(),
        method: "GET",
        success: function (resp) {
            if (!resp.error) {
                $("#" + table ).DataTable().ajax.reload(function(){
                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )
                    $('#viewInfoModal').modal('hide');
                });
            } else {
                Swal.fire(
                    'Error',
                    resp.message,
                    'error'
                )
            }
        },
        error: function (resp) {
            Swal.fire(
                'Error',
                resp,
                'error'
            )
        }
    });

});