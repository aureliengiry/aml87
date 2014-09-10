-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: aml87
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.13.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blog_articles`
--

DROP TABLE IF EXISTS `blog_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `id_media` int(11) DEFAULT NULL,
  `id_video` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `published` datetime DEFAULT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_article`),
  UNIQUE KEY `UNIQ_CB80154FF47645AE` (`url`),
  UNIQUE KEY `UNIQ_CB80154F84A9E03C` (`id_media`),
  UNIQUE KEY `UNIQ_CB80154F92429B1C` (`id_video`),
  KEY `IDX_CB80154F5697F554` (`id_category`),
  CONSTRAINT `FK_CB80154F5697F554` FOREIGN KEY (`id_category`) REFERENCES `blog_categories` (`id_category`),
  CONSTRAINT `FK_CB80154F84A9E03C` FOREIGN KEY (`id_media`) REFERENCES `mediasbundle_medias` (`id_media`),
  CONSTRAINT `FK_CB80154F92429B1C` FOREIGN KEY (`id_video`) REFERENCES `mediasbundle_videos` (`id_video`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_articles`
--

LOCK TABLES `blog_articles` WRITE;
/*!40000 ALTER TABLE `blog_articles` DISABLE KEYS */;
INSERT INTO `blog_articles` VALUES (1,NULL,NULL,3,'Bienvenue sur le nouveau site de l\'AML','bienvenue-sur-le-nouveau-site-de-laml','<p>\r\n	Bonjour &agrave; tous, nous sommes heureux de vous pr&eacute;senter le nouveau site l&#39;AML.<br />\r\n	<br />\r\n	Avec de nouvelles couleurs, un nouveau design, de nouvelles fonctionnalit&eacute;s pour une visite plus agr&eacute;able.<br />\r\n	<br />\r\n	Chabatz d&#39;entrar !! ( finissez d&#39;entrer )</p>\r\n','2010-10-19 14:36:17','2011-01-24 14:15:23','2011-01-24 14:15:23',1),(2,NULL,NULL,2,'Concert à Feytiat du 29 mai 2010','concert-feytiat-du-29-mai-2010','<p>\r\n	Le samedi 29 Mai 2010,&nbsp; &agrave; la salle Georges Brassens de Feytiat, nous avons donn&eacute; un concert d&#39;une heure et demie &agrave; l&#39;invitation du foyer la&iuml;que et culturel de Feytiat.<br />\r\n	Ce concert nous a permis de d&eacute;couvrir cette salle. Et les nombreux applaudissements qui ont rythm&eacute; cette soir&eacute;e, nous a donner l&#39;envie .</p>\r\n','2011-01-11 10:39:52','2011-01-11 10:39:52',NULL,0),(3,NULL,NULL,2,'Concert pour Haïti','concert-pour-hati','<p>\r\n	Le samedi 25 Juin 2010, &agrave; l&#39;auditorium d&#39;Isle, nous avons particip&eacute; &agrave; un concert au profit d&#39;Ha&iuml;ti organis&eacute; par l&#39;association&nbsp;<a href=\"http://acemhaiti87.canalblog.com/\" target=\"_blank\">ACEM 87</a>.</p>\r\n<p>\r\n	La soir&eacute;e s&#39;est d&eacute;roul&eacute;e en 3 parties&nbsp; :</p>\r\n<ul>\r\n	<li>\r\n		- la chorale dirig&eacute;e par Josy Mars DO-MI-SI-LA-DO-RE</li>\r\n	<li>\r\n		- la chorale les Dames de choeurs</li>\r\n	<li>\r\n		- Avenir Musical du Limousin en 3&egrave;me partie</li>\r\n</ul>\r\n<p>\r\n	<br />\r\n	Ce concert a permis de r&eacute;colter une jolie somme pour venir en aide aux victimes du s&eacute;isme &agrave; Ha&iuml;ti.</p>\r\n','2010-11-19 10:54:27','2011-02-02 00:31:19','2011-02-02 00:31:19',1),(4,10,NULL,2,'l\'AML chez les ch\'tis !!!','laml-chez-les-chtis-','<p>\r\n	Le samedi 16 octobre 2010, nous nous sommes rendu &agrave; Dunkerque afin de faire d&eacute;couvrir notre r&eacute;pertoire aux ch&#39;tis.<br />\r\n	Un accueil chaleureux nous a &eacute;t&eacute; offert d&egrave;s notre arriv&eacute;e !!! Nous avons p&ucirc; &eacute;changer nos cultures musicales avec l&#39;orchestre local et un duo Accord&eacute;on et voix basque de qualit&eacute;. Ce voyage nous a &eacute;galement fait d&eacute;couvrir une belle ville qui est celle de Dunkerque.<br />\r\n	PS : &agrave; Dunkerque aussi on peut avoir un beau temps !!</p>\r\n','2011-01-11 12:29:50','2011-01-11 12:29:50',NULL,0),(5,NULL,NULL,2,'Téléthon 2010','tlthon-2010','<p>\r\n	Le 3 D&eacute;cembre 2010, &agrave; la salle des f&ecirc;tes de S&eacute;reilhac, nous avons donn&eacute; une r&eacute;pr&eacute;sentation, ce qui a permis de r&eacute;colter des dons importants pour le T&eacute;l&eacute;thon.</p>\r\n','2011-01-11 12:37:45','2011-01-11 12:37:45',NULL,0),(6,11,NULL,3,'Assemblée Générale 2010','assemble-gnrale-2010','<p>\r\n	Le 19 D&eacute;cembre 2010. l&#39;AML a tenu son Assembl&eacute;e G&eacute;n&eacute;rale et &eacute;lus son nouveau bureau.<br />\r\n	C&#39;est reparti pour un tour avec pleins de concerts, d&#39;&eacute;changes, un nouveau site web et une ann&eacute;e riche en musique !!</p>\r\n','2010-12-20 12:43:11','2011-02-02 00:30:45','2011-02-02 00:30:45',1),(7,NULL,NULL,3,'Galette des Rois 2011 !!','galette-des-rois-2011-','<p>\r\n	Le 15 Janvier 2011 &agrave; la salle du Temps Libre &agrave; Isle (87) nous avons c&eacute;l&eacute;br&eacute; la galette des Rois. La soir&eacute;e a d&eacute;but&eacute; par une d&eacute;monstration de nouveaux morceaux suivit d&#39;une d&eacute;gustation de la traditionnelle galette et l&#39;ambiance s&#39;en est all&eacute; &agrave; la f&ecirc;te <img alt=\":P\" src=\"http://www.aml87.fr/sites/all/modules/contrib/ckeditor/ckeditor/ckeditor/plugins/smiley/images/tounge_smile.gif\" title=\":P\" />!!</p>\r\n','2011-01-11 13:05:27','2011-01-11 13:08:29',NULL,0),(8,NULL,NULL,3,'Bonne année 2011 !!','bonne-anne-2011-','<p>\r\n	L&#39;Avenir Musical du Limousin esp&egrave;re que vous avez pass&eacute; une excellente ann&eacute;e musicale en notre compagnie et que nous pourrons vous retrouver lors de nos futurs concerts en 2011!&nbsp;</p>\r\n<p>\r\n	Bonne ann&eacute;e &agrave; tous!</p>\r\n','2011-01-01 10:00:00','2011-01-24 14:15:57','2011-01-24 14:15:57',1),(9,12,NULL,2,'Concert du 21 mai 2011 avec la chorale du Palais/Vienne','concert-du-21-mai-2011-avec-la-chorale-du-palaisvienne','<p class=\"rtejustify\">\r\n	Nous avons re&ccedil;u ce samedi 21 mai la chorale du Palais sur Vienne en l&#39;Eglise d&#39;Isle. C&#39;est avec &eacute;norm&eacute;ment de plaisir que nous avons partag&eacute; ce moment avec les choristes et leur chef de choeur, Corinne Rouhaut, &eacute;gallement ancienne directrice musicale de notre ensemble. Gr&acirc;ce au r&eacute;pertoire vari&eacute; de nos deux formations, nous avons pu voyager dans l&#39;espace et le temps, de l&#39;Afrique &agrave; l&#39;Irlande en passant bien entendu par le Limousin avec la chorale, puis de Russie &agrave; l&#39;Allemagne en passant par les Etats-Unis en notre compagnie. Finalement, le concert s&#39;est clos par un morceau interpr&eacute;t&eacute; en commun, la c&eacute;l&egrave;bre musique du film Christophe Colomb, <em>1492: Conquest of Paradise</em>.</p>\r\n<p class=\"rtejustify\">\r\n	En esp&eacute;rant revoir tr&egrave;s bient&ocirc;t cette chorale avec laquelle nous avons pass&eacute; un tr&egrave;s bon moment!</p>\r\n<p class=\"rtejustify\">\r\n	Site de la Chorale du Palais/Vienne: http://choraledupalais.com/</p>\r\n','2011-05-22 06:44:28','2011-05-23 13:46:21','2011-05-23 13:46:21',1),(10,16,NULL,1,'Article du Populaire du concert avec la chorale du Palais sur Vienne','article-du-populaire-du-concert-avec-la-chorale-du-palais-sur-vienne','','2011-06-05 13:30:14','2011-06-05 13:30:14','2011-06-05 13:30:14',1),(11,17,NULL,1,'Article du Populaire du Centre sur le Festival Notes de Rues','article-du-populaire-du-centre-sur-le-festival-notes-de-rues','<p>\r\n	Pour visionner l&#39;article en entier veuillez cliquer sur l&#39;image, vous pouvez ensuite l&#39;agrandir en cliquant sur le bouton en haut &agrave; droite.</p>\r\n','2011-06-29 09:33:17','2011-06-29 09:39:54','2011-06-29 09:39:54',1),(12,18,NULL,1,'Article du Populaire du Centre du 25 Juin 2011','article-du-populaire-du-centre-du-25-juin-2011','<p>\r\n	<em>Pour visionner l&#39;article en entier veuillez <strong>cliquer sur l&#39;image</strong>, vous pouvez ensuite l&#39;agrandir en cliquant sur le bouton en haut &agrave; droite. </em></p>\r\n','2011-06-29 10:25:24','2011-06-29 10:25:24','2011-06-29 10:25:24',1),(13,19,NULL,1,'Article d\'Isle Info de Juin 2011 sur le concert à Cognac la Forêt','article-disle-info-de-juin-2011-sur-le-concert-cognac-la-fort','<p>\r\n	<em>Pour visionner l&#39;article en entier veuillez <strong>cliquer sur l&#39;image</strong>, vous pouvez ensuite l&#39;agrandir en cliquant sur le bouton en haut &agrave; droite. </em></p>\r\n','2011-06-29 10:30:41','2011-06-29 10:30:41','2011-06-29 10:30:41',1),(14,22,NULL,2,'Concert en faveur de l\'association Mes mains en or','concert-en-faveur-de-lassociation-mes-mains-en-or','<p>\r\n	Le samedi 23 juin, la chorale des &laquo; Dames de Ch&oelig;ur &raquo; et l&rsquo;Avenir Musical du Limousin ont organis&eacute; une soir&eacute;e &agrave; la salle municipale du Vigenal &agrave; Limoges au profit de l&rsquo;association mes mains en or.</p>\r\n<p>\r\n	Ce c&oelig;ur exclusivement f&eacute;minin a assur&eacute; la premi&egrave;re partie du spectacle, accompagn&eacute; au clavier par Eric Chaupitre. Ce dernier a ensuite repris la baguette de chef pour diriger l&rsquo;AML lors de la seconde partie.</p>\r\n<p>\r\n	Les b&eacute;n&eacute;fices de la soir&eacute;e ont &eacute;t&eacute; vers&eacute; au profit de l&rsquo;association &laquo; mes mains en or &raquo;, qui cr&eacute;&eacute; des livres d&rsquo;images en relief avec &eacute;criture en braille pour que les jeunes enfants malvoyants puisse d&eacute;couvrir avec leurs mains tout le plaisir de la lecture.&nbsp;</p>\r\n<p>\r\n	Ce fut pour tous les participants &agrave; ce concert, organisateurs et spectateurs, un moment d&rsquo;&eacute;change tr&egrave;s int&eacute;ressant que tous sont pr&ecirc;ts &agrave; revivre !</p>\r\n','2012-07-08 04:50:52','2012-07-08 05:00:22','2012-07-08 05:00:22',1),(15,NULL,1,3,'Le Fantôme de l\'Opéra','le-fantme-de-lopra','<p>\r\n	Extrait de notre concert du Samedi 23 Juin 2012 &agrave; la salle du Vigenal &agrave; Limoges</p>\r\n','2012-07-08 06:43:53','2012-07-08 06:43:53','2012-07-08 06:43:53',1),(16,NULL,2,2,'Voilà notre nouveau morceau, Pirate des Caraïbes !!','voil-notre-nouveau-morceau-pirate-des-carabes-','<p>\r\n	Extrait de notre concert du Samedi 10 Novembre 2012 &agrave; l&#39;auditorium d&#39;Isle avec Collectif129.</p>\r\n','2012-11-19 14:05:32','2012-11-26 01:06:39','2012-11-26 01:06:39',1),(17,24,NULL,3,'L\'AML87 vous souhaite à tous une excellente année 2013','laml87-vous-souhaite-tous-une-excellente-anne-2013','<p>\r\n	L&#39;AML87 vous souhaite &agrave; tous une excellente ann&eacute;e 2013 et esp&egrave;re vous retrouver nombreux (et nombreuses...) lors de nos futures repr&eacute;sentations!<br />\r\n	Nous en profitons aussi pour annoncer l&#39;enregistrement d&#39;un nouveau CD qui sortira au cours de l&#39;ann&eacute;e!</p>\r\n<p>\r\n	Bien musicalement!</p>\r\n','2013-01-03 07:01:20','2013-01-03 07:42:12','2013-01-03 07:42:12',1),(18,25,NULL,3,'ça y est nous sommes en plein enregistrement du prochain CD!','a-y-est-nous-sommes-en-plein-enregistrement-du-prochain-cd','<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Et oui, &ccedil;a y est nous sommes en plein enregistrement du prochain CD!</p>\r\n<p>\r\n	Nous avons pass&eacute; notre 1er week-end en studio et d&eacute;j&agrave; 6 morceaux dans la boite dont Bohemian Rhapsody &ccedil;a c&#39;est fait !</p>\r\n','2013-03-06 01:06:58','2013-03-06 01:06:58','2013-03-06 01:06:58',1),(19,26,NULL,3,'L\'AML 87 est passée sur Telim.TV','laml-87-est-passe-sur-telim-tv','<h2>\r\n	<a href=\"http://www.telim.tv/videos/finissez-dentrer-du-21-mars-accordeon-et-theatre-de-lunion\" target=\"_blank\">Finissez d&#39;entrer du 21 mars : accord&eacute;on et Th&eacute;&acirc;tre de l&#39;Union<br />\r\n	</a><span>Source: </span><a>telim.tv</a></h2>\r\n<p>\r\n	45 min 12 vues Au programme, de la musique en live avec Eric Chaupitre, directeur musical de l&#39;AML 87 (Avenir Musical du Limousin), qui d&eacute;fend &quot;l&#39;accord&eacute;on autrement&quot; ; Pierre Pradinas, directeur du th&eacute;&acirc;tre de l&#39;Union, nous parle du festival Sc&egrave;nes Grand Ecran, et de la programmation du Centre Dramatique National. Reportage sur l&#39;association &quot;Rurb&#39;1 en herbe&quot; en Creuse. Chronique B.D. avec Luo.<br />\r\n	<br />\r\n	Voir l&#39;&eacute;mission :&nbsp;<a href=\"http://www.telim.tv/videos/finissez-dentrer-du-21-mars-accordeon-et-theatre-de-lunion\">http://www.telim.tv/videos/finissez-dentrer-du-21-mars-accordeon-et-theatre-de-lunion</a><br />\r\n	<br />\r\n	&nbsp;</p>\r\n','2013-03-23 04:27:18','2013-03-23 04:28:54','2013-03-23 04:28:54',1),(20,27,NULL,3,'Le nouveau album de l\'AML87 est arrivé !! ','le-nouveau-album-de-laml87-est-arriv-','<p>\r\n	<span style=\"color: rgb(51, 51, 51); font-family: \'lucida grande\', tahoma, verdana, arial, sans-serif; font-size: 12.800000190734863px; line-height: 13.600000381469727px; background-color: rgb(255, 255, 255);\">&Ccedil;a y est... Le tr&eacute;sor des pirates a &eacute;t&eacute; d&eacute;couvert! Les premi&egrave;res images de notre nouvel album &quot;A l&#39;abordage !&quot;...</span></p>\r\n','2013-08-10 01:05:47','2013-08-10 01:05:47','2013-08-10 01:05:47',1),(21,28,NULL,2,'AML87, Symphonia et Poly-songs tous en chur.','aml87-symphonia-et-poly-songs-tous-en-chur','<div>\r\n	Le samedi 9 novembre 2013, l&rsquo;AML 87 a r&eacute;pondu pr&eacute;sent &agrave; l&rsquo;invitation de la chorale Poly-songs de Boisseuil dirig&eacute;e par Corinne Rouhaut, en l&rsquo;&eacute;glise de cette m&ecirc;me commune. Cette ex-directrice musicale de l&rsquo;orchestre d&rsquo;accord&eacute;on d&rsquo;Isle, &eacute;galement chef de ch&oelig;ur de la chorale Symphonia d&rsquo;Isle et Condat, &nbsp;a dirig&eacute; ces deux chorales s&eacute;par&eacute;ment puis ensembles, pour un concert de Sainte C&eacute;cile in&eacute;dit, devant une &eacute;glise comble.&nbsp;</div>\r\n<div>\r\n	La seconde partie de la soir&eacute;e a &eacute;t&eacute; assur&eacute;e par l&rsquo;AML 87, qui a pr&eacute;sent&eacute; au public le r&eacute;pertoire original de son dernier album &laquo; A l&rsquo;abordage ! &raquo;. La quinzaine de musiciens s&rsquo;est envol&eacute; pour un voyage musical autour du monde, sous la direction et la pr&eacute;sentation toujours aussi attirante de son chef Eric Chaupitre.</div>\r\n<div>\r\n	Les 3 ensembles se sont ensuite r&eacute;unis pour interpr&eacute;ter au plus grand plaisir de l&rsquo;auditoire 2 morceaux en commun, soit plus de 50 musiciens et choristes r&eacute;unis.</div>','2013-11-13 01:16:23','2013-11-13 01:16:23','2013-11-13 01:16:23',1),(22,29,NULL,3,'LAML 87 recherche batteurs / percussionnistes','laml-87-recherche-batteurs-percussionnistes','<p>Dans le cadre du d&eacute;veloppement et renouvellement de son r&eacute;pertoire musical, l&rsquo;AML 87 est &agrave; la recherche de batteurs / percussionnistes.</p><p>Cet ensemble original compos&eacute; en majorit&eacute; d&rsquo;accord&eacute;ons, mais d&rsquo;&eacute;galement d&rsquo;une flute traversi&egrave;re, d&rsquo;un violon et de claviers souhaite renforcer son groupe de musiciens (20 environ) par un ou plusieurs percussionnistes. Un niveau musical correct et une lecture de la musique est souhait&eacute;.&nbsp;</p><p>Au r&eacute;pertoire actuel de l&rsquo;AML 87, Bohemian Rhapsody de Queen, la musique originale du film Pirates des Cara&iuml;bes, des musiques de jazz comme In The Mood, et d&rsquo;autres pi&egrave;ces classiques, de film ou traditionnels &eacute;trangers.</p><p>L&rsquo;activit&eacute; de l&rsquo;orchestre s&rsquo;articule autour de r&eacute;p&eacute;titions hebdomadaires, et d&rsquo;une quinzaine de prestations par an.</p><p>Pour tout renseignement, les musiciens int&eacute;ress&eacute;s peuvent contacter le Directeur Musical de l&rsquo;AML 87, Eric Chaupitre, 06 14 95 77 80, contact@aml87.fr</p>','2013-12-20 04:38:51','2013-12-20 04:38:51','2013-12-20 04:38:51',1),(23,NULL,3,2,'Un petit souvenir de notre concert avec l\'orchestre national d\'accordéons !','un-petit-souvenir-de-notre-concert-avec-lorchestre-national-daccordons-','','2013-12-28 02:10:00','2013-12-28 02:10:00','2013-12-28 02:10:00',1),(24,30,NULL,2,'Collégiale dEymoutiers : La chorale Intermezzo et lensemble de  lAML réchauffe lambiance !!','collgiale-deymoutiers-la-chorale-intermezzo-et-lensemble-de-laml-rchauffe-lambiance-','<p>Dimanche 16 f&eacute;vrier 2014, Eymoutiers, 15h. Il fait mauvais. Il fait froid. Il a beaucoup plu. Personne dans les rues. Et pourtant.</p><p>La Coll&eacute;giale. Glaciale. Humide. Magnifique.&nbsp;</p>\r\n<div>\r\n	Un public nombreux est rassembl&eacute;, frigorifi&eacute;. Pour commencer en tout cas car tr&egrave;s vite le concert les r&eacute;chauffe. C&rsquo;est un concert inhabituel, c&rsquo;est le moins qu&rsquo;on puisse dire. Pourtant, certains de ceux qui sont sur les bancs, emmitoufl&eacute;s dans leur manteau, le savent d&eacute;j&agrave;. Le m&eacute;lange est &eacute;tonnant et superbe, du chant choral d&rsquo;une part, de l&rsquo;accord&eacute;on d&rsquo;autre part&hellip; et un m&eacute;lange des deux !</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	<div>\r\n		C&rsquo;est la chorale INTERMEZZO, trente ans au compteur, qui commence. La cinquantaine de choristes est famili&egrave;re des lieux. Ils avaient re&ccedil;u un accueil tr&egrave;s chaleureux en 2012 et leur chef de ch&oelig;ur Fran&ccedil;oise Delicq en t&ecirc;te, ils ont eu envie de revenir. Ils pr&eacute;sentent un &eacute;chantillon de leur r&eacute;pertoire vari&eacute; qui va de la musique religieuse (et m&ecirc;me d&rsquo;un extrait de La Traviata travaill&eacute; pour l&rsquo;ann&eacute;e&nbsp;</div>\r\n	<div>\r\n		Verdi) jusqu&rsquo;&agrave; la vari&eacute;t&eacute; ou le jazz. Leur conviction et l&rsquo;&eacute;nergie de leur chef commencent &agrave; r&eacute;chauffer nettement l&rsquo;atmosph&egrave;re&hellip; Dans deux de leurs morceaux, ils sont accompagn&eacute;s au clavier et &agrave; l&rsquo;accord&eacute;on bien entendu par Eric Chaupitre et Aur&eacute;lien&hellip; de l&rsquo;AML 87, le groupe de jeunes accord&eacute;onistes qui pr&eacute;sente la deuxi&egrave;me partie. Les musiciens &agrave; l&rsquo;accord&eacute;on mais aussi &agrave; la flute ou au clavier s&rsquo;en donne &agrave; c&oelig;ur joie. C&rsquo;est un programme essentiellement de musique de film qui emporte le public dans une ambiance enjou&eacute;e et ludique.</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		Ensuite, les tr&egrave;s jeunes accord&eacute;onistes du &laquo; petit ensemble &raquo; dirig&eacute; par Catheline Lallouet ont un &eacute;norme succ&egrave;s car c&#39;est la toute premi&egrave;re fois o&ugrave; ces enfants de 8 &agrave; 13 ans se produisent ensembles lors d&#39;un concert public ; c&#39;est un moment de grande &eacute;motion mais aussi de belle maitrise musicale. Quand le grand orchestre les rejoint c&rsquo;est un festival ! Josy Mars, la fondatrice du groupe est d&rsquo;ailleurs pr&eacute;sente pour encourager l&rsquo;AML 87 qu&rsquo;elle a cr&eacute;&eacute;&hellip; il y a bient&ocirc;t cinquante ans et elle semble &agrave; juste titre tr&egrave;s satisfaite elle aussi&hellip; et &eacute;mue.<br />\r\n		<br />\r\n		La fin du concert n&rsquo;a rien &agrave; envier &agrave; ce moment formidable car lorsque les choristes viennent rejoindre les musiciens, on per&ccedil;oit tr&egrave;s nettement le plaisir de chacun &agrave; partager ce moment &eacute;tonnant et musical o&ugrave; les sons et les &eacute;nergies fusionnent dans un joli cadeau qui r&eacute;chauffe tout &agrave; fait les auditeurs ravis&hellip; Gageons que les deux formations auront envie de renouveler l&rsquo;exp&eacute;rience ! L&rsquo;acoustique superbe et la beaut&eacute; du lieu ainsi que le bonheur de partager la musique les rassembleront s&ucirc;rement encore d&rsquo;autres fois&hellip;</div>\r\n</div>\r\n','2014-02-27 01:11:29','2014-02-27 01:11:29','2014-02-27 01:11:29',1);
/*!40000 ALTER TABLE `blog_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_articles_tags`
--

DROP TABLE IF EXISTS `blog_articles_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_articles_tags` (
  `id_tag` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  PRIMARY KEY (`id_tag`,`id_article`),
  KEY `IDX_46C6990D9D2D5FD9` (`id_tag`),
  KEY `IDX_46C6990DDCA7A716` (`id_article`),
  CONSTRAINT `FK_46C6990D9D2D5FD9` FOREIGN KEY (`id_tag`) REFERENCES `blog_tags` (`id_tag`),
  CONSTRAINT `FK_46C6990DDCA7A716` FOREIGN KEY (`id_article`) REFERENCES `blog_articles` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_articles_tags`
--

LOCK TABLES `blog_articles_tags` WRITE;
/*!40000 ALTER TABLE `blog_articles_tags` DISABLE KEYS */;
INSERT INTO `blog_articles_tags` VALUES (1,3),(2,12),(3,1),(4,6),(5,8),(6,18),(7,9),(7,10),(8,21),(9,13),(10,16),(11,13),(12,14),(13,24),(14,3),(15,24),(16,3),(16,9),(16,10),(16,16),(17,13),(18,10),(18,11),(18,12),(19,11),(20,14),(21,11),(22,23),(23,16),(24,21),(25,12),(26,22),(27,6),(28,1),(29,18),(30,14),(31,8);
/*!40000 ALTER TABLE `blog_articles_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_categories` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `system_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id_category`),
  UNIQUE KEY `UNIQ_DC3564814FEFCDF0` (`system_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_categories`
--

LOCK TABLES `blog_categories` WRITE;
/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
INSERT INTO `blog_categories` VALUES (1,'article_de_presse','Article de presse',''),(2,'concert','Concert','type article concert'),(3,'news','News','');
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_tags`
--

DROP TABLE IF EXISTS `blog_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_tags` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `system_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` smallint(6) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id_tag`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_tags`
--

LOCK TABLES `blog_tags` WRITE;
/*!40000 ALTER TABLE `blog_tags` DISABLE KEYS */;
INSERT INTO `blog_tags` VALUES (1,'acem_87','ACEM 87',0,''),(2,'alsace','Alsace',0,''),(3,'aml','AML',0,''),(4,'assemblee_generale','Assemblée Générale',0,''),(5,'bonne_annee','Bonne année',0,''),(6,'cd','CD',0,''),(7,'chorale_du_palais','Chorale du Palais',0,''),(8,'chorale_symphonia','chorale Symphonia',0,''),(9,'cognac_la_foret','Cognac-la-Forêt',0,''),(10,'collectif_129','Collectif 129',0,''),(11,'culture_au_grand_jour','Culture au Grand Jour',0,''),(12,'dames_de_choeurs','Dames de Choeurs',0,''),(13,'eymoutiers','Eymoutiers',0,''),(14,'haiti','Haîti',0,''),(15,'intermezzo','Intermezzo',0,''),(16,'isle','Isle',0,''),(17,'isle_info','Isle Info',0,''),(18,'le_populaire','Le Populaire',0,''),(19,'limoges','Limoges',0,''),(20,'mes_mains_en_or','Mes mains en or',0,''),(21,'notes_de_rues','Notes de Rues',0,''),(22,'ona','ONA',0,''),(23,'pirate_des_caraibes','Pirate des Caraïbes',0,''),(24,'poly_songs','Poly-songs',0,''),(25,'portes_ouvertes','Portes Ouvertes',0,''),(26,'recrutement','Recrutement',0,''),(27,'reunion','réunion',0,''),(28,'site_web','site web',0,''),(29,'studio','Studio',0,''),(30,'vigenal','Vigenal',0,''),(31,'voeux','voeux',0,'');
/*!40000 ALTER TABLE `blog_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_us_messages`
--

DROP TABLE IF EXISTS `contact_us_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_us_messages` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `address_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_us_messages`
--

LOCK TABLES `contact_us_messages` WRITE;
/*!40000 ALTER TABLE `contact_us_messages` DISABLE KEYS */;
INSERT INTO `contact_us_messages` VALUES (1,'aml_bundle_ContactUsBundle_messagetype[name]','example@example.com','aml_bundle_ContactUsBundle_messagetype[subject]','aml_bundle_ContactUsBundle_messagetype[body]','192.168.0.14',2,'2014-05-05 21:54:45');
/*!40000 ALTER TABLE `contact_us_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discography_albums`
--

DROP TABLE IF EXISTS `discography_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discography_albums` (
  `id_album` int(11) NOT NULL AUTO_INCREMENT,
  `id_media` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `titres` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `public` tinyint(1) NOT NULL,
  `date` date NOT NULL,
  `tracks` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_album`),
  UNIQUE KEY `UNIQ_FE74C9DE84A9E03C` (`id_media`),
  CONSTRAINT `FK_FE74C9DE84A9E03C` FOREIGN KEY (`id_media`) REFERENCES `mediasbundle_medias` (`id_media`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discography_albums`
--

LOCK TABLES `discography_albums` WRITE;
/*!40000 ALTER TABLE `discography_albums` DISABLE KEYS */;
INSERT INTO `discography_albums` VALUES (1,6,'ESCALES','<p>\r\n	4 ans apr&egrave;s la sortie de son premier CD &laquo;&nbsp;voyage&nbsp;&raquo; l&rsquo;orchestre s&rsquo;est engag&eacute; en novembre dernier dans une nouvelle aventure. Apr&egrave;s un an de pr&eacute;paration, les 22 musiciens, sous la direction de leur chef, C&eacute;dric AUPETIT, ont &eacute;crit une nouvelle page dans l&rsquo;histoire de l&rsquo;Avenir Musical du Limousin, cr&eacute;&eacute;e par Josy MARS, voil&agrave; bient&ocirc;t 40 ans.</p>\r\n<p>\r\n	Durant deux week-end les musiciens ont pris le chemin du studio Alain MIRAUCOURT &agrave; Verneuil sur Vienne pour enregistrer les 15 morceaux qui composent ce CD.</p>\r\n<p>\r\n	Des plaines irlandaises &agrave; l&rsquo;Oural, de la musique classique au tango autant d&rsquo;occasions de d&eacute;couvrir l&rsquo;accord&eacute;on autrement. C&#39;est d&rsquo;ailleurs l&#39;objectif que s&#39;est fix&eacute; cet ensemble de jeunes musiciens amateurs.</p>\r\n<p>\r\n	L&rsquo;Avenir Musical fait aujourd&rsquo;hui &laquo;&nbsp;Escales&nbsp;&raquo; sur des terres aux traditions musicales fortes.</p>','a:0:{}',1,'2015-12-02','<table class=\"sticky-enabled sticky-table\">\r\n	<thead class=\"tableHeader-processed\">\r\n		<tr>\r\n			<th>\r\n				N&deg;piste</th>\r\n			<th>\r\n				Titre</th>\r\n			<th>\r\n				Compositeur(s)</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr class=\"odd\">\r\n			<td>\r\n				1</td>\r\n			<td>\r\n				Rikudim (4&egrave;me mvt)</td>\r\n			<td>\r\n				Jan Van der ROOST / Myriam MEES</td>\r\n		</tr>\r\n		<tr class=\"even\">\r\n			<td>\r\n				2</td>\r\n			<td>\r\n				Danse des Loups</td>\r\n			<td>\r\n				Traditionnel irlandais (Hughes DE COURSON / Youenn LE BERRE / C&eacute;dric AUPETIT)</td>\r\n		</tr>\r\n		<tr class=\"odd\">\r\n			<td>\r\n				3</td>\r\n			<td>\r\n				Henry Mancini in Concert</td>\r\n			<td>\r\n				Henry MANCINI / Renato BUI</td>\r\n		</tr>\r\n		<tr class=\"even\">\r\n			<td>\r\n				4</td>\r\n			<td>\r\n				Isra&euml;li Suite</td>\r\n			<td>\r\n				Johan J. DE WITH</td>\r\n		</tr>\r\n		<tr class=\"odd\">\r\n			<td>\r\n				7</td>\r\n			<td>\r\n				Fiebre de Tango</td>\r\n			<td>\r\n				Astor PIAZZOLLA / C&eacute;lino BRATTI</td>\r\n		</tr>\r\n		<tr class=\"even\">\r\n			<td>\r\n				8</td>\r\n			<td>\r\n				Danse Dalmate</td>\r\n			<td>\r\n				Adolf G&Ouml;TZ</td>\r\n		</tr>\r\n		<tr class=\"odd\">\r\n			<td>\r\n				9</td>\r\n			<td>\r\n				Suite Galicienne</td>\r\n			<td>\r\n				Traditionnel galicien / C&eacute;dric AUPETIT</td>\r\n		</tr>\r\n		<tr class=\"even\">\r\n			<td>\r\n				11</td>\r\n			<td>\r\n				Pavane</td>\r\n			<td>\r\n				Jacob DE HAAN / Hotze JELSMA</td>\r\n		</tr>\r\n		<tr class=\"odd\">\r\n			<td>\r\n				12</td>\r\n			<td>\r\n				Violentango</td>\r\n			<td>\r\n				Astor PIAZZOLLA</td>\r\n		</tr>\r\n		<tr class=\"even\">\r\n			<td>\r\n				13</td>\r\n			<td>\r\n				Intermezzo Sinfonico</td>\r\n			<td>\r\n				Pietro MASCAGNI / Hans L&Uuml;DERS</td>\r\n		</tr>\r\n		<tr class=\"odd\">\r\n			<td>\r\n				14</td>\r\n			<td>\r\n				Mambo-Salsa</td>\r\n			<td>\r\n				C&eacute;dric AUPETIT</td>\r\n		</tr>\r\n		<tr class=\"even\">\r\n			<td>\r\n				15</td>\r\n			<td>\r\n				Rhapsodie Slave</td>\r\n			<td>\r\n				Adolf G&Ouml;TZ</td>\r\n		</tr>\r\n	</tbody>\r\n</table>'),(2,15,'embarquement','<p>\r\n	<strong>Les multiples facettes de l&#39;accord&eacute;on vous seraient-elles encore inconnues ?</strong><br />\r\n	Entre musiques de films, compositions originales, musiques d&#39;inspiration traditionnelle et sur des orchestrations subtiles et vari&eacute;es, cet ensemble m&ecirc;le habilement richesse des timbres et sonorit&eacute;s inattendues. Autant de th&egrave;mes explor&eacute;s et &eacute;voqu&eacute;s avec sensibilit&eacute; et musicalit&eacute;.</p>\r\n<p>\r\n	Plus que jamais un vent frais souffle sur l&#39;accord&eacute;on et nous embarque dans un univers unique, d&eacute;finitivement plac&eacute; sous le signe de la nouveaut&eacute;.</p>\r\n','N;',1,'2008-10-31',''),(3,31,'A l\'abordage !','<p><span style=\"font-family: Arial; font-size: 12px; line-height: normal; text-align: justify; background-color: rgb(255, 255, 255);\">&Ccedil;a y est... Le tr&eacute;sor des pirates a &eacute;t&eacute; d&eacute;couvert! Les premi&egrave;res images de notre nouvel album &quot;A l&#39;abordage !&quot;...</span></p>','N;',1,'2014-08-31','');
/*!40000 ALTER TABLE `discography_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discography_tracks`
--

DROP TABLE IF EXISTS `discography_tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discography_tracks` (
  `id_track` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `compositor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id_track`),
  KEY `IDX_2EFBA4BFBF396750` (`id`),
  CONSTRAINT `FK_2EFBA4BFBF396750` FOREIGN KEY (`id`) REFERENCES `discography_albums` (`id_album`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discography_tracks`
--

LOCK TABLES `discography_tracks` WRITE;
/*!40000 ALTER TABLE `discography_tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `discography_tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evenements` (
  `id_evenement` int(11) NOT NULL AUTO_INCREMENT,
  `id_media` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `archive` tinyint(1) NOT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_evenement`),
  UNIQUE KEY `UNIQ_E10AD40084A9E03C` (`id_media`),
  CONSTRAINT `FK_E10AD40084A9E03C` FOREIGN KEY (`id_media`) REFERENCES `mediasbundle_medias` (`id_media`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evenements`
--

LOCK TABLES `evenements` WRITE;
/*!40000 ALTER TABLE `evenements` DISABLE KEYS */;
INSERT INTO `evenements` VALUES (1,NULL,'concert','2010-10-15 15:00:00',NULL,'Concert à Dunkerque','<p>\r\n	<font class=\"Apple-style-span\" face=\"\'times new roman\', \'new york\', times, serif\"><span class=\"Apple-style-span\" style=\"line-height: normal;\">Concert &agrave; Loon-Plage</span></font></p>\r\n',0,1),(2,NULL,'concert','2010-11-05 16:00:00',NULL,'L\'aml fête ses 45 ans !!','<p>\r\n	L&#39;avenir musical f&ecirc;tera ses 45 ans &agrave; la Maison du Temps Libre &agrave; ISLE (87).<br />\r\n	<strong>Entr&eacute;e sur invitation</strong>.</p>\r\n',0,1),(3,NULL,'concert','2010-11-18 15:00:00',NULL,'Assemblée Générale 2010','<p>\r\n	L&#39;aml fait son assembl&eacute;e g&eacute;n&eacute;rale au local de r&eacute;p&eacute;tition &agrave; ISLE.</p>\r\n',0,1),(4,NULL,'concert','2010-12-02 15:00:00',NULL,'Téléthon à Séreilhac','<p>\r\n	L&#39;aml donnera un concert pour le T&eacute;l&eacute;thon &agrave; S&eacute;reilhac (87).</p>\r\n',0,1),(5,NULL,'concert','2010-11-26 15:00:00',NULL,'Fête de la Sainte Cécile','<p>\r\n	L&#39;AML donnera un concert pour la messe de Sainte C&eacute;cile &agrave; l&#39;&eacute;glise Ste Claire (87) &agrave; 18H30.<br />\r\n	<strong>Entr&eacute;e libre</strong>.</p>\r\n',0,1),(6,NULL,'concert','2011-04-16 15:00:00',NULL,'La Culture au Grand Jour','<p>\r\n	Concert &agrave; la salle polyvalente de COGNAC LA FORET dans le cadre de <a href=\"http://www.cg87.fr\">la Culture au Grand Jour</a> &agrave; 17 heures.</p>\r\n<p>\r\n	<strong><span class=\"Apple-style-span\" style=\"font-family: \'Trebuchet MS\', Verdana, Arial, sans-serif; font-size: 11px; line-height: 16px; \">Entr&eacute;e libre&nbsp;</span></strong></p>\r\n',0,1),(7,NULL,'concert','2011-05-20 15:00:00',NULL,'Concert en l\'église d\'ISLE','<p>\r\n	Concert en l&#39;&eacute;glise d&#39;ISLE en compagnie de la chorale Symphonia du PALAIS SUR VIENNE &agrave; 20&nbsp;heures 30.<br />\r\n	Le prix d&#39;entr&eacute;e est fix&eacute;e &agrave; 7 Euros et gratuit pour les moins de 12 ans</p>\r\n',0,1),(8,NULL,'concert','2011-06-24 15:00:00',NULL,'Concert en l\'église Sainte Claire à LIMOGES','<p>\r\n	Concert en l&#39;&eacute;glise Sainte Claire &agrave; LIMOGES &agrave; 20 heures 30 en compagnie de la Chorale &quot;Les&nbsp;Dames de Choeur&quot;.<br />\r\n	Le prix d&#39;entr&eacute;e est fix&eacute; &agrave; 7 Euros et gratuit pour les moins de 12 ans.</p>\r\n',0,1),(9,NULL,'concert','2011-06-17 15:00:00',NULL,'Festival \"Note de Rue\"','<p>\r\n	Concert Place de la Motte &agrave; LIMOGES dans le cadre du <strong>Festival &quot;Note de Rue&quot;.</strong></p>\r\n',0,1),(10,NULL,'concert','2011-09-23 15:00:00',NULL,'Concert en compagnie du jazz-band Caïman Swing','<p>\r\n	Le samedi 24 septembre &agrave; 20h30 &agrave; l&#39;auditorium du centre culturel Robert Margerit &agrave; Isle, venez passer votre soir&eacute;e en notre compagnie pour un concert des plus prometteur...<br />\r\n	En premi&egrave;re partie, nous vous ferons d&eacute;couvrir l&#39;accord&eacute;on autrement en vous faisant voyager &agrave; travers musiques du monde, musique classique et musiques de film...<br />\r\n	Puis ce sera au tour du Jazz-Band Ca&iuml;man-Swing de vous faire revivre l&#39;ambiance extraordinaire des parades de rues de la nouvelle Orl&eacute;ans, dans la plus pure tradition des ann&eacute;es 1920/1930.<br />\r\n	Entr&eacute;e avec partcipation libre!<br />\r\n	Alors retenez bien votre soir&eacute;e, le samedi 24 septembre &agrave; 20h30, &agrave; l&#39;auditorium du centre culturel Robert Margerit &agrave; ISLE</p>\r\n',0,1),(11,NULL,'concert','2012-04-27 15:00:00',NULL,'Concert avec les enfants du Dorat','<p>\r\n	Le samedi 28 Avril 2012, l&#39;AML donnera un concert avec l&#39;harmonie &quot;Les enfants du Dorat&quot;. Le concert sera d&eacute;roulera en l&#39;&eacute;glise de Bellac &agrave; 20h30.</p>\r\n',0,1),(12,NULL,'concert','2012-06-22 15:00:00',NULL,'Concert en faveur de l\'association Mes mains en or','<p>\r\n	Venez nous retrouver, &agrave; 20h30 &agrave; la Salle des f&ecirc;tes du Vigenal &agrave; Limoges. Ce concert est organis&eacute; par la chorale <b>Les Dames de Choeur</b>. Les b&eacute;n&eacute;fices seront revers&eacute;s au profit de l&#39;association <a href=\"http://www.mesmainsenor.com/\" title=\"Site internet de l\'association Mes Mains en Or\">Mes Mains en Or</a> qui cr&eacute;e des livres et des jeux pour les enfants malvoyants.</p>\r\n<p>\r\n	Plus d&#39;informations :<br />\r\n	<a href=\"http://www.mesmainsenor.com/\">http://www.mesmainsenor.com/</a></p>\r\n',0,1),(13,NULL,'concert','2012-11-09 15:00:00',NULL,'Concert avec Collectif 129','<p>\r\n	L&rsquo;AML re&ccedil;oit l&rsquo;ensemble Collectif 129 &agrave; l&rsquo;auditorium du centre culturel Robert Margerit &agrave; ISLE, &agrave; 20h30. Le <a href=\"http://www.orjazz.info/?id=59\" target=\"_blank\">Collectif 129</a> est donc un big-band compos&eacute; de 17 musiciens amateurs. Il est historiquement le creuset de l&#39;Orjazz. Il forme, sous la baguette d&#39;Eric Paillot les musiciens &agrave; la pratique collective du jazz en big-band. Le r&eacute;pertoire est vari&eacute; allant du blues au funk, en passant par la salsa et les grands standards du jazz, le tout port&eacute; par notre chanteuse. Le Collectif 129 vous fera appr&eacute;cier le jazz de fa&ccedil;on tr&egrave;s conviviale.</p>\r\n<p>\r\n	L&rsquo;AML se produira en premi&egrave;re partie.</p>\r\n<p>\r\n	Participation libre</p>\r\n',0,1),(14,NULL,'concert','2012-11-16 15:00:00',NULL,'Festival dHarmonies du Dorat,','<p>\r\n	Participation de l&rsquo;AML aux 1er Festival d&rsquo;Harmonies du Dorat, Manifestation culturelle o&ugrave; se retrouveront plusieurs groupes, harmonies, big band et orchestres, dont orchestre d&rsquo;accord&eacute;on. Successions des ensembles &agrave; partir de 17 heures, avec &agrave; 21 heures, le quatuor LALOI et &agrave; 21h45 une prestation de l&rsquo;ensemble des Harmonies</p>\r\n',0,1),(15,NULL,'concert','2012-12-14 15:00:00',NULL,'Téléthon à Bosmie l\'Aiguille','<p>\r\n	Concert de l&rsquo;AML dans la Salle Georges Bizet de BOSMIE l&rsquo;Aiguille, &agrave; 20h30 au profit du T&eacute;l&eacute;thon.</p>',0,1),(16,NULL,'concert','2012-12-01 15:00:00',NULL,'Concert avec la chorale Intermezzo','<p>\r\n	Musique et chants seront au programme en l&rsquo;&eacute;glise de Nexon, &agrave; partir de 17 heures pour cette nouvelle rencontre entre l&rsquo;Avenir Musical du Limousin et la chorale Intermezzo. Depuis leur dernier &eacute;change en 2005, de nouveaux musiciens, ch&oelig;urs et r&eacute;pertoires &agrave; d&eacute;couvrir.</p>',0,1),(17,NULL,'concert','2013-03-29 16:00:00',NULL,'L\'AML 87 invite l\'Orchestre National d\'Accordéon','<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Limoges, Capitale de l&rsquo;Accord&eacute;on Autrement</p>\r\n<p>\r\n	Le week-end de P&acirc;cques 2013 va &ecirc;tre l&rsquo;occasion pour tous les habitants de Limoges et des environs de pouvoir&nbsp;<span style=\"font-size: 13px;\">assister &agrave; deux concerts exceptionnels sur le th&egrave;me de l&rsquo; &laquo; accord&eacute;on autrement &raquo;. En effet, l&rsquo;AML 87,&nbsp;</span><span style=\"font-size: 13px;\">orchestre d&rsquo;Isle connu et reconnu des amateurs et professionnels de l&rsquo;accord&eacute;on, dirig&eacute; par Eric Chaupitre,&nbsp;</span><span style=\"font-size: 13px;\">re&ccedil;oit l&rsquo;Orchestre National d&rsquo;Accord&eacute;on, dirig&eacute; par 4 chefs d&rsquo;orchestre : Jean Marie Dazas, Marie Christine&nbsp;</span><span style=\"font-size: 13px;\">Moutaud, Marc Aurine et Jean Charles Danet.</span></p>\r\n<p>\r\n	Cet orchestre, compos&eacute; de 15 &eacute;l&eacute;ments de haut niveau venant des 6 coins de la France (2 accord&eacute;onistes jouent&nbsp;<span style=\"font-size: 13px;\">&agrave; l&rsquo;AML 87) se regroupe quelques fois par an pour effectuer des stages en r&eacute;sidence et des concerts. On peut&nbsp;</span><span style=\"font-size: 13px;\">rappeler les tourn&eacute;es en Russie effectu&eacute;es par cet orchestre en 2006 et 2010.</span></p>\r\n<p>\r\n	Le samedi 30 mars 2013 &agrave; 20h30, un premier concert est organis&eacute; en l&rsquo;Eglise R&eacute;form&eacute;e de Limoges. Le&nbsp;<span style=\"font-size: 13px;\">dimanche 31 mars 2013 &agrave; 17 heures, un autre concert se tiendra &agrave; la Salle de f&ecirc;tes du Vigenal &agrave; Limoges. Deux&nbsp;</span><span style=\"font-size: 13px;\">concerts, c&rsquo;est deux fois plus de chance de pouvoir assister &agrave; cet &eacute;change d&rsquo;accord&eacute;onistes, promouvant&nbsp;</span><span style=\"font-size: 13px;\">l&rsquo;accord&eacute;on autrement. Le r&eacute;pertoire se composera de musique de films, de traditionnels &eacute;trangers, de musique&nbsp;</span><span style=\"font-size: 13px;\">classique et du monde, de th&egrave;mes connus, &agrave; d&eacute;couvrir ou red&eacute;couvrir.</span></p>\r\n<p>\r\n	Renseignements / r&eacute;servations : T&eacute;l. 06.12.66.80.81, Mail : contact@aml87.fr</p>\r\n<p>\r\n	Participation libre. Nous vous attendons nombreux !</p>\r\n',0,1),(18,NULL,'concert','2012-11-24 15:00:00',NULL,'Fête de la Sainte Cécile','<p>\r\n	L&rsquo;AML f&ecirc;tera Sainte C&eacute;cile en l&rsquo;Eglise d&rsquo;Isle, &agrave; 11 heures. La sainte patronne des musiciens sera honor&eacute;e, comme chaque ann&eacute;e, par l&rsquo;animation de la messe dominicale.</p>',0,1),(19,NULL,'concert','2013-06-07 15:00:00',NULL,'Concert en compagnie des chorales \"La quinte du Loup\" et \"Poly\'Songs\"','<div style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 13px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n	<span style=\"font-size: 13px; background-color: rgb(255, 255, 255);\">Concert le Samedi 8 juin 2013, 20h30 &agrave; Pageas,</span></div>\r\n<div style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 13px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n	en compagnie des chorales &quot;La quinte du Loup&quot; et &quot;Poly&#39;Songs&quot;</div>\r\n<div style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 13px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n	&nbsp;</div>\r\n<div style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 13px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n	Entr&eacute;e libre. Nous vous attendons nombreux !</div>\r\n',0,1),(20,NULL,'concert','2013-09-06 15:00:00',NULL,'Sortie officielle de l\'album \"A l\'abordage !\"','<p>L&#39;AML 87 vous attend nombreux dans la salle de spectacle du magasin <a href=\"http://www.musicpassion87.com/\" target=\"_blank\">Music Passion</a> le samedi 7 septembre 2013 &agrave; partir de 17h pour la sortie officielle de notre nouvel album &quot;A l&#39;abordage !&quot;. Nous aurons le plaisir de vous faire d&eacute;couvrir notre r&eacute;pertoire en direct!</p><p>Bien musicalement et &agrave; tr&egrave;s bient&ocirc;t,</p><p>L&#39;AML 87</p><p><span>Entr&eacute;e libre<br />\r\n</span><span>Vente de l&#39;album sur place</span></p><p>Retrouvez &eacute;galement ce concert sur notre page Facebook :&nbsp;<a href=\"https://www.facebook.com/events/137686896442292/\">https://www.facebook.com/events/137686896442292/</a></p>',0,1),(21,NULL,'concert','2013-10-11 15:00:00',NULL,'Concert en compagnie de la Châtelaine de Rochechouart','<p>Le samedi 12 octobre 2013, &agrave; 20h30, en l&rsquo;auditorium du Centre Culturel Robert Margerit d&rsquo;ISLE, l&rsquo;AML 87 organise en compagnie de la Ch&acirc;telaine de Rochechouart un concert &eacute;v&egrave;nement pour la pr&eacute;sentation de son album &laquo; A l&rsquo;abordage ! &raquo;.</p>',0,1),(22,NULL,'concert','2013-11-08 15:00:00',NULL,'Concert en compagnie des chorales Poly-songs et Symphonia.','<div style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 13px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n	L&#39;AML 87 vous donne rendez vous&nbsp;<span style=\"font-size: 13px;\">le samedi 9 novembre 2013 &agrave; 20h30 -&nbsp;&eacute;glise de Boisseuil&nbsp;</span><span style=\"font-size: 13px;\">en compagnie des chorales Poly-songs et Symphonia,&nbsp;</span><span style=\"font-size: 13px;\">dirig&eacute;es par Corinne ROUHAUT.</span></div>\r\n<div style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 13px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n	&nbsp;</div>\r\n<div style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 13px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n	Participation libre</div>\r\n',0,1),(23,NULL,'concert','2013-11-29 15:00:00',NULL,'Concert de Sainte-Cécile','<div style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 12.800000190734863px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n	<div style=\"font-size: 12.800000190734863px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n		Samedi 30 novembre, &agrave; 18h, Auditorium du centre culturel Robert Margerit,&nbsp;</div>\r\n	<div style=\"font-size: 12.800000190734863px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n		<span style=\"font-size: 13px;\">A l&#39;invitation du comit&eacute; de jumelage Isle-Gunzenhausen&nbsp;</span></div>\r\n	<div style=\"font-size: 12.800000190734863px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n		<span style=\"font-size: 13px;\">Entr&eacute;e gratuite</span></div>\r\n</div>\r\n',0,1),(24,NULL,'concert','2013-12-05 15:00:00',NULL,'Concert pour le Téléthon','<div style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 12.800000190734863px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n	Vendredi 6 d&eacute;cembre, &agrave; 20h30, Maison du Temps Libre,</div>\r\n<div style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 12.800000190734863px; line-height: normal; background-color: rgb(255, 255, 255);\">\r\n	<span style=\"font-size: 13px;\">Dans le cadre du T&eacute;l&eacute;thon, organis&eacute; par plusieurs associations d&#39;Isle.</span></div>\r\n',0,1),(25,NULL,'concert','2013-12-20 15:00:00',NULL,'Concert avec le groupe Voc ALL','<p>L&#39;AML87 participera au concert de No&euml;l &agrave; l&#39;&eacute;glise de Donzenac &agrave; 20h30 en compagnie du groupe <a href=\"http://groupevocall.wix.com/donzenac\" target=\"_blank\">VOC ALL</a>..<br />\r\nLe groupe <a href=\"http://groupevocall.wix.com/donzenac\">VOC ALL</a>, est une chorale de Donzenac dirig&eacute;e par&nbsp;Christelle PEYRODES.&nbsp;</p>',0,1),(26,NULL,'concert','2014-02-15 15:00:00',NULL,'Concert avec la chorale Intermezzo','<p>Dimanche 16 f&eacute;vrier 2014 &agrave; 15 heures, l&#39;AML87 donnera un concert&nbsp;&agrave; l&rsquo;&eacute;glise d&rsquo;Eymoutiers avec la chorale Intermezzo</p>',0,1),(27,NULL,'concert','2014-03-28 16:00:00',NULL,'Concert \"Arts et Culture\"','<p>L&#39;AML87 donnera un concert &agrave; Bosmie l&rsquo;Aiguille &agrave; l&rsquo;invitation d&rsquo;Arts et Culture</p>',0,1),(28,NULL,'concert','2014-04-05 15:00:00',NULL,'Concert avec l\'ensemble Enigma','<p>Concert avec l&#39;ensemble Enigma &agrave; Limoges.<br />\r\nLe concert se d&eacute;roulera &agrave; la salle Longequeue au 1er &eacute;tage de l&rsquo;H&ocirc;tel de ville de Limoges.</p>',0,1),(29,NULL,'concert','2014-04-26 15:00:00',NULL,'Stage d\'orchestre d\'accordéons','<p><span>L&#39;AML organse son deuxi&egrave;me stage d&#39;orchestre d&#39;accord&eacute;ons &agrave; Feytiat les 26 et 27 avril 2014.</span></p>',0,1),(30,33,'concert','2014-07-12 00:00:00',NULL,'Concert avec la Châtelaine','<p>\r\n	Samedi 12 Juillet,<br />\r\n	La Ch&acirc;telaine de Rochechouart + AML 87 dans la cour du chateau | Avenir Musical du Limousin | Cour du ch&acirc;teau | Concert en plein air<br />\r\n	2nde partie d&#39;un &eacute;change antre ces deux ensembles amis. Concert en plein air</p>',0,1);
/*!40000 ALTER TABLE `evenements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evenements_articles`
--

DROP TABLE IF EXISTS `evenements_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evenements_articles` (
  `id_evenement` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  PRIMARY KEY (`id_evenement`,`id_article`),
  KEY `IDX_6A229B878B13D439` (`id_evenement`),
  KEY `IDX_6A229B87DCA7A716` (`id_article`),
  CONSTRAINT `FK_6A229B878B13D439` FOREIGN KEY (`id_evenement`) REFERENCES `evenements` (`id_evenement`),
  CONSTRAINT `FK_6A229B87DCA7A716` FOREIGN KEY (`id_article`) REFERENCES `blog_articles` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evenements_articles`
--

LOCK TABLES `evenements_articles` WRITE;
/*!40000 ALTER TABLE `evenements_articles` DISABLE KEYS */;
INSERT INTO `evenements_articles` VALUES (30,3),(30,4),(30,5),(30,6);
/*!40000 ALTER TABLE `evenements_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evenements_partenaires`
--

DROP TABLE IF EXISTS `evenements_partenaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evenements_partenaires` (
  `id_partenaire` int(11) NOT NULL,
  `id_evenement` int(11) NOT NULL,
  PRIMARY KEY (`id_partenaire`,`id_evenement`),
  KEY `IDX_9643C88977523A4` (`id_partenaire`),
  KEY `IDX_9643C888B13D439` (`id_evenement`),
  CONSTRAINT `FK_9643C888B13D439` FOREIGN KEY (`id_evenement`) REFERENCES `evenements` (`id_evenement`),
  CONSTRAINT `FK_9643C88977523A4` FOREIGN KEY (`id_partenaire`) REFERENCES `webbundle_partenaires` (`id_partenaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evenements_partenaires`
--

LOCK TABLES `evenements_partenaires` WRITE;
/*!40000 ALTER TABLE `evenements_partenaires` DISABLE KEYS */;
INSERT INTO `evenements_partenaires` VALUES (1,30),(2,30);
/*!40000 ALTER TABLE `evenements_partenaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mediasbundle_medias`
--

DROP TABLE IF EXISTS `mediasbundle_medias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mediasbundle_medias` (
  `id_media` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_media`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mediasbundle_medias`
--

LOCK TABLES `mediasbundle_medias` WRITE;
/*!40000 ALTER TABLE `mediasbundle_medias` DISABLE KEYS */;
INSERT INTO `mediasbundle_medias` VALUES (1,'escale.jpg','image','escale.jpg'),(2,'EMBARQUEMENT.jpg','image','EMBARQUEMENT.jpg'),(3,'EMBARQUEMENT.jpg','image','EMBARQUEMENT.jpg'),(4,'escale.jpg','image','escale.jpg'),(5,'escale.jpg','image','escale.jpg'),(6,'escale5.jpg','image','escale5.jpg'),(7,'groupeMini.jpg','image','groupeMini.jpg'),(8,'large_groupeMini.jpg','image','large_groupeMini.jpg'),(9,'groupe.jpg','image','groupe.jpg'),(10,'P1000918.JPG','image','P1000918.JPG'),(11,'assemble-generale-2010.jpg','image','assemble-generale-2010.jpg'),(12,'morceau en commun_amélioré.jpg','image','morceau en commun_amélioré.jpg'),(13,'AML09-007[DSCF1391].jpg','image','AML09-007[DSCF1391].jpg'),(14,'AML09-007[DSCF1391]_0.jpg','image','AML09-007[DSCF1391]_0.jpg'),(15,'pochette_EMBARQUEMENT.jpg','image','pochette_EMBARQUEMENT.jpg'),(16,'2011_05_25_Isle_chorale du palais_Le populaire.jpg','image','2011_05_25_Isle_chorale du palais_Le populaire.jpg'),(17,'2011_06_17_Notes de Rues.jpg','image','2011_06_17_Notes de Rues.jpg'),(18,'2011_06_25_Portes Ouvertes_Ste Claire_Alsace.jpg','image','2011_06_25_Portes Ouvertes_Ste Claire_Alsace.jpg'),(19,'2011_06_Cognac_Isle info.jpg','image','2011_06_Cognac_Isle info.jpg'),(20,'montage2.jpg','image','montage2.jpg'),(21,'large_montage2.jpg','image','large_montage2.jpg'),(22,'photo.JPG','image','photo.JPG'),(23,'amlFB.jpg','image','amlFB.jpg'),(24,'aml87_voeux_2013.png','image','aml87_voeux_2013.png'),(25,'576216_10151368051626225_319017770_n.jpg','image','576216_10151368051626225_319017770_n.jpg'),(26,'logoTelim.jpg','image','logoTelim.jpg'),(27,'534254_10151620974311225_1635411095_n.jpg','image','534254_10151620974311225_1635411095_n.jpg'),(28,'P1090445.JPG','image','P1090445.JPG'),(29,'IMG_4951 retouche (1).jpg','image','IMG_4951 retouche (1).jpg'),(30,'concert-intermezzo-20140227JPG.JPG','image','concert-intermezzo-20140227JPG.JPG'),(31,'boitier page 1.png','image','boitier page 1.png'),(33,'Affiche','image','affiche_aml_87.jpg'),(34,NULL,'image','logo_rgion_limousin_pour_informatique_2.jpg'),(35,'Canalsup TV','image','logo_canalsuptv.png');
/*!40000 ALTER TABLE `mediasbundle_medias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mediasbundle_videos`
--

DROP TABLE IF EXISTS `mediasbundle_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mediasbundle_videos` (
  `id_video` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_video`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mediasbundle_videos`
--

LOCK TABLES `mediasbundle_videos` WRITE;
/*!40000 ALTER TABLE `mediasbundle_videos` DISABLE KEYS */;
INSERT INTO `mediasbundle_videos` VALUES (1,'nBz-w0h1EEI','Le Fantôme de l\'Opéra','youtube'),(2,'-VUfWh0Cakg','Voilà notre nouveau morceau, Pirate des Caraïbes !!','youtube'),(3,'hE2b9u0fo60','Un petit souvenir de notre concert avec l\'orchestre national d\'accordéons !','youtube');
/*!40000 ALTER TABLE `mediasbundle_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usersbundle_users`
--

DROP TABLE IF EXISTS `usersbundle_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usersbundle_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_26D39E4E92FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_26D39E4EA0D96FBF` (`email_canonical`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usersbundle_users`
--

LOCK TABLES `usersbundle_users` WRITE;
/*!40000 ALTER TABLE `usersbundle_users` DISABLE KEYS */;
INSERT INTO `usersbundle_users` VALUES (1,'admin','admin','aurelien.giry@gmail.com','aurelien.giry@gmail.com',1,'rvqps705vf4c8ksgo0cs0wow08w804k','pBrGrKWtICj4f22R5WaygEYI9ubaGRZ6X10umU6bDvRAIIEo8NowI2WImrAFgxX2FL2F9CtSw0lLLzfKivIFSg==','2014-07-08 21:33:06',0,0,NULL,NULL,NULL,'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `usersbundle_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `webbundle_albums`
--

DROP TABLE IF EXISTS `webbundle_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `webbundle_albums` (
  `id_album` int(11) NOT NULL AUTO_INCREMENT,
  `id_media` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `titres` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `public` tinyint(1) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id_album`),
  UNIQUE KEY `UNIQ_682793CD84A9E03C` (`id_media`),
  CONSTRAINT `FK_682793CD84A9E03C` FOREIGN KEY (`id_media`) REFERENCES `mediasbundle_medias` (`id_media`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `webbundle_albums`
--

LOCK TABLES `webbundle_albums` WRITE;
/*!40000 ALTER TABLE `webbundle_albums` DISABLE KEYS */;
INSERT INTO `webbundle_albums` VALUES (1,6,'ESCALES','<p>4 ans apr&egrave;s la sortie de son premier CD &laquo;&nbsp;voyage&nbsp;&raquo; l&rsquo;orchestre s&rsquo;est engag&eacute; en novembre dernier dans une nouvelle aventure. Apr&egrave;s un an de pr&eacute;paration, les 22 musiciens, sous la direction de leur chef, C&eacute;dric AUPETIT, ont &eacute;crit une nouvelle page dans l&rsquo;histoire de l&rsquo;Avenir Musical du Limousin, cr&eacute;&eacute;e par Josy MARS, voil&agrave; bient&ocirc;t 40 ans.</p>\r\n<p>Durant deux week-end les musiciens ont pris le chemin du studio Alain MIRAUCOURT &agrave; Verneuil sur Vienne pour enregistrer les 15 morceaux qui composent ce CD.</p>\r\n<p>Des plaines irlandaises &agrave; l&rsquo;Oural, de la musique classique au tango autant d&rsquo;occasions de d&eacute;couvrir l&rsquo;accord&eacute;on autrement. C\'est d&rsquo;ailleurs l\'objectif que s\'est fix&eacute; cet ensemble de jeunes musiciens amateurs.</p>\r\n<p>L&rsquo;Avenir                      Musical fait aujourd&rsquo;hui &laquo;&nbsp;Escales&nbsp;&raquo; sur des terres aux traditions musicales fortes.</p>','N;',1,'2003-10-31'),(2,15,'embarquement','<p>\r\n	<strong>Les multiples facettes de l&#39;accord&eacute;on vous seraient-elles encore inconnues ?</strong><br />\r\n	Entre musiques de films, compositions originales, musiques d&#39;inspiration traditionnelle et sur des orchestrations subtiles et vari&eacute;es, cet ensemble m&ecirc;le habilement richesse des timbres et sonorit&eacute;s inattendues. Autant de th&egrave;mes explor&eacute;s et &eacute;voqu&eacute;s avec sensibilit&eacute; et musicalit&eacute;.</p>\r\n<p>\r\n	Plus que jamais un vent frais souffle sur l&#39;accord&eacute;on et nous embarque dans un univers unique, d&eacute;finitivement plac&eacute; sous le signe de la nouveaut&eacute;.</p>\r\n','N;',1,'2008-10-31'),(3,31,'A l\'abordage !','<p><span style=\"font-family: Arial; font-size: 12px; line-height: normal; text-align: justify; background-color: rgb(255, 255, 255);\">&Ccedil;a y est... Le tr&eacute;sor des pirates a &eacute;t&eacute; d&eacute;couvert! Les premi&egrave;res images de notre nouvel album &quot;A l&#39;abordage !&quot;...</span></p>','N;',1,'2014-08-31');
/*!40000 ALTER TABLE `webbundle_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `webbundle_links`
--

DROP TABLE IF EXISTS `webbundle_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `webbundle_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `webbundle_links`
--

LOCK TABLES `webbundle_links` WRITE;
/*!40000 ALTER TABLE `webbundle_links` DISABLE KEYS */;
INSERT INTO `webbundle_links` VALUES (1,'www.cmf-musique.org','http://www.cmf-musique.org','Confédération Musicale de France',0,1),(2,'www.accordions.com/duo','http://www.accordions.com/duo','Nos amis Domi Emorine & Roman Jbanov',0,1),(3,'www.lejouretlanuit.com','http://www.lejouretlanuit.com','Les évènements musicaux en Limousin',0,1),(4,'www.ville-isle.fr','http://www.ville-isle.fr','Mairie d\'ISLE',0,1),(5,'www.fisarmonisorchestra.it','http://www.fisarmonisorchestra.it','Nos amis italiens, la Fisarmonis Orchestra',0,1),(6,'intermezzo87.net','http://intermezzo87.net','La chorale Intermezzo',0,1),(7,'Voc\'all','http://chorale-vocall.spaces.live.com/','La chorale d\'Allassac',0,1),(8,'www.orchestre-accordeons-de-lyon.fr','http://www.orchestre-accordeons-de-lyon.fr','L\'Orchestre des Accordéons de Lyon',0,1),(9,'www.patrickcommincas.com','http://www.patrickcommincas.com','Un autre ami de l\'aml Patrick Commincas',0,1),(10,'www.accordions.com/noton/','http://www.accordions.com/noton/','Le site de Jean-Louis NOTON',0,1),(11,'http://gueulesseches.free.fr/','http://gueulesseches.free.fr/','Les Gueules Sèches',0,1);
/*!40000 ALTER TABLE `webbundle_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `webbundle_pages`
--

DROP TABLE IF EXISTS `webbundle_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `webbundle_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `public` tinyint(1) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `webbundle_pages`
--

LOCK TABLES `webbundle_pages` WRITE;
/*!40000 ALTER TABLE `webbundle_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `webbundle_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `webbundle_partenaires`
--

DROP TABLE IF EXISTS `webbundle_partenaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `webbundle_partenaires` (
  `id_partenaire` int(11) NOT NULL AUTO_INCREMENT,
  `id_media` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_partenaire`),
  UNIQUE KEY `UNIQ_FAB04CAF84A9E03C` (`id_media`),
  CONSTRAINT `FK_FAB04CAF84A9E03C` FOREIGN KEY (`id_media`) REFERENCES `mediasbundle_medias` (`id_media`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `webbundle_partenaires`
--

LOCK TABLES `webbundle_partenaires` WRITE;
/*!40000 ALTER TABLE `webbundle_partenaires` DISABLE KEYS */;
INSERT INTO `webbundle_partenaires` VALUES (1,34,'Région','www.region-limousin.fr/','Site internet de la région Limousin'),(2,35,'Canalsup TV','www.unilim.fr/CanalSupTV','La Web TV de l\'université de Limoges');
/*!40000 ALTER TABLE `webbundle_partenaires` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-08 13:51:42
