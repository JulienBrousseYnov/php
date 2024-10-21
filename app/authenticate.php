<?php
// Configurer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrer la session
session_start();

// Connexion à la base de données
$mysqli = new mysqli("db", "root", "root", "cv_db");

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si c'est une inscription ou une connexion
    if (isset($_POST['register'])) {
        // Récupérer les données du formulaire d'inscription
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Vérifie si l'e-mail existe déjà
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // E-mail déjà utilisé
            header("Location: register.php?alert=mail_exists");
            exit();
        }

        // Vérifier que les champs ne sont pas vides
        if (empty($username) || empty($email) || empty($password)) {
            die("Please fill in all fields.");
        }

        // Préparer une requête pour insérer l'utilisateur dans la base de données
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);

        // Vérifier si la préparation a réussi
        if (!$stmt) {
            die("Error preparing statement: " . $mysqli->error);
        }

        // Hacher le mot de passe avant de l'insérer
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Lier les paramètres et exécuter la requête
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            // Redirection vers index.php après une inscription réussie
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Fermer la déclaration
        $stmt->close();
    } elseif (isset($_POST['login'])) {
        // Récupérer les données du formulaire de connexion
        $email = trim($_POST['e-mail']);
        $password = trim($_POST['password']);

        // Vérifier que les champs ne sont pas vides
        if (empty($email) || empty($password)) {
            die("Please fill in all fields.");
        }

        // Préparer une requête pour vérifier les informations d'identification de l'utilisateur
        $sql = "SELECT id, username, password FROM users WHERE email = ?";
        $stmt = $mysqli->prepare($sql);

        // Vérifier si la préparation a réussi
        if (!$stmt) {
            die("Error preparing statement: " . $mysqli->error);
        }

        // Lier les paramètres et exécuter la requête
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Vérifier si l'utilisateur existe
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();

            // Vérifier le mot de passe
            if (password_verify($password, $hashed_password)) {
                // Enregistrer les informations de l'utilisateur dans la session
                $_SESSION['user_id'] = $id; // ID de l'utilisateur
                $_SESSION['email'] = $email; // Email de l'utilisateur
                $_SESSION['username'] = $username; 
                // Redirection vers index.php après une connexion réussie
                header("Location: index.php");
                exit();
            } else {
                header("Location: login.php?error=wrong_password");
                exit();
            }
        } else {
            header("Location: login.php?error=user_not_found");
            exit();
        }

        $stmt->close();
    }
}

// Fermer la connexion
$mysqli->close();
?>
