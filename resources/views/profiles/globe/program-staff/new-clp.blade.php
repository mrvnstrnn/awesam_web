@extends('layouts.main')

@section('content')
<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }

    .select2-container .select2-selection--multiple .select2-selection__rendered {
        white-space: unset !important;
    }
</style>    

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="New CLP" activitytype="new clp"/>

@endsection


@section('modals')

<div class="ajax_content_box"></div>

{{-- <div class="modal fade" id="craetePrPoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
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
                                        Create PR Memo
                                    </h5>
                                </div>
                            </div>
                        </div> 

                        <form action="/print-to-pdf-pr-po" method="POST" class="pr_po_form" target="_blank">@csrf
                            <input type="hidden" name="file_name" id="file_name">
                            <div class="form_div">
                                <div class="card-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                                    
                                    <input type="hidden" class="form-control" name="site_category" id="site_category" value="none">
                                    <input type="hidden" class="form-control" name="activity_id" id="activity_id" value="2">
                                    <div class="form-row">
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="to">To</label>
                                                <input type="text" class="form-control" name="to" id="to">
                                                <small class="text-danger to-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="subject">Subject</label>
                                                <input type="text" class="form-control" name="subject" id="subject">
                                                <small class="text-danger subject-error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="thru">Thru</label>
                                                <input type="text" class="form-control" name="thru" id="thru">
                                                <small class="text-danger thru-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="date_created">Date Created</label>
                                                <input type="text" class="form-control" name="date_created" id="date_created" value="{{ \Carbon\Carbon::now() }}" readonly>
                                                <small class="text-danger date_created-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="from">From</label>
                                                <input type="text" class="form-control" name="from" id="from" value="{{ \Auth::user()->name }}" readonly>
                                                <small class="text-danger from-error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="group">Group</label>
                                                <input type="text" class="form-control" name="group" id="group" value="Network Technical" readonly>
                                                <small class="text-danger group-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="division">Division</label>
                                                <input type="text" class="form-control" name="division" id="division" value="Network Technical Group" readonly>
                                                <small class="text-danger division-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-12">
                                            <div class="form-group">
                                                <label for="department">Department</label>
                                                <input type="text" class="form-control" name="department" id="department" value="Site Aquisition and Management" readonly>
                                                <small class="text-danger department-error"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="requested_amount">Requested Amount</label>
                                                <input type="number" class="form-control" name="requested_amount" id="requested_amount" value="0" readonly>
                                                <small class="text-danger requested_amount-error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="budget_source">Budget Source</label>
                                                <input type="text" class="form-control" name="budget_source" id="budget_source">
                                                <small class="text-danger budget_source-error"></small>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="form-row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="recommendation">Recommendation</label>
                                                <textarea style="resize: vertical;" type="text" cols="50" rows="5" class="form-control" name="recommendation" id="recommendation"></textarea>
                                                <small class="text-danger recommendation-error"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="vendor">Vendor</label>
                                                <select name="vendor" id="vendor" class="form-control">
                                                    @php
                                                        $vendors = \App\Models\Vendor::select("vendor.vendor_sec_reg_name", "vendor.vendor_id", "vendor.vendor_acronym")
                                                                            ->join("vendor_programs", "vendor_programs.vendors_id", "vendor.vendor_id")
                                                                            ->where("vendor_programs.programs", 1)
                                                                            ->get();
                                                    @endphp
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_sec_reg_name }} ({{ $vendor->vendor_acronym }})</option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger vendor-error"></small>
                                            </div>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="financial_analysis">Add Site</label>
                                                @php
                                                    $sites = \DB::connection('mysql2') 
                                                                    ->table("site")
                                                                    ->leftjoin("vendor", "site.site_vendor_id", "vendor.vendor_id")
                                                                    ->leftjoin("location_regions", "site.site_region_id", "location_regions.region_id")
                                                                    ->leftjoin("location_provinces", "site.site_province_id", "location_provinces.province_id")
                                                                    ->leftjoin("location_lgus", "site.site_lgu_id", "location_lgus.lgu_id")
                                                                    ->leftjoin("location_sam_regions", "location_regions.sam_region_id", "location_sam_regions.sam_region_id")
                                                                    ->leftjoin("new_sites", "new_sites.sam_id", "site.sam_id")
                                                                    ->where('site.program_id', 1)
                                                                    ->where('activities->activity_id', '2')
                                                                    ->where('activities->profile_id', '8')
                                                                    ->get();
                                                @endphp
                                                <select name="financial_analysis[]" id="financial_analysis" class="form-control" multiple="multiple">
                                                    @foreach ($sites as $site)
                                                    <option class="option{{ $site->sam_id }}" value="{{ $site->sam_id }}">{{ $site->search_ring }}</option>
                                                    @endforeach
                                                </select>

                                                <button type="button" class="my-3 btn btn-primary btn-shadow btn-sm pull-right add_new_site">Add</button>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="table_financial_analysis table-responsive">
                                        <table class="table table-hovered">
                                            <thead>
                                                <tr>
                                                    <th>Search Ring Name</th>
                                                    <th>Region</th>
                                                    <th>Province</th>
                                                    <th>Gross Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div class="input_hidden"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body line_items_area" class="d-none" style="overflow-y: auto !important; max-height: calc(100vh - 210px);"></div>
                            <div class="file_view d-none">
                                <div class="card-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                                    <div class="file_view_child"></div>
                                    <button class="btn btn-shadow btn-sm btn-primary edit_form_pdf" type="button">Edit</button>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-primary add_pr_po">Create PR Memo</button>
                                <button type="submit" class="print_to_pdf d-none"></button>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection

@section('js_script')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    //////////////////////////////////////
    var profile_id = 8;
    var table_to_load = 'new_clp';
    // var main_activity = 'New Endorsements Globe';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  

<script>

    $(document).ready(function() {
    //     $(".table_financial_analysis table").DataTable().ajax.reload();
    // });

        $(".btn_create_pr").on("click", function(e){
            e.preventDefault();

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            // loader = '<div class="p-2">Loading...</div>';
            // $.blockUI({ message: loader });

            $.ajax({
                url: "/get-create-pr-memo",
                method: "POST",
                data: $(".pr_po_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    // if (!resp.error) {
                        // $.unblockUI();

                        $(".btn_create_pr").removeAttr("disabled");
                        $(".btn_create_pr").text("Create PR Memo");

                        $(".ajax_content_box").html(resp);
                        $("#craetePrPoModal").modal("show");
                    // } else {
                    //     Swal.fire(
                    //         'Error',
                    //         resp.message,
                    //         'error'
                    //     )
                    // }
                },
                error: function (resp){
                    // $.unblockUI();

                    $(".btn_create_pr").removeAttr("disabled");
                    $(".btn_create_pr").text("Create PR Memo");

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




@endsection