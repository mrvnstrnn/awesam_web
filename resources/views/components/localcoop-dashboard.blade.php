<style>

    .milestone-bg{
        position: absolute; 
        left: 0px; 
        top:0px; 
        opacity: 0.30; 
        height: 100%; 
        width:100%; 
        background-repeat: no-repeat; background-size: 150%;        
    }

    .milestone-bg-1 {
        background-image: url('/images/milestone-gray.jpeg');   
    }
    .milestone-bg-2 {
        background-image: url('/images/milestone-green.jpeg');   
    }
    .milestone-bg-3 {
        background-image: url('/images/milestone-red.jpeg');   
    }
    .milestone-bg-4 {
        background-image: url('/images/milestone-orange.jpeg');   
    }
    .milestone-bg-5 {
        background-image: url('/images/milestone-primary.jpeg');   
    }

</style>

@php

  if(\Auth::user()->profile_id == 21){
    
    $user_detail = \Auth::user()->getUserDetail()->first();
    $vendor = \App\Models\Vendor::where('vendor_id', $user_detail->vendor_id)->first();

    $rt = DB::table('towerco_region_totals_per_company')->where('TOWERCO', $vendor->vendor_acronym)->get();

  }
  else {    
    $rt = DB::table('view_local_coop_region_totals')->get();
  }


  $ctr = 0;


@endphp

