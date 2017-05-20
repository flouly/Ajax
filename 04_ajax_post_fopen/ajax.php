<?php

$email = "";
if(isset($_POST['email'])){

$email = $_POST['email'];
    } 
//creation ou ouverture d un fichier via fopen
//en mode a , php cree le fichier s il  n existe  pas

$f = fopen("email.txt", "a");
fwrite($f, $email . "\n");

$tab = array();
$tab['resultat'] = '<h2>Confirmation de l\'inscription</h2>';

$liste = file("email.txt"); //la fonction file place chaque ligne precise en argument dans un tableau array


$tab['resultat'] .= '<p>Voici la liste de tout les inscrits</p>';

$tab['resultat'] .= '<ul>';

foreach($liste as $valeur){

    $tab['resultat'] .=  '<li>' . $valeur .'</li>';

}

$tab['resultat'] .= '</ul>';

echo json_encode($tab); 

