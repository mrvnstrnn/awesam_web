@extends('layouts.main')

@section('content')
<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <h5 class="card-title">Add new vendor</h5>
                <form id="addVendorForm">
                    @csrf
                    <input type="hidden" name="vendor_id" id="vendor_id">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="vendor_sec_reg_name">SEC Registered Vendor Name</label>
                                <input id="vendor_sec_reg_name" type="text" class="form-control" 
                                    name="vendor_sec_reg_name" required autofocus placeholder="Registered vendor name here...">
            
                                <small id="vendor_sec_reg_name-error" class="form-text text-danger"></small>
                            </div>
                        </div>
        
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="vendor_acronym">Acronym Vendor Name </label>
                                <input id="vendor_acronym" type="text" class="form-control" 
                                    name="vendor_acronym" required placeholder="Vendor acronym name here...">
            
                                <small id="vendor_acronym-error" class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
        
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="vendor_fullname">Vendor System Admin Fullname </label>
                                <input id="vendor_fullname" type="text" class="form-control" 
                                    name="vendor_fullname" required placeholder="Vendor system admin fullname here...">
            
                                <small id="vendor_fullname-error" class="form-text text-danger"></small>
                            </div>
                        </div>
        
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="vendor_admin_email">Vendor System Admin Email Address</label>
                                <input id="vendor_admin_email" type="email" class="form-control" 
                                    name="vendor_admin_email" required placeholder="Vendor system admin email address here...">
            
                                <small id="vendor_admin_email-error" class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
        
                    <div class="form-row">
                        <div class="col-12">
                            <div class="position-relative form-group">
                                <label for="vendor_office_address">Official Head Office Address</label>
                                <input id="vendor_office_address" type="text" class="form-control" 
                                    name="vendor_office_address" required placeholder="Official head office address here...">
            
                                <small id="vendor_office_address-error" class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
        
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="vendor_saq_status">Status of SAQ </label>
                                <select name="vendor_saq_status" id="vendor_saq_status" class="form-control" required>
                                    <option value="">Please select status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Ongoing Accreditation</option>
                                </select>
            
                                <small id="vendor_saq_status-error" class="form-text text-danger"></small>
                            </div>
                        </div>
        
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="vendor_admin_email">Program</label><br>
        
                                @php
                                    $programs = App\Models\VendorProgram::get();
                                @endphp
        
                                @foreach ($programs as $program)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="vendor_program_id{{ $program->vendor_program_id  }}" name="vendor_program_id" value="{{ $program->vendor_program_id  }}">
                                        <label class="form-check-label" for="vendor_program_id{{ $program->vendor_program_id  }}">{{ $program->vendor_program }}</label>
                                    </div>
                                @endforeach
            
                                <small id="vendor_program_id-error" class="form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="javascript:void(0)" class="btn-shadow btn-wide mr-2 float-right btn-pill btn-hover-shine btn btn-default resetForm">Reset</a>
                        <button class="btn btn-primary pull-right add_vendor" type="button" data-href="{{ route('add.vendor') }}">Add vendor</button>
                    </div>
                </form>
            </div>
            
            <div class="col-md-2">
                <h5 class="card-title">Review Existing Vendors</h5>
                <a href="javascript:void(0);" class="list_vendors">Click Here & Show List</a>
            </div>
        </div>
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