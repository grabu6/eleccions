<?php

/**
 * Comprova si un DNI és vàlid
 *
 * @param string $dni
 * @return bool
 */
function is_valid_dni(string $dni): bool
{
    $letter = substr($dni, -1);
    $numbers = substr($dni, 0, -1);

    if (!is_numeric($numbers)) {
        return false;
    }

    if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numbers % 23, 1) == $letter && strlen($letter) == 1 && strlen(
            $numbers
        ) == 8) {
        return true;
    }
    return false;
}

/**
 * * Divideix tots els valors d'un array per un número
 *
 * @param array $array
 * @param float $num
 * @return array
 */
function array_divide(array $array, float $num): array
{
    $out = [];
    foreach ($array as $key => $value) {
        $out[$key] = $value / $num;
    }
    return $out;
}

/**
 * Aplica la llei d'Hondt i reparteix els escons indicats als diferents partits en base els vots.
 * S'espera com entrada un array de votacions amb partits (clau) i vots (valors).
 * Retorna un array de partits (clau) i escons (valors)
 *
 * @param array $votacions
 * @param int $num_escons
 * @return array
 */
function llei_dhondt(array $votacions, int $num_escons): array
{
    // TODO: Implementar

    // Els vots nuls no compten pel recompte

    // Compta el total de vots

    // Als vots blancs no s'assignen escons

    // S'exclouen aquelles candidatures que no han aconseguit superar la barrera del tres per cent.
    // Vegeu funció array_filter https://www.php.net/manual/en/function.array-filter

    // Cal ordenar les candidatures per vots per resoldre els empats
    // Vegeu la funció natsort https://www.php.net/manual/en/function.natsort.php

    // Cal assegurar-se que s'ordenin de major a menor

    // La fórmula D'Hondt consisteix a dividir els vots que ha obtingut cada partit pels nombres naturals (1, 2, 3, ...)
    // fins al nombre d'escons en joc a cada circumscripció. Els escons s'atribueixen a les candidatures amb els
    // quocients més grans, de més a menys fins a arribar als escons en joc de la circumscripció.
    // En cas d'empat en algun quocient, s'emporta l'escó la candidatura que té més vots en total.

    // Ordenem els quocients de major a menor
    // Vegeu funció usort https://www.php.net/manual/en/function.usort.php

    // Assignem els escons als quocients majors

    return []; //$escons;
}

/**
 * Aplica la quota Hare i reparteix els escons indicats als diferents partits en base els vots.
 * S'espera com entrada un array de votacions amb partits (clau) i vots (valors).
 * Retorna un array de partits (clau) i escons (valors)
 * @param array $votacions
 * @param int $num_escons
 * @return array
 */
function quota_hare(array $votacions, int $num_escons): array
{
    // Els vots nuls i els blancs no compten pel recompte
    unset($votacions["nul"]);
    unset($votacions["blanc"]);

    // Total de vots
    $totalvots = array_sum($votacions);

    // Ordenem les candidatures per vots per una millor vista
    // Vegeu la funció natsort https://www.php.net/manual/en/function.natsort.php
    natsort($votacions);
    // Cal assegurar-se que s'ordenin de major a menor
    $votacions = array_reverse($votacions);

    // Si es trien n escons i s'emeten m vots vàlids, s'estableix una quota q la qual servirà per a repartir els vots.
    // Aquesta quota es calcula mitjançant la fórmula: q= m/n
    $quota = $totalvots / $num_escons;

    // Si la i-èssima llista de I llistes inscrites obté m_i vots, aquesta llista obtindrà e_i escons per quota i r_i
    // vots per residu mitjançant la fórmula: e_i = m_i / q  aproximat a l'enter més proper inferior.
    // i residu r_i = m_i -q * e_i
    $escons = [];
    $residus = [];

    foreach ($votacions as $partit => $vots) {
        if (is_array($vots)) {
            $vots = $vots['vots']; // Asegúrate de que 'vots' sea la clave correcta para obtener el valor numérico
        }
        echo "malament";
        $escons[$partit] = floor($vots / $quota);
        $residus[$partit] = $vots - $quota * $escons[$partit];
    }

    // Sigui k el nombre d'escons que no són obtinguts per quota: k = n - sum(e)
    $k = $num_escons - array_sum($escons);

    // Aquests k escons són repartits entre els majors k residus r_i
    /// Ordenem els residus
    natsort($residus);
    /// Cal assegurar-se que s'ordenin de major a menor
    $residus = array_reverse($residus);

    $partits_residus = array_keys($residus);
    /// Assignem els escons als residus majors
    for ($i = 0; $i < $k && $i < count($residus); ++$i) {
        $escons[$partits_residus[$i]]++;
    }

    return $escons;
}