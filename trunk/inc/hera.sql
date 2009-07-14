# Table structure for table `ariadna`

CREATE TABLE `ariadna` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `clave` varchar(16) default NULL,
  `software` text,
  `resumen` text,
  `comentarios` text,
  `url` varchar(255) default NULL,
  `url_base` varchar(255) default NULL,
  `totales` text,
  `puntos` text,
  `mis_puntos` text,
  `marcos` text,
  `revision` datetime default NULL,
  `fecha` datetime default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


#id
#nombre: Name. Not used yet
#email: Not used yet
#clave: Not used yet
#software: User agent
#resumen: General comment
#comentarios: Comment for each checkpoint
#url: Page URI
#url_base: Page base
#totales: Page elements
#puntos: Results by checkpoints
#mis_puntos: Modified results by checkpoints
#marcos: Frames URI's
#revision: Last modification date
#fecha: Start date
