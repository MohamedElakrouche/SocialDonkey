<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <?php 
    include("connectionBDD.php");
    session_start(); 
    ?>
</head>

<body>

    <form action="" method="post">
        <label for="mail_connection">Adresse email :</label>
        <input type="email" name="mail_connection" id="mail_connection" placeholder="Entrez votre email ici" required> <br><br>

        <label for="password_connection">Mot de passe :</label>
        <input type="password" name="password_connection" id="password_connection" placeholder="Entrez votre mot de passe ici" required>

        <button type="submit">Se connecter</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Récupération des données du formulaire
        $mail_connection = $_POST["mail_connection"];
        $password_connection = $_POST["password_connection"];

        // Requête pour récupérer l'ID associé au mail
        $requeteID = "SELECT id_user FROM user WHERE user_mail = :mail";

        // Préparation de la requête
        $secure_requeteID = $pdo->prepare($requeteID);
        $secure_requeteID->bindParam(":mail", $mail_connection, PDO::PARAM_STR);

        try {
            // Exécution de la requête
            if ($secure_requeteID->execute()) {
                $result_connection = $secure_requeteID->fetch(PDO::FETCH_ASSOC);
                
                // Vérifie si un ID utilisateur a été trouvé
                if ($result_connection) {
                    $testID = $result_connection["id_user"];
                    $_SESSION["user_id"] = $testID;

                    // Redirection vers la page de profil
                    header("Location: profile.php");
                    exit();
                } else {
                    echo "Utilisateur non trouvé.";
                }
            } else {
                echo "Erreur lors de l'exécution de la requête.";
            }
        } catch (PDOException $e) {
            echo "Erreur de communication : " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
