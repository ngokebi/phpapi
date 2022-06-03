<?php

class Auth
{
public $user_gateway; 

    public function __construct(UserGateway $gateway)
    {
        $this->user_gateway = $gateway;
    }


    public function authenticateAPIkey(): bool
    {
        // check if header has a key, from the server super global,, break if it doesnt 
        if (empty($_SERVER["HTTP_X_API_KEY"])) {
            http_response_code(400);
            echo json_encode(["message" => "Missing API key"]);
            return false;
        }

        // pass key to a variable 
        $api_key = $_SERVER["HTTP_X_API_KEY"];

        // if user doesnt have a valid key, break
        if ($this->user_gateway->getByAPI($api_key) === false) {
            http_response_code(401);
            echo json_encode(["message" => "API key is Invalid"]);
            exit;
        }
        return true;
    }
}
