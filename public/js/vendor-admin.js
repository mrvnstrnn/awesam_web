$(document).ready(() => {


    $('#employee-verification-table').on( 'click', 'tr td:not(:first-child)', function () {

        // alert('test');

        // var json_parse = JSON.parse($(this).attr("data-site"));
        // var json_parse = JSON.parse($(this).parent().attr('data-site'));
        // $(".btn-accept-endorsement").attr('data-program', $(this).parent().attr('data-program'));

        // allowed_keys = ["PLA_ID", "REGION", "VENDOR", "ADDRESS", "PROGRAM", "LOCATION", "SITENAME", "SITE_TYPE", "TECHNOLOGY", "NOMINATION_ID", "HIGHLEVEL_TECH"];

        // $(".content-data .position-relative.form-group").remove();

        // Object.entries(json_parse.site_fields).forEach(([key, value]) => {
        //     Object.entries(value).forEach(([keys, values]) => {
        //         if(allowed_keys.includes(keys) > 0){
        //             $(".content-data").append(
        //                 '<div class="position-relative form-group col-md-6">' +
        //                     '<label for="' + keys.toLowerCase() + '" style="font-size: 11px;">' +  keys + '</label>' +
        //                     '<input class="form-control"  value="'+values+'" name="' + keys.toLowerCase() + '"  id="'+key.toLowerCase()+'" >' +
        //                 '</div>'
        //             );
        //         }
        //     });
        // });

        // $(".modal-title").text(json_parse.site_name);
        // $(".btn-accept-endorsement").attr('data-sam_id', json_parse.sam_id);
        $("#modal-employee-verification").modal("show");
    } );

});