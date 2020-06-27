<?php

/* 

create view vw_aula as
SELECT  a.id, 
        a.nombre, 
        a.sector, 
        (CASE WHEN c.clases IS NULL THEN 0 ELSE c.clases END) clases,
        (CASE WHEN l.llamados IS NULL THEN 0 ELSE l.llamados END) llamados
FROM aula a
LEFT JOIN (SELECT idAula, COUNT(*) clases FROM clase GROUP BY idAula) c ON c.idAula = a.id
LEFT JOIN (SELECT idAula, COUNT(*) llamados FROM llamado GROUP BY idAula) l ON l.idAula = a.id

 */

