<?php

require_once 'manipularcli.php';

$vcodigo = "";
$vnombre = "";
$vdireccion = "";
$vtelresi = "";
$vtelcel = "";
$vemail = "";
$vidcliente = null;

function filtrofares($dat_fares)
{
    $datos = trim($dat_fares);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST["idcli"])) {
        $vidcliente = (int) $_POST["idcli"];
    }

    if (!empty($_POST["ccodigo"])) {
        $vcodigo = filtrofares($_POST["ccodigo"]);
    }

    if (!empty($_POST["cnomcliente"])) {
        $vnombre = filtrofares($_POST["cnomcliente"]);
    }

    if (!empty($_POST["cdireccion"])) {
        $vdireccion = filtrofares($_POST["cdireccion"]);
    }

    if (!empty($_POST["ctelcasa"])) {
        $vtelresi = filtrofares($_POST["ctelcasa"]);
    }

    if (!empty($_POST["ccelular"])) {
        $vtelcel = filtrofares($_POST["ccelular"]);
    }

    if (!empty($_POST["cemail"])) {
        $vemail = filtrofares($_POST["cemail"]);
    }

    if (isset($_POST["actualizar"]) && $vidcliente !== null) {
        modificarcliente::actualizar($vidcliente, $vnombre, $vdireccion, $vtelresi, $vtelcel, $vemail);
        header('Location: frmcliente.php?msg=actualizado');
        die();
    }

    $guardarcliente = new modificarcliente(
        null,
        $vnombre,
        $vdireccion,
        $vtelresi,
        $vtelcel,
        $vemail
    );

    $guardarcliente->guardar();

    header('Location: frmcliente.php?msg=guardado');
    die();
}

header('Location: frmcliente.php');
die();
?>
