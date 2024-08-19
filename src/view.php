<?php
use Ferre\Polls\Models\Poll;

if (isset($_GET["id"])) {
    $uuid = $_GET["id"];

    $poll = Poll::find($uuid);

    if (isset($_POST["option_id"])) {
        $optionId = $_POST["option_id"];

        $poll = $poll->vote($optionId);
    }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View poll</title>
    <link rel="stylesheet" href="src/resources/main.css">
</head>
<body>
    <?php require "src/navbar.php" ?>
    <div class="container">
        <?php if ($poll): ?>
            <h1> Encuesta sobre: "<?=$poll->getTitle();?>" </h1>
            <h2>Total votes: 
                <?php 
                    $total = $poll->getTotalVotes();
                    echo $total; 
                ?>
            </h2>
            <?php foreach ($poll->getOptions() as $option): ?>
                <?php 
                    $percentage = 0;
    
                    if($total !== 0) {
                        $percentage = number_format(($option["votes"] / $total) * 100,2);
                    }
                ?>
                <div class="vote-item">
                    <div class="bar" style="width:<?= $percentage . "%"?>">
                        <?=$percentage ?> %
                    </div>
                    <form action="?view=view&id=<?=$uuid;?>" method="POST">
                        <input type="hidden" name="option_id" value="<?=$option["id"];?>">
                        <input type="submit" value="Vote for <?=$option["title"];?>">
                    </form>
                </div>
           <?php endforeach;?>
        <?php else: ?>
            <h1>Poll not found</h1>
        <?php endif;?>
    </div>
</body>
</html>