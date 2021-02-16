-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-02-2021 a las 03:03:44
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tempus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE `asignatura` (
  `id` int(11) NOT NULL,
  `nombreCorto` varchar(10) NOT NULL,
  `nombreLargo` varchar(255) NOT NULL,
  `fechaCreacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

CREATE TABLE `aula` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `sector` varchar(5) NOT NULL,
  `fechaCreacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `id` varchar(3) NOT NULL,
  `nombreCorto` varchar(10) NOT NULL,
  `nombreLargo` varchar(255) NOT NULL,
  `fechaCreacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `id` int(11) NOT NULL,
  `idAula` int(11) NOT NULL,
  `idPlan` int(11) NOT NULL,
  `diaSemana` enum('1','2','3','4','5','6','7') NOT NULL DEFAULT '1',
  `horaInicio` time NOT NULL,
  `horaFin` time NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaEdicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamado`
--

CREATE TABLE `llamado` (
  `id` int(11) NOT NULL,
  `idAula` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaEdicion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_examen`
--

CREATE TABLE `mesa_examen` (
  `id` int(11) NOT NULL,
  `idPrimerLlamado` int(11) DEFAULT NULL,
  `idSegundoLlamado` int(11) DEFAULT NULL,
  `idTribunal` int(11) NOT NULL,
  `observacion` varchar(300) NOT NULL,
  `fechaCreacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan`
--

CREATE TABLE `plan` (
  `id` int(11) NOT NULL,
  `idAsignatura` int(11) NOT NULL,
  `idCarrera` varchar(3) NOT NULL,
  `idMesaExamen` int(11) DEFAULT NULL,
  `anio` int(11) NOT NULL,
  `fechaCreacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

CREATE TABLE `rol_permiso` (
  `rol_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE `rol_usuario` (
  `rol_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tribunal`
--

CREATE TABLE `tribunal` (
  `id` int(11) NOT NULL,
  `idPresidente` int(11) NOT NULL,
  `idVocal1` int(11) NOT NULL,
  `idVocal2` int(11) DEFAULT NULL,
  `idSuplente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `metodoLogin` varchar(25) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_google`
--

CREATE TABLE `usuario_google` (
  `usuario_id` int(11) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `imagen` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_manual`
--

CREATE TABLE `usuario_manual` (
  `usuario_id` int(11) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_asignatura`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_asignatura` (
`id` int(11)
,`nombreCorto` varchar(10)
,`nombreLargo` varchar(255)
,`fechaCreacion` datetime
,`carreras` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_aula`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_aula` (
`id` int(11)
,`nombre` varchar(50)
,`sector` varchar(5)
,`fechaCreacion` datetime
,`clases` bigint(21)
,`llamados` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_carrera`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_carrera` (
`id` varchar(3)
,`nombreCorto` varchar(10)
,`nombreLargo` varchar(255)
,`asignaturas` bigint(21)
,`fechaCreacion` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_cursada`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_cursada` (
`idPlan` int(11)
,`anio` int(11)
,`codigoCarrera` varchar(3)
,`nombreCortoCarrera` varchar(10)
,`nombreLargoCarrera` varchar(255)
,`idAsignatura` int(11)
,`nombreCortoAsignatura` varchar(10)
,`nombreLargoAsignatura` varchar(255)
,`horaInicioLunes` time
,`horaFinLunes` time
,`sectorAulaLunes` varchar(5)
,`nombreAulaLunes` varchar(50)
,`fechaEdicionLunes` datetime
,`horaInicioMartes` time
,`horaFinMartes` time
,`sectorAulaMartes` varchar(5)
,`nombreAulaMartes` varchar(50)
,`fechaEdicionMartes` datetime
,`horaInicioMiercoles` time
,`horaFinMiercoles` time
,`sectorAulaMiercoles` varchar(5)
,`nombreAulaMiercoles` varchar(50)
,`fechaEdicionMiercoles` datetime
,`horaInicioJueves` time
,`horaFinJueves` time
,`sectorAulaJueves` varchar(5)
,`nombreAulaJueves` varchar(50)
,`fechaEdicionJueves` datetime
,`horaInicioViernes` time
,`horaFinViernes` time
,`sectorAulaViernes` varchar(5)
,`nombreAulaViernes` varchar(50)
,`fechaEdicionViernes` datetime
,`horaInicioSabado` time
,`horaFinSabado` time
,`sectorAulaSabado` varchar(5)
,`nombreAulaSabado` varchar(50)
,`fechaEdicionSabado` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_informe`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_informe` (
`modulo` varchar(15)
,`informe` varchar(55)
,`cantidad` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_mesa_examen`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_mesa_examen` (
`idPlan` int(11)
,`idMesaExamen` int(11)
,`codigoCarrera` varchar(3)
,`nombreCortoCarrera` varchar(10)
,`nombreLargoCarrera` varchar(255)
,`idAsignatura` int(11)
,`nombreCortoAsignatura` varchar(10)
,`nombreLargoAsignatura` varchar(255)
,`sectorAulaPrimerLlamado` varchar(5)
,`nombreAulaPrimerLlamado` varchar(50)
,`estadoPrimerLlamado` enum('Activo','Inactivo')
,`fechaPrimerLlamado` date
,`fechaEdicionPrimerLlamado` datetime
,`horaPrimerLlamado` time
,`sectorAulaSegundoLlamado` varchar(5)
,`nombreAulaSegundoLlamado` varchar(50)
,`estadoSegundoLlamado` enum('Activo','Inactivo')
,`fechaSegundoLlamado` date
,`fechaEdicionSegundoLlamado` datetime
,`horaSegundoLlamado` time
,`nombrePresidente` varchar(100)
,`nombreVocalPrimero` varchar(100)
,`nombreVocalSegundo` varchar(100)
,`nombreSuplente` varchar(100)
,`fechaCreacionMesaExamen` datetime
,`observacionMesaExamen` varchar(300)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_permiso`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_permiso` (
`id` int(11)
,`nombre` varchar(255)
,`roles` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_plan`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_plan` (
`idPlan` int(11)
,`idAsignatura` int(11)
,`nombreCortoAsignatura` varchar(10)
,`nombreLargoAsignatura` varchar(255)
,`idCarrera` varchar(3)
,`nombreCortoCarrera` varchar(10)
,`nombreLargoCarrera` varchar(255)
,`cursada` varchar(2)
,`mesaExamen` varchar(2)
,`anio` int(11)
,`fechaCreacion` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_rol`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_rol` (
`id` int(11)
,`nombre` varchar(255)
,`usuarios` bigint(21)
,`permisos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_usuario`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_usuario` (
`id` int(11)
,`email` varchar(255)
,`nombreUsuario` varchar(255)
,`metodoLogin` varchar(25)
,`estado` enum('Activo','Inactivo')
,`nombreRol` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_asignatura`
--
DROP TABLE IF EXISTS `vw_asignatura`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_asignatura`  AS  select `a`.`id` AS `id`,`a`.`nombreCorto` AS `nombreCorto`,`a`.`nombreLargo` AS `nombreLargo`,`a`.`fechaCreacion` AS `fechaCreacion`,case when `c`.`carreras` is null then 0 else `c`.`carreras` end AS `carreras` from (`asignatura` `a` left join (select `plan`.`idAsignatura` AS `idAsignatura`,count(`plan`.`idCarrera`) AS `carreras` from `plan` group by `plan`.`idAsignatura`) `c` on(`c`.`idAsignatura` = `a`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_aula`
--
DROP TABLE IF EXISTS `vw_aula`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_aula`  AS  select `a`.`id` AS `id`,`a`.`nombre` AS `nombre`,`a`.`sector` AS `sector`,`a`.`fechaCreacion` AS `fechaCreacion`,case when `c`.`clases` is null then 0 else `c`.`clases` end AS `clases`,case when `l`.`llamados` is null then 0 else `l`.`llamados` end AS `llamados` from ((`aula` `a` left join (select `clase`.`idAula` AS `idAula`,count(0) AS `clases` from `clase` group by `clase`.`idAula`) `c` on(`c`.`idAula` = `a`.`id`)) left join (select `llamado`.`idAula` AS `idAula`,count(0) AS `llamados` from `llamado` group by `llamado`.`idAula`) `l` on(`l`.`idAula` = `a`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_carrera`
--
DROP TABLE IF EXISTS `vw_carrera`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_carrera`  AS  select `c`.`id` AS `id`,`c`.`nombreCorto` AS `nombreCorto`,`c`.`nombreLargo` AS `nombreLargo`,case when `a`.`asignaturas` is null then 0 else `a`.`asignaturas` end AS `asignaturas`,`c`.`fechaCreacion` AS `fechaCreacion` from (`carrera` `c` left join (select `plan`.`idCarrera` AS `idCarrera`,count(`plan`.`idAsignatura`) AS `asignaturas` from `plan` group by `plan`.`idCarrera`) `a` on(`a`.`idCarrera` = `c`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_cursada`
--
DROP TABLE IF EXISTS `vw_cursada`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_cursada`  AS  select distinct `plan`.`id` AS `idPlan`,`plan`.`anio` AS `anio`,`carrera`.`id` AS `codigoCarrera`,`carrera`.`nombreCorto` AS `nombreCortoCarrera`,`carrera`.`nombreLargo` AS `nombreLargoCarrera`,`asignatura`.`id` AS `idAsignatura`,`asignatura`.`nombreCorto` AS `nombreCortoAsignatura`,`asignatura`.`nombreLargo` AS `nombreLargoAsignatura`,`lunes`.`horaInicioLunes` AS `horaInicioLunes`,`lunes`.`horaFinLunes` AS `horaFinLunes`,`lunes`.`sectorAulaLunes` AS `sectorAulaLunes`,`lunes`.`nombreAulaLunes` AS `nombreAulaLunes`,`lunes`.`fechaEdicionLunes` AS `fechaEdicionLunes`,`martes`.`horaInicioMartes` AS `horaInicioMartes`,`martes`.`horaFinMartes` AS `horaFinMartes`,`martes`.`sectorAulaMartes` AS `sectorAulaMartes`,`martes`.`nombreAulaMartes` AS `nombreAulaMartes`,`martes`.`fechaEdicionMartes` AS `fechaEdicionMartes`,`miercoles`.`horaInicioMiercoles` AS `horaInicioMiercoles`,`miercoles`.`horaFinMiercoles` AS `horaFinMiercoles`,`miercoles`.`sectorAulaMiercoles` AS `sectorAulaMiercoles`,`miercoles`.`nombreAulaMiercoles` AS `nombreAulaMiercoles`,`miercoles`.`fechaEdicionMiercoles` AS `fechaEdicionMiercoles`,`jueves`.`horaInicioJueves` AS `horaInicioJueves`,`jueves`.`horaFinJueves` AS `horaFinJueves`,`jueves`.`sectorAulaJueves` AS `sectorAulaJueves`,`jueves`.`nombreAulaJueves` AS `nombreAulaJueves`,`jueves`.`fechaEdicionJueves` AS `fechaEdicionJueves`,`viernes`.`horaInicioViernes` AS `horaInicioViernes`,`viernes`.`horaFinViernes` AS `horaFinViernes`,`viernes`.`sectorAulaViernes` AS `sectorAulaViernes`,`viernes`.`nombreAulaViernes` AS `nombreAulaViernes`,`viernes`.`fechaEdicionViernes` AS `fechaEdicionViernes`,`sabado`.`horaInicioSabado` AS `horaInicioSabado`,`sabado`.`horaFinSabado` AS `horaFinSabado`,`sabado`.`sectorAulaSabado` AS `sectorAulaSabado`,`sabado`.`nombreAulaSabado` AS `nombreAulaSabado`,`sabado`.`fechaEdicionSabado` AS `fechaEdicionSabado` from ((((((((`plan` join `asignatura` on(`asignatura`.`id` = `plan`.`idAsignatura`)) join `carrera` on(`carrera`.`id` = `plan`.`idCarrera`)) left join (select `clase`.`idPlan` AS `idPlan`,`clase`.`horaInicio` AS `horaInicioLunes`,`clase`.`horaFin` AS `horaFinLunes`,`aula`.`sector` AS `sectorAulaLunes`,`aula`.`nombre` AS `nombreAulaLunes`,`clase`.`fechaEdicion` AS `fechaEdicionLunes` from (`clase` join `aula` on(`aula`.`id` = `clase`.`idAula` and `clase`.`diaSemana` = 1))) `lunes` on(`lunes`.`idPlan` = `plan`.`id`)) left join (select `clase`.`idPlan` AS `idPlan`,`clase`.`horaInicio` AS `horaInicioMartes`,`clase`.`horaFin` AS `horaFinMartes`,`aula`.`sector` AS `sectorAulaMartes`,`aula`.`nombre` AS `nombreAulaMartes`,`clase`.`fechaEdicion` AS `fechaEdicionMartes` from (`clase` join `aula` on(`aula`.`id` = `clase`.`idAula` and `clase`.`diaSemana` = 2))) `martes` on(`martes`.`idPlan` = `plan`.`id`)) left join (select `clase`.`idPlan` AS `idPlan`,`clase`.`horaInicio` AS `horaInicioMiercoles`,`clase`.`horaFin` AS `horaFinMiercoles`,`aula`.`sector` AS `sectorAulaMiercoles`,`aula`.`nombre` AS `nombreAulaMiercoles`,`clase`.`fechaEdicion` AS `fechaEdicionMiercoles` from (`clase` join `aula` on(`aula`.`id` = `clase`.`idAula` and `clase`.`diaSemana` = 3))) `miercoles` on(`miercoles`.`idPlan` = `plan`.`id`)) left join (select `clase`.`idPlan` AS `idPlan`,`clase`.`horaInicio` AS `horaInicioJueves`,`clase`.`horaFin` AS `horaFinJueves`,`aula`.`sector` AS `sectorAulaJueves`,`aula`.`nombre` AS `nombreAulaJueves`,`clase`.`fechaEdicion` AS `fechaEdicionJueves` from (`clase` join `aula` on(`aula`.`id` = `clase`.`idAula` and `clase`.`diaSemana` = 4))) `jueves` on(`jueves`.`idPlan` = `plan`.`id`)) left join (select `clase`.`idPlan` AS `idPlan`,`clase`.`horaInicio` AS `horaInicioViernes`,`clase`.`horaFin` AS `horaFinViernes`,`aula`.`sector` AS `sectorAulaViernes`,`aula`.`nombre` AS `nombreAulaViernes`,`clase`.`fechaEdicion` AS `fechaEdicionViernes` from (`clase` join `aula` on(`aula`.`id` = `clase`.`idAula` and `clase`.`diaSemana` = 5))) `viernes` on(`viernes`.`idPlan` = `plan`.`id`)) left join (select `clase`.`idPlan` AS `idPlan`,`clase`.`horaInicio` AS `horaInicioSabado`,`clase`.`horaFin` AS `horaFinSabado`,`aula`.`sector` AS `sectorAulaSabado`,`aula`.`nombre` AS `nombreAulaSabado`,`clase`.`fechaEdicion` AS `fechaEdicionSabado` from (`clase` join `aula` on(`aula`.`id` = `clase`.`idAula` and `clase`.`diaSemana` = 6))) `sabado` on(`sabado`.`idPlan` = `plan`.`id`)) where `lunes`.`idPlan` is not null or `martes`.`idPlan` is not null or `miercoles`.`idPlan` is not null or `jueves`.`idPlan` is not null or `viernes`.`idPlan` is not null or `sabado`.`idPlan` is not null ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_informe`
--
DROP TABLE IF EXISTS `vw_informe`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_informe`  AS  select 'ASIGNATURAS' collate utf8mb4_general_ci AS `modulo`,'Total de asignaturas' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `asignatura` union all select 'ASIGNATURAS' collate utf8mb4_general_ci AS `modulo`,'Total de asignaturas sin carrera asociada' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `vw_asignatura` where `vw_asignatura`.`carreras` = 0 union all select 'AULAS' collate utf8mb4_general_ci AS `modulo`,'Total de aulas' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `aula` union all select 'AULAS' collate utf8mb4_general_ci AS `modulo`,'Total de aulas sin clase asociada' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `vw_aula` where `vw_aula`.`clases` = 0 union all select 'AULAS' collate utf8mb4_general_ci AS `modulo`,'Total de aulas sin llamado asociado' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `vw_aula` where `vw_aula`.`llamados` = 0 union all select 'CARRERAS' collate utf8mb4_general_ci AS `modulo`,'Total de carreras' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `carrera` union all select 'CARRERAS' collate utf8mb4_general_ci AS `modulo`,'Total de carreras sin asignatura asociada' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `vw_carrera` where `vw_carrera`.`asignaturas` = 0 union all select 'CURSADAS' collate utf8mb4_general_ci AS `modulo`,'Total de cursadas' collate utf8mb4_general_ci AS `informe`,count(distinct `clase`.`idPlan`) AS `cantidad` from `clase` union all select 'MESAS DE EXAMEN' collate utf8mb4_general_ci AS `modulo`,'Total de mesas de examen' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `mesa_examen` union all select 'MESAS DE EXAMEN' collate utf8mb4_general_ci AS `modulo`,'Total de mesas de examen creadas los ultimos siete días' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `mesa_examen` where date_format(`mesa_examen`.`fechaCreacion`,'%Y-%m-%d') >= date_format(current_timestamp() + interval -7 day,'%Y-%m-%d') union all select 'MESAS DE EXAMEN' collate utf8mb4_general_ci AS `modulo`,'Total de mesas de examen del día' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `vw_mesa_examen` where `vw_mesa_examen`.`fechaPrimerLlamado` = date_format(current_timestamp(),'%Y-%m-%d') or `vw_mesa_examen`.`fechaSegundoLlamado` = date_format(current_timestamp(),'%Y-%m-%d') union all select 'PERMISOS' collate utf8mb4_general_ci AS `modulo`,'Total de permisos' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `permiso` union all select 'ROLES' collate utf8mb4_general_ci AS `modulo`,'Total de roles' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `rol` union all select 'USUARIOS' collate utf8mb4_general_ci AS `modulo`,'Total de usuarios' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `usuario` union all select 'USUARIOS' collate utf8mb4_general_ci AS `modulo`,'Total de usuarios activos' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `usuario` where `usuario`.`estado` = 'Activo' union all select 'USUARIOS' collate utf8mb4_general_ci AS `modulo`,'Total de usuarios inactivos' collate utf8mb4_general_ci AS `informe`,count(0) AS `cantidad` from `usuario` where `usuario`.`estado` = 'Inactivo' ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_mesa_examen`
--
DROP TABLE IF EXISTS `vw_mesa_examen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_mesa_examen`  AS  select `pla`.`id` AS `idPlan`,`mex`.`id` AS `idMesaExamen`,`car`.`id` AS `codigoCarrera`,`car`.`nombreCorto` AS `nombreCortoCarrera`,`car`.`nombreLargo` AS `nombreLargoCarrera`,`asi`.`id` AS `idAsignatura`,`asi`.`nombreCorto` AS `nombreCortoAsignatura`,`asi`.`nombreLargo` AS `nombreLargoAsignatura`,`apr`.`sector` AS `sectorAulaPrimerLlamado`,`apr`.`nombre` AS `nombreAulaPrimerLlamado`,`prl`.`estado` AS `estadoPrimerLlamado`,`prl`.`fecha` AS `fechaPrimerLlamado`,`prl`.`fechaEdicion` AS `fechaEdicionPrimerLlamado`,`prl`.`hora` AS `horaPrimerLlamado`,`ase`.`sector` AS `sectorAulaSegundoLlamado`,`ase`.`nombre` AS `nombreAulaSegundoLlamado`,`sel`.`estado` AS `estadoSegundoLlamado`,`sel`.`fecha` AS `fechaSegundoLlamado`,`sel`.`fechaEdicion` AS `fechaEdicionSegundoLlamado`,`sel`.`hora` AS `horaSegundoLlamado`,`pre`.`nombre` AS `nombrePresidente`,`vpr`.`nombre` AS `nombreVocalPrimero`,`vse`.`nombre` AS `nombreVocalSegundo`,`sup`.`nombre` AS `nombreSuplente`,`mex`.`fechaCreacion` AS `fechaCreacionMesaExamen`,`mex`.`observacion` AS `observacionMesaExamen` from ((((((((((((`plan` `pla` join `asignatura` `asi` on(`asi`.`id` = `pla`.`idAsignatura`)) join `carrera` `car` on(`car`.`id` = `pla`.`idCarrera`)) join `mesa_examen` `mex` on(`mex`.`id` = `pla`.`idMesaExamen`)) left join `llamado` `prl` on(`prl`.`id` = `mex`.`idPrimerLlamado`)) left join `llamado` `sel` on(`sel`.`id` = `mex`.`idSegundoLlamado`)) left join `aula` `apr` on(`apr`.`id` = `prl`.`idAula`)) left join `aula` `ase` on(`ase`.`id` = `sel`.`idAula`)) join `tribunal` `tri` on(`tri`.`id` = `mex`.`idTribunal`)) join `docente` `pre` on(`pre`.`id` = `tri`.`idPresidente`)) join `docente` `vpr` on(`vpr`.`id` = `tri`.`idVocal1`)) left join `docente` `vse` on(`vse`.`id` = `tri`.`idVocal2`)) left join `docente` `sup` on(`sup`.`id` = `tri`.`idSuplente`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_permiso`
--
DROP TABLE IF EXISTS `vw_permiso`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_permiso`  AS  select `p`.`id` AS `id`,`p`.`nombre` AS `nombre`,case when `r`.`roles` is null then 0 else `r`.`roles` end AS `roles` from (`permiso` `p` left join (select `rol_permiso`.`permiso_id` AS `idPermiso`,count(0) AS `roles` from `rol_permiso` group by `rol_permiso`.`permiso_id`) `r` on(`r`.`idPermiso` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_plan`
--
DROP TABLE IF EXISTS `vw_plan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_plan`  AS  select `p`.`id` AS `idPlan`,`a`.`id` AS `idAsignatura`,`a`.`nombreCorto` AS `nombreCortoAsignatura`,`a`.`nombreLargo` AS `nombreLargoAsignatura`,`c`.`id` AS `idCarrera`,`c`.`nombreCorto` AS `nombreCortoCarrera`,`c`.`nombreLargo` AS `nombreLargoCarrera`,case when `cl`.`clases` is null then 'No' else 'Si' end AS `cursada`,case when `p`.`idMesaExamen` is null then 'No' else 'Si' end AS `mesaExamen`,`p`.`anio` AS `anio`,`p`.`fechaCreacion` AS `fechaCreacion` from (((`plan` `p` join `asignatura` `a` on(`a`.`id` = `p`.`idAsignatura`)) join `carrera` `c` on(`c`.`id` = `p`.`idCarrera`)) left join (select `clase`.`idPlan` AS `idPlan`,count(`clase`.`id`) AS `clases` from `clase` group by `clase`.`idPlan`) `cl` on(`cl`.`idPlan` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_rol`
--
DROP TABLE IF EXISTS `vw_rol`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rol`  AS  select `r`.`id` AS `id`,`r`.`nombre` AS `nombre`,case when `u`.`usuarios` is null then 0 else `u`.`usuarios` end AS `usuarios`,case when `p`.`permisos` is null then 0 else `p`.`permisos` end AS `permisos` from ((`rol` `r` left join (select `rol_usuario`.`rol_id` AS `idRol`,count(0) AS `usuarios` from `rol_usuario` group by `rol_usuario`.`rol_id`) `u` on(`u`.`idRol` = `r`.`id`)) left join (select `rol_permiso`.`rol_id` AS `idRol`,count(0) AS `permisos` from `rol_permiso` group by `rol_permiso`.`rol_id`) `p` on(`p`.`idRol` = `r`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_usuario`
--
DROP TABLE IF EXISTS `vw_usuario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_usuario`  AS  select `u`.`id` AS `id`,`u`.`email` AS `email`,`u`.`nombre` AS `nombreUsuario`,`u`.`metodoLogin` AS `metodoLogin`,`u`.`estado` AS `estado`,`r`.`nombre` AS `nombreRol` from ((`usuario` `u` join `rol_usuario` `ru` on(`ru`.`usuario_id` = `u`.`id`)) join `rol` `r` on(`r`.`id` = `ru`.`rol_id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_largo_UNIQUE` (`nombreLargo`);

--
-- Indices de la tabla `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sector_nombre_UNIQUE` (`sector`,`nombre`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_largo_UNIQUE` (`nombreLargo`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plan_diaSemana_UNIQUE` (`idPlan`,`diaSemana`),
  ADD KEY `fk_clase_aula1_idx` (`idAula`),
  ADD KEY `fk_clase_plan1_idx` (`idPlan`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `llamado`
--
ALTER TABLE `llamado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_llamado_aula1_idx` (`idAula`);

--
-- Indices de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mesa_examen_tribunal1_idx` (`idTribunal`),
  ADD KEY `fk_mesa_examen_llamado1_idx` (`idPrimerLlamado`),
  ADD KEY `fk_mesa_examen_llamado2_idx` (`idSegundoLlamado`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carrera_asignatura_UNIQUE` (`idCarrera`,`idAsignatura`),
  ADD KEY `fk_cursada_carrera1_idx` (`idCarrera`),
  ADD KEY `fk_cursada_asignatura1_idx` (`idAsignatura`),
  ADD KEY `fk_plan_mesa_examen1_idx` (`idMesaExamen`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`rol_id`,`permiso_id`),
  ADD KEY `fk_rol_has_permiso_permiso1_idx` (`permiso_id`),
  ADD KEY `fk_rol_has_permiso_rol1_idx` (`rol_id`);

--
-- Indices de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD PRIMARY KEY (`rol_id`,`usuario_id`),
  ADD KEY `fk_rol_has_usuario_usuario1_idx` (`usuario_id`),
  ADD KEY `fk_rol_has_usuario_rol1_idx` (`rol_id`);

--
-- Indices de la tabla `tribunal`
--
ALTER TABLE `tribunal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tribunal_docente1_idx` (`idPresidente`),
  ADD KEY `fk_tribunal_docente2_idx` (`idVocal1`),
  ADD KEY `fk_tribunal_docente3_idx` (`idVocal2`),
  ADD KEY `fk_tribunal_docente4_idx` (`idSuplente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indices de la tabla `usuario_google`
--
ALTER TABLE `usuario_google`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `fk_usuario_google_usuario1_idx` (`usuario_id`);

--
-- Indices de la tabla `usuario_manual`
--
ALTER TABLE `usuario_manual`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `fk_usuario_manual_usuario1_idx` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aula`
--
ALTER TABLE `aula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `llamado`
--
ALTER TABLE `llamado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plan`
--
ALTER TABLE `plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tribunal`
--
ALTER TABLE `tribunal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clase`
--
ALTER TABLE `clase`
  ADD CONSTRAINT `fk_clase_aula1` FOREIGN KEY (`idAula`) REFERENCES `aula` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_clase_plan1` FOREIGN KEY (`idPlan`) REFERENCES `plan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `llamado`
--
ALTER TABLE `llamado`
  ADD CONSTRAINT `fk_llamado_aula1` FOREIGN KEY (`idAula`) REFERENCES `aula` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD CONSTRAINT `fk_mesa_examen_llamado1` FOREIGN KEY (`idPrimerLlamado`) REFERENCES `llamado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mesa_examen_llamado2` FOREIGN KEY (`idSegundoLlamado`) REFERENCES `llamado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mesa_examen_tribunal1` FOREIGN KEY (`idTribunal`) REFERENCES `tribunal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `plan`
--
ALTER TABLE `plan`
  ADD CONSTRAINT `fk_cursada_asignatura1` FOREIGN KEY (`idAsignatura`) REFERENCES `asignatura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cursada_carrera1` FOREIGN KEY (`idCarrera`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_plan_mesa_examen1` FOREIGN KEY (`idMesaExamen`) REFERENCES `mesa_examen` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `fk_rol_has_permiso_permiso1` FOREIGN KEY (`permiso_id`) REFERENCES `permiso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rol_has_permiso_rol1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD CONSTRAINT `fk_rol_has_usuario_rol1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rol_has_usuario_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tribunal`
--
ALTER TABLE `tribunal`
  ADD CONSTRAINT `fk_tribunal_docente1` FOREIGN KEY (`idPresidente`) REFERENCES `docente` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tribunal_docente2` FOREIGN KEY (`idVocal1`) REFERENCES `docente` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `fk_tribunal_docente3` FOREIGN KEY (`idVocal2`) REFERENCES `docente` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `fk_tribunal_docente4` FOREIGN KEY (`idSuplente`) REFERENCES `docente` (`id`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `usuario_google`
--
ALTER TABLE `usuario_google`
  ADD CONSTRAINT `fk_usuario_google_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_manual`
--
ALTER TABLE `usuario_manual`
  ADD CONSTRAINT `fk_usuario_manual_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
