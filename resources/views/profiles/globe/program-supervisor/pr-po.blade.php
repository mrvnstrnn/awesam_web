@extends('layouts.main')

@section('content')
<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
</style>    

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="PR / PO" activitytype="site prmemo"/>

@endsection

@section('modals')

    {{-- <x-milestone-modal /> --}}

    {{-- <div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="background-color: transparent; border: 0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="main-card mb-3 card ">

                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-dark">
                                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                    <div class="menu-header-content btn-pane-right">
                                        <div>
                                            <h5 class="menu-header-title">
                                                {{ $site[0]->site_name }}
                                                @if(!is_null($site[0]->site_category) && $site[0]->site_category != "none")
                                                    <span class="mr-3 badge badge-secondary"><small class="site_category">{{ $site[0]->site_category }}</small></span>
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="btn-actions-pane-right">

                                        </div>

                                        <div id="actions_box" class="d-none">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="ajax_content_box">

    </div> --}}
    

@endsection

@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 9;
    var table_to_load = 'pr_po';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>
<script type="text/javascript" src="/js/DTmaker.js"></script>
<script type="text/javascript" src="/js/modal-loader.js"></script>

@endsection