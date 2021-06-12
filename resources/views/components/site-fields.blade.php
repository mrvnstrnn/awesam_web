<form>
    @foreach ( $site_fields as $site_field )
    <div class="form-row mb-1">
        <div class="col-5">
            <label for="exampleEmail22" class="mr-sm-2">{{ $site_field->field_name }}</label>
        </div>
        <div class="col-7">
            <input name="email" id="exampleEmail22" type="text" value="{{ $site_field->value }}" class="form-control">
        </div>
    </div>
    @endforeach
</form>
