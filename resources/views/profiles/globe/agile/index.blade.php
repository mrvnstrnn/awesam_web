@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-body">
        <div id="chart_div" style="width: 100%; height: 600px;"></div>
    </div>
</div>
<div class="card">
    &nbsp;
</div>

@endsection

@section('js_script')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var data = google.visualization.arrayToDataTable([
          ['2021', 'STS', 'RAM', 'TowerCo', 'Agile'],
          ['July', 1000, 364, 200, 100],
          ['June', 1000, 1096, 200, 100],
          ['May', 1000, 0, 200, 100],
          ['April', 1000, 148, 200, 100],
          ['March', 1000, 79, 200, 100],
        ]);

    var options = {
        chart: {
            title: 'TowerCo Site Endorsements',
            subtitle: 'Endorsed By Teams Per Month',
            width: '80%'
          },
          bars: 'vertical' // Required for Material Bar Charts.
    };

    var chart = new google.charts.Bar(document.getElementById('chart_div'));
    chart.draw(data, google.charts.Bar.convertOptions(options));

  }
</script>

@endsection
