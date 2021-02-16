<?php

namespace app\mesa\modelo;

use app\asignatura\modelo\Asignatura;
use app\carrera\modelo\Carrera;
use app\docente\modelo\Docente;
use app\mesa\modelo\ColeccionLlamados as Llamados;
use app\mesa\modelo\ColeccionTribunales as Tribunales;
use app\mesa\modelo\Llamado;
use app\mesa\modelo\MesaExamen;
use app\mesa\modelo\Tribunal;
use app\plan\modelo\ColeccionPlanes as Planes;
use app\plan\modelo\Plan;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * Description of MesasExamen
 *
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ColeccionMesasExamen
{

    /**
     * Realiza la busqueda de mesas de examen en la vista correspondientes con el
     * objetivo de generar el informe del modulo. Se pueden aplicar filtros para
     * el nombre de carrera, nombre de asignatura, fecha, hora y fecha de edicion
     * de la mesa.
     * @param string $carrera Nombre de la carrera.
     * @param string $asignatura Nombre de la asignatura.
     * @param string $fecha Fecha en la que se dicta la mesa o NO.
     * @param string $hora Hora en la que se dicta la mesa o NO.
     * @param string $docente Nombre del docente a buscar dentro del tribunal.
     * @param string $modificada SI para mesa modificada, NO en caso contrario.
     * @return integer 0 cuando falla la consulta, 1 sin resultados o 2 correcta.
     */
    public static function buscarParaInforme($carrera, $asignatura, $fecha, $hora, $docente, $modificada)
    {
        $consulta = "SELECT * FROM vw_mesa_examen WHERE "
            . "nombreLargoCarrera LIKE '%$carrera%' AND "
            . "nombreLargoAsignatura LIKE '%$asignatura%' AND ";
        $consulta .= ($fecha == "NO") ? "" : "(fechaPrimerLlamado = '{$fecha}' OR fechaSegundoLlamado = '{$fecha}') AND ";
        $consulta .= ($hora == "NO") ? "" : "(horaPrimerLlamado = '{$hora}' OR horaSegundoLlamado = '{$hora}') AND ";
        $consulta .= (!$docente) ? "" : "(nombrePresidente LIKE '%{$docente}%' OR nombreVocalPrimero LIKE '%{$docente}%' OR nombreVocalSegundo LIKE '%{$docente}%' OR nombreSuplente LIKE '%{$docente}%') AND";
        $condicion = ($modificada == "SI") ? "IS NOT NULL" : "IS NULL";
        $consulta .= "(fechaEdicionPrimerLlamado {$condicion} OR fechaEdicionSegundoLlamado {$condicion})";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        return $resultado;
    }

    /**
     * Buscar mesa de examen a partir del nombre de una carrera y nombre de una
     * asignatura.
     * @see vw_mesa_examen
     * @param string $nombreCarrera Nombre de la carrera o parte del nombre (LIKE).
     * @param string $nombreAsignatura Nombre de la asignatura o parte del nombre (LIKE).
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura)
    {
        $consulta = "SELECT * FROM vw_mesa_examen "
            . "WHERE nombreLargoCarrera LIKE '%{$nombreCarrera}%' AND "
            . "nombreLargoAsignatura LIKE '%{$nombreAsignatura}%'";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    public static function importarMesasExamen($mesas, $nroLlamados)
    {
        Log::guardar("INF", "COLECCION MESAS --> IMPORTAR");
        $resultado = ColeccionMesasExamen::borrarMesasExamen();
        if ($resultado[0] == 2) {
            $errores = ($nroLlamados == 1) ?
                ColeccionMesasExamen::importarUnLlamado($mesas) :
                ColeccionMesasExamen::importarDosLlamados($mesas);
            $totalErrores = count($errores);
            $totalMesas = count($mesas);
            if ($totalErrores == $totalMesas) {
                return array(1, "No se crearon mesas de examen ({$totalErrores} errores sobre {$totalMesas} mesas)");
            }
            $limpiar = Planes::quitarCarrerasAsignaturas();
            return ($limpiar[0] == 2) ? array(2, $errores) : array(1, "No se crearon mesas de examen");
        }
        return $resultado;
    }

    private static function importarUnLlamado($mesas)
    {
        Log::guardar("INF", "COLECCION MESAS --> IMPORTAR UN LLAMADO");
        $errores = array();
        $contador = 1;
        foreach ($mesas as $datos) {
            $numeroRegistro = str_pad($contador, 6, "0", STR_PAD_LEFT);
            Log::guardar("INF", "{$numeroRegistro} " . str_repeat("-", 45));
            $carrera = new Carrera($datos[0], utf8_encode($datos[1]), utf8_encode($datos[1]));
            $asignatura = new Asignatura(NULL, utf8_encode($datos[2]), utf8_encode($datos[2]));
            $tribunal = new Tribunal();
            $tribunal->agregarDocente(new Docente(NULL, utf8_encode($datos[3])));
            $tribunal->agregarDocente(new Docente(NULL, utf8_encode($datos[4])));
            $tribunal->agregarDocente(new Docente(NULL, utf8_encode($datos[5])));
            $tribunal->agregarDocente(new Docente(NULL, utf8_encode($datos[6])));
            $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $datos[7])));
            $llamado = new Llamado(NULL, NULL, NULL, $fecha, $datos[8]);
            $mesaExamen = new MesaExamen(NULL, $llamado, NULL, $tribunal);
            $plan = new Plan(NULL, $asignatura, $carrera, NULL, $mesaExamen, 1);
            $resultado = $plan->crear();
            $escribirLog = ($resultado[0] == 2) ? FALSE : TRUE;
            if (($resultado[0] == 2) && (gettype($plan->getMesa()) == "integer")) {
                $plan->setMesa($mesaExamen);
                $resultado = $plan->asociarMesaExamen();
                $escribirLog = ($resultado[0] == 2) ? FALSE : TRUE;
            }
            if ($escribirLog) {
                $tipo = ($resultado[0] == 0) ? "ERR" : "WAR";
                $mensaje = implode(",", $datos);
                Log::guardar($tipo, "{$numeroRegistro} {$resultado[1]} ({$mensaje})");
                $errores[] = $datos;
            }
            $contador++;
        }
        return $errores;
    }

    public function importarDosLlamados($mesas)
    {
        Log::guardar("INF", "COLECCION MESAS --> IMPORTAR DOS LLAMADOS");
        $errores = array();
        $contador = 1;
        foreach ($mesas as $datos) {
            $numeroRegistro = str_pad($contador, 6, "0", STR_PAD_LEFT);
            Log::guardar("INF", "{$numeroRegistro} " . str_repeat("-", 45));
            $carrera = new Carrera($datos[0], utf8_encode($datos[1]), utf8_encode($datos[1]));
            $asignatura = new Asignatura(NULL, utf8_encode($datos[2]), utf8_encode($datos[2]));
            $tribunal = new Tribunal();
            $tribunal->agregarDocente(new Docente(NULL, utf8_encode($datos[3])));
            $tribunal->agregarDocente(new Docente(NULL, utf8_encode($datos[4])));
            $tribunal->agregarDocente(new Docente(NULL, utf8_encode($datos[5])));
            $tribunal->agregarDocente(new Docente(NULL, utf8_encode($datos[6])));
            $fecha1 = date('Y-m-d', strtotime(str_replace('/', '-', $datos[7])));
            $fecha2 = date('Y-m-d', strtotime(str_replace('/', '-', $datos[8])));
            $primero = ($datos[7]) ? new Llamado(NULL, NULL, NULL, $fecha1, $datos[9]) : NULL;
            $segundo = ($datos[8]) ? new Llamado(NULL, NULL, NULL, $fecha2, $datos[9]) : NULL;
            $mesaExamen = new MesaExamen(NULL, $primero, $segundo, $tribunal);
            $plan = new Plan(NULL, $asignatura, $carrera, NULL, $mesaExamen, 1);
            $resultado = $plan->crear();
            $escribirLog = ($resultado[0] == 2) ? FALSE : TRUE;
            if (($resultado[0] == 2) && (gettype($plan->getMesa()) == "integer")) {
                $plan->setMesa($mesaExamen);
                $resultado = $plan->asociarMesaExamen();
                $escribirLog = ($resultado[0] == 2) ? FALSE : TRUE;
            }
            if ($escribirLog) {
                $tipo = ($resultado[0] == 0) ? "ERR" : "WAR";
                $mensaje = implode(",", $datos);
                Log::guardar($tipo, "{$numeroRegistro} {$resultado[1]} ({$mensaje})");
                $errores[] = $datos;
            }
            $contador++;
        }
        return $errores;
    }

    public static function listarMesasDeAula($idAula)
    {
        if ($idAula > 0) {
            $consulta = "SELECT car.id codigoCarrera, car.nombreCorto nombreCortoCarrera, "
                . "car.nombreLargo nombreLargoCarrera, asi.nombreCorto nombreCortoAsignatura, "
                . "asi.nombreLargo nombreLargoAsignatura, lla.estado, lla.fecha, lla.fechaEdicion, lla.hora "
                . "FROM plan pla INNER JOIN mesa_examen mes on mes.id = pla.idMesaExamen "
                . "INNER JOIN carrera car on car.id = pla.idCarrera "
                . "INNER JOIN asignatura asi on asi.id = pla.idAsignatura "
                . "INNER JOIN llamado lla on lla.id = mes.idPrimerLlamado AND lla.idAula = {$idAula} "
                . "UNION ALL SELECT car.id codigoCarrera, car.nombreCorto nombreCortoCarrera, "
                . "car.nombreLargo nombreLargoCarrera, asi.nombreCorto nombreCortoAsignatura, "
                . "asi.nombreLargo nombreLargoAsignatura, lla.estado, lla.fecha, lla.fechaEdicion, lla.hora "
                . "FROM plan pla INNER JOIN mesa_examen mes on mes.id = pla.idMesaExamen "
                . "INNER JOIN carrera car on car.id = pla.idCarrera "
                . "INNER JOIN asignatura asi on asi.id = pla.idAsignatura "
                . "INNER JOIN llamado lla on lla.id = mes.idSegundoLlamado AND lla.idAula = {$idAula}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se pudo hacer referencia al aula");
    }

    /**
     * @see vw_informe Consulta cuando modulo es MESAS DE EXAMEN.
     */
    public static function listarInformesMesaExamen(): array
    {
        $consulta = "SELECT * FROM vw_informe WHERE modulo = 'MESAS DE EXAMEN'";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    /**
     * Realiza la busqueda de las ultimas diez mesas de examen que se han creado.
     * El objetivo es brindar resultados previos cuando se hace la busqueda de 
     * mesas de examen.
     * @param int $limite Cantidad maxima de mesas de examen.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarResumenMesasExamen($limite)
    {
        if ($limite > 0) {
            $consulta = "SELECT * FROM vw_mesa_examen ORDER BY idMesaExamen LIMIT {$limite}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se estableció un limite valido");
    }

    private static function borrarMesasExamen()
    {
        Log::guardar("INF", "COLECCION MESAS --> BORRAR");
        $desasociar = Planes::quitarMesasExamen();
        if ($desasociar[0] == 2) {
            $consulta = "DELETE FROM mesa_examen";
            $resultado = Conexion::getInstancia()->borrar($consulta);
            if (($resultado[0] == 2) || ($resultado[0] == 1 && $resultado[2] == 0)) {
                $tborrar = Tribunales::borrarTribunales();
                $lborrar = Llamados::borrarLlamados();
                $exito = array(2, "Se realizó la eliminacion de mesas");
                $error = array(0, "No se pudo realizar la eliminación de mesas");
                return ($tborrar[0] == 2 && $lborrar[0] == 2) ? $exito : $error;
            }
            return $resultado;
        }
        return $desasociar;
    }
}
