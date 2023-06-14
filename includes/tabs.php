<?php
require_once "db.php";

$parlament_tab = false;
$dem_tab = "";

if (basename($_SERVER['PHP_SELF']) == "parlament.php")
    $parlament_tab = true;
else if(basename($_SERVER['PHP_SELF']) == "demarcacio.php" && isset($_GET["d"]))
    $dem_tab = $_GET["d"];

?>
<!-- Nav pills -->
<div class='nav nav-pills'>
    <div class='nav-item'>
        <a class='nav-link' data-toggle='pill' href='index.php'>Escrutini</a>
    </div>
    <div class='nav-item <?php if($parlament_tab) echo "active"; ?>'>
        <a class='nav-link' data-toggle='pill' href='parlament.php'>Parlament</a>
    </div>
    <?php

    $db = DB::get_instance();
    $demarcacions = $db->get_demarcacions();

    foreach ($demarcacions as $row) {
        $dem = $row['nom'];
        $dem_upper = ucwords($dem);
        $dem_lower = strtolower($dem);
    
        $extra = $dem_tab == $dem_lower ? "active" : "";
        echo "<div class='nav-item $extra'>
                <a class='nav-link' data-toggle='pill' href='demarcacio.php?d=$dem_lower'>$dem_upper</a>
              </div>";
    }
    ?>
</div>