<?php
/*
// nous avons besoin d un languange interprete cote serveur pour pouvoir communiquer
//$prenom = isset($_POST['prenom']) ? $_POST['prenom'];
$prenom = "";
if(isset($_POST['prenom'])){

    $prenom = $_POST['prenom']; // on recupere  l argument fourni via post
}

$tab = array();//on prepare le tableau array qui contiendra la reponse

$fichier = file_get_contents("fichier.json");
$json = json_decode($fichier, true);// on transforme en tableau array represente par la variable $json

foreach($json as $valeur){

    if($valeur['prenom'] == strtolower($prenom)){
        $tab['resultat'] = '<table border="1"><tr>';// on cree l 'indice resultat'
        foreach($valeur as $information){
            $tab['resultat'] .= '<td>' . $information . '</td>';
        }
        $tab['resultat'] .= '</tr></table>';
    }
}

echo json_encode($tab); // la reponse
*/

//**********************page_choix*****************
$prenom = "";
if(isset($_POST['prenom'])){

    $prenom = $_POST['prenom']; // on recupere  l argument fourni via post
}

$tab = array();//on prepare le tableau array qui contiendra la reponse

$fichier = file_get_contents("fichier.json");
$json = json_decode($fichier, true);// on transforme en tableau array represente par la variable $json

foreach($json as $valeur){

    if($valeur['prenom'] == strtolower($prenom)){
        $tab['resultat'] = '<table border="1"><tr>';// on cree l 'indice resultat'
        foreach($valeur as $information){
            $tab['resultat'] .= '<td>' . $information . '</td>';
        }
        $tab['resultat'] .= '</tr></table>';
    }
}

echo json_encode($tab); // la  reponse

