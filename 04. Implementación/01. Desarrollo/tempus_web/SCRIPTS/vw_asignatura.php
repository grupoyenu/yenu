<?php

/* 
create view vw_asignatura as 
SELECT a.id, a.nombreCorto, a.nombreLargo, (CASE WHEN c.carreras IS NULL THEN 0 ELSE c.carreras END) carreras 
FROM asignatura a
LEFT JOIN (SELECT idAsignatura, COUNT(idCarrera) carreras 
           FROM plan 
           GROUP BY idAsignatura) c ON c.idAsignatura = a.id
 */

