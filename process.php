<?php
require_once 'includes/utils.php';
require_once "includes/db.php";
$status = "error"; // per defecte error genèric

if(!empty($_POST["poblacio"]) && !empty($_POST["demarcacio"]) && !empty($_POST["comarca"]))
{
    $db = DB::get_instance();
    $partits = $db->get_partits($_POST["demarcacio"]);

    $vots_partits = [];
    foreach ($partits as $p) {
        // Comprova les dades
        $partit = $p["curt"];
        $vots_partits[$partit] = ($_POST[$partit] ?? 0);
    }

    // Guarda les dades a la base de dades
    if($db->set_vots($_POST["poblacio"], $vots_partits)) {
        // Tots els resultats de la demarcació?
        $escons = $db->get_num_escons($_POST["demarcacio"]);
        $votacions = $db->get_vots($_POST["demarcacio"]);

        // Recalcula els resultats electorals de la demarcació
        $assignacio_escons = quota_hare($votacions, $escons); // TODO: Canviar a la llei d'Hondt

        // Guarda a la base de dades el nou calcul d'escons de la demarcació
        if($db->set_escons($_POST["demarcacio"], $assignacio_escons))
        {
            // Tot ok?
            $status = "success";
        }
        else
        {
            $status = "error-registrar-escons";
        }
    }
    else
    {
        $status = "error-registrar-vots";
    }
}

// Redireciona PGR a on toqui
if($status == "success") {
    header("Location: index.php?success"); // per defecte 302
}
else {
    header("Location: index.php?error=$status", true, 303);
}
