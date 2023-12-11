<?php

function jouerTour($adversaire, $vous)
{
    
    if ($vous == 'Y') {
        if($adversaire == 'A'){
            $choix = 1;
        }else if($adversaire == 'B'){
            $choix = 2;
        }else if($adversaire == 'C'){
            $choix = 3;
        }
        return $choix + 3;
    } elseif ($vous == 'Z') {
        if($adversaire == 'A'){
            $choix = 2;
        }else if($adversaire == 'B'){
            $choix = 3;
        }else if($adversaire == 'C'){
            $choix = 1;
        }
        return $choix + 6;
    } else {
        if($adversaire == 'A'){
            $choix = 3;
        }else if($adversaire == 'B'){
            $choix = 1;
        }else if($adversaire == 'C'){
            $choix = 2;
        }
        return $choix + 0;
    }
}


$lines = file('data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


$totalScore = 0;

foreach ($lines as $line) {
    list($adversaire, $vous) = explode(' ', $line);
    $totalScore += jouerTour($adversaire, $vous);
}


echo "Votre score total serait : $totalScore\n";

?>