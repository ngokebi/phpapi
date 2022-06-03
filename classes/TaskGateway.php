<?php

class TaskGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function all_Task(): array
    {
        $sql = "SELECT * FROM task ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        // convert the 1 to true for the is_completed column for all the record
        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row["is_completed"] = (bool) $row["is_completed"];

            $data[] = $row;
        }
        return $data;
    }

    public function one_Task(string $id)
    {
        $sql = "SELECT * FROM task WHERE id =:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        // convert the 1 to true for the is_completed column for one record
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data !== false) {
            $data["is_completed"] = (bool) $data["is_completed"];
        }
        return $data;
    }

    public function create_Task(array $data): string
    {
        $sql = "INSERT INTO task (name, priority, is_completed) VALUES (:name, :priority, :is_completed)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        if (empty($data["priority"])) {
            $stmt->bindValue(':priority', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':priority', $data["priority"], PDO::PARAM_INT);
        }
        $stmt->bindValue(':is_completed', $data["is_completed"] ?? false, PDO::PARAM_BOOL);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function update_Task(string $id, array $data): int
    {
        $fields = [];
        if (!empty($data["name"])) {
            $fields["name"] = [$data["name"], PDO::PARAM_STR];
        }
        if (array_key_exists("priority", $data)) {
            $fields["priority"] = [$data["priority"], $data["priority"] === null ? PDO::PARAM_NULL : PDO::PARAM_INT];
        }
        if (array_key_exists("is_completed", $data)) {
            $fields["is_completed"] = [$data["is_completed"], PDO::PARAM_BOOL];
        }

        if (empty($fields)) {
            return 0;
        } else {

            $sets = array_map(function ($value) {
                return "$value = :$value";
            }, array_keys($fields));

            $sql = "UPDATE task" . " SET " . implode(", ", $sets) . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            foreach ($fields as $name => $value) {
                $stmt->bindValue(":$name", $value[0], $value[1]);
            }
            $stmt->execute();

            return $stmt->rowCount();
        }
    }

    public function delete_Task(string $id): int
    {
        $sql = "DELETE FROM task WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}