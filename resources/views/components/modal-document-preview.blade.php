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

{{-- <div class="modal-header">
    <div class="modal-title"></div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div> --}}
<div class="modal-body">
    <div class="row mb-2">
        <div class="col-sm-12">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8 modal_preview">
            <div class="modal_preview_content" style="max-height: 380px;">
                {{-- <iframe class="embed-responsive-item" style="width:100%; min-height: 400px;" src="/ViewerJS/#../files/{{ $file_list[0]->value }}" allowfullscreen></iframe> --}}
            </div>
            @if($mode=='doc_validation')
            <button type="button" class="btn btn-danger btn_reject_approve pull-left" data-action="rejected">Reject Document</button> 
            <button type="button" class="btn btn-primary btn_reject_approve pull-left mr-1" data-action="approved">Approve Document</button>        
            @endif        
        </div>

        <div class="col-sm-4" id="modal_filelist"  style="max-height: 400px; overflow: scroll;">
            <ul class="list-group">
            @foreach ( $file_list as $file )
                <li class="list-group-item file_list_item" data-status="{{ $file->status }}" data-value="{{ $file->value }}" data-sub_activity_name="{{ $file->sub_activity_name }}">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                @if($file->status == "approved" )
                                    <i class="lnr-checkmark-circle h5 text-success" aria-hidden="true"></i>
                                @elseif($file->status == "reject" )
                                    <i class="lnr-cross-circle h5 text-danger" aria-hidden="true"></i>
                                @else
                                    <i class="lnr-magnifier h5 text-warning" aria-hidden="true"></i>
                                @endif
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">{{ $file->sub_activity_name }}</div>
                                {{-- <div class="widget-subheading">{{ $file->value }}</div> --}}
                            </div>
                        </div>
                    </div>
                </li>            
               {{-- <li class="list-group-item ">  </li> --}}
            @endforeach
            </ul>
        </div>
    </div>    
</div>
<div class="modal-footer">
    @if($mode!='doc_validation')
    <button type="button" class="btn btn-success btn_reject_approve" data-action="approved">Approve Site Documents</button>
    {{-- <button type="button" class="btn btn-danger btn_reject_approve" data-action="rejected">Reject Site</button> --}}
    @endif    
</div>


