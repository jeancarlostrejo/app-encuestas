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
        die();
    }
} else {
    header("Location: ?view=home");
    die();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Options</title>
    <link rel="stylesheet" href="src/resources/main.css">
</head>
<body>
    <?php require "src/navbar.php" ?>
    <form action="?view=options" method="POST" class="form">
        <h3>Options</h3>
        <input type="hidden" name="title" value="<?=$_POST["title"];?>">

        <input type="text" name="option[]" class="input">
        <input type="text" name="option[]" class="input">
        
        <div id="more-inputs">
        </div>

        <button id="bAdd">Add another option</button>
        <input type="submit" value="Create poll">
    </form>

    <script>
        const bAdd = document.querySelector("#bAdd");
        const container = document.querySelector("#more-inputs");

        bAdd.addEventListener("click", (e) => {
            e.preventDefault();

            const wrapper = document.createElement("div");
            wrapper.classList.add("wrapper");

            const deleteButton = document.createElement("button");
            deleteButton.append("Delete");
            deleteButton.addEventListener("click", e => {
                e.preventDefault();
                wrapper.remove();
            });

            const input = document.createElement("input");
            input.name = "option[]";
            input.type = "text";

            input.classList.add("input");
            input.placeholder = "Option";
            wrapper.appendChild(input);
            wrapper.appendChild(deleteButton);
            container.appendChild(wrapper);

        })
    </script>
</body>
</html>