<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); // Permite peticiones desde cualquier origen

// Incluir archivos necesarios
include_once 'config/Database.php';
include_once 'models/Client.php';
include_once 'controllers/ClientsController.php';

// Obtener la conexión a la base de datos
$database = new Database();
$db = $database->connection();

// Instanciar el modelo del cliente
$clientModel = new Client($db);

// Instanciar el controlador de clientes
$controller = new ClientsController($clientModel);

// Obtener el método de la petición (GET, POST, etc.)
$method = $_SERVER['REQUEST_METHOD'];

// Obtener el ID de la URL (si existe)
// Esto nos permite manejar /api/clients/1, /api/clients/2, etc.
$id = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}

// Procesar la petición
$controller->processRequest($method, $id);