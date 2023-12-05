<?php

require_once "./toolkit.php";

debugMode(true);
$contenu = file_get_contents('data.txt');
$contenu = explode("\n", $contenu);

class Dossier
{
    public $nom;
    public $taille;
    public $sousDossiers = [];

    public function __construct($nom, $taille)
    {
        $this->nom = $nom;
        $this->taille = $taille;
    }

    public function ajouterSousDossier($sousDossier)
    {
        $this->sousDossiers[] = $sousDossier;
    }
}

class Fichier
{
    public $nom;
    public $taille;

    public function __construct($nom, $taille)
    {
        $this->nom = $nom;
        $this->taille = $taille;
    }
}

// Initialisation du dossier racine
$tableauFin = new Dossier("test", 0);

// Fonction récursive pour calculer la taille d'un dossier
function calculerTailleDossier($dossier)
{
    $taille = $dossier->taille;

    foreach ($dossier->sousDossiers as $sousDossier) {
        $taille += calculerTailleDossier($sousDossier);
    }

    return $taille;
}

// Variables pour suivre le dossier précédent
$dossierActuel = $tableauFin;

// Parcours du tableau initial
foreach ($contenu as $element) {
    // Vérifier si l'élément commence par "$ cd" suivi de caractères autres que ".."
    if (strpos($element, "$ cd") === 0 && strpos($element, "$ cd ..") !== 0) {
        // Calculer la taille du dossier actuel
        $taille = calculerTailleDossier($dossierActuel);

        // Ajouter le dossier actuel au dossier précédent
        $dossierPrecedent = new Dossier(substr($element, 5), $taille);
        $dossierActuel->ajouterSousDossier($dossierPrecedent);

        // Mettre à jour le dossier actuel
        $dossierActuel = $dossierPrecedent;
    } else {
        // Ajouter un fichier au dossier actuel
        $fichier = new Fichier("", intval($element));
        $dossierActuel->ajouterSousDossier($fichier);
    }
}

// Afficher les résultats
dd($tableauFin);
