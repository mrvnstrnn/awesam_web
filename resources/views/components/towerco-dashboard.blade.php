@php

  if(\Auth::user()->profile_id == 21){
    
    $user_detail = \Auth::user()->getUserDetail()->first();
    $vendor = \App\Models\Vendor::where('vendor_id', $user_detail->vendor_id)->first();

    $rt = DB::table('towerco_region_totals_per_company')->where('TOWERCO', $vendor->vendor_acronym)->get();

  }
  else {
    $rt = \App\Models\TowerCoRegion::get();
  }

  $ncr = 0;
  $nlz = 0;
  $slz = 0;
  $vis = 0;
  $min = 0;

  foreach($rt as $r){
    if($r->REGION == 'NCR'){
      $ncr = $r->counter;
    }
    if($r->REGION == 'NLZ'){
      $nlz = $r->counter;
    }
    if($r->REGION == 'SLZ'){
      $slz = $r->counter;
    }
    if($r->REGION == 'VIS'){
      $vis = $r->counter;
    }
    if($r->REGION == 'MIN'){
      $min = $r->counter;
    }
  }

  $rtotal = $ncr + $nlz + $slz + $vis + $min;

@endphp

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
        <div class="mb-2 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                Total
                            </div>
                        </div>
                        <div class="widget-numbers">
                          <span>{{ $rtotal }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>  
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
      <div class="mb-2 card">
        <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-orange.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                NCR
                            </div>
                        </div>
                        <div class="widget-numbers">
                          <span>{{ $ncr }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>  
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
      <div class="mb-2 card">
        <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-green.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                NLZ
                            </div>
                        </div>
                        <div class="widget-numbers">
                          <span>{{ $nlz }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
      <div class="mb-2 card">
        <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-red.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                SLZ
                            </div>
                        </div>
                        <div class="widget-numbers">
                          <span>{{ $slz }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
      <div class="mb-2 card">
        <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-primary.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                VIS
                            </div>
                        </div>
                        <div class="widget-numbers">
                          <span>{{ $vis }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
      <div class="mb-2 card">
        <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                MIN
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span>{{ $min }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
<div class="row">
  <div class="col-12">
    <div class="card mb-3">
        <div class="card-body">
            <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.20; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>

            <div id="chart_div" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  google.charts.load('current', {packages: ['corechart', 'bar']});
  google.charts.setOnLoadCallback(drawBasic);

  var milestones = [['Milestone', 'Milestone Status', { role: 'style' }, { role: 'annotation' }]];

  @php
    if(\Auth::user()->profile_id == 21){
      $ms = DB::table('towerco_milestone_totals_per_company')
          ->where('TOWERCO', $vendor->vendor_acronym)
          ->get();
    } else {
      $ms =  \App\Models\TowerCoMilestoneTotal::get();
    }

    $colors = array('#FADA5E', '#F9A602', '#FFD300', '#D2B55B', '#C3B091', '#DAA520', '#FCF4A3', '#FCD12A', '#C49102', '#FFDDAF');

    $ctr = 0;
    foreach($ms as $m){

      echo "milestones.push(['" . $m->{'MILESTONE STATUS'}  . "', " . $m->counter  . ", 'stroke-color: #443403; stroke-width: 1; fill-color: " . $colors[$ctr] . "', '" . $m->{'MILESTONE STATUS'}  . " - " . $m->counter  . "']);";    
      $ctr++;

    }

  @endphp
  

  function drawBasic() {

    var data = google.visualization.arrayToDataTable(milestones);

    var options = {
      title: 'Site Milestones',
      chartArea: {width: '100%', height: '85%', top: 40},
      
      backgroundColor: { fill:'transparent' },

      bar: {groupWidth: "80%"},
      legend: { position: "none" },
      hAxis: {
        minValue: 0
      },
      vAxis: {
        textPosition: 'none',
      },
      is3D: true
    };


    
    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }

  
</script>