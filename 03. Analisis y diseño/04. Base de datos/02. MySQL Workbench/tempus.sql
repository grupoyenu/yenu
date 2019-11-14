-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2019 a las 03:14:57
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `idasignatura` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`idasignatura`, `nombre`) VALUES
(77, ''),
(103, ' Gestion De La Calidad'),
(81, 'Analisis'),
(82, 'Analisis Matematico 3'),
(1, 'Análisis Matematico I'),
(37, 'Analisis Politico Y Org. Del Sist. Educ.'),
(142, 'Analisis Politico Y Org. Del Sistema Educativa'),
(6, 'Análisis Y Diseño Del Software'),
(18, 'Análisis Y Producción Del Discurso'),
(36, 'Antropologia Sociocultural'),
(38, 'Aprendizaje'),
(127, 'Arquitectura De Las Computadoras'),
(90, 'Asignatura 1'),
(91, 'Asignatura 2'),
(92, 'Asignatura 3'),
(93, 'Asignatura 4'),
(94, 'Asignatura 5'),
(95, 'Asignatura 6'),
(87, 'Asignatura I'),
(88, 'Asignatura Ii'),
(89, 'Asignatura Iii'),
(138, 'Asignatura Nueva '),
(137, 'Asignatura Telefe'),
(99, 'Aspectos Politicos Y Socioeconomicos Del Turismo'),
(128, 'Aspectos Profesionales'),
(5, 'Base De Datos'),
(129, 'Bases De Datos'),
(58, 'Biogeografia'),
(7, 'C.u.s'),
(55, 'Cartografia'),
(140, 'Ciencia Universidad Y Sociedad'),
(33, 'Ciencias Biologicas'),
(57, 'Climatologia'),
(21, 'Conservación De Sitios Culturales Arqueologicos Y Paleontologicos'),
(105, 'Costos'),
(112, 'Demografia Y Politica De  La Poblacion'),
(28, 'Deontologica Prof. I'),
(115, 'Desarrollo Local Y Economia Social'),
(125, 'Didactica Especial De La Geografia'),
(123, 'Didactica Especial De La Historia'),
(65, 'Economia General'),
(104, 'Economia Ii'),
(30, 'Enf. En La At. Del Adulto Y El Anciano'),
(29, 'Enfermeria Basica'),
(32, 'Enfermeria En La At. Del Niño Y Del Adolescente'),
(31, 'Enfermeria En Salud Mental Y Psiquiatrica'),
(79, 'Estadistica'),
(13, 'Estadistica I'),
(68, 'Estadisticas Para Cs. Sociales'),
(9, 'Estructura De Datos'),
(63, 'Formulacion Y Evaluacion De Proyectos'),
(24, 'Formulacion Y Evaluación De Proyectos Turisticos'),
(78, 'Fundamentos De Ciencias De La Computacion'),
(14, 'Fundamentos Y Lenguaje De Programación'),
(16, 'Geografía'),
(52, 'Geografia De La Poblacion'),
(71, 'Geografia Economica Y Politica '),
(53, 'Geografia Regional Argentina'),
(73, 'Geografia Rural'),
(74, 'Geografia Urbana'),
(67, 'Geomorfologia'),
(132, 'Gestion De Organizaciones'),
(11, 'Gestión De Proyectos De Software'),
(25, 'Gestión Y Administración De Empresas Turisticas'),
(27, 'Herramientas De Informatica'),
(83, 'herramientas de microsoft'),
(75, 'Hidrografia'),
(145, 'Historia De La Lengua'),
(76, 'Historia Social General '),
(109, 'Historia Social Latino Americana Y Argentina'),
(45, 'Idioma Moderno Frances'),
(34, 'Idioma Moderno Ingles'),
(15, 'Inglés I'),
(102, 'Ingles Ii'),
(19, 'Inglés Iii'),
(113, 'Instituciones Y Organizaciones'),
(117, 'Instrumentos De Intervencion I '),
(118, 'Instrumentos De Intervencion Ii'),
(134, 'Inteligencia Artificial'),
(136, 'Interpretes Y Compiladores'),
(101, 'Introduccion A La  Economia'),
(35, 'Introduccion A La Administracion'),
(51, 'Introduccion A La Geografia'),
(12, 'Laboratorio De Desarrollo De Software'),
(130, 'Laboratorio De Programacion'),
(39, 'Lengua Y Cultura Latinas I'),
(141, 'Lengua Y Cultura Latinas Ii'),
(47, 'Literatura Argentina I'),
(48, 'Literatura Argentina Ii'),
(43, 'Literatura De Masas'),
(49, 'Literatura Española I'),
(50, 'Literatura Española Ii'),
(46, 'Literatura Francesa'),
(139, 'Literatura Griega I'),
(44, 'Literatura Inglesa Y Norteamericana'),
(40, 'Literatura Latinoamericana I'),
(41, 'Literatura Latinoamericana Ii'),
(62, 'Matematica Aplicada'),
(2, 'Matemática Discreta'),
(85, 'Materia 1'),
(86, 'Materia 2'),
(110, 'Metodologia De La Investigacion Ii'),
(72, 'Metodologia Investig. Geografia'),
(61, 'Ordenamiento Del Territorio Y Planeamiento Regional Y Urbano'),
(3, 'Organización De Las Computadoras'),
(124, 'P. Culturales Comparados En La Prehistoria'),
(66, 'Patrimonio Natural Y Cultural'),
(84, 'Perro'),
(107, 'Planificacion Ii'),
(22, 'Politica Del Turismo'),
(119, 'Politicas Sociales'),
(26, 'Práctica Ii'),
(20, 'Práctica Profesional I'),
(56, 'Problematica Ambiental Y Desarrollo Sustentable'),
(17, 'Procesos Históricos'),
(126, 'Produccion Ovina'),
(4, 'Resolución De Problemas Y Algoritmos'),
(122, 'Seminario De Gestion De Las Organizaciones '),
(69, 'Seminario De Integracion Geografia De La Patagonia'),
(106, 'Seminario De Lic I'),
(42, 'Seminario De Literatura'),
(133, 'Seminario De Programacion'),
(135, 'Seminario De Redes Y De Datos'),
(143, 'Seminario De Teoria Literaria'),
(120, 'Seminario La Familia En La Dinamica Social'),
(111, 'Seminario Psicologia Social Avanzada '),
(114, 'Seminario Y Tutoria De Tesina'),
(54, 'Sistemas De  Informacion Territorial'),
(8, 'Sistemas Operativos'),
(10, 'Sistemas Operativos Distribuidos'),
(100, 'Sociologia'),
(121, 'Sujeto Psicosocial Y Desarrollo Humano'),
(98, 'Taller De Escritura'),
(144, 'Taller De Practica Docente'),
(64, 'Teledeteccion'),
(70, 'Teoria De La Geografia'),
(116, 'Teoria De La Intervencion Social'),
(108, 'Teoria Politica'),
(23, 'Teoria Turistica'),
(60, 'Territorios Geograficos De America'),
(59, 'Territorios Geograficos Mundiales'),
(96, 'Toshiba'),
(97, 'Toshiba 2'),
(131, 'Validacion Y Verificacion De Software');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura_carrera`
--

CREATE TABLE `asignatura_carrera` (
  `idasignatura` int(11) NOT NULL COMMENT 'Clave foranea a Asignatura.',
  `idcarrera` int(3) NOT NULL,
  `anio` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asignatura_carrera`
