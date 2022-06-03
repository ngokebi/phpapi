<?php

class Airtime
{

    function callAPI($method, $url, $data)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            // case "PUT":
            //     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            //     if ($data)
            //         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            //     break;
            default:
                // if ($data)
                //     $url = sprintf("%s?%s", $url, http_build_query($data));
                $this->respondMethodAllowed("POST");
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'hashKey: c1df88d180d0163fc53f4efde6288a2c87a2ceaaefae0685fd4a8c01b217e70d',
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        
        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        return $result;
    }

    private function respondMethodAllowed(string $allowed_methods): void
    {
        http_response_code(405);
        header("Allow: $allowed_methods");
    }
}
