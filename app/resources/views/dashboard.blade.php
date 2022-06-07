<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="{{ asset('images/FullColor-NoTagline-vierkant.png') }}">
    <title>DevelopersDashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css?v=').time() }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                <a href="{{ url('/logout') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Uitloggen</a>
        </div>

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <img src={{ asset('images/FullColor-Tagline.png') }} class="developersLogo" alt="">
        </div>
        <form method="post" action="/dashboard">

            @csrf
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">


                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Aanvragen</div>
                        </div>

                        <label class="toggle">
                            <input name="selectDayMonth" onchange="this.form.submit()" type="checkbox" {{  ($dayMonth == 'on' ? ' checked' : '') }}>
                            <span class="slider"></span>
                            <span class="labels" data-on="Maand" data-off="Dag"></span>
                        </label>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                <div id="chartdiv"></div>
                            </div>
                        </div>

                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">


                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Aanvragen per {{  ($weekMonth == 'on' ? ' maand' : 'week') }}</div>
                        </div>
                        <label class="toggle">
                            <input name="selectWeekMonth" onchange="this.form.submit()" type="checkbox" {{  ($weekMonth == 'on' ? ' checked' : '') }}>
                            <span class="slider"></span>
                            <span class="labels" data-on="Maand" data-off="Week"></span>
                        </label>
                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">

                                <canvas id="myChart" height="280" width="600"></canvas>

                            </div>
                        </div>


                        <div>
                            @if($weekMonth != 'on')
                                <select name="weekNrSelect" onchange="this.form.submit()">
                                    @foreach ($weekNr as $version)
                                        <option value="{{ $version }}" @selected($currentWeek == $version)>
                                            {{'Week '. $version }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <select name="yearsSelect" onchange="this.form.submit()">
                                    @foreach ($years as $version)
                                        <option value="{{ $version }}" @selected($currentYear == $version)>
                                            {{'Jaar '. $version }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>

<script type="text/javascript" src="js/app.js"></script>
<script>

    const vacancyCount = {!! json_encode($vacancyCount) !!};
    let weekJobOrderAll = {!! json_encode($weekData) !!};
    let yearJobOrderAll = {!! json_encode($yearData) !!};
    const weekMonth = {!! json_encode($weekMonth) !!};

    let weeksLabel = [weekJobOrderAll[0][1], weekJobOrderAll[1][1], weekJobOrderAll[2][1], weekJobOrderAll[3][1], weekJobOrderAll[4][1]];
    let monthsLabel = [yearJobOrderAll[0][1], yearJobOrderAll[1][1], yearJobOrderAll[2][1], yearJobOrderAll[3][1], yearJobOrderAll[4][1], yearJobOrderAll[5][1], yearJobOrderAll[6][1], yearJobOrderAll[7][1], yearJobOrderAll[8][1], yearJobOrderAll[9][1], yearJobOrderAll[10][1], yearJobOrderAll[11][1]];

    let weeksData = [weekJobOrderAll[0][0], weekJobOrderAll[1][0], weekJobOrderAll[2][0], weekJobOrderAll[3][0], weekJobOrderAll[4][0]];
    let monthsData = [yearJobOrderAll[0][0], yearJobOrderAll[1][0], yearJobOrderAll[2][0], yearJobOrderAll[3][0], yearJobOrderAll[4][0], yearJobOrderAll[5][0], yearJobOrderAll[6][0], yearJobOrderAll[7][0], yearJobOrderAll[8][0], yearJobOrderAll[9][0], yearJobOrderAll[10][0], yearJobOrderAll[11][0]];

    let weekBackgroundColor = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)'
    ];
    let monthBackgroundColor = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)'
    ]

    let weekBorderColor = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)'
    ];
    let monthBorderColor = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)'
    ];

    let currentLabel = [];
    let currentData = [];
    let currentDataAll= [];
    let currentBackgroundColor = [];
    let currentBorderColor = [];

    if(weekMonth !== 'on') {
        currentLabel = weeksLabel;
        currentData = weeksData;
        currentDataAll = weekJobOrderAll;
        currentBackgroundColor = weekBackgroundColor;
        currentBorderColor = weekBorderColor;
    }
    else {
        currentLabel = monthsLabel;
        currentData = monthsData;
        currentDataAll = yearJobOrderAll;
        currentBackgroundColor = monthBackgroundColor;
        currentBorderColor = monthBorderColor;
    }
        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: currentLabel,
                datasets: [{
                    label: '# Aanvragen',
                    data: currentData,
                    backgroundColor: currentBackgroundColor,
                    borderColor: currentBorderColor,
                    borderWidth: 1
                }]
            },
            plugins: [{
                afterDraw: function (chart) {
                    const ctx = chart.ctx;
                    ctx.restore();
                    ctx.font = "1em sans-serif";
                    ctx.fillStyle = 'white';
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";

                    Chart.helpers.each(currentDataAll.forEach(function (dataset, i) {
                        //console.log(myChart.getDatasetMeta(0));
                        const meta = myChart.getDatasetMeta(i);
                        Chart.helpers.each(meta.data.forEach(function (bar, index) {
                            const centerPoint = bar.getCenterPoint();
                            if (currentDataAll[index][0] !== 0) {
                                ctx.fillText(currentDataAll[index][0], centerPoint.x, centerPoint.y)
                            }
                        }),this)
                    }),this);

                    ctx.save();
                }
            }],
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

