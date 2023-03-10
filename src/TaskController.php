<?php

    class TaskController{

        public function __construct(private TaskGateway $gateway){
            
        }

        public function processRequest(string $method, ?string $id): void{

            if($id === null){

                if($method == "GET"){

                    echo json_encode($this->gateway->getAll());

                }elseif($method == "POST"){

                    echo 'create';

                }else{

                    //METODOS PERMITIDOS -> EX. SE DER UM DELETE SEM ID
                    // http_response_code(405);
                    // header("Allow: GET, POST");
                    $this->respondMetdodNotAllowed("GET, POST");
                }
            }else{

                // 404 NOT FOUND RESPONSE
                $task = $this->gateway->get($id);

                if($task === false){
                    $this->responseNotFound($id);
                    return;
                }
                

                switch($method){

                    case "GET":
                        echo json_encode($task);
                        break;

                    case "PATCH":
                        echo "update $id";
                        break;

                    case "DELETE":
                        echo "delete ";
                        break;

                    default:
                        $this->respondMetdodNotAllowed("GET, PATH, DELETE");
                }
            }
        }

        private function respondMetdodNotAllowed(string $allowed_methods): void{

            http_response_code(405);
            // header("Allow: GET, POST");
            header("Allow: $allowed_methods");
        }

        private function responseNotFound(string $id): void{

            http_response_code(404);
            echo json_encode(["message" => "Task with ID $id not found"]);

        }
    }
?>