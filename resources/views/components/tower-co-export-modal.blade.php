<div id="towerco_export" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark">Export TowerCo Data</h5>
            <button type="button" class="close modal_close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pb-0" >
            <div class="card mb-0" style="box-shadow: none;">
                <div class="card-header">
                    <ul class="nav nav-justified">
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-actor-export" class="nav-link active">Export Filters</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-towerco-actor-export" role="tabpanel" style="height:auto;">
                            <div class="row border-bottom mb-1 pb-1">
                                <div class="col-md-4">
                                    TowerCo
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="select_towerco">

                                    </select>
                                </div>
                            </div>
                            <div class="row border-bottom mb-1 pb-1">
                                <div class="col-md-4">
                                    Region
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="select_region">

                                    </select>
                                </div>
                            </div>
                            <div class="row border-bottom mb-1 pb-1">
                                <div class="col-md-4">
                                    Province
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" id="select_province">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal_close"  data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary actor_update_multi">Export</button>
        </div>
        </div>
    </div>
</div>