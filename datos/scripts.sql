Proyectos sin director

SELECT * FROM proyecto P1 WHERE NOT EXISTS (SELECT P.cd_proyecto FROM proyecto P LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto LEFT JOIN docente D ON I.cd_docente = D.cd_docente  WHERE P.cd_estado = 3 AND I.cd_tipoinvestigador = 1 AND ds_codigo LIKE '%%' AND dt_fin > '2009-12-31' AND P1.cd_proyecto = P.cd_proyecto)


###############Exportar a NO categorizados#######################

#####################investigadores###########################
SELECT DISTINCT ds_nombre, ds_apellido, nu_documento, C.ds_categoria, I.cd_tipoinvestigador, U.ds_universidad
FROM docente AS D
LEFT JOIN universidad AS U ON D.cd_universidad = U.cd_universidad
LEFT JOIN categoria AS C ON D.cd_categoria = C.cd_categoria
INNER JOIN integrante AS I ON D.cd_docente = I.cd_docente
INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto
WHERE P.cd_estado =5 AND (I.cd_tipoinvestigador = 6 OR I.cd_tipoinvestigador = 2 OR (U.cd_universidad <> 11 AND D.cd_categoria <> 1 AND D.cd_categoria <> 11) OR SUBSTRING(P.ds_codigo,1,4)='PPID') 

#####################integrantes (no se usa mas)###########################
SELECT I.cd_proyecto, I.cd_docente, nu_documento, CONCAT(SUBSTRING(dt_alta,9,2),'/',SUBSTRING(dt_alta,6,2),'/',SUBSTRING(dt_alta,1,4)) as dt_alta, CONCAT(SUBSTRING(dt_baja,9,2),'/',SUBSTRING(dt_baja,6,2),'/',SUBSTRING(dt_baja,1,4)) as dt_baja, P.ds_codigo, I.nu_horasinv, I.cd_tipoinvestigador, U.ds_universidad FROM integrante I INNER JOIN docente D ON I.cd_docente = D.cd_docente INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto LEFT JOIN universidad AS U ON D.cd_universidad = U.cd_universidad
LEFT JOIN categoria AS C ON D.cd_categoria = C.cd_categoria WHERE (dt_alta = '2015-01-01' OR dt_baja >= '2015-01-01') AND I.cd_estado = 3 AND (I.cd_tipoinvestigador = 6 OR I.cd_tipoinvestigador = 2 OR (U.cd_universidad <> 11 AND D.cd_categoria <> 1 AND D.cd_categoria <> 11) OR SUBSTRING(P.ds_codigo,1,4)='PPID')	

#####################proyectos PPID (no se usa mas)###########################
SELECT NULL, P.cd_proyecto, NULL, P.ds_codigo,P.ds_titulo,NULL,CONCAT(SUBSTRING(P.dt_ini,9,2),'/',SUBSTRING(P.dt_ini,6,2),'/',SUBSTRING(P.dt_ini,1,4)) as dt_ini,CONCAT(SUBSTRING(P.dt_fin,9,2),'/',SUBSTRING(P.dt_fin,6,2),'/',SUBSTRING(P.dt_fin,1,4)) as dt_fin,CONCAT(SUBSTRING(P.dt_inc,9,2),'/',SUBSTRING(P.dt_inc,6,2),'/',SUBSTRING(P.dt_inc,1,4)) as dt_inc, LPAD(P.cd_facultad, 8, '0'), NULL, LPAD(P.cd_campo, 8, '0'), LPAD(P.cd_especialidad, 8, '0'), LPAD(P.cd_disciplina, 8, '0'), NULL, NULL,P.ds_linea,P.ds_tipo, U.ds_codigo, NULL, NULL, NULL  FROM proyecto P LEFT JOIN unidad U ON P.cd_unidad = U.cd_unidad WHERE cd_tipoacreditacion = 2 AND cd_estado = 5

#####################cambio de colaborador (no se usa mas)###########################
SELECT I.cd_proyecto, I.cd_docente, nu_documento, CONCAT(SUBSTRING(dt_alta,9,2),'/',SUBSTRING(dt_alta,6,2),'/',SUBSTRING(dt_alta,1,4)) as dt_alta, CONCAT(SUBSTRING(dt_baja,9,2),'/',SUBSTRING(dt_baja,6,2),'/',SUBSTRING(dt_baja,1,4)) as dt_baja, P.ds_codigo, I.nu_horasinv, I.cd_tipoinvestigador, U.ds_universidad FROM integrante I INNER JOIN docente D ON I.cd_docente = D.cd_docente INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto LEFT JOIN universidad AS U ON D.cd_universidad = U.cd_universidad
LEFT JOIN categoria AS C ON D.cd_categoria = C.cd_categoria WHERE (dt_alta >= '2015-01-01' OR dt_baja >= '2015-01-01') AND I.cd_estado = 3 AND I.cd_tipoinvestigador <> 6 

#####################proyectos nuevos###########################
SELECT P.cd_proyecto, P.ds_codigo,P.ds_titulo,CONCAT(SUBSTRING(P.dt_ini,9,2),'/',SUBSTRING(P.dt_ini,6,2),'/',SUBSTRING(P.dt_ini,1,4)) as dt_ini,CONCAT(SUBSTRING(P.dt_fin,9,2),'/',SUBSTRING(P.dt_fin,6,2),'/',SUBSTRING(P.dt_fin,1,4)) as dt_fin, LPAD(P.cd_facultad, 8, '0') as cd_facultad, LPAD(P.cd_campo, 8, '0') as cd_campo, LPAD(P.cd_especialidad, 8, '0') as cd_especialidad, LPAD(P.cd_disciplina, 8, '0') as cd_disciplina,P.ds_linea,P.ds_tipo, U.ds_codigo as ds_unidad  FROM proyecto P LEFT JOIN unidad U ON P.cd_unidad = U.cd_unidad WHERE P.dt_ini = '2017-01-01' AND cd_estado = 5

