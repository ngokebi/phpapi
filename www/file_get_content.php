<?php

// return content of a webpage
$response = file_get_contents("https://randomuser.me/api");

// true returns the data as an assoc. array 
$data = json_decode($response, true);

// var_dump($data);
echo $data['results'][0]['name']['first'], "\n";