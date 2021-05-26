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
                                            <input name="vendor_status" value="Active" id="vendor_status" type="radio" class="form-check-input">
                                            Active
                                        </label>
                                    </div>
                                    <div class="position-relative form-check-inline">
                                        <label class="form-check-label">
                                            <input name="vendor_status" value="Ongoing Accreditation" id="vendor_status" type="radio" class="form-check-input">
                                            Ongoing Accreditation
                                        </label>
                                    </div>
                                    <small id="vendor_status-error" class="form-text text-danger"></small>
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
                                            $programs = App\Models\Program::get();
                                        @endphp
                
                                        @foreach ($programs as $program)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="vendor_program_id{{ $program->program_id  }}" name="vendor_program_id[]" value="{{ $program->program_id  }}">
                                                <label class="form-check-label" for="vendor_program_id{{ $program->program_id  }}">{{ $program->program }}</label>
                                            </div>
                                        @endforeach
                    
                                        <small id="vendor_program_id-error" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>  
                        <div class="form-row">
                            <div class="col-md-3">
                                <H5>Vendor Profile</H5>
                            </div>
                            <div class="col-md-9">
                                <div class="form-row">
                                    <div class="col-12">
                                        @php
                                            $vendor_profiles = \DB::connection('mysql2')->table('vendor_profile')->get();
                                        @endphp

                                        @foreach ($vendor_profiles as $vendor_profile)
                                        {{-- <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="vendor_profile_id" id="vendor_profile_id{{ $vendor_profile->id }}" value="{{ $vendor_profile->id }}">
                                                {{ $vendor_profile->profile_type }}
                                            </label>
                                        </div> --}}
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="vendor_profile_id{{ $vendor_profile->id }}" name="vendor_profile_id[]" value="{{ $vendor_profile->id }}">
                                            <label class="form-check-label" for="vendor_profile_id{{ $vendor_profile->id }}">{{ $vendor_profile->profile_type }}</label>
                                        </div>
                                        @endforeach

                                        <small id="vendor_profile_id-error" class="form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>                            
                        <div class="form-row">
                            <div class="col-md-3">
                                <H5>Administrator</H5>
                            </div>
                            <div class="col-md-9">
                                <div class="form-row">
                                    <div class="col-6">
                                        <div class="position-relative form-group">
                                            <label for="vendor_firstname">Firstname </label>
                                            <input id="vendor_firstname" type="text" class="form-control" 
                                                name="vendor_firstname" required placeholder="Vendor system admin firstname here...">
                        
                                            <small id="vendor_firstname-error" class="form-text text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="position-relative form-group">
                                            <label for="vendor_lastname">Lastname</label>
                                            <input id="vendor_lastname" type="text" class="form-control" 
                                                name="vendor_lastname" required placeholder="Vendor system admin lastname here...">
                        
                                            <small id="vendor_lastname-error" class="form-text text-danger"></small>
                                        </div>
                                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.24/dataTables.bootstrap4.min.js" integrity="sha512-NQ2u+QUFbhI3KWtE0O4rk855o+vgPo58C8vvzxdHXJZu6gLu2aLCCBMdudH9580OmLisCC1lJg2zgjcJbnBMOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/sts-vendor-admin.js') }}"></script>
@endsection