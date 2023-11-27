<?php

require_once "./toolkit.php";

$contenu = file_get_contents('data.txt');
$debut = str_split($contenu, 4);

for($i = 0; $i < count($debut); $i++){
    $debut[$i] = str_split($debut[$i]);
}

dd($debut);