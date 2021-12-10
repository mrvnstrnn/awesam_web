@php

    if($programid == 3){
    $datas = \DB::table('program_coloc')
                ->select('highlevel_tech as counter_label', DB::raw("count(sam_id) as counter"))
                ->distinct()
                ->groupBy('highlevel_tech')                
                ->get();
    }

    $bg_img_counter = 0;

@endphp     



<div class="mb-3  card">
    <div class="card-body p-0">                                        
        <div class="no-gutters row">
            @foreach ($datas as $data)
                @php
                    $bg_img_counter++;
                @endphp
                <div class="col border">           
                    <div class="milestone-bg bg_img_{{ $bg_img_counter; }}" style=""></div>                                     
                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                        <div class="widget-numbers mt-1" id="{{ $data->counter_label }}_count">0</div>
                        <div class="widget-subheading">{{ $data->counter_label }}</div>
                    </div>
                </div>                
            @endforeach

        </div>                            
    </div>
</div>