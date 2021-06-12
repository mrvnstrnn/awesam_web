@extends('layouts.main')

@section('content')
<div class="main-card mb-3 card">
    <div class="card-body">
        <div id="calendar-bg-events"></div>
    </div>
</div>

@endsection

@section('js_script')
    <script type="text/javascript" src="/js/calendar.js"></script>
@endsection