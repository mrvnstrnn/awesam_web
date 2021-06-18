<div class="mb-3 profile-responsive card">
    <div class="dropdown-menu-header">
        <div class="dropdown-menu-header-inner bg-dark">
            <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
            <div class="menu-header-content btn-pane-right">
                <div class="avatar-icon-wrapper mr-3 avatar-icon-xl btn-hover-shine">
                    <div class="avatar-icon rounded">
                        <img src="/images/avatars/3.jpg" alt="Avatar 5">
                    </div>
                </div>
                <div>
                    <h5 class="menu-header-title">{{ $agentname }}</h5>
                    <h6 class="menu-header-subtitle">Agent</h6>
                </div>
            </div>
        </div>
    </div>                    


    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="widget-content pt-2 pl-0 pb-2 pr-0">
                <div class="text-center">
                    <h5 class="widget-heading opacity-4 mb-0">Assigned Sites</h5>
                </div>
            </div>
        </li>
        <li class="p-0 list-group-item">
            <ul class="list-group list-group-flush">
                @foreach($agentsites as $what_site)
                <li class="list-group-item agent_sites">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading"><a href="#" data-sam_id="{{ $what_site->sam_id }}" data-site="{{ $what_site->site_name }}" data-activity="">{{ $what_site->site_name }}</a></div>
                                <div class="widget-subheading">{{ $what_site->sam_id }}</div>
                            </div>
                        </div>
                    </div>
                </li>                        
                @endforeach
            </ul>

        </li>
    </ul>   
</div> 
<script>
        $('.agent_sites').on( 'click', 'a', function (e) {
            $('#viewInfoModal').modal("hide");


                var sam_id = $(this).attr('data-sam_id');
                var activity = $(this).attr('data-activity')
                var site = $(this).attr("data-site");

                console.log(sam_id);
                console.log(activity);
                console.log(site);

                loader = '<div class="p-2">Loading...</div>';
                $.blockUI({ message: loader });


                $("#viewInfoModal .modal-title").text($(this).attr("data-site") + " : " + activity);

                $.ajax({
                    url: "/get-all-docs",
                    method: "POST",
                    data: {
                        site : site,
                        activity : activity,
                        mode : table_to_load,
                        sam_id : sam_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                     },
          
                    success: function (resp){

                        $('.ajax_content_box').html("");   
                        $('.ajax_content_box').html(resp);   

                        $.unblockUI();
                        $('#viewInfoModal').modal('show');


                    },
                    complete: function(){
                        // $('#loader_modal').modal('hide');
                        // $('.modal-backdrop').hide();
                    },
                    error: function (resp){
                        toastr.error(resp.message, "Error");
                    }
                })
                .done(function(){
                    $('.file_list_item').first().click();
                });


        });
</script>
