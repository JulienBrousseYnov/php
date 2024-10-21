<?php


// Connexion à la base de données
$mysqli = new mysqli("db", "root", "root", "cv_db");

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Variables pour garder les valeurs du formulaire
$profession = $age = $sex = $address = $phone = $bio = $skills = '';
$profile_picture = '';

// Récupérer les informations du profil si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    $sql = "SELECT profession, age, sex, address, phone, bio, skills, profile_picture FROM user_profiles WHERE user_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($profession, $age, $sex, $address, $phone, $bio, $skills, $profile_picture);
    $stmt->fetch();
    $stmt->close();
}

// Vérifier si le formulaire a été soumis pour enregistrer les informations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profession = trim($_POST['profession']);
    $age = (int)$_POST['age'];
    $sex = $_POST['sex'];
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $bio = trim($_POST['bio']);
    $skills = trim($_POST['skills']);

    // Vérifiez si un fichier a été téléchargé
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $profile_picture = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($_FILES['profileImage']['tmp_name']));
    } else {
        // Si aucun fichier n'est téléchargé, garder l'ancienne image
        $profile_picture = $profile_picture; 
    }

    // Vérifier si l'utilisateur a déjà un profil
    $sql = "SELECT COUNT(*) FROM user_profiles WHERE user_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Mettre à jour les informations
        $sql = "UPDATE user_profiles SET profession = ?, age = ?, sex = ?, address = ?, phone = ?, bio = ?, skills = ?, profile_picture = ? WHERE user_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssssssi", $profession, $age, $sex, $address, $phone, $bio, $skills, $profile_picture, $_SESSION['user_id']);
    } else {
        // Insérer les informations
        $sql = "INSERT INTO user_profiles (user_id, profession, age, sex, address, phone, bio, skills, profile_picture) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("issssssss", $_SESSION['user_id'], $profession, $age, $sex, $address, $phone, $bio, $skills, $profile_picture);
    }

    // Exécuter la requête et vérifier si cela réussit
    if ($stmt->execute()) {
    } else {
        echo "Erreur: " . $stmt->error; 
    }
    $stmt->close();
}

// Fermer la connexion
$mysqli->close();
?>
