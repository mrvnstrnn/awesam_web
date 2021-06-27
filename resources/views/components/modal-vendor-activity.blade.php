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
                                    <div class="row p-2 pt-3    ">
                                        @foreach ($sub_activities as $sub_activity)
                                            @if($sub_activity->activity_id == $activity_id)
                                                <div class="col-md-6 btn_switch_show_action pt-3" data-sub_activity="{{ $sub_activity->sub_activity_name }}" data-sub_activity_id="{{ $sub_activity->sub_activity_id }}" data-action="{{ $sub_activity->action }}" data-with_doc_maker="{{ $sub_activity->with_doc_maker}}" data-required="">
                                                <H6><i class="pe-7s-cloud-upload pe-lg pt-2 mr-2"></i>{{ $sub_activity->sub_activity_name }}</H6>
                                                </div>
                                            @endif                                    
                                        @endforeach
                                        <div class="col-12 mt-5">
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
                                            <div class="dropzone dropzone_files_activities mt-0 mb-5">
                                                <div class="dz-message">
                                                    <i class="fa fa-plus fa-3x"></i>
                                                    <p><small class="sub_activity_name">Drag and Drop files here</small></p>
                                                </div>
                                            </div>                                            
                                            <div class="file_viewer d-none"></div>
                                            <div class="table-responsive table_uploaded_parent"></div>
                                        </div>
                                        <div id="action_doc_maker" class='d-none'>
                                            <textarea id="summernote" name="editordata" style="height:300px;"></textarea>
                                            <button class="btn btn-shadow float-right btn-success btn-sm mt-3">Print to PDF</button> 
                                        </div>     
                                        
                                        {{-- LESSOR ENGAGEMENT --}}
                                        <div id="action_lessor_engagement" class='d-none'>
                                            <div class="row py-5 px-4" id="control_box">
                                                <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Call">
                                                    <i class="fa fa-phone fa-4x" aria-hidden="true" title=""></i>
                                                    <div class="pt-3"><small>Call</small></div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Text">
                                                    <i class="fa fa-mobile fa-4x" aria-hidden="true" title=""></i>
                                                    <div class="pt-3"><small>Text</small></div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 my-3 text-center contact-lessor" data-value="Email">
                                                    <i class="fa fa-envelope fa-4x" aria-hidden="true" title=""></i>
                                                    <div class="pt-3"><small>Email</small></div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Site Visit">
                                                    <i class="fa fa-location-arrow fa-4x" aria-hidden="true" title=""></i>
                                                    <div class="pt-3"><small>Site Visit</small></div>

                                                </div>
                                            </div>
                                            <div class="row py-3 px-5 d-none" id="control_form">
                                                <div class="col-12 py-3">
                                                <form class="">
                                                    <div class="position-relative row form-group">
                                                        <label for="lessor_date" class="col-sm-3 col-form-label">Date</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" id="lessor_date" name="lessor_date" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="lessor_method" class="col-sm-3 col-form-label">Method</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="lessor_method" name="lessor_method" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="lessor_remarks" class="col-sm-3 col-form-label">Remarks</label>
                                                        <div class="col-sm-9">
                                                            <textarea name="lessor_remarks" id="lessor_remarks" class="form-control"></textarea>
                                                            <small class="text-danger lessor_remarks-errors"></small>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="lesor_approval" class="col-sm-3 col-form-label">Approval</label>
                                                        <div class="col-sm-9">
                                                            <select name="lessor_approval" id="lessor_approval" class="form-control">
                                                                <option value="active">Approval not yet secured</option>
                                                                <option value="approved">Approval Secured</option>
                                                                <option value="denied">Lessor Rejected</option>
                                                            </select>
                                                            <small class="text-danger lessor_approval-errors"></small>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group ">
                                                        <div class="col-sm-10 offset-sm-3">
                                                            <button class="btn btn-secondary save_engagement" type="button">Save Engagement</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-12 table-responsive table_lessor_parent">
                                                    {{-- <table class="table_lessor align-middle mb-0 table table-borderless table-striped table-hover w-100">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Method</th>
                                                                <th>Remarks</th>
                                                                <th>Approved</th>
                                                            </tr>
                                                        </thead>
                                                    </table> --}}
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

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.24/dataTables.bootstrap4.min.js" integrity="sha512-NQ2u+QUFbhI3KWtE0O4rk855o+vgPo58C8vvzxdHXJZu6gLu2aLCCBMdudH9580OmLisCC1lJg2zgjcJbnBMOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script src="/js/dropzone/dropzone.js"></script>

    <script>

    $(document).ready(function(){

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = mm + '/' + dd + '/' + yyyy;
        

        $(".contact-lessor").on("click", function(){

            $('#control_box').addClass('d-none');
            $('#control_form').removeClass('d-none');

            $("#lessor_method").val($(this).attr("data-value"));
            $("#lessor_date").val(today);
        });

        $(".btn_switch_back_to_actions").on("click", function(){
            $("#actions_box").addClass('d-none');
            $("#actions_list").removeClass('d-none');
            $("#action_doc_maker").addClass('d-none');

            // $("#action_lessor_engagement").removeClass('d-none');

            $("#control_form").addClass('d-none');
            $("#control_box").removeClass('d-none');
            
            // $("#doc_upload_button").addClass('d-none');
            // $('#doc_maker_button').removeClass('d-none');

            // $(".table_uploaded_parent").addClass('d-none');
            $('.file_viewer').addClass("d-none");

        });

        $(".btn_switch_show_action").on("click", function(){
            $("#actions_box").removeClass('d-none');
            $("#actions_list").addClass('d-none');
            $('#active_action').text($(this).attr('data-sub_activity'));
            // $("#action_doc_maker").removeClass('d-none');


            $(".table_uploaded").removeAttr("id");

            if($(this).attr('data-action')=="doc upload"){
                
                $('#action_doc_upload').removeClass('d-none');

                $(".dropzone_files_activities").attr("data-sub_activity_id", $(this).attr("data-sub_activity_id"));
                $(".dropzone_files_activities").attr("data-sub_activity_name", $(this).attr("data-sub_activity"));


                $(".table_uploaded_parent").html(
                    '<div class="table-responsive table_uploaded_parent">' +
                        '<table class="table_uploaded align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                            '<thead>' +
                                '<tr>' +
                                    '<th style="width: 5%">#</th>' +
                                    '<th>Filename</th>' +
                                    '<th style="width: 35%">Status</th>' +
                                    '<th>Date Uploaded</th>' +
                                '</tr>' +
                            '</thead>' +
                        '</table>' +
                    '</div>'
                );

                $(".table_uploaded").attr("id", "table_uploaded_files_"+$(this).attr("data-sub_activity_id"));
                console.log( ! $.fn.DataTable.isDataTable( '#table_uploaded_files_'+$(this).attr("data-sub_activity_id") ) );

                
                if (! $.fn.DataTable.isDataTable('#table_uploaded_files_'+$(this).attr("data-sub_activity_id")) ){   
                    $('#table_uploaded_files_'+$(this).attr("data-sub_activity_id")).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/get-my-uploaded-file-data/"+$(this).attr("data-sub_activity_id")+"/"+$(".ajax_content_box").attr("data-sam_id"),
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        },
                        dataSrc: function(json){
                            return json.data;
                        },
                        'createdRow': function( row, data, dataIndex ) {
                            $(row).attr('data-value', data.value);
                            $(row).attr('style', 'cursor: pointer');
                        },
                        columns: [
                            { data: "id" },
                            { data: "value" },
                            { data: "status" },
                            { data: "date_created" },
                        ],
                    });
                } else {
                    $('#table_uploaded_files_'+$(this).attr("data-sub_activity_id")).DataTable().ajax.reload();
                }

                if ("{{ \Auth::user()->getUserProfile()->id }}" == 3) {
                    $(".dropzone_files_activities").addClass("d-none");
                } else {
                    $(".dropzone_files_activities").removeClass("d-none");
                    
                    Dropzone.autoDiscover = false;
                    $(".dropzone_files_activities").dropzone({
                        addRemoveLinks: true,
                        maxFiles: 1,
                        // maxFilesize: 1,
                        paramName: "file",
                        url: "/upload-file",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (file, resp) {
                            if (!resp.error){
                                var sam_id = $(".ajax_content_box").attr("data-sam_id");
                                var sub_activity_id = this.element.attributes[1].value;
                                var sub_activity_name = this.element.attributes[2].value;

                                var file_name = resp.file;

                                this.removeFile(file);
                                
                                $.ajax({
                                    url: "/upload-my-file",
                                    method: "POST",
                                    data: {
                                        sam_id : sam_id,
                                        sub_activity_id : sub_activity_id,
                                        file_name : file_name,
                                        sub_activity_name : sub_activity_name
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function (resp) {
                                        if (!resp.error){

                                            $(".table_uploaded_parent").removeClass("d-none");

                                            $('#table_uploaded_files_'+sub_activity_id).DataTable().ajax.reload();

                                            $(".dropzone_files_activities").addClass("d-none");
                                            
                                            Swal.fire(
                                                'Success',
                                                resp.message,
                                                'success'
                                            )
                                        } else {
                                            Swal.fire(
                                                'Error',
                                                resp.message,
                                                'error'
                                            )
                                        }
                                    },
                                    error: function (file, response) {
                                        Swal.fire(
                                            'Error',
                                            resp.message,
                                            'error'
                                        )
                                    }
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    resp.message,
                                    'error'
                                )
                            }
                        },
                        error: function (file, resp) {
                            // toastr.error(resp.message, "Error");
                            // console.log(resp);
                            Swal.fire(
                                'Error',
                                resp,
                                'error'
                            )
                        }
                    });
                }
                
                if($(this).attr('data-with_doc_maker')=="1"){
                    $('.doc_maker_button').removeClass('d-none');
                }
                else {
                    $('.doc_maker_button').addClass('d-none');
                }

                $('.doc_upload_button').addClass('d-none')
            } else if($(this).attr('data-action')=="lessor engagement"){

                $(".table_lessor_parent").html(
                    '<table class="table_lessor align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>Date</th>' +
                                '<th>Method</th>' +
                                '<th>Remarks</th>' +
                                '<th>Approved</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>'
                );

                $(".table_lessor").attr("id", "table_lessor_"+$(this).attr("data-sub_activity_id"));
                
                if (! $.fn.DataTable.isDataTable('#table_lessor_'+$(this).attr("data-sub_activity_id")) ){
                    $('#table_lessor_'+$(this).attr("data-sub_activity_id")).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/get-my-uploaded-file-data/"+$(this).attr("data-sub_activity_id")+"/"+$(".ajax_content_box").attr("data-sam_id"),
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        },
                        dataSrc: function(json){
                            return json.data;
                        },
                        // 'createdRow': function( row, data, dataIndex ) {
                        //     $(row).attr('data-value', data.value);
                        //     $(row).attr('style', 'cursor: pointer');
                        // },
                        columns: [
                            { data: "date_created" },
                            { data: "value" },
                            { data: "status" },
                            { data: "date_created" },
                        ],
                    });
                } 

                $(".save_engagement").attr("data-sub_activity_id", $(this).attr("data-sub_activity_id"));
                $('#action_lessor_engagement').removeClass('d-none');

            } else {
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
            $('.doc_maker_button').removeClass('d-none');
        });

        $('.table_uploaded').on( 'click', 'tr td', function (e) {
            var extensions = ["pdf", "jpg", "png"];

            var values = $(this).parent().attr('data-value');

            console.log(values.split('.').pop());

            if( extensions.includes(values.split('.').pop()) == true) {     
                htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values + '" allowfullscreen></iframe>';
            } else {
                htmltoload = '<div class="text-center my-5"><a href="/files/' + values + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
            }
                    
            $('.file_viewer').html('');
            $('.file_viewer').html(htmltoload);

            $('.file_viewer').removeClass("d-none");
        });

        $(".save_engagement").on("click", function (e){
            e.preventDefault();

            var lessor_method = $("#lessor_method").val();
            var lessor_approval = $("#lessor_approval").val();
            var lessor_remarks = $("#lessor_remarks").val();
            var site_vendor_id = $("#modal_site_vendor_id").val();
            var program_id = $("#modal_program_id").val();
            var sam_id = $(".ajax_content_box").attr("data-sam_id");
            var sub_activity_id = $(this).attr("data-sub_activity_id");
            var site_name = $("#viewInfoModal .menu-header-title").text();

            $(this).attr('disabled', 'disabled');
            $(this).text('Processing...');

            $.ajax({
                url: "/add-engagement",
                method: "POST",
                data: {
                    lessor_method : lessor_method,
                    lessor_approval : lessor_approval,
                    lessor_remarks : lessor_remarks,
                    sam_id : sam_id,
                    sub_activity_id : sub_activity_id,
                    site_name : site_name,
                    site_vendor_id : site_vendor_id,
                    program_id : program_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    if (!resp.error) {

                        $('#table_lessor_'+sub_activity_id).DataTable().ajax.reload(function (){
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )

                            $("#lessor_remarks").val("");
                            $(".save_engagement").removeAttr('disabled');
                            $(".save_engagement").text('Save Engagement');
                        });
                        
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $("." + index + "-error").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }
                            $(".save_engagement").removeAttr('disabled');
                            $(".save_engagement").text('Save Engagement');
                    }
                },
                error: function (resp){
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                            $(".save_engagement").removeAttr('disabled');
                            $(".save_engagement").text('Save Engagement');
                }
            });
        });

        $('#summernote').summernote({
            height: 300,
            focus: true
        });


    });

    </script>