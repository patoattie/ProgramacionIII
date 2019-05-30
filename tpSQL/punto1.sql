CREATE TABLE `UTN`.`Proveedores` ( `numero` INT NOT NULL , `nombre` VARCHAR(30) NULL , `domicilio` VARCHAR(50) NULL , `localidad` VARCHAR(80) NULL , PRIMARY KEY (`numero`)) ENGINE = InnoDB;
CREATE TABLE `utn`.`Productos` ( `pNumero` INT NOT NULL , `pNombre` VARCHAR(30) NULL , `precio` FLOAT NULL , `tamaño` VARCHAR(20) NULL , PRIMARY KEY (`pNumero`)) ENGINE = InnoDB;
CREATE TABLE `utn`.`Envios` ( `numero` INT NOT NULL , `pNumero` INT NOT NULL , `cantidad` INT NOT NULL , PRIMARY KEY (`numero`, `pNumero`)) ENGINE = InnoDB;
ALTER TABLE `Productos` CHANGE `pNumero` `pNumero` INT(11) NOT NULL AUTO_INCREMENT;

