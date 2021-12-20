<form>
    @php
        // $obj = json_decode($sitefields, TRUE);
        $program_mappings = \DB::table('program_mapping')
                            ->where('program_id', $program_id)
                            ->get();
    @endphp

    @foreach ( $program_mappings as $site_field )
        @php
            $what = str_replace(' ', '_', $site_field->label);
        @endphp
        <div class="form-row mb-2 pb-2 border-bottom form_data">
            <div class="col-5">
                <label for="{{ $what }}" class="mr-sm-2">{{ $site_field->label }}</label>
            </div>
            <div class="col-7">
                @if ($site_field->field_type == 'text')
                    <input name="{{ $what }}" id="{{ $what }}" value="" type="text" class="form-control" readonly>
                @elseif ($site_field->field_type == 'url')
                    <p id="{{ $what }}"></p>
                @endif
            </div>
        </div>
    @endforeach

    <script>
        $(document).ready(function(){
            var sam_id = "{{ $sam_id }}";
            var program_id = "{{ $program_id }}";
            $.ajax({
                url: "/get-form-fields",
                data: {
                    sam_id : sam_id,
                    program_id : program_id
                },
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {
                        $.each(resp.message[0], function(index, data) {
                            if (index == 'url_contract' || index == 'url_property_docs' || index == 'url_legal_docs') {
                                if (validURL(data)) {
                                    $(".form_data p#"+index).append(
                                        '<a href="'+data+'" target="_blank">'+ data +'</a>'
                                    );
                                } else {
                                    $(".form_data p#"+index).append(
                                        '<span>"'+ data +'"</span>'
                                    );
                                }
                            }
                            $(".form_data #"+index).val(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            });
        });

        function validURL(str) {
            var pattern = new RegExp('^(https?:\\/\\/)?'+
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+
                '((\\d{1,3}\\.){3}\\d{1,3}))'+
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+
                '(\\?[;&a-z\\d%_.~+=-]*)?'+
                '(\\#[-a-z\\d_]*)?$','i');
            return !!pattern.test(str);
        }
    </script>
</form>
