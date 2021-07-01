@extends('layouts.auth')

@section('content')
    <div class="modal-dialog w-100 mx-auto">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-body">
                    <div class="h5 modal-title text-center">
                        <h4 class="mt-2">
                            <div class="app-logo-inverse mx-auto mb-3"></div>
                            <span>Please sign in to your account below.</span>
                        </h4>
                    </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email here...">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password here...">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- <div class="position-relative form-check">

                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>

                            <input name="check" id="exampleCheck" type="checkbox" class="form-check-input">
                            <label for="exampleCheck" class="form-check-label">Keep me logged in</label>
                        </div> --}}
                    {{-- <div class="divider"></div>
                    <h6 class="mb-0">No account?
                        <a class="text-primary" href="{{ route('register') }}">{{ __('Register Now') }}</a>
                    </h6> --}}
                </div>
                <div class="modal-footer clearfix">                                                
                    <div class="float-left">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary btn-lg">
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection