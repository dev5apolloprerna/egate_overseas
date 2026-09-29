-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 29, 2026 at 11:51 AM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `egate_overseas`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE IF NOT EXISTS `blog` (
  `iBlogId` int NOT NULL AUTO_INCREMENT,
  `strBlogTitle` varchar(255) NOT NULL,
  `strBlogDescription` text NOT NULL,
  `strBlogImage` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `strMetaTitle` varchar(255) DEFAULT NULL,
  `strMetaDescription` text,
  `strHead` text,
  `strFooter` text,
  `iStatus` int DEFAULT '1',
  `isDelete` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iBlogId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`iBlogId`, `strBlogTitle`, `strBlogDescription`, `strBlogImage`, `strMetaTitle`, `strMetaDescription`, `strHead`, `strFooter`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'test blog abcd', 'test blog description abcd', '1752758478.jpg', NULL, NULL, NULL, NULL, 1, 0, '2025-07-17 13:20:56', '2025-07-17 13:21:18'),
(2, 'dkgjlkjglkj', 'lkglgjlgkj', NULL, 'ksjglkgjlgj', 'lkfjlfkj', 'flkjlkjglk', 'kljlgkjlgkj', 1, 1, '2025-07-18 07:35:08', '2025-07-18 07:37:47'),
(3, 'test blog 123', 'mnmn,n,n,nmndksjkggkj', NULL, 'skjlgkjlgjgkj', 'lksjglkgsjgkj', 'lkjalkjgjkg', 'lkfjlgkjglkj', 1, 1, '2025-07-18 07:46:42', '2025-07-18 07:46:49'),
(4, 'skklg', 'lklggk', NULL, 'lskglkjg', NULL, NULL, NULL, 1, 1, '2025-07-18 08:52:44', '2025-07-18 08:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `country_master`
--

DROP TABLE IF EXISTS `country_master`;
CREATE TABLE IF NOT EXISTS `country_master` (
  `iCountryId` int NOT NULL AUTO_INCREMENT,
  `strCountryName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `strSlug` varchar(150) NOT NULL,
  `strH1Tag` varchar(150) DEFAULT NULL,
  `strPhoto` varchar(100) DEFAULT NULL,
  `strDescription` text,
  `iStatus` int DEFAULT '1',
  `isDelete` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iCountryId`) USING BTREE,
  UNIQUE KEY `strSlug` (`strSlug`),
  UNIQUE KEY `uq_CountryName` (`strCountryName`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `country_master`
--

INSERT INTO `country_master` (`iCountryId`, `strCountryName`, `strSlug`, `strH1Tag`, `strPhoto`, `strDescription`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'Australia Visa', 'australia-visa', 'Australia Visa', '1754032333.jpg', NULL, 1, 0, '2025-08-01 07:12:13', '2025-08-01 07:12:13');

-- --------------------------------------------------------

--
-- Table structure for table `country_service_master`
--

DROP TABLE IF EXISTS `country_service_master`;
CREATE TABLE IF NOT EXISTS `country_service_master` (
  `iCountryServiceId` int NOT NULL AUTO_INCREMENT,
  `iCountryId` int NOT NULL,
  `strTitle` varchar(255) NOT NULL,
  `strPhoto` varchar(100) DEFAULT NULL,
  `strDescription` text,
  `iStatus` int DEFAULT '1',
  `isDelete` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iCountryServiceId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `country_service_master`
--

INSERT INTO `country_service_master` (`iCountryServiceId`, `iCountryId`, `strTitle`, `strPhoto`, `strDescription`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 1, 'test  country visa services', '1754032854.jpg', 'yesgjgjggjh', 1, 0, '2025-08-01 07:20:54', '2025-08-01 07:20:54');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` int NOT NULL,
  `visa_id` int NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `strIP` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_faqs_country` (`country_id`),
  KEY `fk_faqs_visa` (`visa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `country_id`, `visa_id`, `question`, `answer`, `iStatus`, `isDelete`, `strIP`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 'test question 1', '<p>test answer&nbsp;</p>', 1, 0, '127.0.0.1', '2025-08-01 08:21:20', '2025-08-01 08:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2022-09-12 04:33:06', '2022-09-12 04:33:06'),
(2, 'Employee', 'web', '2022-09-12 04:33:06', '2022-09-12 04:33:06'),
(3, 'Vendor', 'web', '2022-09-12 04:33:06', '2022-09-12 04:33:06');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sendemaildetails`
--

DROP TABLE IF EXISTS `sendemaildetails`;
CREATE TABLE IF NOT EXISTS `sendemaildetails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `strSubject` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strTitle` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strFromMail` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ToMail` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strCC` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strBCC` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `sendemaildetails`
--

INSERT INTO `sendemaildetails` (`id`, `strSubject`, `strTitle`, `strFromMail`, `ToMail`, `strCC`, `strBCC`) VALUES
(4, 'Contact Inquiry', 'Sukti', 'support@sukti.in', NULL, '', ''),
(8, 'Forget Password', 'Sukti', 'support@sukti.in', NULL, NULL, NULL),
(9, 'sign_up', 'Sukti', 'support@sukti.in', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sitename` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `strIP` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `sitename`, `logo`, `email`, `iStatus`, `isDelete`, `created_at`, `updated_at`, `strIP`) VALUES
(1, 'Jewellery crm', '1746446528.png', 'dev5.apolloinfotech@gmail.com', 1, 0, '2025-05-05 12:02:08', NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iCountryId` int NOT NULL,
  `iVisaId` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `strIP` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_country` (`iCountryId`),
  KEY `fk_visa` (`iVisaId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `iCountryId`, `iVisaId`, `name`, `designation`, `description`, `photo`, `iStatus`, `isDelete`, `strIP`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 'test', 'web developer', '<p>test description</p>', '1754037940.jpg', 1, 0, '127.0.0.1', '2025-08-01 08:45:40', '2025-08-01 08:45:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int NOT NULL DEFAULT '2' COMMENT '1=Admin, 2=TA/TP',
  `otp` int DEFAULT NULL,
  `otpTimeOut` datetime DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `mobile_number`, `email_verified_at`, `password`, `role_id`, `otp`, `otpTimeOut`, `status`, `remember_token`, `device_token`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'admin', 'admin@admin.com', '9876543210', NULL, '$2y$10$sPrSb4x/ajMNN4OAnT6pLe4jQXOovPn.05aQ9HlpTA5faYqRTUilO', 1, NULL, NULL, 1, NULL, NULL, '2022-09-12 04:33:06', '2025-07-14 09:48:46'),
(3, 'test user', NULL, 'user123@gmail.com', '9874569878', NULL, '$2y$10$RZ.83m0wM81MfbOkP2iZo.sBTQV/ibcZW80ObuuahAfcrIEAj/a8C', 2, NULL, NULL, 1, NULL, NULL, '2024-03-07 12:24:52', '2024-03-13 16:20:41'),
(4, 'sweta panchal', NULL, 'swetapanchal@gmail.com', '6353143092', NULL, '$2y$10$nWG.apkCeb27rHsao9PnWOPhsshV5cp5OVQzdEPLTiSE7SbZlqAXi', 2, 618888, NULL, 1, NULL, NULL, '2024-03-07 13:29:04', '2024-03-12 14:56:44'),
(5, 'abc', NULL, 'abc@gmail.com', '9532355555', NULL, '$2y$10$mWRzBa9NkHc2RsYTtglZBuro0G0IWMUMqzSazlLLI.kUb2u8I//Xm', 2, NULL, NULL, 1, NULL, NULL, '2024-03-07 13:32:41', '2024-03-07 13:32:41'),
(7, 'prerna parekh', NULL, 'angelrathod96@gmail.com', '8888888888', NULL, '$2y$10$yt/eN588jx3TpGIAOVbMaeE9BJmoovlqNv7pP7FMG2RuBAW2UwJuO', 2, 909478, '2024-04-05 16:22:12', 1, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N1a3RpLmluL2FwaS9sb2dpbiIsImlhdCI6MTcxMjMxOTM2MCwiZXhwIjoxNzEyMzYyNTYwLCJuYmYiOjE3MTIzMTkzNjAsImp0aSI6ImJZVlZhNVFPcVlDS2xBcUIiLCJzdWIiOiI3IiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.l3W9OibG37GsHysAOeL_R62t_p_GECll24DdvPu1MWk', '2024-03-07 13:32:41', '2024-04-05 17:46:00'),
(10, 'swetarth', NULL, 'swetapanchal.96@gmail.com', '6353143098', NULL, '$2y$10$b1s38zJWzTlo8bf2H5fQA.KyZOfYDPAHuhLqa5V1R.I1avp1Wfb5G', 2, 385334, '2024-04-04 19:02:41', 1, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N1a3RpLmluL2FwaS9sb2dpbiIsImlhdCI6MTcxMjMyMDUyOCwiZXhwIjoxNzEyMzYzNzI4LCJuYmYiOjE3MTIzMjA1MjgsImp0aSI6IkNhWm9JVDR4ZmpNSExjZU8iLCJzdWIiOiIxMCIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Hf7nxxJcS0KpoIzNDE1yR-4Jpt8LWGy2YIpHUNdhSm4', '2024-03-12 16:17:25', '2024-04-05 18:05:28'),
(11, 'Tarang Parmar', NULL, 'dev2.apolloinfotech@gmail.com', '9987654321', NULL, '$2y$10$M.RzcoelvicT5EnwUo/koOAWvEipC44sK9lma6qEIsmmfkxZ/NOFm', 2, NULL, NULL, 1, NULL, NULL, '2024-03-14 12:33:18', '2024-03-14 12:33:18'),
(13, 'Ms.Pushti Shah', NULL, 'pushtishah12345@gmail.com', '7896453110', NULL, '$2y$10$1RvHQynWwIiCzC19k8m8tuuEc5pAs4DOI8Nb6K20pEuZj2N2swQDy', 2, NULL, NULL, 1, NULL, NULL, '2024-03-15 14:58:37', '2024-03-26 12:37:24'),
(14, 'Pushti Shah', NULL, 'pushtishah140403@gmail.com', '9328200153', NULL, NULL, 2, NULL, NULL, 1, NULL, NULL, '2024-03-18 18:50:39', '2024-03-18 18:50:39'),
(15, 'prerna parekh', NULL, 'angelprathod96@gmail.com', '4564654564', NULL, NULL, 2, NULL, NULL, 1, NULL, NULL, '2024-03-18 21:58:57', '2024-03-18 21:58:57'),
(16, 'Pushti Shah', NULL, 'shahpushti12345@gmail.com', '9876541230', NULL, NULL, 2, NULL, NULL, 1, NULL, NULL, '2024-03-19 11:11:50', '2024-03-19 11:11:50'),
(17, 'Patel Krushi', NULL, 'patelkrushi242@gmail.com', '6353595756', NULL, '$2y$10$LfRwWwa6DU2o/HBwqfncI.9veFvdConOGX44yqSM.8yr8OQMF8rCO', 2, NULL, NULL, 1, NULL, NULL, '2024-03-20 15:01:04', '2024-03-23 10:33:51'),
(18, 'Bansari Patel', NULL, 'bansaripatel1830@gmail.com', '7866541230', NULL, '$2y$10$6HPDDFe3IIbL2c930mJOweRNlAljYZmWeDUvJQd0SNcK2l.yVAIYy', 2, 842093, '2024-04-05 10:45:31', 1, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N1a3RpLmluL2FwaS9sb2dpbiIsImlhdCI6MTcxMjMxNDA5NCwiZXhwIjoxNzEyMzE3Njk0LCJuYmYiOjE3MTIzMTQwOTQsImp0aSI6IllyU3N3a3JNRzFJeUprZU0iLCJzdWIiOiIxOCIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.EA8fVKKUKmVqK0yqf38MtFS7VSBsMea3LSTvOXQ1DjQ', '2024-03-26 12:48:34', '2024-04-05 16:18:14'),
(19, 'Pushti Shah', NULL, 'pushtishah1234@gmail.com', '9898289098', NULL, '$2y$10$rQgBL8JCtXELLP.fbn7/TuQ88EUOA3a3gd6grcTKjUe/jPbOrdDle', 2, NULL, NULL, 1, NULL, NULL, '2024-03-26 17:20:38', '2024-03-26 17:20:56'),
(20, 'Sandip Travedi', NULL, 'sahassolutions@gmail.com', '8000498000', NULL, NULL, 2, NULL, NULL, 1, NULL, NULL, '2024-03-28 18:04:12', '2024-03-28 18:04:12'),
(21, 'mignesh', NULL, 'migneshpatel202@gmail.com', '9904500629', NULL, '$2y$10$/n/6BWBhXMWY2w3bo2li5eZgLIBqMZuRdhjw4CRFE73gkpr0u6E.S', 2, NULL, NULL, 1, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N1a3RpLmluL2FwaS9sb2dpbiIsImlhdCI6MTcxMjI5NTQwNCwiZXhwIjoxNzEyMjk5MDA0LCJuYmYiOjE3MTIyOTU0MDQsImp0aSI6IlhNYURFMmRQU2JSNTg3SE4iLCJzdWIiOiIyMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.PRDAJYAOxqQdoG6kbDjTFtdOhDo1WY9sPI1XOoDk62M', '2024-04-03 12:44:12', '2024-04-05 11:06:44'),
(22, 'pinal', NULL, 'pinal@gmail.com', '9696532854', NULL, '$2y$10$GJBcC4hfKy45573yMUhureyx7PN2V28TSeKvv7TbwLNDxorifKcuO', 2, NULL, NULL, 1, NULL, NULL, '2024-04-05 14:39:13', '2024-04-05 14:39:13'),
(23, 'Ms.Patel', NULL, 'bansipatel4041@gmail.com', '9924509080', NULL, '$2y$10$fn1FLF78yQcX6eVoKwDkI.CfIbJ7nHLNC1Qqegftt.YGCJH2jW0am', 2, 842989, '2024-04-05 17:30:59', 1, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N1a3RpLmluL2FwaS9sb2dpbiIsImlhdCI6MTcxMjMxOTM1NCwiZXhwIjoxNzEyMzYyNTU0LCJuYmYiOjE3MTIzMTkzNTQsImp0aSI6ImNBUXJSMTloVGRtd1BpVDkiLCJzdWIiOiIyMyIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.KFnLuFtKkkQ3InJEGjEBlaxuScG1tsAWKs1cT5NZh9c', NULL, '2024-04-05 17:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `visa_master`
--

DROP TABLE IF EXISTS `visa_master`;
CREATE TABLE IF NOT EXISTS `visa_master` (
  `iVisaId` int NOT NULL AUTO_INCREMENT,
  `strVisaName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `strSlug` varchar(150) NOT NULL,
  `strH1Tag` varchar(150) DEFAULT NULL,
  `strPhoto` varchar(100) DEFAULT NULL,
  `strDescription` text,
  `iStatus` int DEFAULT '1',
  `isDelete` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iVisaId`),
  UNIQUE KEY `strSlug` (`strSlug`),
  UNIQUE KEY `uq_VisaName` (`strVisaName`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `visa_master`
--

INSERT INTO `visa_master` (`iVisaId`, `strVisaName`, `strSlug`, `strH1Tag`, `strPhoto`, `strDescription`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(8, 'Student Visa', 'student-visa', 'test name 2', '1754036430.jpg', 'test description', 1, 0, '2025-08-01 08:20:30', '2025-08-01 08:20:30');

-- --------------------------------------------------------

--
-- Table structure for table `visa_service_master`
--

DROP TABLE IF EXISTS `visa_service_master`;
CREATE TABLE IF NOT EXISTS `visa_service_master` (
  `iVisaServiceId` int NOT NULL AUTO_INCREMENT,
  `iVisaId` int NOT NULL,
  `strTitle` varchar(255) NOT NULL,
  `strPhoto` varchar(100) DEFAULT NULL,
  `strDescription` text,
  `iStatus` int DEFAULT '1',
  `isDelete` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iVisaServiceId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `visa_service_master`
--

INSERT INTO `visa_service_master` (`iVisaServiceId`, `iVisaId`, `strTitle`, `strPhoto`, `strDescription`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 1, 'skjjkjk', '1752777666.jpg', 'sdjfkfjf', 1, 0, '2025-07-17 18:41:06', '2025-07-17 18:41:06'),
(2, 1, 'skjjkjk', '1752827588.jpg', 'akjljfljf', 1, 0, '2025-07-18 08:33:08', '2025-07-18 08:33:08'),
(3, 2, 'skjjkjk', '1752828319.jpg', 'skfjkjfjf', 1, 0, '2025-07-18 08:45:19', '2025-07-18 08:45:19'),
(4, 3, 'skjjkjk', '1752828705.jpg', 'lssl;klklg', 1, 1, '2025-07-18 08:51:45', '2025-07-18 08:54:41'),
(5, 3, 'kjlkj', NULL, 'sklkfj', 1, 1, '2025-07-18 08:51:52', '2025-07-18 08:54:49'),
(6, 3, 'kskjglgjkg', NULL, 'skgklj', 1, 1, '2025-07-18 08:52:02', '2025-07-18 09:01:20'),
(7, 4, 'skflkglkng', NULL, 'slklkgkgklgj', 1, 1, '2025-07-18 09:01:41', '2025-07-18 09:01:53'),
(8, 5, 'kajlkgjk', NULL, NULL, 1, 1, '2025-07-18 10:33:37', '2025-08-01 07:10:02'),
(9, 3, 'teshg', '1752836449.jpg', 'sgklgkg', 1, 0, '2025-07-18 11:00:49', '2025-07-18 11:00:49'),
(10, 3, 'slskglgk', '1752836462.jpg', 'skl', 1, 0, '2025-07-18 11:01:02', '2025-07-18 11:01:02'),
(11, 3, 'skjjkjk', '1752836828.png', 'keglg', 1, 0, '2025-07-18 11:07:08', '2025-07-18 11:07:08'),
(12, 7, 'student visa services', '1754030444.jpg', 'test description', 1, 1, '2025-08-01 06:40:44', '2025-08-01 07:10:02');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `fk_faqs_country` FOREIGN KEY (`country_id`) REFERENCES `country_master` (`iCountryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_faqs_visa` FOREIGN KEY (`visa_id`) REFERENCES `visa_master` (`iVisaId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_country` FOREIGN KEY (`iCountryId`) REFERENCES `country_master` (`iCountryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `testimonials_ibfk_visa` FOREIGN KEY (`iVisaId`) REFERENCES `visa_master` (`iVisaId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
