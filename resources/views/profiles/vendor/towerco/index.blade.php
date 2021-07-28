@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-body">
        <div id="chart_div" style="width: 100%; height: 500px;"></div>
    </div>
</div>
<div class="card">
    &nbsp;
</div>

@endsection

@section('js_script')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  google.charts.load('current', {packages: ['corechart', 'bar']});
  google.charts.setOnLoadCallback(drawBasic);

  var milestones = [['Milestone', 'Milestone Status', { role: 'style' }, { role: 'annotation' }]];

  @php
    $ms = \DB::table('towerco_milestone_totals_per_company')
          ->where('TOWERCO', 'CREI')
          ->get();

    $colors = array('#FADA5E', '#F9A602', '#FFD300', '#D2B55B', '#C3B091', '#DAA520', '#FCF4A3', '#FCD12A', '#C49102', '#FFDDAF');

    $ctr = 0;
    foreach($ms as $m){

      echo "milestones.push(['" . $m->{'MILESTONE STATUS'}  . "', " . $m->counter  . ", '". $colors[$ctr] . "', '" . $m->{'MILESTONE STATUS'}  . " - " . $m->counter  . "']);";    
      $ctr++;

    }

  @endphp
  

  function drawBasic() {

    var data = google.visualization.arrayToDataTable(milestones);

    var options = {
      title: 'Site Milestones',
      chartArea: {width: '100%', height: '85%', top: 40},
      bar: {groupWidth: "80%"},
      legend: { position: "none" },
      hAxis: {
        minValue: 0
      },
      vAxis: {
        textPosition: 'none',
      }
    };

    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
</script>

@endsection
