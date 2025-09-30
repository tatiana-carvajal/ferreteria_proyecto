<?php
class Client {
    private $conn;
    private $table_name = "client";

    public $client_id;
    public $name;
    public $phone;
    public $address;
    public $email;

    public function __construct($db){
        $this->conn = $db;      
    }

    // Leer todos los clientes
    public function read(){
        $query = "SELECT client_id, name, phone, address, email FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Leer un solo cliente por ID
    public function read_single(){
        $query = "SELECT client_id, name, phone, address, email FROM " . $this->table_name . " WHERE client_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->client_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            $this->name = $row['name'];
            $this->phone = $row['phone'];
            $this->address = $row['address'];
            $this->email = $row['email'];
            return true;
        }
        return false;
    }
}