$(document).ready(() => {

    var table_list = ['active', 'approved', 'denied'];

    for (let i = 0; i < table_list.length; i++) {
        $('#'+table_list[i]+'-request-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#'+table_list[i]+'-request-table').attr('data-href'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            columnDefs: [{
                "targets": 0,
                "orderable": false
            }],
            columns: [
                { data: "id" },
                { data: "request_type" },
                { data: "reason" },
                { data: "requested_date" },
                { data: "date_created" }
            ],
        });


        
    }


    $(".add_request_button").on('click', function(){

        $('#modal_request').modal('show');
        // $('#loader').addClass('d-none');
        $('#request_form').removeClass('d-none');
        $('#add_request').prop('disabled', false);
        $('#btn_modal_cancel').prop('disabled', false);


    });

    $(".flatpicker").flatpickr(
        {
            minDate: "today"
        }
    );

    $("#add_request").on('click', function(e){
        e.preventDefault();

        $("#request_form").validate({
            rules:{
                request_type: "required",
                start_date_requested: "required",
                end_date_requested: "required",
                reason: "required",
            }
        });

        if($('#request_form').valid()){

            $('#loader').removeClass('d-none');
            $('#request_form').addClass('d-none');

            $('#add_request').prop('disabled', true);
            $('#btn_modal_cancel').prop('disabled', true);


            $.ajax({
                url: $(this).attr('data-href'),
                data: $('#request_form').serialize(),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $('#active-request-table').DataTable().ajax.reload(function(){
                            toastr.success("Request Submitted", 'Success');
                            $('#modal_request').modal('hide');
                            $('#request_form').trigger("reset");
                        });

                    } else {
                        toastr.error(resp, 'Error');
                    }
                },
                error: function(resp){
                    toastr.error(resp, 'Error');
                }
            });    
        }

    });









});