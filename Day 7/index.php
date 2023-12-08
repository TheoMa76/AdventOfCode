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
    public $fichiers = [];

    public function __construct($nom, $taille)
    {
        $this->nom = $nom;
        $this->taille = $taille;
    }

    public function ajouterSousDossier($sousDossier)
    {
        $this->sousDossiers[] = $sousDossier;
    }

    public function ajouterFichier($fichier)
    {
        $this->fichiers[] = $fichier;
    }

    public function calculerTaille()
    {
        $taille = $this->taille;

        foreach ($this->fichiers as $fichier) {
            $taille += intval($fichier->taille);
        }

        foreach ($this->sousDossiers as $sousDossier) {
            $taille += $sousDossier->calculerTaille();
        }

        return $taille;
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


$systeme = [];
//dd($contenu);
for($i=0;$i<count($contenu);$i++){
    if(strpos($contenu[$i], "$ cd") === 0 && strpos($contenu[$i], "$ cd ..") !== 0 ){
        $dossier = new Dossier(substr($contenu[$i], 5),0);
    }if(strpos($contenu[$i], "dir") === 0){
        $sousDossier = new Dossier(substr($contenu[$i], 4),0);
        for($j=$i ; $j<count($contenu);$j++){
            if(ctype_digit($contenu[$j][0]) && strpos($contenu[$j], "dir") !== 0 && strpos($contenu[$j], "$ cd") !== 0){
                $espace = strpos($contenu[$i], " ");
                $taille = substr($contenu[$i], 0, $espace);
                $nomFichier = substr($contenu[$i], $espace+1);
                $fichier = new Fichier($nomFichier, $taille);
                $sousDossier->ajouterFichier($fichier);
                dd($sousDossier);
            }
        }
        $dossier->ajouterSousDossier($sousDossier);
    }if(ctype_digit($contenu[$i][0])){
        $espace = strpos($contenu[$i], " ");
        $taille = substr($contenu[$i], 0, $espace);
        $nomFichier = substr($contenu[$i], $espace+1);
        $fichier = new Fichier($nomFichier, $taille);
        $dossier->ajouterFichier($fichier);
    }
    //dd($contenu[$i]);

    if(isset($contenu[$i+1]) && strpos($contenu[$i+1], "$ cd") === 0 && strpos($contenu[$i+1], "$ cd ..") !== 0){
        //dd("CHECK");
        $dossier->taille = $dossier->calculerTaille();
        $systeme[$i] = $dossier;
    }
}

dd($systeme);
// // Fonction récursive pour calculer la taille d'un dossier
// function calculerTailleDossier($dossier)
// {
//     $taille = $dossier->taille;

//     foreach ($dossier->sousDossiers as $sousDossier) {
//         $taille += calculerTailleDossier($sousDossier);
//     }

//     return $taille;
// }

// // Variables pour suivre le dossier précédent
// $dossierActuel = $tableauFin;

// // Parcours du tableau initial
// foreach ($contenu as $element) {
//     // Vérifier si l'élément commence par "$ cd" suivi de caractères autres que ".."
//     if (strpos($element, "$ cd") === 0 && strpos($element, "$ cd ..") !== 0) {
//         // Calculer la taille du dossier actuel
//         $taille = calculerTailleDossier($dossierActuel);

//         // Ajouter le dossier actuel au dossier précédent
//         $dossierPrecedent = new Dossier(substr($element, 5), $taille);
//         $dossierActuel->ajouterSousDossier($dossierPrecedent);

//         // Mettre à jour le dossier actuel
//         $dossierActuel = $dossierPrecedent;
//     } else {
//         // Ajouter un fichier au dossier actuel
//         $fichier = new Fichier("", intval($element));
//         $dossierActuel->ajouterSousDossier($fichier);
//     }
// }

// // Afficher les résultats
// dd($tableauFin);
