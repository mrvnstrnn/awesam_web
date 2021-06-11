@extends('layouts.main')

@section('content')

<ul class="tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-dar" data-toggle="tab" href="#tab-content-dar">
            <span>Daily Activity Report</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane tabs-animation fade active show" id="tab-content-dar" role="tabpanel">
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                        Daily Activity Report
                        </div>      
                    </div>
                    <div class="card-body" style="overflow-x: scroll">
                        <x-dar-table />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section("js_script")

<script>

$(document).ready( function () {
    $('#dar_table').DataTable();
} );    
</script>
@endsection