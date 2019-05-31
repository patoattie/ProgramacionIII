SELECT *
FROM Productos p
ORDER BY p.pNombre;

SELECT *
FROM Proveedores p
WHERE p.localidad = 'Quilmes';

SELECT *
FROM Envios e
WHERE e.cantidad BETWEEN 200 AND 300;

SELECT SUM(e.cantidad) cant_total
FROM Envios e;

SELECT e.pNumero
FROM Envios e
LIMIT 3;

SELECT pv.nombre proveedor, pd.pNombre producto
FROM Envios e, Productos pd, Proveedores pv
WHERE e.numero = pv.numero
AND e.pNumero = pd.pNumero;

SELECT e.*, TRUNCATE(e.cantidad * p.precio, 2) monto
FROM Envios e, Productos p
WHERE e.pNumero = p.pNumero;

SELECT SUM(e.cantidad) cant_total
FROM Envios e
WHERE e.numero = 102;

SELECT e.pNumero producto
FROM Envios e, Proveedores p
WHERE e.numero = p.numero
AND p.localidad = 'Avellaneda';

SELECT p.domicilio, p.localidad
FROM Proveedores p
WHERE p.nombre LIKE '%I%';

INSERT INTO Productos(pNombre, tamaño, precio)
VALUES('Chocolate', 'Chico', 25.35);

INSERT INTO Proveedores(numero)
VALUES(103);

INSERT INTO Proveedores(numero, nombre, localidad)
VALUES(107, 'Rosales', 'La Plata');

UPDATE Productos p
SET precio = 97.5
WHERE p.tamaño = 'Grande';

UPDATE Productos SET tamaño = 'Mediano'
WHERE tamaño = 'Chico'
AND pNumero IN
(SELECT pNumero
 FROM Envios e
 WHERE e.cantidad >= 300);

DELETE FROM Productos
WHERE pNumero = 1;

DELETE FROM Proveedores
WHERE numero NOT IN
(SELECT e.numero
 FROM Envios e);
