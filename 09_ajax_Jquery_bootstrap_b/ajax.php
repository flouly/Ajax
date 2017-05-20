<?php
require_once('inc/init.inc.php');


$tab = array();
$tab['resultat'] = '';

$mode = isset($_POST['mode']) ? $_POST['mode'] : "liste";

if($mode == 'enregistrer'){

    if(isset($_POST['titre']) && isset($_POST['auteur']) && isset($_POST['contenu'])){

        $resultat = $pdo->prepare("INSERT INTO article (titre, auteur, contenu, date) VALUES (:titre, :auteur, :contenu, NOW())");

            $resultat->bindParam(':titre', $_POST['titre'], PDO::PARAM_STR);
            $resultat->bindParam(':auteur', $_POST['auteur'], PDO::PARAM_STR);
            $resultat->bindParam(':contenu', $_POST['contenu'], PDO::PARAM_STR);
            $resultat->execute();
           $resultat['resultat'] .= '<div class="alert alert-success" role="alert">Article enregistrer</div>';

    }

} elseif($mode == 'liste'){

    //recupere tous les articles et les placecer dans $tab['resultat']
        $liste_article = $pdo->query("SELECT id_article, titre, auteur, contenu, date_format(date, '%d-%m-%Y a %H:%i:%s') as date_fr FROM article ORDER BY date DESC");

        while($article = $liste_article->fetch(PDO::FETCH_ASSOC)){
                $tab['resultat'] .= "<div class='col-sm-4'>";
                 $tab['resultat'] .= "<div class='panel panel-default'>";
                  $tab['resultat'] .= "<div class='panel-heading'><h2>" . $article['titre'].'</h2></div>';
                  $tab['resultat'] .= "<div class='panel panel-body'>";

                  $tab['resultat'] .= '<span class="small">Par:'.  $article['auteur'].'le' .$article['date_fr'].'</span>';

                  $contenu = substr($article['contenu'], 0, 105) . '<a href="#url/fiche_article.php?id_)article=' .$article['id_article'].'">Lire la suite</a>';
                  $tab['resultat'] .= '<p>'. $contenu   .'</p>';


                  $tab['resultat'] .= "</div></div></div>";

        }



}

echo json_encode($tab);