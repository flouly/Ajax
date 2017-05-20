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
    <script>
    //mettre en place un evenement sur la validation du formulaire (submit)
    //bloquer la validation du formuaire
    //eclhencer une requete ajax qui envoie sur ajax.php
     
        var formulaire = document.getElementById("mon_form").addEventListener("submit", ajax);

        function ajax(e){ // les() recoive l evenement on peut l appeler comme on veut ici e
            e.preventDefault();
            //alert('ok');
            var champSelect = document.getElementById("choix");
            var valeur = champSelect.value;
            
            var file = "ajax.php";
            var parametres = "personne="+valeur; //on choisi l indice ici personne (on peut l appeler comme  on veut) qu' on recuperera + tard en POST

            r = new XMLHttpRequest();

              r.open("POST", file, true);
             r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

             r.onreadystatechange = function(){

                if(r.readyState == 4 && r.status == 200){
                        console.log(r.responseText)
                        var reponse = JSON.parse(r.responseText);

                        document.getElementById("resultat").innerHTML = reponse.resultat;       
                }
             }
             r.send(parametres);

        }// end function
        
    </script>


</body>
</html>