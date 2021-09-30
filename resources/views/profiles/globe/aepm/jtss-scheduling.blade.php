@extends('layouts.main')

@section('content')

<x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="JTSS Schedule" activitytype="schedule jtss"/>


@endsection

@section('js_script')

@endsection
