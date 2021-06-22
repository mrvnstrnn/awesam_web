<div class="row">
    <div class="col-lg-6">
        <div id="datepicker" class=""></div>
    </div>
    <div class="col-lg-6">
        <form class="">
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="date_declaration" class="">RTB Declaration</label>
                        <input type="text" id="date_declaration" name="date_declaration" class="form-control" readonly />
                    </div>        
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="rtb_declaration" class="">RTB Declaration</label>
                        <select name="rtb_declaration" id="rtb_declaration" class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>        
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="remarks" rows="6" class="">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" style="height: 95px;"></textarea>
                    </div>        
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row mb-3 border-top pt-3">
    <div class="col-12 align-right">
        <button class="float-right btn btn-shadow btn-success">Approve RTB Declaration</button>                                            
        <button class="float-right btn btn-shadow btn-danger mr-2">Reject</button>                                            
    </div>
</div>


<script>
    $(function() {
        $("#datepicker").datepicker();
        $("#datepicker").on("change",function(){
            var selected = $(this).val();
            $("#date_declaration").val(selected);
        });
    });
</script>