#####################integrantes nuevos (OJO!!!!!!!!!!!! según los estados hacer modificaciones antes de insertarlos)###########################
SELECT I.cd_proyecto, I.cd_docente, nu_documento, CONCAT(SUBSTRING(dt_alta,9,2),'/',SUBSTRING(dt_alta,6,2),'/',SUBSTRING(dt_alta,1,4)) as dt_alta, CONCAT(SUBSTRING(dt_baja,9,2),'/',SUBSTRING(dt_baja,6,2),'/',SUBSTRING(dt_baja,1,4)) as dt_baja, P.ds_codigo, I.nu_horasinv, I.cd_tipoinvestigador, U.ds_universidad, I.cd_estado FROM integrante I INNER JOIN docente D ON I.cd_docente = D.cd_docente INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto LEFT JOIN universidad AS U ON D.cd_universidad = U.cd_universidad
LEFT JOIN categoria AS C ON D.cd_categoria = C.cd_categoria WHERE dt_alta = '2017-01-01' AND (I.cd_tipoinvestigador = 6 OR I.cd_tipoinvestigador = 2 OR (U.cd_universidad <> 11 AND D.cd_categoria <> 1 AND D.cd_categoria <> 11) OR SUBSTRING(P.ds_codigo,1,4)='PPID')	


###############Para insertar al SIPIM#######################
SELECT ds_investigador, P.ds_codigo, I.dt_alta, I.dt_baja, ds_tipoinvestigador FROM no_insertados as NI INNER JOIN docente as D on NI.nu_documento = D.nu_documento INNER JOIN integrante as I ON D.cd_docente = I.cd_docente INNER JOIN proyecto as P ON I.cd_proyecto = P.cd_proyecto INNER JOIN tipoinvestigador as TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador WHERE P.cd_estado = 5 and P.ds_codigo LIKE '11/%'
ORDER BY P.ds_codigo ASC, ds_investigador

##################Actualizar integrantes con una tabla anterior####################
UPDATE integrante SET integrante.cd_tipoinvestigador=(SELECT integrante_vieja.cd_tipoinvestigador FROM integrante_vieja WHERE integrante.cd_docente = integrante_vieja.cd_docente AND integrante.cd_proyecto = integrante_vieja.cd_proyecto)
WHERE integrante.cd_tipoinvestigador = 0 AND EXISTS (SELECT integrante_vieja.cd_tipoinvestigador FROM integrante_vieja WHERE integrante_vieja.cd_tipoinvestigador != 1 AND integrante_vieja.cd_tipoinvestigador != 6 AND integrante_vieja.cd_tipoinvestigador != 0 AND integrante_vieja.cd_tipoinvestigador != 2 AND integrante.cd_docente = integrante_vieja.cd_docente AND integrante.cd_proyecto = integrante_vieja.cd_proyecto)

####################Eliminar los proyectos creados en año anterior########################
DELETE  I, P
FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto
WHERE P.cd_estado = 1 AND P.dt_ini = '2015-01-01' AND (P.cd_tipoacreditacion = 1 OR P.cd_tipoacreditacion = 2)

####################Altas, Bajas y Cambios NO recibidos########################
SELECT I.cd_docente, P.cd_proyecto, P.ds_codigo,CONCAT(DOCDIR.ds_apellido,', ',DOCDIR.ds_nombre) as DIRECTOR, F.ds_facultad, E.ds_estado, CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador,  D.nu_documento,  I.dt_alta, I.dt_baja, U.cd_usuario, E.cd_estado  FROM docente D INNER JOIN integrante I ON D.cd_docente = I.cd_docente INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto INNER JOIN estadointegrante E ON I.cd_estado = E.cd_estado INNER JOIN facultad F ON P.cd_facultad = F.cd_facultad INNER JOIN integrante DIR ON P.cd_proyecto = DIR.cd_proyecto INNER JOIN docente DOCDIR ON DIR.cd_docente = DOCDIR.cd_docente INNER JOIN usuarioproyecto U ON DOCDIR.nu_documento = U.nu_documento
WHERE I.cd_estado != 3 AND DIR.cd_tipoinvestigador = 1
ORDER BY P.ds_codigo,D.ds_apellido,D.ds_nombre

####################Eliminar Altas, Bajas y Cambios Creados########################
DELETE FROM integrante WHERE cd_estado = 1
UPDATE integrante SET cd_estado = 3, dt_baja = '0000-00-0', ds_consecuencias='' WHERE cd_estado = 4
UPDATE integrante SET cd_estado = 3, dt_altapendiente = '0000-00-0', nu_horasinv='0', cd_tipoinvestigador = 6 WHERE cd_estado = 6

UPDATE proyecto SET bl_altapendiente = 0, bl_bajapendiente = 0

##################Actualizar abstracts y palabras claves####################
UPDATE proyecto p, abstracts pp
SET p.ds_abstract1 = pp.TXT1
WHERE p.ds_codigo = pp.PR_ID
AND p.dt_ini < '2012-01-01' AND p.ds_codigo <>'' AND (p.ds_abstract1 IS NULL
OR p.ds_abstract1 = '')

UPDATE proyecto p, abstracts pp
SET p.ds_clave1 = pp.CAMP1,
p.ds_clave2 = pp.CAMP2,
p.ds_clave3 = pp.CAMP3,
p.ds_clave4 = pp.CAMP4,
p.ds_clave5 = pp.CAMP5,
p.ds_clave6 = pp.CAMP6 
WHERE p.ds_codigo = pp.PR_ID
AND p.dt_ini < '2012-01-01' AND p.ds_codigo <>'' AND (p.ds_clave1 IS NULL
OR p.ds_clave1 = '')

