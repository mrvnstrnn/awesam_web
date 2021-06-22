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
                                    $sub_activities = json_decode($site[0]->sub_activity);
                                @endphp
                                <div id="actions_list" class="">
                                    <div class="row border-bottom">
                                        <div class="col-8">
                                            <H5>Actions to Complete</H5>
                                        </div>
                                        <div class="col-4">
                                            {{-- <button class="float-right p-2 pt-1 -mt-4 btn btn-outline btn-outline-dark btn-xs "><small>MARK AS COMPLETED</small></button>                                             --}}
                                        </div>
                                    </div>
                                    <div class="row p-2 pt-3    ">
                                        @foreach ($sub_activities as $sub_activity)
                                            @if($sub_activity->activity_id == $activity_id)
                                                <div class="col-md-6 btn_switch_show_action pt-3" data-sub_activity="{{ $sub_activity->sub_activity_name }}"  data-action="{{ $sub_activity->action }}" data-with_doc_maker="{{ $sub_activity->with_doc_maker}}" data-required="">
                                                <H6><i class="pe-7s-cloud-upload pe-lg pt-2 mr-2"></i>{{ $sub_activity->sub_activity_name }}</H6>
                                                </div>
                                            @endif                                    
                                        @endforeach
                                        <div class="col-12 mt-3">
                                        <small>* Required actions are in bold letters</small>
                                        </div>
                                    </div>
                                </div>
                                <div id="actions_box" class="d-none">
                                    <div class="row border-bottom">
                                        <div class="col-6">
                                            <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
                                        </div>
                                        <div class="col-6 align-right  text-right">
                                            <button class="doc_maker_button btn btn-outline btn-outline-primary btn-sm mb-3 d-none">Document Maker</button>     

                                            <button class="doc_upload_button btn btn-outline btn-outline-primary btn-sm mb-3 d-none">Upload Document</button>                                            
                                        </div>
                                    </div>

                                    <div class="row pt-4">
                                        <div class="col-md-12">
                                            <H5 id="active_action">Letter of Intent</H5>
                                        </div>
                                    </div>
                                    <div class="action_box_content">

                                        <div id="action_doc_upload" class='d-none'>
                                            <div class="dropzone dropzone_files mt-0">
                                                <div class="dz-message">
                                                    <i class="fa fa-plus fa-3x"></i>
                                                    <p><small class="sub_activity_name">Drag and Drop files here</small></p>
                                                </div>
                                            </div>
                                            <button class="btn btn-shadow float-right btn-success btn-sm mt-3">Upload Document</button> 
                                        </div>
                                        <div id="action_doc_maker" class='d-none'>
                                            <textarea id="summernote" name="editordata" style="height:300px;"></textarea>
                                            <button class="btn btn-shadow float-right btn-success btn-sm mt-3">Print to PDF</button> 
                                        </div>                                        
                                        <div id="action_lessor_engagement" class='d-none'>
                                            <div class="row py-5 px-4" id="control_box">
                                                <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor">
                                                    <i class="fa fa-phone fa-4x" aria-hidden="true" title=""></i>
                                                    <div class="pt-3"><small>Call</small></div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor">
                                                    <i class="fa fa-mobile fa-4x" aria-hidden="true" title=""></i>
                                                    <div class="pt-3"><small>Text</small></div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 my-3 text-center contact-lessor">
                                                    <i class="fa fa-envelope fa-4x" aria-hidden="true" title=""></i>
                                                    <div class="pt-3"><small>Email</small></div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor">
                                                    <i class="fa fa-location-arrow fa-4x" aria-hidden="true" title=""></i>
                                                    <div class="pt-3"><small>Site Visit</small></div>

                                                </div>
                                            </div>
                                            <div class="row py-3 px-5 d-none" id="control_form">
                                                <div class="col-12 py-3">
                                                <form class="">
                                                    <div class="position-relative row form-group">
                                                        <label for="exampleSelect" class="col-sm-3 col-form-label">Date</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="exampleSelect" class="col-sm-3 col-form-label">Method</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="exampleText" class="col-sm-3 col-form-label">Remarks</label>
                                                        <div class="col-sm-9">
                                                            <textarea name="text" id="exampleText" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="exampleText" class="col-sm-3 col-form-label">Approval</label>
                                                        <div class="col-sm-9">
                                                            <select name="select" id="exampleSelect" class="form-control">
                                                                <option value="false">Approval not yet secured</option>
                                                                <option value="true">Approval Secured</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group ">
                                                        <div class="col-sm-10 offset-sm-3">
                                                            <button class="btn btn-secondary">Save Engagement</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Method</th>
                                                                <th>Remarks</th>
                                                                <th>Approved</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>2021-01-01</td>
                                                                <td>Call</td>
                                                                <td>Lessor not available</td>
                                                                <td>No</td>
                                                            </tr>
                                                            <tr>
                                                                <td>2021-01-05</td>
                                                                <td>Call</td>
                                                                <td>Lessor went to Hong Kong</td>
                                                                <td>No</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>                                                                                
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


        $(".contact-lessor").on("click", function(){
            $('#control_box').addClass('d-none');
            $('#control_form').removeClass('d-none');
        });

        $(".btn_switch_back_to_actions").on("click", function(){
            $("#actions_box").addClass('d-none');
            $("#actions_list").removeClass('d-none');
            $("#action_doc_maker").addClass('d-none');

            $("#control_form").addClass('d-none');
            $("#control_box").removeClass('d-none');
            
            // $("#doc_upload_button").addClass('d-none');
            // $('#doc_maker_button').removeClass('d-none');

        });

        $(".btn_switch_show_action").on("click", function(){
            $("#actions_box").removeClass('d-none');
            $("#actions_list").addClass('d-none');
            $('#active_action').text($(this).attr('data-sub_activity'));
            


            if($(this).attr('data-action')=="doc upload"){
                $('#action_doc_upload').removeClass('d-none');
                
                if($(this).attr('data-with_doc_maker')=="1"){
                    $('.doc_maker_button').removeClass('d-none');
                }
                else {
                    $('.doc_maker_button').addClass('d-none');
                }

                $('.doc_upload_button').addClass('d-none')
            }
            else if($(this).attr('data-action')=="lessor engagement"){

                $('#action_lessor_engagement').removeClass('d-none');

            } 
            else {
                $('#action_doc_upload').addClass('d-none');
                $('.doc_maker_button').addClass('d-none');
                
            }
        });

        $(".doc_maker_button").on("click", function(){
            $('#action_doc_upload').addClass('d-none');
            $('#action_doc_maker').removeClass('d-none');
            $(this).addClass('d-none');
            $('.doc_upload_button').removeClass('d-none')
        });

        $(".doc_upload_button").on("click", function(){
            $('#action_doc_upload').removeClass('d-none');
            $('#action_doc_maker').addClass('d-none');
            $(this).addClass('d-none');
            $('.doc_maker_button').removeClass('d-none')
        });



        $('#summernote').summernote({
            height: 300,
            focus: true
        });

    </script>