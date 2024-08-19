<?php

use Ferre\Polls\Models\Poll;

$polls = Poll::getPolls();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="src/resources/main.css">
</head>
<body>
    <?php require "src/navbar.php";?>
<div class="container">
    <h1>Encuestas creadas</h1>
    <?php if (empty($polls)): ?>
        <h2>No hay encuestas creadas</h2>
    <?php else: ?>
        <?php foreach ($polls as $poll): ?>
            <div> <a href="?view=view&id=<?=$poll->getUUID();?>"> <?=$poll->getTitle();?> </a></div>
        <?php endforeach;?>
    <?php endif;?>
</div>
</body>
</html>