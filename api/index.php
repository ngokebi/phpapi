<?php

declare(strict_types=1);

require "bootstrap.php";

$full_path =  parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $full_path);

$resource = $parts[3];

$id = $parts[4] ?? null; // if not set, then set to null 

if ($resource != "tasks") {
    http_response_code(404);
    exit;
}


$database = new Database();

$user_gateway = new UserGateway($database);

// how to check for the authorization header
// var_dump($_SERVER["HTTP_AUTHORIZATION"]);
// exit;

// add auth class that checks for api key
$auth = new Auth($user_gateway);

// validate using authetication key
// if (!$auth->authenticateAPIkey()) {
//     exit;
// }

// validate using authetication token
if (!$auth->authenticateAccessToken()) {
    exit;
}

// $user_id = $auth->getUserID();


// $gateway = new TaskGateway($database);

// $taskcontroller = new TaskController($gateway, $user_id);

// $taskcontroller->processRequest($_SERVER["REQUEST_METHOD"], $id);













// how to call an api with another api.. airtime class holds the function
$input_data =  (array) json_decode(file_get_contents("php://input"), true);
$buy_airtime = new Airtime();
$make_call = $buy_airtime->callAPI('POST', 'http://test.shagopayments.com/public/api/test/b2b', json_encode($input_data));
$response = json_decode($make_call, true);
// $errors   = $response['response']['errors'];
// $data     = $response['response']['data'][0];
print_r(json_encode($response));