<?php
// Carga la librería PhpSpreadsheet que instaló Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Carga la conexión a la base de datos y el modelo Producto
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Producto.php';

// Importa las dos clases de la librería que vamos a usar
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class ReporteController
{
    public function reporteExcel()
    {
        // Abre la conexión a la base de datos
        $database = new Database();
        $db = $database->conectar();

        // Crea el modelo y pide todos los productos
        $producto = new Producto($db);
        $datos = $producto->obtenerTodos();

        // Crea un libro de Excel nuevo y toma su hoja activa
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Escribe los títulos de las columnas en la fila 1
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Descripción');
        $sheet->setCellValue('D1', 'Precio');
        $sheet->setCellValue('E1', 'Stock');


            // Pone en negrita los títulos de las columnas (celdas A1 a E1)
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        // Rellena el fondo de esos títulos con un color sólido
        $sheet->getStyle('A1:E1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('4F81BD'); // Código del color azul


        // Los productos empiezan en la fila 2
        $fila = 2;

        // Recorre cada producto y lo escribe en su fila
        foreach ($datos as $row) {
            $sheet->setCellValue('A' . $fila, $row['id']);
            $sheet->setCellValue('B' . $fila, $row['nombre']);
            $sheet->setCellValue('C' . $fila, $row['descripcion']);
            $sheet->setCellValue('D' . $fila, $row['precio']);
            $sheet->setCellValue('E' . $fila, $row['stock']);
            $fila++; // Pasa a la siguiente fila
        }


                // Recorre las columnas de la A a la E
        foreach (range('A', 'E') as $columna) {
            // Ajusta el ancho de cada columna al texto más largo que tenga
            $sheet->getColumnDimension($columna)->setAutoSize(true);
        }

        // Prepara el escritor que convierte el libro a formato .xlsx
        $writer = new Xlsx($spreadsheet);

        // Le avisa al navegador que la respuesta es un archivo de Excel para descargar
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ReporteProductos.xlsx"');

        // Envía el archivo directamente al navegador
        $writer->save('php://output');
    }




        public function reportePDF()
    {
        // Abre la conexión a la base de datos
        $database = new Database();
        $db = $database->conectar();

        // Crea el modelo y pide todos los productos
        $producto = new Producto($db);
        $productos = $producto->obtenerTodos();

        // Empieza a "capturar" lo que se imprimiría, sin mostrarlo todavía
        ob_start();

        // Carga la vista; usa la variable $productos para armar la tabla
        include __DIR__ . '/../views/reportes/productos_pdf.php';

        // Guarda en $html todo lo capturado y limpia la captura
        $html = ob_get_clean();

        // Crea el objeto que convierte HTML en PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Tamaño de hoja A4, en vertical
        $dompdf->setPaper('A4', 'portrait');

        // Genera el PDF
        $dompdf->render();

        // Lo muestra en el navegador (Attachment false = abrir, no descargar)
        $dompdf->stream("ReporteProductos.pdf", ["Attachment" => false]);
    }
}