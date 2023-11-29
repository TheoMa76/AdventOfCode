<?php

require_once "./toolkit.php";

debugMode(true);
$contenu = file_get_contents('data.txt');
$contenu = explode("\n", $contenu);


// Initialisation du tableau résultant
$tableauxResultants = [];
$sousTableauActuel = [];

// Parcours du tableau initial
foreach ($contenu as $element) {
    // Vérifier si l'élément commence par "$ cd" suivi de caractères autres que ".."
    if (strpos($element, "$ cd") === 0 && strpos($element, "$ cd ..") !== 0) {
        // Si un sous-tableau actuel existe, l'ajouter au tableau résultant
        if (!empty($sousTableauActuel)) {
            $tableauxResultants[] = $sousTableauActuel;
            $sousTableauActuel = []; // Réinitialiser le sous-tableau actuel
        }
    }

    // Ajouter l'élément actuel au sous-tableau actuel
    $sousTableauActuel[] = $element;
}

// Ajouter le dernier sous-tableau actuel au tableau résultant
if (!empty($sousTableauActuel)) {
    $tableauxResultants[] = $sousTableauActuel;
}

// Afficher les résultats
    dd($tableauxResultants);

