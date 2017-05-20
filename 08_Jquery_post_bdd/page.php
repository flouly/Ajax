<?php
   $pdo = new PDO('mysql:host=localhost;dbname=entreprise', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

   $liste_prenom = $pdo->query("SELECT prenom, id_employes FROM employes");
   $liste = "";// toujours creer une liste vide pour pouvoir concatener
while($personne = $liste_prenom->fetch(PDO::FETCH_ASSOC)) {

    $liste  .= '<option value="' . $personne['id_employes'].'">' . $personne['prenom']  . '</option>';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form id="mon_form">
        <label >Prenom</label>
        <select  id="choix">
         <?php
             echo $liste; //recuperer tout les prenoms presents dans la bdd
         ?>

        </select>
        <br />

        <input type="submit"  id="valider" value="Valider" >
        
    </form>

    <hr />  
     <div id="resultat"></div>
      <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script>
   
        $(document).ready(function(){
            $("#mon_form").on('submit', function(event){
                event.preventDefault();

                var parametres = "personne="+$("#choix").val();
                $.post("ajax.php", parametres, function(reponse){
                    $("#resultat").html(reponse.resultat);
                }, "json");

            });
        });
        
    </script>


</body>
</html>