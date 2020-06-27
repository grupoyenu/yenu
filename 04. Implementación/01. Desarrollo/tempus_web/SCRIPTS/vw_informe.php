<?php

/* 
create view vw_informe as
SELECT 'ASIGNATURAS' collate utf8mb4_general_ci as modulo, 
	   'Total de asignaturas' collate utf8mb4_general_ci as informe, 
       COUNT(*) cantidad 
FROM asignatura
UNION ALL
SELECT 'ASIGNATURAS' collate utf8mb4_general_ci as modulo, 
	   'Total de asignaturas sin carrera asociada' collate utf8mb4_general_ci as informe, 
       COUNT(*) cantidad 
FROM vw_asignatura WHERE carreras = 0
UNION ALL
SELECT 'AULAS' collate utf8mb4_general_ci as modulo, 
	   'Total de aulas' collate utf8mb4_general_ci as informe, 
       COUNT(*) cantidad FROM aula
UNION ALL
SELECT 'AULAS' collate utf8mb4_general_ci as modulo, 
	   'Total de aulas sin clase asociada' collate utf8mb4_general_ci as informe, 
       COUNT(*) cantidad FROM vw_aula WHERE clases = 0
UNION ALL
SELECT 'AULAS' collate utf8mb4_general_ci as modulo, 
	   'Total de aulas sin llamado asociado' collate utf8mb4_general_ci as informe, 
       COUNT(*) cantidad FROM vw_aula WHERE llamados = 0
UNION ALL
SELECT 'CARRERAS' collate utf8mb4_general_ci as modulo, 
	   'Total de carreras' collate utf8mb4_general_ci as informe, 
       COUNT(*) cantidad FROM carrera
UNION ALL
SELECT 'CARRERAS' collate utf8mb4_general_ci as modulo, 
   	   'Total de carreras sin asignatura asociada' collate utf8mb4_general_ci as informe, 
       COUNT(*) cantidad FROM vw_carrera WHERE asignaturas = 0
UNION ALL
SELECT 'CURSADAS' collate utf8mb4_general_ci as modulo, 'Total de cursadas' collate utf8mb4_general_ci as informe, COUNT(DISTINCT idPlan) cantidad FROM clase
UNION ALL
SELECT 'MESAS DE EXAMEN' collate utf8mb4_general_ci as modulo, 'Total de mesas de examen' collate utf8mb4_general_ci as informe, COUNT(*) cantidad FROM mesa_examen
UNION ALL
SELECT 'MESAS DE EXAMEN' collate utf8mb4_general_ci as modulo, 'Total de mesas de examen creadas los ultimos siete días' collate utf8mb4_general_ci as informe, COUNT(*) cantidad FROM `mesa_examen` 
WHERE DATE_FORMAT(fechaCreacion, "%Y-%m-%d") >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -7 DAY), "%Y-%m-%d")
UNION ALL
SELECT 'MESAS DE EXAMEN' collate utf8mb4_general_ci as modulo, 'Total de mesas de examen del día' collate utf8mb4_general_ci as informe, COUNT(*) cantidad
FROM vw_mesa_examen  
WHERE fechaPrimerLlamado = DATE_FORMAT(NOW(), "%Y-%m-%d") OR fechaSegundoLlamado = DATE_FORMAT(NOW(), "%Y-%m-%d")
UNION ALL
SELECT 'PERMISOS' collate utf8mb4_general_ci as modulo, 'Total de permisos' collate utf8mb4_general_ci as informe, COUNT(*) cantidad FROM permiso
UNION ALL
SELECT 'ROLES' collate utf8mb4_general_ci as modulo, 'Total de roles' collate utf8mb4_general_ci as informe, COUNT(*) cantidad FROM rol
UNION ALL
SELECT 'USUARIOS' collate utf8mb4_general_ci as modulo, 'Total de usuarios' collate utf8mb4_general_ci as informe, COUNT(*) cantidad FROM usuario
UNION ALL
SELECT 'USUARIOS' collate utf8mb4_general_ci as modulo, 
       'Total de usuarios activos' collate utf8mb4_general_ci as informe, 
       COUNT(*) cantidad 
 FROM usuario WHERE estado = 'Activo'
UNION ALL
SELECT 'USUARIOS' collate utf8mb4_general_ci as modulo, 
       'Total de usuarios inactivos' collate utf8mb4_general_ci as informe, 
       COUNT(*) cantidad 
 FROM usuario WHERE estado = 'Inactivo' 

 */

