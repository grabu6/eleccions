<?php

require_once "includes/db.php";

// TODO: Posar el codi a lloc
$db = DB::get_instance();
$escons = $db->get_all_escons();
//var_dump($escons);

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Composició del parlament de Catalunya</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">

    <!-- HighCharts parliament CSS -->
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        input[type="number"] {
            min-width: 50px;
        }
    </style>
</head>
<body class="resultats">

<?php
include("includes/tabs.php");
?>

<div class="container">

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/item-series.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <div class="grafic-container">
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>
    </div>
</div>

<div class="container-notifications">
    <?php
    $db = DB::get_instance();
    if (!$db->connected())
    {
        echo "<p class='message error'> No es pot connectar amb la base de dades. </p>";
    }
    else if($db->count_demarcacio_with_escons() != 4)
    {
        echo "<p class='message error'> Encara falten dades d'algunes demarcacions! </p>";
    }
    ?>
</div>

<script type="text/javascript">
    Highcharts.chart('container', {

        chart: {
            type: 'item'
        },

        title: {
            text: 'Eleccions al parlament de Catalunya 2022'
        },

        subtitle: {
            text: 'Distribució dels diputats al Parlament de Catalunya'
        },

        legend: {
            labelFormat: '{name} <span style="opacity: 0.4">{y}</span>'
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

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 600
                },
                chartOptions: {
                    series: [{
                        dataLabels: {
                            distance: -30
                        }
                    }]
                }
            }]
        }
    });

</script>

</body>

</html>