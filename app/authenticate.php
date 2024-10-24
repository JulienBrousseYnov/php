<?php

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si c'est une inscription ou une connexion
    if (isset($_POST['register'])) {
        // Récupérer les données du formulaire d'inscription
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Vérifie si l'e-mail existe
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // E-mail déjà utilisé
            header("Location: register.php?alert=mail_exists");
            exit();
        }


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
            // Redirection vers index.php si inscription réussie
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['login'])) {
        // Récupérer les données du formulaire de connexion
        $email = trim($_POST['e-mail']);
        $password = trim($_POST['password']);

        // Vérifier si case vides ou non
        if (empty($email) || empty($password)) {
            die("Please fill in all fields.");
        }

        $sql = "SELECT id, username, password FROM users WHERE email = ?";
        $stmt = $mysqli->prepare($sql);

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
                // Enregistrer les informations de l'utilisateur
                $_SESSION['user_id'] = $id;
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username; 
                // Redirection vers index.php si connexion réussie
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
