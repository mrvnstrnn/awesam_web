@extends('layouts.main')

@section('content')

<style>
    .list-group-item {
        cursor: pointer;
    }
</style>

<ul class="tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-today" data-toggle="tab" href="#tab-content-today">
            <span>Today</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-this-week" data-toggle="tab" href="#tab-content-this-week">
            <span>This Week</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-this-month" data-toggle="tab" href="#tab-content-this-month">
            <span>This Month</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-today" role="tabpanel">
        <div class="row">
            <div class="col-md-7">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-calendar-full icon-gradient bg-ripe-malin"></i>
                        Activies
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="todo-indicator bg-warning"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox12" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox12">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Create Letter of Intent and Notice to Proceed</div>
                                        <div class="widget-subheading">AYALA TERRACES -  COLOC-2021-100</div>
                                        <div class="widget-subheading">Due Today</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-focus"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox1" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox1">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Process RTB Documents</div>
                                        <div class="widget-subheading">SM FAIRVIEW - COLOC-2021-200</div>
                                        <div class="widget-subheading">Due Friday : Building Permit Application</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-primary"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox4" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox4">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Process PAC/DOH</div>
                                        <div class="widget-subheading">ROBINSONS NOVALICHES - COLOC-2021-300</div>
                                        <div class="widget-subheading">Due Friday : DOH Application</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>                

            </div>
            
            <div class="col-md-5">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                        Sites
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="todo-indicator bg-warning"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            AYALA TERRACES
                                            <div class="badge badge-warning ml-2">Lessor Negotiation</div>
                                        </div>
                                        <div class="widget-subheading">
                                            <i>COLOC-2021-100</i>
                                        </div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-focus"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            SM FAIRVIEW
                                            <div class="badge badge-focus ml-2">RTB</div>
                                        </div>
                                        <div class="widget-subheading">
                                            <i>COLOC-2021-200</i>
                                        </div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-primary"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            ROBINSONS NOVALICHES
                                            <div class="badge badge-primary ml-2">PAC</div>
                                        </div>
                                        <div class="widget-subheading">
                                            <i>COLOC-2021-300</i>
                                        </div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>                


            </div>

        </div>
    </div>
    <div class="tab-pane tabs-animation fade" id="tab-content-this-week" role="tabpanel">
        <div class="row">
            <div class="col-md-7">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-calendar-full icon-gradient bg-ripe-malin"></i>
                        Activies
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="todo-indicator bg-warning"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox12" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox12">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Create Letter of Intent and Notice to Proceed</div>
                                        <div class="widget-subheading">AYALA TERRACES -  COLOC-2021-100</div>
                                        <div class="widget-subheading">Due Today</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-focus"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox1" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox1">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Process RTB Documents</div>
                                        <div class="widget-subheading">SM FAIRVIEW - COLOC-2021-200</div>
                                        <div class="widget-subheading">Due Friday : Building Permit Application</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-primary"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox4" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox4">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Process PAC/DOH</div>
                                        <div class="widget-subheading">ROBINSONS NOVALICHES - COLOC-2021-300</div>
                                        <div class="widget-subheading">Due Friday : DOH Application</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>                

            </div>
            
            <div class="col-md-5">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                        Sites
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="todo-indicator bg-warning"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            AYALA TERRACES
                                            <div class="badge badge-warning ml-2">Lessor Negotiation</div>
                                        </div>
                                        <div class="widget-subheading">
                                            <i>COLOC-2021-100</i>
                                        </div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-focus"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            SM FAIRVIEW
                                            <div class="badge badge-focus ml-2">RTB</div>
                                        </div>
                                        <div class="widget-subheading">
                                            <i>COLOC-2021-200</i>
                                        </div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-primary"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            ROBINSONS NOVALICHES
                                            <div class="badge badge-primary ml-2">PAC</div>
                                        </div>
                                        <div class="widget-subheading">
                                            <i>COLOC-2021-300</i>
                                        </div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>                


            </div>

        </div>
    </div>
    <div class="tab-pane tabs-animation fade" id="tab-content-this-month" role="tabpanel">
        <div class="row">
            <div class="col-md-7">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-calendar-full icon-gradient bg-ripe-malin"></i>
                        Activies
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="todo-indicator bg-warning"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox12" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox12">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Create Letter of Intent and Notice to Proceed</div>
                                        <div class="widget-subheading">AYALA TERRACES -  COLOC-2021-100</div>
                                        <div class="widget-subheading">Due Today</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-focus"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox1" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox1">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Process RTB Documents</div>
                                        <div class="widget-subheading">SM FAIRVIEW - COLOC-2021-200</div>
                                        <div class="widget-subheading">Due Friday : Building Permit Application</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-primary"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox4" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox4">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Process PAC/DOH</div>
                                        <div class="widget-subheading">ROBINSONS NOVALICHES - COLOC-2021-300</div>
                                        <div class="widget-subheading">Due Friday : DOH Application</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>                

            </div>
            
            <div class="col-md-5">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                        Sites
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="todo-indicator bg-warning"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            AYALA TERRACES
                                            <div class="badge badge-warning ml-2">Lessor Negotiation</div>
                                        </div>
                                        <div class="widget-subheading">
                                            <i>COLOC-2021-100</i>
                                        </div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-focus"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            SM FAIRVIEW
                                            <div class="badge badge-focus ml-2">RTB</div>
                                        </div>
                                        <div class="widget-subheading">
                                            <i>COLOC-2021-200</i>
                                        </div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-primary"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            ROBINSONS NOVALICHES
                                            <div class="badge badge-primary ml-2">PAC</div>
                                        </div>
                                        <div class="widget-subheading">
                                            <i>COLOC-2021-300</i>
                                        </div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>                
            </div>
        </div>
    </div>

</div>

@endsection

@section('modals')
<div class="modal fade" id="list-group-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_script')
    <script>
        $(".list-group-item").on('click', function(e){
            e.preventDefault();
            $("#list-group-modal").modal("show");
            $(".modal-title").text(e.target.children[1].children[0].innerHTML);
        });
    </script>
@endsection