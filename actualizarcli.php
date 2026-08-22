<?php
require_once 'manipularcli.php';

function filtrofares($datos)
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos, ENT_QUOTES, 'UTF-8');
    return $datos;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = !empty($_POST['idcli']) ? (int) $_POST['idcli'] : 0;
    $nombre = filtrofares($_POST['cnomcliente'] ?? '');
    $direccion = filtrofares($_POST['cdireccion'] ?? '');
    $telRes = filtrofares($_POST['ctelcasa'] ?? '');
    $telCel = filtrofares($_POST['ccelular'] ?? '');
    $email = filtrofares($_POST['cemail'] ?? '');

    if ($idCliente > 0) {
        $Clientes = new modificarcliente(null, '', '', '', '', '');
        modificarcliente::actualizar($idCliente, $nombre, $direccion, $telRes, $telCel, $email);
        header('Location: ConsultarCliente.php?msg=actualizado');
        exit;
    }
}

header('Location: ConsultarCliente.php?msg=error');
exit;
