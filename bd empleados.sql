CREATE TABLE BD
(Id int primary key,
Clave int,
Nombre VARCHAR(250),
Paterno VARCHAR(250),Materno VARCHAR(250),
FechaAlta VARCHAR(250),
IdDepto int,
Depto VARCHAR(100),
IdPuesto int,
Puesto VARCHAR(50),
IdGerencia int,
Gerencia VARCHAR(50),
EsOperador int,
Estado int);

INSERT INTO SisRH.dbo.BD(Id,
Clave,
Nombre,
Paterno,
Materno,
FechaAlta,
IdDepto,
Depto,
IdPuesto,
Puesto,
IdGerencia,
Gerencia,
EsOperador,
Estado) VALUES 
(1,1,'SANTIAGO ALBERTO','CARRILLO','SANCHEZ','01-Jan-91',108,'DIRECCION GENERAL.',1,'DIRECTOR GENERAL',14,'DIRECCION GENERAL',0,1),
(184,25,'PAULINO','LORENZO','DOMINGUEZ','06-Feb-03',52,'UNE TULUM',90,'OPERADOR',3,'OPERACIONES',1,1),
(575,37,'TERESA','CASTRO','CHAVEZ','23-Feb-93',70,'INFORMATICA',25,'GERENTE DE LOGISTICA Y PLANEACION',9,'LOGISTICA Y PLANEACION',0,1),
(717,55,'WILBERT RAFAEL','ENCALADA','HERNANDEZ','31-Aug-93',41,'MANTENIMIENTO',362,'ESPECALISTA EN MOTORES',2,'MANTENIMIENTO',0,1),
(451,108,'JORGE EFRAIN','BALAM','CHI','18-Jan-93',52,'UNE TULUM',298,'ASISTENTE DE TRAFICO',3,'OPERACIONES',0,1),
(554,134,'ARNULFO ARMANDO','GARCIA','VELOZ','22-Feb-92',149,'OPERACIONES / SINDICATO',435,'CAPACITADOR/SINDICATO',3,'OPERACIONES',0,1),
(381,286,'LUIS ENRIQUE','AVILES','MAY','16-Apr-93',149,'OPERACIONES / SINDICATO',435,'CAPACITADOR/SINDICATO',3,'OPERACIONES',0,1),
(491,529,'ALFONSO ABRAHAM','ARCE','ARGAEZ','19-Jul-94',52,'UNE TULUM',90,'OPERADOR',3,'OPERACIONES',1,1),
(701,796,'ROSALINO','GUILLEN','RAMON','29-Feb-96',41,'MANTENIMIENTO',70,'T�CNICO MEC�NICO AUTOMOTRIZ',2,'MANTENIMIENTO',0,1),
(239,886,'JESUS RAMON','GALLEGOS','GUEMEZ','08-May-96',53,'UNE KABAH',90,'OPERADOR',3,'OPERACIONES',1,1),
(335,1030,'LUIS ALBERTO','GOMEZ','CANUL','13-Dec-96',52,'UNE TULUM',90,'OPERADOR',3,'OPERACIONES',1,1),
(686,1132,'ABEL','MURILLO','LOPEZ','28-Apr-97',41,'MANTENIMIENTO',70,'T�CNICO MEC�NICO AUTOMOTRIZ',2,'MANTENIMIENTO',0,1),
(83,1140,'ERNESTO CONCEPCION','LOPEZ','CONTRERAS','02-May-97',52,'UNE TULUM',90,'OPERADOR',3,'OPERACIONES',1,1),
(680,1241,'ALFONSO','PEREZ','TORRES','27-Aug-97',53,'UNE KABAH',90,'OPERADOR',3,'OPERACIONES',1,1),
(613,1268,'LEONARDO','MORALES','GOMEZ','24-Sep-97',41,'MANTENIMIENTO',67,'MUELLERO',2,'MANTENIMIENTO',0,1),
(616,1335,'ALFREDO','AGUILAR','PASTRANA','24-Nov-97',52,'UNE TULUM',90,'OPERADOR',3,'OPERACIONES',1,1),
(666,1484,'JAVIER IVAN','DURAN','QUINTAL','27-Mar-98',115,'ADMINISTRACION DE  PERSONAL',24,'JEFE DE ADMINISTRACION DE PERSONAL',10,'CONTRALORIA',0,1),
(285,1599,'JOSE SAMUEL','SANCHEZ','ARA','10-Jun-98',52,'UNE TULUM',90,'OPERADOR',3,'OPERACIONES',1,1),
(91,1637,'JULIO CESAR','RAMIREZ','VELAZQUEZ','02-Jul-98',51,'UNE HIDALGO',90,'OPERADOR',3,'OPERACIONES',1,1),
(164,1974,'MIGUEL GABRIEL','CHAN','TULLUB','05-Mar-99',36,'BOLETAJE',29,'JEFE DE BOLETAJE',10,'CONTRALORIA',0,1),
(705,2003,'MOISES','MENDOZA','CARBAJAL','29-Mar-99',41,'MANTENIMIENTO',375,'TECNICO PINTOR',2,'MANTENIMIENTO',0,1),
(198,2009,'DAVID MANUEL','KANTUN','CAUICH','06-Apr-99',41,'MANTENIMIENTO',70,'T�CNICO MEC�NICO AUTOMOTRIZ',2,'MANTENIMIENTO',0,1),
(325,2153,'FELIPE DE JESUS','MAY','KU','13-Jul-99',54,'UNE HEROES',90,'OPERADOR',3,'OPERACIONES',1,1),
(323,2508,'ALEJANDRO','HERNANDEZ','CHAVEZ','13-Apr-00',118,'UNE CHICHENITZA',90,'OPERADOR',3,'OPERACIONES',1,1),
(298,2538,'MARCOS','HERNANDEZ','ANGEL','11-May-00',52,'UNE TULUM',90,'OPERADOR',3,'OPERACIONES',1,1),
(529,2599,'AUGUSTO','ABAN','UC','21-Jun-00',36,'BOLETAJE',30,'AUXILIAR DE BOLETAJE',10,'CONTRALORIA',0,1),
(647,2604,'MARIA MARTHA','HERNANDEZ','DE LA CRUZ','26-Jun-00',122,'SEGURIDAD E HIGIENE',396,'SUPERVISOR DE LIMPIEZA',23,'DESAROLLO ORGANIZACIONAL',0,1),
(57,2695,'MAURILIO','FUENTES','CASTILLEJOS','01-Sep-00',52,'UNE TULUM',90,'OPERADOR',3,'OPERACIONES',1,1),
(5508,99999,'.......','.....','......','13-Jun-16',0,'.',0,'SIN ASIGNAR',0,'DIRECCION GENERAL',0,1);