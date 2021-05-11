@extends('layouts.main')

@section('content')
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                    <i class="header-icon lnr-apartment icon-gradient bg-ripe-malin"></i>
                    Add New Vendor
                    </div>
                </div>
                <form id="addVendorForm">
                    <div class="card-body">
                            @csrf
                            <input type="hidden" name="vendor_id" id="vendor_id">
                            <div class="form-row">
                                <div class="col-md-3">
                                    <H5>Details</H5>
                                </div>                
                                <div class="col-md-9">
                                    <div class="position-relative form-group">
                                        <label for="vendor_sec_reg_name">SEC Registered Vendor Name</label>
                                        <input id="vendor_sec_reg_name" type="text" class="form-control" 
                                            name="vendor_sec_reg_name" required autofocus placeholder="Registered vendor name here...">
                    
                                        <small id="vendor_sec_reg_name-error" class="form-text text-danger"></small>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="vendor_acronym">Acronym Vendor Name </label>
                                        <input id="vendor_acronym" type="text" class="form-control" 
                                            name="vendor_acronym" required placeholder="Vendor acronym name here...">
                    
                                        <small id="vendor_acronym-error" class="form-text text-danger"></small>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="vendor_office_address">Official Head Office Address</label>
                                        <input id="vendor_office_address" type="text" class="form-control" 
                                            name="vendor_office_address" required placeholder="Official head office address here...">
                    
                                        <small id="vendor_office_address-error" class="form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>          
                            <div class="divider"></div>                            
                            <div class="form-row">
                                <div class="col-md-3">
                                    <H5>Status</H5>
                                </div>
                                <div class="col-md-9">
                                    <div class="position-relative form-group">
                                    {{-- <fieldset class="position-relative row form-group"> --}}
                                    {{-- <label for="vendor_saq_status">Status of Vendor </label> --}}
                                        <div class="position-relative form-check-inline">
                                            <label class="form-check-label">
                                                <input name="vendor_saq_status" value="1" id="vendor_saq_status" type="radio" class="form-check-input">
                                                Active
                                            </label>
                                        </div>
                                        <div class="position-relative form-check-inline">
                                            <label class="form-check-label">
                                                <input name="vendor_saq_status" value="0" id="vendor_saq_status" type="radio" class="form-check-input">
                                                Ongoing Accreditation
                                            </label>
                                        </div>
                                        <small id="vendor_saq_status-error" class="form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>                            
                            <div class="form-row">
                                    <div class="col-md-3">
                                        <H5>Programs</H5>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="position-relative form-group">
                                            {{-- <label for="vendor_admin_email">Program</label><br> --}}
                    
                                            @php
                                                $programs = App\Models\VendorProgram::get();
                                            @endphp
                    
                                            @foreach ($programs as $program)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="vendor_program_id{{ $program->vendor_program_id  }}" name="vendor_program_id" value="{{ $program->vendor_program_id  }}">
                                                    <label class="form-check-label" for="vendor_program_id{{ $program->vendor_program_id  }}">{{ $program->vendor_program }}</label>
                                                </div>
                                            @endforeach
                        
                                            <small id="vendor_program_id-error" class="form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>                            
                            <div class="form-row">
                                <div class="col-md-3">
                                    <H5>Administrator</H5>
                                </div>
                                <div class="col-md-9">
                                    <div class="position-relative form-group">
                                        <label for="vendor_fullname">Admin Fullname </label>
                                        <input id="vendor_fullname" type="text" class="form-control" 
                                            name="vendor_fullname" required placeholder="Vendor system admin fullname here...">
                    
                                        <small id="vendor_fullname-error" class="form-text text-danger"></small>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="vendor_admin_email">Admin Email Address</label>
                                        <input id="vendor_admin_email" type="email" class="form-control" 
                                            name="vendor_admin_email" required placeholder="Vendor system admin email address here...">
                    
                                        <small id="vendor_admin_email-error" class="form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="d-block text-right card-footer">
                        <a href="javascript:void(0)" class="btn-shadow btn-wide mr-2 btn-pill btn-hover-shine btn btn-default resetForm">Reset</a>
                        <button class="btn btn-primary add_vendor" type="button" data-href="{{ route('add.vendor') }}">Add vendor</button>
                        {{-- <button type="button" class="btn btn btn-outline-danger btn-bulk-acceptreject-endorsement" data-program="coloc" data-complete="false" id="" data-href="{{ route('accept-reject.endorsement') }}">Reject</button>
                        <button type="button" class="btn btn-primary btn-bulk-acceptreject-endorsement" data-program="coloc" data-complete="true" id="" data-href="{{ route('accept-reject.endorsement') }}">Accept Endorsement</button> --}}
                    </div>
                </form>
            </div>
        </div>
@endsection

@section('modals')
    <div class="modal fade" id="list_vendor_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Vendor List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>SEC Reg. Name</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Program</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="route_hidden" id="route_hidden" value="{{ route('all.vendors') }}">
@endsection

@section('js_script')
    <script src="{{ asset('js/sts-vendor-admin.js') }}"></script>
@endsection