</script>

<script>
    var dayMonth = {!! json_encode($dayMonth) !!};

    am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chartdiv");

// Create chart
// https://www.amcharts.com/docs/v5/charts/radar-chart/
        var chart = root.container.children.push(am5radar.RadarChart.new(root, {
            panX: false,
            panY: false,
            startAngle: 160,
            endAngle: 380
        }));


// Create axis and its renderer
// https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Axes
        var axisRenderer = am5radar.AxisRendererCircular.new(root, {
            innerRadius: -40
        });

        axisRenderer.grid.template.setAll({
            stroke: root.interfaceColors.get("background"),
            visible: true,
            strokeOpacity: 0.8
        });
        let xAxis = chart;
        if(dayMonth !== 'on') {
             xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0,
                min: 0,
                max: 25,
                strictMinMax: true,
                renderer: axisRenderer
            }));
        } else {
             xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0,
                min: 0,
                max: 150,
                strictMinMax: true,
                renderer: axisRenderer
            }));
        }

// Add clock hand
// https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Clock_hands
        var axisDataItem = xAxis.makeDataItem({});

        var clockHand = am5radar.ClockHand.new(root, {
            pinRadius: am5.percent(20),
            radius: am5.percent(100),
            bottomWidth: 40
        })

        var bullet = axisDataItem.set("bullet", am5xy.AxisBullet.new(root, {
            sprite: clockHand
        }));

        xAxis.createAxisRange(axisDataItem);

        var label = chart.radarContainer.children.push(am5.Label.new(root, {
            fill: am5.color(0xffffff),
            centerX: am5.percent(50),
            textAlign: "center",
            centerY: am5.percent(50),
            fontSize: "3em"
        }));

        axisDataItem.set("value", vacancyCount);
        bullet.get("sprite").on("rotation", function () {
            var value = axisDataItem.get("value");
            var text = Math.round(axisDataItem.get("value")).toString();
            var fill = am5.color(0x000000);
            xAxis.axisRanges.each(function (axisRange) {
                if (value >= axisRange.get("value") && value <= axisRange.get("endValue")) {
                    fill = axisRange.get("axisFill").get("fill");
                }
            })

            label.set("text", Math.round(value).toString());

            clockHand.pin.animate({ key: "fill", to: fill, duration: 500, easing: am5.ease.out(am5.ease.cubic) })
            clockHand.hand.animate({ key: "fill", to: fill, duration: 500, easing: am5.ease.out(am5.ease.cubic) })
        });
        
        chart.bulletsContainer.set("mask", undefined);

// Create axis ranges bands
// https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Bands
        if(dayMonth !== 'on') {
            var bandsData = [{
                title: "Unsustainable",
                color: "#ee1f25",
                lowScore: 0,
                highScore: 5
            }, {
                title: "Volatile",
                color: "#f04922",
                lowScore: 5,
                highScore: 10
            }, {
                title: "Foundational",
                color: "#fdae19",
                lowScore: 10,
                highScore: 15
            }, {
                title: "Sustainable",
                color: "#54b947",
                lowScore: 15,
                highScore: 20
            }, {
                title: "High Performing",
                color: "#0f9747",
                lowScore: 20,
                highScore: 25
            }];
        } else {
            var bandsData = [{
                title: "Unsustainable",
                color: "#ee1f25",
                lowScore: 0,
                highScore: 30
            }, {
                title: "Volatile",
                color: "#f04922",
                lowScore: 30,
                highScore: 60
            }, {
                title: "Foundational",
                color: "#fdae19",
                lowScore: 60,
                highScore: 90
            },  {
                title: "Sustainable",
                color: "#54b947",
                lowScore: 90,
                highScore: 120
            }, {
                title: "High Performing",
                color: "#0f9747",
                lowScore: 120,
                highScore: 150
            }];
        }
        am5.array.each(bandsData, function (data) {
            var axisRange = xAxis.createAxisRange(xAxis.makeDataItem({}));

            axisRange.setAll({
                value: data.lowScore,
                endValue: data.highScore
            });

            axisRange.get("axisFill").setAll({
                visible: true,
                fill: am5.color(data.color),
                fillOpacity: 0.8
            });

            axisRange.get("label").setAll({
                text: data.title,
                inside: true,
                radius: 15,
                fontSize: "0.9em",
                fill: root.interfaceColors.get("background")
            });
        });
// Make stuff animate on load
        chart.appear(1000, 100);

    }); // end am5.ready()
</script>
