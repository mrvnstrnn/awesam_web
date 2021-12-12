@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="main-card p-3 mb-3 card">
                <div class="form-row">
                    <div class="col-12">
                        @php
                            $user = \Auth::user()->getUserDetail()->first();   
                        @endphp
                        <div class="text-center">
                            @if (!is_null(\Auth::user()->getUserDetail()->first()->image))
                                <img width="150" height="150" class="rounded-circle offline" src="{{ asset('files/'.\Auth::user()->getUserDetail()->first()->image) }}" alt="">
                            @else
                                <img width="150" height="150" class="rounded-circle offline" src="images/no-image.jpg" alt="">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" value="{{ \Auth::user()->firstname }}">
                            <small id="helpId" class="text-muted">Help text</small>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" value="{{ \Auth::user()->lastname }}">
                            <small id="helpId" class="text-muted">Help text</small>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{ \Auth::user()->email }}" readonly title="You're not allowed to change you email address.">
                            <small id="helpId" class="text-muted">Help text</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection