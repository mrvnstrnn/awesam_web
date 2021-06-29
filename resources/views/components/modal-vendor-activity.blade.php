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


    .btn_switch_show_action:hover {
        cursor: pointer;
        color: blue;
    }

    .contact-lessor:hover {
        color: blue;
        cursor: pointer;
    }
    
</style>    
    
    <input id="modal_site_vendor_id" type="hidden" value="{{ $site[0]->site_vendor_id }}">
    <input id="modal_program_id" type="hidden" value="{{ $site[0]->program_id }}">

    <div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="background-color: transparent; border: 0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="main-card mb-3 card ">

                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-dark">
                                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                    <div class="menu-header-content btn-pane-right">
                                        <div>
                                            <h5 class="menu-header-title">
                                                {{ $site[0]->site_name }}
                                                @if($site[0]->site_category != null)
                                                    <span class="mr-3 badge badge-secondary"><small>{{ $site[0]->site_category }}</small></span>
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="btn-actions-pane-right">
                                            @php

                                                // dd($site);
                                                if($site[0]->end_date > now()){
                                                    $badge_color = "success";
                                                } else {
                                                    $badge_color = "danger";
                                                }

                                            @endphp

                                            @if($main_activity == "")
                                                <span class="ml-1 badge badge-light text-sm mb-0 p-2">{{ $site[0]->stage_name }}</span>
                                                <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $site[0]->activity_name }}</span>
                                            @else
                                                <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $main_activity }}</span>
                                            @endif
                                        </div>                                            
                                    </div>
                                </div>
                            </div> 

                            <div class="card-body">
                                @php
                                    $sub_activities = \DB::connection('mysql2')
                                                ->table('sub_activity')
                                                ->where('program_id', $site[0]->program_id)
                                                ->where('activity_id', $site[0]->activity_id)
                                                ->get();

                                    // dd($site[0]->activity_id) ;
                                    // $sub_activities = json_decode($site[0]->sub_activity);
                                @endphp
                                <div id="actions_list" class="">
                                    <div class="row border-bottom">
                                        <div class="col-8">
                                            <H5>Actions to Complete</H5>
                                        </div>
                                        <div class="col-4">
                                            <button class="float-right p-2 pt-1 -mt-4 btn btn-outline btn-outline-dark btn-xs "><small>MARK AS COMPLETED</small></button>                                            
                                        </div>
                                    </div>
                                    <div class="row p-2 pt-3">
                                        @foreach ($sub_activities as $sub_activity)
                                            @if($sub_activity->activity_id == $activity_id)
                                                <div class="col-md-6 btn_switch_show_action pt-3" data-sam_id="{{$site[0]->sam_id}}" data-sub_activity="{{ $sub_activity->sub_activity_name }}" data-sub_activity_id="{{ $sub_activity->sub_activity_id }}" data-action="{{ $sub_activity->action }}" data-with_doc_maker="{{ $sub_activity->with_doc_maker}}" data-required="">
                                                <H6><i class="pe-7s-cloud-upload pe-lg pt-2 mr-2"></i>{{ $sub_activity->sub_activity_name }}</H6>
                                                </div>
                                            @endif                                    
                                        @endforeach
                                        <div class="col-12 mt-5">
                                        <small>* Required actions are in bold letters</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="loading_div"></div>
                                <div id="actions_box" class="d-none">

                                </div>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>

    <script>

    $(document).ready(function(){

        $(".btn_switch_show_action").on("click", function(){

            $("#actions_box").removeClass('d-none');
            $("#actions_list").addClass('d-none');

            var active_subactivity = $(this).attr('data-sub_activity').replace("/", " ");
            var active_sam_id = $(this).attr('data-sam_id');
            var sub_activity_id = $(this).attr('data-sub_activity_id');
            var program_id = $('#modal_program_id').val();

            var loader =    '<div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">' +
                                '<div class="loader">' +
                                    '<div class="ball-scale-multiple">' +
                                    '<div></div>' +
                                    '<div></div>' +
                                    '<div></div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

            $(".loading_div").html(loader);
            $('#actions_box').html("");

            $.ajax({
                url: "/subactivity-view/" + active_sam_id + "/" + active_subactivity + "/" + sub_activity_id + "/" + program_id,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    if (!resp.error) {

                        $(".loading_div").html("");

                        $('#actions_box').html(resp);

                        
                    } else {

                        $(".loading_div").html("");
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )


                    }
                },
                error: function (resp){
                    $(".loading_div").html("");
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                }
            });

        });

    });

    </script>