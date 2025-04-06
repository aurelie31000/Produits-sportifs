<?php
// Informations de connexion à la base de données
$host = 'localhost';        // Adresse du serveur MySQL (localhost pour XAMPP)
$dbname = 'datawarehouse';  // Nom de la base de données
$username = 'root';         // Nom d'utilisateur MySQL (root par défaut dans XAMPP)
$password = '';             // Mot de passe MySQL (vide par défaut dans XAMPP)

try {
    // Établir la connexion à la base de données avec PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configurer PDO pour afficher les erreurs en cas de problème
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optionnel : Afficher un message si la connexion est réussie (pour le débogage)
    // echo "Connexion réussie à la base de données.";
} catch (PDOException $e) {
    // Afficher un message d'erreur si la connexion échoue
    die("Erreur de connexion : " . $e->getMessage());
}
?>
