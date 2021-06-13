@extends('layouts.main')

@section('content')

    <x-doc-validation />

@endsection


@section('modals')

<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" >
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Reject</button>
                <button type="button" class="btn btn-primary">Approve</button>        
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_script')

    <script type="text/javascript" src="/js/getCols.js"></script>  
    <script type="text/javascript" src="/js/doc-validations.js"></script>  

@endsection