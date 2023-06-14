<?php

require_once "includes/utils.php";

// Prova la llei d'Hondt / Quota Hare amb els resultats a les elecions a la demarcació de Girona 2021
// https://www.ccma.cat/324/eleccions-parlament-2021/girona/provincia/09170000000/

$vots = [ // Es mostren els resultats aplicant la llei d'Hondt
    "JUNTS" => 89770, // 7 escons
    "ERC" => 59893, // 4 escons
    "PSC" => 41678, // 3 escons
    "CUP-G" => 24837, // 2 escons
    "VOX" => 16917, // 1 escó
    "ECP" => 11101, // 0 escons
    "Cs" => 8935, // 0 escons
    "PDeCAT" => 8755, // 0 escons
    "PP" => 5470, // No passa el tall del 3%
    "PNC" => 886, // No passa el tall del 3%
    "FNC" => 873, // No passa el tall del 3%
    "PRIMÀRIES" => 668, // No passa el tall del 3%
    "UEP" => 631, // No passa el tall del 3%
    "CERO-VERDS" => 615, // No passa el tall del 3%
    "PUM+J" => 483, // No passa el tall del 3%
    "PCTC" => 357, // No passa el tall del 3%
    "ALIANZA CV" => 167, // No passa el tall del 3%
    "IZQP CV" => 109 // No passa el tall del 3%
];

// TODO: Canviar a llei d'Hondt
//var_dump(llei_dhondt($vots, 17));
var_dump(quota_hare($vots, 17));
