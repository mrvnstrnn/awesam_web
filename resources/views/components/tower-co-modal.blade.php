<div id="towerco_details" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark">Coop Details</h5>
            <button type="button" class="close modal_close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pb-0" >
            <div class="card mb-0" style="box-shadow: none;">
                <div class="card-header">
                    <ul class="nav nav-justified">
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-details" class="nav-link active">Details</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-actor" class="nav-link">{{ $actor }}</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-documents" class="nav-link">Documents</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-logs" class="nav-link">Logs</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-towerco-details" role="tabpanel" style="max-height: 400px; overflow-y: auto; overflow-x:hidden;">
                        </div>
                        <div class="tab-pane" id="tab-towerco-actor" role="tabpanel"  style="max-height: 400px; overflow-y: auto; overflow-x:hidden;">
                        </div>
                        <div class="tab-pane" id="tab-towerco-documents" role="tabpanel">
                            <div>
                                <H5>TSSR <i class="fa fa-fw fa-md" aria-hidden="true"></i></H5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">Date</th>
                                            <th>File Name</th>
                                            <th style="width: 20%;">Uploaded By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Date</td>
                                            <td>File Name</td>
                                            <td>Uploaded By</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <H5>RTB DOCS <i class="fa fa-fw fa-md" aria-hidden="true"></i></H5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">Date</th>
                                            <th>File Name</th>
                                            <th style="width: 20%;">Uploaded By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Date</td>
                                            <td>File Name</td>
                                            <td>Uploaded By</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane table-responsive" id="tab-towerco-logs" role="tabpanel">
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