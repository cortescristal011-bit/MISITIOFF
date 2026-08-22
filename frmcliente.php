<?php
require_once 'manipularcli.php';

$clientes = [];
$clienteEditar = null;
$modoEdicion = false;

try {
    $clientes = modificarcliente::listar();
} catch (Exception $e) {
    $clientes = [];
}

if (isset($_GET["editar"]) && is_numeric($_GET["editar"])) {
    try {
        $clienteEditar = modificarcliente::obtenerPorId((int) $_GET["editar"]);
        $modoEdicion = $clienteEditar !== false;
    } catch (Exception $e) {
        $clienteEditar = null;
        $modoEdicion = false;
    }
}

if (isset($_GET["eliminar"]) && is_numeric($_GET["eliminar"])) {
    try {
        modificarcliente::eliminar((int) $_GET["eliminar"]);
        header('Location: frmcliente.php?msg=eliminado');
        die();
    } catch (Exception $e) {
        header('Location: frmcliente.php?msg=error');
        die();
    }
}

$valores = [
    'id' => '',
    'nombre' => '',
    'direccion' => '',
    'telres' => '',
    'telcel' => '',
    'email' => ''
];

if ($modoEdicion && $clienteEditar) {
    $valores = [
        'id' => $clienteEditar['idcli'] ?? '',
        'nombre' => $clienteEditar['nomcli'] ?? '',
        'direccion' => $clienteEditar['direccion'] ?? '',
        'telres' => $clienteEditar['telres_cli'] ?? '',
        'telcel' => $clienteEditar['telcel_cli'] ?? '',
        'email' => $clienteEditar['email_cli'] ?? ''
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ediciones Fares</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<div class="container py-4 w3-container">
    <div class="contenedor-principal w3-card-4 w3-round-large">

        <header class="encabezado w3-container">
            <h1 class="display-4">Ediciones Fares</h1>
        </header>

        <nav class="menu w3-bar w3-dark-grey w3-round-large w3-container">
            <a href="frmcliente.php" class="w3-bar-item w3-button w3-white w3-round-large">Principal</a>
            <a href="#" class="w3-bar-item w3-button">Libros</a>
            <a href="inventario.php" class="w3-bar-item w3-button">Inventario</a>
            <a href="#" class="w3-bar-item w3-button">Contacto</a>
        </nav>

        <main class="contenido w3-container w3-padding-16">

            <?php if (isset($_GET["msg"]) && $_GET["msg"] == "guardado") { ?>
                <div class="alert alert-success mensaje shadow-sm">
                    Cliente guardado correctamente.
                </div>
            <?php } ?>

            <?php if (isset($_GET["msg"]) && $_GET["msg"] == "actualizado") { ?>
                <div class="alert alert-info mensaje shadow-sm">
                    Cliente actualizado correctamente.
                </div>
            <?php } ?>

            <?php if (isset($_GET["msg"]) && $_GET["msg"] == "eliminado") { ?>
                <div class="alert alert-warning mensaje shadow-sm">
                    Cliente eliminado correctamente.
                </div>
            <?php } ?>

            <?php if (isset($_GET["msg"]) && $_GET["msg"] == "error") { ?>
                <div class="alert alert-danger mensaje shadow-sm">
                    Ocurrió un error en la operación.
                </div>
            <?php } ?>

            <div class="w3-row-padding">
                <div class="w3-col l5 m12 s12 mb-4">
                    <div class="w3-card-4 w3-white w3-round-large w3-padding">
                        <form class="formulario-cliente" action="guardarcli.php" method="post">

                            <div class="titulo-formulario">
                                <?php echo $modoEdicion ? 'Editar datos del cliente' : 'Ingresar datos del cliente'; ?>
                            </div>

                            <?php if ($modoEdicion) { ?>
                                <input type="hidden" name="idcli" value="<?php echo htmlspecialchars($valores['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php } ?>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="ccodigo">Código</label>
                                    <input type="text" id="ccodigo" name="ccodigo" class="form-control" placeholder="Ingresar código" value="<?php echo htmlspecialchars($valores['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="cnomcliente">Nombre</label>
                                    <input type="text" id="cnomcliente" name="cnomcliente" class="form-control" placeholder="Ingresar nombre del cliente" value="<?php echo htmlspecialchars($valores['nombre'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cdireccion">Dirección</label>
                                <textarea id="cdireccion" name="cdireccion" class="form-control" rows="3" placeholder="Ingresar dirección"><?php echo htmlspecialchars($valores['direccion'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="ctelcasa">Teléfono residencial</label>
                                    <input type="text" id="ctelcasa" name="ctelcasa" class="form-control" placeholder="Ingresar teléfono residencial" value="<?php echo htmlspecialchars($valores['telres'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="ccelular">Celular</label>
                                    <input type="text" id="ccelular" name="ccelular" class="form-control" placeholder="Ingresar celular" value="<?php echo htmlspecialchars($valores['telcel'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cemail">Email</label>
                                <input type="email" id="cemail" name="cemail" class="form-control" placeholder="Ingresar correo electrónico" value="<?php echo htmlspecialchars($valores['email'], ENT_QUOTES, 'UTF-8'); ?>">
                            </div>

                            <div class="d-flex align-items-center flex-wrap">
                                <?php if ($modoEdicion) { ?>
                                    <button type="submit" name="actualizar" class="btn btn-warning mr-2">
                                        Actualizar
                                    </button>
                                    <a href="frmcliente.php" class="btn btn-outline-secondary">Cancelar</a>
                                <?php } else { ?>
                                    <button type="submit" name="guardar" class="btn btn-fares">
                                        Guardar
                                    </button>
                                <?php } ?>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="w3-col l7 m12 s12 mb-4">
                    <div class="w3-card-4 w3-white w3-round-large w3-padding">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Clientes registrados</h5>
                            <a href="Clientespaginados.php" class="btn btn-sm btn-primary">
                                <i class="fas fa-list"></i> Ver paginados
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 tabla-clientes w3-table-all w3-striped w3-hoverable">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($clientes) > 0) { ?>
                                        <?php foreach ($clientes as $cliente) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($cliente["idcli"], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($cliente["nomcli"], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-nowrap">
                                                    <a href="frmcliente.php?editar=<?php echo htmlspecialchars($cliente["idcli"], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-outline-primary btn-icon mr-1" title="Editar cliente">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="frmcliente.php?eliminar=<?php echo htmlspecialchars($cliente["idcli"], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-outline-danger btn-icon" title="Eliminar cliente" onclick="return confirm('Eliminar cliente?');">
                                                        <i class="fas fa-user-times"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="3" class="text-center py-4">No hay clientes registrados.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <footer class="pie">
            Todos los derechos reservados Ediciones Fares 2024.
        </footer>

    </div>
</div>

</body>
</html>
