@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="main-card p-3 mb-3 card">
                {{$signed_url}}

                <iframe src="{{ $signed_url }}" style="width: 100%; border: 1px solid #e0e0e0;" allowfullscreen />
            </div>
            <form class="asdd">
                <input type="text" name="left" id="left" value="https://sam.globe.com.ph/files/1642955444renewal-000000009-loi-NONE-get-send-approved-loi-01.pdf">
                <input type="text" name="right" id="right" value="https://sam.globe.com.ph/files/1642955444renewal-000000009-loi-NONE-get-send-approved-loi-01.pdf">
            </form>
        </div>
    </div>
@endsection

@section('js_script')
    <script>
        // $(document).ready(function() {
        //     var left = "https://sam.globe.com.ph/files/1642955444renewal-000000009-loi-NONE-get-send-approved-loi-01.pdf";
        //     var right = "https://sam.globe.com.ph/files/1642955444renewal-000000009-loi-NONE-get-send-approved-loi-01.pdf";
        //     $.ajax({
        //         url: '/laravel-curl',
        //         type: 'GET',
        //         dataType: 'json',
        //         contentType: "application/json",
        //         beforeSend: function(xhr) {
        //             xhr.setRequestHeader("Authorization", "Token ddd70898ce025e9060c82a9660fc27bb")
        //         },
        //         success: function(data){
        //             alert(data);
        //         }
        //     });
        // });
    </script>
@endsection
