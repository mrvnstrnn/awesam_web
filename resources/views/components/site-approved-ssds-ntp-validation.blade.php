<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
    
    .dropzone {
        min-height: 20px !important;
        border: 2px dashed #3f6ad8 !important;
        border-radius: 10px;
        padding: unset !important;
    }

    .ui-datepicker.ui-datepicker-inline {
       width: 100% !important;
    }
    
    .ui-datepicker table {
        font-size: 1.3em;
    }
    
</style>  

<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                        <h5 class="menu-header-title">
                                            {{ $site_name }}
                                            @if($site_category != 'none')
                                                <span class="mr-3 badge badge-secondary"><small>{{ $site_category }}</small></span>
                                            @endif
                                        </h5>
                                </div>
                            </div>
                        </div> 

                        <div class="card-body">

                            <div class="row pt-4">
                                <div class="col-md-12">
                                    <H5 id="active_action">{{ $activity }}</H5>
                                </div>
                            </div>
                            <div class="row pt-3" id="ssds_form">
                                <div class="col-md-12">
                                    @php
                                        // $json = json_decode($data->value);
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function(e){

    $(document).on("click", ".view_file", function (e){
        e.preventDefault();
        
        $(".file_lists").addClass("d-none");

        var extensions = ["pdf", "jpg", "png"];

        var values = $(this).attr("data-file_name");

        if( extensions.includes(values.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values + '" allowfullscreen></iframe>';
        } else {
            htmltoload = '<div class="text-center my-5"><a href="/files/' + values + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }
                
        $('.file_viewer').html('');
        $('.file_viewer').html(htmltoload);

        $('.file_view_div').removeClass("d-none");
    });

    $('#btn_back_ssds').on("click", function(){
        $('.file_view_div').addClass("d-none");
        $('.file_lists').removeClass("d-none");
    });

    $(".approve_reject_site").on("click", function (e) {
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var action = $(this).attr("data-action");
        var btn_id = $(this).attr("id");

        // var id = $(this).attr("data-id");

        var activity_name = "{{ $activity }}";
        var activity_id = ["{{ $activity_id }}"];
        var site_category = ["{{ $site_category }}"];
        var program_id = "{{ $program_id }}";
        var sam_id = ["{{ $sam_id }}"];

        if (action == "false") {
            var btn_text = "Reject Site";
        } else {
            var btn_text = "Approve Site";
        }
        
        $.ajax({
            url: "/accept-reject-endorsement",
            method: "POST",
            data: {
                // id : id,
                sam_id : sam_id,
                site_category : site_category,
                activity_id : activity_id,
                activity_name : activity_name,
                program_id : program_id,
                data_complete : action,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                    if (!resp.error){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        $("#viewInfoModal").modal("hide");
                        $("#"+btn_id).removeAttr("disabled");
                        $("#"+btn_id).text(btn_text);

                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                        $("#"+btn_id).removeAttr("disabled");
                        $("#"+btn_id).text(btn_text);
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $("#"+btn_id).removeAttr("disabled");
                    $("#"+btn_id).text(btn_text);
                }
        });
    });

});

</script>