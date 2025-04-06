<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/database.php'; // Charger la connexion à la base de données

// Vérifier que la requête est bien POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier et sécuriser les champs du formulaire
    if (isset($_POST['email'])) {
        $email = htmlspecialchars(trim($_POST['email']));
    } else {
        $email = null; // Ou une valeur par défaut
    }

    if (isset($_POST['password'])) {
        $password = htmlspecialchars(trim($_POST['password']));
    } else {
        $password = null;
    }

    // Vérifier que les champs ne sont pas vides
    if ($email && $password) {
        try {
            // Rechercher l'utilisateur dans la base de données
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Vérifier le mot de passe haché
                if (password_verify($password, $user['password'])) {
                    echo "Connexion réussie. Bienvenue, " . htmlspecialchars($user['username']) . "!";
                } else {
                    echo "Mot de passe incorrect.";
                }
            } else {
                echo "Utilisateur non trouvé.";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Requête invalide.";
}
?>
