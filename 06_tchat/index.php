<?php
require_once("inc/init.inc.php");

if(!empty($_SESSION['pseudo'])){
    //si l utilisateur est deja present exemple: on force l url, il y chargement de page et la fonction php header redirige tout de suite 
    header("location:dialogue.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <fieldset class="cadre_acceuil">
        <div id="message" ></div>
    </fieldset>

    <fieldset class="cadre_acceuil">
        <form  id="form">
                <label for="pseudo">Pseudo</label>
                <input type="text" id="pseudo"  name="pseudo"   value=""  >

                <label for="civilite">Civilite</label>
                <select name="civilite" id="civilite">
                        <option value="m">Homme</option>
                        <option value="f">Femme</option>
                </select>

                <label for="ville">Ville</label>
                <input type="text" id="ville"  name="ville"   value=""  >

                <label for="date_de_naissance">Date_de_naissance</label>
                <input type="text" id="date_de_naissance"  name="date_de_naissance"   value="" placeholder="YYYY-MM-DD" >

                <input type="submit"  name="connexion"  value="Se connecter" >

        </form>

    </fieldset>

    <script>
        document.getElementById("form").addEventListener("submit", function(event){
            event.preventDefault();//eviter le rechargement de la page

            var champPseudo = document.getElementById("pseudo");
            var pseudo = champPseudo.value;

             var champCivilite = document.getElementById("civilite");
            var civilite = champCivilite.value;

             var champVille = document.getElementById("ville");
            var ville = champVille.value;

             var champDate = document.getElementById("date_de_naissance");
            var date_de_naissance = champDate.value;

            var parametres = "mode=connexion&pseudo="+pseudo+"&civilite="+civilite+"&ville="+ville+"&date_de_naissance="+date_de_naissance;//on choisit les indices

            var file = "ajax_connexion.php";

            if(window.XMLHttpRequest){
                var xhttp = new XMLHttpRequest();

            } else{
                var xhttp = new ActiveXObject("MICROSOFT.XMLHTTP");
            }

            xhttp.open("POST", file, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhttp.onreadystatechange = function() {

                  if(xhttp.readyState == 4 && xhttp.status == 200){
                        console.log(xhttp.responseText)
                        var obj = JSON.parse(xhttp.responseText);

                        document.getElementById("message").innerHTML = obj.resultat;

                        if(obj.pseudo == 'disponible'){
                            //si l indice a la valeur disponible on peut connecter l utilisateur
                            //window: objet qui represente le navigateur
                            window.location.href = 'dialogue.php';
                        }                              
                }
            } 
            xhttp.send(parametres);
        });
    </script>
</body>
</html>