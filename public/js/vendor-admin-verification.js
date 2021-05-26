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

            var suffix = data.suffix == null ? "" : data.suffix;
            $(row).attr('data-user_id', data.user_id);
            $(row).attr('data-profile_id', data.designation);
            $(row).attr('data-profile', data.profile);
            $(row).attr('data-employeename', data.firstname + " " + data.lastname + " " + suffix);
            $(row).addClass('modalSetProfile');
        },
        columns: [
            { data: "user_id" },
            { data: "profile" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "email" },
        ],
    });


    $('#for-verification-table tbody').on('click', 'tr', function () {
                
        var data = $( this ).attr("data-chapter_id");


        $(".btn-assign-profile").attr('data-user_id', $( this ).attr("data-user_id"));
        $(".btn-assign-profile").attr('data-profile_id', $( this ).attr("data-profile_id"));
        $(".btn-assign-profile").attr('data-profile', $( this ).attr("data-profile"));
        $(".btn-assign-profile").attr('data-employeename', $( this ).attr("data-employeename"));
        $('.content-data').html('<H5>Approve ' + $( this ).attr("data-employeename") + "'s account?</H5>");
        $("#modal-employee-verification").modal("show");

        // if($( this ).attr("data-profile_id")){
        //     $.ajax({
        //         url: '/get-supervisor',
        //         method: "GET",
        //         success: function (resp) {
        //             if(!resp.error){
        //                 $('.supervisor-data').removeClass("d-none");
        //                 resp.message.forEach(element => {
        //                     console.log(element);
        //                     $('.supervisor-data').html("<option>"+element.email+"</option>");
        //                 });
        //             } else {
        //                 toastr.error(resp.message, "Error");
        //             }
        //         },
        //         error: function (resp) {
        //             toastr.error(resp.message, "Error");
        //         }
        //     });
        // }
        // window.location.href = "/chapters/"+data;
    } );

    

    // $(document).on( 'click', 'tr.modalSetProfile td', function (e) {
    //     e.preventDefault();

        
    //     var data_id = $(this).parent().attr('data-id');
    //     var profile = $(this).parent().attr('data-profile');
    //     var employeename = $(this).parent().attr('data-employeename');


    //     // $(".content-data select#profile option").remove();
    //     $.ajax({
    //         url: '/get-profile',
    //         method: "GET",
    //         success: function (resp) {
    //             if(!resp.error){
    //                 // resp.message.forEach(element => {
    //                 //     $(".content-data select#profile").append(
    //                 //         '<option value="'+element.id+'">'+element.profile+'</option>'
    //                 //     );
    //                 // });
    //                 $(".btn-assign-profile").attr('data-id', data_id);
    //                 $(".btn-assign-profile").attr('data-profile', profile);
    //                 $(".btn-assign-profile").attr('data-employeename', employeename);
    //                 $('.content-data').html('<H5>Approve ' + employeename + "'s account?</H5>");
    //                 $("#modal-employee-verification").modal("show");
    //             } else {
    //                 toastr.error(resp.message, "Error");
    //             }
    //         },
    //         error: function (resp) {
    //             toastr.error(resp.message, "Error");
    //         }
    //     });
    // });

    $(document).on( 'click', '.btn-assign-profile', function (e) {
        e.preventDefault();

        var user_id = $(this).attr('data-user_id');
        var profile_id = $(this).attr('data-profile_id');

        
        var inputElements = document.getElementsByName('vendor_program_id');

        checkbox_id = [];
        for(var i=0; inputElements[i]; ++i){
            if(inputElements[i].checked){
                checkbox_id.push(inputElements[i].value);
            }
        }

        // var val = $("select#profile").val();
        $.ajax({
            url: '/assign-profile',
            method: "POST",
            data: {
                user_id:user_id,
                profile_id:profile_id,
                checkbox_id:checkbox_id
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