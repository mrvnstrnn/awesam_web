<form>
    @php
        $obj = json_decode($sitefields, TRUE);
    @endphp

    @foreach ( $obj[0] as $index => $site_field )
        {{-- @php
            $what = str_replace(' ', '_', $site_field->field_name);
        @endphp
        <div class="form-row mb-2 pb-2 border-bottom">
            <div class="col-5">
                <label for="{{ $what }}" class="mr-sm-2">{{ ucfirst( str_replace("_", " ", $site_field->field_name) ) }}</label>
            </div>
            <div class="col-7">
                <input name="{{ $what }}" id="{{ $what }}" type="text" value="{{ $site_field->value }}" class="form-control" readonly>
            </div>
        </div> --}}

        @php
            $what = str_replace(' ', '_', $index);
        @endphp
        <div class="form-row mb-2 pb-2 border-bottom">
            <div class="col-5">
                <label for="{{ $what }}" class="mr-sm-2">{{ ucfirst( str_replace("_", " ", $what) ) }}</label>
            </div>
            <div class="col-7">
                <input name="{{ $what }}" id="{{ $what }}" type="text" value="{{ $site_field }}" class="form-control" readonly>
            </div>
        </div>
    @endforeach
</form>
