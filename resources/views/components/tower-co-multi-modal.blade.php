<div id="towerco_multi" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark">Update Multiple Sites</h5>
            <button type="button" class="close modal_close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pb-0" >
            <div class="card mb-0" style="box-shadow: none;">
                <div class="card-header">
                    <ul class="nav nav-justified">
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-actor-multi" class="nav-link active">{{ $actor }}</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-sites-multi" class="nav-link">Sites to Update</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-towerco-actor-multi" role="tabpanel" style="height:auto;">
                        </div>
                        <div class="tab-pane" id="tab-towerco-sites-multi" role="tabpanel" style="height:auto;">
                            <table class="table-responsive table table-bordered" id="selected-sites">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Serial No.</th>
                                        <th>REGION</th>
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
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal_close"  data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary actor_update">Update</button>
        </div>
        </div>
    </div>
</div>