########################## Docentes con proyectos en ejecución 2015 #####################
############ DED EX
SELECT D.* FROM docente D
WHERE D.cd_deddoc = 1 AND D.cd_universidad IN (11,0) AND EXISTS (SELECT I.cd_docente FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
WHERE P.dt_fin > '2015-01-01' AND P.cd_estado = 5 AND I.cd_tipoinvestigador <> 6 AND I.cd_estado = 3 AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2015-01-01') AND I.cd_docente = D.cd_docente)

############ DED SE
SELECT D.* FROM docente D
WHERE D.cd_deddoc IN (2,6) AND D.cd_universidad IN (11,0) AND EXISTS (SELECT I.cd_docente FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
WHERE P.dt_fin > '2015-01-01' AND P.cd_estado = 5 AND I.cd_tipoinvestigador <> 6 AND I.cd_estado = 3 AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2015-01-01') AND I.cd_docente = D.cd_docente)

############ DED SI
SELECT D.* FROM docente D
WHERE D.cd_deddoc IN (3,5) AND D.cd_organismo in (1,2) AND D.cd_carrerainv NOT IN (10,11) AND D.cd_universidad IN (11,0) AND EXISTS (SELECT I.cd_docente FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
WHERE P.dt_fin > '2015-01-01' AND P.cd_estado = 5 AND I.cd_tipoinvestigador <> 6 AND I.cd_estado = 3 AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2015-01-01') AND I.cd_docente = D.cd_docente)

#### opcional cic/conicet AND D.cd_organismo in (1,2) AND D.cd_carrerainv NOT IN (10,11)

########################## Proyectos en ejecución 2014 #####################
############### I+D ######################
SELECT *  FROM proyecto WHERE dt_fin > '2013-12-31' AND dt_ini < '2015-01-01' AND cd_estado = 5 AND cd_tipoacreditacion = 1

############### PPID ######################
SELECT *  FROM proyecto WHERE dt_fin > '2013-12-31' AND dt_ini < '2015-01-01' AND cd_estado = 5 AND cd_tipoacreditacion = 2

############### PIT-AP ######################
SELECT *  FROM proyecto WHERE dt_fin > '2013-12-31' AND dt_ini < '2015-01-01' AND cd_estado = 5 AND cd_tipoacreditacion = 3

############### PIO ######################

################################
bajas y altas creadas y no enviadas

SELECT ds_codigo as Proyecto,dt_ini as Inicio,dt_fin as Fin, CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',nu_postcuil) as CUIL, TI.ds_tipoinvestigador as Tipo, CASE I.dt_alta WHEN '0000-00-00' THEN '' ELSE I.dt_alta END as Alta, CASE I.dt_baja WHEN '0000-00-00' THEN '' ELSE I.dt_baja END as Baja, F.ds_facultad, EI.ds_estado, I.cd_docente, I.cd_proyecto FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto LEFT JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN tipoinvestigador TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad INNER JOIN estadointegrante EI ON I.cd_estado = EI.cd_estado WHERE (I.cd_estado=1 or I.cd_estado=4) ORDER BY ds_codigo, D.ds_apellido, D.ds_nombre


########################################Docentes con titulos de posgrado con proyectos en ejecución 2014 #######################################
SELECT D.*, T.ds_titulo 
FROM docente D INNER JOIN titulo T ON D.cd_titulopost = T.cd_titulo
WHERE EXISTS (SELECT I.cd_docente FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
WHERE P.dt_fin > '2014-01-01' AND P.cd_estado = 5 AND I.cd_tipoinvestigador <> 6 AND I.cd_estado = 3 AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2014-01-01') AND I.cd_docente = D.cd_docente) 
ORDER BY D.cd_docente ASC

####################Listado de Proyectos en ejecución INFORMES############################
SELECT P.ds_codigo as Proyecto, ds_titulo as Titulo, CONCAT(SUBSTRING(dt_ini,9,2),'/',SUBSTRING(dt_ini,6,2),'/',SUBSTRING(dt_ini,1,4)) as Inicio,
CONCAT(SUBSTRING(dt_fin,9,2),'/',SUBSTRING(dt_fin,6,2),'/',SUBSTRING(dt_fin,1,4)) as Fin,CONCAT(D.ds_apellido,', ',D.ds_nombre) as Director, 
F.ds_facultad as Facultad, CASE P.dt_fin WHEN '2020-12-31' THEN 'Final' ELSE CASE P.dt_ini WHEN '2020-01-01' THEN 'Reducido' 
ELSE CASE P.dt_ini WHEN '2018-01-01' THEN 'Reducido' ELSE 'Bienal' END END END AS Tipo_Informe
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente 
LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad
WHERE P.cd_tipoacreditacion = 1 AND P.cd_estado=5 AND dt_fin > '2019-12-31' AND dt_ini < '2021-01-01' AND I.cd_tipoinvestigador = 1
ORDER BY P.ds_codigo

####################Listado de Proyectos en ejecución INFORMES (especial pandemia por prórrogas)############################
SELECT P.ds_codigo as Proyecto, ds_titulo as Titulo, CONCAT(SUBSTRING(dt_ini,9,2),'/',SUBSTRING(dt_ini,6,2),'/',SUBSTRING(dt_ini,1,4)) as Inicio,
CONCAT(SUBSTRING(dt_fin,9,2),'/',SUBSTRING(dt_fin,6,2),'/',SUBSTRING(dt_fin,1,4)) as Fin,CONCAT(D.ds_apellido,', ',D.ds_nombre) as Director, 
F.ds_facultad as Facultad, CASE P.dt_fin WHEN '2020-12-31' THEN 'Final' ELSE CASE P.dt_ini WHEN '2020-01-01' THEN 'Reducido' 
ELSE CASE P.dt_ini WHEN '2018-01-01' THEN 'Bienal' ELSE CASE P.dt_fin WHEN '2022-12-31' THEN 'Bienal' ELSE CASE P.dt_fin WHEN '2021-12-31' THEN 'Reducido' ELSE 'Bienal' END END END END END AS Tipo_Informe
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente 
LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad
WHERE P.cd_tipoacreditacion = 1 AND P.cd_estado=5 AND dt_fin > '2019-12-31' AND dt_ini < '2021-01-01' AND I.cd_tipoinvestigador = 1 AND dt_fin <> '2020-01-01'
ORDER BY P.ds_codigo

####################Listado de Proyectos Cargados con integrantes para controlar informes############################
SELECT P.ds_codigo as Proyecto, '' as TipoProyecto, ds_titulo as Titulo, CONCAT(SUBSTRING(dt_ini,9,2),'/',SUBSTRING(dt_ini,6,2),'/',SUBSTRING(dt_ini,1,4)) as Inicio,CONCAT(SUBSTRING(dt_fin,9,2),'/',SUBSTRING(dt_fin,6,2),'/',SUBSTRING(dt_fin,1,4)) as Fin, E.ds_estado as Estado, CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) as CUIL, D.ds_mail As Mail, TI.ds_tipoinvestigador as Tipo, CONCAT(SUBSTRING(I.dt_alta,9,2),'/',SUBSTRING(I.dt_alta,6,2),'/',SUBSTRING(I.dt_alta,1,4)) as Alta, CONCAT(SUBSTRING(I.dt_baja,9,2),'/',SUBSTRING(I.dt_baja,6,2),'/',SUBSTRING(I.dt_baja,1,4)) as Baja, F.ds_facultad As Facultad, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, CAT.ds_categoria as Categoria, D.nu_dedinv as Ded_Inv, CONCAT(D.ds_tipobeca,'-',D.ds_orgbeca) as Becario, CI.ds_carrerainv Carr_Inv, O.ds_organismo as Organismo, U.ds_universidad, FI.ds_facultad as Facultad_Int, TI.cd_tipoinvestigador, I.nu_horasinv, estadointegrante.ds_estado as Estado 
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente
LEFT JOIN estadointegrante E ON E.cd_estado = I.cd_estado 
LEFT JOIN tipoinvestigador TI ON TI.cd_tipoinvestigador = I.cd_tipoinvestigador 
LEFT JOIN facultad F ON F.cd_facultad = P.cd_facultad
LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
LEFT JOIN carrerainv CI ON CI.cd_carrerainv = D.cd_carrerainv
LEFT JOIN organismo O ON O.cd_organismo = D.cd_organismo
LEFT JOIN universidad U ON U.cd_universidad = D.cd_universidad
LEFT JOIN facultad FI ON FI.cd_facultad = D.cd_facultad
INNER JOIN cyt_integrante_estado ON(cyt_integrante_estado.integrante_oid = I.oid) 
  LEFT JOIN estadointegrante ON(cyt_integrante_estado.estado_oid = estadointegrante.cd_estado) 
WHERE cyt_integrante_estado.fechaHasta is null AND P.cd_tipoacreditacion = 1 AND P.cd_estado=5 AND dt_fin > '2018-12-31' AND dt_ini < '2020-01-01' AND (I.dt_baja != I.dt_alta  OR I.dt_baja is null)
ORDER BY P.ds_codigo

####################Listado de Proyectos Cargados con integrantes para controlar con SIU############################
SELECT P.ds_codigo as Proyecto, ds_titulo as Titulo, CONCAT(SUBSTRING(dt_ini,9,2),'/',SUBSTRING(dt_ini,6,2),'/',SUBSTRING(dt_ini,1,4)) as Inicio,CONCAT(SUBSTRING(dt_fin,9,2),'/',SUBSTRING(dt_fin,6,2),'/',SUBSTRING(dt_fin,1,4)) as Fin, E.ds_estado as Estado, CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) as CUIL, D.ds_mail As Mail, TI.ds_tipoinvestigador as Tipo, CONCAT(SUBSTRING(dt_alta,9,2),'/',SUBSTRING(dt_alta,6,2),'/',SUBSTRING(dt_alta,1,4)) as Alta, CONCAT(SUBSTRING(dt_baja,9,2),'/',SUBSTRING(dt_baja,6,2),'/',SUBSTRING(dt_baja,1,4)) as Baja, F.ds_facultad As Facultad, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, CAT.ds_categoria as Categoria, D.nu_dedinv as Ded_Inv, CONCAT(D.ds_tipobeca,'-',D.ds_orgbeca) as Becario, CI.ds_carrerainv Carr_Inv, O.ds_organismo as Organismo, U.ds_universidad, FI.ds_facultad as Facultad_Int, TI.cd_tipoinvestigador, I.nu_horasinv 
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente
LEFT JOIN estadointegrante E ON E.cd_estado = I.cd_estado 
LEFT JOIN tipoinvestigador TI ON TI.cd_tipoinvestigador = I.cd_tipoinvestigador 
LEFT JOIN facultad F ON F.cd_facultad = P.cd_facultad
LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
LEFT JOIN carrerainv CI ON CI.cd_carrerainv = D.cd_carrerainv
LEFT JOIN organismo O ON O.cd_organismo = D.cd_organismo
LEFT JOIN universidad U ON U.cd_universidad = D.cd_universidad
LEFT JOIN facultad FI ON FI.cd_facultad = D.cd_facultad
WHERE dt_ini = '2016-01-01' AND dt_fin > '2018-12-31' AND P.cd_estado = 5 AND P.cd_tipoacreditacion = 1 AND (I.dt_baja != I.dt_alta OR I.dt_baja is null)
ORDER BY P.ds_codigo


####################Listado de integrantes de proyectos categorizados############################
SELECT P.ds_codigo as Proyecto, ds_titulo as Titulo, CONCAT(SUBSTRING(dt_ini,9,2),'/',SUBSTRING(dt_ini,6,2),'/',SUBSTRING(dt_ini,1,4)) as Inicio,CONCAT(SUBSTRING(dt_fin,9,2),'/',SUBSTRING(dt_fin,6,2),'/',SUBSTRING(dt_fin,1,4)) as Fin, E.ds_estado as Estado, CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) as CUIL, D.ds_mail As Mail, TI.ds_tipoinvestigador as Tipo, CONCAT(SUBSTRING(dt_alta,9,2),'/',SUBSTRING(dt_alta,6,2),'/',SUBSTRING(dt_alta,1,4)) as Alta, CONCAT(SUBSTRING(dt_baja,9,2),'/',SUBSTRING(dt_baja,6,2),'/',SUBSTRING(dt_baja,1,4)) as Baja, F.ds_facultad As Facultad, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, CAT.ds_categoria as Categoria, D.nu_dedinv as Ded_Inv, CONCAT(D.ds_tipobeca,'-',D.ds_orgbeca) as Becario, CI.ds_carrerainv Carr_Inv, O.ds_organismo as Organismo, U.ds_universidad, FI.ds_facultad as Facultad_Int, TI.cd_tipoinvestigador, I.nu_horasinv 
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto
LEFT JOIN docente D ON I.cd_docente = D.cd_docente 
LEFT JOIN estadointegrante E ON E.cd_estado = I.cd_estado 
LEFT JOIN tipoinvestigador TI ON TI.cd_tipoinvestigador = I.cd_tipoinvestigador
LEFT JOIN facultad F ON F.cd_facultad = P.cd_facultad
LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
LEFT JOIN carrerainv CI ON CI.cd_carrerainv = D.cd_carrerainv
LEFT JOIN organismo O ON O.cd_organismo = D.cd_organismo
LEFT JOIN universidad U ON U.cd_universidad = D.cd_universidad
LEFT JOIN facultad FI ON FI.cd_facultad = D.cd_facultad
WHERE dt_fin > '2015-12-31' AND P.cd_estado = 5 AND P.cd_tipoacreditacion = 1 AND D.cd_categoria in (6,7,8,9,10) AND D.cd_universidad = 11 
AND I.cd_tipoinvestigador != 6  AND I.cd_estado = 3
ORDER BY P.ds_codigo






####################Actualizar nuevas categorías############################
SELECT CN.* FROM categorizados_nuevos CN WHERE NOT EXISTS (SELECT D.nu_documento FROM docente D WHERE D.nu_documento = CN.nu_documento)

SELECT D.nu_documento, D.ds_apellido, D.cd_categoria, CN.cd_categoria, I.oid, I.cd_categoria, E.oid, E.categoria_oid 
FROM docente D INNER JOIN categorizados_nuevos CN ON D.nu_documento = CN.nu_documento
INNER JOIN integrante I ON I.cd_docente = D.cd_docente
INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto AND P.dt_fin > '2016-01-01' 
INNER JOIN cyt_integrante_estado E ON I.oid = E.integrante_oid


UPDATE docente INNER JOIN categorizados_nuevos ON docente.nu_documento = categorizados_nuevos.nu_documento
SET docente.cd_categoria = categorizados_nuevos.cd_categoria;

UPDATE docente INNER JOIN categorizados_nuevos ON docente.nu_documento = categorizados_nuevos.nu_documento
INNER JOIN integrante ON integrante.cd_docente = docente.cd_docente
INNER JOIN proyecto ON integrante.cd_proyecto = proyecto.cd_proyecto AND proyecto.dt_fin > '2016-01-01' 
SET integrante.cd_categoria = categorizados_nuevos.cd_categoria
WHERE integrante.oid IS NOT NULL;

UPDATE docente INNER JOIN categorizados_nuevos ON docente.nu_documento = categorizados_nuevos.nu_documento
INNER JOIN integrante ON integrante.cd_docente = docente.cd_docente
INNER JOIN proyecto ON integrante.cd_proyecto = proyecto.cd_proyecto AND proyecto.dt_fin > '2016-01-01' 
INNER JOIN cyt_integrante_estado ON integrante.oid = cyt_integrante_estado.integrante_oid
SET cyt_integrante_estado.categoria_oid = categorizados_nuevos.cd_categoria, cyt_integrante_estado.motivo = CONCAT(motivo, '.\r\nCategoría actualizada el ',now())
WHERE cyt_integrante_estado.oid IS NOT NULL AND cyt_integrante_estado.fechaHasta IS NULL;

UPDATE cyt_unidad_integrante INNER JOIN categorizados_nuevos ON cyt_unidad_integrante.cuil = CONCAT(categorizados_nuevos.nu_precuil,'-',LPAD(categorizados_nuevos.nu_documento,8,'0'),'-',categorizados_nuevos.nu_postcuil) 
SET cyt_unidad_integrante.categoria_oid = categorizados_nuevos.cd_categoria
WHERE cyt_unidad_integrante.categoria_oid != categorizados_nuevos.cd_categoria;

########################################Control de categorías ###################################################33
SELECT ds_apellido, cd_categoria FROM docente WHERE cd_categoria = 10 AND nu_documento = '10502292'

SELECT D.nu_documento, D.ds_apellido, D.cd_categoria, CN.cd_categoria
FROM docente D INNER JOIN categorizados_nuevos CN ON D.nu_documento = CN.nu_documento
WHERE D.cd_categoria != CN.cd_categoria




############################################CALCULO DE SUBSIDIOS AUTOMATICOS ##############################################################
####################Listado de Proyectos en ejecución SUBSIDIOS############################
SELECT P.ds_codigo as Proyecto, CONCAT(SUBSTRING(dt_ini,9,2),'/',SUBSTRING(dt_ini,6,2),'/',SUBSTRING(dt_ini,1,4)) as Inicio,
CONCAT(SUBSTRING(dt_fin,9,2),'/',SUBSTRING(dt_fin,6,2),'/',SUBSTRING(dt_fin,1,4)) as Fin,CONCAT(D.ds_apellido,', ',D.ds_nombre) as Director, 
F.ds_facultad as Facultad
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente 
LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad
WHERE P.cd_tipoacreditacion = 1 AND P.cd_estado=5 AND dt_fin > '2020-12-31' AND I.cd_tipoinvestigador = 1
ORDER BY P.ds_codigo

####################Integrantes para subsidios automaticos############################
SELECT P.ds_codigo, P.dt_ini, P.dt_fin,D.nu_documento,CASE I.cd_tipoinvestigador WHEN '1' THEN '-1' ELSE '' END as director, CASE I.dt_alta WHEN '0000-00-00' THEN '' ELSE I.dt_alta END as dt_alta´, CASE I.dt_baja WHEN '0000-00-00' THEN '' ELSE I.dt_baja END as dt_baja, E.estado_oid as cd_estado, C.ds_categoria, CASE D.cd_deddoc WHEN '5' THEN '1' WHEN '6' THEN '1' ELSE D.cd_deddoc END as cd_deddoc, D.cd_universidad, CONCAT(D.ds_apellido,', ',D.ds_nombre) AS ds_integrantes 
FROM integrante I 
INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
INNER JOIN docente D ON I.cd_docente = D.cd_docente 
LEFT JOIN categoria C ON D.cd_categoria = C.cd_categoria
INNER JOIN cyt_integrante_estado E ON E.integrante_oid = I.oid AND E.fechaHasta IS NULL

WHERE I.cd_tipoinvestigador <> 6 AND P.cd_tipoacreditacion = 1 AND P.cd_estado = 5 AND P.dt_fin > '2020-12-31' 

####################Integrantes para subsidios automaticos (contando los becarios e inv de carr como EX siempre que tengan cargo)############################
SELECT P.ds_codigo, P.dt_ini, P.dt_fin,D.nu_documento,CASE I.cd_tipoinvestigador WHEN '1' THEN '-1' ELSE '' END as director, 
CASE I.dt_alta WHEN '0000-00-00' THEN '' ELSE I.dt_alta END as dt_alta´, CASE I.dt_baja WHEN '0000-00-00' THEN '' ELSE I.dt_baja END as dt_baja, 
E.estado_oid as cd_estado, C.ds_categoria, CASE  WHEN D.cd_deddoc IN (1,2,3) THEN (CASE  WHEN D.cd_carrerainv IN (1,2,3,4,5,6,8,9,10,12,13) 
THEN '1' ELSE (CASE  WHEN beca.cd_beca IS NULL THEN (CASE WHEN D.dt_becaHasta > '2020-01-01' OR D.dt_becaHasta IS NULL THEN (CASE D.ds_orgbeca WHEN 'CONICET' THEN '1' 
WHEN 'CIC' THEN '1' ELSE D.cd_deddoc END) ELSE D.cd_deddoc END) ELSE '1' END) END) ELSE D.cd_deddoc END AS cd_deddoc, 
D.cd_universidad, CONCAT(D.ds_apellido,', ',D.ds_nombre) AS ds_integrantes, E.nu_horasinv 
FROM integrante I 
INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
INNER JOIN docente D ON I.cd_docente = D.cd_docente 
LEFT JOIN categoria C ON D.cd_categoria = C.cd_categoria
INNER JOIN cyt_integrante_estado E ON E.integrante_oid = I.oid AND E.fechaHasta IS NULL
LEFT JOIN beca ON D.cd_docente = beca.cd_docente AND beca.dt_hasta > '2020-01-01'
WHERE I.cd_tipoinvestigador <> 6 AND P.cd_tipoacreditacion = 1 AND P.cd_estado = 5 AND P.dt_fin > '2020-01-01' AND (E.dt_baja is null OR E.dt_alta != E.dt_baja)

####################Proyectos para subsidios automaticos############################
SELECT P.ds_codigo,P.dt_ini,P.dt_fin,D.nu_documento,CONCAT(D.ds_apellido,', ',D.ds_nombre)  as director, D.nu_ident, F.ds_facultad, P.cd_unidad, CASE  WHEN unidadaprobada.cd_unidad IS NULL THEN 0 else 4 END AS ORD
FROM integrante I 
INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
INNER JOIN docente D ON I.cd_docente = D.cd_docente 
INNER JOIN facultad F ON P.cd_facultad = F.cd_facultad
LEFT JOIN unidadaprobada ON unidadaprobada.cd_unidad = P.cd_unidad AND unidadaprobada.cd_periodo = 10
WHERE I.cd_tipoinvestigador = 1 AND P.cd_tipoacreditacion = 1 AND P.cd_estado = 5 AND P.dt_fin > '2020-01-01'



##########################################Evaluacion de integrantes en informes############################################################
SELECT distinct T.codigo as 'CODIGO TRAMITE',
FIT_codigo.valor as 'CODIGO PROYECTO',

PRO.denominacion as 'DIRECTOR',
FIT_inicio.valor as 'INICIO',
FIT_fin.valor as 'FIN',
C.denominacion as 'PERIODO',
PE.apellido as 'APELLIDO INTEGRANTE',
PE.nombre as 'NOMBRE INTEGRANTE',
PE.cuil as 'CUIL INTEGRANTE',
DP.tipo_documento as 'TIPO DOCUMENTO',
DP.numero_documento AS 'DNI INTEGRANTE',
RG.rol_grupo as 'ROL INTEGRANTE',
TR.tipo_recomendacion AS 'EVALUACION', GP.fecha_baja, GPTRT.*


FROM TRAMITE T
INNER JOIN CONVOCATORIA C ON T.convocatoria_id = C.id
INNER JOIN PROPIETARIO PRO ON T.propietario_id = PRO.id
INNER JOIN PROPIETARIO_GRUPO PG ON PG.propietario_id = PRO.id
INNER JOIN GRUPO G ON PG.grupo_id = G.id



INNER JOIN FORMULARIO_INSTRUMENTO_TRAMITE FIT_codigo ON FIT_codigo.tramite_id=T.id AND FIT_codigo.instrumento_variable_opcion_id=227
INNER JOIN FORMULARIO_INSTRUMENTO_TRAMITE FIT_inicio ON FIT_inicio.tramite_id=T.id AND FIT_inicio.instrumento_variable_opcion_id=228
INNER JOIN FORMULARIO_INSTRUMENTO_TRAMITE FIT_fin ON FIT_fin.tramite_id=T.id AND FIT_fin.instrumento_variable_opcion_id=229


INNER JOIN GRUPO_PERSONA GP ON GP.grupo_id = G.id  -- AND GP.fecha_fin_vigencia IS NULL
INNER JOIN PERSONA PE ON GP.persona_id = PE.id
INNER JOIN DATO_PERSONAL DP ON DP.persona_id = PE.id and DP.fecha_fin_vigencia is NULL
INNER JOIN ROL_GRUPO RG ON RG.id = GP.rol_grupo_id

LEFT JOIN GRUPO_PERSONA_TIPO_RECOMENDACION_TRAMITE GPTRT ON GPTRT.tramite_id=T.id and GPTRT.grupo_persona_id = GP.id
LEFT JOIN TIPO_RECOMENDACION TR ON TR.id = GPTRT.tipo_recomendacion_id

WHERE

(T.estado_id=2 or T.estado_id=11 or T.estado_id=17 )
AND
(C.id = 402202001
OR C.id = 402202002
OR C.id = 402202003
) AND GP.fecha_baja is null
-- T.codigo='40220190300416LP'
#¿NOMBRE?
-- (GP.fecha_fin_vigencia IS NULL or (GP.fecha_fin_vigencia IS NOT NULL and GP.habilitado=0))

ORDER BY T.id

####################OJO!!!! con la evaluacion de los integrantes en los informes porque la mayoría de los proyectos tienen
el código de SIGEVA y hay que actualizarlos mediante la tabla integantes_infomes de la web############################

UPDATE integrantes_informes INNER JOIN proyecto ON integrantes_informes.CODIGO_PROYECTO = proyecto.ds_codigoSIGEVA
SET integrantes_informes.CODIGO_PROYECTO = proyecto.ds_codigo


###################################################Los calculos los sigo haciendo en access y luego exporto a mysql (NO USO MYSQL)#########################


##########################Actualizo la cantidad de proyectos de la misma facultad que está cada Director #################################
update DIRPROY D1
inner join (SELECT D2.DIR_ID as ID, count(D2.DIR_ID) AS cant
FROM DIRPROY D2
WHERE 1
GROUP BY substr(D2.PR_ID,1,1), D2.DIR_ID
  ) t 
  on (t.ID = D1.DIR_ID)
set D1.NUMDIRFAC = t.cant;


##########################Actualizo la cantidad de proyectos que está cada Integrante #################################
update INTPROY I1
inner join (SELECT I2.IN_NOMBRE AS ID, COUNT(I2.IN_NOMBRE) AS cant 
FROM INTPROY I2 
WHERE 1
GROUP BY I2.IN_NOMBRE
  ) t 
  on (t.ID = I1.IN_NOMBRE)
set I1.NUMPROY = t.cant;

##########################Calculo 2 #################################
DROP PROCEDURE IF EXISTS calculo_2;
DELIMITER $$
CREATE PROCEDURE calculo_2 ()
BEGIN

DECLARE nombre VARCHAR(255);
DECLARE cat VARCHAR(255);
DECLARE ded VARCHAR(255);
DECLARE codproy VARCHAR(255);
DECLARE codproyant VARCHAR(255) DEFAULT '0';
DECLARE nump int;



DECLARE calc FLOAT DEFAULT 0;
DECLARE totdeab INT DEFAULT 0;
DECLARE totdecd INT DEFAULT 0;
DECLARE totseab INT DEFAULT 0;
DECLARE totsecd INT DEFAULT 0;
DECLARE totsiab INT DEFAULT 0;
DECLARE totsicd INT DEFAULT 0;

DECLARE Nd INT;
DECLARE Mt INT;
DECLARE abp FLOAT DEFAULT 0;	
DECLARE cdp FLOAT DEFAULT 0;	
DECLARE St FLOAT DEFAULT 0;
DECLARE M FLOAT DEFAULT 0;
DECLARE ab FLOAT DEFAULT 0;
DECLARE cd FLOAT DEFAULT 0;
DECLARE Sp FLOAT DEFAULT 0;

DECLARE c1 cursor for SELECT IN_NOMBRE, IN_CAINV, IN_DEDI, NUMPROY from INTPROY ORDER BY IN_NOMBRE ASC;

DECLARE c2 cursor for SELECT IN_NOMBRE, IN_CAINV, IN_DEDI, NUMPROY, IN_ID from INTPROY ORDER BY IN_ID ASC;




open c1;
BEGIN
DECLARE done BOOLEAN DEFAULT FALSE;
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = TRUE;
c1_loop: LOOP
fetch c1 into nombre,cat,ded,nump;
        IF done THEN LEAVE c1_loop; END IF; 
        SET calc=1/nump;

	CASE

          when (ded=1) then 
		CASE
			when (cat='I') then
				SET totdeab=totdeab+calc;
			when (cat='II') then
				SET totdeab=totdeab+calc;
			when (cat='III') then
				SET totdecd=totdecd+calc;
			when (cat='IV') then
				SET totdecd=totdecd+calc;
			when (cat='V') then
				SET totdecd=totdecd+calc;
		END CASE; 

          when (ded=2) then 
		CASE
			when (cat='I') then
				SET totseab=totseab+calc;
			when (cat='II') then
				SET totseab=totseab+calc;
			when (cat='III') then
				SET totsecd=totsecd+calc;
			when (cat='IV') then
				SET totsecd=totsecd+calc;
			when (cat='V') then
				SET totsecd=totsecd+calc;
		END CASE; 
	when (ded=3) then 
		CASE
			when (cat='I') then
				SET totsiab=totsiab+calc;
			when (cat='II') then
				SET totsiab=totsiab+calc;
			when (cat='III') then
				SET totsicd=totsicd+calc;
			when (cat='IV') then
				SET totsicd=totsicd+calc;
			when (cat='V') then
				SET totsicd=totsicd+calc;
		END CASE; 

        END CASE; 	

END LOOP c1_loop;
END;
CLOSE c1;
SET Nd = (SELECT COUNT(*) FROM (SELECT COUNT(*) FROM DIRPROY GROUP BY DIR_ID) as total);

SET @enabled = TRUE; 

SET Mt=24667776;

SET abp= 1.2 * ( totdeab + (0.5*totseab) + (0.25*totsiab) ); 
SET cdp= 0.6 * (totdecd + (0.5*totsecd) + (0.25*totsicd) );

SET St = abp + cdp + Nd;
SET M=Mt/St;

#call debug_msg(@enabled, (select concat_ws('',"Nd:", Nd)));
#call debug_msg(@enabled, (select concat_ws('',"St:", St)));
#call debug_msg(@enabled, (select concat_ws('',"M:", M)));
#call debug_msg(@enabled, (select concat_ws('',"I II:", abp)));
#call debug_msg(@enabled, (select concat_ws('',"III IV V:", cdp)));


SET totdeab=0;
SET totdecd=0;
SET totseab=0;
SET totsecd=0;
SET totsiab=0;
SET totsicd=0;


open c2;
BEGIN
DECLARE done BOOLEAN DEFAULT FALSE;
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = TRUE;
c2_loop: LOOP
fetch c2 into nombre,cat,ded,nump,codproy;
        IF done THEN LEAVE c2_loop; END IF; 

	#call debug_msg(@enabled, (select concat_ws('',"Proy:", codproy)));
	IF codproyant = '0' OR codproyant = codproy THEN

        SET calc=1/nump;

	CASE

          when (ded=1) then 
		CASE
			when (cat='I') then
				SET totdeab=totdeab+calc;
			when (cat='II') then
				SET totdeab=totdeab+calc;
			when (cat='III') then
				SET totdecd=totdecd+calc;
			when (cat='IV') then
				SET totdecd=totdecd+calc;
			when (cat='V') then
				SET totdecd=totdecd+calc;
		END CASE; 

          when (ded=2) then 
		CASE
			when (cat='I') then
				SET totseab=totseab+calc;
			when (cat='II') then
				SET totseab=totseab+calc;
			when (cat='III') then
				SET totsecd=totsecd+calc;
			when (cat='IV') then
				SET totsecd=totsecd+calc;
			when (cat='V') then
				SET totsecd=totsecd+calc;
		END CASE; 
	when (ded=3) then 
		CASE
			when (cat='I') then
				SET totsiab=totsiab+calc;
			when (cat='II') then
				SET totsiab=totsiab+calc;
			when (cat='III') then
				SET totsicd=totsicd+calc;
			when (cat='IV') then
				SET totsicd=totsicd+calc;
			when (cat='V') then
				SET totsicd=totsicd+calc;
		END CASE; 

        END CASE; 	
	ELSE
		
		SET ab= (1.2 * (totdeab + (0.5*totseab) + (0.25*totsiab)) ); 
		SET cd= ( 0.6 * (totdecd + (0.5*totsecd) + (0.25*totsicd)) );

		SET nump = (SELECT NUMDIRFAC FROM DIRPROY WHERE PR_ID = codproyant);	
		
		SET Sp= ab + cd + (1/nump);

		#call debug_msg(@enabled, (select concat_ws('',"Sp:", Sp)));
		
		call debug_msg(@enabled, (select concat_ws('',"UPDATE DIRPROY SET DIVI = 1/", nump))));
		,"MONTO = (",Sp,"*",M,"), SPOND = ",Sp," WHERE PR_ID = ",codproy
		UPDATE DIRPROY SET DIVI = 1/nump, MONTO = (Sp*M), SPOND = Sp  WHERE PR_ID = codproyant;

		SET totdeab=0;
		SET totdecd=0;
		SET totseab=0;
		SET totsecd=0;
		SET totsiab=0;
		SET totsicd=0;	
		CASE

		  when (ded=1) then 
			CASE
				when (cat='I') then
					SET totdeab=totdeab+calc;
				when (cat='II') then
					SET totdeab=totdeab+calc;
				when (cat='III') then
					SET totdecd=totdecd+calc;
				when (cat='IV') then
					SET totdecd=totdecd+calc;
				when (cat='V') then
					SET totdecd=totdecd+calc;
			END CASE; 

		  when (ded=2) then 
			CASE
				when (cat='I') then
					SET totseab=totseab+calc;
				when (cat='II') then
					SET totseab=totseab+calc;
				when (cat='III') then
					SET totsecd=totsecd+calc;
				when (cat='IV') then
					SET totsecd=totsecd+calc;
				when (cat='V') then
					SET totsecd=totsecd+calc;
			END CASE; 
		when (ded=3) then 
			CASE
				when (cat='I') then
					SET totsiab=totsiab+calc;
				when (cat='II') then
					SET totsiab=totsiab+calc;
				when (cat='III') then
					SET totsicd=totsicd+calc;
				when (cat='IV') then
					SET totsicd=totsicd+calc;
				when (cat='V') then
					SET totsicd=totsicd+calc;
			END CASE; 

		END CASE; 
		
	END IF;
	SET codproyant = codproy;	
END LOOP c2_loop;
END;
CLOSE c2;

END$$
DELIMITER ;