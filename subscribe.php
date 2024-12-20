<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href=style.css>
</head>

<body>
<?php include_once("nav.php"); ?>
    <!-- ----------------------------Formulaire d'inscription simple-------------------------- -->
<div class="main_subscribe"
    <h2 class=subscribe_title>Formulaire d'inscription</h2>

    <form action="" method="POST">

        <label for="user_name">Nom :</label>
        <input type="text" id="nom" name="user_name" required>
        <br><br>

        <label for="user_firstname">Prénom :</label>
        <input type="text" id="prenom" name="user_firstname" required>
        <br><br>

        <label for="user_birthday">Date de naissance :</label>
        <input type="date" id="birthdate" name="user_birthday" required>
        <br><br>

        <label for="user_mail">Email :</label>
        <input type="email" id="email" name="user_mail" required>
        <br><br>

        <label for="user_password">Mot de passe :</label>
        <input type="password" id="password" name="user_password" required>
        <br><br>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br><br>

        <input type="submit" value="S'inscrire">
    </form>


    <!-- --------------Envoi après vérification des sécurités de base à la base de données-------------------------------- -->


    <?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // ---------récupération des réponses du formulaire-----------

        $user_name = htmlspecialchars(trim($_POST["user_name"]));
        $user_firstname = htmlspecialchars(trim($_POST["user_firstname"]));
        $user_mail = filter_var(trim($_POST["user_mail"]), FILTER_VALIDATE_EMAIL);
        $user_birthday = $_POST["user_birthday"];
        $user_password = $_POST["user_password"];
        $user_password_verification = $_POST["confirm_password"];
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);
        $user_date = $_POST["user_date"];

        if (empty($user_password) || empty($user_name) || empty($user_firstname) || empty($user_birthday)) {
            die("Tous les champs doivent être remplis");
        }
        if ($user_password !== $user_password_verification) {
            die("Les mots de passe ne correspondent pas");
        }

        // -------------Paramètres de connexion à la BDD----------------

       
        include_once("connectionBDD.php");

        // ---------Préparation de la requete SQL à l'insertion-----------


        $requete_sql = "INSERT INTO user (user_name,user_firstname,user_mail,user_birthday,user_password) VALUES ( :user_name,:user_firstname,:user_mail,:user_birthday,:user_password)";

        $secure_requete = $pdo->prepare($requete_sql);

        // ---------------Liaison des paramètres et execution -------------------


        $secure_requete->bindParam(":user_name", $user_name, PDO::PARAM_STR);
        $secure_requete->bindParam(":user_firstname", $user_firstname,PDO::PARAM_STR);
        $secure_requete->bindParam(":user_mail", $user_mail, PDO::PARAM_STR);
        $secure_requete->bindParam(":user_birthday", $user_birthday,PDO::PARAM_STR);
        $secure_requete->bindParam(":user_password", $hashed_password,PDO::PARAM_STR);
        $secure_requete->bindParam(":user_date", $user_date,PDO::PARAM_STR);

        try {
            if ($secure_requete->execute()) {
                
                header("location:connection_website.php");
                exit();
            } else {
                echo "Erreur lors de l'inscription.";
            }
        } catch (PDOException $e) {
            echo "Erreur d'insertion : " . $e->getMessage();
        }
    }


    ?>
</div>
</body>


</html>