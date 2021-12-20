<form>
    {{-- @php
        $obj = json_decode($sitefields, TRUE);
    @endphp --}}

    @foreach ( $sitefields as $site_field )
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
                            if (index == 'url_contract') {
                                $(".form_data p#"+index).append(
                                    '<a href="'+data+'">"'+ data +'"</a>'
                                );
                            } else if (index == 'url_property_docs') {
                                $(".form_data p#"+index).append(
                                    '<a href="'+data+'">"'+ data +'"</a>'
                                );
                            } else if (index == 'url_legal_docs') {
                                $(".form_data p#"+index).append(
                                    '<a href="'+data+'">"'+ data +'"</a>'
                                );
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
            var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
                '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
            return !!pattern.test(str);
        }
    </script>
</form>
