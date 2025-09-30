<?php
class ClientsController {
    private $clientModel;

    public function __construct($clientModel) {
        $this->clientModel = $clientModel;
    }
    
    public function processRequest($method, $id) {
        if ($method == "GET") {
            if ($id) {
                $this->getclient($id);
            } else {
                $this->getClients();
            }
        } else {
            http_response_code(405);
            echo json_encode(["message" => "Método no permitido"]);
        }
    }

    private function getClients() {
        $result = $this->clientModel->read();
        $num = $result->rowCount();

        if ($num > 0) {
            $clients_arr = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $client_item = [
                    "client_id" => $client_id,
                    "name" => $name,
                    "phone" => $phone,
                    "address" => $address,
                    "email" => $email
                ];
                array_push($clients_arr, $client_item);
            }
            http_response_code(200);
            echo json_encode($clients_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No se encontraron clientes."]);
        }
    }

    private function getClient($id) {
        $this->clientModel->client_id = $id;
        if ($this->clientModel->read_single()) {
            $client_item = [
                "client_id" => $this->clientModel->client_id,
                "name" => $this->clientModel->name,
                "phone" => $this->clientModel->phone,
                "address" => $this->clientModel->address,
                "email" => $this->clientModel->email
            ];
            http_response_code(200);
            echo json_encode($client_item);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Cliente no encontrado."]);
        }
    }
}