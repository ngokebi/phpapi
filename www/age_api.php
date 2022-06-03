<?php

if (!empty($_GET['name'])) {
    $response = file_get_contents("https://api.agify.io?name={$_GET['name']}");
    $data = json_decode($response, true);
    $age = $data['age'];
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example</title>
</head>

<body>

    <?php
    if (isset($age)) { ?>
        Age: <?= $age ?>
    <?php } ?>

    <form action="">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <button>Guess Age</button>
    </form>
</body>

</html>