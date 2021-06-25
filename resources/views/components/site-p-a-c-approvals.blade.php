<div class="row file_preview d-none">
    <div class="col-12 mb-3">
        <button id="btn_back_to_file_list" class="mt-0 btn btn-secondary" type="button">Back to files</button>
        {{-- <button id="btn_back_to_file_list" class="float-right mt-0 btn btn-success" type="button">Approve Document</button> --}}
        {{-- <button id="btn_back_to_file_list" class="mr-2 float-right mt-0 btn btn-transition btn-outline-danger" type="button">Reject Document</button> --}}
    </div>
    <div class="col-12 file_viewer">
    </div>
    <div class="col-12 file_viewer_list pt-3">
    </div>
</div>
<div class="row file_lists">
    @php
        $datas = \DB::connection('mysql2')->select('call `files_dropzone`("' .  $site[0]->sam_id . '")');
    @endphp

    @forelse ($datas as $data)
        @if (is_null($data->files))
            <div class="col-md-4 col-sm-4 col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style='min-height: 100px;'>
                <div class="dropzone dropzone_files" data-sam_id="{{ $site[0]->sam_id }}" data-sub_activity_id="{{ $data->sub_activity_id }}" data-sub_activity_name="{{ $data->sub_activity_name }}">
                    <div class="dz-message">
                        <i class="fa fa-plus fa-3x"></i>
                        <p><small class="sub_activity_name{{ $data->sub_activity_id }}">{{ $data->sub_activity_name }}</small></p>
                    </div>
                </div>
            </div>
        @else
            @php
                $uploaded_files = json_decode($data->files);

                if (pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "pdf") {
                    $extension = "fa-file-pdf";
                } else if (pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "png" || pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "jpeg" || pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "jpg") {
                    $extension = "fa-file-image";
                } else {
                    $extension = "fa-file";
                }

                $icon_color = "";
                foreach($uploaded_files as $approved){
                    if($approved->status == "approved"){
                        $icon_color = "success";
                    } else {
                        $icon_color = "secondary";
                    }
                }

            @endphp
            <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style="cursor: pointer;" data-value="{{ json_encode($uploaded_files) }}">
                <div class="child_div_{{ $data->sub_activity_id }}">
                    <div class="dz-message text-center align-center border" style='padding: 25px 0px 15px 0px;'>
                        <div>
                        <i class="fa {{ $extension }} fa-3x text-dark"></i><br>
                        {{-- <small>{{ $item->value }}</small> --}}
                        <p><small>{{ $data->sub_activity_name }}</small></p>
                        </div>
                    </div>
                     @if($icon_color == "success")   
                    <i class="fa fa-check-circle fa-lg text-{{ $icon_color }}" style="position: absolute; top:10px; right: 20px"></i><br>
                    @endif
                </div>
            </div>
        @endif
    @empty
        <div class="col-12 text-center">
            <h3>No files here.</h3>
        </div>
    @endforelse

    <input type="hidden" name="hidden_sam_id" value="{{ $site[0]->sam_id }}">
</div>
<div class="row mb-3 border-top pt-3">
    <div class="col-12 align-right">                                            
        <button class="float-right btn btn-shadow btn-success ml-1" id="btn-accept-endorsement" data-complete="true" data-sam_id="{{ $site[0]->sam_id }}">Approve Site</button>
        <button class="float-right btn btn-shadow btn-danger" id="btn-accept-endorsement" data-complete="false" data-sam_id="{{ $site[0]->sam_id }}">Reject Site</button>                                      
    </div>
</div>

<script src="/js/dropzone/dropzone.js"></script>

<script>
    
    $(".view_file").on("click", function (){

        var extensions = ["pdf", "jpg", "png"];

        var values = JSON.parse($(this).attr('data-value'));

        if( extensions.includes(values[0].value.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values[0].value + '" allowfullscreen></iframe>';
        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + values[0].value + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }
                
        $('.file_viewer').html('');
        $('.file_viewer').html(htmltoload);

        $('.file_viewer_list').html('');

        values.forEach(function(item, index){
            
            htmllist = "<tr>" + 
                            "<td>"  + item.id + "</td>" +
                            "<td>"  + item.value + "</td>" +
                            "<td>"  + item.status + "</td>" +
                            "<td>"  + item.date_created + "</td>" +
                        "</tr>";
        });

        htmllist = "<table class='table-bordered mb-0 table'>" + 
                        "<thead>" +
                            "<tr>" +                           
                                "<th>#</th>"+
                                "<th>file</th>"+
                                "<th>status</th>"+
                                "<th>timestamp</th>"+
                            "</tr>" +                           
                        "</thead>" +
                        "<tbody>" +
                            htmllist + 
                        "</tbody>" +
                    "</table>";

        $('.file_viewer_list').html(htmllist);

        $('.file_lists').addClass('d-none');
        $('.file_preview').removeClass('d-none');

    });

    $("#btn_back_to_file_list").on("click", function (){
        $('.file_lists').removeClass('d-none');
        $('.file_preview').addClass('d-none');
    });


    $(".dropzone_files").on("click", function (){
        $("input[name=hidden_sub_activity_name]").val($(this).attr("data-sub_activity_name"));
    });

    $("#btn-accept-endorsement").click(function(e){
        e.preventDefault();

        var sam_id = [$(this).attr('data-sam_id')];
        var data_complete = $(this).attr('data-complete');
        var activity_name = $("#modal_activity_name").val();

        // if ("{{ \Auth::user()->profile_id }}" == 10) {
        //     activity_name = "pac_approval";
        // } else if ("{{ \Auth::user()->profile_id }}" == 14) {
        //     activity_name = "pac_director_approval";
        // } else if ("{{ \Auth::user()->profile_id }}" == 13) {
        //     activity_name = "pac_vp_approval";
        // } 

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $.ajax({
            url: '/accept-reject-endorsement',
            data: {
                sam_id : sam_id,
                data_complete : data_complete,
                activity_name : activity_name
            },
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                        $("#viewInfoModal").modal("hide");
                        toastr.success(resp.message, 'Success');

                        $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                        $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve RTB Documents");
                        // $("#loaderModal").modal("hide");
                    });
                } else {
                    toastr.error(resp.message, 'Error');
                    $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                    $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve RTB Documents");
                }
            },
            error: function(resp){
                // $("#loaderModal").modal("hide");
                toastr.error(resp.message, 'Error');
                $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve RTB Documents");
            }
        });

    });

</script>

