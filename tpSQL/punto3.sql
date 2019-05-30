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