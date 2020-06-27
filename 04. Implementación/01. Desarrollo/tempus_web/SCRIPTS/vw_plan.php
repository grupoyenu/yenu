<?php

/* 
create view vw_plan as
SELECT 
	p.id idPlan,
    a.id idAsignatura,
    a.nombreCorto nombreCortoAsignatura,
    a.nombreLargo nombreLargoAsignatura,
    c.id idCarrera,
    c.nombreCorto nombreCortoCarrera,
    c.nombreLargo nombreLargoCarrera,
    (CASE WHEN cl.clases IS NULL THEN 'No' ELSE 'Si' END) cursada,
    (CASE WHEN p.idMesaExamen IS NULL THEN 'No' ELSE 'Si' END) mesaExamen,
    p.anio,
    p.fechaCreacion
FROM plan p
INNER JOIN asignatura a ON a.id = p.idAsignatura
INNER JOIN carrera c ON c.id = p.idCarrera
LEFT JOIN (SELECT idPlan, COUNT(id) clases 
           FROM clase 
           GROUP BY idPlan) cl on cl.idPlan = p.id
 */

