<?php 
session_start();
include_once("connectionBDD.php");

// Vérifie si l'ID utilisateur est présent dans la session
if (isset($_SESSION["test_id"])) {
    // Préparation de la requête avec l'ID utilisateur de la session
    $stmt = $pdo->prepare('SELECT * FROM user WHERE id_user = :id_user');

    // Liaison du paramètre :id_user avec la valeur de la session
    $stmt->bindParam(":id_user", $_SESSION["test_id"], PDO::PARAM_INT);

    $stmt->execute(); // Exécution de la requête

    // Récupération de la ligne de résultat
    $requete_profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($requete_profile) {
        echo "Adresse email : " . htmlspecialchars($requete_profile["user_mail"]) . "<br>";
        echo "Nom : " . htmlspecialchars($requete_profile["user_name"]) . "<br>";
        echo "Prénom : " . htmlspecialchars($requete_profile["user_firstname"]) . "<br>";
        echo "date de naissance : " . htmlspecialchars($requete_profile["user_birthday"]) . "<br>";
        echo "date d'inscription : " . htmlspecialchars($requete_profile["user_date"]) . "<br>";
    } else {
        echo "Utilisateur non trouvé.";
    }
} else {
    echo "ID utilisateur non trouvé dans la session.";
}
?>
