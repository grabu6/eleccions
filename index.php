<?php
 include('includes/db.php');
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Escrutini</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class='nav nav-pills'>
    <div class='nav-item'>
        <a class='nav-link' data-toggle='pill' href='parlament.php'>Resultats</a>
    </div>
</div>

<div class="container">

    <div class="form-container left-container">
        <form action="addvotes.php" method="post">
            <h1>Escrutini</h1>
            <span>Escull la població on registrar les dades</span>

            <label for="poblacio">
                <input id="poblacio_in" list="poblacio" name="poblacio" type="text" onchange="setComarcademarcacio()"
                       required>
            </label>

            <datalist id="poblacio">
                <?php
                $db = DB::get_instance();
                $municipis = $db->get_municipis();

                foreach ($municipis as $m){
                    $pob = $m["poblacio"];
                    $com = $m["comarca"];
                    $dem = $m["demarcacio"];

                    echo "<option value='$pob' data-comarca='$com' data-demarcacio='$dem'> $pob - $dem </option> \n";
                }
                ?>
            </datalist>

            <input type="hidden" id="comarca" name="comarca"/>
            <input type="hidden" id="demarcacio" name="demarcacio"/>

            <button>Inicia</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">

            <div class="overlay-panel overlay-right">
                <h1>Eleccions 2023 - Parlament de Catalunya</h1>
            </div>
        </div>
    </div>
</div>
<div class="container-notifications">
    <?php
    $msg = null;
    $class = "message ";

    // Mostra els missatges d'error
    if(!$db->connected()){
        $class .= "error";
        $msg = 'No es pot connectar amb la base de dades';
    }
    if (isset($_GET['error'])) {
        $class .= "error hide";
        $msg = match ($_GET['error']) {
            "error-registrar-escons", "error-registrar-vots" => 'Hi ha hagut un error en registrar les dades',
            default => 'S\'ha produït un error inesperat',
        };
    }
    elseif (isset($_GET['success'])) {
        $class .= "info hide";
        $msg = 'S\'ha registrat correctament';
    }

    if ($msg) {
        echo "<p class='$class' id='message'> $msg </p>";
    }
    ?>
</div>

<script>
    // Assigna la comarca i la demarcació a la població escollida
    function setComarcademarcacio() {
        var element_input = document.getElementById('poblacio_in');
        var element_datalist = document.getElementById('poblacio');
        var opSelected = element_datalist.querySelector(`[value="${element_input.value}"]`);
        document.getElementById("comarca").value = opSelected.getAttribute('data-comarca');
        document.getElementById("demarcacio").value = opSelected.getAttribute('data-demarcacio');
    }

    // Neteja els GETS I POSTS
    function clearGetPost() {
        window.history.replaceState(null, null, window.location.pathname)
    }

    // Amaga el missatge d'error mostrat
    function amagaError() {
        Array.from(document.getElementsByClassName("hide")).forEach(function(element) {
            element.style.opacity = "0"
        });
        clearGetPost()
    }

    window.onload = () => {
        setTimeout(amagaError, 2000)
    }
</script>

</body>

</html>