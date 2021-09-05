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

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Memo" activitytype="pr memo"/>

@endsection

@section('modals')

<div class="ajax_content_box"></div>

<div class="modal fade" id="recommendationModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title">
                                        Recommendation
                                    </h5>
                                </div>
                            </div>
                        </div> 
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="recommendation_site">Recommendation</label>
                                            <textarea class="form-control w-100" name="recommendation_site" id="recommendation_site" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-secondary btn-sm btn-shadow no_thanks" data-action="not_recommend">No, thanks</button>
                            <button type="button" class="btn btn-primary btn-sm btn-shadow recommend" data-action="recommend">Recommend</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 10;
    var table_to_load = 'pr_memo';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>
<script type="text/javascript" src="/js/DTmaker.js"></script>
<script type="text/javascript" src="/js/modal-loader.js"></script>

@endsection