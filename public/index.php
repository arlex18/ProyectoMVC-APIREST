<?php
/* Puerta de entrada del proyecto (Fase 6).
   Conecta a la base de datos, le pide los productos al controlador
   y carga la vista, que necesita la variable $productos para mostrar la tabla. */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ProductoController.php';

$database = new Database();
$db = $database->conectar();

$controlador = new ProductoController($db);
$productos = $controlador->index();

require_once __DIR__ . '/../views/productos/index.php';

// 1. Conectar a la base de datos
$database = new Database();
$db = $database->conectar();

// 2. Pedir la lista de productos al controlador
$controlador = new ProductoController($db);
$productos = $controlador->index();

// 3. Mostrar la vista (usa la variable $productos)
require_once __DIR__ . '/../views/productos/index.php';