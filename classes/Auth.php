<?php

class Auth extends JwtHandler
{
    public $user_gateway;
    private $user_id;
    protected $headers;

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


        $user = $this->user_gateway->getByAPI($api_key);

        // if user doesnt have a valid key, break
        if ($user === false) {
            http_response_code(401);
            echo json_encode(["message" => "API key is Invalid"]);
            return false;
        }
        $this->user_id = $user["id"];
        return true;
    }

    public function getUserID()
    {
        return $this->user_id;
    }

    public function authenticateAccessToken()
    {
        if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            http_response_code(400);
            echo json_encode(["message" => "incomplete authroziation header"]);
            return false;
        }
        // base 64 access token
        // $result = base64_decode($matches[1], true);

        //JWT token
        $result = json_decode($this->jwtDecodeData($matches[1]), true);

        if ($result === false) {
            http_response_code(400);
            echo json_encode(["message" => "invalid authorization header"]);
            return false;
        }

        $this->user_id = $result["sub"];


        return true;
    }
}
