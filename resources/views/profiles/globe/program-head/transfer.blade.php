@extends('layouts.main')

@section('content')

<style>
    .modalTerminate {
        cursor: pointer;
    }
</style>

<div class="main-card mb-3 card">
    <div class="card-body">
        <table style="width: 100%;" id="vendor-list-table" data-href="{{ route('vendor.list', 'listVendor') }}" class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    {{-- <th>Status</th> --}}
                    <th>SEC Reg. Name</th>
                    <th>Acronym</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th style="width: 20%;">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@endsection

@section('modals')
    <div class="modal fade" id="terminationModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terminate Vendor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <p>Are you sure you want to terminate <b class="vendor_sec_reg_name"></b>?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary terminate_button" data-href="{{ route('terminate.vendor') }}">Terminate</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vendor Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="viewInfoForm">
                        <div class="container-fluid">
                            <div class="form-group">
                                <label for="vendor_sec_reg_name">Sec Reg Name</label>
                                <input type="text" name="vendor_sec_reg_name" id="vendor_sec_reg_name" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="vendor_acronym">Acronym</label>
                                <input type="text" name="vendor_acronym" id="vendor_acronym" readonly class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="vendor_office_address">Office Address</label>
                                <input type="text" name="vendor_office_address" id="vendor_office_address" readonly class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="vendor_admin_name">Admin Name</label>
                                <input type="text" name="vendor_admin_name" id="vendor_admin_name" readonly class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="vendor_admin_email">Admin Email</label>
                                <input type="text" name="vendor_admin_email" id="vendor_admin_email" readonly class="form-control">
                            </div>

                            <div class="vendor_profile"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.24/dataTables.bootstrap4.min.js" integrity="sha512-NQ2u+QUFbhI3KWtE0O4rk855o+vgPo58C8vvzxdHXJZu6gLu2aLCCBMdudH9580OmLisCC1lJg2zgjcJbnBMOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/sts-vendor-admin.js') }}"></script>
@endsection