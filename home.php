<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
    <?php 
    session_start();
    include_once("connectionBDD.php"); 
    include_once("nav.php");

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION["user_id"])) {
        echo "<p>Veuillez vous connecter pour accéder à cette page.</p>";
        exit;
    }

    // Fonction pour ajouter une publication
    function ajouterPublication($pdo, $user_id, $contenu) {
        $date_publication = date("Y-m-d H:i:s");
        $requete = "INSERT INTO post (post_contain, user_id, post_date) VALUES (:contenu, :user_id, :date)";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(":contenu", $contenu, PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":date", $date_publication);
        return $stmt->execute();
    }

    // Fonction pour supprimer une publication
    function supprimerPublication($pdo, $user_id, $publication_id) {
        $requete = "DELETE FROM post WHERE post_id = :publication_id AND user_id = :user_id";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(":publication_id", $publication_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Fonction pour modifier une publication
    function modifierPublication($pdo, $user_id, $publication_id, $contenu) {
        $requete = "UPDATE post SET post_contain = :contenu WHERE post_id = :publication_id AND user_id = :user_id";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(":contenu", $contenu, PDO::PARAM_STR);
        $stmt->bindParam(":publication_id", $publication_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Ajout de la publication
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["my_publication"]) && !empty(trim($_POST["my_publication"])) && !isset($_POST["publication_id"])) {
        $contenu = trim($_POST["my_publication"]);
        if (strlen($contenu) <= 500) {
            if (ajouterPublication($pdo, $_SESSION["user_id"], $contenu)) {
                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            } else {
                echo "<p>Erreur lors de l'ajout de la publication.</p>";
            }
        } else {
            echo "<p>La publication ne doit pas dépasser 500 caractères.</p>";
        }
    }

    // Modification de la publication
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["edit_publication_id"]) && isset($_POST["edited_publication"])) {
        $publication_id = $_POST["edit_publication_id"];
        $edited_content = trim($_POST["edited_publication"]);
        if (modifierPublication($pdo, $_SESSION["user_id"], $publication_id, $edited_content)) {
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit;
        } else {
            echo "<p>Erreur lors de la modification de la publication.</p>";
        }
    }

    // Suppression de la publication
    if (isset($_POST["button_delete_publication"]) && isset($_POST["publication_id"])) {
        $publication_id = $_POST["publication_id"];
        if (supprimerPublication($pdo, $_SESSION["user_id"], $publication_id)) {
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit;
        } else {
            echo "<p>Erreur lors de la suppression de la publication.</p>";
        }
    }
    ?>
</head>
<body>

<div class="container">
    <h2 class="publications_title">PUBLICATIONS</h2>

    <!-- Formulaire de publication -->
    <div class="form_home">
        <form action="" method="POST">
            <label for="my_publication" class="label_form_home">Votre publication</label>
            <textarea name="my_publication" id="my_publication" cols="50" rows="5" placeholder="Exprimez-vous" required></textarea>
            <button type="submit" id="button_form_home">Publier</button>
        </form>
    </div>

    <!-- Affichage des publications -->
    <?php
    try {
        $requete_publications_home = "SELECT post.post_id, post.post_contain, post.post_date, user.user_name, post.user_id
                                      FROM post
                                      JOIN user ON post.user_id = user.id_user
                                      ORDER BY post_date DESC";
        $stmt = $pdo->prepare($requete_publications_home);
        if ($stmt->execute()) {
            $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<h3>Liste des publications</h3>";

            foreach ($publications as $publication) {
                echo "<div class='home_publications'>
                        <p>" . htmlspecialchars($publication["post_contain"]) . "</p>
                        <div class='post-date'>Publié le " . htmlspecialchars($publication["post_date"]) . " par " . htmlspecialchars($publication["user_name"]) . "</div>";
                
                // Affiche les boutons de modification et de suppression si l'utilisateur est l'auteur de la publication

                if ($_SESSION["user_id"] == $publication["user_id"]) 
                {
                    echo "<form action='' method='POST' style='display:inline-block;'>
                            <input type='hidden' name='publication_id' value='" . htmlspecialchars($publication["post_id"]) . "'>
                            <button type='submit' name='button_delete_publication' id='button_delete_publication'>Supprimer</button>
                          </form>";

                    // Formulaire de modification (affiché si l'utilisateur clique sur "Modifier")

                    if (isset($_POST['edit_publication_id']) && $_POST['edit_publication_id'] == $publication["post_id"]) 
                    {
                        echo "<form action='' method='POST' style='display:inline-block;'>
                                <input type='hidden' name='edit_publication_id' value='" . htmlspecialchars($publication["post_id"]) . "'>
                                <textarea name='edited_publication' required>" . htmlspecialchars($publication["post_contain"]) . "</textarea>
                                <button type='submit'>Enregistrer</button>
                              </form>";
                    } 
                    else
                     {
                        echo "<form action='' method='POST' style='display:inline-block;'>
                                <input type='hidden' name='edit_publication_id' value='" . htmlspecialchars($publication["post_id"]) . "'>
                                <button type='submit'>Modifier</button>
                              </form>";
                    }
                }
                
                echo "</div>";
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
