<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <title>Login</title>
</head>
<body>
<div class="login">
    <h1>Login</h1>
    <form action="authenticate.php" method="post">
        <label for="email">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="e-mail" placeholder="e-mail" id="e-mail" required>
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="Password" id="password" required>
		<p>Pas encore de compte ? <a href="register.php"><button type="button" class="register-button">Register</button></a></p>
        <input type="hidden" name="login" value="1">
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
