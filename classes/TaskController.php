<?php

class TaskController
{

    private $taskgateway;


    public function __construct(TaskGateway $gateway,  int $user_id)
    {
        $this->taskgateway = $gateway;
        $this->user_id = $user_id;;

    }
    public function processRequest(string $method, ?string $id): void // ? in ?string prefix $id to be nullable if its empty
    {
        // if the id is null 
        if ($id === null) {

            if ($method == "GET") {
                echo json_encode($this->taskgateway->all_Task_User($this->user_id));
            } elseif ($method == "POST") {
                //php://input allows you to read raw data from the request body.
                $input_data =  (array) json_decode(file_get_contents("php://input"), true);

                // check validation
                $errors = $this->check_Validation($input_data);

                if (!empty($errors)) {
                    $this->respondUnprocessableEntity($errors);
                    return;
                } 
                    // add to dataabse if no error
                    $create = $this->taskgateway->create_Task_User($this->user_id, $input_data);
                    $this->respondCreated($create);
                
            } else {
                $this->respondMethodAllowed("GET, POST");
            }
            // if there is an id 
        } else {

            // check the id being passed, if not found
            $task = $this->taskgateway->one_Task_User($this->user_id, $id);
            if ($task === false) {
                $this->respondNotFound($id);
                exit;
            } else {

                // if found...
                switch ($method) {

                    case 'GET':
                        echo json_encode($task);
                        break;

                    case 'PATCH':

                        $input_data =  (array) json_decode(file_get_contents("php://input"), true);

                        // check validation
                        $errors = $this->check_Validation($input_data, false);
        
                        if (!empty($errors)) {
                            $this->respondUnprocessableEntity($errors);
                            return;
                        } 
                        $this->taskgateway->update_Task_User($this->user_id, $id, $input_data);
                        echo json_encode(["message" => "Task with id $id has been Updated"]);
                        break;

                    case 'DELETE':
                        $this->taskgateway->delete_Task_User($this->user_id, $id);
                        echo json_encode(["message" => "Task with id $id has been Deleted"]);
                        break;

                    default:
                        $this->respondMethodAllowed("GET, PATCH, DELETE");
                }
            }
        }
    }
    private function respondMethodAllowed(string $allowed_methods): void
    {
        http_response_code(405);
        header("Allow: $allowed_methods");
    }

    private function respondNotFound(string $id): void
    {
        http_response_code(404);
        echo json_encode(["message" => "Task with id $id not Found"]);
    }

    private function respondCreated(string $id): void
    {
        http_response_code(201);
        echo json_encode(["message" => "Task with id $id was Created"]);
    }

    private function check_Validation(array $data, bool $is_new = true): array
    {
        $error = [];

        if ($is_new && empty(trim($data["name"]))) {
            $error[] = "name is required";
        }

        // confirm its an integer
        if (!empty($data["priority"])) {
            if (filter_var($data["priority"], FILTER_VALIDATE_INT) === false) {
                $error[] = "priority must be an integer";
            }
        }
        return $error;
    }

    private function respondUnprocessableEntity(array $errors): void
    {
        http_response_code(422);
        echo json_encode(["errors" => $errors]);
    }
}
