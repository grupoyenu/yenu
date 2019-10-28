<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$modulos = array("asignaturas" => "asignatura",
    "aulas" => "aula",
    "carreras" => "carrera",
    "cursadas" => "cursada",
    "docentes" => "docente",
    "mesas" => "mesa",
    "planes" => "plan",
    "principal" => "principal",
    "usuario" => "usuario");

$vistas = array("FormBuscarAula" => "buscar_aulas",
    "FormCrearAula" => "crear_aulas",
    "FormBuscarCursada" => "buscar_cursadas",
    "FormCrearCursada" => "crear_cursadas",
    "FormSeleccionarCursada" => "importar_cursadas",
    "FormInformeCursada" => "informe_cursadas");

$modulo = array_search("cursada", $modulos);
if ($modulo) {
    $vista = "crear_" . $modulo;
    $archivo = array_search($vista, $vistas);
    echo "<br> VISTA A CARGAR: " . $archivo;
}



$archivo2 = array_search("planes", $modulos);
echo "<br> MODULO: " . $archivo2;



