<?php
// Le avisa al navegador que la respuesta es JSON y no una página web
header("Content-Type: application/json");

// Carga la conexión a la base de datos y el modelo Producto
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';

// Crea el objeto Database y abre la conexión con MySQL
$database = new Database();
$db = $database->conectar();

// Crea un Producto pasándole la conexión abierta
$producto = new Producto($db);

// Guarda el método de la petición: GET, POST, PUT o DELETE
$metodo = $_SERVER['REQUEST_METHOD'];

// Según el método, ejecuta un bloque distinto
switch($metodo){
    case "GET":
        // Pide todos los productos al modelo
        $stmt = $producto->listar();

        // Convierte los resultados en una lista (arreglo) de PHP
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convierte la lista a texto JSON y la muestra
        echo json_encode($productos);
    break; // Termina este caso para no seguir al siguiente


     case "POST":
        // Lee el cuerpo de la petición (el JSON que envía el cliente) y lo convierte en objeto PHP
        $datos = json_decode(file_get_contents("php://input"));

        // Pasa cada dato recibido a las propiedades del modelo
        $producto->nombre = $datos->nombre;
        $producto->descripcion = $datos->descripcion;
        $producto->precio = $datos->precio;
        $producto->stock = $datos->stock;

 
        // Si el modelo logra insertar el producto, responde con un mensaje en JSON
        if($producto->crear()){
            echo json_encode([
                "mensaje" => "Producto creado"
            ]);
        }
    break; // Termina el caso POST



        case "PUT":
        // Lee el JSON que envía el cliente y lo convierte en objeto PHP
        $datos = json_decode(file_get_contents("php://input"));

        // Esta vez también se recibe el id, para saber QUÉ producto modificar
        $producto->id = $datos->id;
        $producto->nombre = $datos->nombre;
        $producto->descripcion = $datos->descripcion;
        $producto->precio = $datos->precio;
        $producto->stock = $datos->stock;

        // Si el modelo logra actualizar, responde con un mensaje en JSON
        if($producto->actualizarAPI()){
            echo json_encode([
                "mensaje" => "Producto actualizado"
            ]);
        }
    break; // Termina el caso PUT 


        case "DELETE":
        // Lee el JSON que envía el cliente y lo convierte en objeto PHP
        $datos = json_decode(file_get_contents("php://input"));

        // Solo se necesita el id: indica cuál producto eliminar
        $producto->id = $datos->id;

        // Si el modelo logra eliminar, responde con un mensaje en JSON
        if($producto->eliminarAPI()){
            echo json_encode([
                "mensaje" => "Producto eliminado"
            ]);
        }
    break; // Termina el caso DELETE

}
?>