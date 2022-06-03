<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    require "../phpapi/vendor/autoload.php";
    $database = new Database();
    $database = $database->getConnection();

    $sql = "INSERT INTO users (name, email, password, api_key) VALUES(:name, :email, :password, :api_key)";

    $stmt = $database->prepare($sql);

    $api_key = bin2hex(random_bytes(16));

    $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
    $stmt->bindValue(':email', $_POST["email"], PDO::PARAM_STR);
    $stmt->bindValue(':password', password_hash($_POST["password"], PASSWORD_DEFAULT), PDO::PARAM_STR);
    $stmt->bindValue(':api_key', $api_key, PDO::PARAM_STR);

    $stmt->execute();
    echo "You have been Registered. Your Api Key is ", $api_key;
    exit;
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
</head>

<body>
    <main class="container">
        <h1>Register</h1>
        <form action="" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" id=""><br>
            <label for="email">Email</label>
            <input type="email" name="email" id=""><br>
            <label for="password">Password</label>
            <input type="password" name="password" id=""><br>
            <button>Register</button>
        </form>
    </main>
</body>

</html>