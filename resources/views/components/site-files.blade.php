<div class="row file_lists">
    @php
        // $datas = \App\Models\SubActivityValue::leftjoin("sub_activity", 'sub_activity.sub_activity_id', 'sub_activity_value.sub_activity_id')
        //                                             ->where('sub_activity_value.sam_id', $site[0]->sam_id)
        //                                             ->where('sub_activity_value.status', '!=', 'rejected')
        //                                             ->where('sub_activity.action', 'doc upload')
        //                                             ->get();
        
        $datas = \DB::connection('mysql2')->select('call `files_dropzone`("' .  $site[0]->sam_id . '", ' .  $site[0]->program_id . ', "")');
    // dd($datas);
    @endphp

    @forelse ($datas as $data)

    {{-- {{ dd($data) }} --}}
    @if (is_null($data->files))
        <div class="col-md-4 col-sm-4 col-12 dropzone_div_{{ $data->sub_activity_id }}">
            <div class="child_div_{{ $data->sub_activity_id }}">
                <div class="dropzone dropzone_files" data-sam_id="{{ $site[0]->sam_id }}" data-sub_activity_id="{{ $data->sub_activity_id }}"></div>
                <p>{{ $data->sub_activity_name }}</p>
            </div>
        </div>
    @else
        @foreach (json_decode($data->files) as $item)
            @php
                if (pathinfo($item->value, PATHINFO_EXTENSION) == "pdf") {
                    $extension = "fa-file-pdf";
                } else if (pathinfo($item->value, PATHINFO_EXTENSION) == "png" || pathinfo($item->value, PATHINFO_EXTENSION) == "jpeg" || pathinfo($item->value, PATHINFO_EXTENSION) == "jpg") {
                    $extension = "fa-file-image";
                } else {
                    $extension = "fa-file";
                }
            @endphp
            <div class="col-md-4 col-sm-4 col-12 view_file dropzone_div_{{ $data->sub_activity_id }}" style="cursor: pointer;" data-value="{{ $item->value }}">
                <div class="child_div_{{ $data->sub_activity_id }}">
                    <div class="font-icon-wrapper py-4">
                        <i class="fa {{ $extension }}"></i><br>
                        <small>{{ $item->value }}</small>
                        <p>{{ $data->sub_activity_name }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @empty
    <div class="col-12 text-center">
        <h3>No files here.</h3>
    </div>
    @endforelse
</div>
