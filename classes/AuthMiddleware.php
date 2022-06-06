<?php
require 'JwtHandler.php';

class AuthMiddleware extends JwtHandler
{
    protected PDO $conn;
    protected $headers;
    protected $token;

    public function __construct(Database $database, $headers)
    {
        parent::__construct();
        $this->conn = $database->getConnection();
        $this->headers = $headers;
    }

    public function isValid()
    {
        if (array_key_exists('Authorization', $this->headers) && preg_match('/Bearer\s(\S+)/', $this->headers['Authorization'], $matches)) {
            $data = $this->jwtDecodeData($matches[1]);
        }
    }
}
