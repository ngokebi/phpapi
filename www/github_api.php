<?php

$curl = curl_init();

$header = [
    'Authorization: token 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',
    'User-Agent: ngokebi'
];

$payload = json_encode([
    "name" => "phpApi",
    "description" => "Learn all about API Integration using both Laravel and Core Php",
    "private" => false
]);

curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://api.github.com/user/starred/ngokebi/NPCsite',
CURLOPT_URL => 'https://api.github.com/user/repos',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => $header,
  CURLOPT_POSTFIELDS => $payload
));

$response = curl_exec($curl);

$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

echo $response, "\n";
echo $status_code, "\n";