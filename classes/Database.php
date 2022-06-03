<?php

require "config.php";

class Database
{
    private ?PDO $conn = null;
    private string $host = DB_HOST;
    private string $name = DB_NAME;
    private string $user = DB_USER;
    private string $password = DB_PASS;


    public function getConnection(): PDO
    {
        if ($this->conn === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8";

            $this->conn = new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false
            ]);
        }
        return $this->conn;
    }
}
