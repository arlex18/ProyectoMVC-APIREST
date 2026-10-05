<!-- Vista de listado de productos (Fase 6) -->
<table border="1">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Precio</th>
    <th>Stock</th>
</tr>
<?php while($row = $productos->fetch(PDO::FETCH_ASSOC)): ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['nombre']; ?></td>
    <td><?= $row['precio']; ?></td>
    <td><?= $row['stock']; ?></td>
</tr>
<?php endwhile; ?>
</table>

<!-- Botón que lleva a la descarga del reporte en Excel -->
<br>
<a href="../reportes/excel.php">Exportar Excel</a>

<!-- Botón que lleva a la generación del reporte en PDF -->
<br>
<a href="../reportes/pdf.php">Exportar PDF</a>