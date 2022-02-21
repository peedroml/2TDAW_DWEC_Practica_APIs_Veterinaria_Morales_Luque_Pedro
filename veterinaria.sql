-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-02-2022 a las 20:11:04
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `codigo_mascota` int(11) NOT NULL,
  `codigo_servicio` int(11) NOT NULL,
  `fecha_cita` date NOT NULL,
  `hora_cita` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`codigo_mascota`, `codigo_servicio`, `fecha_cita`, `hora_cita`) VALUES
(7, 6, '2021-12-01', '20:50:00'),
(6, 5, '2021-12-09', '13:48:00'),
(6, 7, '2021-12-07', '21:37:00'),
(2, 6, '2021-12-11', '22:00:00'),
(6, 4, '2021-12-10', '21:10:00'),
(14, 10, '2022-01-25', '17:30:00'),
(15, 7, '2022-02-04', '20:30:00'),
(16, 7, '2022-01-31', '16:30:00'),
(14, 7, '2022-03-09', '18:35:00'),
(17, 6, '2022-01-29', '16:36:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `tipo_animal` varchar(30) NOT NULL,
  `nombre_animal` varchar(20) NOT NULL,
  `edad` int(2) UNSIGNED NOT NULL,
  `nombre_dueño` varchar(20) NOT NULL,
  `contraseña` varchar(20) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `foto` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `tipo_animal`, `nombre_animal`, `edad`, `nombre_dueño`, `contraseña`, `telefono`, `foto`) VALUES
