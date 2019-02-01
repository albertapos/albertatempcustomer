-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: localhost    Database: myposdata
-- ------------------------------------------------------
-- Server version	5.7.15-log

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
-- Table structure for table `agreement`
--

DROP TABLE IF EXISTS `agreement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agreement` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `SID` int(11) DEFAULT '0',
  `agreementdatetime` datetime DEFAULT NULL,
  `content` blob,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detail_trans_table`
--

DROP TABLE IF EXISTS `detail_trans_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_trans_table` (
  `DetailTransId` int(11) NOT NULL AUTO_INCREMENT,
  `TransId` int(11) NOT NULL,
  `ItemId` int(11) NOT NULL,
  `SubItemId` int(11) NOT NULL,
  `PrintSeq` int(11) NOT NULL,
  `MoreLessAction` varchar(16) NOT NULL,
  `Price` decimal(11,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`DetailTransId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `itemgroup`
--

DROP TABLE IF EXISTS `itemgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemgroup` (
  `iitemgroupid` int(11) NOT NULL AUTO_INCREMENT,
  `vitemgroupname` varchar(100) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `slicetype` VARCHAR(25) NULL DEFAULT 'ByPrice',
  PRIMARY KEY (`iitemgroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=208 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `itemgroupdetail`
--

DROP TABLE IF EXISTS `itemgroupdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemgroupdetail` (
  `iitemgroupid` int(11) DEFAULT NULL,
  `vsku` varchar(100) DEFAULT NULL,
  `isequence` int(11) DEFAULT '0',
  `vtype` varchar(25) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  KEY `idx_itemgroupdetailitemgroupid` (`iitemgroupid`),
  KEY `idx_itemgroup_vsku` (`vsku`)
) ENGINE=MyISAM AUTO_INCREMENT=03067 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_category`
--

DROP TABLE IF EXISTS `kiosk_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_category` (
  `CategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `MenuId` int(11) NOT NULL,
  `Category` varchar(32) NOT NULL,
  `Sequence` int(11) NOT NULL,
  `ImageLoc` longblob DEFAULT NULL,
  `StartEndTime` time NOT NULL,
  `Status` varchar(8) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `RowSize` int(11) DEFAULT NULL,
  `ColumnSize` int(11) DEFAULT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_default_ingredients`
--

DROP TABLE IF EXISTS `kiosk_default_ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_default_ingredients` (
  `IngredientId` int(11) NOT NULL AUTO_INCREMENT,
  `ItemId` int(11) NOT NULL,
  `SubItemId` int(11) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`IngredientId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_default_ingredients`
--

DROP TABLE IF EXISTS `kiosk_deli_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_deli_order` (
  `DeliOrderId` INT NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_global_param`
--

DROP TABLE IF EXISTS `kiosk_global_param`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_global_param` (
  `UId` int(11) NOT NULL AUTO_INCREMENT,
  `ParameterName` varchar(255) NOT NULL,
  `ParameterValue` varchar(255) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '1000',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_menu_header`
--

DROP TABLE IF EXISTS `kiosk_menu_header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_menu_header` (
  `MenuId` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(32) NOT NULL,
  `StartTime` time NOT NULL,
  `ImageLoc` longblob DEFAULT NULL,
  `Status` varchar(8) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `EndTime` time DEFAULT NULL,
  `RowSize` int(11) DEFAULT NULL,
  `ColumnSize` int(11) DEFAULT NULL,
  `Sequence` int(11) DEFAULT NULL,
  PRIMARY KEY (`MenuId`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_menu_item`
--

DROP TABLE IF EXISTS `kiosk_menu_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_menu_item` (
  `MenuDetailId` int(11) NOT NULL AUTO_INCREMENT,
  `MenuId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `iitemid` int(11) NOT NULL,
  `DisplayPosition` int(11) NOT NULL,
  `Price` decimal(11,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`MenuDetailId`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_menu_item_options`
--

DROP TABLE IF EXISTS `kiosk_menu_item_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_menu_item_options` (
  `iitemId` int(10) DEFAULT NULL,
  `OptionName` varchar(50) DEFAULT NULL,
  `OptionPrice` decimal(10,2) DEFAULT NULL,
  `IsDefault` int(2) DEFAULT NULL,
  `SID` int(11) NOT NULL DEFAULT '1000',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_page_flow_detail`
--

DROP TABLE IF EXISTS `kiosk_page_flow_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_page_flow_detail` (
  `PageDetailId` int(11) NOT NULL AUTO_INCREMENT,
  `PageId` int(11) NOT NULL,
  `iitemid` int(11) NOT NULL,
  `DisplaySeq` int(11) NOT NULL,
  `MoreLessAction` varchar(8) NOT NULL,
  `RealItem` varchar(8) NOT NULL,
  `Price` decimal(11,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PageDetailId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_page_flow_header`
--

DROP TABLE IF EXISTS `kiosk_page_flow_header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_page_flow_header` (
  `PageFlowHeaderId` int(11) NOT NULL AUTO_INCREMENT,
  `PageId` int(11) NOT NULL,
  `ReceiptPrintSeq` int(11) NOT NULL,
  `MenuDetailId` int(11) NOT NULL,
  `PrevPage` int(11) NOT NULL,
  `Action` varchar(16) NOT NULL,
  `NextPage` int(11) NOT NULL,
  `FreeTopingsCt` int(11) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PageFlowHeaderId`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_page_master`
--

DROP TABLE IF EXISTS `kiosk_page_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_page_master` (
  `PageId` int(11) NOT NULL AUTO_INCREMENT,
  `InternalTitle` varchar(50) NOT NULL,
  `DisplayTitle` varchar(50) NOT NULL,
  `RowSize` int(11) NOT NULL DEFAULT '0',
  `ColumnSize` int(11) NOT NULL DEFAULT '0',
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PageId`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kiosk_trn_order`
--

DROP TABLE IF EXISTS `kiosk_trn_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kiosk_trn_order` (
  `OrderId` int(11) NOT NULL AUTO_INCREMENT,
  `Quantity` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '1000',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`OrderId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_adjustmentreason`
--

DROP TABLE IF EXISTS `mst_adjustmentreason`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_adjustmentreason` (
  `ireasonid` int(11) NOT NULL AUTO_INCREMENT,
  `vreasoncode` varchar(50) DEFAULT NULL,
  `vreasonename` varchar(50) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ireasonid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_ageverification`
--

DROP TABLE IF EXISTS `mst_ageverification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_ageverification` (
  `vname` varchar(50) DEFAULT NULL,
  `vvalue` varchar(50) DEFAULT NULL,
  `etransferstatus` varchar(100) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_aisle`
--

DROP TABLE IF EXISTS `mst_aisle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_aisle` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `aislename` varchar(45) DEFAULT NULL,
  `SID` int(11) DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_category`
--

DROP TABLE IF EXISTS `mst_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_category` (
  `icategoryid` int(11) NOT NULL AUTO_INCREMENT,
  `vcategorycode` varchar(20) DEFAULT NULL,
  `vcategoryname` varchar(50) NOT NULL,
  `vdescription` varchar(100) DEFAULT NULL,
  `vcategorttype` varchar(50) DEFAULT NULL,
  `isequence` int(11) DEFAULT NULL,
  `estatus` varchar(10) NOT NULL,
  `ionupload` smallint(6) DEFAULT '0',
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`icategoryid`),
  KEY `idx_category_vcategoryname` (`vcategoryname`),
  KEY `idx_category_vcategorycode` (`vcategorycode`)
) ENGINE=MyISAM AUTO_INCREMENT=181 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_coupon`
--

DROP TABLE IF EXISTS `mst_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_coupon` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CouponCode` int(11) DEFAULT '0',
  `CouponAmount` decimal(15,2) DEFAULT '0.00',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_customer`
--

DROP TABLE IF EXISTS `mst_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_customer` (
  `icustomerid` int(11) NOT NULL AUTO_INCREMENT,
  `vfname` varchar(25) DEFAULT NULL,
  `vlname` varchar(25) DEFAULT NULL,
  `vaddress1` varchar(100) DEFAULT NULL,
  `vcity` varchar(20) DEFAULT NULL,
  `vstate` varchar(20) DEFAULT NULL,
  `vzip` varchar(10) DEFAULT NULL,
  `vcountry` varchar(20) DEFAULT NULL,
  `vphone` varchar(20) DEFAULT NULL,
  `vemail` varchar(100) DEFAULT NULL,
  `vaccountnumber` varchar(50) DEFAULT NULL,
  `estatus` varchar(10) NOT NULL,
  `vcustomername` varchar(50) DEFAULT NULL,
  `ntaxexemption` varchar(15) DEFAULT NULL,
  `vtaxable` varchar(5) DEFAULT 'No',
  `ncustbalance` decimal(15,2) DEFAULT '0.00',
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `pricelevel` int(11) DEFAULT '0',
  `debitlimit` DECIMAL(15,2) NULL DEFAULT 0,
  `creditday` INT(11) NULL DEFAULT 0,
  `note` TEXT NULL,
  PRIMARY KEY (`icustomerid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_delete_table`
--

DROP TABLE IF EXISTS `mst_delete_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_delete_table` (
  `Id` int(10) NOT NULL  AUTO_INCREMENT,
  `TableName` varchar(255) NOT NULL,
  `TableId` int(10) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_deleteditem`
--

DROP TABLE IF EXISTS `mst_deleteditem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_deleteditem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` varchar(45) DEFAULT NULL,
  `itemname` varchar(100) DEFAULT NULL,
  `qty` int(11) DEFAULT '0',
  `unitprice` decimal(18,2) DEFAULT '0.00',
  `extprice` decimal(18,2) DEFAULT '0.00',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) DEFAULT '0',
  `batchid` bigint(30) DEFAULT NULL,
  `userid` INT(11) NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_department`
--

DROP TABLE IF EXISTS `mst_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_department` (
  `idepartmentid` int(11) NOT NULL AUTO_INCREMENT,
  `vdepcode` varchar(20) DEFAULT NULL,
  `vdepartmentname` varchar(50) NOT NULL,
  `vdescription` varchar(100) DEFAULT NULL,
  `isequence` int(11) NOT NULL,
  `estatus` varchar(10) NOT NULL,
  `ionupload` smallint(6) DEFAULT '0',
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `starttime` TIME NULL,
  `endtime` TIME NULL,
  PRIMARY KEY (`idepartmentid`),
  KEY `idx_department_vdepartment` (`vdepartmentname`),
  KEY `idx_department_vdepcode` (`vdepcode`)
) ENGINE=MyISAM AUTO_INCREMENT=241 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_discount`
--

DROP TABLE IF EXISTS `mst_discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_discount` (
  `idiscountid` int(11) NOT NULL AUTO_INCREMENT,
  `vdescription` varchar(150) DEFAULT NULL,
  `npervalue` float(4,0) DEFAULT '0',
  `estatus` varchar(10) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idiscountid`)
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_dispalyimagevedio`
--

DROP TABLE IF EXISTS `mst_dispalyimagevedio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_dispalyimagevedio` (
  `iimageid` int(11) NOT NULL AUTO_INCREMENT,
  `vprofilename` varchar(50) DEFAULT NULL,
  `vterminalid` varchar(50) DEFAULT NULL,
  `vpath` varchar(100) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iimageid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_groupslabprice`
--

DROP TABLE IF EXISTS `mst_groupslabprice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_groupslabprice` (
  `igroupslabid` int(11) NOT NULL AUTO_INCREMENT,
  `iitemgroupid` int(11) DEFAULT NULL,
  `iqty` int(11) DEFAULT '0',
  `nunitprice` decimal(15,2) DEFAULT '0.00',
  `nprice` decimal(15,2) DEFAULT '0.00',
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `percentage` DECIMAL(15,2) NULL DEFAULT '0',
  `startdate` DATETIME NULL DEFAULT NULL,
  `enddate` DATETIME NULL DEFAULT NULL,
  `status` INT NULL DEFAULT '0',
  PRIMARY KEY (`igroupslabid`),
  KEY `idx_mst_groupslabid` (`igroupslabid`),
  KEY `idx_mst_groupslabpricegroupid` (`iitemgroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_holditem`
--

DROP TABLE IF EXISTS `mst_holditem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_holditem` (
  `iholdid` bigint(30) NOT NULL,
  `icustomerid` int(11) DEFAULT NULL,
  `idiscountid` decimal(15,2) DEFAULT NULL,
  `dorderdate` timestamp NULL DEFAULT NULL,
  `vterminalid` varchar(20) DEFAULT NULL,
  `vdiscountname` varchar(30) DEFAULT 'Percentage',
  `isalesid` int(11) DEFAULT NULL,
  `vtablename` varchar(50) DEFAULT NULL,
  `vholdname` varchar(50) DEFAULT NULL,
  `vtransfer` varchar(10) DEFAULT 'No',
  `vholdtrntype` varchar(10) DEFAULT 'Hold',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iholdid`),
  KEY `idx_mst_holditem_dorderdate` (`dorderdate`),
  KEY `idx_mst_holditem_iholdid` (`iholdid`),
  KEY `idx_mst_holditem_isalesid` (`isalesid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_instantbook`
--

DROP TABLE IF EXISTS `mst_instantbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_instantbook` (
  `ibookid` int(11) NOT NULL AUTO_INCREMENT,
  `vbookcode` varchar(30) DEFAULT NULL,
  `vgamecode` varchar(30) DEFAULT NULL,
  `islotnumber` int(11) DEFAULT NULL,
  `iticketstartnumber` int(11) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `dinsertdate` date DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ibookid`),
  KEY `idx_mst_instantbook` (`vbookcode`,`vgamecode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_instantgame`
--

DROP TABLE IF EXISTS `mst_instantgame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_instantgame` (
  `igameid` int(11) NOT NULL AUTO_INCREMENT,
  `vgamecode` varchar(30) DEFAULT NULL,
  `vgamename` varchar(150) DEFAULT NULL,
  `nticketamount` decimal(15,2) DEFAULT NULL,
  `istartnumber` int(11) DEFAULT NULL,
  `iendnumber` int(11) DEFAULT NULL,
  `nbookvalue` decimal(15,2) DEFAULT NULL,
  `ireorderpoint` int(11) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `dexpiredate` date DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`igameid`),
  KEY `idx_mst_instantgame` (`vgamecode`)
) ENGINE=MyISAM AUTO_INCREMENT=233 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_instantgameslot`
--

DROP TABLE IF EXISTS `mst_instantgameslot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_instantgameslot` (
  `igameid` int(11) DEFAULT NULL,
  `islotid` int(11) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_instantsettings`
--

DROP TABLE IF EXISTS `mst_instantsettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_instantsettings` (
  `vilsettingname` varchar(100) DEFAULT NULL,
  `vilsettingvalue` varchar(100) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_instantslot`
--

DROP TABLE IF EXISTS `mst_instantslot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_instantslot` (
  `islotid` int(11) NOT NULL AUTO_INCREMENT,
  `islotnumber` int(11) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`islotid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_item`
--

DROP TABLE IF EXISTS `mst_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_item` (
  `iitemid` int(11) NOT NULL AUTO_INCREMENT,
  `webstore` varchar(10) NOT NULL DEFAULT '0',
  `vitemtype` varchar(10) NOT NULL,
  `vitemcode` varchar(50) DEFAULT NULL,
  `vitemname` varchar(100) NOT NULL,
  `vunitcode` varchar(20) DEFAULT NULL,
  `vbarcode` varchar(50) NOT NULL,
  `vpricetype` varchar(50) DEFAULT NULL,
  `vcategorycode` varchar(20) NOT NULL,
  `vdepcode` varchar(20) DEFAULT NULL,
  `vsuppliercode` varchar(20) DEFAULT NULL,
  `iqtyonhand` int(11) DEFAULT '0',
  `ireorderpoint` int(11) DEFAULT '0',
  `dcostprice` decimal(15,4) DEFAULT '0.0000',
  `dunitprice` decimal(15,2) DEFAULT '0.00',
  `nsaleprice` decimal(15,4) DEFAULT '0.0000',
  `nlevel2` decimal(15,2) DEFAULT '0.00',
  `nlevel3` decimal(15,2) DEFAULT '0.00',
  `nlevel4` decimal(15,2) DEFAULT '0.00',
  `iquantity` int(11) DEFAULT '0',
  `ndiscountper` decimal(10,2) DEFAULT '0.00',
  `ndiscountamt` decimal(15,2) DEFAULT '0.00',
  `vtax1` varchar(2) DEFAULT NULL,
  `vtax2` varchar(2) DEFAULT NULL,
  `vfooditem` varchar(2) DEFAULT NULL,
  `vdescription` varchar(100) DEFAULT NULL,
  `dlastsold` date DEFAULT NULL,
  `visinventory` varchar(10) DEFAULT 'No',
  `dpricestartdatetime` timestamp NULL DEFAULT NULL,
  `dpriceenddatetime` timestamp NULL DEFAULT NULL,
  `estatus` varchar(10) NOT NULL,
  `nbuyqty` int(11) DEFAULT '0',
  `ndiscountqty` int(11) DEFAULT '0',
  `nsalediscountper` decimal(15,2) DEFAULT NULL,
  `vshowimage` varchar(10) DEFAULT 'No',
  `itemimage` longblob,
  `vageverify` varchar(10) DEFAULT NULL,
  `ebottledeposit` varchar(5) DEFAULT NULL,
  `nbottledepositamt` decimal(10,2) DEFAULT NULL,
  `vbarcodetype` varchar(25) DEFAULT 'Code 128',
  `ntareweight` decimal(15,2) DEFAULT '0.00',
  `ntareweightper` decimal(15,2) DEFAULT '0.00',
  `dcreated` date DEFAULT NULL,
  `dlastupdated` date DEFAULT NULL,
  `dlastreceived` date DEFAULT NULL,
  `dlastordered` date DEFAULT NULL,
  `nlastcost` decimal(15,2) DEFAULT '0.00',
  `nonorderqty` int(11) DEFAULT '0',
  `vparentitem` varchar(50) DEFAULT '0',
  `nchildqty` decimal(15,2) DEFAULT '0.00',
  `vsize` varchar(50) DEFAULT NULL,
  `npack` int(11) DEFAULT '1',
  `nunitcost` decimal(15,4) DEFAULT '0.0000',
  `ionupload` smallint(6) DEFAULT '0',
  `nsellunit` int(11) DEFAULT '1',
  `ilotterystartnum` int(11) DEFAULT '0',
  `ilotteryendnum` int(11) DEFAULT '0',
  `etransferstatus` varchar(201) DEFAULT NULL,
  `vsequence` varchar(25) DEFAULT '0',
  `vcolorcode` varchar(25) DEFAULT 'None',
  `vdiscount` varchar(5) DEFAULT 'Yes',
  `norderqtyupto` int(11) DEFAULT '0',
  `vshowsalesinzreport` varchar(10) DEFAULT 'No',
  `iinvtdefaultunit` smallint(6) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `stationid` int(11) DEFAULT '0',
  `shelfid` int(11) DEFAULT '0',
  `aisleid` int(11) DEFAULT '0',
  `shelvingid` int(11) DEFAULT '0',
  `rating` varchar(45) DEFAULT NULL,
  `vintage` varchar(45) DEFAULT NULL,
  `PrinterStationId` int(11) DEFAULT NULL,
  `liability` varchar(5) DEFAULT 'N',
  `isparentchild` INT(11) NULL DEFAULT '0',
  `parentid` INT(11) NULL DEFAULT '0',
  `parentmasterid` INT(11) NULL DEFAULT '0',
  `wicitem` INT(1) NULL DEFAULT '0',
  PRIMARY KEY (`iitemid`),
  UNIQUE KEY `vbarcode_UNIQUE` (`vbarcode`),
  KEY `idx_item_vbarcode` (`vbarcode`),
  KEY `idx_item_vcategorycode` (`vcategorycode`),
  KEY `idx_item_vitecode` (`vitemcode`),
  KEY `idx_item_vitemname` (`vitemname`),
  KEY `idx_item_vitemtype` (`vitemtype`),
  KEY `idx_item_vsuppliercode` (`vsuppliercode`),
  KEY `idx_item_vdepcode` (`vdepcode`),
  KEY `idx_item_vunitcode` (`vunitcode`),
  KEY `idx_item_iitemid` (`iitemid`),
  KEY `idx_item_visinventory` (`visinventory`),
  KEY `idx_item_parentmasterid` (`parentmasterid`),
  KEY `idx_item_parentid` (`parentid`)
) ENGINE=MyISAM AUTO_INCREMENT=19672 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_item_bucket`
--

DROP TABLE IF EXISTS `mst_item_bucket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_item_bucket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bucket_name` varchar(255) DEFAULT NULL,
  `SID` int(11) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_item_size`
--

DROP TABLE IF EXISTS `mst_item_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_item_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_value` varchar(250) NOT NULL,
  `SID` int(11) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_item_unit`
--

DROP TABLE IF EXISTS `mst_item_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_item_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(255) DEFAULT NULL,
  `SID` int(11) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_itemalias`
--

DROP TABLE IF EXISTS `mst_itemalias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_itemalias` (
  `iitemaliasid` int(11) NOT NULL AUTO_INCREMENT,
  `vitemcode` varchar(50) DEFAULT NULL,
  `vsku` varchar(50) DEFAULT NULL,
  `valiassku` varchar(50) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iitemaliasid`),
  KEY `idx_mst_itemalias_vsku` (`vsku`),
  KEY `idx_mst_itemalias_valiasski` (`valiassku`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_itemgroup`
--

DROP TABLE IF EXISTS `mst_itemgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_itemgroup` (
  `iitemgroupid` int(11) NOT NULL AUTO_INCREMENT,
  `vgroupcode` varchar(20) DEFAULT NULL,
  `vitemgroupname` varchar(50) NOT NULL,
  `vterminalid` varchar(50) DEFAULT NULL,
  `estatus` varchar(10) NOT NULL,
  `isequence` int(11) DEFAULT '0',
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iitemgroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_itemkit`
--

DROP TABLE IF EXISTS `mst_itemkit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_itemkit` (
  `iitemkitid` int(11) NOT NULL AUTO_INCREMENT,
  `vpitemcode` varchar(20) NOT NULL,
  `vitemcode` varchar(50) NOT NULL,
  `vitemname` varchar(200) NOT NULL,
  `nquantity2` decimal(10,2) NOT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iitemkitid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_itemlotmatrix`
--

DROP TABLE IF EXISTS `mst_itemlotmatrix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_itemlotmatrix` (
  `iitemid` int(11) DEFAULT NULL,
  `vsku` varchar(50) DEFAULT NULL,
  `vlotmatrixname` varchar(50) DEFAULT NULL,
  `vlotmatrixsku` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_itemmatrix`
--

DROP TABLE IF EXISTS `mst_itemmatrix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_itemmatrix` (
  `iitemmatrixid` int(11) NOT NULL AUTO_INCREMENT,
  `vitemcode` varchar(50) NOT NULL,
  `vcolor` varchar(20) NOT NULL,
  `vsize` varchar(20) NOT NULL,
  `nqty` decimal(15,2) NOT NULL,
  `nprice` decimal(10,2) NOT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iitemmatrixid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_itempackdetail`
--

DROP TABLE IF EXISTS `mst_itempackdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_itempackdetail` (
  `iitemid` int(11) DEFAULT NULL,
  `vbarcode` varchar(50) DEFAULT NULL,
  `ipack` int(11) DEFAULT '0',
  `vpackname` varchar(30) DEFAULT NULL,
  `npackprice` decimal(15,2) DEFAULT '0.00',
  `npackcost` decimal(15,4) DEFAULT '0.0000',
  `npackmargin` decimal(15,2) DEFAULT '0.00',
  `idetid` int(11) NOT NULL AUTO_INCREMENT,
  `iparentid` int(11) DEFAULT '0',
  `nunitcost` decimal(15,4) DEFAULT '0.0000',
  `isequence` int(11) DEFAULT '0',
  `vdesc` varchar(50) DEFAULT NULL,
  `nsaleprice` decimal(15,2) DEFAULT '0.00',
  `nsalediscountper` decimal(15,2) DEFAULT '0.00',
  `vpricetype` varchar(10) DEFAULT NULL,
  `dpricestartdatetime` timestamp NULL DEFAULT NULL,
  `dpriceenddatetime` timestamp NULL DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idetid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_itemslabprice`
--

DROP TABLE IF EXISTS `mst_itemslabprice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_itemslabprice` (
  `vsku` varchar(50) DEFAULT NULL,
  `iitemgroupid` int(11) DEFAULT NULL,
  `iqty` int(11) DEFAULT '0',
  `nunitprice` decimal(15,2) DEFAULT '0.00',
  `nprice` decimal(15,2) DEFAULT '0.00',
  `islabid` int(11) NOT NULL AUTO_INCREMENT,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`islabid`),
  KEY `idx_mst_itemslabpricesku` (`vsku`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_itemvendor`
--

DROP TABLE IF EXISTS `mst_itemvendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_itemvendor` (
  `iitemid` int(11) DEFAULT NULL,
  `ivendorid` int(11) DEFAULT NULL,
  `vvendoritemcode` varchar(100) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  KEY `idx_itemvendor_iitemid` (`iitemid`),
  KEY `idx_itemvendor_vvendoritemcode` (`vvendoritemcode`),
  KEY `idx_itemvendor_ivendorid` (`ivendorid`)
) ENGINE=MyISAM AUTO_INCREMENT=24219 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_location`
--

DROP TABLE IF EXISTS `mst_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_location` (
  `ilocid` int(11) NOT NULL AUTO_INCREMENT,
  `vlocname` varchar(50) DEFAULT NULL,
  `vlocdesc` varchar(100) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ilocid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_missingitem`
--

DROP TABLE IF EXISTS `mst_missingitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_missingitem` (
  `imitemid` int(11) NOT NULL AUTO_INCREMENT,
  `iinvoiceid` int(11) DEFAULT NULL,
  `vbarcode` varchar(50) DEFAULT NULL,
  `vitemname` varchar(100) DEFAULT NULL,
  `vitemcode` varchar(50) DEFAULT NULL,
  `vitemtype` varchar(10) DEFAULT NULL,
  `vunitcode` varchar(10) DEFAULT NULL,
  `vtax1` varchar(10) DEFAULT NULL,
  `vcatcode` varchar(20) DEFAULT NULL,
  `vdepcode` varchar(20) DEFAULT NULL,
  `vsuppcode` varchar(20) DEFAULT NULL,
  `dunitprice` decimal(15,2) DEFAULT '0.00',
  `dcostprice` decimal(15,2) DEFAULT '0.00',
  `nunitcost` decimal(15,4) DEFAULT '0.0000',
  `nsellunit` decimal(15,2) DEFAULT '0.00',
  `npack` int(11) DEFAULT '1',
  `vvendoritemcode` varchar(10) DEFAULT NULL,
  `norderqty` int(11) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`imitemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_mpssetting`
--

DROP TABLE IF EXISTS `mst_mpssetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_mpssetting` (
  `setting_id` varchar(255) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  `register_id` int(11) DEFAULT NULL,
  `etransferstatus` varchar(25) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_paidout`
--

DROP TABLE IF EXISTS `mst_paidout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_paidout` (
  `ipaidoutid` int(11) NOT NULL AUTO_INCREMENT,
  `vpaidoutname` varchar(100) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipaidoutid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_permission`
--

DROP TABLE IF EXISTS `mst_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_permission` (
  `vpermissioncode` varchar(20) NOT NULL,
  `vpermissionname` varchar(50) NOT NULL,
  `vmenuname` varchar(20) NOT NULL,
  `vpermissiontype` varchar(20) DEFAULT NULL,
  `vppercode` varchar(20) NOT NULL,
  `ivorder` int(11) NOT NULL,
  `vdesc` varchar(100) NOT NULL,
  `etransferstatus` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  KEY `idx_mst_permission` (`vpermissioncode`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_permissiongroup`
--

DROP TABLE IF EXISTS `mst_permissiongroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_permissiongroup` (
  `ipermissiongroupid` int(11) NOT NULL AUTO_INCREMENT,
  `ipgroupid` int(11) DEFAULT NULL,
  `vgroupname` varchar(50) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `etransferstatus` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipermissiongroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_permissiongroupdetail`
--

DROP TABLE IF EXISTS `mst_permissiongroupdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_permissiongroupdetail` (
  `ipermissiongroupid` int(11) NOT NULL,
  `vpermissioncode` varchar(20) NOT NULL,
  `vtype` varchar(10) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=200 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_plcb_item`
--

DROP TABLE IF EXISTS `mst_plcb_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_plcb_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `bucket_id` int(11) NOT NULL,
  `prev_mo_beg_qty` int(11) NOT NULL,
  `prev_mo_end_qty` int(11) DEFAULT NULL,
  `malt` TINYINT NOT NULL DEFAULT  '0',
  `SID` int(11) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_plcb_item_detail`
--

DROP TABLE IF EXISTS `mst_plcb_item_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_plcb_item_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plcb_item_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `prev_mo_purchase` int(11) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_posdevice`
--

DROP TABLE IF EXISTS `mst_posdevice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_posdevice` (
  `vdevicetype` varchar(50) DEFAULT NULL,
  `vdevicename` varchar(100) DEFAULT NULL,
  `vdevicevalue` varchar(100) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_printcustomamount`
--

DROP TABLE IF EXISTS `mst_printcustomamount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_printcustomamount` (
  `iid` int(11) NOT NULL AUTO_INCREMENT,
  `vvalue` int(11) DEFAULT NULL,
  `vdescription` varchar(100) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iid`)
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_register`
--

DROP TABLE IF EXISTS `mst_register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_register` (
  `iregisterid` int(11) NOT NULL AUTO_INCREMENT,
  `istoreid` int(11) NOT NULL,
  `vregistername` varchar(50) NOT NULL,
  `vprintername` varchar(50) NOT NULL,
  `vmachineid` varchar(100) DEFAULT NULL,
  `vlocalpath` varchar(100) DEFAULT NULL,
  `vharddriveid` varchar(50) DEFAULT NULL,
  `estatus` varchar(10) NOT NULL,
  `vsequence` varchar(5) DEFAULT '0',
  `ionupload` int(11) DEFAULT '0',
  `vmacaddress` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '1000',
  `registermode` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`iregisterid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_registersettings`
--

DROP TABLE IF EXISTS `mst_registersettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_registersettings` (
  `iregisterid` int(11) DEFAULT NULL,
  `vsettingname` varchar(100) DEFAULT NULL,
  `vsettingvalue` varchar(100) DEFAULT NULL,
  `vsettingdevice` varchar(50) DEFAULT NULL,
  `etransferstatus` varchar(100) DEFAULT NULL,
  `vtransfer` varchar(5) DEFAULT 'No',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  KEY `idx_mst_registersettings_id` (`iregisterid`)
) ENGINE=MyISAM AUTO_INCREMENT=3854 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_shelf`
--

DROP TABLE IF EXISTS `mst_shelf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_shelf` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `shelfname` varchar(45) DEFAULT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_shelving`
--

DROP TABLE IF EXISTS `mst_shelving`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_shelving` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shelvingname` varchar(45) DEFAULT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_size`
--

DROP TABLE IF EXISTS `mst_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_size` (
  `isizeid` int(11) NOT NULL AUTO_INCREMENT,
  `vsize` varchar(50) DEFAULT NULL,
  `etransferstatus` varchar(100) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`isizeid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_station`
--

DROP TABLE IF EXISTS `mst_station`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_station` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `stationname` varchar(100) DEFAULT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `stationprinter` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_store`
--

DROP TABLE IF EXISTS `mst_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_store` (
  `istoreid` int(11) NOT NULL AUTO_INCREMENT,
  `vcompanycode` varchar(20) DEFAULT NULL,
  `vstorename` varchar(40) NOT NULL,
  `vstoredesc` varchar(40) DEFAULT NULL,
  `vstoreabbr` varchar(50) DEFAULT NULL,
  `vaddress1` varchar(100) DEFAULT NULL,
  `vcity` varchar(20) DEFAULT NULL,
  `vstate` varchar(20) DEFAULT NULL,
  `vzip` varchar(10) DEFAULT NULL,
  `vcountry` varchar(20) DEFAULT NULL,
  `vphone1` varchar(20) DEFAULT NULL,
  `vphone2` varchar(20) DEFAULT NULL,
  `vfax1` varchar(20) DEFAULT NULL,
  `vemail` varchar(30) DEFAULT NULL,
  `vwebsite` varchar(100) DEFAULT NULL,
  `vcontactperson` varchar(25) DEFAULT NULL,
  `isequence` int(11) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `dregdate` date DEFAULT NULL,
  `vmessage1` varchar(500) DEFAULT NULL,
  `vmessage2` varchar(500) DEFAULT NULL,
  `ionupload` smallint(6) DEFAULT '0',
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`istoreid`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_storesetting`
--

DROP TABLE IF EXISTS `mst_storesetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_storesetting` (
  `istoreid` int(11) DEFAULT NULL,
  `vsettingname` varchar(50) DEFAULT NULL,
  `vsettingvalue` varchar(500) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=570 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_supplier`
--

DROP TABLE IF EXISTS `mst_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_supplier` (
  `isupplierid` int(11) NOT NULL AUTO_INCREMENT,
  `vsuppliercode` varchar(20) DEFAULT NULL,
  `vcompanyname` varchar(50) NOT NULL,
  `vfnmae` varchar(25) DEFAULT NULL,
  `vlname` varchar(25) DEFAULT NULL,
  `vaddress1` varchar(100) DEFAULT NULL,
  `vcity` varchar(20) DEFAULT NULL,
  `vstate` varchar(20) DEFAULT NULL,
  `vzip` varchar(10) DEFAULT NULL,
  `vcountry` varchar(20) DEFAULT NULL,
  `vphone` varchar(20) DEFAULT NULL,
  `vemail` varchar(100) DEFAULT NULL,
  `estatus` varchar(10) NOT NULL,
  `vvendortype` varchar(10) DEFAULT 'Vendor',
  `vvendorterm` varchar(10) DEFAULT 'COD',
  `icreditday` int(11) DEFAULT '0',
  `vsalesperson1` varchar(50) DEFAULT NULL,
  `vsalesperson2` varchar(50) DEFAULT NULL,
  `vsalesperson3` varchar(50) DEFAULT NULL,
  `vsalesperson4` varchar(50) DEFAULT NULL,
  `vsalesperson5` varchar(50) DEFAULT NULL,
  `vsalesphone1` varchar(20) DEFAULT NULL,
  `vsalesphone2` varchar(20) DEFAULT NULL,
  `vsalesphone3` varchar(20) DEFAULT NULL,
  `vsalesphone4` varchar(20) DEFAULT NULL,
  `vsalesphone5` varchar(20) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `vcode` varchar(20) DEFAULT NULL,
  `vftpserver` varchar(200) DEFAULT NULL,
  `vftpuser` varchar(50) DEFAULT NULL,
  `vftppass` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `plcbtype` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`isupplierid`),
  KEY `mst_supplier_vsuppliecode` (`vsuppliercode`)
) ENGINE=MyISAM AUTO_INCREMENT=186 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_syncmaster`
--

DROP TABLE IF EXISTS `mst_syncmaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_syncmaster` (
  `SyncType` varchar(20) NOT NULL,
  `SourceServer` varchar(20) NOT NULL,
  `SourceDatabase` varchar(40) NOT NULL,
  `SourcePort` varchar(5) NOT NULL,
  `SourceUser` varchar(35) NOT NULL,
  `SourcePassword` varchar(75) NOT NULL,
  `TargetServer` varchar(20) NOT NULL,
  `TargetDatabase` varchar(40) NOT NULL,
  `TargetPort` varchar(5) NOT NULL,
  `TargetUser` varchar(35) NOT NULL,
  `TargetPassword` varchar(75) NOT NULL,
  `LastSyncDateTime` timestamp NULL DEFAULT NULL,
  `Status` bit(1) NOT NULL DEFAULT b'1',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TranTypeId` int(11) NOT NULL DEFAULT '0',
  `Sequence` int(11) DEFAULT '0',
  `LastUpdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` INT(11) NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Using this table our sync service will run.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_synctable`
--

DROP TABLE IF EXISTS `mst_synctable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_synctable` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TableName` varchar(150) NOT NULL,
  `Sequence` int(11) NOT NULL DEFAULT '0',
  `TranTypeId` int(11) DEFAULT '0',
  `SqlOperation` int(2) DEFAULT '0',	
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=475 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_tax`
--

DROP TABLE IF EXISTS `mst_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_tax` (
  `vtaxcode` varchar(20) NOT NULL,
  `vtaxtype` varchar(50) NOT NULL,
  `ntaxrate` decimal(10,4) NOT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_template`
--

DROP TABLE IF EXISTS `mst_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_template` (
  `itemplateid` int(11) NOT NULL AUTO_INCREMENT,
  `vtemplatename` varchar(50) DEFAULT NULL,
  `vtemplatetype` varchar(30) DEFAULT NULL,
  `vinventorytype` varchar(50) DEFAULT NULL,
  `istoreid` int(11) DEFAULT NULL,
  `isequence` int(11) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemplateid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_templatedetail`
--

DROP TABLE IF EXISTS `mst_templatedetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_templatedetail` (
  `itemplateid` int(11) DEFAULT NULL,
  `vitemcode` varchar(50) DEFAULT NULL,
  `isequence` int(11) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  KEY `idx_templatedetail_vitemcode` (`vitemcode`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_tentertype`
--

DROP TABLE IF EXISTS `mst_tentertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_tentertype` (
  `itenderid` int(11) NOT NULL AUTO_INCREMENT,
  `vtendertype` varchar(50) NOT NULL,
  `estatus` varchar(10) NOT NULL,
  `vtendertag` varchar(29) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itenderid`),
  KEY `idx_mst_tendertype_itendeird` (`itenderid`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_unit`
--

DROP TABLE IF EXISTS `mst_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_unit` (
  `iunitid` int(11) NOT NULL AUTO_INCREMENT,
  `vunitcode` varchar(20) NOT NULL,
  `vunitname` varchar(50) NOT NULL,
  `vunitdesc` varchar(100) NOT NULL,
  `estatus` varchar(10) NOT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iunitid`),
  KEY `idx_mst_unit_vunitcode` (`vunitcode`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_unitconversion`
--

DROP TABLE IF EXISTS `mst_unitconversion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_unitconversion` (
  `iunitconversionid` int(11) NOT NULL AUTO_INCREMENT,
  `vfromunitcode` varchar(20) NOT NULL,
  `vtounitcode` varchar(20) NOT NULL,
  `nconfact` decimal(10,2) NOT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iunitconversionid`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_user`
--

DROP TABLE IF EXISTS `mst_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_user` (
  `iuserid` int(11) NOT NULL AUTO_INCREMENT,
  `vfname` varchar(25) NOT NULL,
  `vlname` varchar(25) NOT NULL,
  `vaddress1` varchar(75) DEFAULT NULL,
  `vaddress2` varchar(75) DEFAULT NULL,
  `vcity` varchar(25) DEFAULT NULL,
  `vstate` varchar(25) DEFAULT NULL,
  `vzip` varchar(10) DEFAULT NULL,
  `vcountry` varchar(20) DEFAULT NULL,
  `vphone` varchar(20) DEFAULT NULL,
  `vemail` varchar(125) DEFAULT NULL,
  `vuserid` varchar(20) DEFAULT NULL,
  `vpassword` varchar(20) DEFAULT NULL,
  `vusertype` varchar(20) DEFAULT NULL,
  `vpasswordchange` varchar(5) DEFAULT NULL,
  `dfirstlogindatetime` date DEFAULT NULL,
  `dlastlogindatetime` date DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `vuserbarcode` varchar(25) DEFAULT NULL,
  `dlockoutdatetime` timestamp NULL DEFAULT NULL,
  `vlocktype` varchar(10) DEFAULT NULL,
  `etransferstatus` varchar(200) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iuserid`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_userpermissiongroup`
--

DROP TABLE IF EXISTS `mst_userpermissiongroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_userpermissiongroup` (
  `iuserid` int(11) NOT NULL,
  `ipermissiongroupid` int(11) NOT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mst_warehouse`
--

DROP TABLE IF EXISTS `mst_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_warehouse` (
  `iid` int(11) NOT NULL AUTO_INCREMENT,
  `vwhname` varchar(50) DEFAULT NULL,
  `vwhcode` varchar(10) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iid`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `poshour`
--

DROP TABLE IF EXISTS `poshour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poshour` (
  `outputstring` varchar(50) DEFAULT NULL,
  `hours` decimal(5,2) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `poshours`
--

DROP TABLE IF EXISTS `poshours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poshours` (
  `outputstring` varchar(50) DEFAULT NULL,
  `hours` int(11) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `posscreencontrol`
--

DROP TABLE IF EXISTS `posscreencontrol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posscreencontrol` (
  `controlname` varchar(75) DEFAULT NULL,
  `controltype` smallint(6) DEFAULT '1',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `posscreenresolution`
--

DROP TABLE IF EXISTS `posscreenresolution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posscreenresolution` (
  `resolutionname` varchar(50) DEFAULT NULL,
  `reswidth` int(11) DEFAULT NULL,
  `resheight` int(11) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `screenresolutiondetail`
--

DROP TABLE IF EXISTS `screenresolutiondetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `screenresolutiondetail` (
  `resid` int(11) DEFAULT NULL,
  `vname` varchar(50) DEFAULT NULL,
  `controlid` int(11) DEFAULT NULL,
  `controlvisibility` smallint(6) DEFAULT NULL,
  `controllx` int(11) DEFAULT NULL,
  `controlly` int(11) DEFAULT NULL,
  `controlwidth` int(11) DEFAULT NULL,
  `controlheight` int(11) DEFAULT NULL,
  `controlfontname` varchar(50) DEFAULT NULL,
  `controlfontsize` decimal(12,2) DEFAULT NULL,
  `controlbackcolor` varchar(25) DEFAULT NULL,
  `controlfontcolor` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=569 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_status`
--

DROP TABLE IF EXISTS `system_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_status` (
  `SystemStatusId` int(11) NOT NULL AUTO_INCREMENT,
  `SystemStatusType` varchar(45) NOT NULL,
  `SystemStatusDescription` varchar(1000) NOT NULL,
  `Active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`SystemStatusId`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tmp_priceupdate`
--

DROP TABLE IF EXISTS `tmp_priceupdate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmp_priceupdate` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `SID` int(11) NOT NULL DEFAULT '0',
  `sku` varchar(45) DEFAULT NULL,
  `noldprice` decimal(15,2) NOT NULL DEFAULT '0.00',
  `nnewprice` decimal(15,2) NOT NULL DEFAULT '0.00',
  `modifydate` datetime DEFAULT NULL,
  `status` bit(1) DEFAULT b'0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transactiontemp`
--

DROP TABLE IF EXISTS `transactiontemp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactiontemp` (
  `TransId` int(11) NOT NULL AUTO_INCREMENT,
  `ItemId` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Price` decimal(11,2) NOT NULL,
  `Amount` decimal(11,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `OrderId` int(11) DEFAULT NULL,
  PRIMARY KEY (`TransId`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_batch`
--

DROP TABLE IF EXISTS `trn_batch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_batch` (
  `ibatchid` bigint(30) NOT NULL,
  `vbatchname` varchar(50) DEFAULT NULL,
  `nnetsales` decimal(15,2) DEFAULT '0.00',
  `nnetpaidout` decimal(15,2) DEFAULT '0.00',
  `nnetcashpickup` decimal(15,2) DEFAULT '0.00',
  `estatus` varchar(10) DEFAULT NULL,
  `dbatchstarttime` timestamp NULL DEFAULT NULL,
  `dbatchendtime` timestamp NULL DEFAULT NULL,
  `vterminalid` varchar(15) DEFAULT NULL,
  `nopeningbalance` decimal(15,2) DEFAULT '0.00',
  `nclosingbalance` decimal(15,2) DEFAULT '0.00',
  `nuserclosingbalance` decimal(15,2) DEFAULT '0.00',
  `nnetaddcash` decimal(15,2) DEFAULT '0.00',
  `ntotalnontaxable` decimal(15,2) DEFAULT '0.00',
  `ntotaltaxable` decimal(15,2) DEFAULT '0.00',
  `ntotalsales` decimal(15,2) DEFAULT '0.00',
  `ntotaltax` decimal(15,2) DEFAULT '0.00',
  `ntotalcreditsales` decimal(15,2) DEFAULT '0.00',
  `ntotalcashsales` decimal(15,2) DEFAULT '0.00',
  `ntotalgiftsales` decimal(15,2) DEFAULT '0.00',
  `ntotalchecksales` decimal(15,2) DEFAULT '0.00',
  `ntotalreturns` decimal(15,2) DEFAULT '0.00',
  `ntotaldiscount` decimal(15,2) DEFAULT '0.00',
  `ntotaldebitsales` decimal(15,2) DEFAULT '0.00',
  `ntotalebtsales` decimal(15,2) DEFAULT '0.00',
  `ionupload` smallint(6) DEFAULT '0',
  `vtransfer` varchar(5) DEFAULT 'No',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `endofday` varchar(1) DEFAULT '0',
  PRIMARY KEY (`ibatchid`),
  KEY `idx_tranbatch_ibatchid` (`ibatchid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_customerpay`
--

DROP TABLE IF EXISTS `trn_customerpay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_customerpay` (
  `icpid` bigint(30) NOT NULL AUTO_INCREMENT,
  `icustomerid` int(11) DEFAULT NULL,
  `dtrandate` date NOT NULL,
  `itenderid` int(11) DEFAULT '0',
  `vchecknumber` varchar(50) DEFAULT NULL,
  `vbankname` varchar(100) DEFAULT NULL,
  `vmpstenderid` varchar(50) DEFAULT NULL,
  `vtrantype` varchar(10) DEFAULT NULL,
  `ncreditamt` decimal(15,2) DEFAULT '0.00',
  `ndebitamt` decimal(15,2) DEFAULT '0.00',
  `nbalamt` decimal(15,2) DEFAULT '0.00',
  `vtransfer` varchar(5) DEFAULT 'No',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `salesid` BIGINT(30) NULL DEFAULT 0,
  PRIMARY KEY (`icpid`),
  KEY `idx_trn_customerpay_icpid` (`icpid`,`dtrandate`,`itenderid`,`vmpstenderid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_dailysales`
--

DROP TABLE IF EXISTS `trn_dailysales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_dailysales` (
  `ddate` date DEFAULT NULL,
  `nnetsales` decimal(15,2) DEFAULT '0.00',
  `nnetpaidout` decimal(15,2) DEFAULT '0.00',
  `nnetcashpickup` decimal(15,2) DEFAULT '0.00',
  `nopeningbalance` decimal(15,2) DEFAULT '0.00',
  `nclosingbalance` decimal(15,2) DEFAULT '0.00',
  `nnetaddcash` decimal(15,2) DEFAULT '0.00',
  `ntotalnontaxable` decimal(15,2) DEFAULT '0.00',
  `ntotaltaxable` decimal(15,2) DEFAULT '0.00',
  `ntotalsales` decimal(15,2) DEFAULT '0.00',
  `ntotaltax` decimal(15,2) DEFAULT '0.00',
  `ntotalcreditsales` decimal(15,2) DEFAULT '0.00',
  `ntotalcashsales` decimal(15,2) DEFAULT '0.00',
  `ntotalgiftsales` decimal(15,2) DEFAULT '0.00',
  `ntotalchecksales` decimal(15,2) DEFAULT '0.00',
  `ntotalreturns` decimal(15,2) DEFAULT '0.00',
  `ntotaldiscount` decimal(15,2) DEFAULT '0.00',
  `ntotaldebitsales` decimal(15,2) DEFAULT '0.00',
  `ntotalebtsales` decimal(15,2) DEFAULT '0.00',
  `ntotalincome` decimal(15,2) DEFAULT '0.00',
  `ntotalexpense` decimal(15,2) DEFAULT '0.00',
  `ncashondrawer` decimal(15,2) DEFAULT '0.00',
  `ncashshortover` decimal(15,2) DEFAULT '0.00',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `customercount` int(11) DEFAULT '0',
  `voidcount` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `idx_trn_dailysales_ddate` (`ddate`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_dispalyimagevediodetail`
--

DROP TABLE IF EXISTS `trn_dispalyimagevediodetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_dispalyimagevediodetail` (
  `iimageid` int(11) DEFAULT NULL,
  `vimagename` varchar(100) DEFAULT NULL,
  `isequence` int(11) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_editdeletoperation`
--

DROP TABLE IF EXISTS `trn_editdeletoperation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_editdeletoperation` (
  `ieditdeleteid` int(11) NOT NULL AUTO_INCREMENT,
  `vtablename` varchar(75) DEFAULT NULL,
  `voptype` varchar(10) DEFAULT NULL,
  `vterminalid` varchar(10) DEFAULT NULL,
  `vtranid` varchar(200) DEFAULT NULL,
  `etransferstatus` varchar(10) DEFAULT NULL,
  `ddate` date DEFAULT NULL,
  `ttime` time DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ieditdeleteid`)
) ENGINE=MyISAM AUTO_INCREMENT=188 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_endofday`
--

DROP TABLE IF EXISTS `trn_endofday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_endofday` (
  `id` bigint(30) NOT NULL,
  `nnetsales` decimal(15,2) DEFAULT '0.00',
  `nnetpaidout` decimal(15,2) DEFAULT '0.00',
  `nnetcashpickup` decimal(15,2) DEFAULT '0.00',
  `estatus` varchar(10) DEFAULT NULL,
  `dstartdatetime` timestamp NULL DEFAULT NULL,
  `denddatetime` timestamp NULL DEFAULT NULL,
  `nopeningbalance` decimal(15,2) DEFAULT '0.00',
  `nclosingbalance` decimal(15,2) DEFAULT '0.00',
  `nuserclosingbalance` decimal(15,2) DEFAULT '0.00',
  `nnetaddcash` decimal(15,2) DEFAULT '0.00',
  `ntotalnontaxable` decimal(15,2) DEFAULT '0.00',
  `ntotaltaxable` decimal(15,2) DEFAULT '0.00',
  `ntotalsales` decimal(15,2) DEFAULT '0.00',
  `ntotaltax` decimal(15,2) DEFAULT '0.00',
  `ntotalcreditsales` decimal(15,2) DEFAULT '0.00',
  `ntotalcashsales` decimal(15,2) DEFAULT '0.00',
  `ntotalgiftsales` decimal(15,2) DEFAULT '0.00',
  `ntotalchecksales` decimal(15,2) DEFAULT '0.00',
  `ntotalreturns` decimal(15,2) DEFAULT '0.00',
  `ntotaldiscount` decimal(15,2) DEFAULT '0.00',
  `ntotaldebitsales` decimal(15,2) DEFAULT '0.00',
  `ntotalebtsales` decimal(15,2) DEFAULT '0.00',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_trn_endofday_id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_endofdaydetail`
--

DROP TABLE IF EXISTS `trn_endofdaydetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_endofdaydetail` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `eodid` bigint(30) DEFAULT NULL,
  `batchid` bigint(30) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_failover`
--

DROP TABLE IF EXISTS `trn_failover`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_failover` (
  `ifailid` int(11) NOT NULL AUTO_INCREMENT,
  `ddate` timestamp NULL DEFAULT NULL,
  `vterminalid` varchar(20) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ifailid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_failoverdetail`
--

DROP TABLE IF EXISTS `trn_failoverdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_failoverdetail` (
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `vtranid` varchar(50) DEFAULT NULL,
  `vsourcetype` varchar(20) DEFAULT NULL,
  `vtrntype` varchar(20) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_hold_order`
--

DROP TABLE IF EXISTS `trn_hold_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_hold_order` (
  `OrderId` int(11) NOT NULL AUTO_INCREMENT,
  `Quantity` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Source` varchar(15) DEFAULT NULL,
  `isPaid` bit(1) DEFAULT NULL,
  `Status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`OrderId`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_hold_order_details`
--

DROP TABLE IF EXISTS `trn_hold_order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_hold_order_details` (
  `DetailTransId` int(11) NOT NULL AUTO_INCREMENT,
  `TransId` int(11) NOT NULL,
  `ItemId` int(11) NOT NULL,
  `SubItemId` int(11) NOT NULL,
  `PrintSeq` int(11) NOT NULL,
  `MoreLessAction` varchar(16) NOT NULL,
  `Price` decimal(11,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`DetailTransId`)
) ENGINE=MyISAM AUTO_INCREMENT=1296 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_hold_order_items`
--

DROP TABLE IF EXISTS `trn_hold_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_hold_order_items` (
  `TransId` int(11) NOT NULL AUTO_INCREMENT,
  `OrderId` int(11) NOT NULL,
  `ItemId` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Price` decimal(11,2) NOT NULL,
  `Amount` decimal(11,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TransId`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_holditem`
--

DROP TABLE IF EXISTS `trn_holditem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_holditem` (
  `iholdid` bigint(30) DEFAULT NULL,
  `vitemcode` varchar(50) DEFAULT NULL,
  `vitemname` varchar(100) DEFAULT NULL,
  `nprice` decimal(15,2) DEFAULT NULL,
  `nsaleprice` DECIMAL(15,2) NULL DEFAULT '0.00',
  `iqty` decimal(15,2) DEFAULT '0.00',
  `vtax` varchar(11) DEFAULT NULL,
  `nfreeqty` decimal(15,2) DEFAULT '0.00',
  `nbuyqty` decimal(15,2) DEFAULT '0.00',
  `ndiscountqtyper` decimal(15,2) DEFAULT '0.00',
  `npack` int(11) DEFAULT '0',
  `ncostprice` decimal(15,4) DEFAULT NULL,
  `vitemtype` varchar(25) DEFAULT NULL,
  `vsize` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `itemdiscountvalue` decimal(15,2) DEFAULT '0.00',
  `itemdiscounttype` varchar(4) DEFAULT '0',
  `itemtaxrateone` decimal(15,4) DEFAULT '0.0000',
  `itemtaxratetwo` decimal(15,4) DEFAULT '0.0000',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_instantactivebook`
--

DROP TABLE IF EXISTS `trn_instantactivebook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_instantactivebook` (
  `iactivebookid` int(11) NOT NULL AUTO_INCREMENT,
  `vgamecode` varchar(30) DEFAULT NULL,
  `vbookcode` varchar(30) DEFAULT NULL,
  `istartingnumber` int(11) DEFAULT NULL,
  `ilastnumber` int(11) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `dactivedate` date DEFAULT NULL,
  `dactivetime` time DEFAULT NULL,
  `ibatchid` int(11) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iactivebookid`),
  KEY `idx_trn_instantactivebook` (`vgamecode`,`vbookcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_instantcashout`
--

DROP TABLE IF EXISTS `trn_instantcashout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_instantcashout` (
  `icashoutid` int(11) NOT NULL AUTO_INCREMENT,
  `vcashouttype` varchar(25) DEFAULT NULL,
  `dcashoutdate` date DEFAULT NULL,
  `dcashouttime` time DEFAULT NULL,
  `ibatchid` int(11) DEFAULT NULL,
  `iuserid` int(11) DEFAULT NULL,
  `vgamecode` varchar(30) DEFAULT NULL,
  `vbookcode` varchar(30) DEFAULT NULL,
  `ncashoutamt` decimal(10,2) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`icashoutid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_instantcloseday`
--

DROP TABLE IF EXISTS `trn_instantcloseday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_instantcloseday` (
  `ibatchid` int(11) NOT NULL AUTO_INCREMENT,
  `dclosedate` date DEFAULT NULL,
  `dclosetime` time DEFAULT NULL,
  `ntotalsales` decimal(15,2) DEFAULT NULL,
  `nclosingamount` decimal(15,2) DEFAULT NULL,
  `nactualamount` decimal(15,2) DEFAULT NULL,
  `ncashshortover` decimal(15,2) DEFAULT NULL,
  `ninstantcommission` decimal(15,2) DEFAULT NULL,
  `ninstantcashout` decimal(15,2) DEFAULT NULL,
  `nonlinesales` decimal(15,2) DEFAULT NULL,
  `nonlinecommission` decimal(15,2) DEFAULT NULL,
  `nonlinecashout` decimal(15,2) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `nbooksold` decimal(15,2) DEFAULT NULL,
  `ntotaldue` decimal(15,2) DEFAULT NULL,
  `iactivebook` int(11) DEFAULT NULL,
  `isoldbook` int(11) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ibatchid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_instantclosedaydetail`
--

DROP TABLE IF EXISTS `trn_instantclosedaydetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_instantclosedaydetail` (
  `ibatchid` int(11) DEFAULT NULL,
  `vgamecode` varchar(30) DEFAULT NULL,
  `vbookcode` varchar(30) DEFAULT NULL,
  `ilastticketnumber` int(11) DEFAULT NULL,
  `icurrentticketnumber` int(11) DEFAULT NULL,
  `iticketamount` decimal(15,2) DEFAULT NULL,
  `itotalticketsold` int(11) DEFAULT NULL,
  `ntotalamount` decimal(15,2) DEFAULT NULL,
  `iildetid` int(11) NOT NULL AUTO_INCREMENT,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iildetid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_inventory`
--

DROP TABLE IF EXISTS `trn_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_inventory` (
  `vitemcode` varchar(50) DEFAULT NULL,
  `vunitcode` varchar(20) DEFAULT NULL,
  `ddate` date DEFAULT NULL,
  `nqty` float(4,0) DEFAULT NULL,
  `nreturnqty` float(4,0) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_itempricecosthistory`
--

DROP TABLE IF EXISTS `trn_itempricecosthistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_itempricecosthistory` (
  `iitemid` int(11) DEFAULT NULL,
  `vbarcode` varchar(50) DEFAULT NULL,
  `vtype` varchar(20) DEFAULT NULL,
  `noldamt` decimal(15,2) DEFAULT '0.00',
  `nnewamt` decimal(15,2) DEFAULT '0.00',
  `iuserid` int(11) DEFAULT NULL,
  `iihid` int(11) NOT NULL AUTO_INCREMENT,
  `dhistorydate` date DEFAULT NULL,
  `thistorytime` time DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iihid`),
  KEY `idx_trn_itemph_all` (`vbarcode`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_leger`
--

DROP TABLE IF EXISTS `trn_leger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_leger` (
  `iledgerid` int(11) NOT NULL AUTO_INCREMENT,
  `dlegerdate` date DEFAULT NULL,
  `namount` decimal(10,2) DEFAULT NULL,
  `etype` varchar(15) DEFAULT NULL,
  `vdescription` varchar(100) DEFAULT NULL,
  `vdepcode` varchar(15) DEFAULT NULL,
  `estatus` varchar(5) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iledgerid`),
  KEY `idx_trn_leger_all` (`iledgerid`,`dlegerdate`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_mpsbatchclose`
--

DROP TABLE IF EXISTS `trn_mpsbatchclose`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_mpsbatchclose` (
  `impsbatchcloseid` int(11) NOT NULL AUTO_INCREMENT,
  `merchantid` varchar(150) DEFAULT NULL,
  `transactioncode` varchar(150) DEFAULT NULL,
  `memo` varchar(150) DEFAULT NULL,
  `operatorid` varchar(50) DEFAULT NULL,
  `batchno` int(11) DEFAULT NULL,
  `batchitemcount` int(11) DEFAULT NULL,
  `netbatchtotal` decimal(10,2) DEFAULT NULL,
  `creditpurchasecount` int(11) DEFAULT NULL,
  `creditpurchaseamount` decimal(10,2) DEFAULT NULL,
  `creditreturncount` int(11) DEFAULT NULL,
  `creditreturnamount` decimal(10,2) DEFAULT NULL,
  `debitpurchasecount` int(11) DEFAULT NULL,
  `debitpurchaseamount` decimal(10,2) DEFAULT NULL,
  `debitreturncount` int(11) DEFAULT NULL,
  `debitreturnamount` decimal(10,2) DEFAULT NULL,
  `responseorigin` varchar(150) DEFAULT NULL,
  `dsixreturncode` int(11) DEFAULT NULL,
  `cmdstatus` varchar(150) DEFAULT NULL,
  `textresponse` varchar(255) DEFAULT NULL,
  `usertracedata` varchar(500) DEFAULT NULL,
  `controlno` int(11) DEFAULT NULL,
  `xmlresponse` varchar(5000) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`impsbatchcloseid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_mpsbatchsmry`
--

DROP TABLE IF EXISTS `trn_mpsbatchsmry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_mpsbatchsmry` (
  `impsbatchsmryid` int(11) NOT NULL AUTO_INCREMENT,
  `merchantid` varchar(150) DEFAULT NULL,
  `transactioncode` varchar(150) DEFAULT NULL,
  `memo` varchar(150) DEFAULT NULL,
  `operatorid` varchar(50) DEFAULT NULL,
  `batchno` bigint(30) DEFAULT NULL,
  `batchitemcount` int(11) DEFAULT NULL,
  `netbatchtotal` decimal(10,2) DEFAULT NULL,
  `creditpurchasecount` int(11) DEFAULT NULL,
  `creditpurchaseamount` decimal(10,2) DEFAULT NULL,
  `creditreturncount` int(11) DEFAULT NULL,
  `creditreturnamount` decimal(10,2) DEFAULT NULL,
  `debitpurchasecount` int(11) DEFAULT NULL,
  `debitpurchaseamount` decimal(10,2) DEFAULT NULL,
  `debitreturncount` int(11) DEFAULT NULL,
  `debitreturnamount` decimal(10,2) DEFAULT NULL,
  `textresponse` varchar(500) DEFAULT NULL,
  `sequenceno` varchar(150) DEFAULT NULL,
  `xmlresponse` varchar(10000) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`impsbatchsmryid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_mpsrequest`
--

DROP TABLE IF EXISTS `trn_mpsrequest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_mpsrequest` (
  `impsrequestid` int(11) NOT NULL AUTO_INCREMENT,
  `vtoken` varchar(150) DEFAULT NULL,
  `dtrandate` datetime DEFAULT NULL,
  `dtrantime` time DEFAULT NULL,
  `vauthcode` varchar(21) DEFAULT NULL,
  `npurchaseamount` decimal(10,2) DEFAULT NULL,
  `nauthamount` decimal(10,2) DEFAULT NULL,
  `vbatchno` varchar(30) DEFAULT NULL,
  `nbatchamount` decimal(10,2) DEFAULT NULL,
  `vcardtype` varchar(25) DEFAULT NULL,
  `vcardholdername` varchar(50) DEFAULT NULL,
  `vreturncode` varchar(10) DEFAULT NULL,
  `vsignaturedata` longtext,
  `vtendertype` varchar(25) DEFAULT NULL,
  `vvoucherno` varchar(45) DEFAULT NULL,
  `vmemo` varchar(50) DEFAULT NULL,
  `vtrancode` varchar(40) DEFAULT NULL,
  `vcardusage` varchar(45) DEFAULT NULL,
  `vavsresult` varchar(45) DEFAULT NULL,
  `vacqrefdata` varchar(200) DEFAULT NULL,
  `voperatorid` varchar(10) DEFAULT NULL,
  `vprepaidaccount` varchar(20) DEFAULT NULL,
  `vuserid` varchar(15) DEFAULT NULL,
  `vinvnumber` varchar(20) DEFAULT NULL,
  `vrefnumber` varchar(20) DEFAULT NULL,
  `vtransactiontype` varchar(50) DEFAULT NULL,
  `input` varchar(25) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`impsrequestid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_mpstender`
--

DROP TABLE IF EXISTS `trn_mpstender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_mpstender` (
  `impstenderid` int(11) NOT NULL AUTO_INCREMENT,
  `vtoken` varchar(150) DEFAULT NULL,
  `dtrandate` datetime DEFAULT NULL,
  `dtrantime` time DEFAULT NULL,
  `vcmdstatus` varchar(100) DEFAULT NULL,
  `vtextresponse` varchar(150) DEFAULT NULL,
  `vprocessdata` varchar(500) DEFAULT NULL,
  `vauthcode` varchar(21) DEFAULT NULL,
  `npurchaseamount` decimal(10,2) DEFAULT NULL,
  `nauthamount` decimal(10,2) DEFAULT NULL,
  `vbatchno` varchar(30) DEFAULT NULL,
  `nbatchamount` decimal(10,2) DEFAULT NULL,
  `vcardtype` varchar(25) DEFAULT NULL,
  `vcardholdername` varchar(50) DEFAULT NULL,
  `vreturncode` varchar(10) DEFAULT NULL,
  `vsignaturedata` longtext,
  `vtendertype` varchar(25) DEFAULT NULL,
  `vvoucherno` varchar(45) DEFAULT NULL,
  `vmemo` varchar(50) DEFAULT NULL,
  `vtrancode` varchar(40) DEFAULT NULL,
  `vcardusage` varchar(45) DEFAULT NULL,
  `vavsresult` varchar(45) DEFAULT NULL,
  `vcapturestatus` varchar(20) DEFAULT NULL,
  `vacqrefdata` varchar(200) DEFAULT NULL,
  `voperatorid` varchar(10) DEFAULT NULL,
  `vprepaidaccount` varchar(20) DEFAULT NULL,
  `vuserid` varchar(15) DEFAULT NULL,
  `vinvnumber` varchar(20) DEFAULT NULL,
  `vrefnumber` varchar(20) DEFAULT NULL,
  `xmlresponse` varchar(10000) DEFAULT NULL,
  `itranid` bigint(30) DEFAULT NULL,
  `input` varchar(25) DEFAULT NULL,
  `vtransfer` varchar(5) DEFAULT 'No',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`impstenderid`),
  KEY `idx_trn_mpstender_itranid` (`itranid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_orderserving`
--

DROP TABLE IF EXISTS `trn_orderserving`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_orderserving` (
  `isalesorderid` int(11) DEFAULT NULL,
  `dorderdate` timestamp NULL DEFAULT NULL,
  `dorderupdatetime` timestamp NULL DEFAULT NULL,
  `dservingtime` varchar(20) DEFAULT NULL,
  `estatus` varchar(20) DEFAULT NULL,
  `vtablename` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_paidout`
--

DROP TABLE IF EXISTS `trn_paidout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_paidout` (
  `ipaidouttrnid` bigint(30) NOT NULL,
  `vterminalid` varchar(30) DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `ilogid` int(11) DEFAULT NULL,
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `ttime` time DEFAULT NULL,
  `ibatchid` bigint(30) DEFAULT NULL,
  `vtransfer` varchar(5) DEFAULT 'No',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipaidouttrnid`),
  KEY `idx_trnpaidoit_unique` (`vuniquetranid`),
  KEY `idx_trn_paidout_ddate` (`ddate`),
  KEY `idx_trn_paidout_ibatchid` (`ibatchid`),
  KEY `idx_trn_paidout_ipaidouttrnid` (`ipaidouttrnid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_paidoutdetail`
--

DROP TABLE IF EXISTS `trn_paidoutdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_paidoutdetail` (
  `ipaidouttrnid` int(11) DEFAULT '0',
  `ipaidoutid` bigint(30) DEFAULT '0',
  `namount` decimal(15,2) DEFAULT NULL,
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `vpaidoutname` varchar(100) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` bigint(30) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  KEY `idx_trnpaidoutdetail_unique` (`vuniquetranid`),
  KEY `idx_trn_paidoutdetail_imid` (`ipaidoutid`),
  KEY `idx_trn_paidoutdetail_trnid` (`ipaidouttrnid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_physicalinventory`
--

DROP TABLE IF EXISTS `trn_physicalinventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_physicalinventory` (
  `ipiid` int(11) NOT NULL AUTO_INCREMENT,
  `vpinvtnumber` varchar(30) DEFAULT NULL,
  `vrefnumber` varchar(30) DEFAULT NULL,
  `nnettotal` decimal(15,2) DEFAULT '0.00',
  `ntaxtotal` decimal(15,2) DEFAULT '0.00',
  `dcreatedate` timestamp NULL DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `vordertitle` varchar(50) DEFAULT NULL,
  `vnotes` varchar(1000) DEFAULT NULL,
  `dlastupdate` timestamp NULL DEFAULT NULL,
  `vtype` varchar(15) DEFAULT NULL,
  `ilocid` int(11) DEFAULT '0',
  `dcalculatedate` timestamp NULL DEFAULT NULL,
  `dclosedate` timestamp NULL DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipiid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_physicalinventorydetail`
--

DROP TABLE IF EXISTS `trn_physicalinventorydetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_physicalinventorydetail` (
  `ipidetid` int(11) NOT NULL AUTO_INCREMENT,
  `ipiid` int(11) DEFAULT NULL,
  `vitemid` varchar(50) DEFAULT NULL,
  `vitemname` varchar(100) DEFAULT NULL,
  `vunitcode` varchar(20) DEFAULT NULL,
  `vunitname` varchar(50) DEFAULT NULL,
  `ndebitqty` decimal(15,2) DEFAULT '0.00',
  `ncreditqty` decimal(15,2) DEFAULT '0.00',
  `ndebitunitprice` decimal(15,2) DEFAULT '0.00',
  `ncrediteunitprice` decimal(15,2) DEFAULT '0.00',
  `nordtax` decimal(15,2) DEFAULT NULL,
  `ndebitextprice` decimal(15,2) DEFAULT '0.00',
  `ncrditextprice` decimal(15,2) DEFAULT '0.00',
  `ndebittextprice` decimal(15,2) DEFAULT '0.00',
  `ncredittextprice` decimal(15,2) DEFAULT '0.00',
  `vbarcode` varchar(50) DEFAULT NULL,
  `ndiffqty` decimal(15,2) DEFAULT '0.00',
  `vreasoncode` varchar(25) DEFAULT '0',
  `vvendoritemcode` varchar(50) DEFAULT NULL,
  `npackqty` int(11) DEFAULT '0',
  `nunitcost` decimal(15,4) DEFAULT '0.0000',
  `itotalunit` int(11) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipidetid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_pickupcash`
--

DROP TABLE IF EXISTS `trn_pickupcash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_pickupcash` (
  `icashid` int(11) NOT NULL AUTO_INCREMENT,
  `iuserid` int(11) DEFAULT NULL,
  `ilogid` int(11) DEFAULT NULL,
  `ddatetime` timestamp NULL DEFAULT NULL,
  `vterminalid` varchar(50) DEFAULT NULL,
  `namount` decimal(15,2) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`icashid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_purchaseorder`
--

DROP TABLE IF EXISTS `trn_purchaseorder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_purchaseorder` (
  `ipoid` int(11) NOT NULL AUTO_INCREMENT,
  `vponumber` varchar(30) DEFAULT NULL,
  `vrefnumber` varchar(30) DEFAULT NULL,
  `nnettotal` decimal(15,2) DEFAULT '0.00',
  `ntaxtotal` decimal(15,2) DEFAULT '0.00',
  `dcreatedate` timestamp NULL DEFAULT NULL,
  `dplacedate` timestamp NULL DEFAULT NULL,
  `dreceiveddate` timestamp NULL DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `nfreightcharge` decimal(15,2) DEFAULT NULL,
  `vordertitle` varchar(50) DEFAULT NULL,
  `vorderby` varchar(30) DEFAULT NULL,
  `vconfirmby` varchar(30) DEFAULT NULL,
  `vnotes` varchar(1000) DEFAULT NULL,
  `vvendorid` varchar(10) DEFAULT NULL,
  `vvendorname` varchar(50) DEFAULT NULL,
  `vvendoraddress1` varchar(100) DEFAULT NULL,
  `vvendoraddress2` varchar(100) DEFAULT NULL,
  `vvendorstate` varchar(20) DEFAULT NULL,
  `vvendorzip` varchar(10) DEFAULT NULL,
  `vvendorphone` varchar(20) DEFAULT NULL,
  `vshpid` varchar(10) DEFAULT NULL,
  `vshpname` varchar(50) DEFAULT NULL,
  `vshpaddress1` varchar(100) DEFAULT NULL,
  `vshpaddress2` varchar(100) DEFAULT NULL,
  `vshpzip` varchar(10) DEFAULT NULL,
  `vshpstate` varchar(20) DEFAULT NULL,
  `vshpphone` varchar(26) DEFAULT NULL,
  `dlastupdate` timestamp NULL DEFAULT NULL,
  `vshipvia` varchar(30) DEFAULT NULL,
  `nrectotal` decimal(15,2) DEFAULT '0.00',
  `nsubtotal` decimal(15,2) DEFAULT '0.00',
  `ndeposittotal` decimal(15,2) DEFAULT '0.00',
  `nreturntotal` decimal(15,2) DEFAULT '0.00',
  `vinvoiceno` varchar(50) DEFAULT NULL,
  `ndiscountamt` decimal(15,2) DEFAULT '0.00',
  `nripsamt` decimal(15,2) DEFAULT '0.00',
  `dduedatetime` timestamp NULL DEFAULT NULL,
  `vordertype` varchar(50) DEFAULT 'PO',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipoid`),
  KEY `idx_dcreatedate_trn_po` (`dcreatedate`),
  KEY `idx_trn_purchaseorder_id` (`ipoid`),
  KEY `idx_vinvoiceno_trn_po` (`vinvoiceno`),
  KEY `idx_vponumber_trn_po` (`vponumber`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_purchaseorderdetail`
--

DROP TABLE IF EXISTS `trn_purchaseorderdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_purchaseorderdetail` (
  `ipodetid` int(11) NOT NULL AUTO_INCREMENT,
  `ipoid` int(11) DEFAULT NULL,
  `vitemid` varchar(50) DEFAULT NULL,
  `vitemname` varchar(100) DEFAULT NULL,
  `vunitcode` varchar(25) DEFAULT NULL,
  `vunitname` varchar(50) DEFAULT NULL,
  `nordqty` decimal(15,2) DEFAULT '0.00',
  `nrceqty` decimal(15,2) DEFAULT '0.00',
  `nordunitprice` decimal(15,2) DEFAULT '0.00',
  `nreceunitprice` decimal(15,2) DEFAULT '0.00',
  `nordtax` decimal(15,2) DEFAULT NULL,
  `nordextprice` decimal(15,4) DEFAULT '0.0000',
  `nrceextprice` decimal(15,2) DEFAULT '0.00',
  `nordtextprice` decimal(15,2) DEFAULT '0.00',
  `nrcetextprice` decimal(15,2) DEFAULT '0.00',
  `nnewunitprice` decimal(15,2) DEFAULT '0.00',
  `vbarcode` varchar(50) DEFAULT NULL,
  `vvendoritemcode` varchar(50) DEFAULT NULL,
  `npackqty` int(11) DEFAULT '0',
  `nunitcost` decimal(15,4) DEFAULT '0.0000',
  `itotalunit` int(11) DEFAULT '0',
  `vsize` varchar(100) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `nripamount` DECIMAL(15,2) NULL DEFAULT '0',
  PRIMARY KEY (`ipodetid`),
  KEY `idx_trn_purchaseorderdetail_id` (`ipoid`,`vitemid`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_pushnotification`
--

DROP TABLE IF EXISTS `trn_pushnotification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_pushnotification` (
  `ipushid` bigint(30) NOT NULL,
  `vstorecode` varchar(25) DEFAULT NULL,
  `vmessage` varchar(150) DEFAULT NULL,
  `vusername` varchar(100) DEFAULT NULL,
  `dmessageinsert` timestamp NULL DEFAULT NULL,
  `ddate` date DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `ionupload` int(11) DEFAULT NULL,
  `vtransfer` varchar(5) DEFAULT NULL,
  `vvalue1` varchar(50) DEFAULT NULL,
  `vvalue2` varchar(50) DEFAULT NULL,
  `vvalue3` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipushid`),
  KEY `idx_trn_pushnotification_ddate` (`ddate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_quickitem`
--

DROP TABLE IF EXISTS `trn_quickitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_quickitem` (
  `vitemcode` varchar(50) NOT NULL,
  `vgroupcode` varchar(20) NOT NULL,
  `isequence` int(11) DEFAULT '1',
  `vtype` varchar(10) DEFAULT 'Product',
  `vterminalid` varchar(50) DEFAULT '0',
  `vcolorcode` varchar(50) DEFAULT 'None',
  `vfontsize` varchar(20) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  KEY `idx_trn_quickitem` (`vitemcode`,`vgroupcode`,`vtype`),
  KEY `idx_trn_quickitem_all` (`vgroupcode`,`vtype`,`vterminalid`)
) ENGINE=MyISAM AUTO_INCREMENT=441 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_quotation`
--

DROP TABLE IF EXISTS `trn_quotation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_quotation` (
  `iquotationid` bigint(30) NOT NULL,
  `istoreid` int(11) DEFAULT NULL,
  `vstorename` varchar(100) DEFAULT NULL,
  `iuserid` int(11) DEFAULT NULL,
  `vusername` varchar(50) DEFAULT NULL,
  `ilogid` int(11) DEFAULT NULL,
  `vpaymenttype` varchar(50) DEFAULT NULL,
  `dtrandate` datetime NOT NULL,
  `dentdate` date DEFAULT NULL,
  `nnontaxabletotal` decimal(15,2) DEFAULT NULL,
  `ntaxabletotal` decimal(15,2) DEFAULT '0.00',
  `ntaxtotal` decimal(15,2) DEFAULT NULL,
  `nsubtotal` decimal(15,2) DEFAULT NULL,
  `nnettotal` decimal(10,2) DEFAULT NULL,
  `ndiscountamt` decimal(15,2) DEFAULT NULL,
  `nsaletotalamt` decimal(15,2) DEFAULT NULL,
  `idiscountid` decimal(15,2) DEFAULT NULL,
  `nchange` decimal(15,2) DEFAULT NULL,
  `vterminalid` varchar(50) DEFAULT NULL,
  `vdiscountname` varchar(50) DEFAULT NULL,
  `itemplateid` int(11) DEFAULT '0',
  `vremark` varchar(500) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `vzipcode` varchar(25) DEFAULT NULL,
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `ttime` time DEFAULT NULL,
  `ibatchid` bigint(30) DEFAULT NULL,
  `vinvoicenumber` varchar(50) DEFAULT NULL,
  `ionupload` int(11) DEFAULT '0',
  `ntotalgasoline` decimal(15,2) DEFAULT '0.00',
  `ntotallottery` decimal(15,2) DEFAULT '0.00',
  `ntotallotteryredeem` decimal(15,2) DEFAULT '0.00',
  `vtransactionnumber` varchar(50) DEFAULT NULL,
  `vtransfer` varchar(5) DEFAULT 'No',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iquotationid`),
  KEY `idx_trn_quotation_id` (`iquotationid`,`dtrandate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_quotationdetail`
--

DROP TABLE IF EXISTS `trn_quotationdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_quotationdetail` (
  `iquotationid` bigint(30) NOT NULL,
  `vitemcode` varchar(50) NOT NULL,
  `vitemname` varchar(100) DEFAULT NULL,
  `vcatcode` varchar(20) DEFAULT NULL,
  `vcatname` varchar(100) DEFAULT NULL,
  `vdepcode` varchar(20) DEFAULT NULL,
  `vdepname` varchar(100) DEFAULT NULL,
  `ndebitqty` decimal(15,2) DEFAULT '0.00',
  `ncreditqty` decimal(15,2) DEFAULT '0.00',
  `nunitprice` decimal(10,2) DEFAULT '0.00',
  `ncostprice` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `nextunitprice` decimal(15,2) DEFAULT '0.00',
  `nextcostprice` decimal(15,2) DEFAULT '0.00',
  `ndebitamt` decimal(15,2) DEFAULT '0.00',
  `ncreditamt` decimal(15,2) DEFAULT '0.00',
  `ndiscountper` decimal(15,2) NOT NULL DEFAULT '0.00',
  `ndiscountamt` decimal(15,2) DEFAULT '0.00',
  `nsaleamt` decimal(15,2) DEFAULT '0.00',
  `nsaleprice` decimal(15,2) DEFAULT '0.00',
  `vtax` varchar(10) DEFAULT NULL,
  `vunitcode` varchar(20) DEFAULT NULL,
  `vunitname` varchar(25) DEFAULT NULL,
  `vreason` varchar(100) DEFAULT NULL,
  `vadjtype` varchar(20) DEFAULT NULL,
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `idettrnid` int(11) NOT NULL AUTO_INCREMENT,
  `ereturnitem` varchar(10) DEFAULT 'No',
  `nitemtax` decimal(15,2) DEFAULT '0.00',
  `iunitqty` int(11) DEFAULT '0',
  `npack` int(11) DEFAULT '0',
  `vsize` varchar(50) DEFAULT NULL,
  `vitemtype` varchar(25) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idettrnid`),
  KEY `idx_trn_quotationdetail_all` (`iquotationid`,`vitemcode`,`vcatcode`,`vdepcode`,`vuniquetranid`,`vunitcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_rip_detail`
--

DROP TABLE IF EXISTS `trn_rip_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_rip_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ripheaderid` int(11) NOT NULL,
  `checknumber` varchar(25) NOT NULL,
  `checkamt` decimal(15,2) NOT NULL,
  `checkdesc` varchar(50) NOT NULL,
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `trn_rip_header`
--

DROP TABLE IF EXISTS `trn_rip_header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_rip_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ponumber` varchar(30) NOT NULL,
  `vendorid` varchar(10) NOT NULL,
  `riptotal` decimal(15,2) NOT NULL,
  `receivedtotalamt` decimal(15,2) NOT NULL,
  `pendingtotalamt` decimal(15,2) NOT NULL,
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) 
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Table structure for table `trn_saleprice`
--

DROP TABLE IF EXISTS `trn_saleprice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_saleprice` (
  `isalepriceid` int(11) NOT NULL AUTO_INCREMENT,
  `vsalename` varchar(50) DEFAULT NULL,
  `vsaletype` varchar(25) DEFAULT NULL,
  `ndiscountper` decimal(15,2) DEFAULT NULL,
  `dstartdatetime` timestamp NULL DEFAULT NULL,
  `denddatetime` timestamp NULL DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `dsalecreatedate` date DEFAULT NULL,
  `nbuyqty` decimal(15,2) DEFAULT NULL,
  `ndiscountqty` decimal(15,2) DEFAULT NULL,
  `vsaleby` varchar(20) DEFAULT '',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`isalepriceid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_salepricedetail`
--

DROP TABLE IF EXISTS `trn_salepricedetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_salepricedetail` (
  `isalepriceid` int(11) NOT NULL,
  `vitemcode` varchar(50) NOT NULL,
  `dunitprice` decimal(15,2) DEFAULT NULL,
  `nsaleprice` decimal(15,2) DEFAULT NULL,
  `vunitcode` varchar(20) DEFAULT NULL,
  `vitemtype` varchar(10) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_sales`
--

DROP TABLE IF EXISTS `trn_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_sales` (
  `isalesid` bigint(30) NOT NULL,
  `istoreid` int(11) DEFAULT NULL,
  `vstorename` varchar(100) DEFAULT NULL,
  `iuserid` int(11) DEFAULT NULL,
  `vusername` varchar(50) DEFAULT NULL,
  `ilogid` int(11) DEFAULT NULL,
  `icustomerid` int(11) DEFAULT NULL,
  `vcustomername` varchar(100) DEFAULT NULL,
  `vpaymenttype` varchar(50) DEFAULT NULL,
  `dtrandate` datetime NOT NULL,
  `dentdate` date DEFAULT NULL,
  `nnontaxabletotal` decimal(15,2) DEFAULT NULL,
  `ntaxabletotal` decimal(15,2) DEFAULT '0.00',
  `ntaxtotal` decimal(15,2) DEFAULT NULL,
  `nsubtotal` decimal(15,2) DEFAULT NULL,
  `nnettotal` decimal(10,2) DEFAULT NULL,
  `ndiscountamt` decimal(15,2) DEFAULT NULL,
  `nsaletotalamt` decimal(15,2) DEFAULT NULL,
  `idiscountid` decimal(15,2) DEFAULT NULL,
  `nchange` decimal(15,2) DEFAULT NULL,
  `vterminalid` varchar(50) DEFAULT NULL,
  `vdiscountname` varchar(50) DEFAULT NULL,
  `vtrntype` varchar(50) DEFAULT NULL,
  `itemplateid` int(11) DEFAULT '0',
  `vremark` varchar(500) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `vzipcode` varchar(25) DEFAULT NULL,
  `vcustphone` varchar(25) DEFAULT NULL,
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `ttime` time DEFAULT NULL,
  `vtablename` varchar(100) DEFAULT NULL,
  `ibatchid` bigint(30) DEFAULT NULL,
  `vinvoicenumber` varchar(50) DEFAULT NULL,
  `vtransactionnumber` varchar(50) DEFAULT NULL,
  `vmpstenderid` varchar(50) DEFAULT NULL,
  `ionaccount` int(11) DEFAULT '0',
  `vtendertype` varchar(200) DEFAULT NULL,
  `ionupload` smallint(6) DEFAULT '0',
  `ntotalgasoline` decimal(15,2) DEFAULT '0.00',
  `ntotallottery` decimal(15,2) DEFAULT '0.00',
  `ntotallotteryredeem` decimal(15,2) DEFAULT '0.00',
  `vtransfer` varchar(5) DEFAULT 'No',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0', 
  `kioskid` int(11) DEFAULT '0',
  `iswic` INT(1) NULL DEFAULT '0',
  `checkno` VARCHAR(45) NULL,
  `checksdate` DATE NULL,
  `checkedate` DATE NULL,
  `licnumber` VARCHAR(100) NULL,
  `liccustomername` VARCHAR(100) NULL,
  `licaddress` VARCHAR(100) NULL,
  `liccustomerbirthdate` VARCHAR(20) NULL,
  `licexpireddate` VARCHAR(20) NULL,
  PRIMARY KEY (`isalesid`),
  KEY `idx_trnsales_ibatchid` (`ibatchid`),
  KEY `idx_trnsales_uniqueid` (`vuniquetranid`),
  KEY `idx_trn_sales_dtrandate` (`dtrandate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_salescustomer`
--

DROP TABLE IF EXISTS `trn_salescustomer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_salescustomer` (
  `iscid` bigint(30) NOT NULL AUTO_INCREMENT,
  `isalesid` bigint(30) DEFAULT '0',
  `icustomerid` int(11) DEFAULT NULL,
  `dtrandate` date NOT NULL,
  `nonaccount` decimal(15,2) DEFAULT '0.00',
  `nnontaxabletotal` decimal(15,2) DEFAULT '0.00',
  `ntaxabletotal` decimal(15,2) DEFAULT '0.00',
  `ntaxtotal` decimal(15,2) DEFAULT '0.00',
  `nsubtotal` decimal(15,2) DEFAULT '0.00',
  `nnettotal` decimal(10,2) DEFAULT '0.00',
  `ndiscountamt` decimal(15,2) DEFAULT '0.00',
  `nsaletotalamt` decimal(15,2) DEFAULT '0.00',
  `idiscountid` decimal(15,2) DEFAULT '0.00',
  `nchange` decimal(15,2) DEFAULT '0.00',
  `vtransfer` varchar(5) DEFAULT 'No',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iscid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_salesdetail`
--

DROP TABLE IF EXISTS `trn_salesdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_salesdetail` (
  `isalesid` bigint(30) NOT NULL,
  `vitemcode` varchar(50) NOT NULL,
  `vitemname` varchar(100) DEFAULT NULL,
  `vcatcode` varchar(20) DEFAULT NULL,
  `vcatname` varchar(100) DEFAULT NULL,
  `vdepcode` varchar(20) DEFAULT NULL,
  `vdepname` varchar(100) DEFAULT NULL,
  `ndebitqty` decimal(15,2) DEFAULT '0.00',
  `ncreditqty` decimal(15,2) DEFAULT '0.00',
  `nunitprice` decimal(10,2) DEFAULT '0.00',
  `ncostprice` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `nextunitprice` decimal(15,2) DEFAULT '0.00',
  `nextcostprice` decimal(15,2) DEFAULT '0.00',
  `ndebitamt` decimal(15,2) DEFAULT '0.00',
  `ncreditamt` decimal(15,2) DEFAULT '0.00',
  `ndiscountamt` decimal(15,2) DEFAULT '0.00',
  `nsaleamt` decimal(15,2) DEFAULT '0.00',
  `nsaleprice` decimal(15,2) DEFAULT '0.00',
  `vtax` varchar(10) DEFAULT NULL,
  `vunitcode` varchar(20) DEFAULT NULL,
  `vunitname` varchar(25) DEFAULT NULL,
  `vreason` varchar(100) DEFAULT NULL,
  `vadjtype` varchar(20) DEFAULT NULL,
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `idettrnid` bigint(30) NOT NULL AUTO_INCREMENT,
  `ereturnitem` varchar(10) DEFAULT 'No',
  `nitemtax` decimal(15,2) DEFAULT '0.00',
  `iunitqty` int(11) DEFAULT '0',
  `npack` int(11) DEFAULT '0',
  `vsize` varchar(50) DEFAULT NULL,
  `vitemtype` varchar(25) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `updateqoh` int(2) DEFAULT '0',
  `itemdiscountvalue` decimal(15,2) DEFAULT '0.00',
  `itemdiscounttype` varchar(4) DEFAULT '0',
  `itemtaxrateone` decimal(15,4) DEFAULT '0.0000',
  `itemtaxratetwo` decimal(15,4) DEFAULT '0.0000',
  `liabilityamount` decimal(15,2) DEFAULT '0.00',
  `preqoh` INT NULL DEFAULT 0,
  PRIMARY KEY (`idettrnid`),
  KEY `idx_salesdetail_vitemcode` (`vitemcode`),
  KEY `idx_salesdetil_id` (`isalesid`),
  KEY `idx_trndetail_uniqueid` (`vuniquetranid`,`vitemcode`,`vcatcode`,`vdepcode`),
  KEY `idx_trndetail_isalesid` (`isalesid`),
  KEY `idx_salesdetail_updateqoh` (`updateqoh`),
  KEY `idx_salesdetail_lastupdate` (`LastUpdate`)
) ENGINE=MyISAM AUTO_INCREMENT=612437 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_salestender`
--

DROP TABLE IF EXISTS `trn_salestender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_salestender` (
  `itenerid` int(11) NOT NULL,
  `isalesid` bigint(30) DEFAULT '0',
  `vtendername` varchar(50) DEFAULT NULL,
  `namount` decimal(15,2) DEFAULT NULL,
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `impstenderid` bigint(30) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` bigint(30) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  KEY `idx_salestender_isalesid` (`isalesid`),
  KEY `idx_trnsalestender_itender` (`itenerid`),
  KEY `idx_trntender_uniqueid` (`vuniquetranid`),
  KEY `idx_trndetandetail_lastupdate` (`LastUpdate`)
) ENGINE=MyISAM AUTO_INCREMENT=91093 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_userlog`
--

DROP TABLE IF EXISTS `trn_userlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_userlog` (
  `iuserlogid` int(11) NOT NULL AUTO_INCREMENT,
  `iuserid` int(11) NOT NULL,
  `vdatabasename` varchar(50) DEFAULT NULL,
  `vipaddress` varchar(20) DEFAULT NULL,
  `dlogindatetime` timestamp NULL DEFAULT NULL,
  `dlogoutdatetime` timestamp NULL DEFAULT NULL,
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `vloginfrom` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iuserlogid`)
) ENGINE=MyISAM AUTO_INCREMENT=353 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_userlogdetail`
--

DROP TABLE IF EXISTS `trn_userlogdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_userlogdetail` (
  `iuserlogid` int(11) NOT NULL,
  `vaction` varchar(500) NOT NULL,
  `itranid` int(11) DEFAULT NULL,
  `daccessdatetime` timestamp NULL DEFAULT NULL,
  `vuniquetranid` varchar(50) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2147 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_voidtran`
--

DROP TABLE IF EXISTS `trn_voidtran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_voidtran` (
  `ivoidid` int(11) NOT NULL AUTO_INCREMENT,
  `istoreid` int(11) DEFAULT NULL,
  `dtrandate` date DEFAULT NULL,
  `vterminalid` varchar(50) DEFAULT NULL,
  `iuserid` int(11) DEFAULT NULL,
  `dnettotal` decimal(15,2) DEFAULT NULL,
  `vtrantype` varchar(10) DEFAULT NULL,
  `vreason` varchar(100) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ivoidid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_warehouseinvoice`
--

DROP TABLE IF EXISTS `trn_warehouseinvoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_warehouseinvoice` (
  `iid` int(11) NOT NULL AUTO_INCREMENT,
  `istoreid` int(11) DEFAULT NULL,
  `vstorecode` varchar(25) DEFAULT NULL,
  `dinvoicedate` date DEFAULT NULL,
  `vinvnum` varchar(50) DEFAULT NULL,
  `vvendorid` varchar(25) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_warehouseitems`
--

DROP TABLE IF EXISTS `trn_warehouseitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_warehouseitems` (
  `iwtrnid` int(11) NOT NULL AUTO_INCREMENT,
  `vwhcode` varchar(20) DEFAULT NULL,
  `invoiceid` varchar(50) DEFAULT NULL,
  `vvendorid` int(11) DEFAULT NULL,
  `dreceivedate` date DEFAULT NULL,
  `vbarcode` varchar(50) DEFAULT NULL,
  `vitemname` varchar(100) DEFAULT NULL,
  `nitemqoh` decimal(15,2) DEFAULT '0.00',
  `npackqty` decimal(15,2) DEFAULT '0.00',
  `estatus` varchar(10) DEFAULT NULL,
  `vvendortype` varchar(10) DEFAULT NULL,
  `vtransfertype` varchar(25) DEFAULT NULL,
  `vsize` varchar(50) DEFAULT NULL,
  `ntransferqty` varchar(10) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iwtrnid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_warehouseqoh`
--

DROP TABLE IF EXISTS `trn_warehouseqoh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_warehouseqoh` (
  `vbarcode` varchar(50) DEFAULT NULL,
  `onhandcaseqty` decimal(15,2) DEFAULT '0.00',
  `npack` decimal(15,2) DEFAULT '0.00',
  `ivendorid` int(11) DEFAULT NULL,
  `iid` int(11) NOT NULL AUTO_INCREMENT,
  `euploadstatus` varchar(10) DEFAULT 'No',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iid`),
  KEY `idx_trnwarehouse_vbarcode` (`vbarcode`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trn_webadmin_history`
--

DROP TABLE IF EXISTS `trn_webadmin_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_webadmin_history` (
  `historyid` int(16) NOT NULL AUTO_INCREMENT,
  `userid` int(16) NOT NULL,
  `itemid` int(16) NOT NULL,
  `barcode` varchar(64) NOT NULL,
  `type` varchar(16) NOT NULL,
  `oldamount` decimal(15,2) NOT NULL,
  `newamount` decimal(15,2) NOT NULL,
  `source` varchar(64) NOT NULL,
  `general` longtext,
  `historydatetime` datetime DEFAULT NULL,
  `sid` int(11) NOT NULL DEFAULT '0',
  `lastupdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`historyid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `web_admin_settings`
--

DROP TABLE IF EXISTS `web_admin_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_admin_settings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `variablename` varchar(255) DEFAULT NULL,
  `variablevalue` text,
  `SID` int(11) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `web_mst_item`
--

DROP TABLE IF EXISTS `web_mst_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_mst_item` (
  `iitemid` int(11) NOT NULL AUTO_INCREMENT,
  `webstore` varchar(10) NOT NULL DEFAULT '0',
  `vitemtype` varchar(10) NOT NULL,
  `vitemcode` varchar(50) DEFAULT NULL,
  `vitemname` varchar(100) NOT NULL,
  `vunitcode` varchar(20) DEFAULT NULL,
  `vbarcode` varchar(50) NOT NULL,
  `vpricetype` varchar(50) DEFAULT NULL,
  `vcategorycode` varchar(20) NOT NULL,
  `vdepcode` varchar(20) DEFAULT NULL,
  `vsuppliercode` varchar(20) DEFAULT NULL,
  `iqtyonhand` int(11) DEFAULT '0',
  `ireorderpoint` int(11) DEFAULT '0',
  `dcostprice` decimal(15,4) DEFAULT '0.0000',
  `dunitprice` decimal(15,2) DEFAULT '0.00',
  `nsaleprice` decimal(15,4) DEFAULT '0.0000',
  `nlevel2` decimal(15,2) DEFAULT '0.00',
  `nlevel3` decimal(15,2) DEFAULT '0.00',
  `nlevel4` decimal(15,2) DEFAULT '0.00',
  `iquantity` int(11) DEFAULT '0',
  `ndiscountper` decimal(10,2) DEFAULT '0.00',
  `ndiscountamt` decimal(15,2) DEFAULT '0.00',
  `vtax1` varchar(2) DEFAULT NULL,
  `vtax2` varchar(2) DEFAULT NULL,
  `vfooditem` varchar(2) DEFAULT NULL,
  `vdescription` varchar(100) DEFAULT NULL,
  `dlastsold` date DEFAULT NULL,
  `visinventory` varchar(10) DEFAULT 'No',
  `dpricestartdatetime` timestamp NULL DEFAULT NULL,
  `dpriceenddatetime` timestamp NULL DEFAULT NULL,
  `estatus` varchar(10) NOT NULL,
  `nbuyqty` int(11) DEFAULT '0',
  `ndiscountqty` int(11) DEFAULT '0',
  `nsalediscountper` decimal(15,2) DEFAULT NULL,
  `vshowimage` varchar(10) DEFAULT NULL,
  `itemimage` longblob,
  `vageverify` varchar(10) DEFAULT NULL,
  `ebottledeposit` varchar(5) DEFAULT NULL,
  `nbottledepositamt` decimal(10,2) DEFAULT NULL,
  `vbarcodetype` varchar(25) DEFAULT 'Code 128',
  `ntareweight` decimal(15,2) DEFAULT '0.00',
  `ntareweightper` decimal(15,2) DEFAULT '0.00',
  `dcreated` date DEFAULT NULL,
  `dlastupdated` date DEFAULT NULL,
  `dlastreceived` date DEFAULT NULL,
  `dlastordered` date DEFAULT NULL,
  `nlastcost` decimal(15,2) DEFAULT '0.00',
  `nonorderqty` int(11) DEFAULT '0',
  `vparentitem` varchar(50) DEFAULT '0',
  `nchildqty` decimal(15,2) DEFAULT '0.00',
  `vsize` varchar(50) DEFAULT NULL,
  `npack` int(11) DEFAULT '1',
  `nunitcost` decimal(15,4) DEFAULT '0.0000',
  `ionupload` smallint(6) DEFAULT '0',
  `nsellunit` int(11) DEFAULT '1',
  `ilotterystartnum` int(11) DEFAULT '0',
  `ilotteryendnum` int(11) DEFAULT '0',
  `etransferstatus` varchar(201) DEFAULT NULL,
  `vsequence` varchar(5) DEFAULT '0',
  `vcolorcode` varchar(25) DEFAULT 'None',
  `vdiscount` varchar(5) DEFAULT 'Yes',
  `norderqtyupto` int(11) DEFAULT '0',
  `vshowsalesinzreport` varchar(10) DEFAULT 'No',
  `iinvtdefaultunit` smallint(6) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SID` int(11) NOT NULL DEFAULT '0',
  `stationid` int(11) DEFAULT '0',
  `shelfid` int(11) DEFAULT '0',
  `aisleid` int(11) DEFAULT '0',
  `updatetype` varchar(45) DEFAULT NULL,
  `mstid` int(11) DEFAULT NULL,
  PRIMARY KEY (`iitemid`),
  KEY `idx_web_item_vbarcode` (`vbarcode`),
  KEY `idx_web_item_vcategorycode` (`vcategorycode`),
  KEY `idx_web_item_vitecode` (`vitemcode`),
  KEY `idx_web_item_vitemname` (`vitemname`),
  KEY `idx_web_item_vitemtype` (`vitemtype`),
  KEY `idx_web_item_vsuppliercode` (`vsuppliercode`),
  KEY `idx_web_item_vunitcode` (`vunitcode`),
  KEY `idx_web_item_iitemid` (`iitemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `web_store_settings`
--

DROP TABLE IF EXISTS `web_store_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_store_settings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `variablename` varchar(255) DEFAULT NULL,
  `variablevalue` varchar(255) DEFAULT NULL,
  `SID` int(11) DEFAULT '0',
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `web_trn_hold_order`
--

DROP TABLE IF EXISTS `web_trn_hold_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_trn_hold_order` (
  `OrderId` int(11) NOT NULL AUTO_INCREMENT,
  `Quantity` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Source` varchar(15) DEFAULT NULL,
  `isPaid` bit(1) DEFAULT NULL,
  `Status` varchar(25) DEFAULT NULL,
  `isPrint` INT(1) NULL DEFAULT '0',
  PRIMARY KEY (`OrderId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `web_trn_hold_order_details`
--

DROP TABLE IF EXISTS `web_trn_hold_order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_trn_hold_order_details` (
  `DetailTransId` int(11) NOT NULL AUTO_INCREMENT,
  `TransId` int(11) NOT NULL,
  `ItemId` int(11) NOT NULL,
  `SubItemId` int(11) NOT NULL,
  `PrintSeq` int(11) NOT NULL,
  `MoreLessAction` varchar(16) NOT NULL,
  `Price` decimal(11,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`DetailTransId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `web_trn_hold_order_items`
--

DROP TABLE IF EXISTS `web_trn_hold_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_trn_hold_order_items` (
  `TransId` int(11) NOT NULL AUTO_INCREMENT,
  `OrderId` int(11) NOT NULL,
  `ItemId` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Price` decimal(11,2) NOT NULL,
  `Amount` decimal(11,2) NOT NULL,
  `SID` int(11) NOT NULL DEFAULT '0',
  `LastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TransId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'u0'
--
/*!50003 DROP PROCEDURE IF EXISTS `deleteitem` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `deleteitem`(VTRNID VARCHAR(200))
begin
declare tmpstring varchar(200);
declare ispos integer;
declare vstringid varchar(50);
declare itranid varchar(50);
declare VTID VARCHAR(50);

    set tmpstring = vtrnid;
    set ispos=1;
     WHILE (ispos <> 0 ) DO 
          set ispos = position(',' in tmpstring);
          if(ispos > 0) then
          set itranid =  trim(substring(tmpstring from 1 for ispos-1)) ;
          end if;
          if(ispos <= 0) then
          set itranid =  trim(tmpstring) ;
          end if;
            DELETE FROM mst_itemalias where vitemcode in (itranid);
                        delete from trn_quickitem where vtype = 'LotItem' and  vitemcode in (select  idetid FROM mst_itempackdetail where iitemid in  (itranid));
                        delete from trn_quickitem where vtype = 'Product' and   vitemcode in  (select vitemcode from mst_item WHERE iitemid in (itranid));
                        DELETE FROM mst_itempackdetail WHERE iitemid in (itranid) ;
                        DELETE FROM trn_itempricecosthistory WHERE iitemid in (itranid);
                        DELETE FROM mst_itemlotmatrix where vSku in (select vbarcode from mst_item WHERE iitemid in (itranid));
                        DELETE FROM mst_itemvendor WHERE iitemid in (itranid);
                        DELETE FROM mst_item WHERE iitemid in (itranid);

            set tmpstring = substring(tmpstring from ispos+1);
end while;
                
                     
                      

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteitemgroup` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `deleteitemgroup`(VTRNID VARCHAR(200))
begin
declare tmpstring varchar(200);
declare ispos integer;
declare vstringid varchar(50);
declare  VTID VARCHAR(50);
declare itranid varchar(100);

    set tmpstring = vtrnid;
    set ispos=1;
     WHILE (ispos <> 0 ) DO 
          set ispos = position(',' in tmpstring);
          if(ispos > 0) then
          set itranid =  trim(substring(tmpstring from 1 for ispos-1)) ;
          end if;
          if(ispos <= 0) then
          set itranid =  trim(tmpstring) ;
          end if;
          
          DELETE FROM trn_quickitem 
WHERE
    vtype = 'Group'
    AND vitemcode IN (itranid);
DELETE FROM mst_groupslabprice 
WHERE
    iitemgroupid IN (itranid);
DELETE FROM itemgroupdetail 
WHERE
    IitemgroupID IN (itranid);
DELETE FROM itemgroup 
WHERE
    IitemgroupID IN (itranid);
                        
          
           set tmpstring = substring(tmpstring from ispos+1);
          end while;
                    

           

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `HourlyData` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `HourlyData`(istime numeric(5,2),totalhour int)
BEGIN
declare i int;
declare outputstring varchar(50);
declare OSHOUR numeric(5,2); 
declare OEHOUR numeric(5,2); 
declare varam varchar(10);
declare varamto varchar(10);
declare varsdate decimal(15,2);
declare varedate decimal(15,2);
declare varsecoutput int;
 declare OAMTOPM VARCHAR(50); 
 declare VAROUTPUT VARCHAR(10); 
 declare VARENDOUTPUT VARCHAR(10);
 declare ihour numeric(5,2); 
set i=0;  		
		

CREATE TABLE IF NOT EXISTS poshour (outputstring VARCHAR(50),hours numeric(5,2),sequence int);   
	delete from poshour;
    while( i <= totalhour) do

   if(istime >= 24 ) then
     set  istime=0;
     end if;
    set oshour = istime;
    set varoutput =   replace(cast(istime as char(10)),'.',':');
     set oehour = oshour +1;
    if(istime-cast(istime as decimal) = 0) then
        set varendoutput =    replace(cast((oehour+0.59)-1 as char(10)),'.',':');
        end if;
    if(istime-cast(istime as decimal) <> 0) then
        set varendoutput =    replace(cast(oehour as char(10)),'.',':');
        end if;

   set varam = ' AM ';
    set varamto =' AM TO ';
    set varsdate = oshour;
    set varedate = oehour;
        if(oehour >= 13) then
            set varam = ' PM ';
            set varedate=oehour-12;
        end if;
        if(oshour >= 13) then
        
            set varamto = ' PM TO ';
            set varsdate = oshour-12;
            if(varsdate = 0) then
            set varsdate = 12;
            end if;
        end if;
         if(oshour = 0) then
        
            set varamto = ' PM TO ';
            set varsdate = 12;
        end if;
    set oamtopm = Concat(CAST(varsdate as char(10)) , varamto,CAST(varedate as char(10)),varam)  ;
    set ihour = (oehour - 1);
    insert into poshour values(oamtopm,ihour,i);
    
   set istime = oehour;
   set i = i +1;   
 
  end while;   
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `HourlySales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `HourlySales`(batchid integer)
BEGIN
SELECT h.outputstring, 
       case when sum(nnettotal) is null then 0 else sum(nnettotal) end AS total 
FROM poshour AS h
LEFT OUTER
  JOIN  trn_sales 
  on EXTRACT(HOUR FROM dtrandate) = h.hours AND ibatchid=batchid  and vtrntype='Transaction'                           
GROUP  BY h.hours 
order by h.sequence;	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `new_daily` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `new_daily`(dailysalesdate  date)
BEGIN
declare nopebalance numeric(15,2);
SELECT 
		CASE
			WHEN SUM(nOpeningBalance) IS NULL THEN 0
			ELSE SUM(nOpeningBalance)
		END AS opal
		into nopebalance FROM
		trn_batch
		WHERE
		EXTRACT(MONTH FROM dBatchStartTime) = EXTRACT(MONTH FROM dailysalesdate)
		AND EXTRACT(DAY FROM dBatchStartTime) = EXTRACT(DAY FROM dailysalesdate)
		AND EXTRACT(YEAR FROM dBatchStartTime) = EXTRACT(YEAR FROM dailysalesdate);
        
        select (nopebalance+250) from dual;
        

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_cashpickup` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_cashpickup`(sdate varchar(20),iterminalid int)
BEGIN
	if(iterminalid = 0) then
     
     select namount,date_format(vdatetime,'%h:%i') as vdatetime,vname from(
 SELECT NNETTOTAL as namount,dtrandate as vdatetime,concat('Pick Up',@s:=@s+1) as vname
  FROM trn_sales,(SELECT @s:= 0) AS s
  WHERE vtrntype='Cash pickup' and date_format(dtrandate,'%m-%d-%Y') = sdate 
  ) as a;
    end if;
    if(iterminalid != 0) then
      
       select namount,date_format(vdatetime,'%h:%i') as vdatetime,vname from(
 SELECT NNETTOTAL as namount,dtrandate as vdatetime,concat('Pick Up',@s:=@s+1) as vname
  FROM trn_sales,(SELECT @s:= 0) AS s
  WHERE vtrntype='Cash pickup' and date_format(dtrandate,'%m-%d-%Y') = sdate and vterminalid = iterminalid 
  ) as a;
			
    end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_commissionreport` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_commissionreport`(sdate varchar(20),edate varchar(20))
BEGIN
select date_format(dclosedate,'%m-%d-%Y') as dclosedate,SUM(nclosingamount) as NTOTALSALES,sum(NCASHSHORTOVER) as NCASHSHORTOVER,sum(NINSTANTCOMMISSION) as NINSTANTCOMMISSION ,sum(isoldbook)  as  NBOOKSOLD from    trn_instantcloseday a 
    where date_format(dclosedate,'%Y-%m-%d')  
                between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
    group by dclosedate   ;
    
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_creditsales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_creditsales`(sdate varchar(20),edate varchar(20),vtype varchar(20))
BEGIN
	if(vtype='By Month') then
    
	SELECT  PDATE,AMOUNT,sdate as odate,edate as oedate
	FROM (select  date_format(a.dtrandate,'%m-%Y') as PDATE,
                case when sum(b.NAMOUNT) is null then 0 else sum(b.NAMOUNT) end as AMOUNT
                from trn_sales a,trn_salestender b,mst_tentertype c 
                where UPPER(c.VTENDERTAG)IN('CREDIT','DEBIT','EBT','CHECK')
                AND  a.ISALESID=b.ISALESID AND b.itenerid=c.itenderid 
                AND  date_format(a.dtrandate,'%Y-%m-%d')  
				between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and vtrntype='Transaction'
                group by 1 ) as m;
                
    end if;
    if(vtype='By Date') then
    
	SELECT  PDATE,AMOUNT,sdate as odate,edate as oedate
	FROM (select  date_format(a.dtrandate,'%m-%d-%Y') as PDATE,
                case when sum(b.NAMOUNT) is null then 0 else sum(b.NAMOUNT) end as AMOUNT
                from trn_sales a,trn_salestender b,mst_tentertype c 
                where UPPER(c.VTENDERTAG)IN('CREDIT','DEBIT','EBT','CHECK')
                AND  a.ISALESID=b.ISALESID AND b.itenerid=c.itenderid 
                AND  date_format(a.dtrandate,'%Y-%m-%d')  
				between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and vtrntype='Transaction'
                group by 1 ) as m;
                
    end if;
     if(vtype='By Year') then
    
	SELECT  PDATE,AMOUNT,sdate as odate,edate as oedate
	FROM (select  date_format(a.dtrandate,'%Y') as PDATE,
                case when sum(b.NAMOUNT) is null then 0 else sum(b.NAMOUNT) end as AMOUNT
                from trn_sales a,trn_salestender b,mst_tentertype c 
                where UPPER(c.VTENDERTAG)IN('CREDIT','DEBIT','EBT','CHECK')
                AND  a.ISALESID=b.ISALESID AND b.itenerid=c.itenderid 
                AND  date_format(a.dtrandate,'%Y-%m-%d')  
				between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and vtrntype='Transaction'
                group by 1 ) as m;
                
    end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_credittransaction` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_credittransaction`(sdate varchar(20),edate varchar(20))
BEGIN

  select dtrandate as dtrantime  ,vCardType, vTenderType, vCMDStatus, nPurchaseAmount, nAuthAmount,LPAD(vCardUsage,9,'*') as vcardusage,sdate as SODATE,edate as EODATE from trn_mpstender 
	where
	date_format(dtrandate,'%Y-%m-%d')  
	between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
	order by dtrandate  desc;
  
 

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_customerlist` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_customerlist`()
BEGIN
select c.vcustomername as fname,c.vlname as lname,c.vaddress1 as address,c.vcity as city,c.vstate as state,c.vzip as zip,c.vphone as phone
from mst_customer c
ORDER BY c.vfname,c.vlname;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_customersales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_customersales`(sdate  varchar(20),edate varchar(20))
BEGIN
select fname,'' as lname,qtysold,extprice,sdate as sodate,edate as eodate from (
select c.vcustomername as fname ,sum(a.iunitqty) as QtySold,sum(a.nextunitprice) as ExtPrice
from trn_salesdetail a,trn_sales b,mst_customer c
WHERE a.isalesid= b.isalesid and b.icustomerid = c.icustomerid
AND  date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and b.vtrntype='Transaction'
GROUP by c.vcustomername
ORDER BY c.vcustomername ) as a;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_dailysalesbydatereport` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `rp_dailysalesbydatereport`(sdate  varchar(20))
BEGIN
	
	declare  NETTOTAL NUMERIC(15, 2);
	declare NTAXABLE NUMERIC(15, 2);
	declare NNONTAXABLETOTAL NUMERIC(15, 2);
	declare NDISCOUNTAMT NUMERIC(15, 2);
	declare  NTAXTOTAL NUMERIC(15, 2);
	declare  NOPENINGBALANCE NUMERIC(15, 2);
	declare  NADDCASH NUMERIC(15, 2);
	declare NCLOSINGBALANCE NUMERIC(15, 2);
	declare  NONACCOUNT NUMERIC(15, 2);
	declare  NONCREDITTOTAL NUMERIC(15, 2);
	declare  NSUBTOTAL NUMERIC(15, 2);
	declare  NPAIDOUT NUMERIC(15, 2);
	declare  NPICKUP NUMERIC(15, 2);
	declare  NTOTALSALESWTAX NUMERIC(15, 2);
	declare OIBATCHID INTEGER;
	declare NTOTALSALEDISCOUNT NUMERIC(15, 2);
	DECLARE  Nebtsales NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NRETURNAMOUNT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NCASHAMOUNT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NCHECKAMOUNT NUMERIC(15, 2) DEFAULT '0';
     DECLARE WICAMOUNT NUMERIC(15, 2) DEFAULT '0';
    DECLARE  ISales NUMERIC(15, 2) DEFAULT '0';
	DECLARE  LSales NUMERIC(15, 2) DEFAULT '0';
	DECLARE  IRedeem NUMERIC(15, 2) DEFAULT '0';
	DECLARE  LRedeem NUMERIC(15, 2) DEFAULT '0';
    DECLARE  onhandSalesRedeem NUMERIC(15, 2) DEFAULT '0';
		set NCLOSINGBALANCE =0;
		set NCLOSINGBALANCE =0;
        
        
        SELECT  case when sum(a.NNETTOTAL) is null then 0 else sum(a.NNETTOTAL) end,
        case when sum(a.NTAXABLETOTAL) is null then 0 else sum(a.NTAXABLETOTAL) end
        ,case when sum(a.NNONTAXABLETOTAL) is null then 0 else  sum(a.NNONTAXABLETOTAL) end,
        case when SUM(a.NDISCOUNTAMT) is null then 0 else SUM(a.NDISCOUNTAMT) end,
        case when SUM(a.NTAXTOTAL) is null then 0 else SUM(a.NTAXTOTAL) end ,
        case when sum(a.NSALETOTALAMT) is null then 0 else SUM(a.NSALETOTALAMT) end 
        FROM trn_sales as a
		WHERE iOnAccount != 1 and vtrntype='Transaction' and date_format(a.dtrandate,'%m-%d-%Y') = sdate
         into nettotal,ntaxable,nnontaxabletotal,ndiscountamt,ntaxtotal,ntotalsalediscount;
        
		SELECT case when sum(NOpeningBalance) is null then 0 else sum(NOpeningBalance) end  FROM trn_batch
		WHERE  date_format(dBatchStartTime,'%m-%d-%Y') = sdate
        group by date_format(dBatchStartTime,'%m-%d-%Y')
		into NOPENINGBALANCE;
        
         SELECT case when sum(a.NNETTOTAL) is null then 0 else sum(a.NNETTOTAL) end FROM trn_sales as a
			WHERE vtrntype='Add Cash' and  date_format(a.dtrandate,'%m-%d-%Y') = sdate
			into naddcash;
		
        set NCLOSINGBALANCE = nopeningbalance  + naddcash ;
        
			SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			FROM trn_sales a,trn_salestender b,mst_tentertype c
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
			and b.itenerid = c.itenderid  and date_format(a.dtrandate,'%m-%d-%Y') = sdate
			and c.vtendertag in ('Credit','Debit','Gift')
			into noncredittotal;
            
			set NCLOSINGBALANCE = NCLOSINGBALANCE+noncredittotal;        
			set NSUBTOTAL = noncredittotal;
            
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
				and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%m-%d-%Y') = sdate
				and c.vtendertag in ('OnAcct')
				into nonaccount ;
                set NCLOSINGBALANCE = NCLOSINGBALANCE+nonaccount;
				set NSUBTOTAL = NSUBTOTAL+NONACCOUNT;
                
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
				and b.itenerid = c.itenderid  and date_format(a.dtrandate,'%m-%d-%Y') = sdate
				and c.vtendertag in ('Ebt')
				into Nebtsales;
                 set NCLOSINGBALANCE = NCLOSINGBALANCE+Nebtsales;
				set NSUBTOTAL = NSUBTOTAL+Nebtsales;
                
                
			SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			into NCASHAMOUNT FROM trn_sales a,trn_salestender b,mst_tentertype c 
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 101
			and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%m-%d-%Y') = sdate ; 
			
              set NCLOSINGBALANCE = NCLOSINGBALANCE+NCASHAMOUNT;
				set NSUBTOTAL = NSUBTOTAL+NCASHAMOUNT;
                
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid in (102,124)
				and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%m-%d-%Y') = sdate
				into NCHECKAMOUNT;
				set NCLOSINGBALANCE = NCLOSINGBALANCE+NCHECKAMOUNT;
				set NSUBTOTAL = NSUBTOTAL+NCHECKAMOUNT;
                
                SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 124
				and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%m-%d-%Y') = sdate
				into WICAMOUNT;
                set NCHECKAMOUNT = NCHECKAMOUNT + WICAMOUNT;
				set NCLOSINGBALANCE = NCLOSINGBALANCE+WICAMOUNT;
				set NSUBTOTAL = NSUBTOTAL+WICAMOUNT;
                
					SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
					FROM trn_sales a,trn_salestender b,mst_tentertype c
					WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 120
					and b.itenerid = c.itenderid and date_format(a.dtrandate,'%m-%d-%Y') = sdate
					into NRETURNAMOUNT;                   
                    
                    
					SELECT case when sum(NNETTOTAL) is null then 0 else sum(NNETTOTAL) end    FROM trn_sales as a
					WHERE vtrntype='Cash pickup' and date_format(a.dtrandate,'%m-%d-%Y') = sdate
					into npickup;
                    
					select  case when sum(b.namount) is null  then  0 else  sum(b.namount) end
					from  trn_paidout a,trn_paidoutdetail b
					where a.ipaidouttrnid = b.ipaidouttrnid and date_format(a.ddate,'%m-%d-%Y') = sdate
					AND  a.VUNIQUETRANID = b.VUNIQUETRANID   and b.vpaidoutname is not null
					into npaidout;
			
					 set NCLOSINGBALANCE = NCLOSINGBALANCE -  (npaidout+npickup);
                     set ntotalsaleswtax = ntaxable +  nnontaxabletotal;
       
					select case when sum(o.LSales) is null then 0 else sum(o.LSales) end ,
					case when sum(ISales) is null then 0 else sum(o.ISales) end ,
					case when sum(LRedeem)is null then 0 else sum(o.LRedeem) end ,
					case when sum(IRedeem) is null then 0 else sum(o.IRedeem) end 
                    into LSales,ISales,LRedeem,IRedeem
					from 
					(select case when l.vitemcode = "20" then extprice else 0 end   as 'LSales' ,
					case when l.vitemcode = "21" then  extprice else 0 end   as 'ISales',
					case when l.vitemcode = "22" then  extprice else 0 end   as 'LRedeem',
					case when l.vitemcode = "23" then  extprice else 0 end   as 'IRedeem'
					from
					(select  vitemcode,sum(nextunitprice) as extprice
					from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid  and a.vitemcode in('20','21','22','23') 
                    and date_format(b.dtrandate,'%m-%d-%Y')= sdate 
					group by  vitemcode) as l ) as o;                   
					set onhandSalesRedeem = (LSales+ISales) - ((LRedeem*-1)+(IRedeem*-1));
            
        select sdate as osdate,ntotalsaleswtax,npaidout,npickup,npaidout,NRETURNAMOUNT,NCHECKAMOUNT,NCASHAMOUNT,Nebtsales,NSUBTOTAL,nonaccount,noncredittotal,naddcash,nettotal,ntaxable,nnontaxabletotal,ndiscountamt,NTAXTOTAL,ntotalsalediscount,NOPENINGBALANCE,NCLOSINGBALANCE,LSales,ISales,LRedeem,IRedeem,onhandSalesRedeem from dual;

END;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_dailysalesbyuser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_dailysalesbyuser`(sdate varchar(20))
BEGIN

 select clerk,totalcount,totalsales,sdate as sodate from (select Concat(b.vFNAME ,' ' , b.vLname) as Clerk, count(iSalesID) as TotalCount,SUM(nnettotal) as TotalSales
from trn_sales a,mst_user b
where a.iuserID = b.iuserid  and a.vTrntype ='Transaction'
and  date_format(DTRANDATE,'%m-%d-%Y') = sdate
group by a.iuserid,b.vFNAME ,b.vLNAME
order by a.iuserid ) as aa;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_dailysalesitem` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_dailysalesitem`(sdate varchar(20),edate varchar(20),vreporttype varchar(20))
BEGIN

	if(vreporttype='Category') then
    
		select vitemcode,itemname,vname,qtysold,amount,sdate as SODATE,edate as EODATE from (select vitemcode,vitemname as itemname,vcatname as vname,sum(iunitqty) as qtysold,sum(nextunitprice) as amount
        from trn_salesdetail a,trn_sales b
        where a.isalesid = b.isalesid and date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and b.vtrntype='Transaction'  and (a.vcatname <> '' or a.vcatname is not null)
        group by  vitemcode,vitemname,vcatname
        order by vcatname,vitemname ) as a ;        
    end if;
    
    if(vreporttype='Department') then
    
		select vitemcode,itemname,vname,qtysold,amount,sdate as SODATE,edate as EODATE from (select vitemcode,vitemname as itemname,vdepname as vname,sum(iunitqty) as qtysold,sum(nextunitprice) as amount
        from trn_salesdetail a,trn_sales b
        where a.isalesid = b.isalesid and date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and b.vtrntype='Transaction'  and (a.vdepname <> '' or a.vdepname is not null)
        group by  vitemcode,vitemname,vdepname
        order by vdepname,vitemname ) as a   ;      
    end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_datecategory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_datecategory`(sdate varchar(20),edate varchar(20))
BEGIN
select vcategoryame,namount,sdate as osdate,edate as oedate from(
select vcatname as vcategoryame,CASE when sum(nExtunitPrice+nItemTax) is null then 0 else sum(nExtunitPrice+nItemTax) end as namount
  from trn_salesdetail a,trn_sales b
  where a.isalesid = b.isalesid and vcatname is not null
  and  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
  group by vcatname ) as a;
  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_datedepartment` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_datedepartment`(sdate varchar(20),edate varchar(20))
BEGIN
select vdepatname,namount, sdate as osdate,edate as  oedate from(
  select vdepname as vdepatname,CASE when sum(nExtunitPrice+nItemTax) is null then 0 else sum(nExtunitPrice+nItemTax) end as namount
  from trn_salesdetail a,trn_sales b
  where a.isalesid = b.isalesid and vcatname is not null
  and  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
  group by vdepname ) as a;
  

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_datepaidout` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_datepaidout`(sdate varchar(20),edate  varchar(20),vendor varchar(500))
BEGIN

	if(vendor='ALL') then
		select vpaidoutname,namount,DDATE,sdate as osdate,edate as oedate from (
		select b.vpaidoutname, sum(b.namount) as nAmount,date_format(a.ddate,'%m-%d-%Y') as ddate
		  from  trn_paidout a,trn_paidoutdetail b
		  where a.ipaidouttrnid = b.ipaidouttrnid and date_format(a.dddate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
		  AND  a.VUNIQUETRANID = b.VUNIQUETRANID and  b.vpaidoutname is not null
		  group by  a.DDATE,b.vpaidoutname ) as a;
      else
		select vpaidoutname,namount,DDATE,sdate as osdate,edate as oedate from (
		select b.vpaidoutname, sum(b.namount) as nAmount,date_format(a.ddate,'%m-%d-%Y') as ddate
		  from  trn_paidout a,trn_paidoutdetail b
		  where a.ipaidouttrnid = b.ipaidouttrnid and FIND_IN_SET((vpaidoutname), vendor) and date_format(a.dbdate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
		  AND  a.VUNIQUETRANID = b.VUNIQUETRANID and  b.vpaidoutname is not null
		  group by  a.DDATE,b.vpaidoutname )   as a order by vpaidoutname;
      
      end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_datepickup` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_datepickup`(sdate  varchar(20),edate varchar(20))
BEGIN

  select namount,date_format(vdatetime,'%m-%d-%Y %h:%i') as vdatetime,vpickname,sdate as osdate,edate as oedate from(
 SELECT NNETTOTAL as namount,dtrandate as vdatetime,concat('Pick Up',@s:=@s+1) as vpickname
  FROM trn_sales,(SELECT @s:= 0) AS s
  WHERE vtrntype='Cash pickup' and date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') ) as a;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_datereport` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_datereport`(sdate varchar(20),edate varchar(20))
BEGIN
	
	declare  NETTOTAL NUMERIC(15, 2);
	declare NTAXABLE NUMERIC(15, 2);
	declare NNONTAXABLETOTAL NUMERIC(15, 2);
	declare NDISCOUNTAMT NUMERIC(15, 2);
	declare  NTAXTOTAL NUMERIC(15, 2);
	declare  NOPENINGBALANCE NUMERIC(15, 2);
	declare  NADDCASH NUMERIC(15, 2);
	declare NCLOSINGBALANCE NUMERIC(15, 2);
	declare  NONACCOUNT NUMERIC(15, 2);
	declare  NONCREDITTOTAL NUMERIC(15, 2);
	declare  NSUBTOTAL NUMERIC(15, 2);
	declare  NPAIDOUT NUMERIC(15, 2);
	declare  NPICKUP NUMERIC(15, 2);
	declare  NTOTALSALESWTAX NUMERIC(15, 2);
	declare OIBATCHID INTEGER;
	declare NTOTALSALEDISCOUNT NUMERIC(15, 2);
	DECLARE  Nebtsales NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NRETURNAMOUNT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NCASHAMOUNT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NCHECKAMOUNT NUMERIC(15, 2) DEFAULT '0';
    DECLARE WICAMOUNT NUMERIC(15, 2) DEFAULT '0';
    DECLARE  ISales NUMERIC(15, 2) DEFAULT '0';
	DECLARE  LSales NUMERIC(15, 2) DEFAULT '0';
	DECLARE  IRedeem NUMERIC(15, 2) DEFAULT '0';
	DECLARE  LRedeem NUMERIC(15, 2) DEFAULT '0';
    DECLARE  onhandSalesRedeem NUMERIC(15, 2) DEFAULT '0';
		set NCLOSINGBALANCE =0;
        
        
        SELECT  case when sum(a.NNETTOTAL) is null then 0 else sum(a.NNETTOTAL) end,
        case when sum(a.NTAXABLETOTAL) is null then 0 else sum(a.NTAXABLETOTAL) end
        ,case when sum(a.NNONTAXABLETOTAL) is null then 0 else  sum(a.NNONTAXABLETOTAL) end,
        case when SUM(a.NDISCOUNTAMT) is null then 0 else SUM(a.NDISCOUNTAMT) end,
        case when SUM(a.NTAXTOTAL) is null then 0 else SUM(a.NTAXTOTAL) end ,
        case when sum(a.NSALETOTALAMT) is null then 0 else SUM(a.NSALETOTALAMT) end 
        FROM trn_sales as a
		WHERE iOnAccount != 1 and vtrntype='Transaction' and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
         into nettotal,ntaxable,nnontaxabletotal,ndiscountamt,ntaxtotal,ntotalsalediscount;
        		
         SELECT case when sum(a.NNETTOTAL) is null then 0 else sum(a.NNETTOTAL) end FROM trn_sales as a
			WHERE vtrntype='Add Cash' and  date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
			into naddcash;
		
        set NCLOSINGBALANCE = NCLOSINGBALANCE  + naddcash ;
        
			SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			FROM trn_sales a,trn_salestender b,mst_tentertype c
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
			and b.itenerid = c.itenderid  and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
			and c.vtendertag in ('Credit','Debit','Gift')
			into noncredittotal;
            
			set NCLOSINGBALANCE = NCLOSINGBALANCE+noncredittotal;        
			set NSUBTOTAL = noncredittotal;
            
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
				and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
				and c.vtendertag in ('OnAcct')
				into nonaccount ;
                set NCLOSINGBALANCE = NCLOSINGBALANCE+nonaccount;
				set NSUBTOTAL = NSUBTOTAL+NONACCOUNT;
                
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
				and b.itenerid = c.itenderid  and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
				and c.vtendertag in ('Ebt')
				into Nebtsales;
                 set NCLOSINGBALANCE = NCLOSINGBALANCE+Nebtsales;
				set NSUBTOTAL = NSUBTOTAL+Nebtsales;
                
                
			SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			into NCASHAMOUNT FROM trn_sales a,trn_salestender b,mst_tentertype c 
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 101
			and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y');
			
              set NCLOSINGBALANCE = NCLOSINGBALANCE+NCASHAMOUNT;
				set NSUBTOTAL = NSUBTOTAL+NCASHAMOUNT;
                
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 102
				and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
				into NCHECKAMOUNT;
				set NCLOSINGBALANCE = NCLOSINGBALANCE+NCHECKAMOUNT;
				set NSUBTOTAL = NSUBTOTAL+NCHECKAMOUNT;
                
					SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
					FROM trn_sales a,trn_salestender b,mst_tentertype c
					WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 124
					and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
					into WICAMOUNT;
					set NCHECKAMOUNT = NCHECKAMOUNT + WICAMOUNT;
					set NCLOSINGBALANCE = NCLOSINGBALANCE+WICAMOUNT;
					set NSUBTOTAL = NSUBTOTAL+WICAMOUNT;
                
					SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
					FROM trn_sales a,trn_salestender b,mst_tentertype c
					WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 120
					and b.itenerid = c.itenderid and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
					into NRETURNAMOUNT;
                    
               
                    
					SELECT case when sum(NNETTOTAL) is null then 0 else sum(NNETTOTAL) end    FROM trn_sales as a
					WHERE vtrntype='Cash pickup' and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
					into npickup;
                    
					select  case when sum(b.namount) is null  then  0 else  sum(b.namount) end
					from  trn_paidout a,trn_paidoutdetail b
					where a.ipaidouttrnid = b.ipaidouttrnid and date_format(a.ddate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
					AND  a.VUNIQUETRANID = b.VUNIQUETRANID   and b.vpaidoutname is not null
					into npaidout;
			
					 set NCLOSINGBALANCE = NCLOSINGBALANCE -  (npaidout +npickup);
                     set ntotalsaleswtax = ntaxable +  nnontaxabletotal;
						
                        
					select case when sum(o.LSales) is null then 0 else sum(o.LSales) end ,
					case when sum(ISales) is null then 0 else sum(o.ISales) end ,
					case when sum(LRedeem)is null then 0 else sum(o.LRedeem) end ,
					case when sum(IRedeem) is null then 0 else sum(o.IRedeem) end 
                    into LSales,ISales,LRedeem,IRedeem
					from 
					(select case when l.vitemcode = "20" then extprice else 0 end   as 'LSales' ,
					case when l.vitemcode = "21" then  extprice else 0 end   as 'ISales',
					case when l.vitemcode = "22" then  extprice else 0 end   as 'LRedeem',
					case when l.vitemcode = "23" then  extprice else 0 end   as 'IRedeem'
					from
					(select  vitemcode,sum(nextunitprice) as extprice
					from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid  and a.vitemcode in('20','21','22','23') 
                    and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
					group by  vitemcode) as l ) as o;
                   
					set onhandSalesRedeem = (LSales+ISales) - ((LRedeem*-1)+(IRedeem*-1));
            
        select sdate as osdate,edate as oedate,ntotalsaleswtax,npaidout,npickup,npaidout,NRETURNAMOUNT,NCHECKAMOUNT,NCASHAMOUNT,Nebtsales,NSUBTOTAL,nonaccount,noncredittotal,naddcash,nettotal,ntaxable,nnontaxabletotal,ndiscountamt,NTAXTOTAL,ntotalsalediscount,NOPENINGBALANCE,NCLOSINGBALANCE,LSales,ISales,LRedeem,IRedeem,onhandSalesRedeem from dual;

END;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_datetender` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_datetender`(sdate varchar(20),edate  varchar(20))
BEGIN
select vtendername,namount,ntotcount,sdate as osdate ,edate as oedate from 
	(SELECT b.vtendername,sum(b.namount) as namount,count(b.itenerid) as ntotcount
  FROM trn_sales a,trn_salestender b,mst_tentertype c
  WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
  and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
  group by b.vtendername,c.vtendertag
   ) as a;
  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_datewisedailysales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_datewisedailysales`(sdate varchar(20),edate varchar(20))
BEGIN
select pdate,NNETTOTAL,tax,sdate as odate,edate as oedate from(

select   		date_format(dtrandate,'%m-%d-%Y') as pdate,	
                case when sum(nnettotal) is null then 0 else sum(nnettotal)  end as NNETTOTAL ,
                case when sum(NTAXTOTAL) is null then 0 else sum(NTAXTOTAL) end as TAX
                from trn_sales where date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and vtrntype='Transaction'
                GROUP by pdate ) as a;
                
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_datewisemonthlysales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_datewisemonthlysales`(sdate varchar(20),edate varchar(20))
BEGIN
					select PDATE,TAX,NONTAX,NNETTOTAL,sdate as odate,edate as oedate from (	select     date_format(dtrandate,'%M-%Y') as PDATE,
		case when sum(NTAXTOTAL) is null then 0 else sum(NTAXTOTAL) end as TAX,
		case when sum(NNONTAXABLETOTAL) is null then 0 else sum(NNONTAXABLETOTAL) end as NONTAX,
		case when sum(nnettotal) is null then 0 else sum(nnettotal)  end as NNETTOTAL
		from trn_sales 
		where date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and vtrntype='Transaction'
		group by 1 ) as a;
                 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_departmentsummary` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_departmentsummary`(sdate varchar(20),edate varchar(20))
BEGIN

select vdepartmentname,qtysold,extunitprice,extcostprice,sdate as SODATE,edate as EODATE from (select a.vdepname as vdepartmentname,sum(a.iunitqty) as qtysold,sum(a.nextunitprice) as extunitprice,sum(a.nextcostprice) as extcostprice
from trn_salesdetail a,trn_sales b
where date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
and a.isalesid = b.isalesid and b.vtrntype='Transaction'
GROUP BY a.vdepname
ORDER BY a.vdepname) as a;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_endofshift` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_endofshift`(eofdate varchar(20))
BEGIN
	
					
       select 0 as oibathcid,(ntotaltaxable+ntotalnontaxable) as ntotalsaleswtax, nnetpaidout as npaidout,nnetcashpickup as npickup,
       ntotalreturns as NRETURNAMOUNT,ntotalchecksales as NCHECKAMOUNT,ntotalcashsales as NCASHAMOUNT,
       ntotalebtsales as Nebtsales,ntotalsales as NSUBTOTAL,0 as nonaccount,(ntotalcreditsales+ntotaldebitsales) as noncredittotal,
       nnetaddcash as naddcash,eofdate as VBATCHANAME,'' as VREGNAME,
       nnetsales as nettotal,ntotaltaxable as ntaxable,ntotalnontaxable as nnontaxabletotal,
       ntotaldiscount as ndiscountamt,ntotaltax as NTAXTOTAL,
       0 as ntotalsalediscount,nopeningbalance as NOPENINGBALANCE,
       nclosingbalance as NCLOSINGBALANCE,(nopeningbalance+ntotalcashsales+nnetaddcash)-(nnetpaidout+nnetcashpickup) as CASHONDRAWER,
       nuserclosingbalance as userclosingbalance,
       ((nopeningbalance+ntotalcashsales +nnetaddcash)-(nnetpaidout+nnetcashpickup) )- nuserclosingbalance as CashShort 
       from trn_endofday where date_format(dstartdatetime,'%m-%d-%Y' ) = eofdate ;   
       

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_eofcategory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_eofcategory`(eofdate varchar(20))
BEGIN
select vcategoryame,namount,0 as oibatchid from (
	select vcatname as vcategoryame,CASE when sum(nExtunitPrice+nItemTax) is null then 0 else sum(nExtunitPrice+nItemTax) end as namount
  from trn_salesdetail a,trn_sales b
  where a.isalesid = b.isalesid and vcatname is not null
  and  b.vtrntype='Transaction' and  b.ibatchid in (select batchid from trn_endofday a,trn_endofdaydetail b
where date_format(a.dstartdatetime,'%m-%d-%Y' ) = eofdate
and a.id =  b.eodid)
  group by vcatname ) as a ;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_eofdepartment` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_eofdepartment`(eofdate varchar(20))
BEGIN
select vdepatname,namount,0 as oibatchid from(
 select vdepname as vdepatname,CASE when sum(nExtunitPrice+nItemTax) is null then 0 else sum(nExtunitPrice+nItemTax) end as namount
  from trn_salesdetail a,trn_sales b
  where a.isalesid = b.isalesid and vcatname is not null
  and  b.vtrntype='Transaction' and  b.ibatchid in (select batchid from trn_endofday a,trn_endofdaydetail b
where date_format(a.dstartdatetime,'%m-%d-%Y' ) = eofdate
and a.id =  b.eodid)
  group by vdepname ) as a;
  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_eofhourlysales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_eofhourlysales`(eofdate varchar(20))
BEGIN
SELECT case when(hours > 12 ) then concat(hours-12," PM") else concat(hours," AM") end as TODATE, 
       case when sum(nnettotal) is null then 0 else sum(nnettotal) end AS AMT 
FROM poshour AS h
LEFT OUTER
  JOIN  trn_sales  as a
  on EXTRACT(HOUR FROM dtrandate) = h.hours AND a.ibatchid in  (select batchid from trn_endofday a,trn_endofdaydetail b
where date_format(a.dstartdatetime,'%m-%d-%Y' ) = eofdate
and a.id =  b.eodid) and  a.vtrntype='Transaction'                          
GROUP  BY h.hours 
order by h.sequence;	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_eofpaidout` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_eofpaidout`(eofdate varchar(20))
BEGIN
select vpaidoutname,namount,0 as oibatchid from(
	select b.vpaidoutname, sum(b.namount) as nAmount
  from  trn_paidout a,trn_paidoutdetail b
  where a.ipaidouttrnid = b.ipaidouttrnid and a.ibatchid in (select batchid from trn_endofday a,trn_endofdaydetail b
where date_format(a.dstartdatetime,'%m-%d-%Y' ) = eofdate
and a.id =  b.eodid)
  AND  a.VUNIQUETRANID = b.VUNIQUETRANID and  b.vpaidoutname is not null
  group by  b.vpaidoutname ) as aa;
  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_eofpickup` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_eofpickup`(eofdate varchar(20))
BEGIN
select namount,date_format(vdatetime,'%h:%i') as vdatetime,vpickname,0 as oibatchid from(
 SELECT NNETTOTAL as namount,dtrandate as vdatetime,concat('Pick Up',@s:=@s+1) as vpickname
  FROM trn_sales a,(SELECT @s:= 0) AS s
  WHERE vtrntype='Cash pickup' and a.ibatchid in(select batchid from trn_endofday a,trn_endofdaydetail b
where date_format(a.dstartdatetime,'%m-%d-%Y' ) = eofdate
and a.id =  b.eodid)
  ) as a;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_eoftender` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_eoftender`(eofdate varchar(20))
BEGIN

select vtendername,namount,ntotcount,0 as oibatchid from (
  SELECT b.vtendername,sum(b.namount) as namount,count(b.itenerid) as ntotcount
  FROM trn_sales a,trn_salestender b,mst_tentertype c
  WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
  and b.itenerid = c.itenderid   and a.ibatchid in (select batchid from trn_endofday a,trn_endofdaydetail b
where date_format(a.dstartdatetime,'%m-%d-%Y' ) = eofdate
and a.id =  b.eodid)
  group by b.vtendername,c.vtendertag
  
   ) as aa ;   
  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_hourlysales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_hourlysales`(sdate varchar(20))
BEGIN

SELECT case when(hours > 12 ) then concat(hours-12," PM") else concat(hours," AM") end as TODATE, 
       case when sum(nnettotal) is null then 0 else sum(nnettotal) end AS AMT,
       sdate as ODATE
FROM poshour AS h
LEFT OUTER
  JOIN  trn_sales as a
  on EXTRACT(HOUR FROM dtrandate) = h.hours AND  date_format(dtrandate,'%m-%d-%Y') = sdate and a.vtrntype='Transaction'
GROUP  BY h.hours 
order by h.sequence;	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_ilamountsalestqty` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_ilamountsalestqty`(sdate varchar(20),edate varchar(20))
BEGIN
select VGAMENAME
    ,VGAMECODE    
    ,ITOTALTICKETSOLD
    ,NTOTALAMOUNT,sdate as sodate ,edate as eodate from(
select b.vgamename,a.vgamecode,sum(a.itotalticketsold) as ITOTALTICKETSOLD,sum(a.ntotalamount) as NTOTALAMOUNT from
                trn_instantclosedaydetail a,mst_instantgame b,trn_instantcloseday c 
                where a.vgamecode= b.vgamecode and a.ibatchid =c.ibatchid 
                and  date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
        group by b.vgamename,a.VGAMECODE ) as a;
  

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_ildetailbatch` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_ildetailbatch`(batchid int(11))
BEGIN

select a.ibatchid as OIBATCHID,b.vgamename,a.vgamecode,a.vbookcode, a.ilastticketnumber as ISTARTNUMBER,a.icurrentticketnumber as IENDNUMBER,a.itotalticketsold as ITOTALTICKETSOLD,a.ntotalamount as NTOTALAMOUNT,a.iTicketAmount as ITICKETAMOUNT	
 from
                trn_instantclosedaydetail a,mst_instantgame b where a.vgamecode= b.vgamecode and ibatchid =batchid
        order by b.vgamename,a.iTicketAmount;
 

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_ilheaderbatch` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_ilheaderbatch`(batchid int(11))
BEGIN
 select ibatchid as OIBATCHID,Concat(dClosedate , ' ' , dclosetime) as DCLOSEDATE,ntotalsales,nclosingamount,nactualamount,NCASHSHORTOVER,NINSTANTCOMMISSION,NINSTANTCASHOUT,NONLINESALES
    ,NONLINECOMMISSION,NONLINECASHOUT,ntotaldue,nbooksold,iactivebook as itotalactivate,isoldbook as itotalsold from    trn_instantcloseday where ibatchid =batchid;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_ilsalesamountqty` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_ilsalesamountqty`(sdate varchar(20),edate varchar(20))
BEGIN
select VGAMENAME
    ,VGAMECODE    
    ,ITOTALTICKETSOLD
    ,NTOTALAMOUNT,sdate as osdate ,edate as oedate from(
select b.vgamename,a.vgamecode,sum(a.itotalticketsold) as ITOTALTICKETSOLD,sum(a.ntotalamount) as NTOTALAMOUNT from
                trn_instantclosedaydetail a,mst_instantgame b,trn_instantcloseday c 
                where a.vgamecode= b.vgamecode and a.ibatchid =c.ibatchid 
                and  date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
        group by b.vgamename,a.VGAMECODE ) as a;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_instantdailysales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_instantdailysales`(sdate varchar(20),edate varchar(20))
BEGIN
select vGameName,vbookcode,ticketsold,ticketsoldprice,sdate as sodate,edate as eodate from (
select c.vGameName,b.vbookcode,SUM(b.itotalticketsold) as ticketsold ,SUM(b.ntotalamount) as ticketsoldprice from trn_instantcloseday  a,trn_instantclosedaydetail b,MST_InstantGame c
 where a.ibatchid = b.ibatchid and b.vGameCode = c.vGameCode  and date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
 group by c.vGameName,b.vbookcode
ORDER BY c.vGameName,b.vbookcode ) as a;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_itemhistory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_itemhistory`(vitemcode varchar(50),sdate varchar(20),edate varchar(20))
BEGIN
select itemname,qtysold,amount,curdate,curtime,QOH,sdate as SODATE,edate as EODATE from (
	select c.vitemname as itemname,case WHEN sum(iunitqty) is null then 0 else sum(iunitqty) END as qtysold,
	case when sum(nextunitprice) is null then 0 else sum(nextunitprice) end as amount,
	date_format(b.dtrandate,'%m-%d-%Y') as  curdate,date_format(b.dtrandate,'%H:%i') as curtime,
	case when a.iqtyonhand is null then 0 else a.iqtyonhand end as QOH
	from mst_item a,trn_sales b, trn_salesdetail c
	where a.vitemcode = c.vitemcode and b.isalesid = c.isalesid and a.vitemcode = vitemcode and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')    and b.vtrntype='Transaction'
	group by  date_format(b.dtrandate,'%m-%d-%Y'),c.vitemname,date_format(b.dtrandate,'%H:%i'),a.iqtyonhand ) as a;
    
   

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_itemlist` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_itemlist`(depcode  varchar(500))
BEGIN
 if(depcode <> 'ALL') then
 
	  select b.vdepartmentname as departmantname,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null)   then a.IQTYONHAND else (Concat(cast((a.IQTYONHAND div a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )     end   as qtyonhand,a.dcostprice as costprice,a.dunitprice as unitprice,case when (a.iqtyonhand * a.nunitcost) > 0 then  (a.iqtyonhand * a.nunitcost) else 0 end as ExtCost,case when (a.iqtyonhand * (a.dunitprice/npack)) > 0 then (a.iqtyonhand * (a.dunitprice/npack)) else 0 end  as ExtPrice,a.vsize
        from mst_item a
        LEFT OUTER Join mst_department b  on  a.vdepcode = b.vdepcode
        where find_in_set(b.vdepcode,depcode)
        order by b.vdepartmentname,a.vitemname;        
 else
	select b.vdepartmentname as departmantname,a.vitemname as itemname,CASE WHEN  NPACK = 1 or (npack is null)   then a.IQTYONHAND else (Concat(cast((a.IQTYONHAND div a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )     end   as qtyonhand,a.dcostprice as costprice,a.dunitprice as unitprice,case when (a.iqtyonhand * a.nunitcost) > 0 then (a.iqtyonhand * a.nunitcost) else 0 end as ExtCost,case when (a.iqtyonhand * (a.dunitprice/npack)) > 0 then (a.iqtyonhand * (a.dunitprice/npack)) else 0 end  as ExtPrice,a.vsize
        from mst_item a
        LEFT OUTER Join mst_department b  on  a.vdepcode = b.vdepcode
        order by b.vdepartmentname,a.vitemname;
        
 end if;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_itemmovemement` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_itemmovemement`(sdate  varchar(20),edate  varchar(20),vitemid  varchar(50))
BEGIN

 SELECT   a.isalesid as vsalesid, a.vaction,a.nqty as vqty,date_format(a.DDATETIME,'%m-%d-%Y %H:%i') as vdate ,a.NUNITPRICE as vprice,a.NPACKQTY as vpackqty, a.vSize,b.vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else Concat(cast((IQTYONHAND/NPACK ) as signed ), '  (' , Mod(IQTYONHAND,NPACK) , ')' )  end  as vqoh FROM (
		
        select  b.isalesid ,case when sum(iunitqty) > 0 then 'Sales' else 'Return' end  as vaction,case when sum(iunitqty) > 0 then concat(' - ' ,  Cast(sum(iunitqty) as char(10))) else    concat(' + ' , Cast(sum(iunitqty) as char(10))) end as NQTY ,(a.DTRANDATE) as DDATETIME ,b.NUNITPRICE,b.NPACK as NPACKQTY,b.VSIZE
        from trn_sales a,trn_salesdetail b,mst_item c 
        where vtrntype='Transaction' and a.isalesid = b.isalesid  and b.vitemcode = c.vitemcode 
        and c.iitemid = vitemid and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') group by b.isalesid,b.NUNITPRICE,b.NPACK ,b.VSIZE,DDATETIME
        union 
        select '0' as  isalesid ,'Purchase' as vaction,concat(' + ' , CAST(sum(ITOTALUNIT) as char(10))) as NQTY,DRECEIVEDDATE AS DDATETIME,NRECEUNITPRICE AS NUNITPRICE,b.NPACKQTY,''  as vSize from trn_purchaseorder a,trn_purchaseorderdetail b
        where a.ipoid = b.ipoid and a.estatus='Close' 
        and b.vitemid = vitemid and date_format(a.dreceveddate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') group by b.ipoid,DDATETIME,NUNITPRICE,b.NPACKQTY, vSize,isalesid,vaction

        union 
        SELECT '0' as  isalesid,'Physical' as vaction, concat(' + ' , CAST(sum(ITOTALUNIT) as char(10))) as nqty ,a.dclosedate as ddatetime,b.ndebitunitprice as nunitprice,b.NPACKQTY,'' as vSize
        from trn_physicalinventory a,trn_physicalinventorydetail b
        where a.ipiid = b.ipiid and a.estatus = 'Close'  and a.vtype='Physical'
        and b.vitemid = vitemid and date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') group by b.ipiid,DDATETIME,NUNITPRICE,b.NPACKQTY, vSize,isalesid,vaction
        union 
        SELECT '0' as  isalesid,'Adjustment' as vaction,  CASE WHEN SUM(ITOTALUNIT) < 0 then concat(' - ',cast(sum(ITOTALUNIT) as char(10)))ELSE  concat('+',CAST(sum(ITOTALUNIT) as char(10)))  end  as nqty ,a.dclosedate as ddatetime,b.ndebitunitprice as nunitprice,b.NPACKQTY,'' as vSize
        from trn_physicalinventory a,trn_physicalinventorydetail b
        where a.ipiid = b.ipiid and a.estatus = 'Close' and a.vtype='Adjustment'
        and b.vitemid = vitemid and date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') group by b.ipiid,DDATETIME,NUNITPRICE,b.NPACKQTY, vSize,isalesid,vaction
        union 
        SELECT '0' as  isalesid,'Waste' as vaction, concat(' - ' , CAST(SUM(ITOTALUNIT) as char(10))) as nqty ,a.dclosedate as ddatetime,b.ndebitunitprice as nunitprice,b.NPACKQTY,'' as vSize
        from trn_physicalinventory a,trn_physicalinventorydetail b
        where a.ipiid = b.ipiid and a.estatus = 'Close'  and a.vtype='Waste'
        and b.vitemid = vitemid and date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') group by b.ipiid,DDATETIME,NUNITPRICE,b.NPACKQTY, vSize,isalesid,vaction ) a ,mst_item b
        where b.iitemid = vitemid
        order by vaction asc,ddatetime desc;      
       

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_itemmovement` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_itemmovement`(sdate  varchar(20),edate  varchar(20),vitemid  varchar(50))
BEGIN

 SELECT   a.isalesid as vsalesid, a.vaction,a.nqty as vqty,date_format(a.DDATETIME,'%m-%d-%Y %H:%i') as vdate ,a.NUNITPRICE as vprice,a.NPACKQTY as vpackqty, a.vSize,b.vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else Concat(cast((IQTYONHAND/NPACK ) as signed ), '  (' , Mod(IQTYONHAND,NPACK) , ')' )  end  as vqoh,sdate as OSDATE,edate as OEDATE FROM (
		
        select  b.isalesid ,case when sum(iunitqty) > 0 then 'Sales' else 'Return' end  as vaction,case when sum(iunitqty) > 0 then concat(' - ' ,  Cast(sum(iunitqty) as char(10))) else    concat(' + ' , Cast(sum(iunitqty) as char(10))) end as NQTY ,(a.DTRANDATE) as DDATETIME ,b.NUNITPRICE,b.NPACK as NPACKQTY,b.VSIZE
        from trn_sales a,trn_salesdetail b,mst_item c 
        where vtrntype='Transaction' and a.isalesid = b.isalesid  and b.vitemcode = c.vitemcode 
        and c.iitemid = vitemid and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') group by b.isalesid,b.NUNITPRICE,b.NPACK ,b.VSIZE,DDATETIME
        union 
        select '0' as  isalesid ,'Purchase' as vaction,concat(' + ' , CAST(sum(ITOTALUNIT) as char(10))) as NQTY,DRECEIVEDDATE AS DDATETIME,NRECEUNITPRICE AS NUNITPRICE,b.NPACKQTY,''  as vSize from trn_purchaseorder a,trn_purchaseorderdetail b
        where a.ipoid = b.ipoid and a.estatus='Close' 
        and b.vitemid = vitemid and date_format(DRECEIVEDDATE,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') group by b.ipoid,DDATETIME,NUNITPRICE,b.NPACKQTY, vSize,isalesid,vaction
		
        union 
        SELECT '0' as  isalesid,'Physical' as vaction, concat(' + ' , CAST(sum(ITOTALUNIT) as char(10))) as nqty ,a.dclosedate as ddatetime,b.ndebitunitprice as nunitprice,b.NPACKQTY,'' as vSize
        from trn_physicalinventory a,trn_physicalinventorydetail b
        where a.ipiid = b.ipiid and a.estatus = 'Close'  and a.vtype='Physical'
        and b.vitemid = vitemid and date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') group by b.ipiid,DDATETIME,NUNITPRICE,b.NPACKQTY, vSize,isalesid,vaction
        union 
        SELECT '0' as  isalesid,'Adjustment' as vaction,  CASE WHEN SUM(ITOTALUNIT) < 0 then concat(' - ',cast(sum(ITOTALUNIT) as char(10)))ELSE  concat('+',CAST(sum(ITOTALUNIT) as char(10)))  end  as nqty ,a.dclosedate as ddatetime,b.ndebitunitprice as nunitprice,b.NPACKQTY,'' as vSize
        from trn_physicalinventory a,trn_physicalinventorydetail b
        where a.ipiid = b.ipiid and a.estatus = 'Close' and a.vtype='Adjustment'
        and b.vitemid = vitemid and date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
        group by b.ipiid,DDATETIME,NUNITPRICE,b.NPACKQTY, vSize,isalesid,vaction
        union
        SELECT '0' as  isalesid,'Waste' as vaction, concat(' - ' , CAST(SUM(ITOTALUNIT) as char(10))) as nqty ,a.dclosedate as ddatetime,b.ndebitunitprice as nunitprice,b.NPACKQTY,'' as vSize
        from trn_physicalinventory a,trn_physicalinventorydetail b
        where a.ipiid = b.ipiid and a.estatus = 'Close'  and a.vtype='Waste'        
        and b.vitemid = vitemid and date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') 
        group by b.ipiid,DDATETIME,NUNITPRICE,b.NPACKQTY, vSize,isalesid,vaction ) a ,mst_item b
        where b.iitemid = vitemid
        order by vaction asc,ddatetime desc;         
       

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_itemsummary` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_itemsummary`(sdate varchar(20),edate varchar(20))
BEGIN
select catagoryname,sku,itemname,qtysold,amount,avgprice,sdate as sodate,edate as eodate from (select b.vcatname as catagoryname,b.vitemcode as sku,b.vitemname as itemname,CASE WHEN sum(b.ndebitqty) is null then 0 Else  sum(b.ndebitqty)  END as qtysold,CASE when Sum(b.nextunitprice) is null then 0 else sum(b.nextunitprice) end as amount ,((CASE when Sum(b.nextunitprice) is null then 0 else sum(b.nextunitprice) end)/(CASE WHEN (sum(b.ndebitqty) is null or sum(b.ndebitqty)=0)  then 1 Else  sum(b.ndebitqty) end)) as avgprice
  from trn_salesdetail b,trn_sales d
  WHERE  b.isalesid = d.isalesid
  and date_format(d.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
  and d.vtrntype='Transaction'  and (b.vcatname <> '' or b.vcatname is not null)
  group by b.vcatname,b.vitemcode,b.vitemname ,b.nunitprice) as a;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_itemvariance` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_itemvariance`(sdate varchar(20),edate varchar(20),vitemid varchar(50))
BEGIN

		declare  nvbegqty numeric(15,2) default '0';
        declare  nvsaleqty numeric(15,2) default '0';
        declare  nvreturnqty numeric(15,2) default '0';
        declare  nvpoqty	numeric(15,2) default '0';
        declare  nvadjqty numeric(15,2) default '0';
        declare  nvendqty numeric(15,2) default '0';
         declare  nvvarqty numeric(15,2) default '0';
        declare  nvairance numeric(15,2) default '0';
         declare  nvvairance numeric(15,2) default '0';
        declare  nvwasteqty numeric(15,2) default '0';
         declare  nendqty numeric(15,2) default '0';
         declare  nvarqty numeric(15,2) default '0';
		 		
        SELECT  case when SUM(itotalunit) is null then 0 else   SUM(itotalunit) end
        from trn_physicalinventory a,trn_physicalinventorydetail b
        where a.ipiid = b.ipiid and a.estatus = 'Close'  and a.vtype='Physical'
        and b.vitemid = vitemid and date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
        into nvbegqty;
        
    
        select case when SUM(iunitqty) is null then 0 else sum(iunitqty) end
        from trn_sales a,trn_salesdetail b,mst_item c 
        where vtrntype='Transaction' and a.isalesid = b.isalesid  and b.vitemcode = c.vitemcode 
        and c.iitemid = vitemid and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and iunitqty > 0
        into nvsaleqty;
        
      
        select case when SUM(iunitqty) is null then 0 else sum(iunitqty) end
        from trn_sales a,trn_salesdetail b,mst_item c 
        where vtrntype='Transaction' and a.isalesid = b.isalesid  and b.vitemcode = c.vitemcode 
        and c.iitemid = vitemid and date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and iunitqty < 0
        into nvreturnqty ;
    
        SELECT  case when SUM(itotalunit) is null then 0 else   SUM(itotalunit) end
        from trn_physicalinventory a,trn_physicalinventorydetail b
        where a.ipiid = b.ipiid and a.estatus = 'Close'  and a.vtype='Adjustment'
        and b.vitemid = vitemid and date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
        into nvadjqty;
    
        SELECT  case when SUM(itotalunit) is null then 0 else   SUM(itotalunit) end
        from trn_physicalinventory a,trn_physicalinventorydetail b
        where a.ipiid = b.ipiid and a.estatus = 'Close'  and a.vtype='Waste'
        and b.vitemid = vitemid and date_format(a.dclosedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
        into nvwasteqty;
        
        
        SELECT case when SUM(itotalunit) is null then 0 else   SUM(itotalunit) end
        from trn_purchaseorder a,trn_purchaseorderdetail b
        where a.ipoid = b.ipoid and a.estatus='Close' 
        and b.vitemid = vitemid and date_format(a.drecevedate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
        into  nvpoqty;
      
       
		 set nendqty = (nvbegqty+nvadjqty+nvpoqty) - (nvsaleqty + nvreturnqty+nvwasteqty);

        set nvarqty = (nendqty - nvbegqty);
       
		 if(nvbegqty <> 0 ) then
          set  nvairance = (nvarqty/nvbegqty)*100;        
         else         
           set nvairance=nendqty;
         end if;
       select nvbegqty as nbegqty,nvsaleqty as nsaleqty,nvreturnqty as nreturnqty,nvpoqty as npoqty,nvadjqty as nadjqty,nendqty as nendqty,nvvarqty,nvairance as nvvariance,nvwasteqty  from dual;
	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_kioskitem` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_kioskitem`(sdate varchar(15),edate varchar(15))
BEGIN
declare  totalqty int default 0;
declare  totalamount NUMERIC(15, 2) default 0.00;
declare  totalupsaleamount NUMERIC(15, 2) default 0.00;
declare  totalupsaleqty int default 0;
		
		select case when  sum(b.qty)=0 || sum(b.qty) is null then 0 else  sum(b.qty) END,        
        case when sum(c.Price)=0 || sum(c.Price) is null then 0 else sum(c.Price) END 
		from trn_hold_order a,trn_hold_order_items b,trn_hold_order_details c
		where  a.OrderId =b.OrderId and b.TransId = c.TransId  and c.SubItemId !=0 	 and a.isPaid=1	
		and date_format(a.LastUpdate,'%m-%d-%Y')  between   sdate and edate
		into totalupsaleqty,totalupsaleamount;
        
        select case when sum(b.qty)=0 || sum(b.qty) is null then 0 else  sum(b.qty) END,
        case when sum(c.Price)=0 || sum(c.Price) is null then 0 else sum(c.Price) END 
		from trn_hold_order a,trn_hold_order_items b,trn_hold_order_details c
		where  a.OrderId =b.OrderId and b.TransId = c.TransId	 and a.isPaid=1		
		and date_format(a.LastUpdate,'%m-%d-%Y') between   sdate and edate
		into totalqty,totalamount;
        
        select totalqty,totalamount,totalupsaleqty,totalupsaleamount from dual;
        
         
		select sum(b.qty) as qty,sum(c.Price) as price,d.vitemname, date_format(a.LastUpdate,'%h') as hours,
        format(sum(b.qty)/(totalqty)*100,0) as qtyper,format(sum(c.Price)/(totalamount)*100,0) as amountper
		from trn_hold_order a,trn_hold_order_items b,trn_hold_order_details c,mst_item d
		where  a.OrderId =b.OrderId and b.TransId = c.TransId  and a.isPaid=1	
		and  d.iitemid= c.ItemId
		and date_format(a.LastUpdate,'%m-%d-%Y') between sdate and edate
		group by date_format(a.LastUpdate,'%h'), d.vitemname;
    
		select sum(b.qty) as qty,sum(c.Price) as price,d.vitemname, date_format(a.LastUpdate,'%h') as hours,
        format(sum(b.qty)/(totalupsaleqty)*100,0) as qtyper,format(sum(c.Price)/(totalupsaleamount)*100,0) as amountper
        from trn_hold_order a,trn_hold_order_items b,trn_hold_order_details c,mst_item d
        where  a.OrderId =b.OrderId and b.TransId = c.TransId  and a.isPaid=1	
        and  d.iitemid= c.SubItemId and c.SubItemId !=0 
        and date_format(a.LastUpdate,'%m-%d-%Y') between sdate and edate
        group by date_format(a.LastUpdate,'%h'), d.vitemname; 

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_nosale` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_nosale`(sdate varchar(20),edate varchar(20))
BEGIN
select  vregistername,dtrandate,vreason,sdate as SODATE,edate as EODATE from (
 select b.vRegisterName as vregistername,date_format(a.dtrandate,'%m-%d-%Y %r') as  dtrandate ,a.vRemark as vReason 
 from trn_sales a,mst_register b
  where vtrntype='No Sale' and
  date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and a.vTerminalID = b.iregisterid
 ) as a;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_paidout` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_paidout`(sdate varchar(20),iterminalid int)
BEGIN
if(iterminalid = 0) then
      
		select b.vpaidoutname as vname, sum(b.namount) as namount from  trn_paidout a,trn_paidoutdetail b WHERE
        a.ipaidouttrnid = b.ipaidouttrnid  AND  a.VUNIQUETRANID = b.VUNIQUETRANID and date_format(ddate,'%m-%d-%Y')=sdate
        group by  b.vpaidoutname;
        
    end if;
    if(iterminalid != 0) then
      
		select b.vpaidoutname as vname, sum(b.namount) as namount from  trn_paidout a,trn_paidoutdetail b WHERE
        a.ipaidouttrnid = b.ipaidouttrnid and a.vterminalid = iterminalid  AND  a.VUNIQUETRANID = b.VUNIQUETRANID and date_format(ddate,'%m-%d-%Y')=sdate
        group by  b.vpaidoutname;

    end if;
  end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_productpricelist` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_productpricelist`(categorycode varchar(500))
BEGIN

if(categorycode <> 'ALL') then
	select b.vCategoryName,VITEMCODE,vitemName,DUNITPRICE,DCOSTPRICE,NLEVEL2,NLEVEL3,NLEVEL4 from mst_item a,mst_category b
        where a.vCATEGORYCODE = b.vCategoryCode
        and   find_in_set(a.vCATEGORYCODE,categorycode);
        
else
	select b.vCategoryName,VITEMCODE,vitemName,DUNITPRICE,DCOSTPRICE,NLEVEL2,NLEVEL3,NLEVEL4 from mst_item a,mst_category b
        where a.vCATEGORYCODE = b.vCategoryCode;
end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_profitloss` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_profitloss`(sdate varchar(20),edate varchar(20),vtype varchar(20),vlist varchar(500))
BEGIN

if(vtype='Department') then 

 if(vlist<>'ALL') then 
    
   Select c.vDEPNAME as vname ,d.vITemName,case when (d.nunitcost * d.nsellunit) is null then 0 else (d.nunitcost * d.nsellunit) end as DCOSTPRICE,d.dUnitPrice,c.TOTUNITPRICE, c.TotCostPrice,(c.TOTUNITPRICE-c.TotCostPrice) as Amount,
          CASE WHEN ((c.TotCostPrice)) <> 0 THEN ((c.TOTUNITPRICE-(c.TotCostPrice))/(c.TotCostPrice)) * 100 ELSE ((c.TOTUNITPRICE-(c.TotCostPrice))/c.TOTUNITPRICE-(c.TotCostPrice)) *100 END as AmountPer,c.TotalQty 
          FROM (select a.VITEMCODE,a.VDEPNAME, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty 
          from trn_salesdetail a,trn_sales b
          where a.ISALESID = b.ISALESID AND  b.vtrntype='Transaction' 
          and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
          AND FIND_IN_SET(a.vDEPCODE,vlist)
          group by a.VITEMCODE,a.VDEPNAME) c,mst_item d
          WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0
          order by c.vdepname,d.vITemName;
    else
    Select c.vDEPNAME as vname,d.vITemName,case when (d.nunitcost * d.nsellunit) is null then 0 else (d.nunitcost * d.nsellunit) end as DCOSTPRICE,d.dUnitPrice,c.TOTUNITPRICE ,c.TotCostPrice,(c.TOTUNITPRICE-c.TotCostPrice) as Amount,
          CASE WHEN ((c.TotCostPrice)) <> 0 THEN ((c.TOTUNITPRICE-(c.TotCostPrice))/(c.TotCostPrice)) * 100 ELSE ((c.TOTUNITPRICE-(c.TotCostPrice))/c.TOTUNITPRICE-(c.TotCostPrice)) * 100 END as AmountPer,c.TotalQty 
           FROM (select a.VITEMCODE,a.VDEPNAME, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b
          where a.ISALESID = b.ISALESID AND  b.vtrntype='Transaction' 
          and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')  
          group by a.VITEMCODE,a.VDEPNAME) c,mst_item d
          WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0
          order by c.vdepname,d.vITemName;
    end if;

end if;

if(vtype='Category') then 

 if(vlist<>'ALL') then
  Select c.vCATNAME as vname,d.vITemName,case when (d.nunitcost * d.nsellunit) is null then 0 else (d.nunitcost * d.nsellunit) end as DCOSTPRICE,d.dUnitPrice,c.TOTUNITPRICE,c.TotCostPrice,(c.TOTUNITPRICE-c.TotCostPrice) as Amount,
          CASE WHEN ((c.TotCostPrice)) <> 0 THEN ((c.TOTUNITPRICE-(c.TotCostPrice))/(c.TotCostPrice)) * 100 ELSE ((c.TOTUNITPRICE-(c.TotCostPrice))/c.TOTUNITPRICE-(c.TotCostPrice)) * 100 END as AmountPer,c.TotalQty 
           FROM (select a.VITEMCODE,a.vCATNAME, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b
          where a.ISALESID = b.ISALESID AND  b.vtrntype='Transaction' and 
          date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')  
          AND find_in_set(a.VCATCODE,vlist)
          group by a.VITEMCODE,a.VCATNAME) c,mst_item d
          WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0
          order by c.vcatname,d.vITemName;
          
    else
  Select c.vCATNAME as vname,d.vITemName,case when (d.nunitcost * d.nsellunit) is null then 0 else (d.nunitcost * d.nsellunit) end as DCOSTPRICE,d.dUnitPrice,c.TOTUNITPRICE,c.TotCostPrice,(c.TOTUNITPRICE-c.TotCostPrice) as Amount,
          CASE WHEN ((c.TotCostPrice)) <> 0 THEN ((c.TOTUNITPRICE-(c.TotCostPrice))/(c.TotCostPrice)) * 100 ELSE ((c.TOTUNITPRICE-(c.TotCostPrice))/c.TOTUNITPRICE-(c.TotCostPrice)) * 100 END as AmountPer,c.TotalQty 
          FROM (select a.VITEMCODE,a.vcatname, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b
          where a.ISALESID = b.ISALESID AND  b.vtrntype='Transaction' 
          and date_format(b.dtrandate,'%Y-%m-%d')  
			between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')  
          group by a.VITEMCODE,a.vCATNAME) c,mst_item d
          WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0
          order by c.vcatname,d.vITemName;
    end if;

end if;

if(vtype='Item Group') then 

 if(vlist<>'ALL') then
  Select c.vitemgroupname as vname,d.vITemName,case when (d.nunitcost * d.nsellunit) is null then 0 else (d.nunitcost * d.nsellunit) end as DCOSTPRICE,d.dUnitPrice,c.TOTUNITPRICE,c.TotCostPrice,(c.TOTUNITPRICE-c.TotCostPrice) as Amount,
          CASE WHEN ((c.TotCostPrice)) <> 0 THEN ((c.TOTUNITPRICE-(c.TotCostPrice))/(c.TotCostPrice)) * 100 ELSE ((c.TOTUNITPRICE-(c.TotCostPrice))/c.TOTUNITPRICE-(c.TotCostPrice)) * 100 END as AmountPer,c.TotalQty 
           FROM (select a.VITEMCODE,a.vcatname,m.iitemgroupid,n.vitemgroupname, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b, itemgroupdetail m, itemgroup n
          where a.ISALESID = b.ISALESID AND a.VITEMCODE=m.vsku AND m.iitemgroupid=n.iitemgroupid AND  b.vtrntype='Transaction' 
          and date_format(b.dtrandate,'%Y-%m-%d')  
      between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') AND find_in_set(m.iitemgroupid,vlist)  
          group by a.VITEMCODE,m.iitemgroupid) c,mst_item d
          WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0
          order by c.vitemgroupname,d.vITemName;
          
    else
  Select c.vitemgroupname as vname,d.vITemName,case when (d.nunitcost * d.nsellunit) is null then 0 else (d.nunitcost * d.nsellunit) end as DCOSTPRICE,d.dUnitPrice,c.TOTUNITPRICE,c.TotCostPrice,(c.TOTUNITPRICE-c.TotCostPrice) as Amount,
          CASE WHEN ((c.TotCostPrice)) <> 0 THEN ((c.TOTUNITPRICE-(c.TotCostPrice))/(c.TotCostPrice)) * 100 ELSE ((c.TOTUNITPRICE-(c.TotCostPrice))/c.TOTUNITPRICE-(c.TotCostPrice))  *100 END as AmountPer,c.TotalQty 
          FROM (select a.VITEMCODE,a.vcatname,m.iitemgroupid,n.vitemgroupname, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b, itemgroupdetail m, itemgroup n
          where a.ISALESID = b.ISALESID AND a.VITEMCODE=m.vsku AND m.iitemgroupid=n.iitemgroupid AND  b.vtrntype='Transaction' 
          and date_format(b.dtrandate,'%Y-%m-%d')  
      between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')  
          group by a.VITEMCODE,m.iitemgroupid) c,mst_item d
          WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0
          order by c.vitemgroupname,d.vITemName;
    end if;

end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_purchaseorder` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `rp_purchaseorder`(poid integer)
BEGIN

 SELECT vponumber,vrefnumber,nnettotal,ntaxtotal,date_format(dcreatedate,'%m-%d-%Y') as dcreatedate,date_format(dreceiveddate,'%m-%d-%Y') as dreceiveddate,estatus,nfreightcharge,    
    vvendorname,
    vvendoraddress1,   
    nrectotal,
    nsubtotal,
    ndeposittotal,
    nreturntotal,
    vinvoiceno,
    ndiscountamt,
    nripsamt 
FROM trn_purchaseorder where  ipoid=poid;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_purchaseorderdetail` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `rp_purchaseorderdetail`(poid integer)
BEGIN
 SELECT VVENDORITEMCODE,vbarcode as SKU,VITEMNAME,NORDUNITPRICE AS DCOSTPRICE2,NORDEXTPRICE AS DCOSTPRICE1,NORDQTY AS ORDERQTY,VITEMID AS PITEMCODE1,
VUNITNAME AS PUNITNAME1,NORDTEXTPRICE AS DTAXAMOUNT1,NORDTAX AS DTAX1,NPACKQTY,NUNITCOST,ITOTALUNIT,VSIZE  FROM trn_purchaseorderdetail where IPOID = poid order by IPODETID;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_purchasesales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_purchasesales`(sdate varchar(20),edate varchar(20),vtype varchar(20),vlist varchar(500))
BEGIN

if(vtype="Department") then
	
    if(vlist<>'ALL') then 
    
		select d.vDepartmentName as vname ,o.vitemname as vitemname ,e.vUnitName ,m.NSALES,m.NPURCHASE,o.iqtyonhand as qoh
          from (select i.cname ,i.VCODE,CASE WHEN SUM(i.iUnitQty) is null then 0 else SUM(i.iUnitQty) end as NSALES,CASE WHEN SUM(i.ITOTALUNIT) is null then 0 else SUM(i.ITOTALUNIT) end as NPURCHASE  
          from (select a.vdepcode as CNAME,vitemcode as VCODE, iUnitQty,0 as itotalunit 
          from trn_salesdetail a,trn_sales b
          where a.isalesid = b.isalesid 
          and  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') AND FIND_IN_SET((a.vDEPCODE), vlist) 
          union ALL
          select c.vdepcode as CNAME,A.vbarcode as VCODE,0 as iunitQty,a.ITOTALUNIT from trn_purchaseorderdetail a,trn_purchaseorder b,mst_item c 
          where a.IPOID = b.ipoid and date_format(b.DRECEIVEDDATE,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') AND FIND_IN_SET((c.vDEPCODE), vlist) 
          and c.VBARCODE = a.vbarcode) i
          group by i.cname,i.VCODE) m,mst_item o,mst_department d,mst_unit e
          where o.vbarcode = m.vcode and m.CNAME = o.VDEPCODE and o.VDEPCODE = d.VDEPCODE
          and e.vunitcode = o.vunitcode;
		
    else
		  select VNAME,VITEMNAME,vunitname,NSALES,NPurchase,nQOH   from (
		  select d.vDepartmentName as vname,o.vitemname as vitemname ,e.vUnitName as vunitname ,m.NSALES,m.NPURCHASE,o.iqtyonhand as nqoh   
          from (select i.cname,i.VCODE,CASE WHEN SUM(i.iUnitQty) is null then 0 else SUM(i.iUnitQty) end as NSALES,CASE WHEN SUM(i.ITOTALUNIT) is null then 0 else SUM(i.ITOTALUNIT) end as NPURCHASE  
          from (select a.vdepcode as CNAME,vitemcode as VCODE, iUnitQty,0 as itotalunit 
          from trn_salesdetail a,trn_sales b
          where a.isalesid = b.isalesid and vcatname is not null
          and  b.vtrntype='Transaction' and  date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
          union ALL
          select c.vdepcode as CNAME,A.vbarcode as VCODe,0 as iunitQty,a.ITOTALUNIT from trn_purchaseorderdetail a,trn_purchaseorder b,mst_item c 
          where a.IPOID = b.ipoid and date_format(b.DRECEIVEDDATE,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
          and c.VBARCODE = a.vbarcode) i
          group by i.cname,i.VCODE) m,mst_item o,mst_department d,mst_unit e
          where o.vbarcode = m.vcode and m.CNAME = o.VDEPCODE and o.vdepcode = d.vdepcode
          and e.vunitcode = o.vunitcode ) as a;
    end if;

end if;

if(vtype="Category") then
	
    if(vlist<>'ALL') then 
    select d.VCATEGORYNAME as vname,o.vitemname,e.vUnitName,m.NSALES,m.NPURCHASE,o.iqtyonhand  as nqoh  
          from (select i.cname,i.VCODE,CASE WHEN SUM(i.iUnitQty) is null then 0 else SUM(i.iUnitQty) end as NSALES,CASE WHEN SUM(i.ITOTALUNIT) is null then 0 else SUM(i.ITOTALUNIT) end as NPURCHASE  
          from (select a.vcatcode as CNAME,vitemcode as VCODE, iUnitQty,0 as itotalunit 
          from trn_salesdetail a,trn_sales b
          where a.isalesid = b.isalesid and vcatname is not null
          and  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and FIND_IN_SET(a.vCATCODE,vlist)
          union ALL
          select c.VCATEGORYCODE as CNAME,A.vbarcode as VCODe,0 as iunitQty,a.ITOTALUNIT from trn_purchaseorderdetail a,trn_purchaseorder b,mst_item c 
          where a.IPOID = b.ipoid and date_format(b.DRECEIVEDDATE,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') AND FIND_IN_SET(c.VCATEGORYCODE,vlist)
          and c.VBARCODE = a.vbarcode) i
          group by i.cname,i.VCODE) m,mst_item o,mst_category d,mst_unit e
          where o.vbarcode = m.vcode and m.CNAME = o.VCATEGORYCODE and o.VCATEGORYCODE = d.VCATEGORYCODE
          and e.vunitcode = o.vunitcode;
    else
		select d.VCATEGORYNAME as vname,o.vitemname,e.vUnitName,m.NSALES,m.NPURCHASE,o.iqtyonhand  as  nqoh 
          from (select i.cname,i.VCODE,CASE WHEN SUM(i.iUnitQty) is null then 0 else SUM(i.iUnitQty) end as NSALES,CASE WHEN SUM(i.ITOTALUNIT) is null then 0 else SUM(i.ITOTALUNIT) end as NPURCHASE  
          from (select a.vcatcode as CNAME,vitemcode as VCODE, iUnitQty,0 as itotalunit 
          from trn_salesdetail a,trn_sales b
          where a.isalesid = b.isalesid and vcatname is not null
          and  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
          union ALL
          select c.VCATEGORYCODE as CNAME,A.vbarcode as VCODe,0 as iunitQty,a.ITOTALUNIT from trn_purchaseorderdetail a,trn_purchaseorder b,mst_item c 
          where a.IPOID = b.ipoid and date_format(b.DRECEIVEDDATE,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
          and c.VBARCODE = a.vbarcode) i
          group by i.cname,i.VCODE) m,mst_item o,mst_category d,mst_unit e
          where o.vbarcode = m.vcode and m.CNAME = o.VCATEGORYCODE and o.VCATEGORYCODE = d.VCATEGORYCODE
          and e.vunitcode = o.vunitcode;
    end if;
    
end if;

if(vtype="ItemGroup") then
	
    if(vlist<>'ALL') then 
    
		select d.vitemgroupname as vname,o.vitemname,e.vUnitName,m.NSALES,m.NPURCHASE,o.iqtyonhand as nqoh  
          from (select i.cname,i.VCODE,CASE WHEN SUM(i.iUnitQty) is null then 0 else SUM(i.iUnitQty) end as NSALES,CASE WHEN SUM(i.ITOTALUNIT) is null then 0 else SUM(i.ITOTALUNIT) end as NPURCHASE  
          from (select l.IitemgroupID as CNAME,vitemcode as VCODE, iUnitQty,0 as itotalunit 
          from trn_salesdetail a,trn_sales b,itemgroupdetail l
          where a.isalesid = b.isalesid and vcatname is not null
          and  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and l.VSKU = a.vitemcode AND FIND_IN_SET(l.IitemgroupID ,vlist)
          union ALL
          select l.IitemgroupID as CNAME,A.vbarcode as VCODe,0 as iunitQty,a.ITOTALUNIT 
          from trn_purchaseorderdetail a,trn_purchaseorder b,mst_item c,itemgroupdetail l 
          where a.IPOID = b.ipoid and date_format(b.DRECEIVEDDATE,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and l.VSKU = c.vitemcode AND FIND_IN_SET(l.IitemgroupID ,vlist)
          and c.VBARCODE = a.vbarcode) i
          group by i.cname,i.VCODE) m,mst_item o,itemgroup d,mst_unit e  
          where o.vbarcode = m.vcode and d.IitemgroupID = m.cname
          and e.vunitcode = o.vunitcode;
    else
		select d.vitemgroupname as vname,o.vitemname,e.vUnitName,m.NSALES,m.NPURCHASE,o.iqtyonhand  as nqoh  
          from (select i.cname,i.VCODE,CASE WHEN SUM(i.iUnitQty) is null then 0 else SUM(i.iUnitQty) end as NSALES,CASE WHEN SUM(i.ITOTALUNIT) is null then 0 else SUM(i.ITOTALUNIT) end as NPURCHASE  
          from (select l.IitemgroupID as CNAME,vitemcode as VCODE, iUnitQty,0 as itotalunit 
          from trn_salesdetail a,trn_sales b,itemgroupdetail l
          where a.isalesid = b.isalesid and vcatname is not null
          and  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and l.VSKU = a.vitemcode
          union ALL
          select l.IitemgroupID as CNAME,A.vbarcode as VCODe,0 as iunitQty,a.ITOTALUNIT 
          from trn_purchaseorderdetail a,trn_purchaseorder b,mst_item c,itemgroupdetail l 
          where a.IPOID = b.ipoid and date_format(b.DRECEIVEDDATE,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and l.VSKU = c.vitemcode
          and c.VBARCODE = a.vbarcode) i
          group by i.cname,i.VCODE) m,mst_item o,itemgroup d,mst_unit e  
          where o.vbarcode = m.vcode and d.IitemgroupID = m.cname
          and e.vunitcode = o.vunitcode;
    end if;
end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_qoh` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_qoh`(vtype varchar(20),vcode varchar(500),ihidezeroqty int,ishownegative int)
BEGIN
if (vcode <> 'All' ) then

		if(vtype='Category') then
        
			 if(ihidezeroqty = 1 AND ishownegative = 1) then
             
				SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                        (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcategoryname as vname,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_category b  where a.vcategorycode=b.vcategorycode and visinventory='Yes' and IQTYONHAND !=0  and find_in_set(a.vcategorycode,vcode) and vitemname is not null  ;
			  elseif(ihidezeroqty=0 and ishownegative = 0) then
              
				SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                        (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcategoryname as vname,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_category b  where a.vcategorycode=b.vcategorycode and visinventory='Yes' and IQTYONHAND >0  and find_in_set(a.vcategorycode,vcode) and vitemname is not null  ;
              
              elseif(ishownegative = 1) then
              
				SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                        (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcategoryname as vname,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_category b  where a.vcategorycode=b.vcategorycode and visinventory='Yes' and IQTYONHAND !=0  and find_in_set(a.vcategorycode,vcode) and vitemname is not null  ;
             elseif(ihidezeroqty = 1) then
              SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                        (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcategoryname as vname,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_category b  where a.vcategorycode=b.vcategorycode and visinventory='Yes' and IQTYONHAND > 0  and find_in_set(a.vcategorycode,vcode) and vitemname is not null  ;
              end if;
             
        
        else
			
         if(ihidezeroqty = 1 AND ishownegative = 1) then
             
				 SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                        (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcompanyname as vname ,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_supplier b where a.vsuppliercode =b.vsuppliercode and  IQTYONHAND != 0  and  visinventory='Yes' and FIND_IN_SET(a.vsuppliercode ,vcode) ;
             
             
             elseif(ihidezeroqty=0 and ishownegative = 0) then
               SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                       (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcompanyname as vname ,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_supplier b where a.vsuppliercode =b.vsuppliercode and  IQTYONHAND > 0  and  visinventory='Yes' and FIND_IN_SET(a.vsuppliercode ,vcode) ;
              
              
              elseif(ishownegative = 1) then
              
				SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                       (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') ) end as vqty,b.vcompanyname as vname ,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_supplier b where a.vsuppliercode =b.vsuppliercode and  IQTYONHAND != 0  and  visinventory='Yes' and FIND_IN_SET(a.vsuppliercode ,vcode) ;
              
              elseif(ihidezeroqty = 1) then
				 SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
						(Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcompanyname as vname ,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
							FROM mst_item a,mst_supplier b where a.vsuppliercode =b.vsuppliercode and  IQTYONHAND > 0  and  visinventory='Yes' and FIND_IN_SET(a.vsuppliercode ,vcode) ;
              end if;
             
        end if;

else
	if(vtype='Category') then
        
			 if(ihidezeroqty = 1 AND ishownegative = 1) then
             
				SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                        (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') ) end as vqty,b.vcategoryname as vname,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_category b  where a.vcategorycode=b.vcategorycode and visinventory='Yes' and IQTYONHAND !=0  and  vitemname is not null  ;
				
              
               elseif(ihidezeroqty=0 and ishownegative = 0) then
              
				SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                        (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcategoryname as vname,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_category b  where a.vcategorycode=b.vcategorycode and visinventory='Yes' and IQTYONHAND >0   and vitemname is not null  ;
              
             
              elseif(ishownegative = 1) then
              
				SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                        (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcategoryname as vname,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_category b  where a.vcategorycode=b.vcategorycode and visinventory='Yes' and IQTYONHAND !=0   and vitemname is not null  ;
              
              elseif(ihidezeroqty = 1) then
              SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                        (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcategoryname as vname,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_category b  where a.vcategorycode=b.vcategorycode and visinventory='Yes' and IQTYONHAND > 0   and vitemname is not null  ;
              end if;
             
        
        else
			
         if(ihidezeroqty = 1 AND ishownegative = 1) then
             
				 SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                        (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcompanyname as vname ,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_supplier b where a.vsuppliercode =b.vsuppliercode and  IQTYONHAND > 0  and  visinventory='Yes'  ;
             
            
             elseif(ihidezeroqty=0 and ishownegative = 0) then
               SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                       (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcompanyname as vname ,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_supplier b where a.vsuppliercode =b.vsuppliercode and  IQTYONHAND > 0  and  visinventory='Yes'  ;
              
             
              elseif(ishownegative = 1) then
              
				SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
                       (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcompanyname as vname ,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
                        FROM mst_item a,mst_supplier b where a.vsuppliercode =b.vsuppliercode and  IQTYONHAND != 0  and  visinventory='Yes'  ;
              
              elseif(ihidezeroqty = 1) then
				 SELECT vitemname as vitemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
							(Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,b.vcompanyname as vname ,Case When (IQTYONHAND * nUnitCost) is null then 0 else  IQTYONHAND * nUnitCost end as namount
							FROM mst_item a,mst_supplier b where a.vsuppliercode =b.vsuppliercode and  IQTYONHAND > 0  and  visinventory='Yes'  ;
              end if;
        end if;

end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_salessummarychart` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_salessummarychart`(sdate  varchar(20),SID int(11))
BEGIN
declare  NETTOTAL NUMERIC(15, 2);
	declare NTAXABLE NUMERIC(15, 2);
	declare NNONTAXABLETOTAL NUMERIC(15, 2);
	declare NDISCOUNTAMT NUMERIC(15, 2);
	declare  NTAXTOTAL NUMERIC(15, 2);
	declare  NOPENINGBALANCE NUMERIC(15, 2);
	declare  NADDCASH NUMERIC(15, 2);
	declare  NCLOSINGBALANCE NUMERIC(15, 2);
	declare  NONACCOUNT NUMERIC(15, 2);
	declare  NONCREDITTOTAL NUMERIC(15, 2);
	declare  NSUBTOTAL NUMERIC(15, 2);
	declare  NPAIDOUT NUMERIC(15, 2);
	declare  NPICKUP NUMERIC(15, 2);
	declare  NTOTALSALESTAX NUMERIC(15, 2);
	declare  OIBATCHID INTEGER;
	declare  NTOTALSALEDISCOUNT NUMERIC(15, 2);
	DECLARE  Nebtsales NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NRETURNAMOUNT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NCASHAMOUNT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NCHECKAMOUNT NUMERIC(15, 2) DEFAULT '0';
    
    DECLARE  ncreditcardsales NUMERIC(15, 2) DEFAULT '0';
    DECLARE  ngiftsales NUMERIC(15, 2) DEFAULT '0';
    DECLARE  ncreditsales NUMERIC(15, 2) DEFAULT '0';
    DECLARE  ndebitsales NUMERIC(15, 2) DEFAULT '0';
    
		set NCLOSINGBALANCE =0;        
        
        SELECT  case when sum(a.NNETTOTAL) is null then 0 else sum(a.NNETTOTAL) end,
        case when sum(a.NTAXABLETOTAL) is null then 0 else sum(a.NTAXABLETOTAL) end
        ,case when sum(a.NNONTAXABLETOTAL) is null then 0 else  sum(a.NNONTAXABLETOTAL) end,
        case when SUM(a.NDISCOUNTAMT) is null then 0 else SUM(a.NDISCOUNTAMT) end,
        case when SUM(a.NTAXTOTAL) is null then 0 else SUM(a.NTAXTOTAL) end ,
        case when sum(a.NSALETOTALAMT) is null then 0 else SUM(a.NSALETOTALAMT) end 
        FROM trn_sales as a
		WHERE iOnAccount != 1 and vtrntype='Transaction' and date_format(a.dtrandate,'%m-%d-%Y') = sdate AND a.SID=SID
         into nettotal,ntaxable,nnontaxabletotal,ndiscountamt,ntaxtotal,ntotalsalediscount;
        
		SELECT case when sum(nopeningbalance) is null then 0 else  sum(nopeningbalance) end  FROM trn_batch
  WHERE  date_format(dbatchstarttime,'%m-%d-%Y') = sdate
        group by date_format(dbatchstarttime,'%m-%d-%Y')
  into NOPENINGBALANCE;
        
         SELECT case when sum(a.nnettotal) is null then 0 else sum(a.nnettotal) end FROM trn_sales as a
			WHERE vtrntype='Add Cash' and  date_format(a.dtrandate,'%m-%d-%Y') = sdate AND a.SID=SID
			into naddcash;
		
        set NCLOSINGBALANCE = nopeningbalance  + naddcash ;
        
			SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			FROM trn_sales a,trn_salestender b,mst_tentertype c
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
			and b.itenerid = c.itenderid  and date_format(a.dtrandate,'%m-%d-%Y') = sdate
			and c.vtendertag in ('Credit','Debit','Gift') AND a.SID=SID
			into noncredittotal;
            
			set NCLOSINGBALANCE = NCLOSINGBALANCE+noncredittotal;        
			set NSUBTOTAL = noncredittotal;
            
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
				and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%m-%d-%Y') = sdate
				and c.vtendertag in ('OnAcct') AND a.SID=SID
				into nonaccount ;
                set NCLOSINGBALANCE = NCLOSINGBALANCE+nonaccount;
				set NSUBTOTAL = NSUBTOTAL+NONACCOUNT;
                
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
				and b.itenerid = c.itenderid  and date_format(a.dtrandate,'%m-%d-%Y') = sdate
				and c.vtendertag in ('Ebt') AND a.SID=SID
				into Nebtsales;
                 set NCLOSINGBALANCE = NCLOSINGBALANCE+Nebtsales;
				set NSUBTOTAL = NSUBTOTAL+Nebtsales;
                
                
			SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			into NCASHAMOUNT FROM trn_sales a,trn_salestender b,mst_tentertype c 
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 101
			and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%m-%d-%Y') = sdate AND a.SID=SID; 
			
              set NCLOSINGBALANCE = NCLOSINGBALANCE+NCASHAMOUNT;
				set NSUBTOTAL = NSUBTOTAL+NCASHAMOUNT;
                
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 102
				and b.itenerid = c.itenderid   and date_format(a.dtrandate,'%m-%d-%Y') = sdate AND a.SID=SID
				into NCHECKAMOUNT;
				set NCLOSINGBALANCE = NCLOSINGBALANCE+NCHECKAMOUNT;
				set NSUBTOTAL = NSUBTOTAL+NCHECKAMOUNT;
                
					SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
					FROM trn_sales a,trn_salestender b,mst_tentertype c
					WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 120
					and b.itenerid = c.itenderid and date_format(a.dtrandate,'%m-%d-%Y') = sdate AND a.SID=SID
					into NRETURNAMOUNT;
                    
                    set NCLOSINGBALANCE = NCLOSINGBALANCE - NRETURNAMOUNT*-1;
                    
					SELECT case when sum(NNETTOTAL) is null then 0 else sum(NNETTOTAL) end    FROM trn_sales as a
					WHERE vtrntype='Cash pickup' and date_format(a.dtrandate,'%m-%d-%Y') = sdate AND a.SID=SID
					into npickup;
                    
					select  case when sum(b.namount) is null  then  0 else  sum(b.namount) end
					from  trn_paidout a,trn_paidoutdetail b
					where a.ipaidouttrnid = b.ipaidouttrnid and date_format(a.ddate,'%m-%d-%Y') = sdate
					AND  a.VUNIQUETRANID = b.VUNIQUETRANID   and b.vpaidoutname is not null
					into npaidout;
			
					 set NCLOSINGBALANCE = NCLOSINGBALANCE -  (npaidout+npickup);
                     set ntotalsalestax = ntaxable +  nnontaxabletotal -(ndiscountamt);       	
            
                      
            select  CASE WHEN SUM(a.nPurchaseAmount) is null then 0 else SUM(a.nPurchaseAmount) end from trn_mpstender a
            where date_format(a.dtrandate,'%m-%d-%Y') = sdate AND a.vcmdstatus='OK' AND a.SID=SID
            into ncreditcardsales;
            
            SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			FROM trn_sales a,trn_salestender b,mst_tentertype c
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
			and b.itenerid = c.itenderid  and date_format(a.dtrandate,'%m-%d-%Y') = sdate
			and c.vtendertag in ('Credit') AND a.SID=SID
			into ncreditsales;
            
            SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			FROM trn_sales a,trn_salestender b,mst_tentertype c
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
			and b.itenerid = c.itenderid  and date_format(a.dtrandate,'%m-%d-%Y') = sdate
			and c.vtendertag in ('Debit') AND a.SID=SID
			into ndebitsales;
            
            SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			FROM trn_sales a,trn_salestender b,mst_tentertype c
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
			and b.itenerid = c.itenderid  and date_format(a.dtrandate,'%m-%d-%Y') = sdate
			and c.vtendertag in ('Gift') AND a.SID=SID
			into ngiftsales;
            
        select sdate as osdate,ntotalsalestax,npaidout,npickup,npaidout,nreturnamount,ncheckamount,ncashamount,nebtsales,nsubtotal,nonaccount,noncredittotal,naddcash,nettotal,ntaxable,nnontaxabletotal,ndiscountamt,ntaxtotal,ntotalsalediscount,nopeningbalance,nclosingbalance,ngiftsales,ncreditsales,ndebitsales,ncreditcardsales from dual;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_salestax` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_salestax`(sdate varchar(20),edate varchar(20),vtype varchar(20))
BEGIN

	if(vtype='By Month') then    
    SELECT  PDATE,TAX,NONTAX,NNETTOTAL,sdate as odate ,edate as oedate  from (select   date_format(dTranDate,'%M-%Y') as PDATe,
                case when sum(NTAXTOTAL) is null then 0 else sum(NTAXTOTAL) end as TAX,
                case when sum(NNONTAXABLETOTAL) is null then 0 else sum(NNONTAXABLETOTAL) end as NONTAX,
                case when sum(nnettotal) is null then 0 else sum(nnettotal)  end as NNETTOTAL
                from trn_sales where date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and vtrntype='Transaction'
                group by 1
                )  as  a;
                           
    end if;
    if(vtype='By Date') then    
    SELECT  PDATE,TAX,NONTAX,NNETTOTAL,sdate as odate ,edate as oedate  from (select   date_format(dTranDate,'%m-%d-%Y') as PDATe,
                case when sum(NTAXTOTAL) is null then 0 else sum(NTAXTOTAL) end as TAX,
                case when sum(NNONTAXABLETOTAL) is null then 0 else sum(NNONTAXABLETOTAL) end as NONTAX,
                case when sum(nnettotal) is null then 0 else sum(nnettotal)  end as NNETTOTAL
                from trn_sales where date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and vtrntype='Transaction'
                group by 1
                )  as  a;
                           
    end if;
     if(vtype='By Year') then    
    SELECT  PDATE,TAX,NONTAX,NNETTOTAL,sdate as odate ,edate as oedate  from (select   date_format(dTranDate,'%Y') as PDATe,
                case when sum(NTAXTOTAL) is null then 0 else sum(NTAXTOTAL) end as TAX,
                case when sum(NNONTAXABLETOTAL) is null then 0 else sum(NNONTAXABLETOTAL) end as NONTAX,
                case when sum(nnettotal) is null then 0 else sum(nnettotal)  end as NNETTOTAL
                from trn_sales where date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and vtrntype='Transaction'
                group by 1
                )  as  a;
                           
    end if;
    

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_salestender` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_salestender`(sdate varchar(20),iterminalid int)
BEGIN

	if(iterminalid = 0) then
      
			SELECT b.vtendername as vname ,sum(b.namount) as namount ,count(b.itenerid) as ntotcount  FROM
			trn_sales a,trn_salestender b,mst_tentertype c
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121 and b.itenerid = c.itenderid  
			and  date_format(a.DTRANDATE,'%m-%d-%Y') = sdate
			group by   b.vtendername,c.vtendertag;

    end if;
    if(iterminalid != 0) then
      
			SELECT b.vtendername as vname ,sum(b.namount) as namount ,count(b.itenerid) as ntotcount  FROM
			trn_sales a,trn_salestender b,mst_tentertype c
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid
			and  date_format(a.DTRANDATE,'%m-%d-%Y') = sdate and a.vterminalid = iterminalid  and  b.itenerid != 121  and b.itenerid = c.itenderid  
			group by   b.vtendername,c.vtendertag;

    end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_showproductpicture` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_showproductpicture`()
BEGIN
select a.vitemName as itemname,a.VITEMCODE as itemcode,a.ItemIMage as image from mst_item a
where a.itemimage is not null;    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_store` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_store`()
BEGIN
	 select vstorename from mst_store;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_taxcollection` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_taxcollection`(sdate varchar(20),edate varchar(20))
BEGIN
select TAX,NONTAX,TAXAMOUNT,NETTOTAL as NNETTOTAL,sdate as odate,edate as oedate 
from (
select  case when sum(NTAXTOTAL) is null then 0 else sum(NTAXTOTAL) end as TAX,
                case when sum(NNONTAXABLETOTAL) is null then 0 else sum(NNONTAXABLETOTAL) end as NONTAX,
                case when sum(NTAXABLETOTAL) is null then 0 else sum(NTAXABLETOTAL) end as TAXAMOUNT,
                case when sum(nnettotal) is null then 0 else sum(nnettotal)  end as NETTOTAL
                from trn_sales where date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and vtrntype='Transaction' ) as a;
   
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_tendersummary` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_tendersummary`(sdate varchar(20),edate varchar(20))
BEGIN
select Tenertype, Total,sdate as sodate,edate as eodate from(
select c.vtendertype as Tenertype, SUM(a.NAMOUNT) as Total from trn_salestender a,trn_sales b,mst_tentertype  c
where a.isalesid=b.isalesid and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
and c.itenderid = a.itenerid and b.vtrntype='Transaction'   and c.itenderid != 121
group by a.itenerid,c.vtendertype
order by c.vtendertype ) as a;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_top10amount` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_top10amount`()
BEGIN
select  (i.dunitprice) as unitprice ,i.vitemcode  as itemcode ,i.vitemname as itemname
from mst_item i
order by i.dunitprice desc limit 10;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_vendorsummary` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_vendorsummary`(sdate varchar(20),edate varchar(20))
BEGIN
select vsuppliername,qtysold,extunitprice,extcostprice,sdate as sodate,edate as eodate  from (select (c.vcompanyname) as vsuppliername,sum(a.ndebitqty) as qtysold,sum(a.nextunitprice) as extunitprice,sum(a.nextcostprice) as extcostprice
from trn_salesdetail a,trn_sales b,mst_supplier c,mst_item d
where a.isalesid= b.isalesid and d.vitemcode = a.vitemcode and d.vsuppliercode = c.vsuppliercode 
AND 
date_format(dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y') and a.isalesid = b.isalesid
and b.vtrntype='Transaction'
GROUP BY vsuppliername
ORDER BY vsuppliername ) as a;


END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_voidinformation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_voidinformation`(sdate varchar(20),edate varchar(20))
BEGIN
select name,Total,vregister,dtrandate,sdate as SODATE,edate as EODATE from (
select Concat(b.vfname , '  ' , b.vlname) as  name, (a.nnettotal) as Total,date_format(a.dtrandate,'%m-%d-%Y %H:%i%:%s') as dtrandate
,C.VREGISTERNAME as VREGISTER
from trn_sales a,mst_user b,mst_register C where a.vtrntype='Void'
and a.iuserid = b.iuserid AND  A.VTERMINALID=C.IREGISTERID AND date_format(a.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y')
order by dtrandate desc,c.vregistername,Name ) as a;


END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_webbelowcost` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_webbelowcost`(vcode varchar(500))
BEGIN
if (vcode <> 'All' ) then
	   
		SELECT c.vcompanyname as suppliername,a.vitemname as itemname,		
        b.vdepartmentname as vname,Case When (nunitcost) is null then 0 else  (nunitcost) end as cost
		,a.dUnitPrice as price
        FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and
        a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and dunitprice < nunitcost
		and IQTYONHAND !=0  and find_in_set(a.vdepcode,vcode) and vitemname is not null  ;           
	

else
	      
		SELECT c.vcompanyname as suppliername,a.vitemname as itemname,		
        b.vdepartmentname as vname,Case When (nunitcost) is null then 0 else  (nunitcost) end as cost
		,a.dUnitPrice as price
        FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and
        a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and dunitprice < nunitcost
		and IQTYONHAND !=0   and vitemname is not null  ;          
	

end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_webqoh` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_webqoh`(vtype varchar(20),vcode varchar(500))
BEGIN
if (vcode <> 'All' ) then

	if(vtype='Category') then             
		SELECT c.vcompanyname as suppliername,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
		(Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost
		,a.dUnitPrice as price
        FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and
        a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk'
		and IQTYONHAND !=0  and find_in_set(a.vcategorycode,vcode) and vitemname is not null  ;	
	else           
		SELECT c.vcompanyname as suppliername,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
		(Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vdepartmentname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost
		,a.dUnitPrice as price
        FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and
        a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk'
		and IQTYONHAND !=0  and find_in_set(a.vdepcode,vcode) and vitemname is not null  ;           
	end if;
else
	if(vtype='Category') then             
		SELECT c.vcompanyname as suppliername,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
		(Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost
		,a.dUnitPrice as price
        FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and
        a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk'
		and IQTYONHAND !=0  and vitemname is not null  ;	
	else           
		SELECT c.vcompanyname as suppliername,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
		(Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vdepartmentname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost
		,a.dUnitPrice as price
        FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and
        a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk'
		and IQTYONHAND !=0 and vitemname is not null  ;           
	end if;

end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_webzeroitemmovement` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_webzeroitemmovement`(vcode varchar(500),sdate varchar(15),edate varchar(15))
BEGIN
if (vcode <> 'All' ) then
	   
		SELECT c.vcompanyname as suppliername,a.vitemname as itemname, 
		CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
		(Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,	
        b.vdepartmentname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost
		,a.dUnitPrice as price,a.iqtyonhand,(select shelfname from mst_shelf d where a.shelfid=d.Id) as shelf, 
        (select shelvingname from mst_shelving e where a.shelvingid=e.id) as shelving,
        (select aislename from mst_aisle f where a.aisleid=f.Id) as aisle
        FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and
        a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and (a.nUnitCost*npack) > a.dUnitPrice
		and find_in_set(a.vdepcode,vcode) and vitemname is not null and a.vbarcode not in
        (select a.vitemcode from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid and b.vtrntype='Transaction'
        and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y'));           
	

else
	      
		SELECT c.vcompanyname as suppliername,a.vitemname as itemname, 	
        CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else
		(Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,
        b.vdepartmentname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost
		,a.dUnitPrice as price,a.iqtyonhand,(select shelfname from mst_shelf d where a.shelfid=d.Id) as shelf, 
        (select shelvingname from mst_shelving e where a.shelvingid=e.id) as shelving,
        (select aislename from mst_aisle f where a.aisleid=f.Id) as aisle
        FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and
        a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and (a.nUnitCost*npack) > a.dUnitPrice
		 and vitemname is not null and a.vbarcode not in 
         (select a.vitemcode from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid and vtrntype='Transaction'
        and date_format(b.dtrandate,'%Y-%m-%d')  
		between str_to_date(sdate,'%m-%d-%Y') and str_to_date(edate,'%m-%d-%Y'));          
	

end if;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_xzcategory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `rp_xzcategory`(ibatchid bigint)
BEGIN
select vcategoryame,namount,ibatchid as oibatchid from (
	select vcatname as vcategoryame,CASE when sum(nExtunitPrice+nItemTax) is null then 0 else sum(nExtunitPrice+nItemTax) end as namount
  from trn_salesdetail a,trn_sales b
  where a.isalesid = b.isalesid and vcatname is not null
  and  b.vtrntype='Transaction' and  b.ibatchid=ibatchiD
  group by vcatname ) as a ;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_xzdepartment` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_xzdepartment`(ibatchid bigint)
BEGIN
select vdepatname,namount,ibatchid as oibatchid from(
 select vdepname as vdepatname,CASE when sum(nExtunitPrice+nItemTax) is null then 0 else sum(nExtunitPrice+nItemTax) end as namount
  from trn_salesdetail a,trn_sales b
  where a.isalesid = b.isalesid and vcatname is not null
  and  b.vtrntype='Transaction' and  b.ibatchid=ibatchiD
  group by vdepname ) as a;
  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_xzpaidout` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_xzpaidout`(ibatchid bigint)
BEGIN
select vpaidoutname,namount,ibatchid as oibatchid from(
	select b.vpaidoutname, sum(b.namount) as nAmount
  from  trn_paidout a,trn_paidoutdetail b
  where a.ipaidouttrnid = b.ipaidouttrnid and a.ibatchid = ibatchid
  AND  a.VUNIQUETRANID = b.VUNIQUETRANID and  b.vpaidoutname is not null
  group by  b.vpaidoutname ) as aa;
  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_xzpickup` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_xzpickup`(ibatchid bigint)
BEGIN
select namount,date_format(vdatetime,'%h:%i') as vdatetime,vpickname,ibatchid as oibatchid from(
 SELECT NNETTOTAL as namount,dtrandate as vdatetime,concat('Pick Up',@s:=@s+1) as vpickname
  FROM trn_sales a,(SELECT @s:= 0) AS s
  WHERE vtrntype='Cash pickup' and a.ibatchid = ibatchid
  ) as a;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_xzreport` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_xzreport`(ibatchid bigint)
BEGIN
	declare VBATCHANAME VARCHAR(151);
	declare VREGNAME VARCHAR(20);
	declare  NETTOTAL NUMERIC(15, 2);
	declare NTAXABLE NUMERIC(15, 2);
	declare NNONTAXABLETOTAL NUMERIC(15, 2);
	declare NDISCOUNTAMT NUMERIC(15, 2);
	declare  NTAXTOTAL NUMERIC(15, 2);
	declare  NOPENINGBALANCE NUMERIC(15, 2);
	declare  NADDCASH NUMERIC(15, 2);
	declare NCLOSINGBALANCE NUMERIC(15, 2);
	declare  NONACCOUNT NUMERIC(15, 2);
	declare  NONCREDITTOTAL NUMERIC(15, 2);
	declare  NSUBTOTAL NUMERIC(15, 2);
	declare  NPAIDOUT NUMERIC(15, 2);
	declare  NPICKUP NUMERIC(15, 2);
	declare  NTOTALSALESWTAX NUMERIC(15, 2);
	declare OIBATCHID INTEGER;
	declare NTOTALSALEDISCOUNT NUMERIC(15, 2);
	DECLARE  Nebtsales NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NRETURNAMOUNT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NCASHAMOUNT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  NCHECKAMOUNT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  CASHONDRAWER NUMERIC(15, 2) DEFAULT '0';
	DECLARE  CASHSHORT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  WICAMOUNT NUMERIC(15, 2) DEFAULT '0';
	DECLARE  UserClosingBalance NUMERIC(15, 2) DEFAULT '0';
	DECLARE  ISales NUMERIC(15, 2) DEFAULT '0';
	DECLARE  LSales NUMERIC(15, 2) DEFAULT '0';
	DECLARE  IRedeem NUMERIC(15, 2) DEFAULT '0';
	DECLARE  LRedeem NUMERIC(15, 2) DEFAULT '0';
    DECLARE  onhandSalesRedeem NUMERIC(15, 2) DEFAULT '0';
		set NCLOSINGBALANCE =0;
        select concat(vbatchname,' from [', date_format(dbatchstarttime,'%m-%d-%Y %r') ,']', ' to  [' , case when dbatchendtime is null then date_format(now(),'%m-%d-%Y %r') else date_format(dbatchendtime ,'%m-%d-%Y %r')  end , ']' ) into VBATCHANAME  from trn_batch as a
		where a.ibatchid=ibatchid 
        group by ibatchid;
        
        select a.vregistername into VREGNAME from mst_register a,trn_batch b
		where a.iregisterid= b.vterminalid and b.ibatchid =ibatchid
		group by vregistername; 
        
        SELECT  case when sum(a.NNETTOTAL) is null then 0 else sum(a.NNETTOTAL) end,
        case when sum(a.NTAXABLETOTAL) is null then 0 else sum(a.NTAXABLETOTAL) end
        ,case when sum(a.NNONTAXABLETOTAL) is null then 0 else  sum(a.NNONTAXABLETOTAL) end,
        case when SUM(a.NDISCOUNTAMT) is null then 0 else SUM(a.NDISCOUNTAMT) end,
        case when SUM(a.NTAXTOTAL) is null then 0 else SUM(a.NTAXTOTAL) end ,
        case when sum(a.NSALETOTALAMT) is null then 0 else SUM(a.NSALETOTALAMT) end 
        FROM trn_sales as a
		WHERE a.iOnAccount != 1 and vtrntype='Transaction' and a.ibatchid = ibatchid
         into nettotal,ntaxable,nnontaxabletotal,ndiscountamt,ntaxtotal,ntotalsalediscount;
        
		SELECT case when sum(a.NOpeningBalance) is null then 0 else  sum(a.NOpeningBalance) end , 
        case when sum(a.nuserclosingbalance) is null then 0 else  sum(a.nuserclosingbalance) end
        FROM trn_batch as a
		WHERE  a.ibatchid =ibatchid
        group by a.ibatchid
		into NOPENINGBALANCE,UserClosingBalance;
        
         SELECT case when sum(NNETTOTAL) is null then 0 else sum(NNETTOTAL) end FROM trn_sales as a
			WHERE vtrntype='Add Cash' and a.ibatchid  = ibatchid
			into naddcash;
		
        set NCLOSINGBALANCE = nopeningbalance  + naddcash ;
         set CASHONDRAWER = nopeningbalance  + naddcash ;
        
			SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			FROM trn_sales a,trn_salestender b,mst_tentertype c
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
			and b.itenerid = c.itenderid  and a.ibatchid = ibatchid
			and c.vtendertag in ('Credit','Debit','Gift')
			into noncredittotal;
            
			set NCLOSINGBALANCE = NCLOSINGBALANCE+noncredittotal;        
			set NSUBTOTAL = noncredittotal;
            
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
				and b.itenerid = c.itenderid   and a.ibatchid= ibatchid
				and c.vtendertag in ('OnAcct')
				into nonaccount ;
                set NCLOSINGBALANCE = NCLOSINGBALANCE+nonaccount;
				set NSUBTOTAL = NSUBTOTAL+NONACCOUNT;
                
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
				and b.itenerid = c.itenderid   and a.ibatchid= ibatchid
				and c.vtendertag in ('Ebt')
				into Nebtsales;
                 set NCLOSINGBALANCE = NCLOSINGBALANCE+Nebtsales;
				set NSUBTOTAL = NSUBTOTAL+Nebtsales;
                
                
			SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
			into NCASHAMOUNT FROM trn_sales a,trn_salestender b,mst_tentertype c 
			WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 101
			and b.itenerid = c.itenderid   and a.ibatchid = ibatchid  ; 
			
              set NCLOSINGBALANCE = NCLOSINGBALANCE+NCASHAMOUNT;
				set NSUBTOTAL = NSUBTOTAL+NCASHAMOUNT;
                set CASHONDRAWER = CASHONDRAWER + NCASHAMOUNT;
				SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 102
				and b.itenerid = c.itenderid   and a.ibatchid  =ibatchid   
				into NCHECKAMOUNT;
                set NCLOSINGBALANCE = NCLOSINGBALANCE+NCHECKAMOUNT;
				set NSUBTOTAL = NSUBTOTAL+NCHECKAMOUNT;
                
                SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
				FROM trn_sales a,trn_salestender b,mst_tentertype c
				WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 124
				and b.itenerid = c.itenderid   and a.ibatchid  =ibatchid   
				into WICAMOUNT;
                
				set NCLOSINGBALANCE = NCLOSINGBALANCE+WICAMOUNT;
				set NSUBTOTAL = NSUBTOTAL+WICAMOUNT;
                
					SELECT CASE WHEN sum(b.namount) is null then 0 else sum(b.namount) end
					FROM trn_sales a,trn_salestender b,mst_tentertype c
					WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid = 120
					and b.itenerid = c.itenderid   and a.ibatchid = ibatchid   
					into NRETURNAMOUNT;
                    
                 
                    
					SELECT case when sum(NNETTOTAL) is null then 0 else sum(NNETTOTAL) end    FROM trn_sales as a
					WHERE vtrntype='Cash pickup' and a.ibatchid  =ibatchid
					into npickup;
                    
					select  case when sum(b.namount) is null  then  0 else  sum(b.namount) end
					from  trn_paidout a,trn_paidoutdetail b
					where a.ipaidouttrnid = b.ipaidouttrnid and a.ibatchid = ibatchid
					AND  a.VUNIQUETRANID = b.VUNIQUETRANID   and b.vpaidoutname is not null
					into npaidout;
			
					 set NCLOSINGBALANCE = NCLOSINGBALANCE -  (npaidout + npickup);
                     set ntotalsaleswtax = ntaxable +  nnontaxabletotal ;
					set CASHONDRAWER = CASHONDRAWER -  (npaidout + npickup);
					set CASHSHORT = CASHONDRAWER -UserClosingBalance ;
                    
					select case when sum(o.LSales) is null then 0 else sum(o.LSales) end ,
					case when sum(ISales) is null then 0 else sum(o.ISales) end ,
					case when sum(LRedeem)is null then 0 else sum(o.LRedeem) end ,
					case when sum(IRedeem) is null then 0 else sum(o.IRedeem) end 
                    into LSales,ISales,LRedeem,IRedeem
					from 
					(select case when l.vitemcode = "20" then extprice else 0 end   as 'LSales' ,
					case when l.vitemcode = "21" then  extprice else 0 end   as 'ISales',
					case when l.vitemcode = "22" then  extprice else 0 end   as 'LRedeem',
					case when l.vitemcode = "23" then  extprice else 0 end   as 'IRedeem'
					from
					(select  vitemcode,sum(nextunitprice) as extprice
					from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid  and a.vitemcode in('20','21','22','23') 
                    and b.ibatchid = ibatchid
					group by  vitemcode) as l ) as o;
                   
					set onhandSalesRedeem = (LSales+ISales) - ((LRedeem*-1)+(IRedeem*-1));
        select ibatchid as oibathcid,ntotalsaleswtax,npaidout,npickup,npaidout,NRETURNAMOUNT,NCHECKAMOUNT,NCASHAMOUNT,Nebtsales,NSUBTOTAL,nonaccount,noncredittotal,naddcash,VBATCHANAME,VREGNAME,nettotal,ntaxable,nnontaxabletotal,ndiscountamt,NTAXTOTAL,ntotalsalediscount,NOPENINGBALANCE,NCLOSINGBALANCE,CASHONDRAWER,UserClosingBalance , cashshort,LSales,ISales,LRedeem,IRedeem,onhandSalesRedeem from dual;

END;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_xztender` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_xztender`(ibatchid bigint)
BEGIN

select vtendername,namount,ntotcount,ibatchid as oibatchid from (
  SELECT b.vtendername,sum(b.namount) as namount,count(b.itenerid) as ntotcount
  FROM trn_sales a,trn_salestender b,mst_tentertype c
  WHERE a.vtrntype='Transaction' and a.isalesid = b.isalesid and b.itenerid != 121
  and b.itenerid = c.itenderid   and a.ibatchid=ibatchID 
  group by b.vtendername,c.vtendertag
  
   ) as aa ;
   
  
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `rp_zhourlysales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `rp_zhourlysales`(ibatchid bigint)
BEGIN
SELECT case when(hours > 12 ) then concat(hours-12," PM") else concat(hours," AM") end as TODATE, 
       case when sum(nnettotal) is null then 0 else sum(nnettotal) end AS AMT 
FROM poshour AS h
LEFT OUTER
  JOIN  trn_sales  as a
  on EXTRACT(HOUR FROM dtrandate) = h.hours AND a.ibatchid=ibatchid and  a.vtrntype='Transaction'                          
GROUP  BY h.hours 
order by h.sequence;	
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `spdailysales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `spdailysales`(dailysalesdate date,inout nbegbalance NUMERIC(15,2),inout ntotaltax numeric(15,2),
inout ntotaltaxablesales numeric(15,2),
inout ntotalnontaxablesales numeric(15,2),
inout  ntotalpaidout numeric(15,2),
inout ntotalsales numeric(15,2),
inout ntotalcashpickup numeric(15,2),
inout ntotalcashadded numeric(15,2),
inout ntotaldiscount numeric(15,2),
inout ntotalcreditsales numeric(15,2),
inout ntotaldebitsales numeric(15,2),
inout ntotalgiftsales numeric(15,2),
inout ntotalebtsales numeric(15,2),
inout ntotalcashsales numeric(15,2),
inout ntotalchecksales numeric(15,2),
inout ntotalreturns numeric(15,2) )
BEGIN

declare nopebalance numeric(15,2);
declare vtype varchar(25);
declare ntemptotal numeric(15,2);
declare vnontax numeric(15,2);
declare vntax numeric(15,2);
declare vdiscount numeric(15,2);
declare vtotaltax numeric(15,2);


		SELECT 
		CASE
			WHEN SUM(nOpeningBalance) IS NULL THEN 0
			ELSE SUM(nOpeningBalance)
		END AS opal
		INTO nopebalance FROM
		trn_batch
		WHERE
		EXTRACT(MONTH FROM dBatchStartTime) = EXTRACT(MONTH FROM dailysalesdate)
		AND EXTRACT(DAY FROM dBatchStartTime) = EXTRACT(DAY FROM dailysalesdate)
		AND EXTRACT(YEAR FROM dBatchStartTime) = EXTRACT(YEAR FROM dailysalesdate);
       
		set  nbegbalance = nopebalance;
        
		set vtype='';
			select sum(cash),sum(pickup),sum(tran) into ntotalcashadded,ntotalcashpickup,NTOTALSALES  from (
				SELECT CASE WHEN t.vtrntype ='Add Cash' then t.nnetotal else 0 END as cash, 
				CASE WHEN t.vtrntype ='Cash pickup' then t.nnetotal else 0 END as pickup,
				CASE WHEN t.vtrntype ='Transaction' then t.nnetotal else 0 END as tran from (
				SELECT 		CASE
					WHEN SUM(nnettotal) IS NULL THEN 0
					ELSE SUM(nnettotal)
					END AS nnetotal,
				vtrntype
				 FROM
				trn_sales
				WHERE
				vtrntype IN ('Transaction' , 'Cash pickup', 'Add Cash')
				AND ionaccount != 1
				AND date_format(dTranDate,'%Y-%m-%d') = dailysalesdate
				GROUP BY vtrntype ) as t GROUP BY vtrntype ) as l;
        
				SELECT 
				CASE
					WHEN SUM(namount) IS NULL THEN 0
					ELSE SUM(namount)
					END AS nnetotal
				INTO ntemptotal FROM
				trn_paidout a,
				trn_paidoutdetail b
				WHERE
					a.ipaidouttrnid = b.ipaidouttrnid
				AND date_format(a.ddate,'%Y-%m-%d') = dailysalesdate;

				set    ntotalpaidout = ntemptotal ;
            

				SELECT 
				CASE
					WHEN SUM(NNONTAXABLETOTAL) IS NULL THEN 0
					ELSE SUM(NNONTAXABLETOTAL)
					END AS NNONTAXABLETOTAL,
				CASE
					WHEN SUM(NTAXABLETOTAL) IS NULL THEN 0
					ELSE SUM(NTAXABLETOTAL)
					END AS NTAXABLETOTAL,
				CASE
					WHEN SUM(NTAXTOTAL) IS NULL THEN 0
					ELSE SUM(NTAXTOTAL)
					END AS NTAXTOTAL,
				CASE
					WHEN SUM(NDISCOUNTAMT) IS NULL THEN 0
					ELSE SUM(NDISCOUNTAMT)
					END AS NDISCOUNTAMT
				INTO vnontax , vntax , vtotaltax , vdiscount FROM
				trn_sales
				WHERE
				ionaccount != 1
				AND vtrntype = 'Transaction'
				AND date_format(dTranDate,'%Y-%m-%d') = dailysalesdate;

				set  ntotalnontaxablesales = vnontax;
				set  ntotaltaxablesales = vntax;
				set  ntotaltax = vtotaltax;
				set  ntotaldiscount=vdiscount;
                
				SELECT CASE WHEN sum(m.Credit) IS NULL THEN 0 ELSE SUM(m.Credit) END,
					CASE WHEN sum(m.Gift) IS NULL THEN 0 ELSE SUM(m.Gift) END,
					CASE WHEN sum(m.Ebt) IS NULL THEN 0 ELSE SUM(m.Ebt) END,
					CASE WHEN sum(m.Debit) IS NULL THEN 0 ELSE SUM(m.Debit) END,
                    CASE WHEN sum(m.Checktot) IS NULL THEN 0 ELSE SUM(m.Checktot) END
				into ntotalcreditsales,ntotalgiftsales,ntotalebtsales,ntotaldebitsales,ntotalchecksales from (
				SELECT CASE WHEN t.vtendertag="Credit"  THEN t.namount END as Credit,
					CASE WHEN t.vtendertag="Gift"  THEN t.namount END as Gift ,
					CASE WHEN t.vtendertag="Ebt"  THEN t.namount END as Ebt , 
					CASE WHEN t.vtendertag="Debit"  THEN t.namount END as Debit,
                    CASE WHEN t.vtendertag="Check"  THEN t.namount END as Checktot 
				from
				(
				SELECT	 
				CASE
					WHEN SUM(a.namount) IS NULL THEN 0
					ELSE SUM(a.namount)
				END AS namount,
				vtendertag
				 FROM
				trn_salestender a,
				trn_sales b,
				mst_tentertype c
				WHERE
				date_format(b.dTranDate,'%Y-%m-%d') = dailysalesdate
				AND b.vtrntype = 'Transaction'
				AND a.isalesid = b.isalesid
				AND a.itenerid != 121
				AND a.itenerid = c.itenderid
				GROUP BY vtendertag ) as t GROUP BY vtendertag ) m;


				select CASE WHEN sum(t.Cash) IS NULL THEN 0 ELSE SUM(t.Cash) END, 					
					CASE WHEN sum(t.ReturnItem) IS NULL THEN 0 ELSE SUM(t.ReturnItem) END
				into ntotalcashsales,ntotalreturns from (
				select CASE WHEN (m.vtendername)="Cash" THEN SUM(m.namount) ELSE 0 END as Cash,					
					CASE WHEN (m.vtendername)="ReturnItem" THEN SUM(m.namount) ELSE 0 END as ReturnItem 
                    from (
				SELECT 
				CASE
				WHEN SUM(a.namount) IS NULL THEN 0
				ELSE SUM(a.namount)
				END AS namount,
				vtendername
				FROM
				trn_salestender a,
				trn_sales b
				WHERE
				b.vtrntype = 'Transaction'
				AND a.isalesid = b.isalesid
				AND a.itenerid != 121
				AND vtendername IN ('Cash' ,'ReturnItem')
				AND date_format(b.dTranDate,'%Y-%m-%d') = dailysalesdate
				GROUP BY vtendername ) as m GROUP BY vtendername ) as t;

         
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SPInsertDailySales` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `SPInsertDailySales`(dSalesdate Date)
BEGIN
declare nbegbalance numeric(15,2) default '0';
declare ntotalsales numeric(15,2) default '0';
declare ntotalcashpickup numeric(15,2) default '0';
declare ntotalcashadded numeric(15,2) default '0';
declare ntotalpaidout numeric(15,2) default '0';
declare ntotalnontaxablesales numeric(15,2) default '0';
declare ntotaltaxablesales numeric(15,2) default '0';
declare ntotaltax numeric(15,2) default '0';
declare ntotaldiscount numeric(15,2) default '0';
declare ntotaldebitsales numeric(15,2) default '0';
declare ntotalebtsales numeric(15,2) default '0';
declare ntotalcreditsales numeric(15,2) default '0';
declare ntotalgiftsales numeric(15,2) default '0';
declare ntotalcashsales numeric(15,2) default '0';
declare ntotalchecksales numeric(15,2) default '0';
declare ntotalreturns numeric(15,2) default '0';
declare nclosebal numeric(15,2) default '0';
declare ntotalincome numeric(15,2) default '0';
declare ntotalexpense numeric(15,2) default '0';
declare ncashonedrawer numeric(15,2) default '0';
declare ncashshortover numeric(15,2) default '0';
declare nsubtottal numeric(15,2) default '0';
declare nonacct numeric(15,2) default '0';
declare customercount integer default 0;
declare voidcount integer default 0;
declare dailysalesid integer default 0;

SELECT CASE WHEN SUM(NUSERCLOSINGBALANCE) IS NULL THEN 0 ELSE SUM(NUSERCLOSINGBALANCE) END 
          ,CASE WHEN SUM(NOPENINGBALANCE) IS NULL THEN 0 ELSE SUM(NOPENINGBALANCE) END into NCASHONEDRAWER,NBEGBALANCE
          FROM trn_batch 
          WHERE EXTRACT( MONTH FROM DBATCHSTARTTIME)= EXTRACT(MONTH FROM dSalesdate)
          AND EXTRACT( DAY FROM DBATCHSTARTTIME)= EXTRACT( DAY FROM dSalesdate)
          AND EXTRACT( YEAR FROM DBATCHSTARTTIME)= EXTRACT( YEAR FROM dSalesdate);
  SELECT Case  when sum(a.namount) is null then 0 ELSE sum(a.namount) end as namount into NONACCT
		FROM trn_salestender a,trn_sales b,mst_tentertype c
		WHERE b.vtrntype='Transaction' and a.isalesid = b.isalesid and a.itenerid != 121 
		and a.itenerid = c.itenderid 
		and date_format(b.dTranDate,'%Y-%m-%d')=dSalesdate AND c.vtendertag in ('OnAcct')
		group by c.vtendertag;
                    
  SELECT CASE WHEN sum(a.Income) IS NULL THEN 0 ELSE SUM(A.Income) END as Income, 
        CASE WHEN SUM(a.Expense) IS NULL THEN 0 ELSE SUM(a.Expense) END as Expense into NTOTALINCOME,NTOTALEXPENSE
        
        FROM 
        (
          SELECT CASE WHEN ETYPE = 'Income' then SUM(NAMOUNT) END as Income, 
          CASE WHEN ETYPE = 'Expense' then SUM(NAMOUNT) END as Expense
          FROM trn_leger WHERE DLEGERDATE= dSalesdate
          GROUP BY ETYPE
          )a;
		SELECT CASE WHEN sum(a.Customer) IS NULL THEN 0 ELSE SUM(A.Customer) END , 
        CASE WHEN SUM(a.VoidCustomer) IS NULL THEN 0 ELSE SUM(a.VoidCustomer) END  into customercount,voidcount        
        FROM ( 
		 SELECT CASE WHEN vtrntype = 'Transaction' then COUNT(isalesid) END as Customer, 
          CASE WHEN vtrntype = 'void' then COUNT(isalesid) END as VoidCustomer
          FROM trn_sales WHERE date_format(dTranDate,'%Y-%m-%d')= dSalesdate
          GROUP BY vtrntype ) as a;
          
          
   call spdailysales(dSalesdate,NBEGBALANCE,NTOTALTAX,NTOTALTAXABLESALES,NTOTALNONTAXABLESALES,NTOTALPAIDOUT,NTOTALSALES
    ,NTOTALCASHPICKUP,NTOTALCASHADDED,NTOTALDISCOUNT,NTOTALCREDITSALES,NTOTALDEBITSALES,NTOTALGIFTSALES,NTOTALEBTSALES,
    NTOTALCASHSALES,NTOTALCHECKSALES,NTOTALRETURNS);
    
   
      
             
        select if( NBEGBALANCE IS NULL   ,0, NBEGBALANCE ) as NBEGBALANCE, 
                    if( NTOTALSALES IS NULL  ,0, NTOTALSALES ) as NTOTALSALES,
                    if( NTOTALCASHPICKUP IS NULL  ,0, NTOTALCASHPICKUP ) as NTOTALCASHPICKUP, 
                    if( NTOTALCASHADDED IS NULL  ,0, NTOTALCASHADDED ) as NTOTALCASHADDED, 
                    if( NTOTALPAIDOUT IS NULL  ,0, NTOTALPAIDOUT ) as NTOTALPAIDOUT, 
                    if( NTOTALNONTAXABLESALES IS NULL  ,0, NTOTALNONTAXABLESALES ) as NTOTALNONTAXABLESALES,
                    if( NTOTALTAXABLESALES IS NULL  ,0, NTOTALTAXABLESALES )as NTOTALTAXABLESALES,
                    if( NTOTALTAX IS NULL  ,0, NTOTALTAX ) as NTOTALTAX,
                    if(NTOTALDISCOUNT IS NULL  ,0, NTOTALDISCOUNT ) as NTOTALDISCOUNT,
                    if(NTOTALDEBITSALES IS NULL  ,0, NTOTALDEBITSALES ) as NTOTALDEBITSALES, 
                    if(NTOTALEBTSALES IS NULL  ,0, NTOTALEBTSALES ) as NTOTALEBTSALES, 
                    if(NTOTALCREDITSALES IS NULL  ,0, NTOTALCREDITSALES ) as NTOTALCREDITSALES, 
                    if(NTOTALGIFTSALES IS NULL  ,0, NTOTALGIFTSALES ) as NTOTALGIFTSALES, 
                    if(NTOTALCASHSALES IS NULL  ,0,  NTOTALCASHSALES ) as NTOTALCASHSALES, 
                    if(NTOTALCHECKSALES IS NULL  ,0, NTOTALCHECKSALES ) as NTOTALCHECKSALES, 
                    if(NTOTALRETURNS IS NULL  ,0, NTOTALRETURNS ) as NTOTALRETURNS
                    from dual;
      
       set NSUBTOTTAL = (NTOTALCHECKSALES+NONACCT+NTOTALCASHSALES+NTOTALEBTSALES+NTOTALDEBITSALES+ NTOTALCREDITSALES+NTOTALGIFTSALES);
            set NCLOSEBAL = (NBEGBALANCE +NSUBTOTTAL + NTOTALCASHADDED+NTOTALINCOME) -(NTOTALPAIDOUT+NTOTALCASHPICKUP+NTOTALEXpense);
            set NCASHSHORTOVER = NCLOSEBAL - NCASHONEDRAWER;     
            
            SELECT Id into dailysalesid FROM  trn_dailysales WHERE date_format(DDATE,'%Y-%m-%d') = dSalesdate;
            if(dailysalesid = 0) then           
             INSERT INTO trn_dailysales
                  (
                    DDATE,NNETSALES, NNETPAIDOUT, NNETCASHPICKUP, NOPENINGBALANCE, NCLOSINGBALANCE, NNETADDCASH,
                    NTOTALNONTAXABLE,  NTOTALTAXABLE,  NTOTALSALES, NTOTALTAX, NTOTALCREDITSALES,
                    NTOTALCASHSALES, NTOTALGIFTSALES,  NTOTALCHECKSALES,  NTOTALRETURNS,  NTOTALDISCOUNT,
                    NTOTALDEBITSALES, NTOTALEBTSALES, NTOTALINCOME, NTOTALEXPENSE,NCASHONDRAWER,NCASHSHORTOVER,
                    customercount,voidcount
                  )VALUES
                   (
                    dSalesdate,
                    NTOTALSALES,
                    NTOTALPAIDOUT,
                    NTOTALCASHPICKUP,
                    NBEGBALANCE,
                    NCLOSEBAL,
                    NTOTALCASHADDED,
                    NTOTALNONTAXABLESALES, NTOTALTAXABLESALES,NTOTALSALES, NTOTALTAX,
                    NTOTALCREDITSALES,
                    NTOTALCASHSALES,
                    NTOTALGIFTSALES,
                    NTOTALCHECKSALES,
                    NTOTALRETURNS,
                    NTOTALDISCOUNT,
                    NTOTALDEBITSALES, NTOTALEBTSALES,
                    NTOTALINCOME,NTOTALEXPENSE,NCASHONEDRAWER,NCASHSHORTOVER,
                    customercount,voidcount);
                 
                else
					
						UPDATE trn_dailysales set  NNETSALES= NTOTALSALES, NNETPAIDOUT=NTOTALPAIDOUT, NNETCASHPICKUP=NTOTALCASHPICKUP, NOPENINGBALANCE=NBEGBALANCE, NCLOSINGBALANCE=NCLOSEBAL, NNETADDCASH=NTOTALCASHADDED,
                    NTOTALNONTAXABLE=NTOTALNONTAXABLESALES,  NTOTALTAXABLE=NTOTALTAXABLESALES,  NTOTALSALES=NTOTALSALES, NTOTALTAX=NTOTALTAX, NTOTALCREDITSALES=NTOTALCREDITSALES,
                    NTOTALCASHSALES=NTOTALCASHSALES, NTOTALGIFTSALES=NTOTALGIFTSALES,  NTOTALCHECKSALES=NTOTALCHECKSALES,  NTOTALRETURNS=NTOTALRETURNS,  NTOTALDISCOUNT=NTOTALDISCOUNT,
                    NTOTALDEBITSALES=NTOTALDEBITSALES, NTOTALEBTSALES=NTOTALEBTSALES, NTOTALINCOME=NTOTALINCOME, NTOTALEXPENSE=NTOTALEXPENSE,NCASHONDRAWER=NCASHONEDRAWER,NCASHSHORTOVER=NCASHSHORTOVER,
                    customercount=customercount,voidcount=voidcount where id = dailysalesid;
				END IF;	
END ;;
DELIMITER ;

	ALTER TABLE agreement AUTO_INCREMENT = 100 ;
	ALTER TABLE detail_trans_table AUTO_INCREMENT = 100 ;
	ALTER TABLE itemgroup AUTO_INCREMENT = 100 ;
	ALTER TABLE itemgroupdetail AUTO_INCREMENT = 100 ;
	ALTER TABLE kiosk_category AUTO_INCREMENT = 100 ;
	ALTER TABLE kiosk_default_ingredients AUTO_INCREMENT = 100 ;
	ALTER TABLE kiosk_global_param AUTO_INCREMENT = 100 ;
	ALTER TABLE kiosk_menu_header AUTO_INCREMENT = 100 ;
	ALTER TABLE kiosk_menu_item AUTO_INCREMENT = 100 ;
	ALTER TABLE kiosk_page_flow_detail AUTO_INCREMENT = 100 ;
	ALTER TABLE kiosk_page_flow_header AUTO_INCREMENT = 100 ;
	ALTER TABLE kiosk_page_master AUTO_INCREMENT = 10 ;
	ALTER TABLE kiosk_trn_order AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_adjustmentreason AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_ageverification AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_aisle AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_category AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_customer AUTO_INCREMENT = 100 ;
    ALTER TABLE mst_coupon AUTO_INCREMENT = 200 ;
	ALTER TABLE mst_deleteditem AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_department AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_discount AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_dispalyimagevedio AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_groupslabprice AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_instantbook AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_instantgame AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_instantgameslot AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_instantsettings AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_instantslot AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_item AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_itemalias AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_itemgroup AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_itemkit AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_itemlotmatrix AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_itemmatrix AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_itempackdetail AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_itemslabprice AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_itemvendor AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_location AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_missingitem AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_mpssetting AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_paidout AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_permission AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_permissiongroup AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_permissiongroupdetail AUTO_INCREMENT = 300 ;
	ALTER TABLE mst_posdevice AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_printcustomamount AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_register AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_registersettings AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_shelf AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_shelving AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_size AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_station AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_store AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_storesetting AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_supplier AUTO_INCREMENT = 200 ;
	ALTER TABLE mst_syncmaster AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_synctable AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_tax AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_template AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_templatedetail AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_tentertype AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_unit AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_unitconversion AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_user AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_userpermissiongroup AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_warehouse AUTO_INCREMENT = 100 ;
	ALTER TABLE posscreencontrol AUTO_INCREMENT = 100 ;
	ALTER TABLE posscreenresolution AUTO_INCREMENT = 100 ;
	ALTER TABLE screenresolutiondetail AUTO_INCREMENT = 100 ;
	ALTER TABLE system_status AUTO_INCREMENT = 100 ;
	ALTER TABLE tmp_priceupdate AUTO_INCREMENT = 100 ;
	ALTER TABLE transactiontemp AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_customerpay AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_dailysales AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_dispalyimagevediodetail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_editdeletoperation AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_failover AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_failoverdetail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_holditem AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_instantactivebook AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_instantcashout AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_instantcloseday AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_instantclosedaydetail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_inventory AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_itempricecosthistory AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_leger AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_mpsbatchclose AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_mpsbatchsmry AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_mpsrequest AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_mpstender AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_orderserving AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_paidoutdetail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_physicalinventory AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_physicalinventorydetail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_pickupcash AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_purchaseorder AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_purchaseorderdetail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_quickitem AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_quotationdetail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_saleprice AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_salepricedetail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_salescustomer AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_salesdetail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_salestender AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_userlog AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_userlogdetail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_voidtran AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_warehouseinvoice AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_warehouseitems AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_warehouseqoh AUTO_INCREMENT = 100 ;
	ALTER TABLE web_mst_item AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_delete_table AUTO_INCREMENT = 100 ;
	ALTER TABLE mst_coupon AUTO_INCREMENT = 100 ;	
	ALTER TABLE trn_endofday AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_endofdaydetail AUTO_INCREMENT = 100 ;
	ALTER TABLE web_trn_hold_order AUTO_INCREMENT = 100 ;
	ALTER TABLE web_trn_hold_order_items AUTO_INCREMENT = 100 ;
	ALTER TABLE web_trn_hold_order_details AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_rip_detail AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_rip_header AUTO_INCREMENT = 100 ;
    ALTER TABLE web_store_settings AUTO_INCREMENT = 100 ;
	ALTER TABLE trn_webadmin_history AUTO_INCREMENT = 100 ;	

ALTER TABLE `mst_item` ADD `last_costprice` FLOAT(15,2) NOT NULL DEFAULT '0.00' AFTER `wicitem`;
ALTER TABLE `mst_item` ADD `new_costprice` FLOAT(15,2) NOT NULL DEFAULT '0.00'  AFTER `last_costprice`;

/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-26 13:00:15
