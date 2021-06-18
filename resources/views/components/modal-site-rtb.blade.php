<style>

.ui-datepicker.ui-datepicker-inline {
   width: 100% !important;
}

.ui-datepicker table {
    font-size: 1.2em;
}

</style>    

<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h5 class="modal-title">{{ $activity}} </h5>
            </div> --}}
            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <H4 class="mb-0">{{ $site }}</H4>
                        {{ $activity}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="datepicker" class="my-2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="">
                            <div class="form-row">
                                <div class="col-md-5">
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">RTB Date</label>
                                        <select name="select" id="exampleSelect" class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>        
                                </div>
                                <div class="col-md-7">
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">RTB Declaration</label>
                                        <select name="select" id="exampleSelect" class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>        
                                </div>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if($activity !='RTB Declaration')
                    <button type="button" class="btn btn-success btn_reject_approve" data-action="approved">Approve RTB Declaration</button>
                @else
                    <button type="button" class="btn btn-success btn_reject_approve" data-action="approved">Declare RTB Date</button>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $( "#datepicker" ).datepicker();
</script>