 <?php

$curl = curl_init();

$header = [
    // 'Authorization: token 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',
    'User-Agent: ngokebi'
];


curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://api.github.com/user/starred/ngokebi/NPCsite',
CURLOPT_URL => 'https://api.github.com/gists/aa954cd8f1ce2f7bc6a2b0970b489da5',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => $header,
));

$response = curl_exec($curl);

curl_close($curl);

$data = json_decode($response, true);

// foreach ($data as $gist) {
//     echo $gist['id'], " - ", $gist['description'], "\n";
// }

echo $response, "\n";
