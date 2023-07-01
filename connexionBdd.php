<?php

function newUser($firstName, $name, $username, $email, $phone, $password) {
    $servername = "localhost"; // Adresse du serveur MySQL (généralement localhost)
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $dbname = "yourmarket"; // Nom de la base de données

    try {
        // Créer une connexion PDO à la base de données
        $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        session_start();
        // Configurer le mode d'erreur pour afficher les erreurs de requête
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête d'insertion des données d'inscription
        $query = "INSERT INTO users (firstName, name, username, email, phone, password)
                  VALUES (:firstName, :name, :username, :email, :phone, :password)";
        $stmt = $connexion->prepare($query);

        // Liage des valeurs des paramètres
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $password);

        // Exécution de la requête
        $stmt->execute();

        // Afficher un message de succès
        echo "Inscription réussie!";
    } catch(PDOException $e) {
        // En cas d'erreur, afficher le message d'erreur
        echo "Erreur d'inscription: " . $e->getMessage();
    }
}

?>
