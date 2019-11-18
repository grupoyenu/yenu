<?php

class Aulas {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($campo, $valor) {
        if ($campo) {
            $consulta = "SELECT aul.*, (CASE WHEN cla.clases IS NULL THEN 0 ELSE cla.clases END) clases,"
                    . "(CASE WHEN lla.llamados IS NULL THEN 0 ELSE lla.llamados END) llamados "
                    . "FROM aula aul LEFT JOIN (SELECT idaula, COUNT(idclase) clases "
                    . "FROM clase GROUP BY idaula) cla ON cla.idaula = aul.idaula "
                    . "LEFT JOIN (SELECT idaula, COUNT(idllamado) llamados "
                    . "FROM llamado GROUP BY idaula) lla ON lla.idaula = aul.idaula "
                    . "WHERE {$campo} LIKE '%{$valor}%'";
            $resultado = Conexion::getInstancia()->seleccionar($consulta);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $resultado;
        }
        $this->descripcion = "El campo es obligatorio";
        return 0;
    }

    public function listar() {
        $consulta = "SELECT * FROM aula";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarAulasDisponibles($dia, $desde, $hasta, $nombre) {
        $consulta = "SELECT * FROM aula WHERE nombre LIKE '%{$nombre}%' AND idaula NOT IN "
                . "(SELECT idaula FROM clase WHERE dia = {$dia} AND "
                . "((desde >= '{$desde}' AND desde < '{$hasta}') OR "
                . "(hasta > '{$desde}' AND hasta < '{$hasta}') OR "
                . "(desde < '{$desde}' AND hasta > '{$desde}') "
                . ")) OR "
                . "idaula IN (SELECT idaula FROM clase WHERE dia = {$dia} AND desde = '{$desde}' and hasta='{$hasta}')";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarHorariosClase($id) {
        $consulta = "SELECT DISTINCT idAsignatura, nombreAsignatura, idClase, "
                . "numeroDia, nombreDia, desde, hasta, idAula, fechaMod "
                . "FROM vista_aulascursadas WHERE idAula = {$id} ORDER BY numeroDia asc, desde";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarInformeCursada($disponible, $dia, $desde, $hasta) {
        $consulta = "SELECT * FROM aula WHERE idaula {$disponible} (SELECT idaula FROM clase WHERE ";
        $consulta .= ($dia != "NO") ? "dia = {$dia} AND" : "";
        $consulta .= "((desde >= '{$desde}' AND desde < '{$hasta}') OR (hasta > '{$desde}' AND hasta < '{$hasta}') "
                . "OR (desde < '{$desde}' AND hasta > '{$desde}'))) ORDER BY sector, nombre";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarInformeMesa($disponible, $fecha, $hora) {
        $consulta = "SELECT * FROM aula WHERE idaula {$disponible} (SELECT idaula "
                . "FROM llamado WHERE fecha = '{$fecha}' AND hora = '{$hora}') ORDER BY sector, nombre";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarMesasExamen($id) {
        $consulta = "SELECT codigoCarrera, nombreCarrera, nombreAsignatura, fechaPri, horaPri, fechaSeg, horaSeg "
                . " FROM vista_mesas WHERE idAulaPri = {$id} OR idAulaSeg = {$id}";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $consulta = "SELECT aul.*, (CASE WHEN cla.clases IS NULL THEN 0 ELSE cla.clases END) clases,"
                . "(CASE WHEN lla.llamados IS NULL THEN 0 ELSE lla.llamados END) llamados "
                . "FROM aula aul LEFT JOIN (SELECT idaula, COUNT(idclase) clases "
                . "FROM clase GROUP BY idaula) cla ON cla.idaula = aul.idaula "
                . "LEFT JOIN (SELECT idaula, COUNT(idllamado) llamados "
                . "FROM llamado GROUP BY idaula) lla ON lla.idaula = aul.idaula "
                . "ORDER BY idaula DESC LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
