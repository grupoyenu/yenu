<?php

/*

CREATE VIEW vw_rol AS
SELECT r.id, 
  r.nombre, 
 (CASE WHEN u.usuarios IS NULL THEN 0 ELSE u.usuarios END) usuarios,
 (CASE WHEN p.permisos IS NULL THEN 0 ELSE p.permisos END) permisos
FROM rol r 
LEFT JOIN 
	(SELECT rol_id idRol, COUNT(*) usuarios 
	 FROM rol_usuario 
	 GROUP BY rol_id) u ON u.idRol = r.id 
LEFT JOIN 
	(SELECT rol_id idRol, COUNT(*) permisos 
	 FROM rol_permiso 
	 GROUP BY rol_id) p ON p.idRol = r.id 
 
 */

