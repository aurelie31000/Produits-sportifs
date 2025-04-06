<?php
require_once 'config/database.php'; // Charger la connexion à la base de données

// Vérifier que la requête est bien POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sécuriser les entrées et retirer les espaces inutiles
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Hacher le mot de passe avant de l'enregistrer
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Rechercher si l'utilisateur existe déjà dans la base de données
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "L'utilisateur existe déjà.";
        } else {
            // Insérer un nouvel utilisateur avec le mot de passe haché
            $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password_hashed);

            // Exécuter l'insertion
            $stmt->execute();

            echo "Utilisateur inscrit avec succès.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
