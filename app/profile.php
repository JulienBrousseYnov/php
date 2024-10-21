<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'informations.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <title>Profil de l'utilisateur</title>
</head>
<body>

    <div class="cvpage">
    </div>

    <!-- TITLE SECTION -->
    <div class="title">
        <h1>Your CV, <?php echo ucfirst(strtolower($_SESSION['username'])); ?>!</h1>
    </div>

    <!-- Formulaire pour saisir les informations de profil -->
    <div class="profile-picture">
     <img id="profileImg" src="<?php echo !empty($profile_picture) ? htmlspecialchars($profile_picture) : ''; ?>" alt="Profile Picture" style="display: <?php echo !empty($profile_picture) ? 'block' : 'none'; ?>;" />
    </div>


        <p><?php echo htmlspecialchars($profession); ?></p>


        <p><?php echo htmlspecialchars($age); ?></p>

        <p><?php echo ($sex); ?></p>

        <p> <?php echo htmlspecialchars($address); ?></p>

        <p> <?php echo htmlspecialchars($phone); ?></p>

        <p><?php echo htmlspecialchars($bio); ?></p>
        
        <p><?php echo htmlspecialchars($skills); ?></p>
    </div>
    <script>
function previewImage(event) {
    const img = document.getElementById('profileImg');
    img.src = URL.createObjectURL(event.target.files[0]);
}
</script>
</body>
</html>
