<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
    
    .dropzone {
        min-height: 20px !important;
        border: 2px dashed #3f6ad8 !important;
        border-radius: 10px;
        padding: unset !important;
    }

    .ui-datepicker.ui-datepicker-inline {
       width: 100% !important;
    }
    
    .ui-datepicker table {
        font-size: 1.3em;
    }
    
</style>    
    
    <input id="modal_sam_id" type="hidden" value="{{ $site[0]->sam_id }}">
    <input id="modal_activity_name" type="hidden" value="{{ str_replace(" ", "_", strtolower($site[0]->activity_name)) }}">
    <input id="modal_site_vendor_id" type="hidden" value="{{ $site[0]->vendor_id }}">
    <input id="modal_program_id" type="hidden" value="{{ $site[0]->program_id }}">

    <div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="background-color: transparent; border: 0">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="main-card mb-3 card ">

                            <div class="dropdown-menu-header p-0">
                                <div class="dropdown-menu-header-inner bg-dark">
                                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                    <div class="menu-header-content text-left">
                                        <div>
                                            <h5 class="menu-header-title">
                                                {{ $site[0]->site_name }}
                                                @if($site[0]->site_category != 'none')
                                                    <span class="mr-3 badge badge-secondary"><small>{{ $site[0]->site_category }}</small></span>
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="mt-2">
                                            @php
                                            if (isset($site[0]->end_date)) {
                                    
                                                if($site[0]->end_date > now()){
                                                    $badge_color = "success";
                                                } else {
                                                    $badge_color = "danger";
                                                }
                                            } else {
                                                $badge_color = "danger";
                                            }
                                    
                                            @endphp
                                    
                                            @if($main_activity == "")
                                                <span class="badge badge-dark text-sm mb-0 p-2">{{ isset($site[0]->stage_name) ? $site[0]->stage_name : "" }}</span>
                                                <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $site[0]->activity_name }}</span>
                                            @else
                                                <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $main_activity }}</span>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="card-body">

                                @php
                                $dynamicComponent = "site-modal-details-view";
                                @endphp
                                <x-dynamic-component :component="$dynamicComponent" :site="$site" :mainactivity="$main_activity" />

                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>


