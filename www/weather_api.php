<?php

$request = curl_init();

$response_header = [];

$header_callback = function($request, $header) use (&$response_header) {
    $len = strlen($header);

    $response_header[] = $header;

    return $len;
};

curl_setopt_array($request, [
    CURLOPT_URL => "https://api.openweathermap.org/data/2.5/weather?q=London&appid=dcd6adadcf8ee1256ec8045e5938e452",
    CURLOPT_RETURNTRANSFER => true, // return as a string 
    // CURLOPT_HEADER => true, // show all headers
    CURLOPT_HEADERFUNCTION => $header_callback 
]);

$response = curl_exec($request);

curl_close($request);

echo $response, "\n";