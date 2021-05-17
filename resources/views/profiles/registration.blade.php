@extends('layouts.auth')

@section('content')
    <div class="modal-dialog w-100">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title">
                        <h4 class="mt-2">
                            <div>Welcome,</div>
                            <span>It only takes a
                                <span class="text-success">few seconds</span> to create your account</span>
                        </h4>
                    </h5>
                    <div class="divider row"></div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" 
                                    name="firstname" value="{{ $invitations->firstname ? $invitations->firstname : old('firstname') }}" required autocomplete="firstname" autofocus placeholder="Firstname here...">

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" 
                                    name="lastname" value="{{ $invitations->lastname ? $invitations->lastname : old('lastname') }}" required autocomplete="lastname" autofocus placeholder="Lastname here...">

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ $invitations->email ? $invitations->email : old('email') }}" required autocomplete="email" placeholder="Email here..." readonly>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="new-password" placeholder="Password here...">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <input id="password-confirm" type="password" class="form-control" 
                                    name="password_confirmation" required autocomplete="new-password" placeholder="Repeat Password here...">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <input id="mode" type="text" class="form-control" 
                                    name="mode" value="{{ $invitations->mode ? $invitations->mode : old('mode') }}" required autocomplete="mode" placeholder="Mode here..." readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <input id="company" type="text" class="form-control" 
                                    name="company" value="{{ $invitations->vendor_acronym ? $invitations->vendor_acronym : old('vendor_acronym') }}" required autocomplete="mode" placeholder="Vendor Acronymn" readonly>

                                    <input type="hidden" name="company_hidden" id="company_hidden" value="{{ $invitations->id }}">
                                    <input type="hidden" name="token_hidden" id="token_hidden" value="{{ $invitations->token }}">
                                    <input type="hidden" name="invitationcode_hidden" id="invitationcode_hidden" value="{{ $invitations->invitation_code }}">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 position-relative form-check">
                        <input name="check" id="exampleCheck" type="checkbox" class="form-check-input">
                        <label for="exampleCheck" class="form-check-label">Accept our
                            <a href="javascript:void(0);">Terms and Conditions</a>.
                        </label>
                    </div>
                </div>
                <div class="modal-footer d-block text-center">
                    <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Register Account</button>
                </div>
            </div>
        </form>
    </div>

    
@endsection
