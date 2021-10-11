<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
</style>
<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title">
                                        {{ $activity }}
                                    </h5>
                                </div>
                            </div>
                        </div> 
                        
                        @php
                            $json = json_decode($data->value);
                        @endphp
                        <div class="row p-2">
                            <div class="col-lg-5 text-center m-auto">
                                <h3 style="font-size: 56px; font-weight: 700;">{{ date('M', strtotime($json->site_schedule)) }}</h3>
                                <h1 style="font-size: 70px; font-weight: 900;">{{ date('d', strtotime($json->site_schedule)) }}</h1>
                            </div>
                            <div class="col-lg-7">
                                <form class="jtss_form">
                                    <div class="form-row"> 
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label for="jtss_schedule">JTSS Schedule</label>
                                                <input type="text" id="jtss_schedule" name="jtss_schedule" value="{{ $json->site_schedule }}" class="form-control" readonly />
                                                <small class="jtss_schedule-error text-danger"></small>
                                            </div>        
                                        </div>
                                    </div>
                                    <div class="form-row"> 
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <label for="remarks" class="">Remarks</label>
                                                <textarea class="form-control"  rows="10" id="remarks" name="remarks" style="height: 175px;" readonly>{{ $json->remarks }}</textarea>
                                                <small class="remarks-error text-danger"></small>
                                            </div>        
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row p-2">
                            <div class="col-12">
                                <button class="btn btn-shadow btn-sm btn-primary pull-right">Approve</button>
                                <button class="btn btn-shadow btn-sm btn-danger pull-right mr-1">Reject</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>