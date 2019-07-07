SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` 
( `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,  
	`nombre` VARCHAR(50) NOT NULL ,  
	`clave` VARCHAR(60) NOT NULL ,  
	`perfil` VARCHAR(50) NOT NULL ,    
	`sexo` VARCHAR(50) NOT NULL ,    
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY  (`id`),    
	UNIQUE  `ukNombre` (`nombre`)) 
ENGINE = InnoDB;
