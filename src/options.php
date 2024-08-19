<?php

use Ferre\Polls\Models\Poll;

if (isset($_POST["title"])) {
    if (isset($_POST["option"])) {
        $title = $_POST["title"];
        $options = $_POST["option"];

        $poll = new Poll($title, true);
        $poll->save();

        $poll->insertOptions($options);

        header("Location: ?view=home");

    }

} else {
    header("Location: ?view=home");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Options</title>
</head>
<body>
    <form action="?view=options" method="POST">
        <h3>Questions</h3>
        <input type="hidden" name="title" value="<?=$_POST["title"];?>">

        <input type="text" name="option[]" id="">
        <input type="text" name="option[]" id="">

        <div id="more-input">

        </div>

        <button id="bAdd">Add another option</button>
        <input type="submit" value="Create poll">
    </form>
</body>
</html>