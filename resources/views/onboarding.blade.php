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
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name here...">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email here...">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
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
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <input id="password-confirm" type="password" class="form-control" 
                                    name="password_confirmation" required autocomplete="new-password" placeholder="Repeat Password here...">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 position-relative form-check">
                        <input name="check" id="exampleCheck" type="checkbox" class="form-check-input" required>
                        <label for="exampleCheck" class="form-check-label">Accept our
                            <a href="javascript:void(0);">Terms and Conditions</a>.
                        </label>
                    </div>
                    <div class="divider row"></div>
                    <h6 class="mb-0">
                        Already have an account?
    
                        <a href="javascript:void(0);" class="text-primary">Sign in</a> |
                        @if (Route::has('password.request'))
                            <a class="text-primary" href="{{ route('password.request') }}">
                                {{ __('Recover Password?') }}
                            </a>
                        @endif
                    </h6>
                </div>
                <div class="modal-footer d-block text-center">
                    <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Create Account</button>
                </div>
            </div>
        </form>
    </div>

    
@endsection