--

INSERT INTO `asignatura_carrera` (`idasignatura`, `idcarrera`, `anio`) VALUES
(9, 72, 2),
(11, 16, 3),
(11, 72, 3),
(18, 1, 1),
(18, 60, 1),
(38, 1, 1),
(41, 1, 1),
(41, 60, 3),
(42, 1, 1),
(42, 60, 4),
(46, 1, 1),
(46, 60, 2),
(47, 1, 1),
(47, 60, 3),
(98, 1, 1),
(98, 60, 1),
(127, 16, 1),
(127, 72, 1),
(128, 72, 1),
(129, 72, 1),
(130, 16, 1),
(130, 72, 1),
(131, 72, 1),
(132, 72, 1),
(133, 72, 1),
(134, 72, 1),
(135, 72, 1),
(136, 72, 1),
(139, 1, 1),
(139, 60, 1),
(140, 1, 1),
(140, 60, 1),
(141, 1, 2),
(141, 60, 2),
(142, 1, 3),
(143, 1, 3),
(143, 60, 3),
(144, 1, 4),
(145, 1, 4),
(145, 60, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

CREATE TABLE `aula` (
  `idaula` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `sector` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `aula`
--

INSERT INTO `aula` (`idaula`, `nombre`, `sector`) VALUES
(23, '', 'A'),
(2, '1', 'A'),
(85, '1', 'B'),
(3, '10', 'A'),
(60, '10', 'E'),
(20, '10', 'K'),
(21, '11', 'A'),
(5, '11', 'E'),
(16, '12', 'A'),
(109, '13', 'E'),
(63, '14', 'A'),
(18, '17', 'D'),
(8, '2', 'A'),
(69, '2', 'B'),
(17, '2', 'D'),
(19, '2', 'E'),
(1, '3', 'A'),
(79, '3', 'B'),
(57, '3', 'E'),
(7, '4', 'A'),
(59, '4', 'E'),
(45, '434', 'A'),
(11, '5', 'A'),
(13, '5', 'E'),
(46, '543', 'A'),
(49, '543', 'X'),
(50, '5444', 'X'),
(52, '545', 'X'),
(6, '6', 'A'),
(14, '6', 'D'),
(15, '6', 'E'),
(9, '7', 'A'),
(12, '7', 'E'),
(10, '8', 'A'),
(56, '8', 'E'),
(4, '9', 'E'),
(42, 'Almodobars', 'B'),
(32, 'Ana', 'A'),
(31, 'Ana', 'X'),
(35, 'Colaborador', 'X'),
(41, 'Energon', 'A'),
(26, 'Laboratorio De Fisica', 'Z'),
(25, 'Laboratorio De Hardware ', 'X'),
(29, 'Laboratorio De Hardware 5', 'A'),
(30, 'Laboratorio De Hardware 6', 'A'),
(28, 'Laboratorio De ProgramaciÃ³n 5', 'A'),
(34, 'Laboratorio De QuÃ­mica', 'X'),
(22, 'Laboratorio De Software', 'X'),
(24, 'Laboratorio De Software 6', 'A'),
(54, 'Naranja', 'A'),
(53, 'Nueva', 'A'),
(40, 'PeÃ±a Morfi', 'C'),
(33, 'Sa', 'A'),
(84, 'Srd', 'A'),
(39, 'Woody', 'A'),
(38, 'Woody', 'X'),
(44, 'X10', 'X'),
(43, 'X9', 'X'),
(37, 'Zoom', 'A'),
(27, 'Zoom', 'H'),
(36, 'Zoom', 'Z');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `codigo` int(3) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`codigo`, `nombre`) VALUES
(1, ' Profesorado En Letras'),
(16, 'Analista De Sistemas'),
(46, 'Enf. Universitaria'),
(89, 'Flora y Fauna'),
(99, 'Ingenierã­a Civil'),
(23, 'Ingenieria En Recursos  Naturales Renovables'),
(43, 'Ingenieria En Telefe'),
(54, 'Ingenieria En Trece'),
(100, 'Intratables'),
(101, 'Intratabless'),
(74, 'Licenciarura En Trabajo Social'),
(76, 'Licenciatura En Cursadas'),
(60, 'Licenciatura En Letras '),
(75, 'Licenciatura En Mesas'),
(72, 'Licenciatura En Sistemas'),
(61, 'Licenciatura En Turismo'),
(86, 'Maestria En Cursadas'),
(85, 'Maestria En Mesas'),
(564, 'profesorado'),
(914, 'Profesorado En Economia Y Gestion De Organizaciones'),
(3, 'Profesorado En Historia'),
(87, 'Profesorado en informÃ¡tica'),
(4, 'Profesorado Geografía'),
(88, 'tecnicatura en informatica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `idclase` int(11) NOT NULL,
  `dia` enum('1','2','3','4','5') NOT NULL DEFAULT '1' COMMENT '1. Lunes\n2. Martes\n3. Miercoles\n4. Jueves\n5. Viernes\n6. Sabado',
  `desde` time NOT NULL,
  `hasta` time NOT NULL,
  `idaula` int(11) DEFAULT NULL,
  `fechamod` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`idclase`, `dia`, `desde`, `hasta`, `idaula`, `fechamod`) VALUES
(128, '1', '14:00:00', '16:00:00', 3, NULL),
(129, '3', '14:00:00', '16:00:00', 56, NULL),
(130, '4', '17:00:00', '19:00:00', 57, NULL),
(131, '1', '16:00:00', '18:00:00', 1, NULL),
(132, '1', '19:00:00', '21:00:00', 59, NULL),
(133, '2', '20:00:00', '22:00:00', 60, NULL),
(134, '2', '16:00:00', '18:00:00', 1, NULL),
(135, '5', '15:00:00', '17:00:00', 2, NULL),
(136, '1', '16:00:00', '19:00:00', 16, NULL),
(137, '3', '15:00:00', '18:00:00', 69, NULL),
(138, '1', '16:00:00', '21:00:00', 59, NULL),
(139, '2', '17:00:00', '20:00:00', 56, NULL),
(140, '4', '18:00:00', '21:00:00', 59, NULL),
(141, '5', '13:00:00', '17:00:00', 21, NULL),
(142, '1', '15:00:00', '18:00:00', 5, NULL),
(143, '3', '15:00:00', '18:00:00', 5, NULL),
(144, '2', '18:00:00', '21:00:00', 79, NULL),
(145, '3', '18:00:00', '21:00:00', 5, NULL),
(146, '1', '10:00:00', '13:00:00', 8, NULL),
(147, '4', '17:00:00', '20:00:00', 16, NULL),
(148, '4', '20:00:00', '22:00:00', 15, NULL),
(149, '1', '15:00:00', '18:00:00', 84, NULL),
(150, '3', '15:00:00', '18:00:00', 85, NULL),
(151, '2', '15:00:00', '18:00:00', 13, NULL),
(152, '5', '15:00:00', '18:00:00', 14, NULL),
(153, '4', '18:00:00', '21:00:00', 14, NULL),
(154, '4', '17:00:00', '19:00:00', 109, NULL),
(155, '2', '15:00:00', '18:00:00', 5, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursada`
--

CREATE TABLE `cursada` (
  `idasignatura` int(11) NOT NULL COMMENT 'Clave foranea a la relacion "Asignatura-Carrera"',
  `idcarrera` int(3) NOT NULL COMMENT 'Clave foranea a la relacion "Asignatura-Carrera"',
  `idclase` int(11) NOT NULL COMMENT 'Clabe foranea a "Clase".'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cursada`
--

INSERT INTO `cursada` (`idasignatura`, `idcarrera`, `idclase`) VALUES
(18, 1, 131),
(18, 60, 131),
(38, 1, 141),
(41, 1, 144),
(41, 1, 145),
(41, 60, 144),
(41, 60, 145),
(42, 1, 153),
(42, 60, 153),
(46, 1, 136),
(46, 1, 137),
(46, 60, 136),
(46, 60, 137),
(47, 1, 142),
(47, 1, 143),
(47, 60, 142),
(47, 60, 143),
(98, 1, 132),
(98, 1, 133),
(98, 60, 132),
(98, 60, 133),
(139, 1, 128),
(139, 1, 129),
(139, 1, 130),
(139, 60, 128),
(139, 60, 129),
(139, 60, 130),
(140, 1, 134),
(140, 1, 135),
(140, 60, 134),
(140, 60, 135),
(141, 1, 139),
(141, 1, 140),
(141, 60, 139),
(141, 60, 140),
(142, 1, 146),
(142, 1, 147),
(143, 1, 148),
(143, 60, 154),
(144, 1, 149),
(144, 1, 150),
(145, 1, 151),
(145, 1, 152),
(145, 60, 152),
(145, 60, 155);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `iddocente` int(11) NOT NULL COMMENT 'Clave primaria.',
  `nombre` varchar(255) NOT NULL COMMENT 'APELLIDO, NOMBRE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`iddocente`, `nombre`) VALUES
(8, 'Altamirano Walter'),
(20, 'Alvarez Alejandra'),
(4, 'Amarilla Carlos'),
(23, 'Casas Sandra'),
(22, 'Climis Jorge'),
(13, 'Dos Santos Eder'),
(15, 'Enriquez Juan'),
(6, 'Gesto Esteban'),
(3, 'Gonzalez C.'),
(10, 'Gonzalez Daniel'),
(7, 'Gonzalez Leonardo'),
(19, 'Hallar Karim'),
(26, 'Herlein'),
(16, 'Herrera Franco'),
(24, 'Ivanissevich'),
(17, 'Laguia Daniel'),
(25, 'Livacic'),
(18, 'Millado Paula'),
(21, 'Oyarzo Laura'),
(9, 'Reinaga Hector'),
(12, 'Saldivia Claudio'),
(14, 'Sofia Osiris'),
(5, 'Soto Hector'),
(1, 'Talay Carlos'),
(11, 'Vidal Graciela'),
(2, 'Zhielke M.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamado`
--

CREATE TABLE `llamado` (
  `idllamado` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `idaula` int(11) DEFAULT NULL,
  `fechamod` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `llamado`
--

INSERT INTO `llamado` (`idllamado`, `fecha`, `hora`, `idaula`, `fechamod`) VALUES
(1, '2019-10-25', '16:00:00', NULL, NULL),
(5, '2019-10-25', '16:00:00', NULL, NULL),
(8, '2019-10-29', '16:00:00', NULL, NULL),
(9, '2019-10-25', '16:00:00', NULL, NULL),
(10, '2019-11-10', '21:00:00', NULL, '2019-11-10 15:23:50'),
(11, '2019-11-10', '10:00:00', NULL, '2019-11-10 15:24:15'),
(12, '2019-11-10', '10:00:00', NULL, '2019-11-10 15:25:15'),
(13, '2019-11-10', '16:00:00', 49, '2019-11-10 17:27:13'),
(14, '2019-10-31', '16:00:00', NULL, NULL),
(15, '2019-10-29', '16:00:00', NULL, NULL),
(16, '2019-10-29', '16:00:00', NULL, NULL),
(17, '2019-10-25', '17:00:00', NULL, NULL),
(18, '2019-10-25', '17:00:00', NULL, NULL),
(19, '2019-10-25', '16:00:00', NULL, NULL),
(20, '2019-10-25', '18:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_examen`
--

CREATE TABLE `mesa_examen` (
  `idmesa` int(11) NOT NULL,
  `idasignatura` int(11) NOT NULL,
  `idcarrera` int(3) NOT NULL,
  `idtribunal` int(11) NOT NULL,
  `primero` int(11) DEFAULT NULL,
  `segundo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mesa_examen`
--

INSERT INTO `mesa_examen` (`idmesa`, `idasignatura`, `idcarrera`, `idtribunal`, `primero`, `segundo`) VALUES
(1, 127, 16, 1, 1, NULL),
(5, 130, 16, 5, 5, NULL),
(8, 11, 16, 8, 8, NULL),
(9, 127, 72, 1, 9, NULL),
(10, 128, 72, 2, 10, NULL),
(11, 9, 72, 3, 11, NULL),
(12, 129, 72, 4, 12, NULL),
(13, 130, 72, 5, 13, NULL),
(14, 131, 72, 6, 14, NULL),
(15, 132, 72, 9, 15, NULL),
(16, 11, 72, 8, 16, NULL),
(17, 133, 72, 10, 17, NULL),
(18, 134, 72, 11, 18, NULL),
(19, 135, 72, 12, 19, NULL),
(20, 136, 72, 13, 20, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Cursadas'),
(2, 'Mesas'),
(3, 'Aulas'),
(4, 'CREAR MESA EXAMEN'),
(5, 'Planes'),
(6, 'Usuarios'),
(7, 'Roles'),
(8, 'Permisos'),
(9, 'Colaborador'),
(11, 'Permiso'),
(12, 'Permiso De Prueba'),
(13, 'WOODY'),
(16, 'PASAPALABRA'),
(23, 'TELEFE'),
(26, 'PRESI'),
(28, 'PRESO'),
(31, 'NUEVODE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'SECRETARIA ACADEMICA'),
(3, 'Colaborador Academico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

CREATE TABLE `rol_permiso` (
  `idrol` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol_permiso`
--

INSERT INTO `rol_permiso` (`idrol`, `idpermiso`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(3, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tribunal`
--

CREATE TABLE `tribunal` (
  `idtribunal` int(11) NOT NULL,
  `presidente` int(11) NOT NULL,
  `vocal1` int(11) NOT NULL,
  `vocal2` int(11) DEFAULT NULL,
  `suplente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tribunal`
--

INSERT INTO `tribunal` (`idtribunal`, `presidente`, `vocal1`, `vocal2`, `suplente`) VALUES
(1, 1, 2, 3, 4),
(2, 5, 6, 7, 8),
(3, 9, 10, 11, 12),
(4, 8, 13, 14, 7),
(5, 9, 10, 15, NULL),
(6, 17, 18, 19, 14),
(8, 14, 22, 7, 19),
(9, 20, 21, 6, NULL),
(10, 15, 23, NULL, NULL),
(11, 24, 18, 14, NULL),
(12, 1, 25, 26, 2),
(13, 23, 9, 10, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `metodologin` varchar(25) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `email`, `nombre`, `metodologin`, `estado`) VALUES
(1, 'marquez.emanuel.alberto@gmail.com', 'Marquez Emanuel', 'Google', 'Activo'),
(7, 'vela-note@hotmail.com', 'Emanuel Marquez', 'Google', 'Activo'),
(9, 'rooo_huaiquil@hotmail.com', 'Roxana Huaiquil', 'Manual', 'Activo'),
(11, 'marquez.emanuel@hotmail.com', 'Marquez Jose Alberto', 'Google', 'Activo'),
(12, 'marquez.emanuel@yahoo.com', 'Marquez Jose Albert', 'Manual', 'Activo'),
(14, 'sebaveron@yahoo.com', 'Sebastian Veron', 'Manual', 'Activo'),
(15, 'sabalero@yahoo.com', 'Sebastian Marino', 'Manual', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_google`
--

CREATE TABLE `usuario_google` (
  `idusuario` int(11) NOT NULL,
  `googleid` varchar(255) NOT NULL,
  `imagen` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_google`
--

INSERT INTO `usuario_google` (`idusuario`, `googleid`, `imagen`) VALUES
(1, '109779500300491816517', 'https://lh5.googleusercontent.com/-yb9VbtreRlk/AAAAAAAAAAI/AAAAAAAAAXU/pqJBseRq3Lo/s96-c/photo.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_manual`
--

CREATE TABLE `usuario_manual` (
  `idusuario` int(11) NOT NULL,
  `clave` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_manual`
--

INSERT INTO `usuario_manual` (`idusuario`, `clave`) VALUES
(12, '12345'),
(14, '12345'),
(15, '12345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `idusuario` int(11) NOT NULL,
  `idrol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`idusuario`, `idrol`) VALUES
(1, 1),
(7, 1),
(9, 2);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_aulas`
--
CREATE TABLE `vista_aulas` (
`idCarrera` int(3)
,`nombreCarrera` varchar(255)
,`idAsignatura` int(11)
,`nombreAsignatura` varchar(255)
,`idclase` int(11)
,`dia` enum('1','2','3','4','5')
,`desde` varchar(10)
,`hasta` varchar(10)
,`idaula` int(11)
,`fechamod` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_aulascursadas`
--
CREATE TABLE `vista_aulascursadas` (
`idCarrera` int(3)
,`nombreCarrera` varchar(255)
,`idAsignatura` int(11)
,`nombreAsignatura` varchar(255)
,`idClase` int(11)
,`numeroDia` enum('1','2','3','4','5')
,`nombreDia` varchar(9)
,`desde` varchar(10)
,`hasta` varchar(10)
,`idAula` int(11)
,`sector` varchar(1)
,`nombreAula` varchar(255)
,`fechaMod` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_clases`
--
CREATE TABLE `vista_clases` (
`idCarrera` int(3)
,`idAsignatura` int(11)
,`idClase` int(11)
,`dia` enum('1','2','3','4','5')
,`desde` time
,`hasta` time
,`idAula` int(11)
,`sector` varchar(1)
,`aula` varchar(255)
,`fechaMod` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_cursadas`
--
CREATE TABLE `vista_cursadas` (
`idCarrera` int(3)
,`nombreCarrera` varchar(255)
,`idAsignatura` int(11)
,`nombreAsignatura` varchar(255)
,`anio` int(1)
,`idClase1` int(11)
,`desde1` varchar(10)
,`hasta1` varchar(10)
,`idAula1` int(11)
,`sector1` varchar(1)
,`aula1` varchar(255)
,`fechaMod1` datetime
,`idClase2` int(11)
,`desde2` time
,`hasta2` time
,`idAula2` int(11)
,`sector2` varchar(1)
,`aula2` varchar(255)
,`fechaMod2` datetime
,`idClase3` int(11)
,`desde3` time
,`hasta3` time
,`idAula3` int(11)
,`sector3` varchar(1)
,`aula3` varchar(255)
,`fechaMod3` datetime
,`idClase4` int(11)
,`desde4` time
,`hasta4` time
,`idAula4` int(11)
,`sector4` varchar(1)
,`aula4` varchar(255)
,`fechaMod4` datetime
,`idClase5` int(11)
,`desde5` time
,`hasta5` time
,`idAula5` int(11)
,`sector5` varchar(1)
,`aula5` varchar(255)
,`fechaMod5` datetime
,`idClase6` int(11)
,`desde6` time
,`hasta6` time
,`idAula6` int(11)
,`sector6` varchar(1)
,`aula6` varchar(255)
,`fechaMod6` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_mesas`
--
CREATE TABLE `vista_mesas` (
`idmesa` int(11)
,`idasignatura` int(11)
,`nombreAsignatura` varchar(255)
,`codigoCarrera` int(3)
,`nombreCarrera` varchar(255)
,`idtribunal` int(11)
,`idPresidente` int(11)
,`nombrePresidente` varchar(255)
,`idVocalPri` int(11)
,`nombreVocalPri` varchar(255)
,`idVocalSeg` int(11)
,`nombreVocalSeg` varchar(255)
,`idSuplente` int(11)
,`nombreSuplente` varchar(255)
,`idLlamadoPri` int(11)
,`fechaPri` date
,`horaPri` time
,`idAulaPri` int(11)
,`sectorPri` varchar(1)
,`aulaPri` varchar(255)
,`fechaModPri` datetime
,`idLlamadoSeg` int(11)
,`fechaSeg` date
,`horaSeg` time
,`idAulaSeg` int(11)
,`sectorSeg` varchar(1)
,`aulaSeg` varchar(255)
,`fechaModSeg` datetime
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarios`
--
CREATE TABLE `vista_usuarios` (
`idUsuario` int(11)
,`email` varchar(255)
,`nombreUsuario` varchar(255)
,`metodo` varchar(25)
,`estado` enum('Activo','Inactivo')
,`idRol` int(11)
,`nombreRol` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_aulas`
--
DROP TABLE IF EXISTS `vista_aulas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_aulas`  AS  select `car`.`codigo` AS `idCarrera`,`car`.`nombre` AS `nombreCarrera`,`asi`.`idasignatura` AS `idAsignatura`,`asi`.`nombre` AS `nombreAsignatura`,`cla`.`idclase` AS `idclase`,`cla`.`dia` AS `dia`,date_format(`cla`.`desde`,'%H:%i') AS `desde`,date_format(`cla`.`hasta`,'%H:%i') AS `hasta`,`cla`.`idaula` AS `idaula`,`cla`.`fechamod` AS `fechamod` from (((`cursada` `cur` join `carrera` `car` on((`car`.`codigo` = `cur`.`idcarrera`))) join `asignatura` `asi` on((`asi`.`idasignatura` = `cur`.`idasignatura`))) join `clase` `cla` on((`cla`.`idclase` = `cur`.`idclase`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_aulascursadas`
--
DROP TABLE IF EXISTS `vista_aulascursadas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_aulascursadas`  AS  select `car`.`codigo` AS `idCarrera`,`car`.`nombre` AS `nombreCarrera`,`asi`.`idasignatura` AS `idAsignatura`,`asi`.`nombre` AS `nombreAsignatura`,`cla`.`idclase` AS `idClase`,`cla`.`dia` AS `numeroDia`,(case when (`cla`.`dia` = 1) then 'Lunes' when (`cla`.`dia` = 2) then 'Martes' when (`cla`.`dia` = 3) then 'Miercoles' when (`cla`.`dia` = 4) then 'Jueves' when (`cla`.`dia` = 5) then 'Viernes' when (`cla`.`dia` = 6) then 'Sábado' end) AS `nombreDia`,date_format(`cla`.`desde`,'%H:%i') AS `desde`,date_format(`cla`.`hasta`,'%H:%i') AS `hasta`,`cla`.`idaula` AS `idAula`,`aul`.`sector` AS `sector`,`aul`.`nombre` AS `nombreAula`,`cla`.`fechamod` AS `fechaMod` from ((((`cursada` `cur` join `carrera` `car` on((`car`.`codigo` = `cur`.`idcarrera`))) join `asignatura` `asi` on((`asi`.`idasignatura` = `cur`.`idasignatura`))) join `clase` `cla` on((`cla`.`idclase` = `cur`.`idclase`))) join `aula` `aul` on((`cla`.`idaula` = `aul`.`idaula`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_clases`
--
DROP TABLE IF EXISTS `vista_clases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_clases`  AS  select `cur`.`idcarrera` AS `idCarrera`,`cur`.`idasignatura` AS `idAsignatura`,`cla`.`idclase` AS `idClase`,`cla`.`dia` AS `dia`,`cla`.`desde` AS `desde`,`cla`.`hasta` AS `hasta`,`cla`.`idaula` AS `idAula`,`aul`.`sector` AS `sector`,`aul`.`nombre` AS `aula`,`cla`.`fechamod` AS `fechaMod` from ((`cursada` `cur` join `clase` `cla` on((`cla`.`idclase` = `cur`.`idclase`))) join `aula` `aul` on((`aul`.`idaula` = `cla`.`idaula`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_cursadas`
--
DROP TABLE IF EXISTS `vista_cursadas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_cursadas`  AS  select `car`.`codigo` AS `idCarrera`,`car`.`nombre` AS `nombreCarrera`,`asi`.`idasignatura` AS `idAsignatura`,`asi`.`nombre` AS `nombreAsignatura`,`rel`.`anio` AS `anio`,`lun`.`idClase` AS `idClase1`,date_format(`lun`.`desde`,'%H:%i') AS `desde1`,date_format(`lun`.`hasta`,'%H:%i') AS `hasta1`,`lun`.`idAula` AS `idAula1`,`lun`.`sector` AS `sector1`,`lun`.`aula` AS `aula1`,`lun`.`fechaMod` AS `fechaMod1`,`mar`.`idClase` AS `idClase2`,`mar`.`desde` AS `desde2`,`mar`.`hasta` AS `hasta2`,`mar`.`idAula` AS `idAula2`,`mar`.`sector` AS `sector2`,`mar`.`aula` AS `aula2`,`mar`.`fechaMod` AS `fechaMod2`,`mie`.`idClase` AS `idClase3`,`mie`.`desde` AS `desde3`,`mie`.`hasta` AS `hasta3`,`mie`.`idAula` AS `idAula3`,`mie`.`sector` AS `sector3`,`mie`.`aula` AS `aula3`,`mie`.`fechaMod` AS `fechaMod3`,`jue`.`idClase` AS `idClase4`,`jue`.`desde` AS `desde4`,`jue`.`hasta` AS `hasta4`,`jue`.`idAula` AS `idAula4`,`jue`.`sector` AS `sector4`,`jue`.`aula` AS `aula4`,`jue`.`fechaMod` AS `fechaMod4`,`vie`.`idClase` AS `idClase5`,`vie`.`desde` AS `desde5`,`vie`.`hasta` AS `hasta5`,`vie`.`idAula` AS `idAula5`,`vie`.`sector` AS `sector5`,`vie`.`aula` AS `aula5`,`vie`.`fechaMod` AS `fechaMod5`,`sab`.`idClase` AS `idClase6`,`sab`.`desde` AS `desde6`,`sab`.`hasta` AS `hasta6`,`sab`.`idAula` AS `idAula6`,`sab`.`sector` AS `sector6`,`sab`.`aula` AS `aula6`,`sab`.`fechaMod` AS `fechaMod6` from ((((((((`asignatura_carrera` `rel` join `carrera` `car` on((`car`.`codigo` = `rel`.`idcarrera`))) join `asignatura` `asi` on((`asi`.`idasignatura` = `rel`.`idasignatura`))) left join `vista_clases` `lun` on(((`lun`.`idCarrera` = `rel`.`idcarrera`) and (`lun`.`idAsignatura` = `rel`.`idasignatura`) and (`lun`.`dia` = 1)))) left join `vista_clases` `mar` on(((`mar`.`idCarrera` = `rel`.`idcarrera`) and (`mar`.`idAsignatura` = `rel`.`idasignatura`) and (`mar`.`dia` = 2)))) left join `vista_clases` `mie` on(((`mie`.`idCarrera` = `rel`.`idcarrera`) and (`mie`.`idAsignatura` = `rel`.`idasignatura`) and (`mie`.`dia` = 3)))) left join `vista_clases` `jue` on(((`jue`.`idCarrera` = `rel`.`idcarrera`) and (`jue`.`idAsignatura` = `rel`.`idasignatura`) and (`jue`.`dia` = 4)))) left join `vista_clases` `vie` on(((`vie`.`idCarrera` = `rel`.`idcarrera`) and (`vie`.`idAsignatura` = `rel`.`idasignatura`) and (`vie`.`dia` = 5)))) left join `vista_clases` `sab` on(((`sab`.`idCarrera` = `rel`.`idcarrera`) and (`sab`.`idAsignatura` = `rel`.`idasignatura`) and (`sab`.`dia` = 6)))) where ((`lun`.`idClase` is not null) or (`mar`.`idClase` is not null) or (`mie`.`idClase` is not null) or (`jue`.`idClase` is not null) or (`vie`.`idClase` is not null) or (`sab`.`idClase` is not null)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_mesas`
--
DROP TABLE IF EXISTS `vista_mesas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_mesas`  AS  select `mes`.`idmesa` AS `idmesa`,`asi`.`idasignatura` AS `idasignatura`,`asi`.`nombre` AS `nombreAsignatura`,`car`.`codigo` AS `codigoCarrera`,`car`.`nombre` AS `nombreCarrera`,`tri`.`idtribunal` AS `idtribunal`,`tri`.`presidente` AS `idPresidente`,`pre`.`nombre` AS `nombrePresidente`,`tri`.`vocal1` AS `idVocalPri`,`vop`.`nombre` AS `nombreVocalPri`,`tri`.`vocal2` AS `idVocalSeg`,`vos`.`nombre` AS `nombreVocalSeg`,`tri`.`suplente` AS `idSuplente`,`sup`.`nombre` AS `nombreSuplente`,`pri`.`idllamado` AS `idLlamadoPri`,`pri`.`fecha` AS `fechaPri`,`pri`.`hora` AS `horaPri`,`pri`.`idaula` AS `idAulaPri`,`aup`.`sector` AS `sectorPri`,`aup`.`nombre` AS `aulaPri`,`pri`.`fechamod` AS `fechaModPri`,`seg`.`idllamado` AS `idLlamadoSeg`,`seg`.`fecha` AS `fechaSeg`,`seg`.`hora` AS `horaSeg`,`seg`.`idaula` AS `idAulaSeg`,`aus`.`sector` AS `sectorSeg`,`aus`.`nombre` AS `aulaSeg`,`seg`.`fechamod` AS `fechaModSeg` from (((((((((((`mesa_examen` `mes` join `asignatura` `asi` on((`asi`.`idasignatura` = `mes`.`idasignatura`))) join `carrera` `car` on((`car`.`codigo` = `mes`.`idcarrera`))) join `tribunal` `tri` on((`tri`.`idtribunal` = `mes`.`idtribunal`))) left join `llamado` `pri` on((`pri`.`idllamado` = `mes`.`primero`))) left join `llamado` `seg` on((`seg`.`idllamado` = `mes`.`segundo`))) join `docente` `pre` on((`pre`.`iddocente` = `tri`.`presidente`))) join `docente` `vop` on((`vop`.`iddocente` = `tri`.`vocal1`))) left join `docente` `vos` on((`vos`.`iddocente` = `tri`.`vocal2`))) left join `docente` `sup` on((`sup`.`iddocente` = `tri`.`suplente`))) left join `aula` `aup` on((`aup`.`idaula` = `pri`.`idaula`))) left join `aula` `aus` on((`aus`.`idaula` = `seg`.`idaula`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_usuarios`
--
DROP TABLE IF EXISTS `vista_usuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_usuarios`  AS  select `usu`.`idusuario` AS `idUsuario`,`usu`.`email` AS `email`,`usu`.`nombre` AS `nombreUsuario`,`usu`.`metodologin` AS `metodo`,`usu`.`estado` AS `estado`,`rol`.`idrol` AS `idRol`,`rol`.`nombre` AS `nombreRol` from ((`usuario` `usu` join `usuario_rol` `rel` on((`rel`.`idusuario` = `usu`.`idusuario`))) join `rol` on((`rol`.`idrol` = `rel`.`idrol`))) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`idasignatura`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `asignatura_carrera`
--
ALTER TABLE `asignatura_carrera`
  ADD PRIMARY KEY (`idasignatura`,`idcarrera`),
  ADD KEY `fk_asignatura_has_carrera_carrera1_idx` (`idcarrera`),
  ADD KEY `fk_asignatura_carrera_asignatura1_idx` (`idasignatura`);

--
-- Indices de la tabla `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`idaula`),
  ADD UNIQUE KEY `nombre` (`nombre`,`sector`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`idclase`),
  ADD KEY `fk_clase_aula1_idx` (`idaula`);

--
-- Indices de la tabla `cursada`
--
ALTER TABLE `cursada`
  ADD PRIMARY KEY (`idasignatura`,`idcarrera`,`idclase`),
  ADD KEY `fk_asignatura_carrera_has_clase_clase1_idx` (`idclase`),
  ADD KEY `fk_asignatura_carrera_has_clase_asignatura_carrera1_idx` (`idasignatura`,`idcarrera`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`iddocente`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `llamado`
--
ALTER TABLE `llamado`
  ADD PRIMARY KEY (`idllamado`),
  ADD KEY `fk_llamado_aula1_idx` (`idaula`);

--
-- Indices de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD PRIMARY KEY (`idmesa`),
  ADD UNIQUE KEY `idasignatura` (`idasignatura`,`idcarrera`),
  ADD KEY `fk_mesa_examen_tribunal1_idx` (`idtribunal`),
  ADD KEY `fk_mesa_examen_asignatura_carrera1_idx` (`idasignatura`,`idcarrera`),
  ADD KEY `fk_mesa_examen_llamado1_idx` (`primero`),
  ADD KEY `fk_mesa_examen_llamado2_idx` (`segundo`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`idrol`,`idpermiso`),
  ADD KEY `fk_rol_has_permiso_permiso1_idx` (`idpermiso`),
  ADD KEY `fk_rol_has_permiso_rol1_idx` (`idrol`);

--
-- Indices de la tabla `tribunal`
--
ALTER TABLE `tribunal`
  ADD PRIMARY KEY (`idtribunal`),
  ADD KEY `fk_tribunal_docente1_idx` (`presidente`),
  ADD KEY `fk_tribunal_docente2_idx` (`vocal1`),
  ADD KEY `fk_tribunal_docente3_idx` (`vocal2`),
  ADD KEY `fk_tribunal_docente4_idx` (`suplente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario_UNIQUE` (`idusuario`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `usuario_google`
--
ALTER TABLE `usuario_google`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario_UNIQUE` (`idusuario`);

--
-- Indices de la tabla `usuario_manual`
--
ALTER TABLE `usuario_manual`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario_UNIQUE` (`idusuario`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`idusuario`,`idrol`),
  ADD KEY `fk_usuario_has_rol_rol1_idx` (`idrol`),
  ADD KEY `fk_usuario_has_rol_usuario1_idx` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `idasignatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
--
-- AUTO_INCREMENT de la tabla `aula`
--
ALTER TABLE `aula`
  MODIFY `idaula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;
--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `idclase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `iddocente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria.', AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de la tabla `llamado`
--
ALTER TABLE `llamado`
  MODIFY `idllamado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  MODIFY `idmesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tribunal`
--
ALTER TABLE `tribunal`
  MODIFY `idtribunal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignatura_carrera`
--
ALTER TABLE `asignatura_carrera`
  ADD CONSTRAINT `fk_asignatura_carrera_asignatura1` FOREIGN KEY (`idasignatura`) REFERENCES `asignatura` (`idasignatura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_asignatura_has_carrera_carrera1` FOREIGN KEY (`idcarrera`) REFERENCES `carrera` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `clase`
--
ALTER TABLE `clase`
  ADD CONSTRAINT `fk_clase_aula1` FOREIGN KEY (`idaula`) REFERENCES `aula` (`idaula`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `cursada`
--
ALTER TABLE `cursada`
  ADD CONSTRAINT `fk_asignatura_carrera_has_clase_asignatura_carrera1` FOREIGN KEY (`idasignatura`,`idcarrera`) REFERENCES `asignatura_carrera` (`idasignatura`, `idcarrera`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_asignatura_carrera_has_clase_clase1` FOREIGN KEY (`idclase`) REFERENCES `clase` (`idclase`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `llamado`
--
ALTER TABLE `llamado`
  ADD CONSTRAINT `fk_llamado_aula1` FOREIGN KEY (`idaula`) REFERENCES `aula` (`idaula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD CONSTRAINT `fk_mesa_examen_asignatura_carrera1` FOREIGN KEY (`idasignatura`,`idcarrera`) REFERENCES `asignatura_carrera` (`idasignatura`, `idcarrera`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mesa_examen_llamado1` FOREIGN KEY (`primero`) REFERENCES `llamado` (`idllamado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mesa_examen_llamado2` FOREIGN KEY (`segundo`) REFERENCES `llamado` (`idllamado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mesa_examen_tribunal1` FOREIGN KEY (`idtribunal`) REFERENCES `tribunal` (`idtribunal`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `fk_rol_has_permiso_permiso1` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rol_has_permiso_rol1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tribunal`
--
ALTER TABLE `tribunal`
  ADD CONSTRAINT `fk_tribunal_docente1` FOREIGN KEY (`presidente`) REFERENCES `docente` (`iddocente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tribunal_docente2` FOREIGN KEY (`vocal1`) REFERENCES `docente` (`iddocente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tribunal_docente3` FOREIGN KEY (`vocal2`) REFERENCES `docente` (`iddocente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tribunal_docente4` FOREIGN KEY (`suplente`) REFERENCES `docente` (`iddocente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_google`
--
ALTER TABLE `usuario_google`
  ADD CONSTRAINT `fk_usuario_google_usuario1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_manual`
--
ALTER TABLE `usuario_manual`
  ADD CONSTRAINT `fk_usuario_manual_usuario1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `fk_usuario_has_rol_rol1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_has_rol_usuario1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
