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
</head>
<body>
    <h1>App de encuestas</h1>
    <?php if (empty($polls)): ?>
        <h2>No hay encuestas creadas</h2>
    <?php else: ?>
        <?php foreach ($polls as $poll): ?>
            <div> <a href="?view=view&id=<?=$poll->getUUID();?>"> <?=$poll->getTitle();?> </a></div>
        <?php endforeach;?>
    <?php endif;?>
</body>
</html>