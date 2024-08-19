<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Poll</title>
    <link rel="stylesheet" href="src/resources/main.css">
</head>
<body>
    <?php require "src/navbar.php" ?>
    <form action="?view=options" method="POST" class="form">
        <h1>Create a Poll</h1>
        <input type="text" name="title" placeholder="Title of poll" required>
        <input type="submit" value="Next">
    </form>
</body>
</html>