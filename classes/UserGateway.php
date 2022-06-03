<?php

class UserGateway
{
    private  $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getByAPI(string $key)
    {
        $sql = "SELECT * FROM users WHERE api_key = :api_key";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":api_key", $key, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
