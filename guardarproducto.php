<?php
require_once 'datosproductos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: frmproducto.php');
    exit;
}

$codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_INT);
$nombre = trim($_POST['nombre'] ?? '');
$costo = filter_input(INPUT_POST, 'costo', FILTER_VALIDATE_FLOAT);
$porcentaje = filter_input(INPUT_POST, 'porcentaje', FILTER_VALIDATE_FLOAT);
$precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
$imagen = trim($_POST['imagen'] ?? '');
$stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
$fecha = $_POST['fecha'] ?? '';

if ($nombre === '' || $costo === false || $porcentaje === false || $precio === false || $stock === false || $stock < 0 || $fecha === '') {
    header('Location: frmproducto.php?msg=datos_invalidos');
    exit;
}

try {
    $producto = new datosProductos();
    $producto->set_nom_producto($nombre);
    $producto->set_costoproducto($costo);
    $producto->set_porc_ventapro($porcentaje);
    $producto->set_precio_ventapro($precio);
    $producto->set_imagenpro($imagen);
    $producto->set_stockpro($stock);
    $producto->set_fechapro($fecha);

    if ($codigo !== false && $codigo !== null) {
        $producto->set_codproducto($codigo);
        $producto->actualizarProducto();
        header('Location: inventario.php?msg=actualizado');
    } else {
        $producto->guardarproducto();
        header('Location: inventario.php?msg=guardado');
    }
} catch (Exception $e) {
    header('Location: frmproducto.php?msg=error');
}
exit;
?>
