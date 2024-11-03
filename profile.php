<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="main_profile">
    
<h2 class="profile_title">Votre profil</h2>

<?php 
session_start();
include_once("connectionBDD.php");
include_once("nav.php");

// Vérifie si l'ID utilisateur est présent dans la session
if (isset($_SESSION["test_id"])) {
    // Préparation de la requête avec l'ID utilisateur de la session
    $stmt = $pdo->prepare('SELECT * FROM user WHERE id_user = :id_user');
    $stmt->bindParam(":id_user", $_SESSION["test_id"], PDO::PARAM_INT);
    $stmt->execute();

    // Récupération de la ligne de résultat
    $requete_profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($requete_profile)
    {
        echo "<div class='container_profile_design'>";
        echo "<div class='profile_design'>"; 
      echo "<p><span class='label'>Adresse email :</span> <span class='value'>" . htmlspecialchars($requete_profile["user_mail"]) . "</span></p>";
     echo "<p><span class='label'>Nom :</span> <span class='value'>" . htmlspecialchars($requete_profile["user_name"]) . "</span></p>";
      echo "<p><span class='label'>Prénom :</span> <span class='value'>" . htmlspecialchars($requete_profile["user_firstname"]) . "</span></p>";
      echo "<p> <span class='label'>Date de naissance :</span> <span class='value'>" . htmlspecialchars($requete_profile["user_birthday"]) . "</span></p>";
     echo "<p><span class='label'>Date d'inscription :</span> <span class='value'>" . htmlspecialchars($requete_profile["user_date"]) . "</span></p>";
       echo "</div>";
    echo "</div>";
    } 
    else 
    {
        echo "<p>Utilisateur non trouvé.</p>";
    }
} else {
    echo "<p> ID utilisateur non trouvé dans la session. </p>";
}
?>
</body>
</html>
