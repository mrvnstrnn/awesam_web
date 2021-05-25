@extends('layouts.main')

@section('content')
    <style>
        .modalDataEndorsement {
            cursor: pointer;
        }

        table {
            width: 100% !important;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                    <i class="header-icon lnr-exit icon-gradient bg-ripe-malin"></i>
                    Vendor Sites
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="width: 100%;" id="vendor-sites-table" data-href="{{ route('site.vendortable', $vendor_id) }}" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 15px;">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox"  id="checkAll" class="custom-control-input">
                                            <label class="custom-control-label" for="checkAll">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th class="d-none d-md-table-cell">SAM ID</th>
                                    <th>Site</th>
                                    <th class="text-center  d-none d-sm-table-cell">Site Address</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="terminationModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <p>Are you sure you want to conmplete the termination of <b class="vendor_sec_reg_name"></b>?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary terminate_button" data-href="{{ route('terminate.vendor') }}">Complete</button>
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