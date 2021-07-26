<style>
    #towerco-table tbody tr:hover {
        cursor: pointer;
    }
    .site-add:hover {
        color: blue;
    }
    .site-added {
        color: green;
    }
    table.dataTable tbody tr.selected {
        color: black;
    }    
</style>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header" style=" opacity: 0.9; background-image: url('/images/modal-background.jpeg');   background-repeat: no-repeat; background-size: 100%;"> 
                <div class="row" style="width: 100%; margin: 0px; padding: 0px;">
                    <div class="col-xs-12 col-sm-12 col-md-6 p-0">
                        <h5 class=" menu-header-title text-dark align-left">
                            <i class="header-icon lnr-layers icon-gradient bg-dark mr-1"></i>
                            {{ $actor }}
                        </h5>        
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 p-0 text-md-right text-sm-center ">
                        <button class=" btn btn-dark d-none update-button ">Update Sites
                            <span class=" badge badge-pill badge-light">6</span>
                        </button>                        
                        <button class=" btn btn-dark export-button mr-1"><i class="fa fa-fw fa-lg" aria-hidden="true"></i> Export</button>                        
                    </div>
                </div>
            </div> 
            <div class="card-body">

                <table id="towerco-table" 
                    class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table table-responsive"
                    data-href="{{ route('get_towerco_all', $actor) }}"
                    data-program_id="6" data-table_loaded="false"
                    style="width: 100%;">
                    <thead>
                        <tr>
                            <th></th> 
                            <th>Serial Number</th>
                            <th>Region</th>
                            <th>Search Ring</th>
                            @if($actor != 'TowerCo')
                            <th>TOWERCO</th> 
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>           