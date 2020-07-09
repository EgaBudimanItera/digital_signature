/*
SQLyog Enterprise - MySQL GUI v7.14 
MySQL - 5.6.25 : Database - db_digital_signature
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

USE `db_digital_signature`;

/*Table structure for table `tb_peserta` */

DROP TABLE IF EXISTS `tb_peserta`;

CREATE TABLE `tb_peserta` (
  `id_peserta` int(11) NOT NULL AUTO_INCREMENT,
  `id_trans` int(11) DEFAULT NULL,
  `nama_peserta` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_peserta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_peserta` */

/*Table structure for table `tb_secret` */

DROP TABLE IF EXISTS `tb_secret`;

CREATE TABLE `tb_secret` (
  `secret_key` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_secret` */

insert  into `tb_secret`(`secret_key`) values ('!Ter4OK3.t1Kjug4l4H87ujUyT78U9809II.!!');

/*Table structure for table `tb_trans_signature` */

DROP TABLE IF EXISTS `tb_trans_signature`;

CREATE TABLE `tb_trans_signature` (
  `id_trans` varchar(12) NOT NULL,
  `nama_dokumen` varchar(100) DEFAULT NULL,
  `web_download` text,
  `tanggal_kegiatan` date DEFAULT NULL,
  `template` enum('1','2','3') DEFAULT NULL,
  `no_sertifikat` varchar(100) DEFAULT NULL,
  `file_upload` text,
  PRIMARY KEY (`id_trans`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_trans_signature` */

insert  into `tb_trans_signature`(`id_trans`,`nama_dokumen`,`web_download`,`tanggal_kegiatan`,`template`,`no_sertifikat`,`file_upload`) values ('FD0001072020','as',NULL,'2020-07-08',NULL,'123/kghg/2020','FD0001072020.pdf'),('FD0002072020','as',NULL,'2020-07-08',NULL,'123/kghg/2020','FD0002072020.pdf');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
