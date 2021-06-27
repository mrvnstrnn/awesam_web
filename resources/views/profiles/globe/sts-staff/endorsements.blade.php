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

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="New Endorsements" activitytype="new endorsements globe"/>

@endsection


@section('modals')

<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                        <h5 class="menu-header-title">
                                            Endorsement
                                        </h5>
                                </div>
                            </div>
                        </div> 

                        <div class="card-body">

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
    var profile_id = 6;
    var table_to_load = 'new_endorsements_globe';
    var main_activity = 'New Endorsements Globe';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
{{-- <script type="text/javascript" src="/js/modal-loader.js"></script>   --}}

<script>
    $('.assigned-sites-table').on( 'click', 'tr td:not(:first-child)', function (e) {
        e.preventDefault();
        $(document).find('#viewInfoModal').modal('show');
        console.log('test');
    } );

    $(".checkAll").click(function(e){
        e.preventDefault();
        var val = $(this).val();
        $('input[name='+val+']').not(this).prop('checked', this.checked);
    });

</script>




@endsection