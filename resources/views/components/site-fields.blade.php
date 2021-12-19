<form>
    {{-- @php
        $obj = json_decode($sitefields, TRUE);
    @endphp --}}

    @foreach ( $sitefields as $site_field )
        @foreach ($sites_data[0] as $index => $site)
            @php
                $what = str_replace(' ', '_', $site_field->label);
            @endphp

            @if ($what == $index)
                <div class="form-row mb-2 pb-2 border-bottom form_data">
                    <div class="col-5">
                        <label for="{{ $what }}" class="mr-sm-2">{{ $site_field->label }}</label>
                    </div>
                    <div class="col-7">
                        @if ($site_field->field_type == 'text')
                            <input name="{{ $what }}" id="{{ $what }}" value="{{ $site }}" type="text" class="form-control" readonly>
                        @elseif ($site_field->field_type == 'url')
                            <a href="{{ $site }}">https://sam.local/program-sites</a>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach

    {{-- <script>

        var data = JSON.parse("{{ $sites_data }}".replace(/&quot;/g,'"'));

        $.each(data[0], function(index, data) {
            if (index == 'url_contract' || index == 'url_property_docs' || index == 'url_legal_docs') {
                $(".form_data #"+index).attr("href", data);
            }
            $(".form_data #"+index).val(data);
        });
    </script> --}}
</form>
