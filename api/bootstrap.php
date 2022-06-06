<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// we use an autoloader to load classes 
// create the composer.json file and input the commands in it then run composer dump-autoload on the terminal
// require "../classes/TaskController.php"; // not using this again

require "../vendor/autoload.php";

set_error_handler("ErrorHandler::handleError");

set_exception_handler("ErrorHandler::handleException"); // use this to get a more pre-defined error message