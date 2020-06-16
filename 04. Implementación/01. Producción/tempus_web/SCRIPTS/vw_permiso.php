<?php

/*

CREATE VIEW vw_permiso AS
SELECT p.id, p.nombre, (CASE WHEN r.roles IS NULL THEN 0 ELSE r.roles END) roles
FROM permiso p
LEFT JOIN 
	(SELECT permiso_id idPermiso, COUNT(*) roles
	FROM rol_permiso
	GROUP BY permiso_id) r ON r.idPermiso = p.id

 */
