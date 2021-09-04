CREATE TABLE usuarioproyectoperfil (
cd_usuario INT NOT NULL ,
cd_perfil INT NOT NULL ,
PRIMARY KEY ( cd_usuario , cd_perfil )
) ENGINE = MYISAM ;

INSERT INTO usuarioproyectoperfil ( cd_usuario, cd_perfil )
SELECT cd_usuario, cd_perfil
FROM usuarioproyecto 

################2012###################
ALTER TABLE docente ADD bl_estudiante BINARY NOT NULL DEFAULT '0',
ADD nu_materias INT NOT NULL DEFAULT '0';

################09/08/2013###################
ALTER TABLE integrante ADD ds_motivos TEXT NULL ;

################10/02/2016###################
ALTER TABLE integrante 
ADD nu_horasinvAnt int(11) NULL,
ADD dt_cambioHS date default NULL,
ADD ds_reduccionHS TEXT NULL ;

INSERT INTO `estadointegrante` (`ds_estado`) VALUES ('Cambio Hs. Creado');
INSERT INTO `estadointegrante` (`ds_estado`) VALUES ('Cambio Hs. Recibido');

INSERT INTO `funcionproyecto` (`ds_funcion`) VALUES ('Cambiar Horas');
INSERT INTO `funcionproyecto` (`ds_funcion`) VALUES ('Enviar cambio Horas');

