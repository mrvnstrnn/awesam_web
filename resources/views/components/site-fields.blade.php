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
            $array_not_allowed = array(
                "id",
                "sam_id",
                "load_date",
                // "mar_status",
                // "las_completed_date",
                // "las_completed_month",
                // "contract_completed_date",
                // "contract_completed_month",
                // "challenges",
                "sam_region_id",
                "vendor_id",
                "region_id",
                "province_id",
                "lgu_id",
            );

            // $site_not_allowed = array(
            //     'null',
            //     'NULL',
            //     NULL,
            //     '',
            // );
        @endphp

        @if ( !in_array( $index, $array_not_allowed ) )
            @php
                $what = str_replace(' ', '_', $index);
            @endphp

            {{-- @if ( !in_array( $site_field, $site_not_allowed ) ) --}}
            {{-- @if ( !is_null($site_field) || $site_field != '' || $site_field != 'null' || $site_field != 'NULL') --}}
                <div class="form-row mb-2 pb-2 border-bottom">
                    <div class="col-5">
                        <label for="{{ $what }}" class="mr-sm-2">{{ ucfirst( str_replace("_", " ", $what) ) }}</label>
                    </div>
                    <div class="col-7">
                        <input name="{{ $what }}" id="{{ $what }}" type="text" value="{{ $site_field }}" class="form-control" readonly>
                    </div>
                </div>
            {{-- @endif --}}
        @endif
    @endforeach
</form>
