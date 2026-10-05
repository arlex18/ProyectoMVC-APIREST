<!-- Vista del reporte en PDF: tabla con todos los productos -->
<meta charset="UTF-8">
<h1>Reporte General de Productos</h1>
<table border="1" width="100%" cellspacing="0">
    <tr>
        <!-- Títulos de las columnas -->
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Stock</th>
    </tr>
    <?php
    // Recorre la lista de productos; $producto guarda el producto actual
    foreach($productos as $producto):
    ?>
    <tr>
        <!-- Imprime cada dato del producto actual -->
        <td><?= $producto['id']; ?></td>
        <td><?= $producto['nombre']; ?></td>
        <td><?= $producto['descripcion']; ?></td>
        <td><?= $producto['precio']; ?></td>
        <td><?= $producto['stock']; ?></td>
    </tr>
    <?php
    // Cierra el foreach: repite hasta que no queden más productos
    endforeach;
    ?>
</table>