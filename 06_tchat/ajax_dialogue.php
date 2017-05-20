<?php
require_once("inc/init.inc.php");

$tab = array();
$tab['resultat'] = '';

$mode = isset($_POST['mode']) ? $_POST['mode'] : '';
$arg = isset($_POST['arg']) ? $_POST['arg'] : '';

if($mode == 'liste_membre_connecte' && empty($arg)){

    //recuperer le contenu du fichier prenom.txt (file())
    //placer dans $tab['resultat'] le contnenu de ce fichier sous la form '<p>pseudo1</p><p>pseudo2</p>'
    $liste_membre = file("prenom.txt");

    foreach($liste_membre as $valeur){

        $tab['resultat'] .= '<p>' . $valeur   .'</p>';
    }
} elseif($mode == 'postMessage'){
        // on teste s il y a un message a enregistrer
        $arg = trim($arg);//on enleve les espaces

        if(!empty($arg)){
            $position = strpos($arg, ">");
            $arg = substr($arg, $position);

            $arg = addslashes($arg);//met un\ devant les ' et "
            // les deux lignes precedentes sont a  decocommenter si l on enregistre avec le pseudo et le >
            $pdo->query("INSERT INTO dialogue (id_membre, message, date) VALUES ('$_SESSION[id_membre]', '$arg', NOW())");

            $tab['resultat'] .= "Message enregistre!";
        }

} elseif($mode == "message_tchat"){
    //recuperer tous les messsages de la table dialogue
    //traitement de l objet resultat avec un while pour placer la reponse dans $tab['resultat']

    $messages = $pdo->query("SELECT membre.pseudo, membre.civilite, dialogue.message FROM membre, dialogue WHERE membre.id_membre = dialogue.id_membre ORDER BY dialogue.date ");

    while($liste_message = $messages->fetch(PDO::FETCH_ASSOC)){

        if($liste_message['civilite'] == 'm'){         
                $tab['resultat'] .= '<p class="bleu">' .ucfirst($liste_message['pseudo']).'>'. $liste_message['message'] .'</p>';
         } else {        
                $tab['resultat'] .= '<p class="rose">' .ucfirst($liste_message['pseudo']).'>'. $liste_message['message'] .'</p>';
          }
    }

} elseif($mode == 'liste_membre_connecte' && !empty($arg)){
    // si $arg n est pas vide alors on a un pseudo et nous devons le retirer du fichier prenom.txt
    $contenu = file_get_contents('prenom.txt');
    $contenu = str_replace($arg, "", $contenu); //on remplace le pseudo recherche par rien
    file_put_contents('prenom.txt', $contenu);

    //session_destroy();


}

echo json_encode($tab);