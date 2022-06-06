<?php
// require './vendor/autoload.php';

use Firebase\JWT\JWT;

class JwtHandler
{
    protected $jwt_secrect;
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
        $this->expire = $this->issuedAt + 120;

        // Set your secret or signature
        $this->jwt_secrect = "72357538782F4125442A472D4B6150645367566B597033733676397924422645";

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

        $this->jwt = JWT::encode($this->token, $this->jwt_secrect, 'HS256');
        return $this->jwt;
    }

    public function jwtDecodeData($jwt_token)
    {
        try {
            $decode = JWT::decode($jwt_token, $this->jwt_secrect, array('HS256'));
            return [
                "data" => $decode
            ];
        } catch (Exception $e) {
            return [
                "message" => $e->getMessage()
            ];
        }
    }
}