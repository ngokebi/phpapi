<?php

declare(strict_types=1);

require "bootstrap.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    header("Allow: POST");
    exit;
}

$input_data =  (array) json_decode(file_get_contents("php://input"), true);

if (!array_key_exists("email", $input_data) || !array_key_exists("password", $input_data)) {
    http_response_code(400);
    echo json_encode(["message" => "missing login credentials"]);
    exit;
}

$database = new Database();

$user_gateway = new UserGateway($database);

$user = $user_gateway->getByUsername($input_data["email"]);

if ($user === false) {
    http_response_code(401);
    echo json_encode(["message" => "Invalid credentials"]);
    exit;
}
if (!password_verify($input_data["password"], $user["password"])) {
    http_response_code(401);
    echo json_encode(["message" => "Invalid credentials"]);
    exit;
}


$payload = json_encode([
    "sub" => $user["id"],
    "email" => $user["email"]
]);

$jwt = new JwtHandler();
$domainName = 'http://localhost/phpapi/api';
$token = $jwt->jwtEncodeData($domainName, $payload);

// $access_token = base64_encode($payload);
echo json_encode(["access_token" => $token]);
