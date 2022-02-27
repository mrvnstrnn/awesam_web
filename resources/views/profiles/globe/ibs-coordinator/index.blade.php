@extends('layouts.home')

@section('content')

    <x-home-dashboard />  

@endsection

@section('modals')
    <div class="modal fade" id="rtb_tracker_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <div class="dropdown-menu-header">
                    <div class="dropdown-menu-header-inner bg-dark">
                        <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                        <div class="menu-header-content btn-pane-right">
                            <h5 class="menu-header-title">
                                RTB Tracker
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="rtb_tracker_table">
                            <thead>
                                <tr>
                                    <th>Site Name</th>
                                    <th>SAM ID</th>
                                    <th>Region</th>
                                    <th>Vendor</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts.rtb-tracker')