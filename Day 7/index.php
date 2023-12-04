<?php

require_once "./toolkit.php";

debugMode(true);
$contenu = file_get_contents('data.txt');
$contenu = explode("\n", $contenu);

// Initialisation du tableau résultant
$tableauxResultants = [];
// Fonction récursive pour calculer la taille d'un dossier
function calculerTailleDossier($dossier) {
    $taille = 0;
    foreach ($dossier as $element) {
        // Vérifier si l'élément est un tableau (sous-dossier)
        if (is_array($element)) {
            // Si c'est un sous-dossier, ajouter la taille du sous-dossier
            $taille += calculerTailleDossier($element);
        } else {
            // Si l'élément est un fichier, ajouter sa taille
            $taille += intval($element);
        }
    }
    return $taille;
}

// Variables pour suivre le dossier précédent
$dossierPrecedent = "";
$sousTableauActuel = [];

// Parcours du tableau initial
foreach ($contenu as $element) {
    // Vérifier si l'élément commence par "$ cd" suivi de caractères autres que ".."
    if (strpos($element, "$ cd") === 0 && strpos($element, "$ cd ..") !== 0) {
        // Si un sous-tableau actuel existe, calculer sa taille et l'ajouter au tableau résultant
        if (!empty($sousTableauActuel)) {
            $taille = calculerTailleDossier($sousTableauActuel);
            $tableauxResultants[] = [$dossierPrecedent => $taille];
        }
        

        // Réinitialiser le sous-tableau actuel et mettre à jour le dossier précédent
        $sousTableauActuel = [];
        $dossierPrecedent = substr($element, 5);


    } else {
        // Ajouter l'élément actuel au sous-tableau actuel
        $sousTableauActuel[] = $element;
    }

}

// Ajouter la taille du dernier sous-tableau actuel au tableau résultant
if (!empty($sousTableauActuel)) {
    $taille = calculerTailleDossier($sousTableauActuel);
    $tableauxResultants[] = [$dossierPrecedent => $taille];
}

// Afficher les résultats
dd($tableauxResultants);


//FAIRE AVEC DES CLASS 