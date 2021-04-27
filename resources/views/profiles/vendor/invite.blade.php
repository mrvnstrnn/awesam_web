@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Invitation Information</h5>
                <form id="invitation_form">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="firstname" class="">Firstname</label>
                                <input name="firstname" id="firstname" placeholder="John" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="lastname" class="">Lastname</label>
                                <input name="lastname" id="lastname" placeholder="Doe" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="email" class="">Email</label>
                                <input name="email" id="email" placeholder="johndoe@gmail.com" type="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="mode" class="">Mode</label>
                                <input name="mode" id="mode" placeholder="mode" type="text" class="form-control" value="Vendor">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="company" class="">Company</label>
                                <input name="company" id="company" placeholder="Company" type="text" class="form-control" value="2">
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