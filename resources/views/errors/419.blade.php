@extends('layouts.error')

@section('content')
<div class="row">
    <div class="col-12 py-5 text-center">
        <h1>Page Expired</h1>
        <div><img src='/images/awesam_loader.png' width='250px;' alt-text='Loading...'/></div>
        <div>redirecting...</div>
    </div>
</div>

<script>
    window.setTimeout(function(){
        window.location.href = "/login";
    }, 0);
</script>
@endsection