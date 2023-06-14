<?php

require_once "includes/db.php";

// Comprova si tenim les dades necessàries
if (empty($_GET["d"])) {
    die("Error: Cal especificar la demarcació");
}

// Comprovem si la demarcació existeix
$db = DB::get_instance();
if(!$db->connected())
{
    die("Error: No es pot connectar amb la base de dades");
}

// Comprovem si la demarcació existeix
if(!$db->find_demarcacio($_GET["d"]))
{
    die("Error: La demarcació no existeix");
}

// TODO: Posar el codi a lloc
$escons = $db->get_escons($_GET["d"]);
//var_dump($escons);

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Resultats a la demarcació de <?= ucwords($_GET["d"])?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">

    <!-- HighCharts 3D Graph CSS -->
    <style>
        #container {
            height: 400px;
        }

        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 310px;
            max-width: 800px;
            margin: 1em auto;
        }

        #sliders td input[type="range"] {
            display: inline;
        }

        #sliders td {
            padding-right: 1em;
            white-space: nowrap;
        }
    </style>

</head>
<body class="resultats">

<?php
include("includes/tabs.php");
?>

<div class="container">

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <div class="grafic-container" id="grafic-container">
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>
    </div>
</div>

<script type="text/javascript">// Data retrieved from https://netmarketshare.com
    // Set up the chart
    const chart = new Highcharts.Chart({
        chart: {
            renderTo: 'container',
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 0,
                beta: 0,
                depth: 26,
                viewDistance: 25
            }
        },
        xAxis: {
            // TODO: Cal canviar els partits de la demarcació
            categories: ['PSC', 'ERC', 'Junts', 'VOX', 'CUP-G', 'ECP',
                'Cs', 'PP']
        },
        yAxis: {
            title: {
                enabled: false
            }
        },
        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: 'Diputats: {point.y}'
        },
        title: {
            text: 'Eleccions al parlament de Catalunya 2022'
        },

        subtitle: {
            text: 'Diputats al Parlament de Catalunya de la demarcació de <?= ucwords($_GET["d"])?>'
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        series: [{
            name: 'Diputats',
            keys: ['name', 'y', 'color', 'label'],
            data: [
            <?php
            $db = DB::get_instance();
            $escons = $db->get_all_escons();

            foreach ($escons as $partit => $escons) {
                $color = ''; 
                $label = ''; 

                echo "['" . $partit . "', " . $escons . ", '" . $color . "'],";
            }
            ?>
            ],
            dataLabels: {
                enabled: true,
                format: '{point.label}',
                style: {
                    textOutline: '3px contrast'
                }
            },

            // Circular options
            center: ['50%', '88%'],
            size: '170%',
            startAngle: -100,
            endAngle: 100
        }],
    });

    function showValues() {
        document.getElementById('alpha-value').innerHTML = chart.options.chart.options3d.alpha;
        document.getElementById('beta-value').innerHTML = chart.options.chart.options3d.beta;
        document.getElementById('depth-value').innerHTML = chart.options.chart.options3d.depth;
    }

    // Activate the sliders
    document.querySelectorAll('#sliders input').forEach(input => input.addEventListener('input', e => {
        chart.options.chart.options3d[e.target.id] = parseFloat(e.target.value);
        showValues();
        chart.redraw(false);
    }));

    showValues();

</script>

</body>

</html>