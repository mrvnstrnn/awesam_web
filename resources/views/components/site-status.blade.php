<div class="mb-3 profile-responsive card">
    <div class="dropdown-menu-header">
        <div class="dropdown-menu-header-inner bg-dark">
            <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg'); background-size: cover;"></div>
            <div class="menu-header-content btn-pane-right">
                <div>
                    <h5 class="menu-header-title">Site Status</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="p-0 card-body align-center" style="position: relative;">
        <div id="chart-radial"></div>
    </div>
</div> 

<div class="card-shadow-primary profile-responsive card-border mb-3 card">
    <div class="dropdown-menu-header">
        <div class="dropdown-menu-header-inner bg-dark">
            <div class="menu-header-image" style="background-image: url('images/dropdown-header/abstract2.jpg')"></div>
            <div class="menu-header-content btn-pane-right">
                <div class="avatar-icon-wrapper mr-2 avatar-icon-xl">
                    <div class="avatar-icon">
                        <img src="images/avatars/3.jpg" alt="Avatar 5">
                    </div>
                </div>
                <div>
                    <h5 class="menu-header-title">Mathew Mercer</h5>
                    <h6 class="menu-header-subtitle">Agent</h6>
                </div>
            </div>
        </div>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-3">
                        <div class="icon-wrapper m-0">
                            <div class="progress-circle-wrapper">
                                <div class="circle-progress d-inline-block circle-progress-success"><canvas width="104" height="104" style="height: 52px; width: 52px;"></canvas>
                                    <small><span>81%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left">
                        <div class="widget-heading">January Sales</div>
                        <div class="widget-subheading">Lorem ipsum dolor</div>
                    </div>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-3">
                        <div class="icon-wrapper m-0">
                            <div class="progress-circle-wrapper">
                                <div class="circle-progress d-inline-block circle-progress-info"><canvas width="104" height="104" style="height: 52px; width: 52px;"></canvas>
                                    <small><span>69%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left">
                        <div class="widget-heading">February Sales</div>
                        <div class="widget-subheading">Maecenas tempus, tellus</div>
                    </div>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-3">
                        <div class="icon-wrapper m-0">
                            <div class="progress-circle-wrapper">
                                <div class="circle-progress d-inline-block circle-progress-danger"><canvas width="104" height="104" style="height: 52px; width: 52px;"></canvas>
                                    <small><span>23%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left">
                        <div class="widget-heading">March Sales</div>
                        <div class="widget-subheading">Donec vitae sapien</div>
                    </div>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-3">
                        <div class="icon-wrapper m-0">
                            <div class="progress-circle-wrapper">
                                <div class="circle-progress d-inline-block circle-progress-dark"><canvas width="104" height="104" style="height: 52px; width: 52px;"></canvas>
                                    <small><span>69%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left">
                        <div class="widget-heading">April Sales</div>
                        <div class="widget-subheading">Curabitur ullamcorper ultricies</div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>


<script>

window.Apex = {
    dataLabels: {
        enabled: false
    },
    stroke: {
        width: 2
    },
};

var options444 = {
    chart: {
        height: 390,
        type: 'radialBar',
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 225,
            hollow: {
                margin: 0,
                size: '70%',
                background: '#fff',
                image: undefined,
                imageOffsetX: 0,
                imageOffsetY: 0,
                position: 'front',
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 0,
                    blur: 4,
                    opacity: 0.24
                }
            },
            track: {
                background: '#fff',
                strokeWidth: '67%',
                margin: 0, // margin is in pixels
                dropShadow: {
                    enabled: true,
                    top: -3,
                    left: 0,
                    blur: 4,
                    opacity: 0.35
                }
            },

            dataLabels: {
                showOn: 'always',
                name: {
                    offsetY: -10,
                    show: true,
                    color: '#888',
                    fontSize: '17px'
                },
                value: {
                    formatter: function (val) {
                        return parseInt(val) + "%";
                    },
                    color: '#111',
                    fontSize: '36px',
                    show: true,
                }
            }
        }
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: ['#ABE5A1'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        }
    },
    series: [75],
    stroke: {
        lineCap: 'round'
    },
    labels: ['Completed'],

};

var chart444 = new ApexCharts(
    document.querySelector("#chart-radial"),
    options444
);

if (document.getElementById('chart-radial')) {
            chart444.render();
        }


</script>