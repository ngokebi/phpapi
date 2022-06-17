<?php


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandler
{
    protected $jwt_secret = "586E3272357538782F4125442A472D4B6150645367566B597033733676397924";
    protected $token;
    protected $issuedAt;
    protected $expire;
    protected $domainName;
    protected $jwt;

    public function __construct()
    {
        // set your default time-zone
        date_default_timezone_set('Africa/Lagos');
        $this->issuedAt = time();

        // Token Validity (3600 second = 1hr)
        $this->expire = $this->issuedAt + 1800;

        // Issuer
        $this->domainName = "http://localhost/phpapi/api/login.php";
    }

    public function jwtEncodeData($domainName, $payload)
    {

        $this->token = array(
            //Adding the identifier to the token (who issue the token)
            "iss" => $domainName,
            // Adding the current timestamp to the token, for identifying that when the token was issued.
            "iat" => $this->issuedAt,
            // Token expiration
            "exp" => $this->expire,
            // Payload
            "data" => $payload
        );

        $this->jwt = JWT::encode($this->token, $this->jwt_secret, 'HS256');
        return $this->jwt;
    }

    public function jwtDecodeData($jwt_token)
    {

        try {
            $decode = JWT::decode($jwt_token, new Key($this->jwt_secret, 'HS256'));
            $payload = json_encode($decode->data);
            return $payload;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode([
                "message" => $e->getMessage()
            ]);
            exit;
        }
    }
}
