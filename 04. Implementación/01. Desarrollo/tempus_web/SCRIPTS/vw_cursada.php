<?php

/* 

create view vw_cursada as
SELECT 
	DISTINCT
    plan.id idPlan,
    plan.anio,
    carrera.id codigoCarrera,
    carrera.nombreCorto nombreCortoCarrera,
    carrera.nombreLargo nombreLargoCarrera,
    asignatura.nombreCorto nombreCortoAsignatura,
    asignatura.nombreLargo nombreLargoAsignatura,
    lunes.horaInicioLunes,
    lunes.horaFinLunes,
    lunes.sectorAulaLunes,
    lunes.nombreAulaLunes,
    lunes.fechaEdicionLunes,
    martes.horaInicioMartes,
    martes.horaFinMartes,
    martes.sectorAulaMartes,
    martes.nombreAulaMartes,
    martes.fechaEdicionMartes,
    miercoles.horaInicioMiercoles,
    miercoles.horaFinMiercoles,
    miercoles.sectorAulaMiercoles,
    miercoles.nombreAulaMiercoles,
    miercoles.fechaEdicionMiercoles,
    jueves.horaInicioJueves,
    jueves.horaFinJueves,
    jueves.sectorAulaJueves,
    jueves.nombreAulaJueves,
    jueves.fechaEdicionJueves,
    viernes.horaInicioViernes,
    viernes.horaFinViernes,
    viernes.sectorAulaViernes,
    viernes.nombreAulaViernes,
    viernes.fechaEdicionViernes,
    sabado.horaInicioSabado,
    sabado.horaFinSabado,
    sabado.sectorAulaSabado,
    sabado.nombreAulaSabado,
    sabado.fechaEdicionSabado
FROM plan 
INNER JOIN asignatura on asignatura.id = plan.idAsignatura
INNER JOIN carrera on carrera.id = plan.idCarrera
LEFT JOIN (SELECT 
                clase.idPlan, 
                clase.horaInicio horaInicioLunes, 
                clase.horaFin horaFinLunes, 
                aula.sector sectorAulaLunes, 
                aula.nombre nombreAulaLunes,
                clase.fechaEdicion fechaEdicionLunes
           FROM clase
           INNER JOIN aula on aula.id = clase.idAula AND clase.diaSemana = 1) lunes on lunes.idPlan = plan.id
LEFT JOIN (SELECT 
                clase.idPlan, 
                clase.horaInicio horaInicioMartes, 
                clase.horaFin horaFinMartes, 
                aula.sector sectorAulaMartes, 
                aula.nombre nombreAulaMartes,
                clase.fechaEdicion fechaEdicionMartes
           FROM clase
           INNER JOIN aula on aula.id = clase.idAula AND clase.diaSemana = 2) martes on martes.idPlan = plan.id
LEFT JOIN (SELECT 
                clase.idPlan, 
                clase.horaInicio horaInicioMiercoles, 
                clase.horaFin horaFinMiercoles, 
                aula.sector sectorAulaMiercoles, 
                aula.nombre nombreAulaMiercoles,
                clase.fechaEdicion fechaEdicionMiercoles
           FROM clase
           INNER JOIN aula on aula.id = clase.idAula AND clase.diaSemana = 3) miercoles on miercoles.idPlan = plan.id
LEFT JOIN (SELECT 
                clase.idPlan, 
                clase.horaInicio horaInicioJueves, 
                clase.horaFin horaFinJueves, 
                aula.sector sectorAulaJueves, 
                aula.nombre nombreAulaJueves,
                clase.fechaEdicion fechaEdicionJueves
           FROM clase
           INNER JOIN aula on aula.id = clase.idAula AND clase.diaSemana = 4) jueves on jueves.idPlan = plan.id
LEFT JOIN (SELECT 
                clase.idPlan, 
                clase.horaInicio horaInicioViernes, 
                clase.horaFin horaFinViernes, 
                aula.sector sectorAulaViernes, 
                aula.nombre nombreAulaViernes,
                clase.fechaEdicion fechaEdicionViernes
           FROM clase
           INNER JOIN aula on aula.id = clase.idAula AND clase.diaSemana = 5) viernes on viernes.idPlan = plan.id
LEFT JOIN (SELECT 
                clase.idPlan, 
                clase.horaInicio horaInicioSabado, 
                clase.horaFin horaFinSabado, 
                aula.sector sectorAulaSabado, 
                aula.nombre nombreAulaSabado,
                clase.fechaEdicion fechaEdicionSabado
           FROM clase
           INNER JOIN aula on aula.id = clase.idAula AND clase.diaSemana = 6) sabado on sabado.idPlan = plan.id
 WHERE 
 lunes.idPlan is not null OR
 martes.idPlan is not null OR
 miercoles.idPlan is not null OR
 jueves.idPlan is not null OR
 viernes.idPlan is not null OR
 sabado.idPlan is not null
 
 */

