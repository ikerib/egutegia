-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "calendar" -------------------------------------
CREATE TABLE `calendar` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`user_id` Int( 11 ) NULL,
	`template_id` Int( 11 ) NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`year` Int( 11 ) NOT NULL,
	`hours_year` Decimal( 10, 2 ) NOT NULL,
	`hours_free` Decimal( 10, 2 ) NOT NULL,
	`hours_self` Decimal( 10, 2 ) NOT NULL,
	`hours_compensed` Decimal( 10, 2 ) NOT NULL,
	`hours_day` Decimal( 10, 2 ) NOT NULL,
	`note` LongText CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`slug` VarChar( 105 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`content_changed_by` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`percent_year` Decimal( 10, 2 ) NOT NULL,
	`hours_sindikal` Decimal( 10, 2 ) NOT NULL,
	`hirurtekoa` Decimal( 10, 2 ) NOT NULL,
	`hours_self_half` Decimal( 10, 2 ) NOT NULL,
	PRIMARY KEY ( `id` ),
	CONSTRAINT `UNIQ_6EA9A146989D9B62` UNIQUE( `slug` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 341;
-- -------------------------------------------------------------


-- CREATE TABLE "document" -------------------------------------
CREATE TABLE `document` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`calendar_id` Int( 11 ) NULL,
	`filename` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`orden` Int( 11 ) NULL,
	`eskaera_id` Int( 11 ) NULL,
	`filenamepath` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`egutegian` TinyInt( 1 ) NULL DEFAULT 0,
	`image_size` Int( 11 ) NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 2347;
-- -------------------------------------------------------------


-- CREATE TABLE "eskaera" --------------------------------------
CREATE TABLE `eskaera` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`user_id` Int( 11 ) NULL,
	`type_id` Int( 11 ) NULL,
	`calendar_id` Int( 11 ) NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`noiz` DateTime NOT NULL,
	`hasi` DateTime NOT NULL,
	`amaitu` DateTime NULL,
	`orduak` Decimal( 10, 2 ) NOT NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`content_changed_by` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`sinatzaileak_id` Int( 11 ) NULL,
	`egunak` Decimal( 10, 2 ) NOT NULL,
	`total` Decimal( 10, 2 ) NOT NULL,
	`abiatua` TinyInt( 1 ) NULL DEFAULT 0,
	`amaitua` TinyInt( 1 ) NULL DEFAULT 0,
	`egutegian` TinyInt( 1 ) NULL DEFAULT 0,
	`oharra` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`bideratua` TinyInt( 1 ) NULL DEFAULT 0,
	`konfliktoa` TinyInt( 1 ) NULL DEFAULT 0,
	`emaitza` TinyInt( 1 ) NULL DEFAULT 0,
	`nondik` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`justifikatua` TinyInt( 1 ) NULL DEFAULT 0,
	`justifikante_name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`justifikante_size` Int( 11 ) NULL,
	`lizentziamota_id` Int( 11 ) NULL,
	`kostua` Decimal( 10, 2 ) NOT NULL,
	`egutegian2` TinyInt( 1 ) NULL DEFAULT 0,
	`bertsioa` Int( 11 ) NULL DEFAULT 0,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1202;
-- -------------------------------------------------------------


-- CREATE TABLE "event" ----------------------------------------
CREATE TABLE `event` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`calendar_id` Int( 11 ) NULL,
	`type_id` Int( 11 ) NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`start_date` DateTime NULL,
	`end_date` DateTime NULL,
	`hours` Decimal( 10, 2 ) NOT NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`egunorduak` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`nondik` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`hoursSelfBefore` Decimal( 10, 2 ) NULL,
	`hoursSelfHalfBefore` Decimal( 10, 2 ) NULL,
	`eskaera_id` Int( 11 ) NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 4577;
-- -------------------------------------------------------------


-- CREATE TABLE "event_history" --------------------------------
CREATE TABLE `event_history` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`calendar_id` Int( 11 ) NULL,
	`type_id` Int( 11 ) NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`start_date` DateTime NULL,
	`end_date` DateTime NULL,
	`hours` Decimal( 10, 2 ) NOT NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 214;
-- -------------------------------------------------------------


-- CREATE TABLE "firma" ----------------------------------------
CREATE TABLE `firma` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`eskaera_id` Int( 11 ) NULL,
	`sinatzaile_id` Int( 11 ) NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`completed` TinyInt( 1 ) NOT NULL,
	`orden` Int( 11 ) NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	PRIMARY KEY ( `id` ),
	CONSTRAINT `UNIQ_2BED35637C9B02EC` UNIQUE( `eskaera_id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1078;
-- -------------------------------------------------------------


-- CREATE TABLE "firmadet" -------------------------------------
CREATE TABLE `firmadet` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`firma_id` Int( 11 ) NULL,
	`sinatzaileakdet_id` Int( 11 ) NULL,
	`firmatzaile_id` Int( 11 ) NULL,
	`noiz` DateTime NULL,
	`firmatua` TinyInt( 1 ) NULL,
	`orden` Int( 11 ) NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`postit` TinyInt( 1 ) NULL,
	`autofirma` TinyInt( 1 ) NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 3955;
-- -------------------------------------------------------------


-- CREATE TABLE "gutxienekoak" ---------------------------------
CREATE TABLE `gutxienekoak` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`portzentaia` Decimal( 10, 2 ) NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 20;
-- -------------------------------------------------------------


-- CREATE TABLE "gutxienekoakdet" ------------------------------
CREATE TABLE `gutxienekoakdet` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`gutxienekoak_id` Int( 11 ) NULL,
	`user_id` Int( 11 ) NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`orden` Int( 11 ) NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 47;
-- -------------------------------------------------------------


-- CREATE TABLE "hour" -----------------------------------------
CREATE TABLE `hour` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`calendar_id` Int( 11 ) NULL,
	`date` DateTime NOT NULL,
	`hours` Decimal( 10, 2 ) NULL,
	`minutes` Decimal( 10, 2 ) NULL,
	`factor` Decimal( 10, 2 ) NULL,
	`total` Decimal( 10, 2 ) NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 375;
-- -------------------------------------------------------------


-- CREATE TABLE "lizentziamota" --------------------------------
CREATE TABLE `lizentziamota` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`name` VarChar( 200 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`sinatubehar` TinyInt( 1 ) NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`kostuabehar` TinyInt( 1 ) NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 6;
-- -------------------------------------------------------------


-- CREATE TABLE "log" ------------------------------------------
CREATE TABLE `log` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`user_id` Int( 11 ) NULL,
	`calendar_id` Int( 11 ) NULL,
	`event_id` Int( 11 ) NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`description` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`content_changed_by` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`query` VarChar( 2000 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 11114;
-- -------------------------------------------------------------


-- CREATE TABLE "notification" ---------------------------------
CREATE TABLE `notification` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`firma_id` Int( 11 ) NULL,
	`eskaera_id` Int( 11 ) NULL,
	`user_id` Int( 11 ) NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`description` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`readed` TinyInt( 1 ) NOT NULL,
	`completed` TinyInt( 1 ) NOT NULL,
	`result` TinyInt( 1 ) NOT NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`orden` Int( 11 ) NULL,
	`notified` TinyInt( 1 ) NULL,
	`sinatzeprozesua` TinyInt( 1 ) NULL DEFAULT 1,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 10882;
-- -------------------------------------------------------------


-- CREATE TABLE "sinatzaileak" ---------------------------------
CREATE TABLE `sinatzaileak` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`orden` Int( 11 ) NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 26;
-- -------------------------------------------------------------


-- CREATE TABLE "sinatzaileakdet" ------------------------------
CREATE TABLE `sinatzaileakdet` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`sinatzaileak_id` Int( 11 ) NULL,
	`user_id` Int( 11 ) NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`orden` Int( 11 ) NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 104;
-- -------------------------------------------------------------


-- CREATE TABLE "template" -------------------------------------
CREATE TABLE `template` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`hours_year` Decimal( 10, 2 ) NOT NULL,
	`hours_free` Decimal( 10, 2 ) NOT NULL,
	`hours_self` Decimal( 10, 2 ) NOT NULL,
	`hours_compensed` Decimal( 10, 2 ) NOT NULL,
	`hours_day` Decimal( 10, 2 ) NOT NULL,
	`slug` VarChar( 105 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	PRIMARY KEY ( `id` ),
	CONSTRAINT `UNIQ_97601F83989D9B62` UNIQUE( `slug` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 8;
-- -------------------------------------------------------------


-- CREATE TABLE "template_event" -------------------------------
CREATE TABLE `template_event` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`template_id` Int( 11 ) NULL,
	`type_id` Int( 11 ) NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`start_date` DateTime NULL,
	`end_date` DateTime NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 725;
-- -------------------------------------------------------------


-- CREATE TABLE "type" -----------------------------------------
CREATE TABLE `type` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`slug` VarChar( 105 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`hours` Decimal( 10, 2 ) NOT NULL,
	`color` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`created` DateTime NOT NULL,
	`updated` DateTime NOT NULL,
	`orden` Int( 11 ) NULL,
	`erakutsi` TinyInt( 1 ) NULL,
	`related` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`erakutsi_eskaera` TinyInt( 1 ) NULL,
	`description` LongText CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`lizentziamotabehar` TinyInt( 1 ) NULL,
	PRIMARY KEY ( `id` ),
	CONSTRAINT `UNIQ_8CDE5729989D9B62` UNIQUE( `slug` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 18;
-- -------------------------------------------------------------


-- CREATE TABLE "user" -----------------------------------------
CREATE TABLE `user` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`username` VarChar( 180 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`username_canonical` VarChar( 180 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`email` VarChar( 180 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`email_canonical` VarChar( 180 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`enabled` TinyInt( 1 ) NOT NULL,
	`salt` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`password` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`last_login` DateTime NULL,
	`confirmation_token` VarChar( 180 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`password_requested_at` DateTime NULL,
	`roles` LongText CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
	`dn` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	`department` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`displayname` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`nan` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`lanpostua` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`members` LongText CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '(DC2Type:json_array)',
	`notes` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`hizkuntza` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	`sailburuada` TinyInt( 1 ) NULL DEFAULT 0,
	`ldapsaila` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
	PRIMARY KEY ( `id` ),
	CONSTRAINT `UNIQ_8D93D64992FC23A8` UNIQUE( `username_canonical` ),
	CONSTRAINT `UNIQ_8D93D649A0D96FBF` UNIQUE( `email_canonical` ),
	CONSTRAINT `UNIQ_8D93D649C05FB297` UNIQUE( `confirmation_token` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci
ENGINE = InnoDB
AUTO_INCREMENT = 157;
-- -------------------------------------------------------------


-- Dump data of "calendar" ---------------------------------
INSERT INTO `calendar`(`id`,`user_id`,`template_id`,`name`,`year`,`hours_year`,`hours_free`,`hours_self`,`hours_compensed`,`hours_day`,`note`,`slug`,`created`,`updated`,`content_changed_by`,`percent_year`,`hours_sindikal`,`hirurtekoa`,`hours_self_half`) VALUES 
( '270', '3', '7', 'GORKA GONZALEZ ETXEPARE', '2019', '1590.00', '130.68', '27.04', '5.96', '7.26', '<p><u><strong>NAE 3&nbsp;egun, 5 ordu eta 15 minutu (27,04ordu)</strong></u></p>

<p>4 egun oso (29,04 ordu)<u><strong> - egun 1</strong></u> = 3 egun oso (21,78 ordu) <u><strong>- egun 1</strong></u> = 2 egun (14,52ordu)</p>

<p>2 egun zatitzeko (14,52 ordu) <u><strong>- 2 ordu</strong></u> = 12,52 ordu (egun 1, 5 ordu eta 15 minutu)</p>', 'gorka-gonzalez-etxepare-2', '2019-01-07 12:42:43', '2019-08-26 10:44:49', NULL, '100.00', '0.00', '0.00', '12.52' ),
( '271', '27', '7', 'ITZIAR ELORZA ZORROZUA', '2019', '1590.00', '188.76', '43.56', '0.00', '7.26', NULL, 'itziar-elorza-zorrozua', '2019-01-07 12:46:46', '2019-01-07 12:46:46', NULL, '100.00', '0.00', '0.00', '14.52' ),
( '272', '63', '7', 'IÑIGO ESNAOLA ARBIZA', '2019', '1590.00', '166.98', '43.56', '0.00', '7.26', NULL, 'inigo-esnaola-arbiza-2', '2019-01-07 12:48:50', '2019-05-10 07:51:52', NULL, '100.00', '0.00', '0.00', '14.52' ),
( '273', '92', '6', 'IZASKUN GOMEZ CERMEÑO', '2019', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, 'izaskun-gomez-cermeno', '2019-01-07 12:49:34', '2019-01-07 12:49:34', NULL, '100.00', '0.00', '0.00', '0.00' ),
( '274', '2', '7', 'IKER IBARGUREN BERASALUZE ( +5 opor egun 2018)', '2019', '1590.00', '250.00', '29.04', '9.37', '7.26', '<p><u><strong>NAE 4&nbsp;EGUN (29,04 ordu)</strong></u></p>

<p>4 egun oso (29,04 ordu)<u><strong> - egun 1</strong></u> = 3 egun (21,78ordu) - egun 1 = 2 egun (14,52ordu)</p>

<p>2 egun oso (14,52ordu)</p>', 'iker-ibarguren-berasaluze-5-opor-egun-2018', '2019-01-07 13:31:23', '2019-08-27 12:47:20', NULL, '100.00', '30.00', '0.00', '14.52' ),
( '275', '32', '7', 'ITZIAR MINER CANFLANCA (+ 2018ko opor egun 1)', '2019', '1590.00', '36.30', '16.78', '0.00', '7.26', '<p><u><strong>NAE 2&nbsp;egun, 2&nbsp;ordu eta 15 minutu (16,78&nbsp;ordu)</strong></u></p>

<p>4 egun oso (29,04ordu)<u><strong> - egun 1</strong></u> = 3 egun (21,78 ordu)<u><strong> - egun 1</strong><em> </em></u>= 2 egun (14,52 ordu)<u><strong> - egun 1</strong></u>= egun 1 (7,26ordu)</p>

<p>2 egun zatitzeko (14,52ordu) <u><strong>- 3 ordu</strong></u> = 11,52ordu ( egun 1, 4ordu eta 15 minutu)<u><strong> - 2 ordu</strong></u> = 9,52ordu&nbsp; ( egun 1, 2 ordu eta 15 minutu)</p>', 'itziar-miner-canflanca-2018ko-opor-egun-1', '2019-01-07 13:49:40', '2019-06-28 12:41:56', NULL, '100.00', '0.00', '0.00', '9.52' ),
( '276', '82', '7', 'MARIAN SUAREZ MARTIN', '2019', '1590.00', '123.42', '34.30', '5.77', '7.26', '<p><u><strong>NAE 4&nbsp;egun, 3 ordu eta 15 minutu (34,30ordu)</strong></u></p>

<p>4 egun oso (29,04 ordu)<u><strong> - egun 1</strong></u> = 3 egun (21,78 ordu)</p>

<p>2 egun zatitzeko (14,52ordu)<u><strong> - 2 ordu</strong></u> = 12,52 ordu&nbsp; (egun 1, 3 ordu eta 15 minutu)</p>', 'marian-suarez-martin-2', '2019-01-07 13:55:55', '2019-06-13 11:41:31', NULL, '100.00', '0.00', '0.00', '12.52' ),
( '277', '48', '7', 'JOSE LUIS ARANBURU GOMEZ (+5 NAE hirurtekoengatik)', '2019', '1590.00', '72.60', '21.80', '0.00', '7.26', '<p>** 2019/01/07an egutegia sortuta ez zuenez, emailez egin zuen eskaera 2019/01/08rako 3 NAE ordukoa. Bertan behera utzi dut 7an baja hartu duelako baina berez berak eskatu behar zuen eta ez duenez egin, deskontatu beharko zitzaion. Marmarka ez entzutearren ezabatu dut.</p>

<p><u><strong>NAE 21,80 ordu (3&nbsp;egun)</strong></u></p>

<p>9 egun oso (65,34ordu) - <u><strong>2 egun</strong></u> = 7 egun (50,82 ordu) <u><strong>- egun 1</strong></u>=&nbsp; 6 egun (43,58&nbsp;ordu)<u><strong> - egun 1 </strong></u>= 5 egun (36,32ordu)<u><strong> - egun</strong></u> 1 = 4 egun (29,06ordu)<u><strong> - egun 1 </strong></u>= 3 egun (21,80ordu)</p>

<p>2 egun zatitzeko (14,52ordu)<u><strong> - 3 ordu</strong></u> = egun 1, 4 ordu eta 15 minutu(11,52ordu)<u><strong> - 3 ordu</strong></u> = 8,52 ordu ( egun 1, ordu 1 eta 15 minutu)<u><strong> - 2,5 ordu</strong></u>= 6,02 ordu ( 6 ordu eta minutu 1) <u><strong>- 2 ordu </strong></u>= 4,02 ordu ( 4 ordu eta minutu 1) <u><strong>- 2 ordu</strong></u> = 2,02ordu (2 ordu eta minutu 1)<u><strong> - 2 ordu</strong></u>= 0</p>

<p>&nbsp;</p>', 'jose-luis-aranburu-gomez-5-nae-hirurtekoengatik-1', '2019-01-07 14:03:23', '2019-08-27 09:45:25', NULL, '100.00', '0.00', '5.00', '0.00' ),
( '278', '76', '7', 'IKER OSTOLAZA OYARZABAL', '2019', '1590.00', '159.72', '36.30', '0.00', '7.26', '<p><u><strong>NAE 5&nbsp;egun (36,30ordu)</strong></u></p>

<p>4 egun oso (29,04ordu)<u><strong> - egun </strong></u>1 = 3 egun (21,78ordu)</p>

<p>2 egun zatitzeko (14,52ordu)</p>', 'iker-ostolaza-oyarzabal-2', '2019-01-07 14:05:43', '2019-06-26 08:16:10', NULL, '100.00', '0.00', '0.00', '14.52' ),
( '279', '18', '7', 'IBAI SAAVEDRA ALONSO', '2019', '1590.00', '29.04', '9.52', '13.30', '7.26', '<p><u><strong>NAE 9,52&nbsp;ordu (&nbsp;egun 1 , 2 ordu eta 15 minutu)</strong></u></p>

<p>4 egun oso (29,04ordu) <u><strong>- 2 egun</strong></u> = 2 egun (14,52ordu) <u><strong>- 2 egun</strong></u>= 0</p>

<p>2 egun zatitzeko (14,52ordu)<u><strong> - 5 ordu</strong></u> =9,52ordu (egun1, 2 ordu eta 15 minutu)</p>', 'ibai-saavedra-alonso-2', '2019-01-07 14:09:17', '2019-06-28 12:50:36', NULL, '100.00', '0.00', '0.00', '9.52' ),
( '280', '25', '7', 'IZASKUN UGARTEMENDIA GORRITI + ZUBI 1 (03)', '2019', '1590.00', '159.72', '36.30', '0.00', '7.26', '<p>2019/03/18an LANA EGIN DU. EGUN 1 GEHIAGO</p>

<p><u><strong>NAE 5&nbsp;egun (36,30ordu)</strong></u></p>

<p>4 egun oso (29,04 ordu) <u><strong>- egun 1</strong></u> = 3 egun oso (21,78ordu)</p>

<p>2 egun zatitzeko (14,52 ordu)</p>', 'izaskun-ugartemendia-gorriti-zubi-1-03', '2019-01-08 08:03:09', '2019-06-28 07:40:00', NULL, '100.00', '0.00', '0.00', '14.52' );
-- ---------------------------------------------------------


-- Dump data of "document" ---------------------------------
-- ---------------------------------------------------------


-- Dump data of "eskaera" ----------------------------------
-- ---------------------------------------------------------


-- Dump data of "event" ------------------------------------
INSERT INTO `event`(`id`,`calendar_id`,`type_id`,`name`,`start_date`,`end_date`,`hours`,`created`,`updated`,`egunorduak`,`nondik`,`hoursSelfBefore`,`hoursSelfHalfBefore`,`eskaera_id`) VALUES 
( '3770', '271', '11', 'ESZEDENTZIA', '2019-01-01 11:00:00', '2019-01-31 11:00:00', '166.98', '2019-01-07 12:47:00', '2019-01-07 12:47:00', NULL, NULL, '0.00', '0.00', NULL ),
( '3889', '277', '14', 'Baja ', '2019-01-07 11:00:00', '2019-01-09 11:00:00', '21.78', '2019-01-10 12:21:54', '2019-01-10 12:21:54', NULL, NULL, '0.00', '0.00', NULL ),
( '3893', '277', '5', 'Eskaeratik: Id: 455', '2019-01-11 00:00:00', '2019-01-11 00:00:00', '3.00', '2019-01-11 13:08:13', '2019-01-11 13:08:13', NULL, 'Orduak', '79.86', '14.52', NULL ),
( '3902', '276', '8', 'LIZENTZIA (ANAIA INGRESOA)', '2019-01-02 11:00:00', '2019-01-04 11:00:00', '21.78', '2019-01-15 09:45:59', '2019-01-15 09:45:59', NULL, NULL, '0.00', '0.00', NULL ),
( '3903', '276', '12', '2018KO OPORRAK (BAJA LUZE BATEN ONDOREN)', '2019-01-07 11:00:00', '2019-01-21 11:00:00', '79.86', '2019-01-15 09:46:27', '2019-01-15 09:46:27', NULL, NULL, '0.00', '0.00', NULL ),
( '3909', '271', '11', 'ESZEDENTZIA', '2019-02-01 11:00:00', '2019-02-20 11:00:00', '101.64', '2019-01-24 08:05:12', '2019-01-24 08:05:12', NULL, NULL, '0.00', '0.00', NULL ),
( '3914', '280', '8', 'Eskaeratik: Id: 496', '2019-01-17 00:00:00', '2019-01-17 00:00:00', '2.00', '2019-02-01 10:27:30', '2019-02-01 10:27:30', NULL, NULL, '0.00', '0.00', NULL ),
( '3917', '278', '5', 'Eskaeratik: Id: 488', '2019-01-21 00:00:00', '2019-01-21 00:00:00', '7.26', '2019-02-01 10:58:33', '2019-02-01 10:58:33', NULL, 'Egunak', '43.56', '14.52', NULL ),
( '3922', '275', '8', 'Eskaeratik: Id: 484', '2019-01-11 00:00:00', '2019-01-11 00:00:00', '2.00', '2019-02-01 11:06:29', '2019-02-01 11:06:29', NULL, NULL, '0.00', '0.00', NULL ),
( '3923', '275', '8', 'Eskaeratik: Id: 452', '2019-01-23 00:00:00', '2019-01-23 00:00:00', '4.00', '2019-02-01 11:07:16', '2019-02-01 11:07:16', NULL, NULL, '0.00', '0.00', NULL ),
( '3938', '277', '8', 'Eskaeratik: Id: 470', '2019-01-07 00:00:00', '2019-01-07 00:00:00', '2.00', '2019-02-01 11:32:17', '2019-02-01 11:32:17', NULL, NULL, '0.00', '0.00', NULL ),
( '3939', '277', '5', 'Eskaeratik: Id: 462', '2019-01-16 00:00:00', '2019-01-16 00:00:00', '3.00', '2019-02-01 11:34:24', '2019-02-01 11:34:24', NULL, 'Orduak', '76.86', '11.52', NULL ),
( '3957', '279', '8', 'Eskaeratik: Id: 536', '2019-01-28 00:00:00', '2019-01-28 00:00:00', '3.00', '2019-02-07 07:57:14', '2019-02-07 07:57:14', NULL, NULL, '0.00', '0.00', NULL ),
( '3958', '279', '5', 'Eskaeratik: Id: 524', '2019-02-01 00:00:00', '2019-02-01 00:00:00', '5.00', '2019-02-07 07:57:43', '2019-02-07 07:57:43', NULL, 'Orduak', '43.56', '14.52', NULL ),
( '3966', '274', '8', 'Eskaeratik: Id: 528', '2019-01-31 00:00:00', '2019-01-31 00:00:00', '3.50', '2019-02-07 08:22:36', '2019-02-07 08:22:36', NULL, NULL, '0.00', '0.00', NULL ),
( '3967', '275', '5', 'Eskaeratik: Id: 525', '2019-01-31 00:00:00', '2019-01-31 00:00:00', '7.26', '2019-02-07 08:26:20', '2019-02-07 08:26:20', NULL, 'Egunak', '43.56', '14.52', NULL ),
( '3968', '275', '5', 'Eskaeratik: Id: 516', '2019-02-05 00:00:00', '2019-02-05 00:00:00', '7.26', '2019-02-07 08:27:38', '2019-02-07 08:27:38', NULL, 'Egunak', '36.30', '14.52', NULL ),
( '3978', '277', '5', 'Eskaeratik: Id: 505', '2019-01-25 00:00:00', '2019-01-25 00:00:00', '2.50', '2019-02-07 09:08:36', '2019-02-07 09:08:36', NULL, 'Orduak', '73.86', '8.52', NULL ),
( '3979', '277', '5', 'Eskaeratik: Id: 494', '2019-01-22 00:00:00', '2019-01-22 00:00:00', '2.00', '2019-02-07 09:10:47', '2019-02-07 09:10:47', NULL, 'Orduak', '71.36', '6.02', NULL ),
( '3983', '276', '5', 'Eskaeratik: Id: 495', '2019-01-25 00:00:00', '2019-01-25 00:00:00', '7.26', '2019-02-07 09:53:12', '2019-02-07 09:53:12', NULL, 'Egunak', '43.56', '14.52', NULL ),
( '3989', '274', '14', 'BAJA', '2019-02-07 11:00:00', '2019-02-11 11:00:00', '21.78', '2019-02-14 08:01:08', '2019-02-14 08:01:08', NULL, NULL, '0.00', '0.00', NULL ),
( '4007', '275', '8', 'Eskaeratik: Id: 515', '2019-02-04 00:00:00', '2019-02-04 00:00:00', '7.26', '2019-02-14 10:19:11', '2019-02-14 10:19:11', NULL, NULL, '0.00', '0.00', NULL ),
( '4012', '271', '11', 'EZSEDENTZIA', '2019-02-21 11:00:00', '2019-04-08 10:00:00', '239.58', '2019-02-20 12:08:40', '2019-02-20 12:08:40', NULL, NULL, '0.00', '0.00', NULL ),
( '4017', '280', '8', 'LANA EGIN DU', '2019-03-18 11:00:00', '2019-03-18 11:00:00', '7.26', '2019-03-20 10:07:38', '2019-03-20 10:07:38', NULL, NULL, '0.00', '0.00', NULL ),
( '4028', '274', '14', 'BAJA', '2019-03-13 11:00:00', '2019-03-31 10:00:00', '94.38', '2019-03-26 10:29:23', '2019-03-26 10:29:23', NULL, NULL, '0.00', '0.00', NULL ),
( '4050', '275', '17', 'GREBA', '2019-03-08 11:00:00', '2019-03-08 11:00:00', '7.26', '2019-03-26 10:39:03', '2019-03-26 10:39:03', NULL, NULL, '0.00', '0.00', NULL ),
( '4054', '280', '17', 'GREBA', '2019-03-08 11:00:00', '2019-03-08 11:00:00', '7.26', '2019-03-26 10:40:07', '2019-03-26 10:40:07', NULL, NULL, '0.00', '0.00', NULL ),
( '4060', '273', '17', 'GREBA', '2019-03-08 11:00:00', '2019-03-08 11:00:00', '0.00', '2019-03-26 12:52:06', '2019-03-26 12:52:06', NULL, NULL, '0.00', '0.00', NULL ),
( '4086', '276', '6', 'Eskaeratik: Id: 599', '2019-03-01 00:00:00', '2019-03-01 00:00:00', '3.00', '2019-03-29 10:47:48', '2019-03-29 10:47:48', NULL, NULL, '0.00', '0.00', NULL ),
( '4088', '276', '6', 'Eskaeratik: Id: 654', '2019-03-26 00:00:00', '2019-03-26 00:00:00', '2.00', '2019-03-29 10:48:53', '2019-03-29 10:48:53', NULL, NULL, '0.00', '0.00', NULL ),
( '4089', '276', '8', 'Eskaeratik: Id: 647', '2019-03-22 00:00:00', '2019-03-22 00:00:00', '2.00', '2019-03-29 10:51:27', '2019-03-29 10:51:27', NULL, NULL, '0.00', '0.00', NULL ),
( '4090', '276', '8', 'Eskaeratik: Id: 648', '2019-03-25 00:00:00', '2019-03-25 00:00:00', '5.00', '2019-03-29 10:52:58', '2019-03-29 10:52:58', NULL, NULL, '0.00', '0.00', NULL ),
( '4091', '276', '8', 'Eskaeratik: Id: 659', '2019-03-21 00:00:00', '2019-03-21 00:00:00', '1.50', '2019-03-29 10:53:30', '2019-03-29 10:53:30', NULL, NULL, '0.00', '0.00', NULL ),
( '4126', '275', '8', 'Eskaeratik: Id: 466', '2019-02-14 00:00:00', '2019-02-14 00:00:00', '7.26', '2019-03-29 12:10:14', '2019-03-29 12:10:14', NULL, NULL, '0.00', '0.00', NULL ),
( '4143', '277', '8', 'Eskaeratik: Id: 618', '2019-03-12 00:00:00', '2019-03-12 00:00:00', '1.00', '2019-03-29 12:39:17', '2019-03-29 12:39:17', NULL, NULL, '0.00', '0.00', NULL ),
( '4144', '279', '6', 'Eskaeratik: Id: 614', '2019-03-28 00:00:00', '2019-03-29 00:00:00', '14.52', '2019-03-29 12:40:36', '2019-03-29 12:40:36', NULL, NULL, '0.00', '0.00', NULL ),
( '4147', '274', '8', 'Eskaeratik: Id: 594', '2019-02-25 00:00:00', '2019-02-25 00:00:00', '2.00', '2019-03-29 12:44:44', '2019-03-29 12:44:44', NULL, NULL, '0.00', '0.00', NULL ),
( '4151', '278', '8', 'Eskaeratik: Id: 579', '2019-02-22 00:00:00', '2019-02-22 00:00:00', '2.00', '2019-03-29 12:47:12', '2019-03-29 12:47:12', NULL, NULL, '0.00', '0.00', NULL ),
( '4167', '276', '8', 'Eskaeratik: Id: 645', '2019-03-27 00:00:00', '2019-03-27 00:00:00', '3.00', '2019-04-03 10:21:10', '2019-04-03 10:21:10', NULL, NULL, '0.00', '0.00', NULL ),
( '4175', '270', '5', 'Eskaeratik: Id: 697', '2019-04-02 00:00:00', '2019-04-02 00:00:00', '7.26', '2019-04-11 08:08:46', '2019-04-11 08:08:46', NULL, 'Egunak', '43.56', '14.52', NULL ),
( '4183', '279', '6', 'Eskaeratik: Id: 690', '2019-04-15 00:00:00', '2019-04-16 00:00:00', '14.52', '2019-04-11 08:21:47', '2019-04-11 08:21:47', NULL, NULL, '0.00', '0.00', NULL ),
( '4184', '279', '13', 'Eskaeratik: Id: 691', '2019-04-17 00:00:00', '2019-04-26 00:00:00', '36.30', '2019-04-11 08:22:16', '2019-04-11 08:22:16', NULL, NULL, '0.00', '0.00', NULL ),
( '4185', '279', '13', 'Eskaeratik: Id: 692', '2019-07-29 00:00:00', '2019-08-23 00:00:00', '123.42', '2019-04-11 08:22:47', '2019-04-11 08:22:47', NULL, NULL, '0.00', '0.00', NULL ),
( '4186', '279', '5', 'Eskaeratik: Id: 693', '2019-05-02 00:00:00', '2019-05-03 00:00:00', '14.52', '2019-04-11 08:24:22', '2019-04-11 08:24:22', NULL, 'Egunak', '38.56', '9.52', NULL ),
( '4187', '279', '5', 'Eskaeratik: Id: 694', '2019-06-20 00:00:00', '2019-06-21 00:00:00', '14.52', '2019-04-11 08:25:27', '2019-04-11 08:25:27', NULL, 'Egunak', '24.04', '9.52', NULL ),
( '4202', '275', '8', 'Eskaeratik: Id: 467', '2019-03-11 00:00:00', '2019-03-12 00:00:00', '14.52', '2019-04-11 09:23:30', '2019-04-11 09:23:30', NULL, NULL, '0.00', '0.00', NULL ),
( '4203', '270', '13', 'Eskaeratik: Id: 741', '2019-04-15 00:00:00', '2019-04-17 00:00:00', '21.78', '2019-04-11 09:44:09', '2019-04-11 09:44:09', NULL, NULL, '0.00', '0.00', NULL ),
( '4213', '275', '8', 'Eskaeratik: Id: 680', '2019-03-29 00:00:00', '2019-03-29 00:00:00', '4.00', '2019-04-11 09:59:50', '2019-04-11 09:59:50', NULL, NULL, '0.00', '0.00', NULL ),
( '4221', '276', '13', 'Eskaeratik: Id: 725', '2019-04-23 00:00:00', '2019-04-26 00:00:00', '29.04', '2019-04-12 09:04:09', '2019-04-12 09:04:09', NULL, NULL, '0.00', '0.00', NULL ),
( '4236', '277', '8', 'Eskaeratik: Id: 740', '2019-04-11 00:00:00', '2019-04-11 00:00:00', '1.00', '2019-04-26 15:06:12', '2019-04-26 15:06:12', NULL, NULL, '0.00', '0.00', NULL ),
( '4237', '277', '13', 'Eskaeratik: Id: 723', '2019-04-23 00:00:00', '2019-04-26 00:00:00', '29.04', '2019-04-26 15:06:54', '2019-04-26 15:06:54', NULL, NULL, '0.00', '0.00', NULL ),
( '4238', '277', '5', 'Eskaeratik: Id: 751', '2019-04-16 00:00:00', '2019-04-16 00:00:00', '2.00', '2019-04-26 15:08:16', '2019-04-26 15:08:16', NULL, 'Orduak', '69.36', '4.02', NULL ),
( '4242', '275', '13', 'Eskaeratik: Id: 745', '2019-04-23 00:00:00', '2019-04-26 00:00:00', '29.04', '2019-04-26 15:11:12', '2019-04-26 15:11:12', NULL, NULL, '0.00', '0.00', NULL ),
( '4250', '277', '14', 'BAJA', '2019-04-09 10:00:00', '2019-04-10 10:00:00', '14.52', '2019-04-26 15:27:09', '2019-04-26 15:27:09', NULL, NULL, '0.00', '0.00', NULL ),
( '4253', '274', '14', 'BAJA', '2019-04-01 10:00:00', '2019-04-30 10:00:00', '159.72', '2019-04-26 15:33:10', '2019-04-26 15:33:10', NULL, NULL, '0.00', '0.00', NULL ),
( '4268', '275', '5', 'Eskaeratik: Id: 816', '2019-05-10 00:00:00', '2019-05-10 00:00:00', '7.26', '2019-05-09 10:14:56', '2019-05-09 10:14:56', NULL, 'Egunak', '29.04', '14.52', NULL ),
( '4287', '280', '8', 'Eskaeratik: Id: 774', '2019-04-12 00:00:00', '2019-04-12 00:00:00', '2.00', '2019-05-10 07:44:36', '2019-05-10 07:44:36', NULL, NULL, '0.00', '0.00', NULL ),
( '4288', '280', '5', 'Eskaeratik: Id: 790', '2019-04-30 00:00:00', '2019-04-30 00:00:00', '7.26', '2019-05-10 07:45:04', '2019-05-10 07:45:04', NULL, 'Egunak', '43.56', '14.52', NULL ),
( '4293', '272', '8', 'Eskaeratik: Id: 777', '2019-04-15 00:00:00', '2019-04-15 00:00:00', '2.00', '2019-05-10 07:51:17', '2019-05-10 07:51:17', NULL, NULL, '0.00', '0.00', NULL ),
( '4294', '272', '8', 'Eskaeratik: Id: 776', '2019-04-01 00:00:00', '2019-04-01 00:00:00', '2.00', '2019-05-10 07:51:38', '2019-05-10 07:51:38', NULL, NULL, '0.00', '0.00', NULL ),
( '4295', '272', '13', 'Eskaeratik: Id: 775', '2019-04-23 00:00:00', '2019-04-25 00:00:00', '21.78', '2019-05-10 07:51:52', '2019-05-10 07:51:52', NULL, NULL, '0.00', '0.00', NULL ),
( '4332', '270', '8', 'Eskaeratik: Id: 847', '2019-05-14 00:00:00', '2019-05-14 00:00:00', '4.00', '2019-05-20 08:52:34', '2019-05-20 08:52:34', NULL, NULL, '0.00', '0.00', NULL ),
( '4351', '276', '5', 'Eskaeratik: Id: 841', '2019-05-17 00:00:00', '2019-05-17 00:00:00', '2.00', '2019-05-22 12:38:25', '2019-05-22 12:38:25', NULL, 'Orduak', '36.30', '14.52', NULL ),
( '4364', '275', '8', 'Eskaeratik: Id: 794', '2019-05-20 00:00:00', '2019-05-20 00:00:00', '4.00', '2019-05-22 13:34:05', '2019-05-22 13:34:05', NULL, NULL, '0.00', '0.00', NULL ),
( '4368', '277', '8', 'Eskaeratik: Id: 857', '2019-05-23 00:00:00', '2019-05-23 00:00:00', '1.00', '2019-05-24 10:25:53', '2019-05-24 10:25:53', NULL, NULL, '0.00', '0.00', NULL ),
( '4369', '277', '5', 'Eskaeratik: Id: 856', '2019-05-23 00:00:00', '2019-05-23 00:00:00', '2.00', '2019-05-24 10:26:09', '2019-05-24 10:26:09', NULL, 'Orduak', '67.36', '2.02', NULL ),
( '4370', '270', '8', 'Eskaeratik: Id: 853', '2019-05-16 00:00:00', '2019-05-16 00:00:00', '7.26', '2019-05-24 10:27:17', '2019-05-24 10:27:17', NULL, NULL, '0.00', '0.00', NULL ),
( '4375', '274', '14', 'baja', '2019-05-01 10:00:00', '2019-05-27 10:00:00', '137.94', '2019-05-29 09:47:46', '2019-05-29 09:47:46', NULL, NULL, '0.00', '0.00', NULL ),
( '4388', '275', '8', 'Eskaeratik: Id: 849', '2019-06-04 00:00:00', '2019-06-04 00:00:00', '4.00', '2019-06-04 09:01:17', '2019-06-04 09:01:17', NULL, NULL, '0.00', '0.00', NULL ),
( '4395', '277', '5', 'Eskaeratik: Id: 903', '2019-06-04 00:00:00', '2019-06-05 00:00:00', '14.52', '2019-06-04 10:27:22', '2019-06-04 10:27:22', NULL, 'Egunak', '65.36', '0.00', NULL ),
( '4398', '277', '5', 'Eskaeratik: Id: 896', '2019-05-30 00:00:00', '2019-05-30 00:00:00', '7.26', '2019-06-04 13:04:41', '2019-06-04 13:04:41', NULL, 'Egunak', '50.84', '0.00', NULL ),
( '4404', '274', '5', 'Eskaeratik: Id: 950', '2019-06-10 00:00:00', '2019-06-10 00:00:00', '7.26', '2019-06-13 09:53:22', '2019-06-13 09:53:22', NULL, 'Egunak', '43.56', '14.52', NULL ),
( '4417', '275', '8', 'Eskaeratik: Id: 795', '2019-06-05 00:00:00', '2019-06-05 00:00:00', '7.26', '2019-06-13 10:04:23', '2019-06-13 10:04:23', NULL, NULL, '0.00', '0.00', NULL ),
( '4418', '275', '5', 'Eskaeratik: Id: 926', '2019-06-04 00:00:00', '2019-06-04 00:00:00', '3.00', '2019-06-13 10:06:00', '2019-06-13 10:06:00', NULL, 'Orduak', '21.78', '14.52', NULL ),
( '4433', '277', '5', 'Eskaeratik: Id: 895', '2019-05-28 00:00:00', '2019-05-28 00:00:00', '7.26', '2019-06-13 11:01:28', '2019-06-13 11:01:28', NULL, 'Egunak', '43.58', '0.00', NULL ),
( '4445', '276', '13', 'Eskaeratik: Id: 866', '2019-06-07 00:00:00', '2019-06-13 00:00:00', '36.30', '2019-06-13 11:41:31', '2019-06-13 11:41:31', NULL, NULL, '0.00', '0.00', NULL ),
( '4460', '270', '13', 'Eskaeratik: Id: 989', '2019-07-01 00:00:00', '2019-07-05 00:00:00', '36.30', '2019-06-26 08:02:16', '2019-06-26 08:02:16', NULL, NULL, '0.00', '0.00', NULL ),
( '4461', '270', '5', 'Eskaeratik: Id: 988', '2019-06-21 00:00:00', '2019-06-21 00:00:00', '7.26', '2019-06-26 08:02:40', '2019-06-26 08:02:40', NULL, 'Egunak', '36.30', '14.52', NULL ),
( '4467', '275', '8', 'Eskaeratik: Id: 980', '2019-06-14 00:00:00', '2019-06-14 00:00:00', '3.00', '2019-06-26 08:09:21', '2019-06-26 08:09:21', NULL, NULL, '0.00', '0.00', NULL ),
( '4468', '275', '5', 'Eskaeratik: Id: 963', '2019-06-13 00:00:00', '2019-06-13 00:00:00', '2.00', '2019-06-26 08:09:44', '2019-06-26 08:09:44', NULL, 'Orduak', '18.78', '11.52', NULL ),
( '4473', '278', '13', 'Eskaeratik: Id: 975', '2019-06-25 00:00:00', '2019-06-28 00:00:00', '29.04', '2019-06-26 08:16:10', '2019-06-26 08:16:10', NULL, NULL, '0.00', '0.00', NULL ),
( '4499', '276', '8', 'Eskaeratik: Id: 842', '2019-06-14 00:00:00', '2019-06-14 00:00:00', '4.00', '2019-06-26 12:07:50', '2019-06-26 12:07:50', NULL, NULL, '0.00', '0.00', NULL ),
( '4505', '279', '8', 'Eskaeratik: Id: 1036', '2019-06-10 00:00:00', '2019-06-10 00:00:00', '2.00', '2019-06-28 07:27:46', '2019-06-28 07:27:46', NULL, NULL, '0.00', '0.00', NULL ),
( '4516', '275', '8', 'Eskaeratik: Id: 1019', '2019-06-25 00:00:00', '2019-06-25 00:00:00', '2.00', '2019-06-28 07:30:26', '2019-06-28 07:30:26', NULL, NULL, '0.00', '0.00', NULL ),
( '4518', '276', '8', 'Eskaeratik: Id: 1000', '2019-06-18 00:00:00', '2019-06-18 00:00:00', '1.30', '2019-06-28 07:31:57', '2019-06-28 07:31:57', NULL, NULL, '0.00', '0.00', NULL ),
( '4521', '280', '13', 'Eskaeratik: Id: 1024', '2019-07-09 00:00:00', '2019-07-12 00:00:00', '29.04', '2019-06-28 07:39:09', '2019-06-28 07:39:09', NULL, NULL, '0.00', '0.00', NULL ),
( '4522', '280', '4', 'SAN FERMIN EGUNA', '2019-07-08 10:00:00', '2019-07-08 10:00:00', '7.26', '2019-06-28 07:39:31', '2019-06-28 07:39:31', NULL, NULL, '0.00', '0.00', NULL ),
( '4523', '280', '13', 'Eskaeratik: Id: 1023', '2019-06-25 00:00:00', '2019-06-25 00:00:00', '7.26', '2019-06-28 07:40:00', '2019-06-28 07:40:00', NULL, NULL, '0.00', '0.00', NULL ),
( '4524', '280', '8', 'Antxoko bulegoan LAN EGUNA', '2019-06-24 10:00:00', '2019-06-24 10:00:00', '7.26', '2019-06-28 07:40:41', '2019-06-28 07:40:41', NULL, NULL, '0.00', '0.00', NULL ),
( '4526', '270', '5', 'Eskaeratik: Id: 1008', '2019-06-20 00:00:00', '2019-06-20 00:00:00', '2.00', '2019-06-28 07:43:02', '2019-06-28 07:43:02', NULL, 'Orduak', '29.04', '14.52', NULL ),
( '4537', '275', '13', 'Eskaeratik: Id: 1017', '2019-07-08 00:00:00', '2019-07-12 00:00:00', '36.30', '2019-06-28 12:41:39', '2019-06-28 12:41:39', NULL, NULL, '0.00', '0.00', NULL ),
( '4538', '275', '13', 'Eskaeratik: Id: 1018', '2019-08-05 00:00:00', '2019-08-23 00:00:00', '94.38', '2019-06-28 12:41:56', '2019-06-28 12:41:56', NULL, NULL, '0.00', '0.00', NULL ),
( '4544', '279', '6', 'Eskaeratik: Id: 1043', '2019-07-05 00:00:00', '2019-07-08 00:00:00', '14.52', '2019-06-28 12:49:59', '2019-06-28 12:49:59', NULL, NULL, '0.00', '0.00', NULL ),
( '4545', '279', '6', 'Eskaeratik: Id: 1042', '2019-06-28 00:00:00', '2019-06-28 00:00:00', '1.00', '2019-06-28 12:50:36', '2019-06-28 12:50:36', NULL, NULL, '0.00', '0.00', NULL ),
( '4558', '276', '8', 'Eskaeratik: Id: 1055', '2019-06-28 00:00:00', '2019-06-28 00:00:00', '2.00', '2019-07-24 13:23:25', '2019-07-24 13:23:25', NULL, NULL, '0.00', '0.00', NULL ),
( '4560', '276', '8', 'Eskaeratik: Id: 1002', '2019-07-11 00:00:00', '2019-07-11 00:00:00', '4.00', '2019-07-24 13:24:13', '2019-07-24 13:24:13', NULL, NULL, '0.00', '0.00', NULL ),
( '4561', '274', '5', 'Eskaeratik: Id: 1087', '2019-07-15 00:00:00', '2019-07-15 00:00:00', '7.26', '2019-07-24 13:25:09', '2019-07-24 13:25:09', NULL, 'Egunak', '36.30', '14.52', NULL ),
( '4565', '277', '8', 'Eskaeratik: Id: 1168', '2019-08-08 00:00:00', '2019-08-08 00:00:00', '2.00', '2019-08-26 10:12:19', '2019-08-26 10:12:19', NULL, NULL, '0.00', '0.00', NULL ),
( '4571', '277', '5', 'Eskaeratik: Id: 1052', '2019-07-03 00:00:00', '2019-07-03 00:00:00', '7.26', '2019-08-27 09:40:05', '2019-08-27 09:40:05', NULL, 'Egunak', '36.32', '0.00', NULL ),
( '4572', '277', '13', 'Eskaeratik: Id: 1099', '2019-07-29 00:00:00', '2019-08-02 00:00:00', '29.04', '2019-08-27 09:41:08', '2019-08-27 09:41:08', NULL, NULL, '0.00', '0.00', NULL ),
( '4573', '277', '5', 'Eskaeratik: Id: 1138', '2019-07-24 00:00:00', '2019-07-24 00:00:00', '7.26', '2019-08-27 09:42:22', '2019-08-27 09:42:22', NULL, 'Egunak', '29.06', '0.00', NULL ),
( '4574', '277', '8', 'Eskaeratik: Id: 1166', '2019-08-09 00:00:00', '2019-08-09 00:00:00', '2.00', '2019-08-27 09:43:23', '2019-08-27 09:43:23', NULL, NULL, '0.00', '0.00', NULL ),
( '4575', '277', '13', 'oporrak', '2019-08-19 10:00:00', '2019-08-28 10:00:00', '58.08', '2019-08-27 09:45:25', '2019-08-27 09:45:25', NULL, NULL, '0.00', '0.00', NULL );
-- ---------------------------------------------------------


-- Dump data of "event_history" ----------------------------
-- ---------------------------------------------------------


-- Dump data of "firma" ------------------------------------
-- ---------------------------------------------------------


-- Dump data of "firmadet" ---------------------------------
-- ---------------------------------------------------------


-- Dump data of "gutxienekoak" -----------------------------
INSERT INTO `gutxienekoak`(`id`,`name`,`portzentaia`,`created`,`updated`) VALUES 
( '8', 'INFORMATIKA', NULL, '2018-03-22 07:54:56', '2018-09-19 13:51:18' ),
( '9', 'GGBB', NULL, '2018-09-19 10:12:05', '2018-09-19 10:12:44' ),
( '10', 'ISUNAK', NULL, '2018-09-19 10:12:57', '2018-09-19 10:12:57' ),
( '11', 'IDAZKARIA', NULL, '2018-09-19 10:13:31', '2018-09-19 10:13:31' ),
( '12', 'HIRIGINTZA - ADMINISTRARI LANAK', NULL, '2018-09-19 10:14:05', '2018-09-19 10:14:05' ),
( '13', 'HIRIGINTZA - ARKITEKTOAK', NULL, '2018-09-19 13:46:12', '2018-09-19 13:46:12' ),
( '14', 'HAZ', NULL, '2018-09-19 13:47:13', '2018-09-19 13:47:13' ),
( '15', 'KONTABILITATEA', NULL, '2018-09-20 15:17:03', '2018-09-20 15:17:03' ),
( '16', 'LIBURUTEGIAK', NULL, '2018-11-08 13:05:27', '2018-11-08 13:05:27' ),
( '17', 'GIZARTEKINTZA', NULL, '2018-11-22 14:34:33', '2018-11-22 14:34:33' ),
( '18', 'KULTURA TEKNIKARIAK', NULL, '2018-11-22 14:35:26', '2018-11-22 14:38:26' ),
( '19', 'IDAZKARITZA (ADMINISTRARIAK)', NULL, '2018-11-22 14:37:17', '2018-11-22 14:37:17' );
-- ---------------------------------------------------------


-- Dump data of "gutxienekoakdet" --------------------------
INSERT INTO `gutxienekoakdet`(`id`,`gutxienekoak_id`,`user_id`,`created`,`updated`,`orden`) VALUES 
( '15', '8', '3', '2018-03-22 07:55:01', '2018-03-22 07:55:01', '0' ),
( '16', '8', '2', '2018-03-22 07:55:09', '2018-03-22 07:55:09', '1' ),
( '17', '9', '4', '2018-09-19 10:12:17', '2018-09-19 10:12:17', '2' ),
( '18', '9', '130', '2018-09-19 10:12:25', '2018-09-19 10:12:25', '3' ),
( '19', '10', '49', '2018-09-19 10:13:06', '2018-09-19 10:13:06', '4' ),
( '20', '10', '48', '2018-09-19 10:13:18', '2018-09-19 10:13:18', '5' ),
( '21', '11', '129', '2018-09-19 10:13:37', '2018-09-19 10:13:37', '6' ),
( '22', '11', '33', '2018-09-19 10:13:45', '2018-09-19 10:13:45', '7' ),
( '23', '12', '38', '2018-09-19 10:15:12', '2018-09-19 10:15:12', '8' ),
( '24', '12', '85', '2018-09-19 10:15:17', '2018-09-19 10:15:17', '9' ),
( '25', '13', '29', '2018-09-19 13:46:19', '2018-09-19 13:46:19', '10' ),
( '26', '13', '30', '2018-09-19 13:46:25', '2018-09-19 13:46:25', '11' ),
( '27', '14', '24', '2018-09-19 13:47:19', '2018-09-19 13:47:19', '12' ),
( '28', '14', '25', '2018-09-19 13:47:25', '2018-09-19 13:47:25', '13' ),
( '29', '14', '26', '2018-09-19 13:47:31', '2018-09-19 13:47:31', '14' ),
( '30', '14', '90', '2018-09-19 13:47:38', '2018-09-19 13:47:38', '15' ),
( '31', '14', '52', '2018-09-19 13:48:06', '2018-09-19 13:48:06', '16' ),
( '32', '15', '57', '2018-09-20 15:17:10', '2018-09-20 15:17:10', '17' ),
( '33', '15', '54', '2018-09-20 15:17:16', '2018-09-20 15:17:16', '18' ),
( '34', '16', '11', '2018-11-08 13:05:35', '2018-11-08 13:05:35', '19' ),
( '35', '16', '21', '2018-11-08 13:05:41', '2018-11-08 13:05:41', '20' ),
( '36', '16', '20', '2018-11-08 13:05:47', '2018-11-08 13:05:47', '21' ),
( '37', '16', '43', '2018-11-08 13:05:54', '2018-11-08 13:05:54', '22' ),
( '38', '16', '8', '2018-11-08 13:06:01', '2018-11-08 13:06:01', '23' ),
( '39', '17', '64', '2018-11-22 14:34:42', '2018-11-22 14:34:42', '24' ),
( '40', '17', '50', '2018-11-22 14:34:49', '2018-11-22 14:34:49', '25' ),
( '41', '17', '59', '2018-11-22 14:34:55', '2018-11-22 14:34:55', '26' ),
( '42', '18', '11', '2018-11-22 14:35:39', '2018-11-22 14:35:39', '27' ),
( '43', '18', '12', '2018-11-22 14:35:45', '2018-11-22 14:35:45', '28' ),
( '44', '19', '74', '2018-11-22 14:37:26', '2018-11-22 14:37:26', '29' ),
( '45', '19', '62', '2018-11-22 14:37:31', '2018-11-22 14:37:31', '30' ),
( '46', '18', '14', '2018-11-22 14:39:01', '2018-11-22 14:39:01', '31' );
-- ---------------------------------------------------------


-- Dump data of "hour" -------------------------------------
INSERT INTO `hour`(`id`,`calendar_id`,`date`,`hours`,`minutes`,`factor`,`total`) VALUES 
( '329', '279', '2019-01-17 00:00:00', '5.00', '10.00', '1.75', '9.04' ),
( '330', '279', '2019-01-25 00:00:00', '1.00', '30.00', '1.75', '2.63' ),
( '331', '276', '2019-02-01 00:00:00', '2.00', '0.00', '1.75', '3.50' ),
( '342', '276', '0003-03-27 00:00:00', '3.00', '0.00', '1.75', '5.25' ),
( '346', '279', '2019-01-22 00:00:00', '2.00', '10.00', '1.75', '3.79' ),
( '347', '279', '2019-02-19 00:00:00', '1.00', '15.00', '1.75', '2.19' ),
( '348', '279', '2019-03-14 00:00:00', '1.00', '10.00', '1.75', '2.04' ),
( '349', '279', '2019-03-28 00:00:00', '2.00', '15.00', '1.75', '3.94' ),
( '350', '279', '2019-04-02 00:00:00', '1.00', '20.00', '1.75', '2.33' ),
( '351', '279', '2019-04-05 00:00:00', '1.00', '30.00', '1.75', '2.63' ),
( '352', '279', '2019-04-30 00:00:00', '1.00', '15.00', '1.75', '2.19' ),
( '353', '279', '2019-05-14 00:00:00', '2.00', '0.00', '1.75', '3.50' ),
( '354', '279', '2019-05-16 00:00:00', '1.00', '10.00', '1.75', '2.04' ),
( '355', '279', '2019-05-22 00:00:00', '1.00', '25.00', '1.75', '2.48' ),
( '358', '270', '2019-07-13 00:00:00', '3.00', '20.00', '1.75', '5.83' );
-- ---------------------------------------------------------


-- Dump data of "lizentziamota" ----------------------------
INSERT INTO `lizentziamota`(`id`,`name`,`sinatubehar`,`created`,`updated`,`kostuabehar`) VALUES 
( '1', 'IKASTAROAK', '1', '2019-05-31 14:07:11', '2019-06-04 07:56:47', '1' ),
( '2', 'AZTERKETAK', '0', '2019-06-04 07:58:58', '2019-06-04 08:11:21', '0' ),
( '3', 'MEDIKU KONTSULTAK', '0', '2019-06-04 08:11:10', '2019-06-04 08:11:10', '0' ),
( '4', 'FAMILIAKO NORBAITEN INGRESOA', '0', '2019-06-04 08:11:46', '2019-06-04 08:11:46', '0' ),
( '5', 'BESTE BATZUK', '1', '2019-06-04 08:12:24', '2019-06-04 08:12:24', '0' );
-- ---------------------------------------------------------


-- Dump data of "log" --------------------------------------
-- ---------------------------------------------------------


-- Dump data of "notification" -----------------------------
-- ---------------------------------------------------------


-- Dump data of "sinatzaileak" -----------------------------
INSERT INTO `sinatzaileak`(`id`,`name`,`orden`,`created`,`updated`) VALUES 
( '1', 'GGBB', '0', '2018-03-12 14:56:41', '2018-03-12 15:01:39' ),
( '2', 'INFORMATIKA', '1', '2018-03-12 14:58:35', '2018-03-12 14:58:35' ),
( '3', 'IDAZKARITZA', '2', '2018-03-12 15:00:00', '2018-03-12 15:00:00' ),
( '4', 'AHOLKULARITZA JURIDIKOA', '3', '2018-03-12 15:01:58', '2018-03-12 15:01:58' ),
( '5', 'UDALTZAINGOA (ORDEZKOA - FAYA)', '4', '2018-03-12 15:09:54', '2018-03-12 15:17:13' ),
( '6', 'GIZARTE EKINTZA', '5', '2018-03-12 15:18:20', '2018-03-12 15:18:20' ),
( '7', 'HAUR ETA NERABEAK', '6', '2018-03-12 15:19:53', '2018-03-12 15:19:53' ),
( '8', 'KULTURA ETA HEZKUNTZA', '7', '2018-03-12 15:20:51', '2018-03-12 15:20:51' ),
( '9', 'EUSKERA', '8', '2018-03-12 15:23:26', '2018-03-12 15:23:26' ),
( '10', 'GAZTERIA', '9', '2018-03-12 15:25:27', '2018-03-12 15:25:27' ),
( '11', 'JARDUERA FISIKOA ETA KIROLA', '10', '2018-03-12 15:26:17', '2018-03-12 15:26:17' ),
( '12', 'HIRIGINTZA', '11', '2018-03-12 15:35:47', '2018-03-12 15:35:47' ),
( '13', 'ZERBITZUAK', '12', '2018-03-12 15:36:39', '2018-03-12 15:36:39' ),
( '14', 'OGASUNA', '13', '2018-03-12 15:38:50', '2018-03-12 15:38:50' ),
( '15', 'UDALTZAINGOA (IÑAKI PORTUGAL)', '14', '2018-03-13 15:06:12', '2018-03-13 15:06:12' ),
( '16', 'KIROLA', '15', '2018-09-12 13:24:44', '2018-09-12 13:24:44' ),
( '17', 'KULTURA ETA HEZKUNTZA (TG)', '16', '2018-10-01 07:44:25', '2018-10-01 07:44:25' ),
( '18', 'GIZARTE EKINTZA (TG)', '17', '2018-10-02 07:41:37', '2018-10-02 07:41:37' ),
( '19', 'OGASUNA (TG)', '18', '2018-10-02 12:08:13', '2018-10-02 12:08:13' ),
( '20', 'HIRIGINTZA (TG)', '19', '2018-10-18 09:00:42', '2018-10-18 09:00:42' ),
( '21', 'EUSKERA (TG)', '20', '2018-10-18 10:01:27', '2018-10-18 10:01:27' ),
( '22', 'KULTURA, EUSKERA, GAZTERIA, KIROLA', '21', '2018-11-06 10:01:02', '2018-11-06 10:01:02' ),
( '23', 'IDAZKARITZA (TG)', '22', '2018-11-19 09:42:21', '2018-11-19 09:42:21' ),
( '24', 'GGBB (TG)', '23', '2018-11-22 13:10:14', '2018-11-22 13:10:14' ),
( '25', 'GIZARTEKINTZA OK', '24', '2018-11-27 13:40:58', '2018-11-27 13:40:58' );
-- ---------------------------------------------------------


-- Dump data of "sinatzaileakdet" --------------------------
INSERT INTO `sinatzaileakdet`(`id`,`sinatzaileak_id`,`user_id`,`created`,`updated`,`orden`) VALUES 
( '2', '1', '91', '2018-03-12 14:58:10', '2018-03-12 14:58:10', '1' ),
( '4', '2', '91', '2018-03-12 14:59:16', '2018-05-16 14:05:03', '1' ),
( '5', '3', '33', '2018-03-12 15:00:09', '2018-03-12 15:00:09', '0' ),
( '7', '3', '91', '2018-03-12 15:00:28', '2018-10-03 14:17:45', '2' ),
( '8', '4', '92', '2018-03-12 15:09:04', '2018-03-12 15:09:04', '0' ),
( '10', '4', '91', '2018-03-12 15:09:24', '2018-03-12 15:09:24', '2' ),
( '11', '5', '45', '2018-03-12 15:17:23', '2018-03-12 15:17:23', '0' ),
( '13', '5', '91', '2018-03-12 15:17:40', '2018-03-12 15:17:40', '1' ),
( '14', '6', '56', '2018-03-12 15:18:28', '2018-03-12 15:18:28', '0' ),
( '17', '6', '91', '2018-03-12 15:19:26', '2019-06-27 08:47:07', '3' ),
( '18', '7', '92', '2018-03-12 15:20:01', '2018-03-12 15:20:01', '0' ),
( '20', '7', '91', '2018-03-12 15:20:13', '2018-03-12 15:20:13', '2' ),
( '21', '8', '12', '2018-03-12 15:21:04', '2018-03-12 15:21:04', '0' ),
( '24', '8', '91', '2018-03-12 15:22:23', '2018-12-05 07:49:11', '2' ),
( '25', '9', '19', '2018-03-12 15:23:38', '2018-03-12 15:23:38', '0' ),
( '28', '9', '91', '2018-03-12 15:25:07', '2019-06-27 08:48:27', '3' ),
( '31', '10', '91', '2018-03-12 15:25:51', '2018-03-12 15:25:51', '1' ),
( '32', '11', '91', '2018-03-12 15:26:23', '2018-03-12 15:26:23', '1' ),
( '34', '12', '30', '2018-03-12 15:35:59', '2018-03-12 15:35:59', '0' ),
( '35', '12', '95', '2018-03-12 15:36:08', '2018-03-12 15:36:08', '1' ),
( '37', '12', '91', '2018-03-12 15:36:20', '2018-10-03 14:25:35', '3' ),
( '38', '13', '96', '2018-03-12 15:37:42', '2018-03-12 15:37:42', '0' ),
( '40', '13', '91', '2018-03-12 15:37:59', '2019-06-27 08:39:11', '3' ),
( '41', '14', '32', '2018-03-12 15:38:57', '2018-03-12 15:38:57', '0' ),
( '44', '14', '91', '2018-03-12 15:39:51', '2018-11-06 10:12:28', '2' ),
( '45', '15', '44', '2018-03-13 15:06:32', '2018-03-13 15:06:56', '0' ),
( '46', '15', '91', '2018-03-13 15:06:39', '2018-03-13 15:06:57', '1' ),
( '48', '2', '130', '2018-05-16 14:04:52', '2018-05-16 14:05:21', '0' ),
( '49', '16', '130', '2018-09-12 13:27:00', '2018-09-12 13:27:00', '0' ),
( '50', '16', '91', '2018-09-12 13:27:14', '2018-09-13 13:19:25', '1' ),
( '51', '1', '130', '2018-09-12 13:52:37', '2018-10-03 14:24:06', '0' ),
( '52', '10', '130', '2018-09-12 13:53:14', '2019-06-27 08:37:13', '2' ),
( '53', '11', '130', '2018-09-12 13:53:40', '2018-10-03 14:24:42', '0' ),
( '54', '12', '130', '2018-09-12 13:53:59', '2018-10-03 14:25:19', '2' ),
( '55', '13', '130', '2018-09-12 13:54:21', '2019-06-27 08:39:14', '2' ),
( '56', '14', '130', '2018-09-12 13:54:39', '2018-11-06 10:12:26', '1' ),
( '57', '15', '130', '2018-09-12 13:55:00', '2018-09-12 13:55:00', '2' ),
( '58', '3', '130', '2018-09-12 13:55:32', '2018-09-12 13:55:32', '1' ),
( '59', '4', '130', '2018-09-12 13:55:50', '2019-03-21 08:06:34', '1' ),
( '60', '5', '130', '2018-09-12 13:56:12', '2018-09-12 13:56:12', '2' ),
( '61', '6', '130', '2018-09-12 13:56:31', '2019-06-27 08:47:12', '2' ),
( '62', '7', '130', '2018-09-12 13:56:48', '2019-04-04 09:25:00', '1' ),
( '63', '8', '130', '2018-09-12 13:57:10', '2018-09-12 13:57:10', '1' ),
( '64', '9', '130', '2018-09-12 13:57:28', '2019-06-27 08:48:31', '2' ),
( '66', '17', '130', '2018-10-01 07:47:04', '2019-06-27 11:30:37', '2' ),
( '67', '17', '91', '2018-10-01 07:47:10', '2019-06-27 11:30:41', '1' ),
( '69', '18', '130', '2018-10-02 07:41:53', '2019-06-27 08:41:19', '1' ),
( '70', '18', '91', '2018-10-02 07:41:59', '2019-06-27 08:41:37', '2' ),
( '72', '19', '130', '2018-10-02 12:08:26', '2018-10-02 12:08:26', '0' ),
( '73', '19', '91', '2018-10-02 12:08:31', '2018-10-02 12:08:31', '1' ),
( '74', '20', '95', '2018-10-18 09:00:51', '2018-10-18 09:00:51', '0' ),
( '75', '20', '130', '2018-10-18 09:01:02', '2018-10-18 09:01:02', '1' ),
( '76', '20', '91', '2018-10-18 09:01:07', '2018-10-18 09:01:07', '2' ),
( '78', '21', '130', '2018-10-18 10:01:56', '2019-06-27 08:42:54', '1' ),
( '79', '21', '91', '2018-10-18 10:02:04', '2019-06-27 08:43:04', '2' ),
( '80', '22', '12', '2018-11-06 10:01:19', '2018-11-06 10:01:19', '0' ),
( '81', '22', '19', '2018-11-06 10:01:26', '2018-11-06 10:01:26', '1' ),
( '82', '22', '18', '2018-11-06 10:01:33', '2018-11-06 10:01:33', '2' ),
( '83', '22', '15', '2018-11-06 10:01:39', '2018-11-06 10:01:39', '3' ),
( '85', '22', '130', '2018-11-06 10:01:51', '2018-11-06 10:01:51', '4' ),
( '86', '22', '91', '2018-11-06 10:02:00', '2018-11-06 10:02:00', '5' ),
( '87', '23', '130', '2018-11-19 09:43:15', '2018-11-19 09:43:15', '0' ),
( '88', '23', '91', '2018-11-19 09:43:22', '2018-11-19 09:43:22', '1' ),
( '89', '24', '91', '2018-11-22 13:10:20', '2018-11-22 13:10:20', '0' ),
( '90', '25', '56', '2018-11-27 13:41:05', '2018-11-27 13:41:05', '0' ),
( '92', '25', '130', '2018-11-27 13:41:16', '2019-06-27 08:45:49', '2' ),
( '93', '25', '91', '2018-11-27 13:41:22', '2019-06-27 08:46:09', '3' ),
( '95', '10', '150', '2019-06-27 08:37:00', '2019-06-27 08:37:07', '0' ),
( '96', '13', '151', '2019-06-27 08:38:50', '2019-06-27 08:38:50', '1' ),
( '97', '18', '149', '2019-06-27 08:41:07', '2019-06-27 08:41:07', '0' ),
( '98', '21', '149', '2019-06-27 08:42:50', '2019-06-27 08:42:50', '0' ),
( '99', '25', '149', '2019-06-27 08:44:39', '2019-06-27 08:44:39', '1' ),
( '100', '6', '149', '2019-06-27 08:46:55', '2019-06-27 08:46:55', '1' ),
( '101', '9', '149', '2019-06-27 08:48:16', '2019-06-27 08:48:16', '1' ),
( '102', '17', '92', '2019-06-27 11:28:52', '2019-06-27 11:28:52', '0' ),
( '103', '22', '92', '2019-06-27 11:31:04', '2019-06-27 11:31:04', '6' );
-- ---------------------------------------------------------


-- Dump data of "template" ---------------------------------
INSERT INTO `template`(`id`,`name`,`hours_year`,`hours_free`,`hours_self`,`hours_compensed`,`hours_day`,`slug`,`created`,`updated`) VALUES 
( '2', '2017 Orokorra', '1590.00', '191.36', '44.16', '0.00', '7.36', '2017-orokorra', '2017-04-21 05:58:14', '2017-05-05 10:46:23' ),
( '3', '2018 Orokorra', '1590.00', '190.32', '43.92', '0.00', '7.32', '2018-orokorra', '2018-01-10 06:28:32', '2018-02-02 12:37:18' ),
( '4', '2018 Udaltzaingoa', '1590.00', '186.94', '43.14', '0.00', '7.19', '2018-udaltzaingoa', '2018-02-02 12:40:30', '2018-02-02 12:40:30' ),
( '5', 'ZINEGOTZIAK', '0.00', '0.00', '0.00', '0.00', '0.00', 'zinegotziak', '2018-03-12 15:02:22', '2018-03-12 15:02:22' ),
( '6', 'SINATZAILEA', '0.00', '0.00', '0.00', '0.00', '0.00', 'sinatzailea', '2018-03-12 15:14:19', '2018-03-12 15:14:19' ),
( '7', '2019 Orokorra', '1590.00', '188.76', '43.56', '0.00', '7.26', '2019-orokorra', '2018-12-14 13:44:52', '2019-01-07 10:16:42' );
-- ---------------------------------------------------------


-- Dump data of "template_event" ---------------------------
INSERT INTO `template_event`(`id`,`template_id`,`type_id`,`name`,`start_date`,`end_date`,`created`,`updated`) VALUES 
( '370', '2', '4', 'Ostegun Santua', '2017-04-13 00:00:00', '2017-04-13 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '371', '2', '4', 'Pazko astelehena', '2017-04-17 00:00:00', '2017-04-17 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '372', '2', '4', 'Errege eguna', '2017-01-06 00:00:00', '2017-01-06 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '373', '2', '15', 'Zubia', '2017-07-24 00:00:00', '2017-07-24 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '374', '2', '15', 'Zubia', '2017-08-14 00:00:00', '2017-08-14 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '375', '2', '15', 'Zubia', '2017-10-13 00:00:00', '2017-10-13 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '376', '2', '15', 'Zubia', '2017-12-07 00:00:00', '2017-12-07 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '377', '2', '4', 'Sortzez Garbiaren eguna', '2017-12-08 00:00:00', '2017-12-08 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '378', '2', '4', 'Ostiral Santua', '2017-04-14 00:00:00', '2017-04-14 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '379', '2', '4', 'Santiago Apostolua', '2017-07-25 00:00:00', '2017-07-25 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '380', '2', '4', 'San Ignazio Loiolakoaren eguna', '2017-07-31 00:00:00', '2017-07-31 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '381', '2', '4', 'Langileen Eguna', '2017-05-01 00:00:00', '2017-05-01 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '382', '2', '4', 'Andra Mari eguna', '2017-08-15 00:00:00', '2017-08-15 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '383', '2', '4', 'Espainiako Jai Nazionala', '2017-10-12 00:00:00', '2017-10-12 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '384', '2', '4', 'Konstituzio eguna', '2017-12-06 00:00:00', '2017-12-06 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '385', '2', '4', 'Domu Santu eguna', '2017-11-01 00:00:00', '2017-11-01 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '386', '2', '4', 'Eguberri eguna', '2017-12-25 00:00:00', '2017-12-25 00:00:00', '2017-05-05 11:10:12', '2017-05-05 11:10:12' ),
( '442', '4', '4', 'URTEBERRI EGUNA', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '2018-02-02 12:53:42', '2018-02-02 12:53:42' ),
( '443', '4', '4', 'OSTEGUN SANTUA', '2018-03-29 00:00:00', '2018-03-29 00:00:00', '2018-02-02 12:53:43', '2018-02-02 12:53:43' ),
( '444', '4', '4', 'OSTIRAL SANTUA', '2018-03-30 00:00:00', '2018-03-30 00:00:00', '2018-02-02 12:53:43', '2018-02-02 12:53:43' ),
( '445', '4', '4', 'PAZKO ASTELEHENA', '2018-04-02 00:00:00', '2018-04-02 00:00:00', '2018-02-02 12:53:43', '2018-02-02 12:53:43' ),
( '446', '4', '15', 'ZUBIA', '2018-04-30 00:00:00', '2018-04-30 00:00:00', '2018-02-02 12:53:43', '2018-02-02 12:53:43' ),
( '447', '4', '4', 'LANAREN JAIA', '2018-05-01 00:00:00', '2018-05-01 00:00:00', '2018-02-02 12:53:43', '2018-02-02 12:53:43' ),
( '448', '4', '4', 'S.JUAN BIHARAMUNA', '2018-06-25 00:00:00', '2018-06-25 00:00:00', '2018-02-02 12:53:43', '2018-02-02 12:53:43' ),
( '449', '4', '4', 'LOIOLAKO SAN INAZIO EGUNA', '2018-07-31 00:00:00', '2018-07-31 00:00:00', '2018-02-02 12:53:43', '2018-02-02 12:53:43' ),
( '450', '4', '15', 'ZUBIA', '2018-07-30 00:00:00', '2018-07-30 00:00:00', '2018-02-02 12:53:43', '2018-02-02 12:53:43' ),
( '451', '4', '4', 'BIRJINAREN JASOKUNDEA', '2018-08-15 00:00:00', '2018-08-15 00:00:00', '2018-02-02 12:53:43', '2018-02-02 12:53:43' ),
( '452', '4', '4', 'JAI NAZIONALA', '2018-10-12 00:00:00', '2018-10-12 00:00:00', '2018-02-02 12:53:43', '2018-02-02 12:53:43' ),
( '453', '4', '4', 'DOMUSANTU EGUNA', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-02-02 12:53:44', '2018-02-02 12:53:44' ),
( '454', '4', '15', 'ZUBIA', '2018-11-02 00:00:00', '2018-11-02 00:00:00', '2018-02-02 12:53:44', '2018-02-02 12:53:44' ),
( '455', '4', '4', 'KONSTITUZIOAREN EGUNA', '2018-12-06 00:00:00', '2018-12-06 00:00:00', '2018-02-02 12:53:44', '2018-02-02 12:53:44' ),
( '456', '4', '15', 'ZUBIA', '2018-12-07 00:00:00', '2018-12-07 00:00:00', '2018-02-02 12:53:44', '2018-02-02 12:53:44' ),
( '457', '4', '4', 'EGUBERRI EGUNA', '2018-12-25 00:00:00', '2018-12-25 00:00:00', '2018-02-02 12:53:44', '2018-02-02 12:53:44' ),
( '458', '4', '15', 'ZUBIA', '2018-12-24 00:00:00', '2018-12-24 00:00:00', '2018-02-02 12:53:44', '2018-02-02 12:53:44' ),
( '459', '4', '15', 'ZUBIA', '2018-12-31 00:00:00', '2018-12-31 00:00:00', '2018-02-02 12:53:44', '2018-02-02 12:53:44' ),
( '460', '5', '4', 'JAI EGUNA', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '2018-03-12 15:05:51', '2018-03-12 15:05:51' ),
( '461', '5', '4', 'JAI EGUNA', '2018-01-06 00:00:00', '2018-01-06 00:00:00', '2018-03-12 15:05:51', '2018-03-12 15:05:51' ),
( '462', '5', '4', 'JAI EGUNA', '2018-03-29 00:00:00', '2018-03-30 00:00:00', '2018-03-12 15:05:52', '2018-03-12 15:05:52' ),
( '463', '5', '4', 'JAI EGUNA', '2018-04-02 00:00:00', '2018-04-02 00:00:00', '2018-03-12 15:05:52', '2018-03-12 15:05:52' ),
( '464', '5', '15', 'ZUBIA', '2018-04-30 00:00:00', '2018-04-30 00:00:00', '2018-03-12 15:05:52', '2018-03-12 15:05:52' ),
( '465', '5', '15', 'JAI EGUNA', '2018-05-01 00:00:00', '2018-05-01 00:00:00', '2018-03-12 15:05:52', '2018-03-12 15:05:52' ),
( '466', '5', '15', 'JAI EGUNA', '2018-06-25 00:00:00', '2018-06-25 00:00:00', '2018-03-12 15:05:52', '2018-03-12 15:05:52' ),
( '467', '5', '15', 'ZUBIA', '2018-07-30 00:00:00', '2018-07-30 00:00:00', '2018-03-12 15:05:52', '2018-03-12 15:05:52' ),
( '468', '5', '4', 'JAI EGUNA', '2018-07-31 00:00:00', '2018-07-31 00:00:00', '2018-03-12 15:05:52', '2018-03-12 15:05:52' ),
( '469', '5', '4', 'JAI EGUNA', '2018-08-15 00:00:00', '2018-08-15 00:00:00', '2018-03-12 15:05:52', '2018-03-12 15:05:52' ),
( '470', '5', '4', 'JAI EGUNA', '2018-10-12 00:00:00', '2018-10-12 00:00:00', '2018-03-12 15:05:52', '2018-03-12 15:05:52' ),
( '471', '5', '4', 'JAI EGUNA', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-03-12 15:05:52', '2018-03-12 15:05:52' ),
( '472', '5', '15', 'ZUBIA', '2018-11-02 00:00:00', '2018-11-02 00:00:00', '2018-03-12 15:05:53', '2018-03-12 15:05:53' ),
( '473', '5', '4', 'JAI EGUNA', '2018-12-06 00:00:00', '2018-12-06 00:00:00', '2018-03-12 15:05:53', '2018-03-12 15:05:53' ),
( '474', '5', '15', 'ZUBIA', '2018-12-07 00:00:00', '2018-12-07 00:00:00', '2018-03-12 15:05:53', '2018-03-12 15:05:53' ),
( '475', '5', '15', 'ZUBIA', '2018-12-24 00:00:00', '2018-12-24 00:00:00', '2018-03-12 15:05:53', '2018-03-12 15:05:53' ),
( '476', '5', '4', 'JAI EGUNA', '2018-12-25 00:00:00', '2018-12-25 00:00:00', '2018-03-12 15:05:53', '2018-03-12 15:05:53' ),
( '477', '5', '15', 'ZUBIA', '2018-12-31 00:00:00', '2018-12-31 00:00:00', '2018-03-12 15:05:53', '2018-03-12 15:05:53' ),
( '478', '5', '4', 'JAI EGUNA', '2019-01-01 00:00:00', '2019-01-01 00:00:00', '2018-03-12 15:05:53', '2018-03-12 15:05:53' ),
( '479', '5', '4', 'JAI EGUNA', '2019-01-06 00:00:00', '2019-01-06 00:00:00', '2018-03-12 15:05:53', '2018-03-12 15:05:53' ),
( '499', '3', '4', 'S. JUAN BIHARAMUNA', '2018-06-25 00:00:00', '2018-06-25 00:00:00', '2018-10-01 12:18:15', '2018-10-01 12:18:15' ),
( '500', '3', '4', 'URTEBERRI EGUNA', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '2018-10-01 12:18:15', '2018-10-01 12:18:15' ),
( '501', '3', '4', 'OSTEGUN SANTUA', '2018-03-29 00:00:00', '2018-03-29 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '502', '3', '4', 'OSTIRAL SANTUA', '2018-03-30 00:00:00', '2018-03-30 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '503', '3', '4', 'PAZKO ASTELEHENA', '2018-04-02 00:00:00', '2018-04-02 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '504', '3', '4', 'LANAREN JAIA', '2018-05-01 00:00:00', '2018-05-01 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '505', '3', '15', 'ZUBIA', '2018-04-30 00:00:00', '2018-04-30 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '506', '3', '4', 'BIRJINAREN JASOKUNDEA', '2018-08-15 00:00:00', '2018-08-15 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '507', '3', '4', 'DOMUSANTU EGUNA', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '508', '3', '15', 'ZUBIA', '2018-11-02 00:00:00', '2018-11-02 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '509', '3', '4', 'KONSTITUZIOAREN EGUNA', '2018-12-06 00:00:00', '2018-12-06 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '510', '3', '4', 'EGUBERRI EGUNA', '2018-12-25 00:00:00', '2018-12-25 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '511', '3', '15', 'ZUBIA', '2018-12-07 00:00:00', '2018-12-07 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '512', '3', '15', 'ZUBIA', '2018-12-24 00:00:00', '2018-12-24 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '513', '3', '15', 'ZUBIA', '2018-12-31 00:00:00', '2018-12-31 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '514', '3', '4', 'URTEBERRI EGUNA', '2019-01-01 00:00:00', '2019-01-01 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '515', '3', '4', 'LOIOLAKO SAN INAZIO EGUNA', '2018-07-31 00:00:00', '2018-07-31 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '516', '3', '15', 'ZUBIA', '2018-07-30 00:00:00', '2018-07-30 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '517', '3', '4', 'ESPAINIAKO JAI NAZIONALA', '2018-10-12 00:00:00', '2018-10-12 00:00:00', '2018-10-01 12:18:16', '2018-10-01 12:18:16' ),
( '707', '7', '4', 'Ostegun Santua', '2019-04-18 00:00:00', '2019-04-18 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '708', '7', '4', 'Ostiral Santua', '2019-04-19 00:00:00', '2019-04-19 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '709', '7', '4', 'Pazko Astelehena', '2019-04-22 00:00:00', '2019-04-22 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '710', '7', '4', 'Langileen Eguna', '2019-05-01 00:00:00', '2019-05-01 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '711', '7', '4', 'Santiago Apostolua', '2019-07-25 00:00:00', '2019-07-25 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '712', '7', '4', 'Andra Mari eguna', '2019-08-15 00:00:00', '2019-08-15 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '713', '7', '4', 'Espainiako jai nazionala', '2019-10-12 00:00:00', '2019-10-12 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '714', '7', '4', 'Domu Santu eguna', '2019-11-01 00:00:00', '2019-11-01 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '715', '7', '4', 'Konstituzio eguna', '2019-12-06 00:00:00', '2019-12-06 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '716', '7', '4', 'Eguberri eguna', '2019-12-25 00:00:00', '2019-12-25 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '717', '7', '15', 'ZUBIA', '2019-07-26 00:00:00', '2019-07-26 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '718', '7', '15', 'ZUBIA', '2019-03-18 00:00:00', '2019-03-18 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '719', '7', '15', 'ZUBIA', '2019-08-16 00:00:00', '2019-08-16 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '720', '7', '4', 'Loiolako San Inazio eguna', '2019-07-31 00:00:00', '2019-07-31 00:00:00', '2019-06-10 13:18:42', '2019-06-10 13:18:42' ),
( '721', '7', '4', 'San Juan eguna', '2019-06-24 00:00:00', '2019-06-24 00:00:00', '2019-06-10 13:18:43', '2019-06-10 13:18:43' ),
( '722', '7', '4', 'Urteberri eguna', '2019-01-01 00:00:00', '2019-01-01 00:00:00', '2019-06-10 13:18:43', '2019-06-10 13:18:43' ),
( '723', '7', '4', 'Urteberri eguna', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '2019-06-10 13:18:43', '2019-06-10 13:18:43' ),
( '724', '7', '4', 'San Jose Eguna', '2019-03-19 00:00:00', '2019-03-19 00:00:00', '2019-06-10 13:18:43', '2019-06-10 13:18:43' );
-- ---------------------------------------------------------


-- Dump data of "type" -------------------------------------
INSERT INTO `type`(`id`,`name`,`slug`,`hours`,`color`,`created`,`updated`,`orden`,`erakutsi`,`related`,`erakutsi_eskaera`,`description`,`lizentziamotabehar`) VALUES 
( '4', 'Jai eguna', 'jai-eguna', '0.00', '#e01b1b', '2017-04-21 05:58:14', '2017-05-11 09:51:49', '11', '1', NULL, NULL, NULL, NULL ),
( '5', 'Norberaren arazoetarako egunak', 'norberaren-arazoetarako-egunak', '0.00', '#41a8f5', '2017-04-21 05:58:14', '2018-10-18 09:06:14', '3', '1', 'hours_self', '1', 'Langileak urtean norberaren gauzetarako hartzeko dituen egunetatik, Udalhitzek dioen bezala, bi egun zatitzeko aukera izango du funtzionarioak, baina zati horiek gutxienez bi ordukoak eta gehienez egun erdikoak izan beharko dute (60.2. artikulua).', NULL ),
( '6', 'Konpentsatuak', 'konpentsatuak', '0.00', '#e01bd8', '2017-04-21 05:58:14', '2017-05-24 08:54:14', '4', '1', 'hours_compensed', '1', NULL, NULL ),
( '7', 'Ordu Sindikalak', 'ordu-sindikalak', '0.00', 'rgba(149,27,224,0.94)', '2017-04-28 09:46:48', '2019-07-05 14:14:50', '6', '1', 'hours_sindical', '1', NULL, '0' ),
( '8', 'Lizentziak', 'lizentziak', '0.00', '#70ed52', '2017-04-28 09:47:39', '2019-06-04 07:55:08', '5', '1', NULL, '1', '<p><u><strong>BETI JUSTIFIKATUAK IZAN BEHARKO DIRA</strong></u>. Mediku kontsultak, familiarteko baten ospitaleratzea, ezkontzea edo izatezko bikotea sortzea, zentro ofizialetako azken azterketetara joatea, ohiko etxebizitza aldatzea, izaera publiko eta pertsonaleko nahitaezko betebeharrak.</p>', '1' ),
( '9', 'Amatasuna/Aitatasuna', 'amatasuna-aitatasuna', '0.00', '#998b8b', '2017-04-28 10:07:00', '2017-05-05 07:31:56', '8', '1', NULL, NULL, NULL, NULL ),
( '10', 'Soldata gabeko baimena', 'soldata-gabeko-baimena', '0.00', '#382b32', '2017-04-28 10:07:48', '2018-03-19 14:03:34', '9', '1', NULL, '0', NULL, NULL ),
( '11', 'Eszedentzia', 'eszedentzia', '0.00', '#66627a', '2017-04-28 10:08:56', '2017-05-05 07:32:08', '10', '1', NULL, NULL, NULL, NULL ),
( '12', 'Aurreko urteko opor egunak', 'aurreko-urteko-opor-egunak', '0.00', '#ebe795', '2017-04-28 10:10:32', '2017-05-12 07:52:18', '2', '1', 'hours_free', NULL, NULL, NULL ),
( '13', 'Oporrak', 'oporrak', '0.00', 'rgba(242,234,72,0.93)', '2017-04-28 10:12:23', '2019-01-07 09:55:22', '1', '1', 'hours_free', '1', NULL, NULL ),
( '14', 'Gaixotasun / Lan istripu BAJA', 'gaixotasun-lan-istripu-baja', '0.00', '#e89029', '2017-04-28 10:18:48', '2017-05-05 07:32:19', '7', '1', NULL, NULL, NULL, NULL ),
( '15', 'Zubia', 'zubia', '0.00', '#e01b1b', '2017-04-28 10:24:08', '2017-05-05 07:32:51', '12', '1', NULL, NULL, NULL, NULL ),
( '16', 'konpentsatuak OLH', 'konpentsatuak-olh', '0.00', '#e675d9', '2017-05-12 08:19:14', '2017-05-25 05:48:09', '13', '1', NULL, '0', NULL, NULL ),
( '17', 'Greba', 'greba', '0.00', '#b76bc4', '2018-03-19 14:04:25', '2018-03-19 14:33:27', '14', '1', NULL, '0', NULL, NULL );
-- ---------------------------------------------------------


-- Dump data of "user" -------------------------------------
INSERT INTO `user`(`id`,`username`,`username_canonical`,`email`,`email_canonical`,`enabled`,`salt`,`password`,`last_login`,`confirmation_token`,`password_requested_at`,`roles`,`dn`,`department`,`displayname`,`nan`,`lanpostua`,`members`,`notes`,`hizkuntza`,`sailburuada`,`ldapsaila`) VALUES 
( '2', 'iibarguren', 'iibarguren', 'iibarguren@pasaia.net', 'iibarguren@pasaia.net', '1', NULL, '', '2019-08-27 12:46:02', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SUPER_ADMIN";i:1;s:10:"ROLE_ADMIN";}', 'CN=iibarguren,CN=Users,DC=pasaia,DC=net', NULL, 'Iker Ibarguren Berasaluze', '72470919N', 'Informatikako Errefortzua', '["CN=Domain Admins,CN=Users,DC=pasaia,DC=net","CN=APP-Web_infoGerkud,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_Informatika,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Egutegia,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-bidali,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Informatika,CN=Users,DC=pasaia,DC=net","CN=Sarbide-VPN,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Hiri-Garapena,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Office,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Zertegi-Kudeatzailea,CN=Users,DC=pasaia,DC=net","CN=ROL-Alkatetza_Alkatea,CN=Users,DC=pasaia,DC=net"]', '*** Gorka Gonzalez', 'EU', '0', NULL ),
( '3', 'ggonzalez', 'ggonzalez', 'ggonzalez@pasaia.net', 'ggonzalez@pasaia.net', '1', NULL, '', '2019-08-27 07:33:18', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SUPER_ADMIN";i:1;s:16:"ROLE_SINATZAILEA";}', 'CN=ggonzalez,CN=Users,DC=pasaia,DC=net', 'Informatika', 'Gorka Gonzalez Etxepare', '44554932E', 'Informatikako teknikaria', '["CN=Domain Admins,CN=Users,DC=pasaia,DC=net","CN=APP-Web_infoGerkud,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Jakinarazpenak,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_Informatika,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-bidali,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Informatika,CN=Users,DC=pasaia,DC=net","CN=Sarbide-VPN,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-kutxa,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Hiri-Garapena,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Ogasuna,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_GANES,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-TV_Donibane-Liburutegia,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Iberdrola,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Office,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-TV_Jberasategi,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Zertegi-Kontsulta,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Zertegi-Kudeatzailea,CN=Users,DC=pasaia,DC=net"]', '*** Iker Ibarguren', 'EU', '0', NULL ),
( '4', 'rgonzalez', 'rgonzalez', 'rgonzalez@pasaia.net', 'rgonzalez@pasaia.net', '1', NULL, '', '2019-08-27 10:12:47', NULL, NULL, 'a:3:{i:0;s:10:"ROLE_ADMIN";i:1;s:18:"ROLE_BIDERATZAILEA";i:2;s:16:"ROLE_SINATZAILEA";}', 'CN=rgonzalez,CN=Users,DC=pasaia,DC=net', 'Pertsonala', 'Ruth Gonzalez Antolin', '44152950B', 'Antolaketa eta GGBB administraria', '["CN=APP-Web_Egutegia,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_GGBB-Administraria,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Guacamole-Nomina,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Egutegia-Bideratzaile,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_HAZ-SAC,CN=Users,DC=pasaia,DC=net"]', '*** Amaia Oiarbide', 'EU', '0', NULL ),
( '5', 'iaramendi', 'iaramendi', 'iaramendi@pasaia.net', 'iaramendi@pasaia.net', '1', NULL, '', '2019-08-27 10:11:06', NULL, NULL, 'a:0:{}', 'CN=iaramendi,CN=Users,DC=pasaia,DC=net', NULL, 'Inaki Aramendi Lizarralde', '44560730', 'Espediente Kudeaketarako Teknikaria', '["CN=APP-Web_infoGerkud,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Informatika,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_Espedienteak,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Office,CN=Users,DC=pasaia,DC=net"]', 'Informatika', 'EU', '0', NULL ),
( '6', 'rafel', 'rafel', 'rafel@pasaia.net', 'rafel@pasaia.net', '1', NULL, '', '2019-08-19 10:22:00', NULL, NULL, 'a:3:{i:0;s:16:"ROLE_SUPER_ADMIN";i:1;s:10:"ROLE_ADMIN";i:2;s:16:"ROLE_SINATZAILEA";}', 'CN=rafel,CN=Users,DC=pasaia,DC=net', NULL, 'Rafel Puy Agirre', '15963796W', 'Informatikako arduraduna eta Antolakuntzako teknikaria', '["CN=Domain Admins,CN=Users,DC=pasaia,DC=net","CN=APP-Web_infoGerkud,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_Informatika,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Egutegia,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-bidali,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Informatika,CN=Users,DC=pasaia,DC=net","CN=Sarbide-VPN,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-kutxa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Ondare-Kontratazio-ZZ-Juridikoak_Idatzi,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Hiri-Garapena,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Ogasuna,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Zuzendaritza_Taldea,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Office,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Zertegi-Kontsulta,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Zertegi-Kudeatzailea,CN=Users,DC=pasaia,DC=net"]', NULL, 'ES', '0', NULL ),
( '7', 'ainsausti', 'ainsausti', 'ainsausti@pasaia.net', 'ainsausti@pasaia.net', '1', NULL, '', '2018-04-11 13:34:33', NULL, NULL, 'a:2:{i:0;s:10:"ROLE_ADMIN";i:1;s:16:"ROLE_SINATZAILEA";}', 'CN=ainsausti,CN=Users,DC=pasaia,DC=net', 'Pertsonala', 'Ainhoa Insausti Echeverria', '44335285W', 'Antolaketa eta GGBB teknikaria', '["CN=ROL-Antolakuntza_GGBB-Arduraduna,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Guacamole-Nomina,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Segurtasun-Osasuna_Irakurri,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Egutegia,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Larrialdi-Plana,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net"]', '', 'EU', '0', NULL ),
( '8', 'Olatz', 'olatz', 'Olatz@pasaia.net', 'olatz@pasaia.net', '1', NULL, '', '2019-08-26 12:51:57', NULL, NULL, 'a:0:{}', 'CN=Olatz,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Olatz Alberro Bilbao', '72432899B', 'Trintxerpeko Liburuzaina', '["CN=ROL-Sustapena_Liburuzaina,CN=Users,DC=pasaia,DC=net"]', 'Liburuzaina', 'EU', '0', NULL ),
( '9', 'Nieves', 'nieves', 'Nieves@pasaia.net', 'nieves@pasaia.net', '1', NULL, '', '2019-07-22 12:48:10', NULL, NULL, 'a:0:{}', 'CN=Nieves,CN=Users,DC=pasaia,DC=net', 'CIP', 'Nieves Alegria Asenjo', '15960187G', 'OLH-ko arduraduna', '["CN=ROL-OLH_Bulegoa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '10', 'acuadrado', 'acuadrado', 'acuadrado@pasaia.net', 'acuadrado@pasaia.net', '1', NULL, '', '2019-07-23 09:22:23', NULL, NULL, 'a:0:{}', 'CN=acuadrado,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Antton Cuadrado Iraola', '72498137K', 'Irakaslea, hizkuntza-normalizazioko teknikaria', '["CN=ROL-Sustapena_Itzultzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Itzultzaileak,CN=Users,DC=pasaia,DC=net"]', 'Euskera', 'EU', '0', NULL ),
( '11', 'azinkunegi', 'azinkunegi', 'azinkunegi@pasaia.net', 'azinkunegi@pasaia.net', '1', NULL, '', '2019-06-17 10:49:31', NULL, NULL, 'a:0:{}', 'CN=azinkunegi,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Aitziber Zinkunegi Arrillaga', '44163558Q', 'Liburuzain-koordinatzailea', '["CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=ROL-Sustapena_Liburutegi-Arduraduna,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-TV_Donibane-Liburutegia,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-TV_Trintxerpe-Liburutegia,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-TV_Antxo-Liburutegia,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-TV_Sanpedro-Liburutegia,CN=Users,DC=pasaia,DC=net"]', 'Liburuzaina', 'EU', '0', NULL ),
( '12', 'Beatriz', 'beatriz', 'Beatriz@pasaia.net', 'beatriz@pasaia.net', '1', NULL, '', '2019-06-21 09:16:53', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SINATZAILEA";i:1;s:14:"ROLE_SAILBURUA";}', 'CN=Beatriz,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Beatriz Caballero Alonso', '15987110V', 'Kultura eta Hezkuntzako teknikaria', '["CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=ROL-Sustapena_Kultura,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', 'Kultura', 'EU', '1', 'Sustapena' ),
( '13', 'Berta', 'berta', 'Berta@pasaia.net', 'berta@pasaia.net', '1', NULL, '', '2019-08-13 12:33:49', NULL, NULL, 'a:0:{}', 'CN=Berta,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Berta Zumalde Goitia', '72571052A', 'Irakaslea, hizkuntza-normalizazioko teknikaria', '["CN=ROL-Sustapena_Itzultzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Itzultzaileak,CN=Users,DC=pasaia,DC=net"]', 'Euskera', 'EU', '0', NULL ),
( '14', 'aeguskiza', 'aeguskiza', 'aeguskiza@pasaia.net', 'aeguskiza@pasaia.net', '1', NULL, '', '2019-08-09 09:37:57', NULL, NULL, 'a:1:{i:0;s:14:"ROLE_SAILBURUA";}', 'CN=aeguskiza,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Aitziber Eguskiza Samos', '78884737G', 'Kultura eta Hezkuntzako teknikaria', '["CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=ROL-Haur-Nerabe_Haur-Nerabe-Teknikaria,CN=Users,DC=pasaia,DC=net","CN=ROL-Sustapena_Kultura,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', 'kultura', 'EU', '1', 'Haur' ),
( '15', 'Cristina', 'cristina', 'Cristina@pasaia.net', 'cristina@pasaia.net', '1', NULL, '', '2019-07-22 14:09:53', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SINATZAILEA";i:1;s:14:"ROLE_SAILBURUA";}', 'CN=Cristina,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Cristina Vazquez Lacalle', '15960423X', 'Gazteriako teknikaria', '["CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=ROL-Sustapena_Gazteria,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net"]', 'Gazteria', 'EU', '1', 'Sustapena' ),
( '16', 'eastiasaran', 'eastiasaran', 'eastiasaran@pasaia.net', 'eastiasaran@pasaia.net', '1', NULL, '', '2018-07-13 12:57:53', NULL, NULL, 'a:0:{}', 'CN=eastiasaran,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Elisabete Astiasaran De Miguel', '44158311J', NULL, '["CN=ROL-Haur-Nerabe_Haur-Nerabe-Teknikaria,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net"]', 'Haur eta nerabeak', 'EU', '0', NULL ),
( '17', 'igoitia', 'igoitia', 'igoitia@pasaia.net', 'igoitia@pasaia.net', '1', NULL, '', '2018-10-22 17:13:17', NULL, NULL, 'a:0:{}', 'CN=igoitia,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Inaki Goitia Lucas', '44171507F', 'Antxoko Liburuzaina', '["CN=ROL-Sustapena_Liburuzaina,CN=Users,DC=pasaia,DC=net"]', 'Liburuzaina', 'EU', '0', NULL ),
( '18', 'isaavedra', 'isaavedra', 'isaavedra@pasaia.net', 'isaavedra@pasaia.net', '1', NULL, '', '2019-07-25 10:34:55', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SINATZAILEA";i:1;s:14:"ROLE_SAILBURUA";}', 'CN=isaavedra,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Ibai Saavedra Alonso', '44154050F', 'Kirol teknikaria', '["CN=ROL-Sustapena_Kirolak,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_SALTO,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net"]', 'Kirola', 'EU', '1', 'Sustapena' ),
( '19', 'Jaione', 'jaione', 'Jaione@pasaia.net', 'jaione@pasaia.net', '1', NULL, '', '2019-08-21 14:50:06', NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SINATZAILEA";}', 'CN=Jaione,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Jaione Urruzola Arizeta', '15979616K', 'Euskara teknikaria', '["CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=ROL-Sustapena_Euskara,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Zuzendaritza_Taldea,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', 'Euskera', 'EU', '0', NULL ),
( '20', 'lburlada', 'lburlada', 'lburlada@pasaia.net', 'lburlada@pasaia.net', '1', NULL, '', '2019-07-29 10:58:16', NULL, NULL, 'a:0:{}', 'CN=lburlada,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Larraitz Burlada Diez', '72460428D', 'San Pedroko Liburuzaina', '["CN=ROL-Sustapena_Liburuzaina,CN=Users,DC=pasaia,DC=net"]', 'Liburuzaina', 'EU', '0', NULL ),
( '21', 'manzuela', 'manzuela', 'manzuela@pasaia.net', 'manzuela@pasaia.net', '1', NULL, '', '2019-06-06 19:36:45', NULL, NULL, 'a:0:{}', 'CN=manzuela,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Marga Anzuela Martinez', '44132185S', 'Donibaneko Liburuzaina', '["CN=ROL-Sustapena_Liburuzaina,CN=Users,DC=pasaia,DC=net"]', 'Liburuzaina', 'EU', '0', NULL ),
( '22', 'Martxel', 'martxel', 'Martxel@pasaia.net', 'martxel@pasaia.net', '1', NULL, '', '2019-07-22 11:24:22', NULL, NULL, 'a:0:{}', 'CN=Martxel,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Martxel Saizar Sarasua', '15970892Z', 'Administrazioa eta izapideak', '["CN=APP-Web_Guacamole-HAZ,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=ROL-Sustapena_Administrazioa,CN=Users,DC=pasaia,DC=net"]', 'Kultura, Euskera, Gazteria, Kirola', 'EU', '0', NULL ),
( '23', 'Ortzuri', 'ortzuri', 'Ortzuri@pasaia.net', 'ortzuri@pasaia.net', '1', NULL, '', '2019-07-24 11:55:54', NULL, NULL, 'a:0:{}', 'CN=Ortzuri,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Ortzuri Olaetxea Rodriguez', '35775019Z', 'Itzultzailea, hizkuntz-normalizatzailea', '["CN=ROL-Sustapena_Itzultzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Itzultzaileak,CN=Users,DC=pasaia,DC=net"]', 'Euskera', 'EU', '0', NULL ),
( '24', 'mesonero', 'mesonero', 'mesonero@pasaia.net', 'mesonero@pasaia.net', '1', NULL, '', '2019-08-26 12:33:39', NULL, NULL, 'a:0:{}', 'CN=mesonero,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', 'Juan Antonio Mesonero Dosuna', '15245374P', 'Herritarren arreta (orokorra)', '["CN=ROL-Antolakuntza_HAZ-SAC,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=Taldea-Sindikatuak_ELA,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Intranet_Erregistroa_Idatzi,CN=Users,DC=pasaia,DC=net"]', '*** HAZ-SAC', 'EU', '0', NULL ),
( '25', 'Iugarte', 'iugarte', 'Iugarte@pasaia.net', 'iugarte@pasaia.net', '1', NULL, '', '2019-08-26 12:32:05', NULL, NULL, 'a:0:{}', 'CN=Iugarte,CN=Users,DC=pasaia,DC=net', 'Hirigintza', 'Izaskun Ugartemendia Gorriti', '15995470M', 'Herritarren arreta (orokorra)', '["CN=SARBIDE-Intranet_Erregistroa_Idatzi,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_HAZ-SAC,CN=Users,DC=pasaia,DC=net"]', '*** HAZ-SAC', 'EU', '0', NULL ),
( '26', 'Olmedo', 'olmedo', 'Olmedo@pasaia.net', 'olmedo@pasaia.net', '1', NULL, '', '2019-07-23 08:14:17', NULL, NULL, 'a:0:{}', 'CN=Olmedo,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', 'Karmele Olmedo Cortijo', '34082343T', 'Herritarren arreta (orokorra)', '["CN=SARBIDE-Intranet_Erregistroa_Idatzi,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_HAZ-SAC,CN=Users,DC=pasaia,DC=net"]', '*** HAZ-SAC', 'EU', '0', NULL ),
( '27', 'ielorza', 'ielorza', 'ielorza@pasaia.net', 'ielorza@pasaia.net', '1', NULL, '', '2018-04-16 12:34:16', NULL, NULL, 'a:0:{}', 'CN=ielorza,CN=Users,DC=pasaia,DC=net', 'Zerbitzuak', 'Itziar Elorza Zorrozua', '72463540Q', 'Administrazioa eta jendaurreko zerbitzua - Ate-zate programa', '["CN=APP-Web_Guacamole-HAZ,CN=Users,DC=pasaia,DC=net","CN=ROL-Hirigintza_Legalaria,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Udalbatza_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Hirigintza_Idatzi,CN=Users,DC=pasaia,DC=net"]', '', 'EU', '0', NULL ),
( '28', 'garrambide', 'garrambide', 'garrambide@pasaia.net', 'garrambide@pasaia.net', '1', NULL, '', '2019-08-26 09:54:50', NULL, NULL, 'a:0:{}', 'CN=garrambide,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Garbine Arrambide Oronoz', '15257498B', 'Diru-bilketa. Administrazioa eta izapideak', '["CN=SARBIDE-Intranet_Erregistroa_Idatzi,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_HAZ-SAC,CN=Users,DC=pasaia,DC=net","CN=ROL-Ogasuna_Diru-bilketa_Administrazioa,CN=Users,DC=pasaia,DC=net"]', '*** HAZ-SAC', 'EU', '0', NULL ),
( '29', 'mizeta', 'mizeta', 'mizeta@pasaia.net', 'mizeta@pasaia.net', '1', NULL, '', '2019-08-14 08:49:36', NULL, NULL, 'a:0:{}', 'CN=mizeta,CN=Users,DC=pasaia,DC=net', 'Hirigintza', 'Maria Izeta Etxabe', '72454691E', 'Arkitektoa', '["CN=ROL-Hirigintza_Arkitektoa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Topografia,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Hiri-Garapena,CN=Users,DC=pasaia,DC=net"]', '*** Iñaki Ormazabal', 'EU', '0', NULL ),
( '30', 'ormazabal', 'ormazabal', 'ormazabal@pasaia.net', 'ormazabal@pasaia.net', '1', NULL, '', '2019-08-22 09:52:04', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SINATZAILEA";i:1;s:14:"ROLE_SAILBURUA";}', 'CN=ormazabal,CN=Users,DC=pasaia,DC=net', 'Hirigintza', 'Inaki Ormazabal Azkoitia', '15910269L', 'Hirigintza eta Ingurumen arloko arduraduna', '["CN=ROL-Hirigintza_Arduraduna,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Hiri-Garapena,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Larrialdi-Plana,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Zuzendaritza_Taldea,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Topografia,CN=Users,DC=pasaia,DC=net"]', '*** Maria Izeta', 'EU', '1', 'Hirigintza' ),
( '31', 'elopetegi', 'elopetegi', 'elopetegi@pasaia.net', 'elopetegi@pasaia.net', '1', NULL, '', '2019-08-07 12:17:46', NULL, NULL, 'a:1:{i:0;s:14:"ROLE_SAILBURUA";}', 'CN=elopetegi,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Erika Lopetegi Suarez', '72460251Q', 'Diruzaina', '["CN=APP-Ulteo_Access,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-kutxa,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Ogasuna,CN=Users,DC=pasaia,DC=net","CN=ROL-Ogasuna_Diruzaina,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', '*** Itziar Miner', 'EU', '1', 'Ogasuna' ),
( '32', 'iminer', 'iminer', 'iminer@pasaia.net', 'iminer@pasaia.net', '1', NULL, '', '2019-07-24 10:37:04', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SINATZAILEA";i:1;s:14:"ROLE_SAILBURUA";}', 'CN=iminer,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Itziar Miner Canflanca', '44145251V', 'Kontu-hartzailea', '["CN=ROL-Ogasuna_Kontu-Hartzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-kutxa,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Zuzendaritza_Taldea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Ogasuna_Idatzi,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net"]', '*** Erika Lopetegi', 'EU', '1', 'Ogasuna' ),
( '33', 'urekondo', 'urekondo', 'urekondo@pasaia.net', 'urekondo@pasaia.net', '1', NULL, '', '2019-07-24 10:36:35', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SINATZAILEA";i:1;s:14:"ROLE_SAILBURUA";}', 'CN=urekondo,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', 'Unai Rekondo Perez', '72490342T', 'Udal idazkaria', '["CN=ROL-Idazkaritza_Idazkaria,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Zuzendaritza_Taldea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Tokiko-Gobernua_Idatzi,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Udalbatza_Idatzi,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Udalbatza_Irakurri,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Tokiko-Gobernua_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Intranet_Erregistroa_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Ondare-Kontratazio-ZZ-Juridikoak_Idatzi,CN=Users,DC=pasaia,DC=net"]', '*** Xabier Etxaniz', 'EU', '1', 'Idazkaritza' ),
( '34', 'xetxaniz', 'xetxaniz', 'xetxaniz@pasaia.net', 'xetxaniz@pasaia.net', '1', NULL, '', '2017-10-09 11:45:29', NULL, NULL, 'a:0:{}', 'CN=xetxaniz,CN=Users,DC=pasaia,DC=net', 'Hirigintza', 'Xabier Etxaniz Moreno', '22737520L', 'Hirigintza arloko teknikaria', '["CN=Hirigintza,CN=Users,DC=pasaia,DC=net","CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net","CN=ROL-Hirigintza_Legalaria,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Guacamole-HAZ,CN=Users,DC=pasaia,DC=net"]', '*** Unai Rekondo', NULL, '0', NULL ),
( '35', 'jmarroniz', 'jmarroniz', 'jmarroniz@pasaia.net', 'jmarroniz@pasaia.net', '1', NULL, '', '2019-08-01 11:12:48', NULL, NULL, 'a:0:{}', 'CN=jmarroniz,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Jose Mari Arroniz Villa', '34101352B', 'Jakinarazlea', '["CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Jakinarazpenak,CN=Users,DC=pasaia,DC=net","CN=ROL-Ogasuna_Diru-bilketa_Jakinarazlea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Intranet_Langileen-ordezkaritza_idatzi,CN=Users,DC=pasaia,DC=net","CN=Taldea-Sindikatuak_LAB,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_GANES,CN=Users,DC=pasaia,DC=net"]', 'LAB', 'EU', '0', NULL ),
( '36', 'Imanol', 'imanol', 'Imanol@pasaia.net', 'imanol@pasaia.net', '1', NULL, '', '2017-09-28 08:22:51', NULL, NULL, 'a:0:{}', 'CN=Imanol,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', 'Imanol Esnaola Eskisabel', '15940959G', 'Udaltzaina', '["CN=Udaltzaingoa,CN=Users,DC=pasaia,DC=net","CN=BIC,CN=Users,DC=pasaia,DC=net","CN=UdaltzainBulegoa,CN=Users,DC=pasaia,DC=net","CN=LAB-pasaia,CN=Users,DC=pasaia,DC=net","CN=Ezinduak,CN=Users,DC=pasaia,DC=net","CN=Isunak,CN=Users,DC=pasaia,DC=net","CN=LangileenBatza,CN=Users,DC=pasaia,DC=net","CN=PertsonalBatzordea,CN=Users,DC=pasaia,DC=net","CN=SegurtasunOsasunBatzordea,CN=Users,DC=pasaia,DC=net","CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net","CN=ROL-Udaltzaingoa_BIC,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Segurtasun-Osasuna_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Ezinduak,CN=Users,DC=pasaia,DC=net","CN=Taldea-Sindikatuak_LAB,CN=Users,DC=pasaia,DC=net"]', 'LAB', NULL, '0', NULL ),
( '37', 'zrodriguez', 'zrodriguez', 'zrodriguez@pasaia.net', 'zrodriguez@pasaia.net', '1', NULL, '', '2019-08-05 10:47:46', NULL, NULL, 'a:0:{}', 'CN=zrodriguez,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Ziortza Rodriguez Aizkorreta', '44158656J', 'Gizarte langilea', '["CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Gizar-Laguntzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', 'LAB', 'EU', '0', NULL ),
( '38', 'Zinkunegi', 'zinkunegi', 'Zinkunegi@pasaia.net', 'zinkunegi@pasaia.net', '1', NULL, '', '2019-07-18 12:45:11', NULL, NULL, 'a:0:{}', 'CN=Zinkunegi,CN=Users,DC=pasaia,DC=net', 'Hirigintza', 'Miren Zinkunegi Arrillaga', '35772409A', 'Administrazioa eta izapideak', '["CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=ROL-Hirigintza_Administrazioa,CN=Users,DC=pasaia,DC=net"]', 'LAB', 'EU', '0', NULL ),
( '39', 'Inmaculada', 'inmaculada', 'Inmaculada@pasaia.net', 'inmaculada@pasaia.net', '1', NULL, '', '2019-02-08 21:14:20', NULL, NULL, 'a:1:{i:0;s:15:"ROLE_UDALTZAINA";}', 'CN=Inmaculada,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', 'Inmaculada Pinedo Urtxulutegi', '15951752X', 'Udaltzaina', '["CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=Taldea-Sindikatuak_ELA,CN=Users,DC=pasaia,DC=net","CN=ROL-Udaltzaingoa_Udaltzaina,CN=Users,DC=pasaia,DC=net","CN=Udaltzaingoa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Ezinduak,CN=Users,DC=pasaia,DC=net"]', 'ELA', 'EU', '0', NULL ),
( '40', 'jmoneca', 'jmoneca', 'jmoneca@pasaia.net', 'jmoneca@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=jmoneca,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', 'ELA', NULL, '0', NULL ),
( '41', 'jgarcia', 'jgarcia', 'jgarcia@pasaia.net', 'jgarcia@pasaia.net', '1', NULL, '', '2018-09-19 04:01:30', NULL, NULL, 'a:0:{}', 'CN=jgarcia,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', 'Jon Garcia Familiar', '72483897H', 'Udaltzaina', '["CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=Taldea-Sindikatuak_ELA,CN=Users,DC=pasaia,DC=net","CN=ROL-Udaltzaingoa_Administrazioa,CN=Users,DC=pasaia,DC=net","CN=Udaltzaingoa,CN=Users,DC=pasaia,DC=net"]', 'ELA', 'EU', '0', NULL ),
( '42', 'Pako', 'pako', 'Pako@pasaia.net', 'pako@pasaia.net', '1', NULL, '', '2019-07-24 11:56:24', NULL, NULL, 'a:0:{}', 'CN=Pako,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Pako Sudupe Elortza', '72430719Q', 'Irakaslea, hizkuntza-normalizazioko teknikaria', '["CN=ROL-Sustapena_Itzultzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Itzultzaileak,CN=Users,DC=pasaia,DC=net"]', 'Euskera', 'EU', '0', NULL ),
( '43', 'Yolanda', 'yolanda', 'Yolanda@pasaia.net', 'yolanda@pasaia.net', '1', NULL, '', '2019-08-22 13:08:25', NULL, NULL, 'a:0:{}', 'CN=Yolanda,CN=Users,DC=pasaia,DC=net', 'Kultura', 'Yolanda Garcia Hernandez', '15999156B', 'Antxoko Liburuzaina', '["CN=ROL-Sustapena_Liburuzaina,CN=Users,DC=pasaia,DC=net"]', 'Liburuzaina', 'EU', '0', NULL ),
( '44', 'arteaga', 'arteaga', 'arteaga@pasaia.net', 'arteaga@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=arteaga,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaingoaren ofizialordea', '[]', '*** Jose Mª Faya', NULL, '0', NULL ),
( '45', 'Faya', 'faya', 'Faya@pasaia.net', 'faya@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=Faya,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Jarduneko ofizialordea', '[]', '*** Iñaki Portugal', NULL, '0', NULL ),
( '46', 'erab2', 'erab2', 'erab2@pasaia.net', 'erab2@pasaia.net', '1', NULL, '', '2018-09-19 10:15:55', NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 'CN=erab2,CN=Users,DC=pasaia,DC=net', 'Bereziak', 'Erab2', NULL, 'Lanpostua', '["CN=SARBIDE-TV_Donibane-Liburutegia,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-TV_Jberasategi,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_Informatika,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '47', 'mandonegi', 'mandonegi', 'mandonegi@pasaia.net', 'mandonegi@pasaia.net', '1', NULL, '', '2017-10-09 07:33:21', NULL, NULL, 'a:0:{}', 'CN=mandonegi,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Maider Andonegi Mujika', '72456919L', 'Berdintasun Teknikaria', '["CN=Gizarte Ekintza,CN=Users,DC=pasaia,DC=net","CN=Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Berdintasuna,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-bidali,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net"]', NULL, NULL, '0', NULL ),
( '48', 'jlaranburu', 'jlaranburu', 'jlaranburu@pasaia.net', 'jlaranburu@pasaia.net', '1', NULL, '', '2019-08-14 10:08:42', NULL, NULL, 'a:0:{}', 'CN=jlaranburu,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Jose Luis Aranburu Gomez', '72432931C', 'Zehapen espedienteen adm/lag.', '["CN=ROL-Ogasuna_Isunak,CN=Users,DC=pasaia,DC=net"]', '*** Aitor Cuevas', 'EU', '0', NULL ),
( '49', 'acuevas', 'acuevas', 'acuevas@pasaia.net', 'acuevas@pasaia.net', '1', NULL, '', '2019-08-19 12:02:11', NULL, NULL, 'a:0:{}', 'CN=acuevas,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Aitor Cuevas Chans', '44138094J', 'Zehapen espedienteen adm/lag.', '["CN=ROL-Ogasuna_Isunak,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', '*** Jose Luis Aranburu', 'EU', '0', NULL ),
( '50', 'Andone', 'andone', 'Andone@pasaia.net', 'andone@pasaia.net', '1', NULL, '', '2019-08-06 08:58:52', NULL, NULL, 'a:0:{}', 'CN=Andone,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Andone Barandiaran Arratibel', '15941222Z', 'Administrazioa-jendaurreko zerbitzua', '["CN=ROL-Gizarte-Ekintza_Bulegoa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Ezinduak,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '51', 'Clara', 'clara', 'Clara@pasaia.net', 'clara@pasaia.net', '1', NULL, '', '2019-08-27 11:20:31', NULL, NULL, 'a:0:{}', 'CN=Clara,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', 'Clara Barbier Zabaleta', '15977044W', 'Artxibozaina', '["CN=ROL-Idazkaritza_Artxiboa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Intranet_Prentsa_Idatzi,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Zertegi-Kudeatzailea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '52', 'Manoli', 'manoli', 'Manoli@pasaia.net', 'manoli@pasaia.net', '1', NULL, '', '2019-07-30 08:50:19', NULL, NULL, 'a:0:{}', 'CN=Manoli,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Manoli Barrenetxea Blanco', '72432988P', 'Herritarren arreta (orokorra)', '["CN=ROL-Ogasuna_Diru-bilketa_Administrazioa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Intranet_Erregistroa_Idatzi,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Segurtasun-Osasuna_Irakurri,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_HAZ-SAC,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '53', 'belaustegi', 'belaustegi', 'belaustegi@pasaia.net', 'belaustegi@pasaia.net', '1', NULL, '', '2019-07-19 08:49:36', NULL, NULL, 'a:1:{i:0;s:14:"ROLE_SAILBURUA";}', 'CN=belaustegi,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', 'Joseba Belaustegi Cuesta', '15996362T', 'Udal letradu-aholkularia', '["CN=ROL-Aholkularitza-Juridikoa_Aholkularia,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '1', 'Aholkularitza' ),
( '54', 'beloki', 'beloki', 'beloki@pasaia.net', 'beloki@pasaia.net', '1', NULL, '', '2019-08-27 10:42:01', NULL, NULL, 'a:0:{}', 'CN=beloki,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'M.Carmen Beloki  Lizaso', '15964951F', 'Kontu-hartzailetzako kontabilitateko teknikaria', '["CN=ROL-Ogasuna_Kontabilitatea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Ogasuna_Idatzi,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '55', 'aberistain', 'aberistain', 'aberistain@pasaia.net', 'aberistain@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=aberistain,CN=Users,DC=pasaia,DC=net', 'CIP', NULL, NULL, 'Irakasle sozio-laborala', '[]', NULL, NULL, '0', NULL ),
( '56', 'maje', 'maje', 'maje@pasaia.net', 'maje@pasaia.net', '1', NULL, '', '2019-08-19 09:39:36', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SINATZAILEA";i:1;s:14:"ROLE_SAILBURUA";}', 'CN=maje,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Maje Karrera Etxeberria', '72433985Q', 'Gizarte Ekintzako arduraduna', '["CN=ROL-Gizarte-Ekintza_Arduraduna,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Zuzendaritza_Taldea,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '1', 'Gizarte' ),
( '57', 'maika', 'maika', 'maika@pasaia.net', 'maika@pasaia.net', '1', NULL, '', '2019-08-12 14:27:19', NULL, NULL, 'a:0:{}', 'CN=maika,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Maika Castineira Casal', '15994909L', 'Kontu-hartzailetza, kontabilitatea. Administra. - jendaurreko zerbitzua', '["CN=ROL-Ogasuna_Kontabilitatea-Administrazioa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Ogasuna_Idatzi,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '58', 'Cerrato', 'cerrato', 'Cerrato@pasaia.net', 'cerrato@pasaia.net', '1', NULL, '', '2019-06-17 14:08:56', NULL, NULL, 'a:0:{}', 'CN=Cerrato,CN=Users,DC=pasaia,DC=net', 'Hirigintza', 'Edurne Cerrato Eskamendi', '15248460N', 'Delineatzaile-administraria', '["CN=APP-Ulteo_Hiri-Garapena,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Larrialdi-Plana,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Topografia,CN=Users,DC=pasaia,DC=net","CN=ROL-Hirigintza_Delineantea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '59', 'Bego', 'bego', 'Bego@pasaia.net', 'bego@pasaia.net', '1', NULL, '', '2019-08-21 12:19:35', NULL, NULL, 'a:0:{}', 'CN=Bego,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Bego de Miguel Gutierrez', '15933380S', 'Administrazioa eta izapideak', '["CN=APP-Web_Guacamole-HAZ,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Ezinduak,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=Taldea-Sindikatuak_CCOO,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Bulegoa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '60', 'eegana', 'eegana', 'eegana@pasaia.net', 'eegana@pasaia.net', '1', NULL, '', '2019-08-23 09:58:50', NULL, NULL, 'a:0:{}', 'CN=eegana,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Enara Egana Zurita', '44153599Q', 'Gizarte langilea', '["CN=ROL-Gizarte-Ekintza_Gizar-Laguntzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '61', 'Mila', 'mila', 'Mila@pasaia.net', 'mila@pasaia.net', '1', NULL, '', '2019-07-23 13:26:53', NULL, NULL, 'a:0:{}', 'CN=Mila,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Mila Elizondo Zuloaga', '72431247S', 'Diruzaintza. Administrazioa eta jendaurreko zerbitzua', '["CN=ROL-Ogasuna_Diruzaintza-Administrazioa,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-kutxa,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Ogasuna,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '62', 'Agustin', 'agustin', 'Agustin@pasaia.net', 'agustin@pasaia.net', '1', NULL, '', '2019-07-11 14:55:21', NULL, NULL, 'a:0:{}', 'CN=Agustin,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', 'Agustin Emparan Ortiz', '15237718B', 'Aseguru, kontratazio eta erosketen kudeaketa', '["CN=ROL-Idazkaritza_Kudeaketa,CN=Users,DC=pasaia,DC=net"]', NULL, 'ES', '0', NULL ),
( '63', 'iesnaola', 'iesnaola', 'iesnaola@pasaia.net', 'iesnaola@pasaia.net', '1', NULL, '', '2019-04-29 09:07:32', NULL, NULL, 'a:0:{}', 'CN=iesnaola,CN=Users,DC=pasaia,DC=net', 'CIP', 'Inigo Esnaola Arbiza', '44141444M', 'Irakaslea', '["CN=cip-lhi,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '64', 'marian', 'marian', 'marian@pasaia.net', 'marian@pasaia.net', '1', NULL, '', '2019-06-10 10:01:19', NULL, NULL, 'a:0:{}', 'CN=marian,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Marian Figueroa Laboa', '15902864C', 'Administrazioa-jendaurreko zerbitzua', '["CN=SARBIDE-Ezinduak,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Bulegoa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '65', 'Ngago', 'ngago', 'Ngago@pasaia.net', 'ngago@pasaia.net', '1', NULL, '', '2019-05-07 10:36:24', NULL, NULL, 'a:0:{}', 'CN=Ngago,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Nerea Gago Rezola', '44167688Y', 'Gizarte langilea', '["CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Gizar-Laguntzailea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '66', 'agoienetxea', 'agoienetxea', 'agoienetxea@pasaia.net', 'agoienetxea@pasaia.net', '1', NULL, '', '2019-07-22 12:48:50', NULL, NULL, 'a:0:{}', 'CN=agoienetxea,CN=Users,DC=pasaia,DC=net', 'CIP', 'Aitor Goienetxea Urkizu', '35773384N', 'Irakaslea', '["CN=ROL-OLH_Irakaslea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '67', 'mguezala', 'mguezala', 'mguezala@pasaia.net', 'mguezala@pasaia.net', '1', NULL, '', '2019-08-01 11:24:42', NULL, NULL, 'a:0:{}', 'CN=mguezala,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Maider Guezala Sala', '72461191J', 'Gizarte langilea', '["CN=ROL-Gizarte-Ekintza_Gizar-Laguntzailea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '68', 'Rosa', 'rosa', 'Rosa@pasaia.net', 'rosa@pasaia.net', '1', NULL, '', '2019-07-01 07:55:22', NULL, NULL, 'a:0:{}', 'CN=Rosa,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Rosa Ibarlucea Gracia', '72433104D', 'Errentak. Administrazioa eta izapideak', '["CN=ROL-Ogasuna_Errentak-Administrazioa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '69', 'tiglesias', 'tiglesias', 'tiglesias@pasaia.net', 'tiglesias@pasaia.net', '1', NULL, '', '2019-07-19 12:51:11', NULL, NULL, 'a:0:{}', 'CN=tiglesias,CN=Users,DC=pasaia,DC=net', 'CIP', 'Tomas Iglesias Gomez', '44126913X', 'Irakaslea', '["CN=ROL-OLH_Irakaslea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '70', 'Maitane', 'maitane', 'Maitane@pasaia.net', 'maitane@pasaia.net', '1', NULL, '', '2019-08-05 09:27:14', NULL, NULL, 'a:0:{}', 'CN=Maitane,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Maitane Irurieta Zabala', '44138555Z', 'Gizarte langilea', '["CN=ROL-Gizarte-Ekintza_Gizar-Laguntzailea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '71', 'mkortajarena', 'mkortajarena', 'mkortajarena@pasaia.net', 'mkortajarena@pasaia.net', '1', NULL, '', '2019-08-22 12:59:03', NULL, NULL, 'a:0:{}', 'CN=mkortajarena,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Maite Kortajarena Albisu', '15999546X', 'Gizarte langilea', '["CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Gizar-Laguntzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '72', 'jlarrea', 'jlarrea', 'jlarrea@pasaia.net', 'jlarrea@pasaia.net', '1', NULL, '', '2019-02-18 12:25:16', NULL, NULL, 'a:0:{}', 'CN=jlarrea,CN=Users,DC=pasaia,DC=net', 'Hirigintza', 'Joana Larrea Auzokoa', '16074403W', 'Ingurumen Teknikaria', '["CN=ROL-Hirigintza_Ingurumen-Teknikaria,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Topografia,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Hiri-Garapena,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '73', 'nlasa', 'nlasa', 'nlasa@pasaia.net', 'nlasa@pasaia.net', '1', NULL, '', '2019-08-20 08:17:39', NULL, NULL, 'a:0:{}', 'CN=nlasa,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Naiara Lasa Aranburu', '44158142M', 'Gizarte langilea', '["CN=ROL-Gizarte-Ekintza_Gizar-Laguntzailea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '74', 'lmagarino', 'lmagarino', 'lmagarino@pasaia.net', 'lmagarino@pasaia.net', '1', NULL, '', '2019-08-22 07:40:26', NULL, NULL, 'a:0:{}', 'CN=lmagarino,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', 'Leire Magarino Mitxelena', '44171144N', 'Gobernu-organoak', '["CN=SARBIDE-Batzordea_Udalbatza_Idatzi,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Tokiko-Gobernua_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Udalbatza_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Ondare-Kontratazio-ZZ-Juridikoak_Idatzi,CN=Users,DC=pasaia,DC=net","CN=ROL-Idazkaritza_Administrazioa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Tokiko-Gobernua_Idatzi,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '75', 'mmanzano', 'mmanzano', 'mmanzano@pasaia.net', 'mmanzano@pasaia.net', '1', NULL, '', '2019-04-29 08:52:14', NULL, NULL, 'a:0:{}', 'CN=mmanzano,CN=Users,DC=pasaia,DC=net', 'CIP', 'Maribel Manzano Herce', '34106863W', 'Irakasle sozio-laborala', '["CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '76', 'iostolaza', 'iostolaza', 'iostolaza@pasaia.net', 'iostolaza@pasaia.net', '1', NULL, '', '2019-07-24 13:58:01', NULL, NULL, 'a:0:{}', 'CN=iostolaza,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', 'Iker Ostolaza Oiarzabal', '35772450K', 'Udalaren ondarea, emakidak, zerbitzuak eta erregistroak', '["CN=APP-Web_Guacamole-HAZ,CN=Users,DC=pasaia,DC=net","CN=ROL-Idazkaritza_Ondarea,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '77', 'KPuy', 'kpuy', 'KPuy@pasaia.net', 'kpuy@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=KPuy,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', NULL, NULL, 'Gobernu-organoak', '[]', NULL, NULL, '0', NULL ),
( '78', 'nrecio', 'nrecio', 'nrecio@pasaia.net', 'nrecio@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=nrecio,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', NULL, NULL, 'Aseguru, kontratazio eta erosketen kudeaketa', '[]', NULL, NULL, '0', NULL ),
( '79', 'agalindez', 'agalindez', 'agalindez@pasaia.net', 'agalindez@pasaia.net', '1', NULL, '', '2017-12-04 13:12:35', NULL, NULL, 'a:0:{}', 'CN=agalindez,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Amaia Galindez Fernandez', '44688804B', 'Gizarte langilea', '["CN=ROL-Gizarte-Ekintza_Gizar-Laguntzailea,CN=Users,DC=pasaia,DC=net"]', NULL, NULL, '0', NULL ),
( '80', 'murbitarte', 'murbitarte', 'murbitarte@pasaia.net', 'murbitarte@pasaia.net', '1', NULL, '', '2019-08-27 07:22:07', NULL, NULL, 'a:0:{}', 'CN=murbitarte,CN=Users,DC=pasaia,DC=net', 'Ogasuna', 'Maider Urbitarte Mancisidor', '72454563D', 'Zergen teknikaria', '["CN=APP-Web_Guacamole-HAZ,CN=Users,DC=pasaia,DC=net","CN=ROL-Ogasuna_Errentak,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Ogasuna,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '81', 'lsalaberria', 'lsalaberria', 'lsalaberria@pasaia.net', 'lsalaberria@pasaia.net', '1', NULL, '', '2019-08-27 12:11:26', NULL, NULL, 'a:0:{}', 'CN=lsalaberria,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Lurdes Salaberria Garmendia', '34086709L', 'Gizarte langilea', '["CN=ROL-Zahar-Egoitza-GLaguntzailea,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Gizar-Laguntzailea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '82', 'Inmigrazioa', 'inmigrazioa', 'Inmigrazioa@pasaia.net', 'inmigrazioa@pasaia.net', '1', NULL, '', '2019-08-14 10:25:01', NULL, NULL, 'a:0:{}', 'CN=Inmigrazioa,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Marian Suarez Martin', '44127548R', 'Migrazio eta aniztasun teknikaria', '["CN=ROL-Gizarte-Ekintza_Inmigrazioa,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-bidali,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '83', 'jjtorre', 'jjtorre', 'jjtorre@pasaia.net', 'jjtorre@pasaia.net', '1', NULL, '', '2019-04-29 09:17:48', NULL, NULL, 'a:0:{}', 'CN=jjtorre,CN=Users,DC=pasaia,DC=net', 'CIP', 'Jon Joseba Torre', '72455649Z', 'Irakaslea', '["CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net","CN=cip-lhi,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '84', 'mrios', 'mrios', 'mrios@pasaia.net', 'mrios@pasaia.net', '1', NULL, '', '2017-09-27 12:29:26', NULL, NULL, 'a:0:{}', 'CN=mrios,CN=Users,DC=pasaia,DC=net', 'Zaharren Egoitza', 'Maite Rios Domingo', '35771003T', 'Administrari laguntzailea', '["CN=ROL-Zahar-Egoitza_Administrazioa,CN=Users,DC=pasaia,DC=net","CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net","CN=apartamentuak,CN=Users,DC=pasaia,DC=net","CN=ZEgoitza,CN=Users,DC=pasaia,DC=net","CN=Zahar-Bulego,CN=Users,DC=pasaia,DC=net","CN=erizainak,CN=Users,DC=pasaia,DC=net","CN=Egoitza,CN=Users,DC=pasaia,DC=net"]', NULL, NULL, '0', NULL ),
( '85', 'alertxundi', 'alertxundi', 'alertxundi@pasaia.net', 'alertxundi@pasaia.net', '1', NULL, '', '2019-08-06 14:04:52', NULL, NULL, 'a:0:{}', 'CN=alertxundi,CN=Users,DC=pasaia,DC=net', 'Hirigintza', 'Aitor Lertxundi Yeregui', '72495531Z', 'Hirigintzako Administrari Laguntzailea', '["CN=ROL-Hirigintza_Administrazioa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '86', 'aaraneta', 'aaraneta', 'aaraneta@pasaia.net', 'aaraneta@pasaia.net', '1', NULL, '', '2019-08-05 11:30:06', NULL, NULL, 'a:0:{}', 'CN=aaraneta,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Aitzole Araneta Zinkunegi', '44139736E', 'Berdintasun Teknikaria', '["CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=APP-Web_SMS-bidali,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Berdintasuna,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '87', 'amartinez', 'amartinez', 'amartinez@pasaia.net', 'amartinez@pasaia.net', '1', NULL, '', '2019-07-19 12:50:49', NULL, NULL, 'a:0:{}', 'CN=amartinez,CN=Users,DC=pasaia,DC=net', 'CIP', 'Ane Martinez', '44563390Q', 'Irakasle sozio-laborala', '["CN=ROL-OLH_Bulegoa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '88', 'nsolagaistua', 'nsolagaistua', 'nsolagaistua@pasaia.net', 'nsolagaistua@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=nsolagaistua,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '89', 'nbazo', 'nbazo', 'nbazo@pasaia.net', 'nbazo@pasaia.net', '1', NULL, '', '2018-09-26 10:18:59', NULL, NULL, 'a:0:{}', 'CN=nbazo,CN=Users,DC=pasaia,DC=net', 'Idazkaritza', 'Nerea Bazo Diaz-Aguado', '44131589V', 'Gobernu-organoak', '["CN=ROL-Idazkaritza_Administrazioa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Tokiko-Gobernua_Idatzi,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Udalbatza_Idatzi,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Udalbatza_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Tokiko-Gobernua_Irakurri,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '90', 'jpineiro', 'jpineiro', 'jpineiro@pasaia.net', 'jpineiro@pasaia.net', '1', NULL, '', '2019-08-14 12:11:50', NULL, NULL, 'a:0:{}', 'CN=jpineiro,CN=Users,DC=pasaia,DC=net', 'HAZ-SAC', 'Jorge Pineiro Fernandez', '44170460H', 'Herritarren arreta (orokorra)', '["CN=SARBIDE-Intranet_Erregistroa_Idatzi,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_HAZ-SAC,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '91', 'lsuarez', 'lsuarez', 'lsuarez@pasaia.net', 'lsuarez@pasaia.net', '1', NULL, '', '2019-07-18 10:25:13', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SINATZAILEA";i:1;s:15:"ROLE_ARDURADUNA";}', 'CN=lsuarez,CN=Users,DC=pasaia,DC=net', 'Zinegotzia', 'Lore Suarez Linazasoro', '44147040N', 'Lehen alkateordea', '["CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Ondare-Kontratazio-ZZ-Juridikoak_Irakurri,CN=Users,DC=pasaia,DC=net","CN=PertsonalBatzordea,CN=Users,DC=pasaia,DC=net","CN=Zinegotziak,CN=Users,DC=pasaia,DC=net","CN=Alkatetza,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Segurtasun-Osasuna_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SegurtasunOsasunBatzordea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Zuzendaritza_Taldea,CN=Users,DC=pasaia,DC=net","CN=ROL-Hautetsiak_PSE-EE,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=PSE-EE-PASAIA,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Intranet_Erregistroa_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Sindikatuko-Ordezkariekin-Bilerak_Irakurri,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Arduraduna,CN=Users,DC=pasaia,DC=net"]', NULL, 'ES', '0', NULL ),
( '92', 'igomez', 'igomez', 'igomez@pasaia.net', 'igomez@pasaia.net', '1', NULL, '', '2019-08-27 10:40:54', NULL, NULL, 'a:2:{i:0;s:16:"ROLE_SINATZAILEA";i:1;s:15:"ROLE_ARDURADUNA";}', 'CN=igomez,CN=Users,DC=pasaia,DC=net', 'Alkatetza', 'Izaskun Gomez Cermeno', '15980525X', 'Alkatea', '["CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=ROL-Alkatetza_Alkatea,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Zuzendaritza_Taldea,CN=Users,DC=pasaia,DC=net","CN=ROL-Hautetsiak_PSE-EE,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Intranet_Erregistroa_Irakurri,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Arduraduna,CN=Users,DC=pasaia,DC=net"]', NULL, 'ES', '0', NULL ),
( '93', 'sekiza', 'sekiza', 'sekiza@pasaia.net', 'sekiza@pasaia.net', '1', NULL, '', '2019-06-14 10:16:59', NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SINATZAILEA";}', 'CN=sekiza,CN=Users,DC=pasaia,DC=net', 'Zinegotzia', 'Sergio Ekiza Ipina', '72481180S', 'Zinegotzia - EAJ/PNV', '["CN=EAJ-PNV-PASAIA,CN=Users,DC=pasaia,DC=net","CN=Zinegotziak,CN=Users,DC=pasaia,DC=net","CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net","CN=ROL-Hautetsiak_EAJ-PNV,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Udalbatza_Irakurri,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net"]', NULL, 'ES', '0', NULL ),
( '94', 'mcano', 'mcano', 'mcano@pasaia.net', 'mcano@pasaia.net', '1', NULL, '', '2019-06-15 09:29:44', NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SINATZAILEA";}', 'CN=mcano,CN=Users,DC=pasaia,DC=net', 'Zinegotzia', 'Miriam Cano Puy', '34080613H', 'Donibaneko Alkateordea', '["CN=Kultura,CN=Users,DC=pasaia,DC=net","CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net","CN=EAJ-PNV-PASAIA,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=KulturaArloa,CN=Users,DC=pasaia,DC=net","CN=Euskara,CN=Users,DC=pasaia,DC=net","CN=Zinegotziak,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Udalbatza_Irakurri,CN=Users,DC=pasaia,DC=net","CN=ROL-Hautetsiak_EAJ-PNV,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=Liburutegiak,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '95', 'notermin', 'notermin', 'notermin@pasaia.net', 'notermin@pasaia.net', '1', NULL, '', '2019-08-08 12:24:02', NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SINATZAILEA";}', 'CN=notermin,CN=Users,DC=pasaia,DC=net', 'Zinegotzia', 'Nahikari Otermin Soroa', '44149653A', 'San Pedroko Alkateordea', '["CN=EAJ-PNV-PASAIA,CN=Users,DC=pasaia,DC=net","CN=Zinegotziak,CN=Users,DC=pasaia,DC=net","CN=PertsonalBatzordea,CN=Users,DC=pasaia,DC=net","CN=GobernuBatzordea,CN=Users,DC=pasaia,DC=net","CN=SegurtasunOsasunBatzordea,CN=Users,DC=pasaia,DC=net","CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net","CN=ROL-Hautetsiak_EAJ-PNV,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Segurtasun-Osasuna_Irakurri,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Zuzendaritza_Taldea,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Ondare-Kontratazio-ZZ-Juridikoak_Irakurri,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '96', 'Jose', 'jose', 'Jose@pasaia.net', 'jose@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=Jose,CN=Users,DC=pasaia,DC=net', 'Zerbitzuak', NULL, NULL, 'Zerbitzu, Sare eta Mantentze-lanen Saileko arduraduna', '[]', NULL, NULL, '0', NULL ),
( '97', 'aiturbe', 'aiturbe', 'aiturbe@pasaia.net', 'aiturbe@pasaia.net', '1', NULL, '', '2019-06-26 16:12:42', NULL, NULL, 'a:0:{}', 'CN=aiturbe,CN=Users,DC=pasaia,DC=net', 'Zinegotzia', 'Aitor Iturbe Otaegui', '15993913N', 'Zinegotzia - EAJ/PNV', '["CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=INTERNET_Orokorra,CN=Users,DC=pasaia,DC=net","CN=EAJ-PNV-PASAIA,CN=Users,DC=pasaia,DC=net","CN=APP-Web_KexaKud,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Ondare-Kontratazio-ZZ-Juridikoak_Irakurri,CN=Users,DC=pasaia,DC=net","CN=PertsonalBatzordea,CN=Users,DC=pasaia,DC=net","CN=Zinegotziak,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Segurtasun-Osasuna_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SegurtasunOsasunBatzordea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Udalbatza_Irakurri,CN=Users,DC=pasaia,DC=net","CN=ROL-Hautetsiak_EAJ-PNV,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=GobernuBatzordea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '98', 'edegana', 'edegana', 'edegana@pasaia.net', 'edegana@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=edegana,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '99', 'Mvarela', 'mvarela', 'Mvarela@pasaia.net', 'mvarela@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=Mvarela,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, '1. mailako udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '100', 'bgonzalez', 'bgonzalez', 'bgonzalez@pasaia.net', 'bgonzalez@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=bgonzalez,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '101', 'rodolfo', 'rodolfo', 'rodolfo@pasaia.net', 'rodolfo@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=rodolfo,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, '1. mailako udaltzaina', '[]', 'LAB - PREBENTZIO ORDEZKARIA', NULL, '0', NULL ),
( '102', 'ssanchez', 'ssanchez', 'ssanchez@pasaia.net', 'ssanchez@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=ssanchez,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '103', 'kagirre', 'kagirre', 'kagirre@pasaia.net', 'kagirre@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=kagirre,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '104', 'jmisasa', 'jmisasa', 'jmisasa@pasaia.net', 'jmisasa@pasaia.net', '1', NULL, '', '2018-09-20 01:58:18', NULL, NULL, 'a:1:{i:0;s:15:"ROLE_UDALTZAINA";}', 'CN=jmisasa,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', 'Jose Maria Isasa Ulazia', '15973404L', 'Udaltzaina', '["CN=Taldea-Sindikatuak_LAB,CN=Users,DC=pasaia,DC=net","CN=ROL-Udaltzaingoa_Udaltzaina,CN=Users,DC=pasaia,DC=net","CN=Udaltzaingoa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '105', 'jmiarzabal', 'jmiarzabal', 'jmiarzabal@pasaia.net', 'jmiarzabal@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=jmiarzabal,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '106', 'Loli', 'loli', 'Loli@pasaia.net', 'loli@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=Loli,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '107', 'Otermin', 'otermin', 'Otermin@pasaia.net', 'otermin@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=Otermin,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, '1. mailako udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '108', 'jaarzallus', 'jaarzallus', 'jaarzallus@pasaia.net', 'jaarzallus@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=jaarzallus,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '109', 'aintxauspe', 'aintxauspe', 'aintxauspe@pasaia.net', 'aintxauspe@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=aintxauspe,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '110', 'Lucas', 'lucas', 'Lucas@pasaia.net', 'lucas@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=Lucas,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '111', 'agrijalba', 'agrijalba', 'agrijalba@pasaia.net', 'agrijalba@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=agrijalba,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '112', 'urdapi', 'urdapi', 'urdapi@pasaia.net', 'urdapi@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=urdapi,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '113', 'jmisasi', 'jmisasi', 'jmisasi@pasaia.net', 'jmisasi@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=jmisasi,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '114', 'aoteiza', 'aoteiza', 'aoteiza@pasaia.net', 'aoteiza@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=aoteiza,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', 'LAB', NULL, '0', NULL ),
( '115', 'jmaldaz', 'jmaldaz', 'jmaldaz@pasaia.net', 'jmaldaz@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=jmaldaz,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '116', 'Iribarren', 'iribarren', 'Iribarren@pasaia.net', 'iribarren@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=Iribarren,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '117', 'Longarte', 'longarte', 'Longarte@pasaia.net', 'longarte@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=Longarte,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '118', 'Rafa', 'rafa', 'Rafa@pasaia.net', 'rafa@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=Rafa,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '119', 'pmolpeceres', 'pmolpeceres', 'pmolpeceres@pasaia.net', 'pmolpeceres@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=pmolpeceres,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '120', 'jmoilokiegi', 'jmoilokiegi', 'jmoilokiegi@pasaia.net', 'jmoilokiegi@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=jmoilokiegi,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '121', 'oolaizola', 'oolaizola', 'oolaizola@pasaia.net', 'oolaizola@pasaia.net', '1', NULL, '', '2018-09-19 04:16:21', NULL, NULL, 'a:0:{}', 'CN=oolaizola,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', 'Oscar Olaizola Berroa', '34095706T', 'Udaltzaina', '["CN=ROL-Udaltzaingoa_Udaltzaina,CN=Users,DC=pasaia,DC=net","CN=Udaltzaingoa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '122', 'irodrigo', 'irodrigo', 'irodrigo@pasaia.net', 'irodrigo@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=irodrigo,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '123', 'jsein', 'jsein', 'jsein@pasaia.net', 'jsein@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=jsein,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '124', 'Vila', 'vila', 'Vila@pasaia.net', 'vila@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=Vila,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, '1. mailako udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '125', 'idaguer', 'idaguer', 'idaguer@pasaia.net', 'idaguer@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=idaguer,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '126', 'azapiain', 'azapiain', 'azapiain@pasaia.net', 'azapiain@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=azapiain,CN=Users,DC=pasaia,DC=net', 'Udaltzaingoa', NULL, NULL, 'Udaltzaina', '[]', NULL, NULL, '0', NULL ),
( '127', 'bmakazaga', 'bmakazaga', 'bmakazaga@pasaia.net', 'bmakazaga@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=bmakazaga,CN=Users,DC=pasaia,DC=net', 'Zerbitzuak', NULL, NULL, '1. mailako ofizial gidaria', '[]', 'LAB', NULL, '0', NULL ),
( '128', 'atorrado', 'atorrado', 'atorrado@pasaia.net', 'atorrado@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=atorrado,CN=Users,DC=pasaia,DC=net', 'Alkatetza', NULL, NULL, 'Alkatearen Idazkaria', '[]', NULL, NULL, '0', NULL ),
( '129', 'mralla', 'mralla', 'mralla@pasaia.net', 'mralla@pasaia.net', '1', NULL, '', '2019-07-19 10:50:15', NULL, NULL, 'a:0:{}', 'CN=mralla,CN=Users,DC=pasaia,DC=net', 'Hirigintza', 'Manex Ralla Arregi', '72515128S', 'Hirigintza arloko teknikaria', '["CN=APP-Web_Guacamole-HAZ,CN=Users,DC=pasaia,DC=net","CN=ROL-Hirigintza_Legalaria,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Hirigintza_Idatzi,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Udalbatza_Irakurri,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '130', 'aoiarbide', 'aoiarbide', 'aoiarbide@pasaia.net', 'aoiarbide@pasaia.net', '1', NULL, '', '2019-08-21 12:26:24', NULL, NULL, 'a:4:{i:0;s:10:"ROLE_ADMIN";i:1;s:16:"ROLE_SINATZAILEA";i:2;s:14:"ROLE_SAILBURUA";i:3;s:15:"ROLE_ARDURADUNA";}', 'CN=aoiarbide,CN=Users,DC=pasaia,DC=net', 'Pertsonala', 'Amaia Oiarbide Urtxulutegi', '44573430M', 'Antolaketa eta GGBB teknikaria', '["CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Egutegia,CN=Users,DC=pasaia,DC=net","CN=ROL-Antolakuntza_GGBB-Arduraduna,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Guacamole-Nomina,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Segurtasun-Osasuna_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Larrialdi-Plana,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Arduraduna,CN=Users,DC=pasaia,DC=net"]', '*** Ruth Gonzalez', 'EU', '1', 'Antolakuntza' ),
( '131', 'malbizu', 'malbizu', 'malbizu@pasaia.net', 'malbizu@pasaia.net', '1', NULL, '', '2019-08-27 07:47:31', NULL, NULL, 'a:0:{}', 'CN=malbizu,CN=Users,DC=pasaia,DC=net', 'Kudeaketa', 'Mikel Albizu Huegun', '34089454G', 'Aseguru, kontratazio eta erosketen kudeaketa', '["CN=ROL-Idazkaritza_Kudeaketa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '132', 'icia', 'icia', 'icia@pasaia.net', 'icia@pasaia.net', '1', NULL, '', '2018-11-07 13:00:06', NULL, NULL, 'a:0:{}', 'CN=icia,CN=Users,DC=pasaia,DC=net', 'Diru-Bilketa', 'Idoia Cia Olascoaga', '44140603S', 'Jakinarazlea', '["CN=APP-Web_Jakinarazpenak,CN=Users,DC=pasaia,DC=net","CN=ROL-Ogasuna_Diru-bilketa_Jakinarazlea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '133', 'aoyarzabal', 'aoyarzabal', 'aoyarzabal@pasaia.net', 'aoyarzabal@pasaia.net', '1', NULL, '', '2018-12-14 14:33:56', NULL, NULL, 'a:0:{}', 'CN=aoyarzabal,CN=Users,DC=pasaia,DC=net', 'Migrazioa', 'Aitor Oyarzabal Zabalegui', '44550441Q', 'Migrazio eta aniztasun teknikaria', '["CN=APP-Web_SMS-bidali,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Inmigrazioa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '134', 'barratibel', 'barratibel', 'barratibel@pasaia.net', 'barratibel@pasaia.net', '1', NULL, '', '2018-09-17 10:08:44', NULL, NULL, 'a:0:{}', 'CN=barratibel,CN=Users,DC=pasaia,DC=net', 'Zerbitzuak', 'Bernardo Arratibel Bilbao', '15987636Z', 'Administrazioa eta jendaurreko zerbitzua', '["CN=ROL-Zerbitzuak_Administrazioa,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Gerkud,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Guacamole-HAZ,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '135', 'jlmujika', 'jlmujika', 'jlmujika@pasaia.net', 'jlmujika@pasaia.net', '1', NULL, '', '2018-09-24 14:24:30', NULL, NULL, 'a:0:{}', 'CN=jlmujika,CN=Users,DC=pasaia,DC=net', 'Zerbitzuak', 'Jose Luis Mujika Basurko', '15944516L', 'Zerbitzuetako arduraduna', '["CN=ROL-Zerbitzuak_Zerbitzu-Arloa,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Gerkud,CN=Users,DC=pasaia,DC=net","CN=Taldea-Sindikatuak_ELA,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '136', 'aolkotz', 'aolkotz', 'aolkotz@pasaia.net', 'aolkotz@pasaia.net', '1', NULL, '', '2018-09-21 12:45:44', NULL, NULL, 'a:0:{}', 'CN=aolkotz,CN=Users,DC=pasaia,DC=net', 'Euskaltegia', 'Ane Olkotz Goikoetxea', '15994083K', 'Euskaltegiko Irakaslea', '["CN=ROL-Euskaltegia_Irakaslea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '137', 'admin', 'admin', 'admin@pasaia.net', 'admin@pasaia.net', '1', NULL, '', '2018-10-11 07:51:57', NULL, NULL, 'a:0:{}', 'CN=admin,CN=Users,DC=pasaia,DC=net', 'Bereziak', 'Admin', NULL, 'System User', '["CN=Domain Admins,CN=Users,DC=pasaia,DC=net"]', NULL, NULL, '0', NULL ),
( '138', 'lvalparis', 'lvalparis', 'lvalparis@pasaia.net', 'lvalparis@pasaia.net', '1', NULL, '', '2018-11-09 07:33:18', NULL, NULL, 'a:0:{}', 'CN=lvalparis,CN=Users,DC=pasaia,DC=net', 'Zerbitzuak', 'Lander Valparis Arriaga', NULL, 'Instalazioetarako teknikaria', '["CN=APP-Ulteo_Iberdrola,CN=Users,DC=pasaia,DC=net","CN=APP-Web_Gerkud,CN=Users,DC=pasaia,DC=net","CN=ROL-Zerbitzuak_Instalazioetako-Teknikaria,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Topografia,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '139', 'lmujika', 'lmujika', 'lmujika@pasaia.net', 'lmujika@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=lmujika,CN=Users,DC=pasaia,DC=net', 'Zerbitzuak', NULL, NULL, 'Zerbitzu, sare eta mantentze-lanetako langilea', '[]', NULL, NULL, '0', NULL ),
( '140', 'rbelmonte', 'rbelmonte', 'rbelmonte@pasaia.net', 'rbelmonte@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=rbelmonte,CN=Users,DC=pasaia,DC=net', 'Zerbitzuak', NULL, NULL, 'Zerbitzu, sare eta mantentze-lanetako langilea', '[]', NULL, NULL, '0', NULL ),
( '141', 'jmfgorostiza', 'jmfgorostiza', 'jmfgorostiza@pasaia.net', 'jmfgorostiza@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=jmfgorostiza,CN=Users,DC=pasaia,DC=net', 'Zerbitzuak', NULL, NULL, 'Zerbitzu, sare eta mantentze-lanetako langilea', '[]', NULL, NULL, '0', NULL ),
( '142', 'afranco', 'afranco', 'afranco@pasaia.net', 'afranco@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=afranco,CN=Users,DC=pasaia,DC=net', 'Zerbitzuak', NULL, NULL, 'Garbitzailea', '[]', NULL, NULL, '0', NULL ),
( '143', 'esubtil', 'esubtil', 'esubtil@pasaia.net', 'esubtil@pasaia.net', '1', NULL, '', '2019-01-09 18:00:53', NULL, NULL, 'a:0:{}', 'CN=esubtil,CN=Users,DC=pasaia,DC=net', 'Liburutegiak', 'Elixabet Subtil Inigo', '15986481D', 'Antxoko Liburuzaina', '["CN=ROL-Sustapena_Liburuzaina,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '144', 'iurrutia', 'iurrutia', 'iurrutia@pasaia.net', 'iurrutia@pasaia.net', '1', NULL, '', '2019-08-09 09:02:31', NULL, NULL, 'a:1:{i:0;s:14:"ROLE_SAILBURUA";}', 'CN=iurrutia,CN=Users,DC=pasaia,DC=net', 'Haurren eskubideak', 'Iyuya Urrutia Goya', '72479780H', 'Haur eta nerabeen erdi mailako teknikaria', '["CN=ROL-Haur-Nerabe_Haur-Nerabe-Teknikaria,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '1', 'Haur' ),
( '145', 'xiridoy', 'xiridoy', 'xiridoy@pasaia.net', 'xiridoy@pasaia.net', '1', NULL, '', '2019-07-30 14:18:09', NULL, NULL, 'a:0:{}', 'CN=xiridoy,CN=Users,DC=pasaia,DC=net', 'Hirigintza', 'Xabier Iridoy Iruretagoyena', '15249948M', 'Hirigintza Errefortzua', '["CN=ROL-Hirigintza_Ingurumen-Teknikaria,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Hiri-Garapena,CN=Users,DC=pasaia,DC=net","CN=APP-Ulteo_Nabegatzaileak,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Topografia,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '146', 'jmgarmendia', 'jmgarmendia', 'jmgarmendia@pasaia.net', 'jmgarmendia@pasaia.net', '1', NULL, '', '2019-07-11 10:57:06', NULL, NULL, 'a:0:{}', 'CN=jmgarmendia,CN=Users,DC=pasaia,DC=net', 'Liburutegiak', 'Josetxo Garmendia Apezetxea', '34099025F', 'Antxoko Liburuzaina', '["CN=ROL-Sustapena_Liburuzaina,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '147', 'afernandez', 'afernandez', 'afernandez@pasaia.net', 'afernandez@pasaia.net', '1', NULL, '', '2019-08-21 09:27:43', NULL, NULL, 'a:0:{}', 'CN=afernandez,CN=Users,DC=pasaia,DC=net', 'Sustapena', 'Ainhoa Fernandez Carballo', '44162451J', 'Administrazioa eta jendaurreko zerbitzua', '["CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=ROL-Sustapena_Administrazioa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '148', 'lzumalde', 'lzumalde', 'lzumalde@pasaia.net', 'lzumalde@pasaia.net', '1', NULL, '', '2019-08-26 08:59:21', NULL, NULL, 'a:0:{}', 'CN=lzumalde,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Leire Zumalde Gantxegi', '44332676S', 'Gizarte Langilea', '["CN=ROL-Gizarte-Ekintza_Gizar-Laguntzailea,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '149', 'losa', 'losa', 'losa@pasaia.net', 'losa@pasaia.net', '1', NULL, '', '2019-08-26 08:50:04', NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SINATZAILEA";}', 'CN=losa,CN=Users,DC=pasaia,DC=net', 'Zinegotzia', 'Loreto Osa Ocon', '44126008W', 'Zinegotzia - EAJ/PNV', '["CN=ROL-Hautetsiak_EAJ-PNV,CN=Users,DC=pasaia,DC=net","CN=Zinegotziak,CN=Users,DC=pasaia,DC=net","CN=App-Web_Egutegia-Sinatzailea,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_GBB_Irakurri,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Batzordea_Ondare-Kontratazio-ZZ-Juridikoak_Irakurri,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '150', 'kperez', 'kperez', 'kperez@pasaia.net', 'kperez@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=kperez,CN=Users,DC=pasaia,DC=net', 'Zinegotzia', NULL, NULL, 'Zinegotzia - EAJ/PNV', '[]', NULL, NULL, NULL, NULL ),
( '151', 'jaguayo', 'jaguayo', 'jaguayo@pasaia.net', 'jaguayo@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=jaguayo,CN=Users,DC=pasaia,DC=net', 'Zinegotzia', NULL, NULL, 'Zinegotzia - PSE-EE', '[]', NULL, NULL, NULL, NULL ),
( '152', 'jmendoza', 'jmendoza', 'jmendoza@pasaia.net', 'jmendoza@pasaia.net', '1', NULL, '', NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 'CN=jmendoza,CN=Users,DC=pasaia,DC=net', 'Hirigintza', NULL, NULL, 'Hirigintza arloko teknikaria', '[]', NULL, NULL, NULL, NULL ),
( '153', 'larbelaiz', 'larbelaiz', 'larbelaiz@pasaia.net', 'larbelaiz@pasaia.net', '1', NULL, '', '2019-08-23 14:33:13', NULL, NULL, 'a:0:{}', 'CN=larbelaiz,CN=Users,DC=pasaia,DC=net', 'Kudeaketa', 'Larraitz Arbelaiz Garmendia', '35779166K', 'Aseguru, kontratazio eta erosketen kudeaketa', '["CN=ROL-Idazkaritza_Kudeaketa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '154', 'eacha', 'eacha', 'eacha@pasaia.net', 'eacha@pasaia.net', '1', NULL, '', '2019-07-19 11:47:40', NULL, NULL, 'a:0:{}', 'CN=eacha,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Eider Acha Corella', '44167601B', 'Administrazioa eta jendaurreko zerbitzua', '["CN=ROL-Gizarte-Ekintza_Bulegoa,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Ezinduak,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL ),
( '155', 'siraola', 'siraola', 'siraola@pasaia.net', 'siraola@pasaia.net', '1', NULL, '', '2019-08-05 14:22:09', NULL, NULL, 'a:0:{}', 'CN=siraola,CN=Users,DC=pasaia,DC=net', 'Berdintasuna', 'Saioa Iraola Urkiola', '44633379Q', 'Berdintasun Teknikaria', '["CN=APP-Web_SMS-bidali,CN=Users,DC=pasaia,DC=net","CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Berdintasuna,CN=Users,DC=pasaia,DC=net"]', NULL, NULL, '0', NULL ),
( '156', 'mmugica', 'mmugica', 'mmugica@pasaia.net', 'mmugica@pasaia.net', '1', NULL, '', '2019-08-06 09:01:16', NULL, NULL, 'a:0:{}', 'CN=mmugica,CN=Users,DC=pasaia,DC=net', 'Gizartekintza', 'Maitane Mugica Uranga', '72462227Z', 'Administrazioa eta jendaurreko zerbitzua', '["CN=SARBIDE-Sailenartekoa,CN=Users,DC=pasaia,DC=net","CN=ROL-Gizarte-Ekintza_Bulegoa,CN=Users,DC=pasaia,DC=net"]', NULL, 'EU', '0', NULL );
-- ---------------------------------------------------------


-- CREATE INDEX "IDX_6EA9A1465DA0FB8" --------------------------
CREATE INDEX `IDX_6EA9A1465DA0FB8` USING BTREE ON `calendar`( `template_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_6EA9A146A76ED395" -------------------------
CREATE INDEX `IDX_6EA9A146A76ED395` USING BTREE ON `calendar`( `user_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_D8698A767C9B02EC" -------------------------
CREATE INDEX `IDX_D8698A767C9B02EC` USING BTREE ON `document`( `eskaera_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_D8698A76A40A2C8" --------------------------
CREATE INDEX `IDX_D8698A76A40A2C8` USING BTREE ON `document`( `calendar_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_CD8C56184BEDA520" -------------------------
CREATE INDEX `IDX_CD8C56184BEDA520` USING BTREE ON `eskaera`( `sinatzaileak_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_CD8C5618A40A2C8" --------------------------
CREATE INDEX `IDX_CD8C5618A40A2C8` USING BTREE ON `eskaera`( `calendar_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_CD8C5618A76ED395" -------------------------
CREATE INDEX `IDX_CD8C5618A76ED395` USING BTREE ON `eskaera`( `user_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_CD8C5618C54C8C93" -------------------------
CREATE INDEX `IDX_CD8C5618C54C8C93` USING BTREE ON `eskaera`( `type_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_CD8C5618EA690108" -------------------------
CREATE INDEX `IDX_CD8C5618EA690108` USING BTREE ON `eskaera`( `lizentziamota_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_3BAE0AA77C9B02EC" -------------------------
CREATE INDEX `IDX_3BAE0AA77C9B02EC` USING BTREE ON `event`( `eskaera_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_3BAE0AA7A40A2C8" --------------------------
CREATE INDEX `IDX_3BAE0AA7A40A2C8` USING BTREE ON `event`( `calendar_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_3BAE0AA7C54C8C93" -------------------------
CREATE INDEX `IDX_3BAE0AA7C54C8C93` USING BTREE ON `event`( `type_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_A2EDD9E4A40A2C8" --------------------------
CREATE INDEX `IDX_A2EDD9E4A40A2C8` USING BTREE ON `event_history`( `calendar_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_A2EDD9E4C54C8C93" -------------------------
CREATE INDEX `IDX_A2EDD9E4C54C8C93` USING BTREE ON `event_history`( `type_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_2BED3563DAE9553C" -------------------------
CREATE INDEX `IDX_2BED3563DAE9553C` USING BTREE ON `firma`( `sinatzaile_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_C966B9081A0941E9" -------------------------
CREATE INDEX `IDX_C966B9081A0941E9` USING BTREE ON `firmadet`( `firmatzaile_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_C966B908505AEC11" -------------------------
CREATE INDEX `IDX_C966B908505AEC11` USING BTREE ON `firmadet`( `firma_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_C966B908A8931802" -------------------------
CREATE INDEX `IDX_C966B908A8931802` USING BTREE ON `firmadet`( `sinatzaileakdet_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_108C241A89B07103" -------------------------
CREATE INDEX `IDX_108C241A89B07103` USING BTREE ON `gutxienekoakdet`( `gutxienekoak_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_108C241AA76ED395" -------------------------
CREATE INDEX `IDX_108C241AA76ED395` USING BTREE ON `gutxienekoakdet`( `user_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_701E114EA40A2C8" --------------------------
CREATE INDEX `IDX_701E114EA40A2C8` USING BTREE ON `hour`( `calendar_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_8F3F68C571F7E88B" -------------------------
CREATE INDEX `IDX_8F3F68C571F7E88B` USING BTREE ON `log`( `event_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_8F3F68C5A40A2C8" --------------------------
CREATE INDEX `IDX_8F3F68C5A40A2C8` USING BTREE ON `log`( `calendar_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_8F3F68C5A76ED395" -------------------------
CREATE INDEX `IDX_8F3F68C5A76ED395` USING BTREE ON `log`( `user_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_BF5476CA505AEC11" -------------------------
CREATE INDEX `IDX_BF5476CA505AEC11` USING BTREE ON `notification`( `firma_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_BF5476CA7C9B02EC" -------------------------
CREATE INDEX `IDX_BF5476CA7C9B02EC` USING BTREE ON `notification`( `eskaera_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_BF5476CAA76ED395" -------------------------
CREATE INDEX `IDX_BF5476CAA76ED395` USING BTREE ON `notification`( `user_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_D2D1F0394BEDA520" -------------------------
CREATE INDEX `IDX_D2D1F0394BEDA520` USING BTREE ON `sinatzaileakdet`( `sinatzaileak_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_D2D1F039A76ED395" -------------------------
CREATE INDEX `IDX_D2D1F039A76ED395` USING BTREE ON `sinatzaileakdet`( `user_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_878D9685DA0FB8" ---------------------------
CREATE INDEX `IDX_878D9685DA0FB8` USING BTREE ON `template_event`( `template_id` );
-- -------------------------------------------------------------


-- CREATE INDEX "IDX_878D968C54C8C93" --------------------------
CREATE INDEX `IDX_878D968C54C8C93` USING BTREE ON `template_event`( `type_id` );
-- -------------------------------------------------------------


-- CREATE LINK "FK_6EA9A1465DA0FB8" ----------------------------
ALTER TABLE `calendar`
	ADD CONSTRAINT `FK_6EA9A1465DA0FB8` FOREIGN KEY ( `template_id` )
	REFERENCES `template`( `id` )
	ON DELETE Set NULL
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_6EA9A146A76ED395" ---------------------------
ALTER TABLE `calendar`
	ADD CONSTRAINT `FK_6EA9A146A76ED395` FOREIGN KEY ( `user_id` )
	REFERENCES `user`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_D8698A767C9B02EC" ---------------------------
ALTER TABLE `document`
	ADD CONSTRAINT `FK_D8698A767C9B02EC` FOREIGN KEY ( `eskaera_id` )
	REFERENCES `eskaera`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_D8698A76A40A2C8" ----------------------------
ALTER TABLE `document`
	ADD CONSTRAINT `FK_D8698A76A40A2C8` FOREIGN KEY ( `calendar_id` )
	REFERENCES `calendar`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_CD8C56184BEDA520" ---------------------------
ALTER TABLE `eskaera`
	ADD CONSTRAINT `FK_CD8C56184BEDA520` FOREIGN KEY ( `sinatzaileak_id` )
	REFERENCES `sinatzaileak`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_CD8C5618A40A2C8" ----------------------------
ALTER TABLE `eskaera`
	ADD CONSTRAINT `FK_CD8C5618A40A2C8` FOREIGN KEY ( `calendar_id` )
	REFERENCES `calendar`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_CD8C5618A76ED395" ---------------------------
ALTER TABLE `eskaera`
	ADD CONSTRAINT `FK_CD8C5618A76ED395` FOREIGN KEY ( `user_id` )
	REFERENCES `user`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_CD8C5618C54C8C93" ---------------------------
ALTER TABLE `eskaera`
	ADD CONSTRAINT `FK_CD8C5618C54C8C93` FOREIGN KEY ( `type_id` )
	REFERENCES `type`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_CD8C5618EA690108" ---------------------------
ALTER TABLE `eskaera`
	ADD CONSTRAINT `FK_CD8C5618EA690108` FOREIGN KEY ( `lizentziamota_id` )
	REFERENCES `lizentziamota`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_3BAE0AA77C9B02EC" ---------------------------
ALTER TABLE `event`
	ADD CONSTRAINT `FK_3BAE0AA77C9B02EC` FOREIGN KEY ( `eskaera_id` )
	REFERENCES `eskaera`( `id` )
	ON DELETE Cascade
	ON UPDATE Restrict;
-- -------------------------------------------------------------


-- CREATE LINK "FK_3BAE0AA7A40A2C8" ----------------------------
ALTER TABLE `event`
	ADD CONSTRAINT `FK_3BAE0AA7A40A2C8` FOREIGN KEY ( `calendar_id` )
	REFERENCES `calendar`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_3BAE0AA7C54C8C93" ---------------------------
ALTER TABLE `event`
	ADD CONSTRAINT `FK_3BAE0AA7C54C8C93` FOREIGN KEY ( `type_id` )
	REFERENCES `type`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_A2EDD9E4A40A2C8" ----------------------------
ALTER TABLE `event_history`
	ADD CONSTRAINT `FK_A2EDD9E4A40A2C8` FOREIGN KEY ( `calendar_id` )
	REFERENCES `calendar`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_A2EDD9E4C54C8C93" ---------------------------
ALTER TABLE `event_history`
	ADD CONSTRAINT `FK_A2EDD9E4C54C8C93` FOREIGN KEY ( `type_id` )
	REFERENCES `type`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_2BED35637C9B02EC" ---------------------------
ALTER TABLE `firma`
	ADD CONSTRAINT `FK_2BED35637C9B02EC` FOREIGN KEY ( `eskaera_id` )
	REFERENCES `eskaera`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_2BED3563DAE9553C" ---------------------------
ALTER TABLE `firma`
	ADD CONSTRAINT `FK_2BED3563DAE9553C` FOREIGN KEY ( `sinatzaile_id` )
	REFERENCES `sinatzaileak`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_C966B9081A0941E9" ---------------------------
ALTER TABLE `firmadet`
	ADD CONSTRAINT `FK_C966B9081A0941E9` FOREIGN KEY ( `firmatzaile_id` )
	REFERENCES `user`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_C966B908505AEC11" ---------------------------
ALTER TABLE `firmadet`
	ADD CONSTRAINT `FK_C966B908505AEC11` FOREIGN KEY ( `firma_id` )
	REFERENCES `firma`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_C966B908A8931802" ---------------------------
ALTER TABLE `firmadet`
	ADD CONSTRAINT `FK_C966B908A8931802` FOREIGN KEY ( `sinatzaileakdet_id` )
	REFERENCES `sinatzaileakdet`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_108C241A89B07103" ---------------------------
ALTER TABLE `gutxienekoakdet`
	ADD CONSTRAINT `FK_108C241A89B07103` FOREIGN KEY ( `gutxienekoak_id` )
	REFERENCES `gutxienekoak`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_108C241AA76ED395" ---------------------------
ALTER TABLE `gutxienekoakdet`
	ADD CONSTRAINT `FK_108C241AA76ED395` FOREIGN KEY ( `user_id` )
	REFERENCES `user`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_701E114EA40A2C8" ----------------------------
ALTER TABLE `hour`
	ADD CONSTRAINT `FK_701E114EA40A2C8` FOREIGN KEY ( `calendar_id` )
	REFERENCES `calendar`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_8F3F68C571F7E88B" ---------------------------
ALTER TABLE `log`
	ADD CONSTRAINT `FK_8F3F68C571F7E88B` FOREIGN KEY ( `event_id` )
	REFERENCES `event`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_8F3F68C5A40A2C8" ----------------------------
ALTER TABLE `log`
	ADD CONSTRAINT `FK_8F3F68C5A40A2C8` FOREIGN KEY ( `calendar_id` )
	REFERENCES `calendar`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_8F3F68C5A76ED395" ---------------------------
ALTER TABLE `log`
	ADD CONSTRAINT `FK_8F3F68C5A76ED395` FOREIGN KEY ( `user_id` )
	REFERENCES `user`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_BF5476CA505AEC11" ---------------------------
ALTER TABLE `notification`
	ADD CONSTRAINT `FK_BF5476CA505AEC11` FOREIGN KEY ( `firma_id` )
	REFERENCES `firma`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_BF5476CA7C9B02EC" ---------------------------
ALTER TABLE `notification`
	ADD CONSTRAINT `FK_BF5476CA7C9B02EC` FOREIGN KEY ( `eskaera_id` )
	REFERENCES `eskaera`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_BF5476CAA76ED395" ---------------------------
ALTER TABLE `notification`
	ADD CONSTRAINT `FK_BF5476CAA76ED395` FOREIGN KEY ( `user_id` )
	REFERENCES `user`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_D2D1F0394BEDA520" ---------------------------
ALTER TABLE `sinatzaileakdet`
	ADD CONSTRAINT `FK_D2D1F0394BEDA520` FOREIGN KEY ( `sinatzaileak_id` )
	REFERENCES `sinatzaileak`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_D2D1F039A76ED395" ---------------------------
ALTER TABLE `sinatzaileakdet`
	ADD CONSTRAINT `FK_D2D1F039A76ED395` FOREIGN KEY ( `user_id` )
	REFERENCES `user`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_878D9685DA0FB8" -----------------------------
ALTER TABLE `template_event`
	ADD CONSTRAINT `FK_878D9685DA0FB8` FOREIGN KEY ( `template_id` )
	REFERENCES `template`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


-- CREATE LINK "FK_878D968C54C8C93" ----------------------------
ALTER TABLE `template_event`
	ADD CONSTRAINT `FK_878D968C54C8C93` FOREIGN KEY ( `type_id` )
	REFERENCES `type`( `id` )
	ON DELETE Cascade
	ON UPDATE No Action;
-- -------------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


