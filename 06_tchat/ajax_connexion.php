<?php
require_once("inc/init.inc.php");

$tab = array();
$tab['resultat'] = "";
$tab['pseudo'] = "disponible";

$erreur = false;  //variable de controle en fin de script. si sa valeur est passe a true alors il y a une erreur

//extract($_POST) a ne  pas utiliser

$mode = isset($_POST['mode']) ? $_POST['mode'] : '';
$pseudo = isset($_POST['pseudo']) ? addslashes($_POST['pseudo']) : '';
$civilite = isset($_POST['civilite']) ? addslashes($_POST['civilite']) : '';
$ville = isset($_POST['ville']) ? addslashes($_POST['ville']) : '';
$date_de_naissance = isset($_POST['date_de_naissance']) ? addslashes($_POST['date_de_naissance']) : '';
// addslashes predefinie php qui rajoute un \ pour ' et "

if($mode == "connexion"){
    //traitement de la connexion/inscription
    $resultat = $pdo->query("SELECT * FROM membre WHERE pseudo = '$pseudo' ");
    $membre = $resultat->fetch(PDO::FETCH_ASSOC);
    if($resultat->rowCount() == 0){

        $time = time();
        $pdo->query("INSERT INTO membre (pseudo, civilite, ville, date_de_naissance, ip, date_connexion) VALUES ('$pseudo', '$civilite', '$ville', '$date_de_naissance', '$_SERVER[REMOTE_ADDR]', '$time')");

        $id_membre = $pdo->lastInsertId(); //on recupere le dernier id insere pour l entrer dans la session + tard

        $tab['resultat'] = "Membre enregistre!";

    } elseif($resultat->rowCount() > 0 && $_SERVER['REMOTE_ADDR'] == $membre['ip']){

        //on met a jour uniquement sadate de connexion
        $time = time();
        $pdo->query("UPDATE membre SET date_connexion = $time  WHERE id_membre = $membre[id_membre]");
        $id_membre = $membre['id_membre'];
    } else {

        $tab['resultat'] = "Pseudo indisponible, veuillez recommencer";
        $erreur = true;// on change la valeur la variable erreur
        $tab['pseudo'] = "indisponible";// evite la redirection depuis index.php
    }

    if(!$erreur){//if erreur est egale a false if( erreur == false)

                //on place dans la $_SESSION LE pseudo , l id et la civilite de l utilisateur
                $_SESSION['id_membre'] = $id_membre;
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['civilite'] = $civilite;

                $f = fopen("prenom.txt", "a");
                        fwrite($f, $pseudo . "\n");//on ecrit dans se fihier 
                        fclose($f);//ferme le fichier pour liberer de l espace


    }
}// Fin if($mode == "connexion")
    echo json_encode($tab);