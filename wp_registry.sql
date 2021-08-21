-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 21, 2021 at 05:19 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_registry`
--

DROP TABLE IF EXISTS `wp_registry`;
CREATE TABLE IF NOT EXISTS `wp_registry` (
  `id` varchar(3) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `image_url` varchar(300) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp_registry`
--

INSERT INTO `wp_registry` (`id`, `password`, `image_url`, `url`) VALUES
('1', NULL, 'https://img.made.com/image/upload/c_pad,d_madeplusgrey.svg,f_auto,w_982,dpr_2.0,q_auto:good,b_rgb:f5f6f4/v4/catalog/product/asset/e/9/6/1/e96106547cb9b71a15b6be7931840c1aa79da14d_CLPLAB001ZMU_UK_Lab_Ceiling_Pendant_Teal_Deep_Grey_and_Mustard_ar3_2_LB01_PS.png', 'https://www.made.com/nl/lab-hanglamp-turkoois-diepgrijs-en-mosterdgeel'),
('2', NULL, 'https://img.made.com/image/upload/c_pad,d_madeplusgrey.svg,f_auto,w_982,dpr_2.0,q_auto:good,b_rgb:f5f6f4/v4/catalog/product/asset/9/9/6/d/996d2999b8fd0add3938231450a9e88f988a0fff_BSPSYR002GRE_UK_Syrah_Cotton_Velvet_Bedspread_225x220cm_Storm_Green_ar3_2_LB01_LS.jpg', 'https://www.made.com/nl/syrah-bedsprei-van-100-katoenfluweel-225x220cm-blauwgroen'),
('3', NULL, 'https://img.made.com/image/upload/c_pad,d_madeplusgrey.svg,f_auto,w_982,dpr_2.0,q_auto:good,b_rgb:f5f6f4/v4/catalog/product/asset/2/a/e/9/2ae9d488d914e8b1bd690e367f0523769e35af7c_THRKLA001YEL_UK_Klara_200x200cm_Lambswool_Throw_Mustard_ar3_2_LB01_LS.jpg', 'https://www.made.com/nl/klara-sprei-van-lamswol-200-x-200-cm-mostergeel'),
('4', NULL, 'https://img.made.com/image/upload/c_pad,d_madeplusgrey.svg,f_auto,w_982,dpr_2.0,q_auto:good,b_rgb:f5f6f4/v4/catalog/product/asset/4/0/5/f/405f3947526ae03652e95ea70f3ec484e4e0f931_STOHAK002NAT_UK_Hakkan_Polyrattan_Laundry_Basket_Natural_ar3_2_LB01_PS.png', 'https://www.made.com/nl/hakkan-wasmand-van-polyrotan'),
('5', NULL, 'https://img.made.com/image/upload/c_pad,d_madeplusgrey.svg,f_auto,w_982,dpr_2.0,q_auto:good,b_rgb:f5f6f4/v4/catalog/product/asset/5/d/4/9/5d49d9cb9496040849e953803948c437bcf36cbd_BTAJOS004OCR_UK_Joss_30L_Domed_Pedal_Bin_Yellow_ar3_2_LB01_PS.png', 'https://www.made.com/nl/joss-30l-koepelvormige-pedaalemmer-geel'),
('6', NULL, 'https://img.made.com/image/upload/c_pad,d_madeplusgrey.svg,f_auto,w_982,dpr_2.0,q_auto:good,b_rgb:f5f6f4/v4/catalog/product/asset/8/e/f/7/8ef7faecc56a831a24c1e99edf3012203044fcf5_BINCRO001GRN_UK_Cross_Flat_Top_Pedal_Bin_27L_3L_Forest_Green_Copper_ar3_2_LB01_PS.png', 'https://www.made.com/nl/cross-platte-pedaalemmer-prullenbak-27l-en-3l-bosgroen-en-koper'),
('7', NULL, 'https://sissyboy.xcdn.nl/sissy-boy-homeland-riet-beige-00048917-171_1.jpg?f=xlarge', 'https://www.sissy-boy.be/nl/homeland/mand-oranges-medium-00048917-171.html'),
('8', NULL, 'https://sissyboy.xcdn.nl/sissy-boy-homeland-aluminium-oranje-00049239-109_1.jpg?f=xlarge', 'https://www.sissy-boy.be/nl/homeland/peper-en-zout-stel-mandarijn-00049239-109.html'),
('9', NULL, 'https://sissyboy.xcdn.nl/sissy-boy-homeland-staal-roze-00046878-122_1.jpg?f=xlarge', 'https://www.sissy-boy.be/nl/homeland/rose-champagne-slacouvert-set-00046878-122.html'),
('10', NULL, 'https://sissyboy.xcdn.nl/sissy-boy-homeland-ijzer-zwart-00047136-166_1.jpg?f=xlarge', 'https://www.sissy-boy.be/nl/homeland/zwart-bijzettafeltje-00047136-166.html'),
('11', NULL, 'https://sissyboy.xcdn.nl/sissy-boy-homeland-aardewerk-oranje-00045794-109_1.jpg?f=xlarge', 'https://www.sissy-boy.be/nl/homeland/oranje-aardewerk-kom-klein-art-00045794-109.html');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
