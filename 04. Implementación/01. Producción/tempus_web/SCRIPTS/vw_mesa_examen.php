<?php

/* 

create view vw_mesa_examen as
SELECT 
	pla.id idPlan,
    mex.id idMesaExamen,
    car.id codigoCarrera,
    car.nombreCorto nombreCortoCarrera,
    car.nombreLargo nombreLargoCarrera,
    asi.nombreCorto nombreCortoAsignatura,
    asi.nombreLargo nombreLargoAsignatura,
    apr.sector sectorAulaPrimerLlamado,
    apr.nombre nombreAulaPrimerLlamado,
    prl.estado estadoPrimerLlamado,
    prl.fecha fechaPrimerLlamado,
    prl.fechaEdicion fechaEdicionPrimerLlamado,
    prl.hora horaPrimerLlamado,
    ase.sector sectorAulaSegundoLlamado,
    ase.nombre nombreAulaSegundoLlamado,
    sel.estado estadoSegundoLlamado,
    sel.fecha fechaSegundoLlamado,
    sel.fechaEdicion fechaEdicionSegundoLlamado,
    sel.hora horaSegundoLlamado,
    pre.nombre nombrePresidente,
    vpr.nombre nombreVocalPrimero,
    vse.nombre nombreVocalSegundo,
    sup.nombre nombreSuplente,
    mex.fechaCreacion fechaCreacionMesaExamen,
    mex.observacion observacionMesaExamen
FROM plan pla
INNER JOIN asignatura asi on asi.id = pla.idAsignatura
INNER JOIN carrera car on car.id = pla.idCarrera
INNER JOIN mesa_examen mex on mex.id = pla.idMesaExamen
LEFT JOIN llamado prl on prl.id = mex.idPrimerLlamado
LEFT JOIN llamado sel on sel.id = mex.idSegundoLlamado
LEFT JOIN aula apr on apr.id = prl.idAula
LEFT JOIN aula ase on ase.id = sel.idAula
INNER JOIN tribunal tri ON tri.id = mex.idTribunal
INNER JOIN docente pre on pre.id = tri.idPresidente
INNER JOIN docente vpr on vpr.id = tri.idVocal1
LEFT  JOIN docente vse on vse.id = tri.idVocal2
LEFT  JOIN docente sup on sup.id = tri.idSuplente

 */

