<?php
require_once 'manipularcli.php';

$Clientes = new modificarcliente(null, '', '', '', '', '');
$cliente = null;
$mensaje = '';

function filtrofares($datos)
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos, ENT_QUOTES, 'UTF-8');
    return $datos;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['idcli'])) {
    $idCliente = (int) $_POST['idcli'];
    $cliente = modificarcliente::obtenerPorId($idCliente);

    if ($cliente !== false) {
        $Clientes->set_codigo($cliente['idcli']);
        $Clientes->set_nombre($cliente['nomcli']);
        $Clientes->set_direccion($cliente['direccion']);
        $Clientes->set_telresi($cliente['telres_cli']);
        $Clientes->set_telcel($cliente['telcel_cli']);
        $Clientes->set_email($cliente['email_cli']);
    } else {
        $mensaje = 'No se encontró ningún cliente con ese código.';
    }
}

if (isset($_GET['msg']) && $_GET['msg'] === 'actualizado') {
    $mensaje = 'Cliente actualizado correctamente.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar cliente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            background: linear-gradient(135deg, #eef4ff 0%, #fdf2f8 50%, #fef3c7 100%);
        }
        .panel-principal {
            max-width: 920px;
            margin: 0 auto;
            border: 1px solid #dbeafe;
        }
        .encabezado {
            background: linear-gradient(90deg, #2563eb 0%, #7c3aed 50%, #ec4899 100%);
            color: white;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        .btn-warning {
            background-color: #f59e0b;
            border-color: #f59e0b;
            color: white;
        }
        .btn-outline-secondary {
            color: #4b5563;
            border-color: #9ca3af;
        }
        .form-control:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.2);
        }
        .w3-panel {
            background: #f8fafc;
            border-left: 5px solid #7c3aed;
        }
        .alert-info {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #7dd3fc;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="w3-card-4 w3-white w3-round-large panel-principal">
        <header class="encabezado w3-container w3-padding-24 w3-round-top">
            <h2 class="w3-margin-0"><i class="fas fa-search"></i> Consultar y actualizar cliente</h2>
            <p class="mb-0 mt-2">Consulta por código y actualiza los datos con un diseño moderno.</p>
        </header>

        <div class="w3-container w3-padding-24">
            <?php if (!empty($mensaje)) { ?>
                <div class="alert alert-info rounded-pill text-center">
                    <i class="fas fa-info-circle"></i> <?php echo $mensaje; ?>
                </div>
            <?php } ?>

            <form method="post" class="mb-4">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-8">
                        <label for="idcli" class="font-weight-bold">Código del cliente</label>
                        <input type="number" class="form-control" id="idcli" name="idcli" placeholder="Ingrese el código" required>
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-primary btn-block w3-round-xlarge">
                            <i class="fas fa-search"></i> Consultar
                        </button>
                    </div>
                </div>
            </form>

            <?php if ($cliente !== null) { ?>
                <div class="w3-panel w3-light-grey w3-padding w3-round-large">
                    <form action="actualizarcli.php" method="post">
                        <input type="hidden" name="idcli" value="<?php echo htmlspecialchars($Clientes->get_codigo(), ENT_QUOTES, 'UTF-8'); ?>">

                        <div class="form-group">
                            <label for="cnomcliente" class="font-weight-bold">Nombre</label>
                            <input type="text" class="form-control" id="cnomcliente" name="cnomcliente" value="<?php echo htmlspecialchars($Clientes->get_nombre(), ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="cdireccion" class="font-weight-bold">Dirección</label>
                            <textarea class="form-control" id="cdireccion" name="cdireccion" rows="3"><?php echo htmlspecialchars($Clientes->get_direccion(), ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="ctelcasa" class="font-weight-bold">Teléfono residencial</label>
                                <input type="text" class="form-control" id="ctelcasa" name="ctelcasa" value="<?php echo htmlspecialchars($Clientes->get_telresi(), ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ccelular" class="font-weight-bold">Celular</label>
                                <input type="text" class="form-control" id="ccelular" name="ccelular" value="<?php echo htmlspecialchars($Clientes->get_telcel(), ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cemail" class="font-weight-bold">Email</label>
                            <input type="email" class="form-control" id="cemail" name="cemail" value="<?php echo htmlspecialchars($Clientes->get_demail(), ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button type="submit" class="btn btn-warning w3-round-xlarge">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                            <a href="frmcliente.php" class="btn btn-outline-secondary w3-round-xlarge">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>
