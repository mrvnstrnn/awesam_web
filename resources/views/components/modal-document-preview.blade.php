<style>

    .modal-dialog{
        overflow-y: initial !important
    }

    .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }

    .details_file {
        display: none !important;
    }

    .col_child:hover .details_file {
        display: block !important;
    }

    .file_list_item {
        cursor: pointer;
    }

    #toolbarRight {
        display: none !important;
    }



</style>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <button type="button" class="btn btn-primary btn_reject_approve pull-left mr-1" data-action="approved">Approve</button>        
            <button type="button" class="btn btn-danger btn_reject_approve pull-left" data-action="rejected">Reject</button>        
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <div class="col-sm-8 modal_preview">
            <div class="modal_preview_content">
                {{-- <iframe class="embed-responsive-item" style="width:100%; min-height: 400px;" src="/ViewerJS/#../files/{{ $file_list[0]->value }}" allowfullscreen></iframe> --}}
            </div>
        </div>
        <div class="col-sm-4">
            <ul class="list-group">
            @foreach ( $file_list as $file )
                <button class=" file_list_item list-group-item-action list-group-item"  data-value="{{ $file->value }}" data-sub_activity_name="{{ $file->sub_activity_name }}">
                    <div><strong>{{ $file->sub_activity_name }}</strong></div>
                    <small>{{ $file->value }}</small>
                </button>            
               {{-- <li class="list-group-item ">  </li> --}}
            @endforeach
            </ul>
        </div>
    </div>    
</div>
<div class="modal-footer">
    <div class="modal_preview_marker  text-left">
        {{ $file_list[0]->sub_activity_name }} : {{ $file_list[0]->value }}
    </div>
</div>


