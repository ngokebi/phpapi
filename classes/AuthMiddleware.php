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

            if (
                isset($data['data']->user_id) &&
                $user = $this->fetchUser($data['data']->user_id)
            ) :
                return [
                    "success" => 1,
                    "user" => $user
                ];
            else :
                return [
                    "success" => 0,
                    "message" => $data['message'],
                ];
            endif;
        } else {
            return [
                "success" => 0,
                "message" => "Token not found in request"
            ];
        }
    }

    protected function fetchUser($user_id)
    {
        try {
            $sql = "SELECT name, email FROM users WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount()) :
                return $stmt->fetch(PDO::FETCH_ASSOC);
            else :
                return false;
            endif;
        } catch (PDOException $e) {
            return null;
        }
    }
}       