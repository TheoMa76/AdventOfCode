<?php

require_once "./toolkit.php";

debugMode(true);
$contenu = file_get_contents('data.txt');

function compter($chaine) {
    $longueur = strlen($chaine);
    $pos = 0;
    for ($i = 0; $i <= $longueur - 4; $i++) {
        $sousChaine = substr($chaine, $i, 14);

        $unique = array_unique(str_split($sousChaine));

        $lettresDifferentes = count($unique) === 14;
        dd($sousChaine, $unique, $lettresDifferentes);
        $pos++;
        if ($lettresDifferentes) {
            return $pos+13; 
        }
    }

    return -1;
}

$position = compter($contenu);

if ($position !== -1) {
    echo $position;
}