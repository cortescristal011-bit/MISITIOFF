<?php
require_once 'datosproductos.php';

$productoEditar = null;
$modoEdicion = false;
$valores = [
    'codigo' => '',
    'nombre' => '',
    'costo' => '',
    'porcentaje' => '',
    'precio' => '',
    'imagen' => '',
    'stock' => '',
    'fecha' => date('Y-m-d')
];

if (isset($_GET['editar']) && ctype_digit($_GET['editar'])) {
    try {
        $productos = datosProductos::consultarProductoCod((int) $_GET['editar']);
        $productoEditar = $productos[0] ?? null;
        $modoEdicion = $productoEditar !== null;
    } catch (Exception $e) {
        $productoEditar = null;
    }
}

if ($modoEdicion) {
    $valores = [
        'codigo' => $productoEditar->codigo ?? '',
        'nombre' => $productoEditar->nom_producto ?? '',
        'costo' => $productoEditar->costo ?? '',
        'porcentaje' => $productoEditar->porc_venta ?? '',
        'precio' => $productoEditar->precio_venta ?? '',
        'imagen' => $productoEditar->Imagen ?? '',
        'stock' => $productoEditar->stock ?? '',
        'fecha' => $productoEditar->Fecha ?? date('Y-m-d')
    ];
}

function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $modoEdicion ? 'Editar producto' : 'Nuevo producto'; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="contenedor-principal">
        <header class="encabezado">
            <h1><?php echo $modoEdicion ? 'Editar producto' : 'Nuevo producto'; ?></h1>
        </header>

        <main class="contenido">
            <form action="guardarproducto.php" method="post" class="w3-white w3-card-4 w3-round-large w3-padding">
                <?php if ($modoEdicion) { ?>
                    <input type="hidden" name="codigo" value="<?php echo escapar($valores['codigo']); ?>">
                <?php } ?>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="nombre">Nombre del producto</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" maxlength="150" value="<?php echo escapar($valores['nombre']); ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" value="<?php echo escapar($valores['fecha']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="costo">Costo</label>
                        <input type="number" id="costo" name="costo" class="form-control" min="0" step="0.01" value="<?php echo escapar($valores['costo']); ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="porcentaje">Porcentaje de venta</label>
                        <input type="number" id="porcentaje" name="porcentaje" class="form-control" min="0" step="0.01" value="<?php echo escapar($valores['porcentaje']); ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="precio">Precio de venta</label>
                        <input type="number" id="precio" name="precio" class="form-control" min="0" step="0.01" value="<?php echo escapar($valores['precio']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="imagen">Imagen</label>
                        <input type="text" id="imagen" name="imagen" class="form-control" maxlength="255" placeholder="ejemplo.jpg" value="<?php echo escapar($valores['imagen']); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="stock">Stock inicial</label>
                        <input type="number" id="stock" name="stock" class="form-control" min="0" step="1" value="<?php echo escapar($valores['stock']); ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-fares">
                    <?php echo $modoEdicion ? 'Actualizar producto' : 'Guardar producto'; ?>
                </button>
                <a href="inventario.php" class="btn btn-outline-secondary ml-2">Cancelar</a>
            </form>
        </main>
    </div>
</div>
</body>
</html>
