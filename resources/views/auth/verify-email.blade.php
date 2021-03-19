@extends('layouts.app')

@section('content')
<div class="modal-dialog w-100">
    <div class="modal-content">
        <div class="modal-body">
            <h5 class="modal-title">
                <h4 class="mt-2">
                    <div>Verify your email,</div>
                </h4>
            </h5>
            <div class="divider row"></div>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer d-block text-center">
            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="float-right">
                    <button type="submit" class="btn btn-primary btn-lg">{{ __('click here to request another') }}</button>.
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
