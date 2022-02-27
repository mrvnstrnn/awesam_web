
{{-- COLOC MINI DASHBOARD --}}

@if (\Auth::user()->profile_id == 6 && $tableheader =="New Endorsements")

    <button class="mb-3 btn btn-dark show-filters"><i class="fa fa-fw fa-lg" aria-hidden="true"></i> Filters</button>

    <div class="filter_text d-none">
        <label>Filtering: </label>

    </div>

    <div id="filters-box" class="d-none bg-light rounded border p-3 mb-3">
        <form id="coloc-filters-form">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-12">
                    <div class="form-group">
                        <label>Site Type</label>
                        <select name="site_type" id="site_type" class="form-control">
                            <option value="">-</option>
                            <option value="GREENFIELD">GREENFIELD</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-12">
                    <div class="form-group">
                        <label>Program</label>
                        <select name="program" id="program" class="form-control">
                            <option value="">-</option>
                            <option value="ENABLER">ENABLER</option>
                            <option value="WTTX">WTTX</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-12">
                    <div class="form-group">
                        <label>Technology</label>
                        <select name="technology" id="technology" class="form-control">
                            <option value="">-</option>
                            <option value="CARRIER UPGRADE">CARRIER UPGRADE</option>
                            <option value="L21">L21</option>
                            <option value="FE TO GE">FE TO GE</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <button type="button" class="pull-right btn btn-primary filter-records">Filter Records</button>
                <button type="button" class="pull-right btn btn-success mr-1 clear-records">Clear Filter</button>
                <button type="button" class="pull-right btn btn-secondary mr-1 close-filters">Close</button>
            </div>
        </div>
    </div>

@endif
