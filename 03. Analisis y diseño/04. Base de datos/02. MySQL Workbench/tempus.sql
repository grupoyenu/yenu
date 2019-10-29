-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2019 a las 03:04:19
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
(81, 'Analisis'),
(82, 'Analisis Matematico 3'),
(1, 'Análisis Matematico I'),
(37, 'Analisis Politico Y Org. Del Sist. Educ.'),
(6, 'Análisis Y Diseño Del Software'),
(18, 'Análisis Y Producción Del Discurso'),
(36, 'Antropologia Sociocultural'),
(38, 'Aprendizaje'),
(5, 'Base De Datos'),
(58, 'Biogeografia'),
(7, 'C.u.s'),
(55, 'Cartografia'),
(33, 'Ciencias Biologicas'),
(57, 'Climatologia'),
(21, 'Conservación De Sitios Culturales Arqueologicos Y Paleontologicos'),
(28, 'Deontologica Prof. I'),
(65, 'Economia General'),
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
(11, 'Gestión De Proyectos De Software'),
(25, 'Gestión Y Administración De Empresas Turisticas'),
(27, 'Herramientas De Informatica'),
(83, 'herramientas de microsoft'),
(75, 'Hidrografia'),
(76, 'Historia Social General '),
(45, 'Idioma Moderno Frances'),
(34, 'Idioma Moderno Ingles'),
(15, 'Inglés I'),
(19, 'Inglés Iii'),
(35, 'Introduccion A La Administracion'),
(51, 'Introduccion A La Geografia'),
(12, 'Laboratorio De Desarrollo De Software'),
(39, 'Lengua Y Cultura Latinas I'),
(47, 'Literatura Argentina I'),
(48, 'Literatura Argentina Ii'),
(43, 'Literatura De Masas'),
(49, 'Literatura Española I'),
(50, 'Literatura Española Ii'),
(46, 'Literatura Francesa'),
(44, 'Literatura Inglesa Y Norteamericana'),
(40, 'Literatura Latinoamericana I'),
(41, 'Literatura Latinoamericana Ii'),
(62, 'Matematica Aplicada'),
(2, 'Matemática Discreta'),
(72, 'Metodologia Investig. Geografia'),
(61, 'Ordenamiento Del Territorio Y Planeamiento Regional Y Urbano'),
(3, 'Organización De Las Computadoras'),
(66, 'Patrimonio Natural Y Cultural'),
(84, 'Perro'),
(22, 'Politica Del Turismo'),
(26, 'Práctica Ii'),
(20, 'Práctica Profesional I'),
(56, 'Problematica Ambiental Y Desarrollo Sustentable'),
(17, 'Procesos Históricos'),
(4, 'Resolución De Problemas Y Algoritmos'),
(69, 'Seminario De Integracion Geografia De La Patagonia'),
(42, 'Seminario De Literatura'),
(54, 'Sistemas De  Informacion Territorial'),
(8, 'Sistemas Operativos'),
(10, 'Sistemas Operativos Distribuidos'),
(64, 'Teledeteccion'),
(70, 'Teoria De La Geografia'),
(23, 'Teoria Turistica'),
(60, 'Territorios Geograficos De America'),
(59, 'Territorios Geograficos Mundiales');

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
(1, 16, 1),
(1, 61, 5),
(1, 72, 1),
(2, 16, 1),
(2, 72, 1),
(3, 16, 1),
(3, 72, 1),
(4, 16, 1),
(4, 72, 1),
(5, 16, 2),
(5, 61, 3),
(5, 72, 2),
(6, 16, 2),
(7, 16, 2),
(7, 61, 2),
(7, 72, 2),
(8, 16, 2),
(8, 72, 2),
(9, 16, 2),
(9, 72, 2),
(10, 16, 3),
(10, 72, 3),
(11, 16, 3),
(11, 72, 3),
(12, 16, 3),
(12, 72, 3),
(13, 16, 3),
(13, 72, 3),
(14, 72, 4),
(15, 61, 1),
(16, 61, 1),
(17, 61, 1),
(18, 61, 1),
(18, 89, 1),
(19, 61, 3),
(20, 61, 3),
(21, 61, 4),
(22, 61, 4),
(23, 61, 4),
(24, 61, 4),
(25, 61, 4),
(26, 61, 4),
(27, 4, 1),
(27, 46, 1),
(28, 46, 1),
(28, 61, 2),
(29, 46, 1),
(30, 46, 1),
(31, 46, 1),
(32, 46, 1),
(33, 46, 1),
(33, 61, 5),
(34, 1, 1),
(34, 4, 1),
(34, 46, 1),
(35, 46, 1),
(36, 46, 1),
(37, 1, 1),
(38, 1, 1),
(39, 1, 1),
(40, 1, 1),
(41, 1, 1),
(42, 1, 1),
(43, 1, 1),
(44, 1, 1),
(45, 1, 1),
(45, 4, 1),
(46, 1, 1),
(47, 1, 1),
(48, 1, 1),
(49, 1, 1),
(50, 1, 1),
(51, 4, 1),
(52, 4, 1),
(53, 4, 1),
(54, 4, 1),
(55, 4, 1),
(56, 4, 1),
(57, 4, 1),
(57, 61, 5),
(58, 4, 1),
(59, 4, 1),
(60, 4, 1),
(61, 4, 1),
(62, 4, 1),
(63, 4, 1),
(64, 4, 1),
(65, 4, 1),
(66, 4, 1),
(67, 4, 1),
(68, 4, 1),
(69, 4, 1),
(70, 4, 1),
(71, 4, 1),
(72, 4, 1),
(73, 4, 1),
(74, 4, 1),
(75, 4, 1),
(76, 4, 1),
(78, 16, 3),
(79, 16, 3),
(79, 61, 2),
(81, 16, 1),
(81, 72, 1),
(82, 16, 3),
(82, 72, 4),
(83, 16, 1),
(83, 87, 1),
(83, 88, 1);

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
(3, '10', 'A'),
(20, '10', 'K'),
(21, '11', 'A'),
(5, '11', 'E'),
(16, '12', 'A'),
(18, '17', 'D'),
(8, '2', 'A'),
(17, '2', 'D'),
(19, '2', 'E'),
(1, '3', 'A'),
(7, '4', 'A'),
(45, '434', 'A'),
(11, '5', 'A'),
(13, '5', 'E'),
(46, '543', 'A'),
(49, '543', 'X'),
(50, '544', 'X'),
(52, '545', 'X'),
(6, '6', 'A'),
(14, '6', 'D'),
(15, '6', 'E'),
(9, '7', 'A'),
(12, '7', 'E'),
(10, '8', 'A'),
(4, '9', 'E'),
(42, 'Almodobar', 'B'),
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
(40, 'PeÃ±a Morfi', 'C'),
(33, 'Sa', 'A'),
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
(72, 'Licenciatura En Sistemas'),
(61, 'Licenciatura En Turismo'),
(564, 'profesorado'),
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
(2, '3', '18:00:00', '21:00:00', 1, NULL),
(3, '2', '20:00:00', '22:00:00', 6, NULL),
(4, '1', '18:00:00', '20:00:00', 6, NULL),
(5, '2', '16:00:00', '19:00:00', 6, '2018-09-21 19:24:29'),
(6, '4', '16:00:00', '18:00:00', 6, NULL),
(7, '3', '16:00:00', '18:00:00', 7, NULL),
(8, '4', '18:00:00', '20:00:00', 7, NULL),
(9, '2', '18:00:00', '20:00:00', 1, NULL),
(10, '4', '20:00:00', '23:00:00', 9, NULL),
(11, '5', '17:00:00', '20:00:00', 10, NULL),
(12, '1', '18:00:00', '21:00:00', 9, NULL),
(14, '2', '16:00:00', '18:00:00', 7, NULL),
(15, '4', '16:00:00', '18:00:00', 7, NULL),
(16, '2', '18:00:00', '21:00:00', 7, NULL),
(19, '2', '16:00:00', '18:00:00', 2, NULL),
(20, '1', '14:00:00', '16:00:00', 3, NULL),
(21, '2', '14:00:00', '16:00:00', 4, NULL),
(22, '3', '14:00:00', '16:00:00', 5, NULL),
(23, '2', '18:00:00', '20:00:00', 6, NULL),
(24, '5', '15:00:00', '17:00:00', 8, NULL),
(25, '2', '20:00:00', '23:00:00', 9, NULL),
(26, '3', '18:00:00', '21:00:00', 10, NULL),
(27, '3', '18:00:00', '20:00:00', 11, NULL),
(28, '1', '14:00:00', '16:00:00', 7, NULL),
(29, '2', '14:00:00', '16:00:00', 7, NULL),
(30, '4', '14:00:00', '16:00:00', 7, NULL),
(31, '2', '19:00:00', '21:00:00', 12, NULL),
(32, '2', '21:00:00', '23:00:00', 12, NULL),
(33, '4', '18:00:00', '20:00:00', 13, NULL),
(34, '3', '15:00:00', '17:00:00', 2, NULL),
(35, '1', '18:00:00', '20:00:00', 11, NULL),
(36, '1', '18:00:00', '20:00:00', 3, NULL),
(37, '2', '16:00:00', '18:00:00', 18, NULL),
(38, '4', '19:00:00', '21:00:00', 18, NULL),
(39, '2', '18:00:00', '20:00:00', 18, NULL),
(40, '3', '18:00:00', '20:00:00', 18, NULL),
(41, '2', '20:00:00', '22:00:00', 18, NULL),
(42, '3', '14:00:00', '16:00:00', 18, NULL),
(43, '5', '15:00:00', '18:00:00', 13, NULL),
(44, '1', '16:00:00', '18:00:00', 6, NULL),
(45, '1', '00:00:00', '00:00:00', 1, NULL),
(46, '1', '21:10:00', '23:10:00', 7, NULL),
(47, '2', '21:10:00', '23:10:00', 7, NULL),
(48, '2', '14:00:00', '16:00:00', 21, '2018-11-16 14:15:47'),
(49, '4', '14:00:00', '16:00:00', 21, NULL),
(51, '1', '10:00:00', '11:00:00', 33, NULL),
(52, '2', '18:00:00', '20:00:00', 21, NULL),
(53, '4', '18:00:00', '20:00:00', 3, NULL),
(55, '2', '10:00:00', '12:00:00', 1, NULL),
(56, '1', '10:00:00', '11:00:00', 1, NULL),
(57, '2', '10:00:00', '11:00:00', 37, NULL),
(58, '3', '10:00:00', '11:00:00', 21, NULL),
(59, '4', '10:00:00', '11:00:00', 24, NULL),
(60, '5', '10:00:00', '11:00:00', 28, NULL),
(61, '', '10:00:00', '11:00:00', 29, NULL),
(80, '1', '16:00:00', '18:00:00', 44, NULL),
(81, '1', '16:00:00', '18:00:00', 44, NULL),
(82, '1', '16:00:00', '18:00:00', 44, NULL),
(83, '1', '16:00:00', '18:00:00', 44, NULL),
(84, '1', '16:00:00', '18:00:00', 44, NULL),
(85, '1', '16:00:00', '18:00:00', 44, NULL),
(86, '1', '16:00:00', '18:00:00', 44, NULL),
(87, '1', '16:00:00', '18:00:00', 21, NULL),
(88, '1', '18:00:00', '20:00:00', 1, NULL),
(89, '1', '16:00:00', '18:00:00', 13, NULL),
(90, '3', '16:00:00', '18:00:00', 13, NULL),
(91, '4', '17:00:00', '19:00:00', 21, NULL),
(92, '5', '16:00:00', '18:00:00', 21, NULL),
(93, '1', '10:00:00', '12:00:00', 21, NULL),
(94, '2', '10:00:00', '11:00:00', 21, NULL),
(95, '3', '12:00:00', '14:00:00', 13, NULL),
(96, '4', '12:00:00', '14:00:00', 21, NULL),
(97, '5', '12:00:00', '14:00:00', 21, NULL),
(98, '2', '10:00:00', '12:30:00', 20, NULL),
(99, '3', '10:00:00', '13:00:00', 20, NULL);

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
(1, 16, 2),
(1, 72, 19),
(2, 72, 20),
(2, 72, 21),
(2, 72, 22),
(3, 72, 23),
(4, 16, 3),
(4, 72, 3),
(5, 16, 4),
(5, 16, 5),
(5, 16, 6),
(5, 72, 4),
(5, 72, 5),
(5, 72, 6),
(6, 16, 7),
(6, 16, 8),
(7, 16, 9),
(7, 72, 9),
(7, 72, 24),
(8, 16, 10),
(8, 72, 10),
(8, 72, 25),
(9, 16, 11),
(9, 72, 11),
(9, 72, 26),
(10, 16, 12),
(10, 72, 12),
(11, 16, 14),
(11, 16, 15),
(11, 72, 14),
(12, 16, 16),
(12, 72, 16),
(13, 72, 27),
(14, 72, 28),
(14, 72, 29),
(14, 72, 30),
(16, 61, 31),
(17, 61, 32),
(17, 61, 33),
(18, 61, 34),
(19, 61, 35),
(22, 61, 36),
(23, 61, 37),
(23, 61, 38),
(24, 61, 39),
(24, 61, 40),
(25, 61, 41),
(25, 61, 42),
(26, 61, 43),
(34, 1, 2),
(38, 1, 55),
(42, 1, 2),
(43, 1, 56),
(43, 1, 57),
(43, 1, 58),
(43, 1, 59),
(43, 1, 60),
(43, 1, 61),
(45, 1, 55),
(78, 16, 46),
(78, 16, 47),
(79, 16, 48),
(79, 16, 49),
(79, 61, 48),
(79, 61, 49),
(81, 72, 9),
(81, 72, 87),
(81, 72, 90),
(81, 72, 91),
(81, 72, 92),
(81, 72, 93),
(81, 72, 94),
(81, 72, 95),
(81, 72, 96),
(81, 72, 97);

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
(300, ''),
(259, ' Gogoy, P'),
(260, '433'),
(274, 'Aimar Carlos'),
(197, 'Alvarez, P.'),
(225, 'Ampuero, C.'),
(275, 'Arcucci Daniel'),
(219, 'Arpes'),
(201, 'Astete Fl.'),
(234, 'Asueta, R'),
(257, 'Auzoberria'),
(253, 'Auzoberria, M'),
(270, 'Benjamin Marquez'),
(268, 'Bilardo C.'),
(218, 'Borquez'),
(221, 'Borquez N.'),
(212, 'Borquez, N.'),
(191, 'Brandoni B., V.'),
(180, 'Britos, Evangelina'),
(252, 'Caceres A.'),
(240, 'Caceres, A'),
(187, 'Calisaya'),
(198, 'Campan'),
(284, 'Centurion Ricardo'),
(213, 'Cheuqueman'),
(242, 'Concetti'),
(224, 'Constanzo'),
(173, 'Constanzo, M.'),
(247, 'Corbacho L.'),
(250, 'Cornaglia'),
(269, 'Cristobal Colon'),
(183, 'David Soria'),
(214, 'Diaz Mass, S.'),
(238, 'Diez, P'),
(193, 'Diez, P.'),
(271, 'El Dipy'),
(199, 'Enrici'),
(237, 'Ercolano '),
(174, 'Farias R'),
(223, 'Farias, R.'),
(209, 'Ferrante B.'),
(258, 'Ferro, C'),
(217, 'Figueroa'),
(192, 'Figueroa Claudia'),
(196, 'Firnkorn, M '),
(245, 'Franciscovic'),
(254, 'Frias'),
(251, 'Frias P.'),
(184, 'Galarza'),
(222, 'Gimenez'),
(211, 'Gimenez, P.'),
(229, 'Godoy, P.'),
(261, 'Gogoy, P'),
(277, 'Gonzalez'),
(232, 'Grima, D.'),
(279, 'Islas Luis'),
(200, 'Laje'),
(276, 'Lavecchia'),
(285, 'Lopez Lisandro'),
(220, 'Luque'),
(207, 'Luque, G.'),
(243, 'Lurbe'),
(272, 'Maluma'),
(181, 'Mansilla Valeria'),
(267, 'Maradona D.'),
(278, 'Maradona Diego'),
(249, 'Marderwald G.'),
(281, 'Marquez Benjamin'),
(262, 'Marquez E.'),
(280, 'Marquez Emanuel'),
(288, 'MARQUEZ EMANUEL ALBERTO'),
(265, 'Marquez J.'),
(266, 'Marquez L.'),
(282, 'Marquez Mariano'),
(283, 'Martinez Roman'),
(239, 'Mazzoni'),
(190, 'Miro M'),
(189, 'Navarro, O.'),
(255, 'Norambuena'),
(228, 'Norambuena Monica'),
(226, 'Norambuena, Monica'),
(182, 'Ojeda, M'),
(176, 'Ojeda, S.'),
(185, 'Ojeda, Sara'),
(263, 'Oyarzo M.'),
(195, 'Oyarzo V'),
(286, 'Palermo Martin'),
(246, 'Paolillo'),
(172, 'Pezzini '),
(264, 'Quiroga S.'),
(215, 'Reinoso P'),
(203, 'Restivo'),
(178, 'Rojas A.'),
(179, 'Romero D.'),
(202, 'Rosales, K'),
(241, 'Saenz, J.l.'),
(208, 'Saldivia S.'),
(210, 'Salemi, P.'),
(194, 'Sanchez'),
(230, 'Schweitzer'),
(216, 'Segovia S'),
(273, 'Shakira'),
(235, 'Sierpe C'),
(177, 'Soria, D.'),
(256, 'Soto J.'),
(236, 'Soto, J.'),
(233, 'Sunico'),
(206, 'Tabares'),
(248, 'Tiberi'),
(188, 'Torres'),
(244, 'Vazquez'),
(231, 'Vazquez M'),
(205, 'Vega P. Lic Mater'),
(175, 'Vega, P'),
(186, 'Velazquez V'),
(227, 'Vera Ml'),
(204, 'Zapata P.'),
(171, 'Zuñiga');

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
(1, '2018-11-16', '20:00:00', 20, '2018-11-08 11:58:58'),
(2, '2018-11-05', '16:00:00', NULL, '2018-10-01 12:09:56'),
(3, '2018-11-17', '15:00:00', NULL, '2018-11-16 14:30:05'),
(4, '2018-11-07', '14:00:00', 1, NULL),
(5, '2018-11-05', '10:00:00', NULL, '2018-09-29 20:03:30'),
(7, '2018-11-05', '18:00:00', NULL, NULL),
(8, '2018-11-08', '16:00:00', 1, '2018-11-08 11:37:12'),
(9, '2018-11-16', '16:00:00', 9, '2018-11-16 14:32:24'),
(10, '2018-11-05', '15:00:00', NULL, NULL),
(11, '2018-11-05', '15:00:00', NULL, NULL),
(13, '2018-11-05', '15:00:00', NULL, NULL),
(14, '2018-11-05', '15:00:00', NULL, NULL),
(15, '2018-11-05', '15:00:00', NULL, NULL),
(16, '2018-11-07', '16:00:00', NULL, NULL),
(17, '2018-11-05', '16:00:00', NULL, NULL),
(18, '2018-11-05', '16:00:00', NULL, NULL),
(19, '2018-11-05', '19:00:00', NULL, NULL),
(20, '2018-11-05', '19:00:00', NULL, NULL),
(21, '2018-11-05', '16:00:00', NULL, NULL),
(22, '2018-11-05', '15:00:00', NULL, NULL),
(23, '2018-11-05', '15:00:00', NULL, NULL),
(24, '2018-11-05', '18:00:00', NULL, NULL),
(25, '2018-11-05', '18:00:00', NULL, NULL),
(26, '2018-11-05', '10:00:00', NULL, NULL),
(27, '2018-11-05', '16:00:00', NULL, NULL),
(28, '2018-11-05', '16:00:00', NULL, NULL),
(29, '2018-11-05', '16:00:00', NULL, NULL),
(30, '2018-11-05', '15:00:00', NULL, NULL),
(31, '2018-11-05', '15:00:00', NULL, NULL),
(32, '2018-11-05', '18:00:00', NULL, NULL),
(33, '2018-11-05', '16:00:00', NULL, NULL),
(34, '2018-11-05', '16:00:00', NULL, NULL),
(35, '2018-11-16', '18:00:00', NULL, '2018-11-16 14:32:57'),
(36, '2018-11-20', '18:00:00', NULL, NULL),
(37, '2018-11-20', '18:00:00', NULL, NULL),
(38, '2018-11-20', '18:00:00', NULL, NULL),
(39, '2018-11-20', '18:00:00', NULL, NULL),
(40, '2018-11-20', '16:00:00', NULL, NULL),
(41, '2018-11-20', '15:00:00', NULL, NULL),
(42, '2018-11-20', '19:00:00', NULL, NULL),
(43, '2018-11-20', '19:00:00', NULL, NULL),
(44, '2018-11-20', '15:00:00', NULL, NULL),
(46, '2018-11-20', '18:00:00', NULL, NULL),
(47, '2018-11-20', '16:00:00', NULL, NULL),
(48, '2018-11-20', '14:00:00', NULL, NULL),
(49, '2018-11-20', '14:00:00', NULL, NULL),
(51, '2018-11-20', '14:00:00', NULL, NULL),
(52, '2018-11-20', '14:00:00', NULL, NULL),
(53, '2019-03-19', '10:00:00', NULL, NULL),
(54, '2019-03-19', '10:00:00', NULL, NULL),
(55, '2019-03-20', '10:00:00', 1, NULL),
(56, '0000-00-00', '00:00:00', 1, NULL),
(57, '2019-03-01', '24:00:00', NULL, NULL),
(58, '2019-03-30', '21:40:00', 2, '2019-03-23 16:18:53'),
(59, '0000-00-00', '10:30:00', 1, NULL),
(60, '0000-00-00', '10:30:00', 1, NULL),
(61, '0000-00-00', '10:30:00', 1, NULL),
(62, '0000-00-00', '10:30:00', 1, NULL),
(63, '0000-00-00', '10:30:00', 1, NULL),
(64, '0000-00-00', '10:30:00', 1, NULL);

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
(2, 28, 46, 93, 2, NULL),
(3, 29, 46, 94, 3, NULL),
(4, 30, 46, 95, 4, NULL),
(5, 31, 46, 96, 5, NULL),
(7, 33, 46, 98, 7, NULL),
(8, 34, 46, 99, 8, NULL),
(9, 35, 46, 100, 9, NULL),
(10, 36, 46, 101, 10, NULL),
(11, 37, 1, 102, 11, NULL),
(13, 39, 1, 104, 13, NULL),
(14, 40, 1, 105, 14, NULL),
(15, 41, 1, 105, 15, NULL),
(16, 42, 1, 106, 16, NULL),
(17, 43, 1, 107, 17, NULL),
(18, 44, 1, 108, 18, NULL),
(19, 34, 1, 109, 19, NULL),
(20, 45, 1, 110, 20, NULL),
(21, 46, 1, 111, 21, NULL),
(22, 47, 1, 112, 22, NULL),
(23, 48, 1, 112, 23, NULL),
(24, 49, 1, 113, 24, NULL),
(25, 50, 1, 113, 25, NULL),
(27, 51, 4, 115, 27, NULL),
(28, 52, 4, 116, 28, NULL),
(29, 53, 4, 117, 29, NULL),
(30, 54, 4, 118, 30, NULL),
(31, 55, 4, 118, 31, NULL),
(32, 56, 4, 119, 32, NULL),
(33, 57, 4, 120, 33, NULL),
(34, 58, 4, 121, 34, NULL),
(35, 59, 4, 122, 35, NULL),
(36, 60, 4, 122, 36, NULL),
(37, 61, 4, 123, 37, NULL),
(38, 62, 4, 124, 38, NULL),
(39, 63, 4, 125, 39, NULL),
(40, 64, 4, 126, 40, NULL),
(41, 65, 4, 127, 41, NULL),
(42, 34, 4, 109, 42, NULL),
(43, 45, 4, 110, 43, NULL),
(44, 66, 4, 128, 44, NULL),
(46, 68, 4, 130, 46, NULL),
(47, 69, 4, 131, 47, NULL),
(48, 70, 4, 132, 48, NULL),
(49, 71, 4, 133, 49, NULL),
(51, 73, 4, 135, 51, NULL),
(52, 74, 4, 136, 52, NULL);

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
(14, 'MUSSA'),
(16, 'PASAPALABRA'),
(18, 'EXPRESIVOS'),
(19, 'CARLOS'),
(20, 'ADMIN'),
(21, 'ADMIN'),
(22, 'GOSTR'),
(23, 'TELEFE'),
(24, 'DIEGOS'),
(25, 'LPASO'),
(26, 'PRESI'),
(27, 'GRADO'),
(28, 'PRESO'),
(29, 'ADMIN'),
(30, 'NUEVO PER'),
(31, 'NUEVO PER'),
(32, 'NUEVO PER'),
(33, 'NUEVO PER'),
(34, 'NUEVO PERS'),
(35, 'NUEVAZO');

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
(3, 'Colaborador Academico'),
(7, 'Colaborador'),
(8, 'ELIGE'),
(9, 'FRENTE');

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
(3, 3),
(7, 3),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(8, 6),
(8, 7),
(8, 8),
(8, 9),
(8, 11),
(8, 12),
(8, 13),
(8, 14),
(8, 16),
(8, 18),
(8, 19),
(8, 20),
(8, 21),
(8, 22),
(8, 23),
(8, 24),
(8, 25),
(8, 26),
(8, 27),
(8, 28),
(8, 29),
(8, 30),
(8, 31),
(8, 32),
(8, 33),
(8, 34),
(8, 35),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(9, 5),
(9, 6),
(9, 7),
(9, 8),
(9, 9),
(9, 11),
(9, 12),
(9, 13),
(9, 14),
(9, 16),
(9, 18),
(9, 19),
(9, 21),
(9, 22),
(9, 23),
(9, 24),
(9, 25),
(9, 26),
(9, 27),
(9, 28),
(9, 30),
(9, 31),
(9, 32),
(9, 33),
(9, 34),
(9, 35);

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
(92, 262, 219, 173, 174),
(93, 175, 176, 177, NULL),
(94, 178, 179, 180, 181),
(95, 176, 182, 183, 184),
(96, 182, 185, NULL, NULL),
(97, 186, 187, 188, NULL),
(98, 189, 190, 191, NULL),
(99, 192, 193, 194, NULL),
(100, 195, 196, 178, NULL),
(101, 197, 198, 199, NULL),
(102, 200, 201, NULL, NULL),
(103, 202, 203, NULL, NULL),
(104, 204, 205, 206, NULL),
(105, 207, 208, 209, NULL),
(106, 207, 210, 208, NULL),
(107, 211, 212, NULL, NULL),
(108, 192, 212, 213, NULL),
(109, 214, 215, 216, 194),
(110, 214, 194, 216, 215),
(111, 213, 217, 218, NULL),
(112, 219, 209, 220, NULL),
(113, 221, 217, 222, NULL),
(114, 171, 172, 223, 224),
(115, 225, 226, 227, NULL),
(116, 225, 227, 228, NULL),
(117, 227, 229, 230, NULL),
(118, 231, 193, 232, NULL),
(119, 233, 234, 235, NULL),
(120, 236, 237, 238, NULL),
(121, 236, 193, 239, NULL),
(122, 230, 229, 227, NULL),
(123, 230, 240, NULL, NULL),
(124, 241, 240, 242, NULL),
(125, 243, 240, 230, NULL),
(126, 239, 244, 238, 232),
(127, 245, 246, 247, NULL),
(128, 240, 234, NULL, NULL),
(129, 237, 248, 249, NULL),
(130, 250, 193, 241, NULL),
(131, 228, 251, 252, NULL),
(132, 228, 251, 225, NULL),
(133, 229, 253, NULL, NULL),
(134, 240, 254, 228, NULL),
(135, 228, 240, NULL, NULL),
(136, 240, 255, NULL, NULL),
(137, 193, 256, 239, NULL),
(138, 257, 258, 259, NULL),
(139, 278, 279, NULL, NULL),
(140, 278, 279, 280, NULL),
(141, 278, 280, NULL, NULL),
(142, 278, 280, 281, NULL),
(143, 278, 280, 281, 282),
(144, 283, 284, 285, 286),
(145, 286, 285, NULL, NULL),
(146, 285, 286, NULL, NULL),
(147, 286, 286, NULL, NULL),
(148, 285, 286, NULL, NULL);

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
(9, 'rooo_huaiquil@hotmail.com', 'Roxana Huaiquil', 'Manual', 'Activo');

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
  `clave` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `idasignatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT de la tabla `aula`
--
ALTER TABLE `aula`
  MODIFY `idaula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `idclase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `iddocente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clave primaria.', AUTO_INCREMENT=301;
--
-- AUTO_INCREMENT de la tabla `llamado`
--
ALTER TABLE `llamado`
  MODIFY `idllamado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  MODIFY `idmesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `tribunal`
--
ALTER TABLE `tribunal`
  MODIFY `idtribunal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
