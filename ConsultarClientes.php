<?php
require_once 'manipularcli.php';

class ConsultarClientes
{
    private $clientes = [];
    private $clienteSeleccionado = null;
    private $mensaje = '';

    public function __construct()
    {
        $this->cargarClientes();
    }

    private function cargarClientes()
    {
        try {
            $this->clientes = modificarcliente::listar();
        } catch (Exception $e) {
            $this->clientes = [];
            $this->mensaje = 'No se pudieron cargar los clientes.';
        }
    }

    public function buscarPorId($id)
    {
        if ($id === null || $id === '') {
            return;
        }

        $codigo = (int) $id;

        try {
            $cliente = modificarcliente::obtenerPorId($codigo);

            if ($cliente !== false) {
                $this->clienteSeleccionado = $cliente;
                $this->mensaje = 'Cliente encontrado correctamente.';
            } else {
                $this->clienteSeleccionado = null;
                $this->mensaje = 'No existe un cliente con ese código.';
            }
        } catch (Exception $e) {
            $this->clienteSeleccionado = null;
            $this->mensaje = 'Ocurrió un error al consultar el cliente.';
        }
    }

    public function getClientes()
    {
        return $this->clientes;
    }

    public function getClienteSeleccionado()
    {
        return $this->clienteSeleccionado;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public static function limpiarDato($dato)
    {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        return htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
    }
}

$consultar = new ConsultarClientes();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idcli'])) {
    $consultar->buscarPorId($_POST['idcli']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 50%, #fdf2f8 100%);
        }

        .panel-principal {
            max-width: 1100px;
            margin: 30px auto;
        }

        .encabezado {
            background: linear-gradient(90deg, #0d6efd 0%, #6f42c1 50%, #d63384 100%);
            color: white;
        }

        .form-control:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.15);
        }

        .tarjeta-datos {
            border-left: 5px solid #d63384;
            background: #fcf7ff;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="w3-card-4 w3-white w3-round-large panel-principal">
        <header class="encabezado w3-container w3-padding-24 w3-round-top">
            <h2 class="w3-margin-0"><i class="fas fa-users"></i> Consultar clientes</h2>
            <p class="mb-0 mt-2">Búsqueda por código con programación orientada a objetos, Bootstrap y W3.CSS.</p>
        </header>

        <div class="w3-container w3-padding-24">
            <?php if (!empty($consultar->getMensaje())) { ?>
                <div class="alert alert-info rounded-pill text-center">
                    <i class="fas fa-info-circle"></i> <?php echo ConsultarClientes::limpiarDato($consultar->getMensaje()); ?>
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

            <?php if ($consultar->getClienteSeleccionado() !== null) { ?>
                <div class="w3-panel w3-padding tarjeta-datos w3-round-large">
                    <h5 class="font-weight-bold mb-3"><i class="fas fa-id-card"></i> Datos del cliente</h5>
                    <?php $cliente = $consultar->getClienteSeleccionado(); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Código</label>
                            <div><?php echo ConsultarClientes::limpiarDato($cliente['idcli']); ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Nombre</label>
                            <div><?php echo ConsultarClientes::limpiarDato($cliente['nomcli']); ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Dirección</label>
                            <div><?php echo ConsultarClientes::limpiarDato($cliente['direccion']); ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Teléfono residencial</label>
                            <div><?php echo ConsultarClientes::limpiarDato($cliente['telres_cli']); ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Teléfono celular</label>
                            <div><?php echo ConsultarClientes::limpiarDato($cliente['telcel_cli']); ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Email</label>
                            <div><?php echo ConsultarClientes::limpiarDato($cliente['email_cli']); ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="mt-4">
                <h5 class="font-weight-bold mb-3"><i class="fas fa-list"></i> Lista de clientes</h5>
                <div class="table-responsive">
                    <table class="table table-hover w3-table-all w3-striped w3-hoverable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($consultar->getClientes()) > 0) { ?>
                                <?php foreach ($consultar->getClientes() as $cliente) { ?>
                                    <tr>
                                        <td><?php echo ConsultarClientes::limpiarDato($cliente['idcli']); ?></td>
                                        <td><?php echo ConsultarClientes::limpiarDato($cliente['nomcli']); ?></td>
                                        <td><?php echo ConsultarClientes::limpiarDato($cliente['email_cli']); ?></td>
                                        <td>
                                            <form method="post" class="mb-0">
                                                <input type="hidden" name="idcli" value="<?php echo ConsultarClientes::limpiarDato($cliente['idcli']); ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Ver
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4">No hay clientes registrados.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