(1, 'Perro', 'Rudolf', 4, 'Alexa Perez', 'pacaP123', '665614215', 'animal_1.jpg'),
(2, 'Perro', 'Urko', 7, 'Alexa Perez', 'aR777', '667787475', 'animal_2.jpg'),
(6, 'Gato', 'Michi', 5, 'Lucia Recio', 'JLtF12', '669688774', 'animal_6.jpeg'),
(7, 'Gallina', 'Antonia', 1, 'Lucia Recio', 'HL9876', '663265326', 'animal_7.jpeg'),
(10, 'Foca', 'Lucy', 2, 'Alexa Perez', 'Ale987654', '663622320', 'animal_10.jpeg'),
(12, 'Oveja', 'Paquito', 3, 'Lucia Recio', 'AMYYY2', '665677870', 'animal_12.jpeg'),
(14, 'Perro', 'Zeus', 2, 'Juan Castillo', 'Zeus', '1', 'animal_14.jpeg'),
(15, 'Pez', 'Poppy', 1, 'Juan Castillo', 'Poppy', '1', 'animal_15.jpeg'),
(16, 'Ornitorrinco', 'Kalise', 2, 'Pablo Hernández', 'Kalise', '1', 'animal_16.jpeg'),
(17, 'Serpiente', 'Cassiopeia', 3, 'Pablo Hernández', 'Cassiopeia', '1', 'animal_17.jpeg'),
(18, 'Araña', 'Elipse', 1, 'Pablo Hernández', 'Elipse', '1', 'animal_18.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dueño`
--

CREATE TABLE `dueño` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `telefono` int(9) UNSIGNED DEFAULT NULL,
  `nick` varchar(20) NOT NULL,
  `pass` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dueño`
--

INSERT INTO `dueño` (`dni`, `nombre`, `telefono`, `nick`, `pass`) VALUES
('00000000', 'Administrador', NULL, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
('75847596R', 'Juan Castillo', 0, 'JuanN', '671b7fa6fb0c818ad06b7e8596857740'),
('85265365A', 'Pablo Hernández', 663625362, 'PablitoHRZ', '8a2e3ec615ca38078d24eff1325a2ccf'),
('87587548P', 'Lucia Recio', 666554411, 'Lucy', 'f4109bdbe064fa0e3db89aa42055b387');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id` int(11) NOT NULL,
  `titulo` varchar(40) NOT NULL,
  `contenido` varchar(500) NOT NULL,
  `imagen` varchar(500) NOT NULL,
  `fecha_publicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `contenido`, `imagen`, `fecha_publicacion`) VALUES
(1, 'Los perros no serán \'cosas\'', 'El Pleno del Senado ha aprobado con el voto en contra de Vox y la abstención del PP la reforma legal de varias leyes para dejar de considerar \'cosas\' a los animales, que a partir de ahora serán atendidos en accidentes y ya no serán considerados como bienes inmuebles de modo que en casos de separación o divorcio el juez tendrá que decidir sobre su custodia. ', 'https://www.myhappypet.es/sites/spmhp/files/styles/side_content_square/public/perro-feliz.jpg?itok=NviIPrVr', '2021-11-17'),
(2, 'Hacer que un gato huya con una palabra', 'Hay gente a la que no le gustan los perros o los gatos o, simplemente, les tienen miedo y prefieren tenerlos lejos. Pero para ahuyentar a un felino, puedes usar una interjección. Lo más fácil es gritarles con tono firme alguna de las dos interjecciones más conocidas para ahuyentar a los gatos. Son estas: ¡zape! o ¡sape!', 'https://misanimales.com/wp-content/uploads/2015/01/rabo-gato.jpg', '2021-11-07'),
(3, 'En libertad un asesino de perros', 'La jueza ha puesto en libertad sin medidas, como investigado por un delito de maltrato animal, al detenido este sábado por ser el presunto responsable de intentar matar a perros con cebos con alfileres en Ourense. El hombre fue arrestado por un operativo conjunto del Seprona, la Policía Nacional de Ourense y la Policía Local como principal acusado de los intentos de asesinato animal que durante años se hicieron en la ciudad de Ourense y que le costó la vida a al menos dos perros.', 'https://m.media-amazon.com/images/I/513WBiRphyL.jpg', '2021-11-05'),
(4, 'Multas de hasta 30.000 €', 'Los mastines gallegos, podrán ‘jubilarse’ desde los 7 años en virtud del proyecto de Ley de Protección y Derechos de los animales que prepara el Gobierno. La medida no está exenta de polémica porque exige un informe veterinario que deberá evaluar anualmente el estado de salud del animal, con los costes que esto acarrea si se desea que el can siga trabajando a partir de los siete años. Y el incumplimiento de esta norma aparece tipificado con una posible sanción que va de 600 a 30.000 euros.', 'https://lucasylola.es/blog/wp-content/uploads/2019/06/mastin-espa%C3%B1ol-2.jpg', '2021-11-17'),
(5, 'Salvadores de perros en Palma', 'Los propietarios de esos animales de caza que no esperaron a que los drones que los iban a rescatar llegasen a la Isla Bonita y se adentraron en el paisaje lunar para recuperar a sus perros atrapados en el ya arrasado barrio de Todoque. Para dar fe de su hazaña dejaron una pancarta: \"Fuerza La Palma. Los perros están bien. A Team\", escribieron orgullosos.', 'https://media.istockphoto.com/vectors/the-eruption-of-a-volcano-on-a-river-vector-id820075538?b=1&k=6&m=820075538&s=170667a&w=0&h=bC_9UeimjekP3gMUNt9HcLyZljAfM5zRkH6RJC8mD_A=', '2021-11-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `precio` double(5,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`) VALUES
(9, 'Cepillo', 4.00),
(10, 'Pelota', 7.00),
(11, 'Arena para gato', 7.00),
(12, 'Jaula para loro', 25.00),
(14, 'Collar anti-pulgas', 13.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(35) NOT NULL,
  `duracion` int(3) UNSIGNED NOT NULL,
  `precio` double(5,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`codigo`, `descripcion`, `duracion`, `precio`) VALUES
(1, 'Lavado', 20, 10.80),
(2, 'Cortar pelo', 30, 6.70),
(3, 'Vacunar de la rabia ', 5, 20.00),
(4, 'Vacuna del adenovirus', 5, 30.00),
(5, 'Vacunar de la parvovirosis', 5, 15.00),
(6, 'Revisar la vision de tu mascota', 30, 8.99),
(7, 'Ecografia', 30, 25.20),
(10, 'Limpiar dentadura', 15, 14.00),
(12, 'Cortar uñas', 12, 5.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonio`
--

CREATE TABLE `testimonio` (
  `id` int(11) NOT NULL,
  `autor` varchar(20) NOT NULL,
  `contenido` varchar(80) NOT NULL,
  `fecha_publicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `testimonio`
--

INSERT INTO `testimonio` (`id`, `autor`, `contenido`, `fecha_publicacion`) VALUES
(1, 'Juan Lopez Perez', 'Muy contento con el servicio proporcionado', '2021-11-02'),
(2, 'Paco Hernandez', 'Mi mascota fue correctamente atendida :)', '2021-11-04'),
(3, 'Maria Morales', '¡¡A mi mascota le fue muy bien el lavado!!', '2021-11-10'),
(4, 'Alberto Garcia', 'Un gran trabajo de la veterinaria!', '2021-11-08'),
(5, 'Sergio Gonzalez', 'De las mejores clinicas veterinarias de Granada', '2021-09-27'),
(6, 'Lucia Fernandez', 'Mi loro esta sanísimo, muchas gracias!!', '2021-11-09'),
(7, 'Dario Perez', 'Mi lagarto se ha recuperado correctamente :D', '2021-12-08'),
(8, 'Samuel Macias', 'De las mejores veterinarias en las que he estado', '2021-12-08'),
(9, 'Lucia Sanchez', 'Me regalaron pienso', '2021-12-06'),
(10, 'Alexa Perez', 'Tienen loros\r\n', '2022-01-20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD KEY `codigo_mascota` (`codigo_mascota`),
  ADD KEY `codigo_servicio` (`codigo_servicio`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dueño`
--
ALTER TABLE `dueño`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`codigo_mascota`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`codigo_servicio`) REFERENCES `servicio` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
