$(document).ready(() => {
    $('#for-verification-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#for-verification-table").attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function(row, data) {
            $(row).attr('data-id', data.id);
            $(row).addClass('modalSetProfile');
        },
        columns: [
            { data: "firstname" },
            { data: "lastname" },
            { data: "email" },
        ],
    });
    

    $(document).on( 'click', 'tr.modalSetProfile td', function (e) {
        e.preventDefault();
        
        var data_id = $(this).parent().attr('data-id');

        // $(".content-data select#profile option").remove();
        $.ajax({
            url: '/get-profile',
            method: "GET",
            success: function (resp) {
                if(!resp.error){
                    // resp.message.forEach(element => {
                    //     $(".content-data select#profile").append(
                    //         '<option value="'+element.id+'">'+element.profile+'</option>'
                    //     );
                    // });
                    $(".btn-assign-profile").attr('data-id', data_id);
                    $("#modal-employee-verification").modal("show");
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function (resp) {
                toastr.error(resp.message, "Error");
            }
        });
    });

    $(document).on( 'click', '.btn-assign-profile', function (e) {
        e.preventDefault();

        var data_id = $(this).attr('data-id');

        var val = $("select#profile").val();
        $.ajax({
            url: '/assign-profile',
            method: "POST",
            data: {
                val:val,
                data_id:data_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if(!resp.error){
                    $('#for-verification-table').DataTable().ajax.reload(function(){
                        toastr.success(resp.message, "Success");
                        $("#modal-employee-verification").modal("hide");
                    });
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function (resp) {
                toastr.error(resp.message, "Error");
            }
        });
    });

});