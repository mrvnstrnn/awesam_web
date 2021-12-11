@extends('layouts.auth')

@section('content')
    <div class="card text-left">
        <img class="card-img-top" src="holder.js/100px180/" alt="">
        <div class="card-body">
            <h4 class="card-title">eLAS Approval</h4>
            <p class="card-text">
                <div class="alert {{ $error ? "alert-danger" : "alert-success" }}" role="alert">
                    {{ $message }}
                </div>
            </p>
        </div>
    </div>
    
@endsection
