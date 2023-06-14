<?php

require_once "includes/db.php";

// Comprova si tenim les dades necessàries
if (empty($_POST["poblacio"]) || empty($_POST["demarcacio"]) || empty($_POST["comarca"])) {
    header("Location: index.php?error", true, 303);
}

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Escrutini <?= $_POST["poblacio"] ?> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">

</head>
<body>

<div class='nav nav-pills'>
    <div class='nav-item'>
        <a class='nav-link' data-toggle='pill' href='index.php'>Inici</a>
    </div>
    <div class='nav-item'>
        <a class='nav-link' data-toggle='pill' href='parlament.php'>Resultats</a>
    </div>
</div>

<div class="container right-panel-active">
    <div class="form-container right-container">
        <form action="process.php" class="scrollable" method="post">

            <input type="hidden" id="poblacio" name="poblacio" value="<?= $_POST["poblacio"] ?>"/>
            <input type="hidden" id="comarca" name="comarca" value="<?= $_POST["comarca"] ?>"/>
            <input type="hidden" id="demarcacio" name="demarcacio" value="<?= $_POST["demarcacio"] ?>"/>

                <?php
                $db = DB::get_instance();

                if ($db->connected()) {
                    $partits = $db->get_partits($_POST["demarcacio"]);

                    $partits[] = ["nom" => "Vots en blanc *", "curt" => "blanc"];
                    $partits[] = ["nom" => "Vots nuls *", "curt" => "nul"];

                    echo '<div class="votacions">';
                    foreach ($partits as $p) {
                        echo '<div class="vots-partit">';
                        echo '<div class="partit"> ' . $p["nom"] . ' </div>';
                        echo '<input type="number" name="' . $p["curt"] . '" placeholder="Vots" />';
                        echo '</div>';
                    }

                    echo "<button>Registra</button>";
                    echo "</div>";
                }
                else
                {
                    echo "<p class='message error' id='message'> No es pot connectar amb la base de dades </p>";
                }
                ?>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Afegeix els resultats electorals</h1>
                <p>
                    <?php
                    echo $_POST["poblacio"] . " - " . $_POST["comarca"] . " - " . $_POST["demarcacio"]; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Neteja els GETS I POSTS
    function clearGetPost() {
        window.history.replaceState(null, null, window.location.pathname)
    }

    window.onload = () => {
        setTimeout(clearGetPost, 2000)
    }
</script>

</body>

</html>