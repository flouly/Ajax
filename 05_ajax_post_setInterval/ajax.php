<?php


  $pdo = new PDO('mysql:host=localhost;dbname=entreprise', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

  $tab = array();

  $liste_employes = $pdo->query("SELECT * FROM employes");

  $tab['resultat'] = '<table class="table table-bordered">';

  $tab['resultat'] .= '<tr>';

  $nb_col = $liste_employes->columnCount(); //a mettre dans une variable a l exterieur pour que l operation ne soit repetee a chaque passage de boucle

  for($i = 0; $i < $nb_col; $i++){

    $colonne = $liste_employes->getColumnMeta($i);
    $tab['resultat'] .= '<th>'.  $colonne['name']    .'</th>';

  }

  $tab['resultat'] .= '</tr>';

  while($ligne = $liste_employes->fetch(PDO::FETCH_ASSOC)){

    $tab['resultat'] .= '<tr>';
    foreach($ligne as $valeur){

        $tab['resultat'] .= '<td>'. $valeur   .'</td>';
    }


    $tab['resultat'] .= '</tr>';
  }
  
  
  $tab['resultat'] .= '</table>';


//echo $tab['resultat'];
  
  echo json_encode($tab);
  
  
  
  
  
  
  