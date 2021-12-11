@extends('layouts.auth')

@section('content')

    <div class="modal-dialog w-100">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <div class="h5 modal-title">
                        Reset Password
                        <h6 class="mt-1 mb-0 opacity-8">
                            <span>Enter a new password.</span>
                        </h6>
                    </div>
                </div>
                <div class="modal-body">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session()->all() }}
                        </div>
                    @endif
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ request()->email ?? old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                {{-- <input name="email" id="exampleEmail"
                                    placeholder="Email here..." type="email" class="form-control"> --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="new-password" placeholder="New password here..." autofocus>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                {{-- <input name="password" id="examplePassword"
                                    placeholder="Password here..." type="password" class="form-control" autofocus> --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <input id="password-confirm" type="password" class="form-control" 
                                    name="password_confirmation" required autocomplete="new-password" placeholder="Confirm new password here...">

                                {{-- <input name="passwordrep" id="examplePasswordRep"
                                    placeholder="Repeat Password here..." type="password" class="form-control"> --}}
                            </div>
                        </div>
                        <input type="hidden" name="token" value="{{ request()->route('token') }}">
                    </div>
                </div>
                <div class="modal-footer d-block text-center">
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('Reset Password') }}</button>.
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
