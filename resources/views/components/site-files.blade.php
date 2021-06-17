<div class="row">
    @php
        $datas = \App\Models\SubActivityValue::leftjoin("sub_activity", 'sub_activity.sub_activity_id', 'sub_activity_value.sub_activity_id')
                                                    ->where('sub_activity_value.sam_id', $site[0]->sam_id)
                                                    ->where('sub_activity_value.status', '!=', 'rejected')
                                                    ->where('sub_activity.action', 'doc upload')
                                                    ->get();
    @endphp

    @foreach ($datas as $data)
        @if (is_null($data->value))
            <div class="col-md-4 col-sm-4 col-12">
                <div class="dropzone"></div>
            </div>
        @else
            @php
                if (pathinfo($data->value, PATHINFO_EXTENSION) == "pdf") {
                    $extension = "fa-file-pdf";
                } else if (pathinfo($data->value, PATHINFO_EXTENSION) == "png" || pathinfo($data->value, PATHINFO_EXTENSION) == "jpeg" || pathinfo($data->value, PATHINFO_EXTENSION) == "jpg") {
                    $extension = "fa-file-image";
                } else {
                    $extension = "fa-file";
                }
            @endphp
            <div class="col-md-4 col-sm-4 col-12">
                <div class="font-icon-wrapper py-4">
                    {{-- <i class="lnr-plus-circle"></i> --}}
                    <i class="fa {{ $extension }}"></i><br>
                    <small>{{ $data->value }}</small>
                    <p>{{ $data->sub_activity_name }}</p>
                </div>
            </div>
        @endif
    @endforeach
</div>

<script>
    Dropzone.autoDiscover = false;
    $(".dropzone").dropzone({
        addRemoveLinks: true,
        maxFiles: 1,
        maxFilesize: 5,
        paramName: "file",
        url: "/upload-file",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, resp) {
            $("#form-upload  #file_name").val(resp.file);
            console.log(resp.message);
        },
        error: function (file, resp) {
            toastr.error(resp.message, "Error");
        }
    });
</script>
