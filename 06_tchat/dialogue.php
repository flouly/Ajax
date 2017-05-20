<?php
require_once("inc/init.inc.php");

if(empty($_SESSION['pseudo'])){
    //si l utilisateur ne s est pas connecte
    header("location:index.php");
}
var_dump($_SESSION);
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
    <div id="conteneur">
        <h2 id="moi">Bonjour<?php  echo $_SESSION['pseudo'] ;  ?></h2>
        <div id="message_tchat"></div>
        <div id="liste_membre_connecte"></div>
        <div class="clear"></div>
        <div id="smiley">
            <img src="smil/smiley1.gif" alt=":)">
        </div>
        <!--Formulaire-->
        <div>
            <form id="form">
                <textarea name="message" id="message" maxlength="300" rows="5"></textarea><br>
                <input type="submit"  name="envoi" value="envoi" class="submit">
            </form>
        </div>
        <div id="postMessage" ></div>
        <script>
        //faire en sorte que l utilisateur appuie sur la touche "entree" cela enregistre le message
        //code de la touche => 13
                document.addEventListener("keypress", function(event){

                    if(event.keyCode == 13) {
                        event.preventDefault();
                    // ajax("postMessage", message.value);
                    var messageValeur = document.getElementById("message").value;
                    //on envoie notre ajax pour enregistrement
                    console.log('test: '+messageValeur);
                    ajax("postMessage", messageValeur);
                        //on envoie une autre requete ajax pour recuperer les messages et les afficher dans message_tchat
                    ajax("message_tchat");
                    //on vide le champ
                    document.getElementById("message").value = "";
                    }
                });




        //ajout de :) dans le messsage lors du clic dsur le smiley
        document.getElementById("smiley").addEventListener("click", function(event){

            document.getElementById("message").value = document.getElementById("message").value + event.target.alt;
            document.getElementById("message").focus();//focus permet de remettre le curseur

        });

        //ajax('message_tchat');
        //pour recuoerer la liste des  membres connectes
        setInterval("ajax(liste_membre_connecte)", 3333);
         //pour recuoerer la liste des  messages en base de donnees
        setInterval("ajax(message_tchat)", 7000);

        //enregistrement du message via l evenement submit
        document.getElementById("form").addEventListener("submit", function(e){
            e.preventDefault();

           // ajax("postMessage", message.value);
           var messageValeur = document.getElementById("message").value;
           //on envoie notre ajax pour enregistrement
           console.log('test: '+messageValeur);
           ajax("postMessage", messageValeur);
             //on envoie une autre requete ajax pour recuperer les messages et les afficher dans message_tchat
           ajax("message_tchat");
           //on vide le champ
           document.getElementById("message").value = "";

        });

        //FERMETURE DE LA PAGE PAR L UTILISATEUR
        //on le retire du fichier prenom.txt
        window.onbeforeunload = function() {
            ajax('liste_membre_connecte', '<?php echo $_SESSION['pseudo']; ?>');
        }
        
        
        //declaration de la fonction
        function ajax(mode, arg = ''){ 
                    if(typeof(mode) == 'object'){
                        mode = mode.id;
                        // l argument mode recevra  les id des differents elements de notre page. Sachant que l on peut selectionner des element html directement par leur id (sans utiliser getElementById) il ya un risque de recuperer un objet representant l element html. dans ce cas nous recuperons juste l id
                    }
                    console.log("mode actuel: "+mode)//affiche le mode actuel dans la console

                    var file = "ajax_dialogue.php"
                    var parametres = "mode="+mode+"&arg="+arg;

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

                        document.getElementById(mode).innerHTML = obj.resultat;  

                        var boiteMessage = document.getElementById("message_tchat");
                          document.getElementById(mode).scrollTop = boiteMessage.scrollHeight;//permet de descendre  le scroll de ce div et de voir les derniers messages                   
                }
            } 
            xhttp.send(parametres);       
        }

        </script>
    </div>
</body>
</html>