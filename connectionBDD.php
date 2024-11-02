<?php

$host = 'localhost';
        $dbname = 'SocialDonkey';
        $username = 'root';
        $password = '';

        // Connexion avec PDO avec message d'erreur au cas où...
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            echo "Erreur de connexion : " . $e->getMessage();
        }

        ?>