<div class="row">
    <div class="col-12">
        <H3>COOP List</H3>
    </div>
    @foreach ($rt as $r)
        @php
            $ctr = $ctr + 1;
        @endphp
        <div class="col">
            <div class="mb-2 card">
                <div class="widget-chart widget-chart2 text-left p-0">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                            <div class="milestone-bg milestone-bg-{{ $ctr  }}" style=""></div>

                            <div class="widget-chart-flex">
                                <div class="widget-title  text-muted text-uppercase">
                                    {{ $r->region }}
                                </div>
                            </div>
                            <div class="widget-numbers">
                            <span>{{ $r->coops }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>          
    @endforeach

</div>
<div class="divider"></div>
<div class="row">
    <div class="col-6">
        <H3>Engagements Added</H3>
        <div class="card mb-3">
            <div class="card-body">
                <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.20; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                <div id="engaged" style="width: 100%; height: 200px;"></div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.20; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                <div id="not_engaged" style="width: 100%; height: 200px;"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <H3>Contacts Added</H3>
        <div class="card mb-3">
            <div class="card-body">
                <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.20; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                <div id="contact_type" style="width: 100%; height: 473px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col-12">
        <H3>Issues</H3>
        <div class="card mb-3">
            <div class="card-body">
                <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.20; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                <div id="ongoing_issues" style="width: 100%; height: 300px;"></div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.20; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                <div id="resolved_issues" style="width: 100%; height: 300px;"></div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  google.charts.load('current', {packages: ['corechart', 'bar']});
  google.charts.setOnLoadCallback(drawBasic);

  var ongoing_issues = [['Nature of Issue', 'Counter', { role: 'style' }, { role: 'annotation' }]];
  var resolved_issues = [['Nature of Issue', 'Counter', { role: 'style' }, { role: 'annotation' }]];
 
  var engaged = [['Type of Engagement', 'Counter', { role: 'style' }, { role: 'annotation' }]];
  var not_engaged = [['Type of Engagement', 'Counter', { role: 'style' }, { role: 'annotation' }]];

  var contact_type = [['Contact Type', 'Counter', { role: 'style' }, { role: 'annotation' }]];

  @php
    $ms = DB::table('view_local_coop_nature_of_issues')
        ->where('status_of_issue', 'Ongoing')
        ->get();

    $colors = array('#FADA5E', '#F9A602', '#FFD300', '#D2B55B', '#C3B091', '#DAA520', '#FCF4A3', '#FCD12A', '#C49102', '#FFDDAF');
    $ctr = 0;
    foreach($ms as $m){

      echo "ongoing_issues.push(['" . $m->{'nature_of_issue'}  . "', " . $m->counter  . ", 'stroke-color: #443403; stroke-width: 1; fill-color: " . $colors[$ctr] . "', '" . $m->{'nature_of_issue'}  . " - " . $m->counter  . "']);";    
      $ctr++;

    }

    $ms = DB::table('view_local_coop_nature_of_issues')
        ->where('status_of_issue', 'Resolved')
        ->get();

    $colors = array('#FADA5E', '#F9A602', '#FFD300', '#D2B55B', '#C3B091', '#DAA520', '#FCF4A3', '#FCD12A', '#C49102', '#FFDDAF');
    $ctr = 0;
    foreach($ms as $m){

      echo "resolved_issues.push(['" . $m->{'nature_of_issue'}  . "', " . $m->counter  . ", 'stroke-color: #443403; stroke-width: 1; fill-color: " . $colors[$ctr] . "', '" . $m->{'nature_of_issue'}  . " - " . $m->counter  . "']);";    
      $ctr++;

    }


    $ms = DB::table('view_local_coop_engagement_types')
        ->where('result_of_engagement', 'Engaged')
        ->get();

    $colors = array('#FADA5E', '#F9A602', '#FFD300', '#D2B55B', '#C3B091', '#DAA520', '#FCF4A3', '#FCD12A', '#C49102', '#FFDDAF');
    $ctr = 0;
    foreach($ms as $m){

      echo "engaged.push(['" . $m->{'engagement_type'}  . "', " . $m->counter  . ", 'stroke-color: #443403; stroke-width: 1; fill-color: " . $colors[$ctr] . "', '" . $m->{'engagement_type'}  . " - " . $m->counter  . "']);";    
      $ctr++;

    }

    $ms = DB::table('view_local_coop_engagement_types')
        ->where('result_of_engagement', 'Not Engaged')
        ->get();

    $colors = array('#FADA5E', '#F9A602', '#FFD300', '#D2B55B', '#C3B091', '#DAA520', '#FCF4A3', '#FCD12A', '#C49102', '#FFDDAF');
    $ctr = 0;
    foreach($ms as $m){

        echo "not_engaged.push(['" . $m->{'engagement_type'}  . "', " . $m->counter  . ", 'stroke-color: #443403; stroke-width: 1; fill-color: " . $colors[$ctr] . "', '" . $m->{'engagement_type'}  . " - " . $m->counter  . "']);";    
      $ctr++;

    }

    $ms = DB::table('view_local_coop_engagement_types')
        ->where('result_of_engagement', 'Not Engaged')
        ->get();

    $colors = array('#FADA5E', '#F9A602', '#FFD300', '#D2B55B', '#C3B091', '#DAA520', '#FCF4A3', '#FCD12A', '#C49102', '#FFDDAF');
    $ctr = 0;
    foreach($ms as $m){

        echo "not_engaged.push(['" . $m->{'engagement_type'}  . "', " . $m->counter  . ", 'stroke-color: #443403; stroke-width: 1; fill-color: " . $colors[$ctr] . "', '" . $m->{'engagement_type'}  . " - " . $m->counter  . "']);";    
      $ctr++;

    }
    

    $ms = DB::table('view_local_coop_contact_types')
        ->get();

    $colors = array('#FADA5E', '#F9A602', '#FFD300', '#D2B55B', '#C3B091', '#DAA520', '#FCF4A3', '#FCD12A', '#C49102', '#FFDDAF');
    $ctr = 0;
    foreach($ms as $m){

        echo "contact_type.push(['" . $m->{'contact_type'}  . "', " . $m->counter  . ", 'stroke-color: #443403; stroke-width: 1; fill-color: " . $colors[$ctr] . "', '" . $m->{'contact_type'}  . " - " . $m->counter  . "']);";    
      $ctr++;

    }

  @endphp


  

  function drawBasic() {

    var data = google.visualization.arrayToDataTable(ongoing_issues );

    var options = {
      title: 'Ongoing Issues',
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

    
    var chart = new google.visualization.BarChart(document.getElementById('ongoing_issues'));
    chart.draw(data, options);



    var data = google.visualization.arrayToDataTable(resolved_issues );

    var options = {
      title: 'Resolved Issues',
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
    
    var chart = new google.visualization.BarChart(document.getElementById('resolved_issues'));
    chart.draw(data, options);

    

    var data = google.visualization.arrayToDataTable(engaged );

    var options = {
      title: 'Engaged',
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
    
    var chart = new google.visualization.BarChart(document.getElementById('engaged'));
    chart.draw(data, options);




    var data = google.visualization.arrayToDataTable(not_engaged );

    var options = {
      title: 'Not Engaged',
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

    
    var chart = new google.visualization.BarChart(document.getElementById('contact_type'));
    chart.draw(data, options);
    

    var data = google.visualization.arrayToDataTable(contact_type );

    var options = {
      title: 'Contact Types',
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

    
    var chart = new google.visualization.BarChart(document.getElementById('contact_type'));
    chart.draw(data, options);


  }

  
</script>