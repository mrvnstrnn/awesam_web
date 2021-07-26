<style>
    #towerco-table tbody tr:hover {
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header" style="overflow: hidden; opacity: 0.8; background-image: url('/images/modal-background.jpeg');   background-repeat: no-repeat; background-size: 100%;"> 
                        <h5 class="menu-header-title text-dark">
                            <i class="header-icon lnr-layers icon-gradient bg-dark mr-1"></i>
                            {{ $actor }}
                        </h5>
            </div> 
            <div class="card-body">

                <table id="towerco-table" 
                    class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table"
                    data-href="{{ route('get_towerco_all', $actor) }}"
                    data-program_id="6" data-table_loaded="false"
                    style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Serial Number</th>
                            <th>Region</th>
                            <th>Search Ring</th>
                            <th>TOWERCO</th> 
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>           