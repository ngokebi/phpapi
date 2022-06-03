<?php

$resquest = curl_init();

// curl_setopt($resquest, CURLOPT_URL, "https://randomuser.me/api");
// curl_setopt($resquest, CURLOPT_RETURNTRANSFER, true);

curl_setopt_array($resquest, [
    CURLOPT_URL => "https://randomuser.me/api",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => true
]);

$response = curl_exec($resquest);

// to get the status code
$status_code = curl_getinfo($resquest, CURLINFO_HTTP_CODE);
// TO GET THE content type
$content_type = curl_getinfo($resquest, CURLINFO_CONTENT_TYPE);
// to get the content length
$content_length = curl_getinfo($resquest, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

curl_close($resquest);

echo $response, "\n";

echo $status_code, "\n";

echo $content_length, "\n";

echo $content_type, "\n";
