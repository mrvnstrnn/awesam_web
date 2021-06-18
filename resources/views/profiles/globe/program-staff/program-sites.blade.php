@extends('layouts.main')

@section('content')

    <x-assigned-sites mode="globe"/>

@endsection

@section('modals')

    <x-milestone-modal />

    @include('profiles.view_site_modal')

@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 8;
    var table_to_load = 'assigned_sites';
    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    
// $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
//     e.preventDefault();

//     window.location.href = "/assigned-sites/" + $(this).attr('data-sam_id');
// });
</script>



@endsection