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
                    <th>SEC Reg. Name</th>
                    <th>Acronym</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    {{-- <th>Program</th> --}}
                    <th>Address</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
            {{-- <tbody>
                @php
                    $vendors = new App\Models\Vendor();
                @endphp
                @foreach ($vendors->getAllVendor()->chunk(100) as $chunk)
                    @foreach ($chunk as $vendor)
                        <tr>
                            <td>{{ $vendor->vendor_sec_reg_name }} ({{ $vendor->vendor_acronym }})</td>
                            <td>{{ $vendor->vendor_fullname }}</td>
                            <td>{{ $vendor->vendor_admin_email }}</td>
                            <td>{{ $vendor->vendor_program }}</td>
                            <td>{{ $vendor->vendor_office_address }}</td>
                            <td><span class="badge badge-{{ $vendor->vendor_saq_status == 1 ? 'success' : 'warning' }}">{{ $vendor->vendor_saq_status == 1 ? 'Active' : 'Ongoing accreditation' }}</span></td>
                        </tr>   
                    @endforeach
                @endforeach
            </tbody> --}}
        </table>
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
@endsection

@section('js_script')
    <script src="{{ asset('js/sts-vendor-admin.js') }}"></script>
@endsection