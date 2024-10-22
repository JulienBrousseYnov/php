<?php 

session_start();


include 'informations.php';

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, target-densitydpi=device-dpi"/>
    <link rel="stylesheet" href="css\style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <title>Acceuil</title>
</head>
<body>

    <div class="profile">
        <a href="profile.php">
        <img id="profileImg" src="<?php echo !empty($profile_picture) ? htmlspecialchars($profile_picture) : ''; ?>" alt="Profile Picture" style="display: <?php echo !empty($profile_picture) ? 'block' : 'none'; ?>;" />
        </a>
    </div>

    <!-- TITLE SECTION -->
    <div class="title">
        <h1>Bienvenue sur mon site CV</h1>
        <p>Un site internet CV est une plateforme personnelle en ligne où un individu présente ses compétences, expériences professionnelles, et réalisations sous forme de CV numérique. Vous y retrouvez mon CV ainsi que beaucoup d'autres</p>
    </div>


    <!-- BUTTON SECTION -->
<div class="cv">
    <a href="cv.php">
        <button> Je crée mon CV 🖋️ </button>
    </a>
</div> 



</body>
</html>
