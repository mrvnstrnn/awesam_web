@extends('layouts.home')

@section('content')

    <x-home-dashboard />  

@endsection

@section('modals')

@endsection



@section("js_script")

    {{-- <script>
        $(document).ready(() => {

            $('#dar_table').DataTable();
        });
    </script> --}}

    <!-- PR PO Counter -->
    <script type="text/javascript" src="/js/newsites_ajax_counter.js"></script>  

@endsection