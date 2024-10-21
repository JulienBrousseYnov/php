<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Register</title>
</head>
<body>
<div class="register">
    <h1>Register</h1>
    <form action="authenticate.php" method="post">
        <label for="username">Username:</label> 
        <input id="username" name="username" required="" type="text" />
        <label for="email">Email:</label>
        <input id="email" name="email" required="" type="email" />
        <label for="password">Password:</label>
        <input id="password" name="password" required="" type="password" />
        <input name="register" type="submit" value="Register" />
    </form>
</div>
</body>
</html>
