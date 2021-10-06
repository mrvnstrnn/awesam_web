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
    th {
        font-size: 12px;
    }
    td {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 13px;
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
                        <button class=" btn btn-dark show-filters mr-1"><i class="fa fa-fw fa-lg" aria-hidden="true"></i> Filters</button>                        
                        <button class=" btn btn-dark export-button mr-1"><i class="fa fa-fw fa-lg" aria-hidden="true"></i> Export</button>                        
                    </div>
                </div>
            </div> 
            <div class="card-body">
                <div id="filters-box" class="d-none bg-light rounded border p-3" style="margin-bottom: 20px;">
                    <form id="towerco-filters-form">
                        <div class="row">
                            @php
                                if($actor != 'TowerCo'){
                                    $col_lg = '3';
                                } else {
                                    $col_lg = '4';
                                }
                            @endphp
                            @if($actor != 'TowerCo')
                            <div class="col-sm-6 col-md-6 col-lg-{{ $col_lg }}">
                                <div class="form-group">
                                    <label>TOWERCO</label>
                                    <select class="form-control mb-0" name="towerco">
                                        @php
                                            $recs = \DB::connection('mysql2')
                                                ->table('towerco')
                                                ->select('TOWERCO')
                                                ->distinct()
                                                ->where('TOWERCO', '!=', '')
                                                ->orderBy('TOWERCO')
                                                ->get();
                                        @endphp
                                        <option value="-">-</option>                                    
                                        @foreach ($recs as $rec)
                                            <option value="{{ $rec->TOWERCO }}">{{ $rec->TOWERCO }}</option>                                    
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                                <input type="hidden" value="-" name="towerco" />
                            @endif
                            <div class="col-sm-6 col-md-6 col-lg-{{ $col_lg }}">
                                <div class="form-group">
                                    <label>REGION</label>
                                    <select class="form-control mb-0" name="region">
                                        @php
                                            $recs = \DB::connection('mysql2')
                                                ->table('towerco')
                                                ->select('REGION')
                                                ->distinct()
                                                ->where('REGION', '!=', '')
                                                ->orderBy('REGION')
                                                ->get();
                                            // dd($recs);
                                        @endphp
                                        <option value="-">-</option>                                    
                                        @foreach ($recs as $rec)
                                            <option value="{{ $rec->REGION }}">{{ $rec->REGION }}</option>                                    
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-{{ $col_lg }}">
                                <div class="form-group">
                                    <label>TSSR STATUS</label>
                                    <select class="form-control mb-0" name="tssr_status">
                                        @php
                                            $recs = \DB::connection('mysql2')
                                                ->table('towerco')
                                                ->select('TSSR STATUS')
                                                ->distinct()
                                                ->where('TSSR STATUS', '!=', '')
                                                ->orderBy('TSSR STATUS')
                                                ->get();
                                            // dd($recs);
                                        @endphp
                                        <option value="-">-</option>                                    
                                        @foreach ($recs as $rec)
                                            <option value="{{ $rec->{'TSSR STATUS'} }}">{{ $rec->{'TSSR STATUS'} }}</option>                                    
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-{{ $col_lg }}">
                                <div class="form-group">
                                    <label>MILESTONE STATUS</label>
                                    <select class="form-control mb-0" name="milestone_status">
                                        @php
                                            $recs = \DB::connection('mysql2')
                                                ->table('towerco')
                                                ->select('MILESTONE STATUS')
                                                ->distinct()
                                                ->where('MILESTONE STATUS', '!=', '')
                                                ->orderBy('MILESTONE STATUS')
                                                ->get();
                                            // dd($recs);
                                        @endphp
                                        <option value="-">-</option>                                    
                                        @foreach ($recs as $rec)
                                            <option value="{{ $rec->{'MILESTONE STATUS'} }}">{{ $rec->{'MILESTONE STATUS'} }}</option>                                    
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{ $actor }}" name="actor" />
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="button" class="pull-right btn btn-primary filter-records">Filter Records</button>
                            <button type="button" class="pull-right btn btn-secondary mr-1 close-filters">Close</button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">

                    <table id="towerco-table" 
                        class="compact align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table"
                        data-href="{{ route('get_towerco_all', $actor) }}"
                        data-program_id="6" data-table_loaded="false"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th></th> 
                                <th>SEARCH RING</th>
                                <th>TOWERCO</th> 
                                <th>PROJECT TAG</th>
                                <th>MILESTONE STATUS</th>
                                <th>LOCATION</th>
                                <th>GRID</th>
                                <th>TSSR STATUS</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>           