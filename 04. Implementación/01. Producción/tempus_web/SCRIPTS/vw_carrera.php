<?php

/* 

create view vw_carrera as
SELECT c.id, c.nombreCorto, c.nombreLargo, (CASE WHEN a.asignaturas IS NULL THEN 0 ELSE a.asignaturas END) asignaturas
FROM carrera c
LEFT JOIN (SELECT idCarrera, COUNT(idAsignatura) asignaturas
           FROM plan 
           GROUP BY idCarrera) a ON a.idCarrera = c.id

 */

