<?php

header("Content-Type: application/json; charset=UTF-8");

// we use an autoloader to load classes 
// create the composer.json file and input the commands in it then run composer dump-autoload on the terminal
// require "../classes/TaskController.php"; // not using this again

require "../vendor/autoload.php";

set_error_handler("ErrorHandler::handleError");

set_exception_handler("ErrorHandler::handleException"); // use this to get a more pre-defined error message