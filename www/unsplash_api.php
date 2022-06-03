<?php

$resquest = curl_init();

$header = [
    "Authorization: Client-ID 3Qr8wKR5kDIY8rgH0Ov6PMDOq-PqfCNG6VXqrs1Vlm0",
];

curl_setopt_array($resquest, [
    CURLOPT_URL => "https://api.unsplash.com/photos/random",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $header
]);

$response = curl_exec($resquest);

curl_close($resquest);

echo $response, "\n";