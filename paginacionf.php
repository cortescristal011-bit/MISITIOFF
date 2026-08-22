<?php
class paginacionf
{
    private $conexion;
    private $tabla;
    private $registrosPorPagina;
    private $paginaActual;

    public function __construct($conexion, $tabla, $registrosPorPagina = 10, $paginaActual = 1)
    {
        $this->conexion = $conexion;
        $this->tabla = $tabla;
        $this->registrosPorPagina = max(1, (int) $registrosPorPagina);
        $this->paginaActual = max(1, (int) $paginaActual);
    }

    public function totalregistros()
    {
        $consulta = $this->conexion->prepare('SELECT COUNT(*) AS total FROM ' . $this->tabla);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        return (int) ($resultado['total'] ?? 0);
    }

    public function limitregistros()
    {
        $inicio = ($this->paginaActual - 1) * $this->registrosPorPagina;

        $consulta = $this->conexion->prepare(
            'SELECT * FROM ' . $this->tabla . ' ORDER BY idcli DESC LIMIT :inicio, :limite'
        );

        $consulta->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $consulta->bindValue(':limite', $this->registrosPorPagina, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalpaginas()
    {
        $total = $this->totalregistros();
        return (int) ceil($total / $this->registrosPorPagina);
    }

    public function paginaActual()
    {
        return $this->paginaActual;
    }
}
?>
