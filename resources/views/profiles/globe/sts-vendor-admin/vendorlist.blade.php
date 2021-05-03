@extends('layouts.main')

@section('content')
<div class="main-card mb-3 card">
    <div class="card-body">
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
                @php
                    $vendors = new App\Models\Vendor();
                    $vendors->getAllVendor();
                @endphp
                @foreach ($vendors->getAllVendor() as $vendor)
                    <tr>
                        <td>{{ $vendor->vendor_sec_reg_name }} ({{ $vendor->vendor_acronym }})</td>
                        <td>{{ $vendor->vendor_fullname }}</td>
                        <td>{{ $vendor->vendor_admin_email }}</td>
                        <td>{{ $vendor->vendor_program }}</td>
                        <td>{{ $vendor->vendor_office_address }}</td>
                        <td><span class="badge badge-{{ $vendor->vendor_saq_status == 1 ? 'success' : 'warning' }}">{{ $vendor->vendor_saq_status == 1 ? 'Active' : 'Ongoing accreditation' }}</span></td>
                    </tr>   
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>SEC Reg. Name</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Program</th>
                    <th>Address</th>
                    <th>Status</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection