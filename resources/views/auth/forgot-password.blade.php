@extends('layouts.auth')

@section('content')

    <div class="modal-dialog w-100">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <div class="h5 modal-title">
                        Forgot your Password?
                        <h6 class="mt-1 mb-0 opacity-8">
                            <span>Use  the form below to recover it.</span>
                        </h6>
                    </div>
                </div>
                <div class="modal-body">
                    <div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">Email</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        {{-- <input name="email" id="exampleEmail"
                                            placeholder="Email here..." type="email" class="form-control"> --}}
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="divider"></div>
                    <h6 class="mb-0">
                        <a href="{{ route('login') }}" class="text-primary">Sign in existing account</a>
                    </h6>
                </div>
                <div class="modal-footer d-block text-center">
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('Recover Password') }}</button>.
                        {{-- <button class="btn btn-primary btn-lg">Recover Password</button> --}}
                    </div>
                </div>
            </div>
        </form>

    </div>

@endsection
