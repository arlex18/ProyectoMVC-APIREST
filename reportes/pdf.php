<?php
// Carga el controlador de reportes (usa __DIR__ para que la ruta siempre funcione)
require_once __DIR__ . '/../controllers/ReporteController.php';

// Crea el controlador
$reporte = new ReporteController();

// Ejecuta el método que genera y muestra el PDF
$reporte->reportePDF();