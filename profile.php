<?php 
session_start();
include_once("connectionBDD.php");

// Préparation de la requête avec un paramètre nommé :id_user
$stmt = $pdo->prepare('SELECT * FROM user WHERE id_user = :id_user');

echo $_POST["id_user"];

// Liaison du paramètre :id_user avec la valeur fournie dans $_POST
$stmt->bindParam(":id_user", $_POST["id_user"], PDO::PARAM_INT);

$stmt->execute(); // Exécution de la requête

// Récupération de la ligne de résultat
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo $row["user_mail"];
    echo $row["user_name"];
    echo $row["user_firstname"];
} else {
    echo "Utilisateur non trouvé.";

    echo $_POST["id_user"];
}
?>
