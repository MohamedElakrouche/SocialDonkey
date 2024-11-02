

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connection</title>
    <?php include("connectionBDD.php");
    session_start(); 
     ?>
</head>

<body>

    <form action="" method="post">


        <label for="mail_connection" id="mail_connection">Adresse email : </label>
        <input type="email" name="mail_connection" placeholder="Entrez votre email ici" required> <br> <br>

        <label for="password-connection" id="password_connection" >Mot de passe :</label>
        <input type="password" name="password_connection" placeholder="Entrez votre mot de passe ici" required>

        <button type="submit">Se connecter</button>

    </form>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // ---------récupération des réponses du formulaire-----------
$mail_connection=$_POST["mail_connection"];
$password_connection=$_POST["password_connection"];

       //Récupération de l'ID associé au mail
       
       $requeteID="SELECT id_user FROM user WHERE user_mail=:mail";

       // On prépare la requête

       $secure_requeteID= $pdo -> prepare($requeteID);

       $secure_requeteID-> bindParam (":mail",$mail_connection, PDO::PARAM_STR );

       try {
        
        if ($secure_requeteID->execute()) {
            
        

            $result_connection=$secure_requeteID;
            $testID=fletch->
            $_SESSION["id_user"]=$testID;
        header("location:profile.php");
        exit();
       }
       else {
echo "id non récupéré";
       }
    }
catch (PDOException $e) {
    echo "erreur de communication :" . $e->getMessage();
    
}

    }

    



?>
</body>

</html>


