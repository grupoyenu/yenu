<?php

/**
 * Este controlador permite realizar las operaciones que corresponden a las mesas
 * de examen. Funciona como un intermediario entre las vistas y los modelos. Se
 * encarga de relacionar la operacion que se desea realizar con el objeto que 
 * debe llevarla a cabo. Recibe el resultado de una operacion y la devuelve a 
 * traves de una descripcion asociada.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class ControladorMesaExamen {

    /** @var MesaExamen Mesa de examen con la que se va a trabajar */
    private $mesa;
    
    /** @var string Descripcion sobre alguna operacion realizada */
    private $descripcion;

    /**
     * Constructor del controlador. Realiza la creacion del objeto mesa de examen
     * para poder operar sobre el a partir de los datos ingresados en cada uno de
     * los metodos.
     */
    function __construct() {
        $this->mesa = new Mesa();
    }

    /**
     * Retorna un mensaje que sirve de descripcion sobre alguna de las operaciones
     * que se lleva a cabo. Puede mostrar un mensaje que indica un error, una 
     * alerta o un exito.
     * @return string Mensaje descriptivo sobre alguna operacion.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Realiza la eliminacion de una mesa de examen. Esta operacion involucra a
     * un conjunto de sentencias SQL por lo que hace uso de COMMIT y ROLLBACK para
     * operar. 
     * @param integer $idmesa Identificador de la mesa de examen a borrar.
     * @return integer Description
     */
    public function borrar($idmesa) {
        $this->mesa = new Mesa($idmesa);
        if ($this->mesa->getEstado()) {
            Conexion::getInstancia()->setAutocommit(false);
            $eliminacion = $this->mesa->borrar();
            $this->descripcion = $this->mesa->getDescripcion();
            switch ($eliminacion) {
                case 1:
                    Conexion::getInstancia()->executeRollback();
                    break;
                case 2:
                    Conexion::getInstancia()->executeCommit();
                    break;
            }
            Conexion::getInstancia()->setAutocommit(true);
            return $eliminacion;
        }
        $this->descripcion = "No pudo obtener la información de la mesa de examen";
        return 0;
    }

    public function borrarMesas() {
        
    }

    public function buscar() {
        
    }

    /**
     * Realiza la busqueda de una o varias mesas de examen. Crea un objeto de 
     * tipo Mesas para llevar a cabo la busqueda. Como resultado se obtiene un
     * arreglo de mesas, un arreglo vacio o nulo.
     * @param string $nombreAsignatura Nombre de la asignatura para buscar similares.
     * @return array() NULL si falla, arreglo vacio o arreglo de mesas de examen.
     */
    public function buscarMesas($nombreAsignatura) {
        $mesas = new Mesas();
        return $mesas->buscar($nombreAsignatura);
    }

    /**
     * Realiza la creacion de una nueva mesa de examen.
     */
    public function crear($plan, $tribunal, $llamados) {
        
    }

    /**
     * Realiza la modificacion de una mesa de examen.
     */
    public function modificar($idmesa, $plan, $tribunal, $llamados) {
        
    }

    /**
     * Realiza la consulta sobre la cantidad de llamados de las actuales mesas de
     * examen.
     * @return int 0 error, 1 llamado o 2 llamados.
     */
    public function obtenerCantidadLlamados() {
        $mesas = new Mesas();
        return $mesas->obtenerCantidadLlamados();
    }

}
