<?php
class Database 
{
    private $host = "localhost";
    // CORRECCIÓN: Conectamos a la base de datos de la ferretería
    private $db_name = "ferreteria"; 
    private $username = "developer";
    private $password = "developer";
    public $conn;       

    public function connection(){
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}