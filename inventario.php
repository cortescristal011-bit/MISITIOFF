<?php
require_once 'datosproductos.php';

try {
    $conexion = new Conexion();
    $consulta = $conexion->query('SELECT * FROM inventario ORDER BY codigo DESC');
    $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $conexion = null;
} catch (Exception $e) {
    $productos = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="w3-card-4 w3-white w3-round-large p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Inventario</h2>
            <div>
                <a href="frmproducto.php" class="btn btn-primary mr-2">Nuevo producto</a>
                <a href="frmcliente.php" class="btn btn-secondary">Volver</a>
            </div>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'guardado') { ?>
            <div class="alert alert-success">Producto guardado correctamente.</div>
        <?php } elseif (isset($_GET['msg']) && $_GET['msg'] === 'actualizado') { ?>
            <div class="alert alert-info">Producto actualizado correctamente.</div>
        <?php } elseif (isset($_GET['msg']) && $_GET['msg'] === 'error') { ?>
            <div class="alert alert-danger">No se pudo guardar el producto.</div>
        <?php } ?>

        <?php if (count($productos) > 0) { ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Costo</th>
                            <th>% Venta</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['codigo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($producto['nom_producto'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($producto['costo'] ?? '0', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($producto['porc_venta'] ?? '0', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($producto['precio_venta'] ?? '0', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($producto['stock'] ?? '0', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($producto['Fecha'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <a href="frmproducto.php?editar=<?php echo (int) ($producto['codigo'] ?? 0); ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="alert alert-info">No hay productos registrados en el inventario.</div>
        <?php } ?>
    </div>
</div>
</body>
</html>
