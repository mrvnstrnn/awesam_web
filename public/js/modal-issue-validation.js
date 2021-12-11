$('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
    e.preventDefault();

    var what_table = $(this).attr("data-what_table");

    $(".resolve_issue").attr("data-what_table", what_table);
    var site = $(this).attr("data-site");
    $.ajax({
        url: "/get-site-issue-details/" + $(this).attr("data-issue_id") + "/" + $(this).attr("data-what_table"),
        method: "GET",
        success: function (resp) {
            if (!resp.error) {
                $("#viewIssueModal .menu-header-title").text(site);
                $(".update_issue_form input[name=hidden_issue_id]").val(resp.site.issue_id);
                $(".remarks_issue_form #site_issue_id").val(resp.site.issue_id);
                $(".update_issue_form input[name=issue]").val(resp.site.issue);
                $(".update_issue_form input[name=issue_callout]").val(resp.site.issue_callout);
                $(".update_issue_form input[name=start_date]").val(resp.site.start_date);
                $(".update_issue_form input[name=issue_type]").val(resp.site.issue_type);
                $(".update_issue_form textarea[name=issue_details]").text(resp.site.issue_details);

                $('.table_div').html("");
                htmllist = '<div class="table-responsive table_issue_parent">' +
                    '<table class="table_issue align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                        '<thead>' +
                            '<tr>' +
                                '<th style="width: 5%">#</th>' +
                                '<th style="width: 35%">Remarks</th>' +
                                '<th>Status</th>' +
                                '<th>Date Engage</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>' +
                '</div>';

                $('.table_div').html(htmllist);
                $(".table_issue").attr("id", "table_issue_child_"+resp.site.issue_id);

                if (! $.fn.DataTable.isDataTable("#table_issue_child_"+resp.site.issue_id) ){
                    $("#table_issue_child_"+resp.site.issue_id).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/get-site_issue_remarks/"+resp.site.issue_id,
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        },
                        dataSrc: function(json){
                            return json.data;
                        },
                        columns: [
                            { data: "id" },
                            { data: "remarks" },
                            { data: "status" },
                            { data: "date_engage" },
                        ],
                    });
                } else {
                    $("#table_issue_child_"+resp.site.issue_id).DataTable().ajax.reload();
                }

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
    
    $(this).attr("disabled", "disabled");
    $(this).text("Processing...");

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
                    $('#viewIssueModal').modal('hide');

                    $(".resolve_issue").removeAttr("disabled");
                    $(".resolve_issue").text("Resolve Issue");
                });
            } else {
                Swal.fire(
                    'Error',
                    resp.message,
                    'error'
                )

                $(".resolve_issue").removeAttr("disabled");
                $(".resolve_issue").text("Resolve Issue");
            }
        },
        error: function (resp) {
            Swal.fire(
                'Error',
                resp,
                'error'
            )

            $(".resolve_issue").removeAttr("disabled");
            $(".resolve_issue").text("Resolve Issue");
        }
    });

});