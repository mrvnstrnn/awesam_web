@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                Employee Invitation
                </div>      
            </div>        
            <div class="card-body">
                <form id="invitation_form">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="firstname" class="">Firstname</label>
                                <input name="firstname" id="firstname" placeholder="John" type="text" class="form-control">
                                <small id="firstname-error" class="text-danger"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="lastname" class="">Lastname</label>
                                <input name="lastname" id="lastname" placeholder="Doe" type="text" class="form-control">
                                <small id="lastname-error" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="email" class="">Email</label>
                                <input name="email" id="email" placeholder="johndoe@gmail.com" type="email" class="form-control">
                                <small id="email-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="mode" class="">Mode</label>
                                <input name="mode" id="mode" placeholder="mode" type="text" class="form-control" value="{{ ucfirst(\Auth::user()->getUserProfile()->first()->mode) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="company" class="">Company</label>
                                <input name="company" id="company" value="{{ \Auth::user()->getCompany(2)->vendor_acronym }}" type="text" class="form-control" readonly>
                                <input name="company_hidden" id="company_hidden" type="hidden" class="form-control" value="2" readonly>
                            </div>
                        </div>
                    </div>
                    <button class="mt-2 btn btn-primary float-right" id="invite_btn" type="button" data-href="{{ route('invite.send') }}">Invite</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_script')
    <script type="text/javascript" src="{{ asset('js/invite.js') }}"></script>
@endsection