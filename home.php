<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" >
    <title>Accueil</title>
    <?php 
    include_once("connectionBDD.php"); 
    session_start();
    ?>
    
</head>
<body>

<div class="container">

    <h2>PUBLICATIONS</h2>

    <!-- Formulaire de publication -->
    <div class="form_home">
        <form action="" method="POST">
            <label for="my_publication" class="label_form_home">Votre publication</label>
            <textarea name="my_publication" id="my_publication" cols="50" rows="5" placeholder="Exprimez-vous" required></textarea>
            <button type="submit" id="button_form_home">Publier</button>
        </form>
    </div>

    <?php
    // Vérification de sécurité de la publication reçue
    if (isset($_POST["my_publication"]) && !empty($_POST["my_publication"]) && strlen($_POST["my_publication"]) < 500) {

        $my_publication = ($_POST["my_publication"]);
        $date_publication = date("Y-m-d H:i:s");

        // Vérification que l'utilisateur est connecté
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];

            // Enregistrement dans la base de données
            $requete_publication = "INSERT INTO post (post_contain, user_id, post_date) VALUES (:my_publication, :user_id, :post_date)"; 
            $secure_requete_publication = $pdo->prepare($requete_publication);

            $secure_requete_publication->bindParam(":my_publication", $my_publication, PDO::PARAM_STR);
            $secure_requete_publication->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $secure_requete_publication->bindParam(":post_date", $date_publication);

            try {
                if ($secure_requete_publication->execute()) {
                    echo "<p>Votre publication a été ajoutée : " . htmlspecialchars($my_publication) . "</p>";
                } else {
                    echo "<p>Problème de BDD lors de la publication.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        } else {
            echo "<p>Utilisateur non connecté. Veuillez vous connecter pour publier.</p>";
        }
    } else {
        echo "<p>Le formulaire n'a pu être publié, merci d'en vérifier le contenu.</p>";
    }

    // Affichage des publications
    $requete_publications_home = "SELECT * FROM post JOIN user ON post.user_id=user.id_user ORDER BY post_date DESC";
    $secure_requete_publications_home = $pdo->prepare($requete_publications_home);

    try {
        if ($secure_requete_publications_home->execute()) {
            $publications = $secure_requete_publications_home->fetchAll(PDO::FETCH_ASSOC);
            echo "<h3>Liste des publications</h3>";
    
            // Affichage des publications
            foreach ($publications as $publication) {
                echo "<div class='home_publications'>
                        <p>" . htmlspecialchars($publication["post_contain"]) . "</p>
                        <div class='post-date'>Publié le " . htmlspecialchars($publication["post_date"]) . " par : " . htmlspecialchars($publication["user_name"]) . "</div>
                      </div>";
            }
        } else {
            echo "<p>Problème d'affichage des posts.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
    
    ?>

</div>

</body>
</html>
