<?php

/**
 * Permite obtener operar con los registros de Aula almacenados en la base 
 * de datos. 
 * Relacion con BD: AULA.
 * Campos: idaula, nombre, sector.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class Aula {

    /** @var integer Identificador del aula en la base de datos. */
    private $idaula;

    /** @var string Nombre del aula. */
    private $nombre;

    /** @var string Sector donde se ubica el aula. */
    private $sector;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var boolean Estado que indica la validez del aula */
    private $estado;

    /**
     * Constructor de la clase aula. Cuando se indica un identificador se 
     * busca la informacion en la base de datos y se actualizan los atributos,
     * siendo valida. Cuando no se obtiene un registro el aula no sera valida. 
     * Al no indicar idaula, se crea un objeto vacio.
     * @param integer $idaula Identificador del aula o null.
     */
    function __construct($idaula = null) {
        $this->estado = false;
        if ($idaula) {
            $consulta = "SELECT * FROM aula WHERE idaula = " . $idaula;
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $aula = $rows[0];
                $this->cargar($aula['nombre'], $aula['sector'], $aula['idaula']);
            }
        }
    }

    /**
     * Constructor alternativo de la clase aula. Permite establecer la informacion 
     * del aula y la validez de la misma. Se debe utilizar cuando es necesario 
     * realizar INSERT o UPDATE a la base de datos.
     * @param string $nombre Nombre del aula.
     * @param string $sector Nombre del sector.
     * @param integer $idaula Identificador del aula o null.
     */
    public function constructor($nombre, $sector, $idaula = null) {
        $this->estado = false;
        if ($this->setNombre($nombre) && $this->setSector($sector)) {
            $this->idaula = $idaula;
            $this->estado = true;
        }
        return $this->estado;
    }

    public function cargar($nombre, $sector, $idaula) {
        $this->nombre = $nombre;
        $this->sector = $sector;
        $this->idaula = $idaula;
        $this->estado = true;
    }

    /**
     * Devuelve el identificador del aula. 
     * @return integer $idaula
     */
    public function getIdaula() {
        return $this->idaula;
    }

    /**
     * Devuelve el nombre del aula. Si contiene nombre se devuelve el valor que
     * posee sino devuelve una cadena vacia.
     * @return string Nombre del aula o cadena vacia.
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Devuelve el sector del aula. Si contiene sector devuelve el valor que 
     * posee sino devuelve una cadena vacia.
     * @return string Nombre del sector o cadena vacia.
     */
    public function getSector() {
        return $this->sector;
    }

    /**
     * Devuelve la descripcion del aula. Cuando el aula sea invalida (no cumple 
     * formato) se puede mostrar la descripcion que causa la no aceptacion. 
     * Ademas, se puede utilizar para mostrar mensajes luego de realizar alguna 
     * operacion en la base de datos,
     * @return string Descripcion del error detectado.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Devuelve la validacion del aula. Si el aula cumple con las caracteristicas 
     * necesarias sera valida, caso contrario, sera invalida y contendra una 
     * descripcion.
     * @return string True o false.
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Modifica el identificador del aula.
     * @param integer $idaula
     */
    public function setIdaula($idaula) {
        $this->idaula = $idaula;
    }

    /**
     * Modifica el nombre del aula. Solo se realiza la modificacion del nombre 
     * si cumple con el formato. En caso de no cumplirlo el aula sera invalida.
     * @param string $nombre Nombre del aula.
     */
    public function setNombre($nombre) {
        if ($this->validarFormatoNombre($nombre)) {
            $this->nombre = Utilidades::convertirCamelCase($nombre);
            return true;
        }
        return false;
    }

    /**
     * Modifica el sector del aula. Solo se realiza la modificacion del sector
     * si cumple con el formato. En caso de no cumplirlo el aula sera invalida.
     * @param string $sector Nombre del sector donde se ubica el aula.
     */
    public function setSector($sector) {
        if ($this->validarFormatoSector($sector)) {
            $this->sector = Utilidades::convertirCamelCase($sector);
            return true;
        }
        return false;
    }

    public function borrar() {
        $rows = $this->obtenerHorarios();
        if (is_null($rows)) {
            $this->descripcion = "El aula no se puede borrar porque está asociado a una clase";
            return 0;
        }
        if (empty($rows)) {
            $where = "idaula=" . $this->idaula;
            $borrar = Conexion::getInstancia()->executeDelete("aula", $where);
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del aula";
            return $borrar;
        }
        $this->descripcion = "El aula no se puede borrar porque está asociado a una clase";
        return 1;
    }

    /**
     * Realiza la busqueda de un aula por su nombre y sector solo si es valida. 
     * Se retorna un arreglo asociativo que solo es vacio en caso de no encontrar
     * registros en la base de datos.
     * @return array() Arreglo asociativo de la tabla aula.
     */
    public function buscar() {
        if ($this->completa()) {
            $consulta = "SELECT * FROM aula WHERE nombre = '" . $this->nombre . "' AND sector = '" . $this->sector . "' ";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            return $rows;
        }
        return null;
    }

    public function buscarAulas() {
        $consulta = "SELECT * FROM aula ORDER BY sector ASC";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }

    /**
     * Realiza la creacion de una aula solo si es valida. El metodo retorna
     * null si el aula no es valida, retorna un arreglo asociativo si se 
     * encontro una coincidencia existente, true si se crea o false en caso que
     * no se haya creado. En todos los casos, se obtiene una descripcion que 
     * indica un mensaje.
     */
    public function crear() {
        $rows = $this->buscar();
        if (!empty($rows)) {
            $this->descripcion = "Se encontró un aula que coincide con la indicada";
            $this->idaula = $rows[0]['idaula'];
            return 3;
        }
        if (!is_null($rows)) {
            $values = "(NULL,'" . $this->nombre . "','" . $this->sector . "')";
            $creacion = Conexion::getInstancia()->executeInsert("aula", $values);
            $this->idaula = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del aula";
            return $creacion;
        }
        $this->descripcion = "No pudo realizar la búsqueda de aula";
        return 0;
    }

    /**
     * Devuelve true si el aula contiene los campos obligatorios. Evalua si el
     * aula tiene definido un nombre y sector. Si ambos atributos estan definidos
     * entonces devuelve true. En caso contrario devuelve false para indicar que
     * el aula esta incompleta.
     * @return boolean True o false.
     */
    private function completa() {
        $this->descripcion = "El aula no contiene toda la información";
        return ($this->nombre && $this->sector) ? true : false;
    }

    /**
     * Realiza la modificacion de un aula solo si es valida y contiene el
     * identificador. El metodo retorna true en caso de realizar la modificacion
     * o false en caso contrario. En ambos casos se indica una descripcion con 
     * un mensaje a mostrar.
     */
    public function modificar() {
        if ($this->completa() && $this->idaula) {
            $set = "nombre='{$this->nombre}', sector='{$this->sector}'";
            $where = "idaula={$this->idaula}";
            $modificacion = Conexion::getInstancia()->executeUpdate("aula", $set, $where);
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del aula";
            return $modificacion;
        }
        $this->descripcion = "El aula no contiene toda la información";
        return 0;
    }

    public function obtenerHorarios() {
        if ($this->idaula) {
            $consulta = "SELECT DISTINCT(a.idasignatura), cl.dia, a.nombre, DATE_FORMAT(cl.desde, '%H:%i') desde, DATE_FORMAT(cl.hasta, '%H:%i') hasta
                    FROM asignatura a, cursada cu, clase cl 
                    WHERE a.idasignatura = cu.idasignatura AND cu.idclase = cl.idclase AND cl.idaula = {$this->idaula} 
                    ORDER BY cl.dia ASC, cl.desde ASC";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $horarios = array();
                foreach ($rows as $fila) {
                    $columna = substr($fila['desde'], 0, 2);
                    $horarios[$fila['dia']][$columna] = array('nombre' => $fila['nombre'], 'inicio' => $fila['desde'], 'fin' => $fila['hasta']);
                }
                return $horarios;
            }
            return is_null($rows) ? NULL : $rows;
        }
        $this->descripcion = "El aula no contiene toda la información";
        return 0;
    }

    /**
     * Realiza la validacion del nombre del aula. Para el nombre de un aula
     * solo se permiten entre 1 y 40 caracteres alfanumericos, incluyendo 
     * acentos, comas, puntos y enes. Solo si el nombre cumple con los
     * requerimientos sera valido. En caso contrario sera invalida y contendra 
     * una descripcion indicando el motivo.
     * @param string $nombre Recibe el nombre a validar.
     * @return boolean True o false.
     */
    private function validarFormatoNombre($nombre) {
        $expresion = "/^[A-Za-zÁÉÍÓÚÑáéíóúñ0123456789 ]{1,40}$/";
        $this->descripcion = "El nombre de aula no cumple con el formato";
        return (preg_match($expresion, $nombre)) ? true : false;
    }

    /**
     * Realiza la validacion del nombre del sector. Para el nombre de un sector
     * solo se permiten entre 1 caracter afabetico. Solo si el nombre del sector 
     * cumple con los requerimientos sera valido. En caso contrario sera 
     * invalida el aula y contendra una descripcion indicando el motivo.
     * @param string $sector Recibe el nombre del sector a validar.
     */
    private function validarFormatoSector($sector) {
        $expresion = "/^[A-Za-z]$/";
        $this->descripcion = "El sector no cumple con el formato";
        return (preg_match($expresion, $sector)) ? true : false;
    }

    /**
     * Verifica la disponilidad del aula para un determinado dia. Se controla que exista una clase 
     * en el mismo horario que el indicado. Devuelve falso si el aula esta ocupada y verdadero si 
     * esta disponible en ese horario.
     * @param integer $idaula Identificador de aula.
     * @param integer $dia Dia de la semana (1,2,3,4,5,6).
     * @param string $desde Hora de inicio HH:MM:SS.
     * @param string $hasta Hora de fin HH:MM:SS.
     * @return boolean True o false.
     * */
    public function verificarDisponibilidad($idaula, $dia, $desde, $hasta) {
        $consulta = "SELECT idclase FROM clase WHERE dia=" . $dia . " AND idaula=" . $idaula . " AND (desde='" . $desde . "' AND hasta='" . $hasta . "')";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Verifica la disponibilidad del aula para un dia determinado. Este metodo controla que una 
     * clase no empiece o termine entre las horas de inicio y fin indicadas. No muestra si hay una
     * clase que inicie a la misma hora y finalice a la misma hora. Esto se realiza como opcion 
     * intermedia dado que puede haber clases distintas en la misma aula. El metodo devuelve falso 
     * si no esta dispobible y verdadero si esta disponible.
     * @param integer $idaula Identificador de aula.
     * @param integer $dia Dia de la semana (1,2,3,4,5,6).
     * @param string $desde Hora de inicio HH:MM:SS.
     * @param string $hasta Hora de fin HH:MM:SS.
     * @return boolean 0 error, 1 libre, 2 ocupada.
     * */
    public function verificarDisponibilidadFranja($dia, $desde, $hasta) {
        $consulta = "SELECT idclase FROM clase WHERE dia=" . $dia . " AND idaula=" . $this->idaula . " AND ((desde>'" . $desde . "' AND desde<'" . $hasta . "') OR (hasta>'" . $desde . "' AND hasta<'" . $hasta . "'))";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        if (!is_null($rows)) {
            return empty($rows) ? 1 : 2;
        }
        return 0;
    }

}
