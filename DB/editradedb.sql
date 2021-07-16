-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2021 at 08:20 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `editradedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `et_admin`
--

CREATE TABLE `et_admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` enum('developer','owner','admin','marketing','staff') DEFAULT NULL,
  `is_active` enum('yes','no') DEFAULT 'no',
  `forgot_password_code` varchar(255) DEFAULT NULL,
  `cookies` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `otp` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_admin`
--

INSERT INTO `et_admin` (`id`, `email`, `password`, `name`, `role`, `is_active`, `forgot_password_code`, `cookies`, `ip_address`, `user_agent`, `otp`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'adam.pm77@gmail.com', '$2y$10$YysMw8.jKVUn5.bSMioNNurFK/sFahRZ/EoE9l049VHWmEGA6r7h6', 'Adam PM', 'developer', 'yes', NULL, 'IfNG62YRH5NZXe1sCMBdU0mozjPW8gJ8juyiIE3YRfcHrCiQDBqoTm791M0nhDFL', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', 407274, '2021-06-06 00:35:15', '2021-07-16 00:48:50', NULL, NULL, 1, NULL),
(4, 'adam.pm59@gmail.com', '$2y$10$yvrSrpUCLsbutbwJv6GvAuf1b/UpzmKcXhSbjD8mVa4m0V1ijArTe', 'adam', 'admin', 'yes', NULL, NULL, NULL, NULL, NULL, '2021-06-08 23:00:00', '2021-06-17 04:32:24', '2021-06-17 04:32:24', 1, 1, 1),
(5, 'adam.pm59@gmail.com', '$2y$10$.YgEFdZVUSZRUOXo7VT04ugKLHTWOppq8TZfQWHP1NoCv1c3W/vS.', 'Adam PM 2', 'admin', 'yes', NULL, NULL, NULL, NULL, NULL, '2021-06-17 04:33:59', '2021-06-17 04:33:59', NULL, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `et_coinpayment_ipn_trade_manager`
--

CREATE TABLE `et_coinpayment_ipn_trade_manager` (
  `txn_id` varchar(255) NOT NULL,
  `amount` decimal(15,8) DEFAULT NULL,
  `receiver_address` varchar(255) DEFAULT NULL,
  `state` enum('waiting payment','pending','active','inactive','cancel','expired') DEFAULT NULL COMMENT 'waiting payment | pending | active | inactive | cancel | expired',
  `status_code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_coinpayment_ipn_trade_manager`
--

INSERT INTO `et_coinpayment_ipn_trade_manager` (`txn_id`, `amount`, `receiver_address`, `state`, `status_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
('CPFG2IMYQFU11XOPCZYYI7QVAJ', '6.10000000', '0x19673a0bebcc81584352d8c138d0dbc7d6b67157', 'waiting payment', NULL, '2021-07-16 20:49:57', '2021-07-16 20:49:57', NULL),
('CPFG6XWA7EUI2I9WSY5KDTEJ1B', '0.00822000', 'n3NmwF6rUsf4beh1VPdL4HZeort8WTy5rN', 'waiting payment', NULL, '2021-07-16 19:51:35', '2021-07-16 19:51:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `et_country`
--

CREATE TABLE `et_country` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_country`
--

INSERT INTO `et_country` (`id`, `name`, `code`) VALUES
(1, 'Afghanistan', 'AF'),
(2, 'Åland Islands', 'AX'),
(3, 'Albania', 'AL'),
(4, 'Algeria', 'DZ'),
(5, 'American Samoa', 'AS'),
(6, 'Andorra', 'AD'),
(7, 'Angola', 'AO'),
(8, 'Anguilla', 'AI'),
(9, 'Antarctica', 'AQ'),
(10, 'Antigua and Barbuda', 'AG'),
(11, 'Argentina', 'AR'),
(12, 'Armenia', 'AM'),
(13, 'Aruba', 'AW'),
(14, 'Australia', 'AU'),
(15, 'Austria', 'AT'),
(16, 'Azerbaijan', 'AZ'),
(17, 'Bahamas', 'BS'),
(18, 'Bahrain', 'BH'),
(19, 'Bangladesh', 'BD'),
(20, 'Barbados', 'BB'),
(21, 'Belarus', 'BY'),
(22, 'Belgium', 'BE'),
(23, 'Belize', 'BZ'),
(24, 'Benin', 'BJ'),
(25, 'Bermuda', 'BM'),
(26, 'Bhutan', 'BT'),
(27, 'Bolivia', 'BO'),
(28, 'Bosnia and Herzegovina', 'BA'),
(29, 'Botswana', 'BW'),
(30, 'Bouvet Island', 'BV'),
(31, 'Brazil', 'BR'),
(32, 'British Indian Ocean Territory', 'IO'),
(33, 'Brunei Darussalam', 'BN'),
(34, 'Bulgaria', 'BG'),
(35, 'Burkina Faso', 'BF'),
(36, 'Burundi', 'BI'),
(37, 'Cambodia', 'KH'),
(38, 'Cameroon', 'CM'),
(39, 'Canada', 'CA'),
(40, 'Cape Verde', 'CV'),
(41, 'Cayman Islands', 'KY'),
(42, 'Central African Republic', 'CF'),
(43, 'Chad', 'TD'),
(44, 'Chile', 'CL'),
(45, 'China', 'CN'),
(46, 'Christmas Island', 'CX'),
(47, 'Cocos (Keeling) Islands', 'CC'),
(48, 'Colombia', 'CO'),
(49, 'Comoros', 'KM'),
(50, 'Congo', 'CG'),
(51, 'Congo, Democratic Republic', 'CD'),
(52, 'Cook Islands', 'CK'),
(53, 'Costa Rica', 'CR'),
(54, 'Cote D\"Ivoire', 'CI'),
(55, 'Croatia', 'HR'),
(56, 'Cuba', 'CU'),
(57, 'Cyprus', 'CY'),
(58, 'Czech Republic', 'CZ'),
(59, 'Denmark', 'DK'),
(60, 'Djibouti', 'DJ'),
(61, 'Dominica', 'DM'),
(62, 'Dominican Republic', 'DO'),
(63, 'Ecuador', 'EC'),
(64, 'Egypt', 'EG'),
(65, 'El Salvador', 'SV'),
(66, 'Equatorial Guinea', 'GQ'),
(67, 'Eritrea', 'ER'),
(68, 'Estonia', 'EE'),
(69, 'Ethiopia', 'ET'),
(70, 'Falkland Islands (Malvinas)', 'FK'),
(71, 'Faroe Islands', 'FO'),
(72, 'Fiji', 'FJ'),
(73, 'Finland', 'FI'),
(74, 'France', 'FR'),
(75, 'French Guiana', 'GF'),
(76, 'French Polynesia', 'PF'),
(77, 'French Southern Territories', 'TF'),
(78, 'Gabon', 'GA'),
(79, 'Gambia', 'GM'),
(80, 'Georgia', 'GE'),
(81, 'Germany', 'DE'),
(82, 'Ghana', 'GH'),
(83, 'Gibraltar', 'GI'),
(84, 'Greece', 'GR'),
(85, 'Greenland', 'GL'),
(86, 'Grenada', 'GD'),
(87, 'Guadeloupe', 'GP'),
(88, 'Guam', 'GU'),
(89, 'Guatemala', 'GT'),
(90, 'Guernsey', 'GG'),
(91, 'Guinea', 'GN'),
(92, 'Guinea-Bissau', 'GW'),
(93, 'Guyana', 'GY'),
(94, 'Haiti', 'HT'),
(95, 'Heard Island and Mcdonald Islands', 'HM'),
(96, 'Holy See (Vatican City State)', 'VA'),
(97, 'Honduras', 'HN'),
(98, 'Hong Kong', 'HK'),
(99, 'Hungary', 'HU'),
(100, 'Iceland', 'IS'),
(101, 'India', 'IN'),
(102, 'Indonesia', 'ID'),
(103, 'Iran', 'IR'),
(104, 'Iraq', 'IQ'),
(105, 'Ireland', 'IE'),
(106, 'Isle of Man', 'IM'),
(107, 'Israel', 'IL'),
(108, 'Italy', 'IT'),
(109, 'Jamaica', 'JM'),
(110, 'Japan', 'JP'),
(111, 'Jersey', 'JE'),
(112, 'Jordan', 'JO'),
(113, 'Kazakhstan', 'KZ'),
(114, 'Kenya', 'KE'),
(115, 'Kiribati', 'KI'),
(116, 'Korea (North)', 'KP'),
(117, 'Korea (South)', 'KR'),
(118, 'Kosovo', 'XK'),
(119, 'Kuwait', 'KW'),
(120, 'Kyrgyzstan', 'KG'),
(121, 'Laos', 'LA'),
(122, 'Latvia', 'LV'),
(123, 'Lebanon', 'LB'),
(124, 'Lesotho', 'LS'),
(125, 'Liberia', 'LR'),
(126, 'Libyan Arab Jamahiriya', 'LY'),
(127, 'Liechtenstein', 'LI'),
(128, 'Lithuania', 'LT'),
(129, 'Luxembourg', 'LU'),
(130, 'Macao', 'MO'),
(131, 'Macedonia', 'MK'),
(132, 'Madagascar', 'MG'),
(133, 'Malawi', 'MW'),
(134, 'Malaysia', 'MY'),
(135, 'Maldives', 'MV'),
(136, 'Mali', 'ML'),
(137, 'Malta', 'MT'),
(138, 'Marshall Islands', 'MH'),
(139, 'Martinique', 'MQ'),
(140, 'Mauritania', 'MR'),
(141, 'Mauritius', 'MU'),
(142, 'Mayotte', 'YT'),
(143, 'Mexico', 'MX'),
(144, 'Micronesia', 'FM'),
(145, 'Moldova', 'MD'),
(146, 'Monaco', 'MC'),
(147, 'Mongolia', 'MN'),
(148, 'Montserrat', 'MS'),
(149, 'Morocco', 'MA'),
(150, 'Mozambique', 'MZ'),
(151, 'Myanmar', 'MM'),
(152, 'Namibia', 'NA'),
(153, 'Nauru', 'NR'),
(154, 'Nepal', 'NP'),
(155, 'Netherlands', 'NL'),
(156, 'Netherlands Antilles', 'AN'),
(157, 'New Caledonia', 'NC'),
(158, 'New Zealand', 'NZ'),
(159, 'Nicaragua', 'NI'),
(160, 'Niger', 'NE'),
(161, 'Nigeria', 'NG'),
(162, 'Niue', 'NU'),
(163, 'Norfolk Island', 'NF'),
(164, 'Northern Mariana Islands', 'MP'),
(165, 'Norway', 'NO'),
(166, 'Oman', 'OM'),
(167, 'Pakistan', 'PK'),
(168, 'Palau', 'PW'),
(169, 'Palestinian Territory, Occupied', 'PS'),
(170, 'Panama', 'PA'),
(171, 'Papua New Guinea', 'PG'),
(172, 'Paraguay', 'PY'),
(173, 'Peru', 'PE'),
(174, 'Philippines', 'PH'),
(175, 'Pitcairn', 'PN'),
(176, 'Poland', 'PL'),
(177, 'Portugal', 'PT'),
(178, 'Puerto Rico', 'PR'),
(179, 'Qatar', 'QA'),
(180, 'Reunion', 'RE'),
(181, 'Romania', 'RO'),
(182, 'Russian Federation', 'RU'),
(183, 'Rwanda', 'RW'),
(184, 'Saint Helena', 'SH'),
(185, 'Saint Kitts and Nevis', 'KN'),
(186, 'Saint Lucia', 'LC'),
(187, 'Saint Pierre and Miquelon', 'PM'),
(188, 'Saint Vincent and the Grenadines', 'VC'),
(189, 'Samoa', 'WS'),
(190, 'San Marino', 'SM'),
(191, 'Sao Tome and Principe', 'ST'),
(192, 'Saudi Arabia', 'SA'),
(193, 'Senegal', 'SN'),
(194, 'Serbia', 'RS'),
(195, 'Montenegro', 'ME'),
(196, 'Seychelles', 'SC'),
(197, 'Sierra Leone', 'SL'),
(198, 'Singapore', 'SG'),
(199, 'Slovakia', 'SK'),
(200, 'Slovenia', 'SI'),
(201, 'Solomon Islands', 'SB'),
(202, 'Somalia', 'SO'),
(203, 'South Africa', 'ZA'),
(204, 'South Georgia and the South Sandwich Islands', 'GS'),
(205, 'Spain', 'ES'),
(206, 'Sri Lanka', 'LK'),
(207, 'Sudan', 'SD'),
(208, 'Suriname', 'SR'),
(209, 'Svalbard and Jan Mayen', 'SJ'),
(210, 'Swaziland', 'SZ'),
(211, 'Sweden', 'SE'),
(212, 'Switzerland', 'CH'),
(213, 'Syrian Arab Republic', 'SY'),
(214, 'Taiwan, Province of China', 'TW'),
(215, 'Tajikistan', 'TJ'),
(216, 'Tanzania', 'TZ'),
(217, 'Thailand', 'TH'),
(218, 'Timor-Leste', 'TL'),
(219, 'Togo', 'TG'),
(220, 'Tokelau', 'TK'),
(221, 'Tonga', 'TO'),
(222, 'Trinidad and Tobago', 'TT'),
(223, 'Tunisia', 'TN'),
(224, 'Turkey', 'TR'),
(225, 'Turkmenistan', 'TM'),
(226, 'Turks and Caicos Islands', 'TC'),
(227, 'Tuvalu', 'TV'),
(228, 'Uganda', 'UG'),
(229, 'Ukraine', 'UA'),
(230, 'United Arab Emirates', 'AE'),
(231, 'United Kingdom', 'GB'),
(232, 'United States', 'US'),
(233, 'United States Minor Outlying Islands', 'UM'),
(234, 'Uruguay', 'UY'),
(235, 'Uzbekistan', 'UZ'),
(236, 'Vanuatu', 'VU'),
(237, 'Venezuela', 'VE'),
(238, 'Viet Nam', 'VN'),
(239, 'Virgin Islands, British', 'VG'),
(240, 'Virgin Islands, U.S.', 'VI'),
(241, 'Wallis and Futuna', 'WF'),
(242, 'Western Sahara', 'EH'),
(243, 'Yemen', 'YE'),
(244, 'Zambia', 'ZM'),
(245, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `et_log_bonus_qualification_level`
--

CREATE TABLE `et_log_bonus_qualification_level` (
  `id` varchar(255) NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `id_downline` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `type_package` enum('trade manager','crypto asset') DEFAULT NULL COMMENT 'trade manager | crypto asset',
  `invoice` varchar(255) DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) DEFAULT NULL,
  `package_amount` decimal(15,8) DEFAULT NULL COMMENT 'USDT',
  `state` enum('get bonus','correction bonus') DEFAULT NULL COMMENT 'get bonus | correction bonus',
  `description` varchar(255) DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `et_log_bonus_recruitment`
--

CREATE TABLE `et_log_bonus_recruitment` (
  `id` varchar(255) NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `id_downline` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `type_package` enum('trade manager','crypto asset') DEFAULT NULL COMMENT 'trade manager | crypto asset',
  `invoice` varchar(255) DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) DEFAULT NULL,
  `package_amount` decimal(15,8) DEFAULT NULL COMMENT 'USDT',
  `state` enum('get bonus','correction bonus') DEFAULT NULL COMMENT 'get bonus | correction bonus',
  `description` varchar(255) DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `et_log_bonus_royalty`
--

CREATE TABLE `et_log_bonus_royalty` (
  `id` varchar(255) NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `id_downline` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `type_package` enum('trade manager','crypto asset') DEFAULT NULL COMMENT 'trade manager | crypto asset',
  `invoice` varchar(255) DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) DEFAULT NULL,
  `package_amount` decimal(15,8) DEFAULT NULL COMMENT 'USDT',
  `state` enum('get bonus','correction bonus') DEFAULT NULL COMMENT 'get bonus | correction bonus',
  `description` varchar(255) DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `et_log_ipn_trade_manager`
--

CREATE TABLE `et_log_ipn_trade_manager` (
  `id` varchar(255) NOT NULL COMMENT 'uuid',
  `ipn_version` varchar(255) DEFAULT NULL,
  `ipn_type` varchar(255) DEFAULT NULL,
  `ipn_mode` varchar(255) DEFAULT NULL,
  `ipn_id` varchar(255) DEFAULT NULL,
  `merchant` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `status_text` varchar(255) DEFAULT NULL,
  `txn_id` varchar(255) DEFAULT NULL,
  `currency1` varchar(255) DEFAULT NULL,
  `currency2` varchar(255) DEFAULT NULL,
  `amount1` decimal(15,8) DEFAULT NULL,
  `amount2` decimal(15,8) DEFAULT NULL,
  `fee` decimal(15,8) DEFAULT NULL,
  `buyer_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `received_amount` decimal(15,8) DEFAULT NULL,
  `received_confirms` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `et_log_member_trade_manager`
--

CREATE TABLE `et_log_member_trade_manager` (
  `id` varchar(255) NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `invoice` varchar(255) DEFAULT NULL COMMENT 'no invoice',
  `amount_invest` int(11) DEFAULT NULL,
  `amount_transfer` decimal(15,8) DEFAULT NULL,
  `currency_transfer` varchar(255) DEFAULT NULL,
  `txn_id` varchar(255) DEFAULT NULL,
  `state` enum('waiting payment','pending','active','inactive','cancel','expired') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_log_member_trade_manager`
--

INSERT INTO `et_log_member_trade_manager` (`id`, `id_member`, `invoice`, `amount_invest`, `amount_transfer`, `currency_transfer`, `txn_id`, `state`, `description`, `created_at`, `updated_at`) VALUES
('925c363e-e634-11eb-abed-ea7075f67258', '1294a713-e596-11eb-abed-ea7075f67258', 'INV-20210716-000001', 1, '0.00822000', 'LTCT', 'CPFG6XWA7EUI2I9WSY5KDTEJ1B', 'waiting payment', '[2021-07-16 19:51:35] Member adam.pm77@gmail.com Pick Package Starter Pack. Waiting for Payment Transfer', '2021-07-16 19:51:35', NULL),
('bbe94059-e63c-11eb-abed-ea7075f67258', '1294a713-e596-11eb-abed-ea7075f67258', 'INV-20210716-000002', 2, '6.10000000', 'USDT.ERC20', 'CPFG2IMYQFU11XOPCZYYI7QVAJ', 'waiting payment', '[2021-07-16 20:49:57] Member adam.pm77@gmail.com Pick Package Sapphire Pack. Waiting for Payment Transfer', '2021-07-16 20:49:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `et_log_profit_crypto_asset`
--

CREATE TABLE `et_log_profit_crypto_asset` (
  `id` varchar(255) NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `id_downline` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `type_package` enum('trade manager','crypto asset') DEFAULT NULL COMMENT 'trade manager | crypto asset',
  `invoice` varchar(255) DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) DEFAULT NULL,
  `package_amount` decimal(15,8) DEFAULT NULL COMMENT 'USDT',
  `state` enum('get bonus','correction bonus') DEFAULT NULL COMMENT 'get bonus | correction bonus',
  `description` varchar(255) DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `et_log_profit_trade_manager`
--

CREATE TABLE `et_log_profit_trade_manager` (
  `id` varchar(255) NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `invoice` varchar(255) DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) DEFAULT NULL,
  `profit` decimal(15,8) DEFAULT NULL COMMENT 'USDT',
  `state` enum('get bonus','correction bonus') DEFAULT NULL COMMENT 'get bonus | correction bonus',
  `description` varchar(255) DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `et_log_send_email_admin`
--

CREATE TABLE `et_log_send_email_admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail_to` varchar(255) DEFAULT NULL,
  `mail_subject` varchar(255) DEFAULT NULL,
  `mail_message` text DEFAULT NULL,
  `is_success` enum('yes','no') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL COMMENT 'uuid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_log_send_email_admin`
--

INSERT INTO `et_log_send_email_admin` (`id`, `mail_to`, `mail_subject`, `mail_message`, `is_success`, `created_at`, `created_by`) VALUES
(1, 'adam.pm77@gmail.com', 'EDI TRADE | OTP (One Time Password)', '<!DOCTYPE html>\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n\n<head>\n	<meta charset=\"utf-8\"> <!-- utf-8 works for most cases -->\n	<meta name=\"viewport\" content=\"width=device-width\"> <!-- Forcing initial-scale shouldn\'t be necessary -->\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <!-- Use the latest (edge) version of IE rendering engine -->\n	<meta name=\"x-apple-disable-message-reformatting\"> <!-- Disable auto-scale in iOS 10 Mail entirely -->\n	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->\n\n	<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700\" rel=\"stylesheet\">\n\n	<!-- CSS Reset : BEGIN -->\n	<style>\n		/* What it does: Remove spaces around the email design added by some email clients. */\n		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */\n		html,\n		body {\n			margin: 0 auto !important;\n			padding: 0 !important;\n			height: 100% !important;\n			width: 100% !important;\n			background: #f1f1f1;\n		}\n\n		/* What it does: Stops email clients resizing small text. */\n		* {\n			-ms-text-size-adjust: 100%;\n			-webkit-text-size-adjust: 100%;\n		}\n\n		/* What it does: Centers email on Android 4.4 */\n		div[style*=\"margin: 16px 0\"] {\n			margin: 0 !important;\n		}\n\n		/* What it does: Stops Outlook from adding extra spacing to tables. */\n		table,\n		td {\n			mso-table-lspace: 0pt !important;\n			mso-table-rspace: 0pt !important;\n		}\n\n		/* What it does: Fixes webkit padding issue. */\n		table {\n			border-spacing: 0 !important;\n			border-collapse: collapse !important;\n			table-layout: fixed !important;\n			margin: 0 auto !important;\n		}\n\n		/* What it does: Uses a better rendering method when resizing images in IE. */\n		img {\n			-ms-interpolation-mode: bicubic;\n		}\n\n		/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */\n		a {\n			text-decoration: none;\n		}\n\n		/* What it does: A work-around for email clients meddling in triggered links. */\n		*[x-apple-data-detectors],\n		/* iOS */\n		.unstyle-auto-detected-links *,\n		.aBn {\n			border-bottom: 0 !important;\n			cursor: default !important;\n			color: inherit !important;\n			text-decoration: none !important;\n			font-size: inherit !important;\n			font-family: inherit !important;\n			font-weight: inherit !important;\n			line-height: inherit !important;\n		}\n\n		/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */\n		.a6S {\n			display: none !important;\n			opacity: 0.01 !important;\n		}\n\n		/* What it does: Prevents Gmail from changing the text color in conversation threads. */\n		.im {\n			color: inherit !important;\n		}\n\n		/* If the above doesn\'t work, add a .g-img class to any image in question. */\n		img.g-img+div {\n			display: none !important;\n		}\n\n		/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */\n		/* Create one of these media queries for each additional viewport size you\'d like to fix */\n\n		/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */\n		@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {\n			u~div .email-container {\n				min-width: 320px !important;\n			}\n		}\n\n		/* iPhone 6, 6S, 7, 8, and X */\n		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n			u~div .email-container {\n				min-width: 375px !important;\n			}\n		}\n\n		/* iPhone 6+, 7+, and 8+ */\n		@media only screen and (min-device-width: 414px) {\n			u~div .email-container {\n				min-width: 414px !important;\n			}\n		}\n	</style>\n\n	<!-- CSS Reset : END -->\n\n	<!-- Progressive Enhancements : BEGIN -->\n	<style>\n		.primary {\n			background: #30e3ca;\n		}\n\n		.bg_white {\n			background: #ffffff;\n		}\n\n		.bg_light {\n			background: #fafafa;\n		}\n\n		.bg_black {\n			background: #000000;\n		}\n\n		.bg_dark {\n			background: rgba(0, 0, 0, .8);\n		}\n\n		.email-section {\n			padding: 2.5em;\n		}\n\n		/*BUTTON*/\n		.btn {\n			padding: 10px 15px;\n			display: inline-block;\n		}\n\n		.btn.btn-primary {\n			border-radius: 5px;\n			background: #30e3ca;\n			color: #ffffff;\n		}\n\n		.btn.btn-white {\n			border-radius: 5px;\n			background: #ffffff;\n			color: #000000;\n		}\n\n		.btn.btn-white-outline {\n			border-radius: 5px;\n			background: transparent;\n			border: 1px solid #fff;\n			color: #fff;\n		}\n\n		.btn.btn-black-outline {\n			border-radius: 0px;\n			background: transparent;\n			border: 2px solid #000;\n			color: #000;\n			font-weight: 700;\n		}\n\n		h1,\n		h2,\n		h3,\n		h4,\n		h5,\n		h6 {\n			font-family: \'Lato\', sans-serif;\n			color: #000000;\n			margin-top: 0;\n			font-weight: 400;\n		}\n\n		body {\n			font-family: \'Lato\', sans-serif;\n			font-weight: 400;\n			font-size: 15px;\n			line-height: 1.8;\n			color: rgba(0, 0, 0, .4);\n		}\n\n		a {\n			color: #30e3ca;\n		}\n\n		table {}\n\n		/*LOGO*/\n\n		.logo h1 {\n			margin: 0;\n		}\n\n		.logo h1 a {\n			color: #30e3ca;\n			font-size: 24px;\n			font-weight: 700;\n			font-family: \'Lato\', sans-serif;\n		}\n\n		/*HERO*/\n		.hero {\n			position: relative;\n			z-index: 0;\n		}\n\n		.hero .text {\n			color: rgba(0, 0, 0, .3);\n		}\n\n		.hero .text h2 {\n			color: #000;\n			font-size: 40px;\n			margin-bottom: 0;\n			font-weight: 400;\n			line-height: 1.4;\n		}\n\n		.hero .text h3 {\n			font-size: 24px;\n			font-weight: 300;\n		}\n\n		.hero .text h2 span {\n			font-weight: 600;\n			color: #30e3ca;\n		}\n\n\n		/*HEADING SECTION*/\n		.heading-section {}\n\n		.heading-section h2 {\n			color: #000000;\n			font-size: 28px;\n			margin-top: 0;\n			line-height: 1.4;\n			font-weight: 400;\n		}\n\n		.heading-section .subheading {\n			margin-bottom: 20px !important;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(0, 0, 0, .4);\n			position: relative;\n		}\n\n		.heading-section .subheading::after {\n			position: absolute;\n			left: 0;\n			right: 0;\n			bottom: -10px;\n			content: \'\';\n			width: 100%;\n			height: 2px;\n			background: #30e3ca;\n			margin: 0 auto;\n		}\n\n		.heading-section-white {\n			color: rgba(255, 255, 255, .8);\n		}\n\n		.heading-section-white h2 {\n			font-family: Lato;\n			line-height: 1;\n			padding-bottom: 0;\n		}\n\n		.heading-section-white h2 {\n			color: #ffffff;\n		}\n\n		.heading-section-white .subheading {\n			margin-bottom: 0;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(255, 255, 255, .4);\n		}\n\n\n		ul.social {\n			padding: 0;\n		}\n\n		ul.social li {\n			display: inline-block;\n			margin-right: 10px;\n		}\n\n		/*FOOTER*/\n\n		.footer {\n			border-top: 1px solid rgba(0, 0, 0, .05);\n			color: rgba(0, 0, 0, .5);\n		}\n\n		.footer .heading {\n			color: #000;\n			font-size: 20px;\n		}\n\n		.footer ul {\n			margin: 0;\n			padding: 0;\n		}\n\n		.footer ul li {\n			list-style: none;\n			margin-bottom: 10px;\n		}\n\n		.footer ul li a {\n			color: rgba(0, 0, 0, 1);\n		}\n\n\n		@media screen and (max-width: 500px) {}\n	</style>\n\n\n</head>\n\n<body width=\"100%\" style=\"margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;\">\n	<center style=\"width: 100%; background-color: #f1f1f1;\">\n		<div style=\"display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;\">\n			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n		</div>\n		<div style=\"max-width: 600px; margin: 0 auto;\" class=\"email-container\">\n			<!-- BEGIN BODY -->\n			<table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">\n				<tr>\n					<td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">\n						<table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tr>\n								<td class=\"logo\" style=\"text-align: center;\">\n									<h1>\n										<a href=\"http://localhost/admin.editrade.com/\">\n											<img src=\"http://localhost/admin.editrade.com/public/img/logo.png\" alt=\"EDITRADE LOGO\">\n										</a>\n									</h1>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 3em 0 2em 0;\">\n						<img src=\"http://localhost/admin.editrade.com/public/img/otp.png\" alt=\"Logo OTP\" style=\"width: 300px; max-width: 600px; height: auto; margin: auto; display: block;\">\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 2em 0 4em 0;\">\n						<table>\n							<tr>\n								<td>\n									<div class=\"text\" style=\"padding: 0 2.5em; text-align: center;\">\n										<h3>Please verify your One Time Password (OTP)</h3>\n										<h2><kbd>407274</kbd></h2>\n										<h3>Never Share this OTP to anyone</h3>\n									</div>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<!-- 1 Column Text + Button : END -->\n			</table>\n\n		</div>\n	</center>\n</body>\n\n</html>\n', 'yes', NULL, NULL),
(2, 'adam.pm77@gmail.com', 'EDI TRADE | Account Activation', '<!DOCTYPE html>\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n\n<head>\n	<meta charset=\"utf-8\"> <!-- utf-8 works for most cases -->\n	<meta name=\"viewport\" content=\"width=device-width\"> <!-- Forcing initial-scale shouldn\'t be necessary -->\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <!-- Use the latest (edge) version of IE rendering engine -->\n	<meta name=\"x-apple-disable-message-reformatting\"> <!-- Disable auto-scale in iOS 10 Mail entirely -->\n	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->\n\n	<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700\" rel=\"stylesheet\">\n\n	<!-- CSS Reset : BEGIN -->\n	<style>\n		/* What it does: Remove spaces around the email design added by some email clients. */\n		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */\n		html,\n		body {\n			margin: 0 auto !important;\n			padding: 0 !important;\n			height: 100% !important;\n			width: 100% !important;\n			background: #f1f1f1;\n		}\n\n		/* What it does: Stops email clients resizing small text. */\n		* {\n			-ms-text-size-adjust: 100%;\n			-webkit-text-size-adjust: 100%;\n		}\n\n		/* What it does: Centers email on Android 4.4 */\n		div[style*=\"margin: 16px 0\"] {\n			margin: 0 !important;\n		}\n\n		/* What it does: Stops Outlook from adding extra spacing to tables. */\n		table,\n		td {\n			mso-table-lspace: 0pt !important;\n			mso-table-rspace: 0pt !important;\n		}\n\n		/* What it does: Fixes webkit padding issue. */\n		table {\n			border-spacing: 0 !important;\n			border-collapse: collapse !important;\n			table-layout: fixed !important;\n			margin: 0 auto !important;\n		}\n\n		/* What it does: Uses a better rendering method when resizing images in IE. */\n		img {\n			-ms-interpolation-mode: bicubic;\n		}\n\n		/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */\n		a {\n			text-decoration: none;\n		}\n\n		/* What it does: A work-around for email clients meddling in triggered links. */\n		*[x-apple-data-detectors],\n		/* iOS */\n		.unstyle-auto-detected-links *,\n		.aBn {\n			border-bottom: 0 !important;\n			cursor: default !important;\n			color: inherit !important;\n			text-decoration: none !important;\n			font-size: inherit !important;\n			font-family: inherit !important;\n			font-weight: inherit !important;\n			line-height: inherit !important;\n		}\n\n		/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */\n		.a6S {\n			display: none !important;\n			opacity: 0.01 !important;\n		}\n\n		/* What it does: Prevents Gmail from changing the text color in conversation threads. */\n		.im {\n			color: inherit !important;\n		}\n\n		/* If the above doesn\'t work, add a .g-img class to any image in question. */\n		img.g-img+div {\n			display: none !important;\n		}\n\n		/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */\n		/* Create one of these media queries for each additional viewport size you\'d like to fix */\n\n		/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */\n		@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {\n			u~div .email-container {\n				min-width: 320px !important;\n			}\n		}\n\n		/* iPhone 6, 6S, 7, 8, and X */\n		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n			u~div .email-container {\n				min-width: 375px !important;\n			}\n		}\n\n		/* iPhone 6+, 7+, and 8+ */\n		@media only screen and (min-device-width: 414px) {\n			u~div .email-container {\n				min-width: 414px !important;\n			}\n		}\n	</style>\n\n	<!-- CSS Reset : END -->\n\n	<!-- Progressive Enhancements : BEGIN -->\n	<style>\n		.primary {\n			background: #30e3ca;\n		}\n\n		.bg_white {\n			background: #ffffff;\n		}\n\n		.bg_light {\n			background: #fafafa;\n		}\n\n		.bg_black {\n			background: #000000;\n		}\n\n		.bg_dark {\n			background: rgba(0, 0, 0, .8);\n		}\n\n		.email-section {\n			padding: 2.5em;\n		}\n\n		/*BUTTON*/\n		.btn {\n			padding: 10px 15px;\n			display: inline-block;\n		}\n\n		.btn.btn-primary {\n			border-radius: 5px;\n			background: #30e3ca;\n			color: #ffffff;\n		}\n\n		.btn.btn-white {\n			border-radius: 5px;\n			background: #ffffff;\n			color: #000000;\n		}\n\n		.btn.btn-white-outline {\n			border-radius: 5px;\n			background: transparent;\n			border: 1px solid #fff;\n			color: #fff;\n		}\n\n		.btn.btn-black-outline {\n			border-radius: 0px;\n			background: transparent;\n			border: 2px solid #000;\n			color: #000;\n			font-weight: 700;\n		}\n\n		h1,\n		h2,\n		h3,\n		h4,\n		h5,\n		h6 {\n			font-family: \'Lato\', sans-serif;\n			color: #000000;\n			margin-top: 0;\n			font-weight: 400;\n		}\n\n		body {\n			font-family: \'Lato\', sans-serif;\n			font-weight: 400;\n			font-size: 15px;\n			line-height: 1.8;\n			color: rgba(0, 0, 0, .4);\n		}\n\n		a {\n			color: #30e3ca;\n		}\n\n		table {}\n\n		/*LOGO*/\n\n		.logo h1 {\n			margin: 0;\n		}\n\n		.logo h1 a {\n			color: #30e3ca;\n			font-size: 24px;\n			font-weight: 700;\n			font-family: \'Lato\', sans-serif;\n		}\n\n		/*HERO*/\n		.hero {\n			position: relative;\n			z-index: 0;\n		}\n\n		.hero .text {\n			color: rgba(0, 0, 0, .3);\n		}\n\n		.hero .text h2 {\n			color: #000;\n			font-size: 40px;\n			margin-bottom: 0;\n			font-weight: 400;\n			line-height: 1.4;\n		}\n\n		.hero .text h3 {\n			font-size: 24px;\n			font-weight: 300;\n		}\n\n		.hero .text h2 span {\n			font-weight: 600;\n			color: #30e3ca;\n		}\n\n\n		/*HEADING SECTION*/\n		.heading-section {}\n\n		.heading-section h2 {\n			color: #000000;\n			font-size: 28px;\n			margin-top: 0;\n			line-height: 1.4;\n			font-weight: 400;\n		}\n\n		.heading-section .subheading {\n			margin-bottom: 20px !important;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(0, 0, 0, .4);\n			position: relative;\n		}\n\n		.heading-section .subheading::after {\n			position: absolute;\n			left: 0;\n			right: 0;\n			bottom: -10px;\n			content: \'\';\n			width: 100%;\n			height: 2px;\n			background: #30e3ca;\n			margin: 0 auto;\n		}\n\n		.heading-section-white {\n			color: rgba(255, 255, 255, .8);\n		}\n\n		.heading-section-white h2 {\n			font-family: Lato;\n			line-height: 1;\n			padding-bottom: 0;\n		}\n\n		.heading-section-white h2 {\n			color: #ffffff;\n		}\n\n		.heading-section-white .subheading {\n			margin-bottom: 0;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(255, 255, 255, .4);\n		}\n\n\n		ul.social {\n			padding: 0;\n		}\n\n		ul.social li {\n			display: inline-block;\n			margin-right: 10px;\n		}\n\n		/*FOOTER*/\n\n		.footer {\n			border-top: 1px solid rgba(0, 0, 0, .05);\n			color: rgba(0, 0, 0, .5);\n		}\n\n		.footer .heading {\n			color: #000;\n			font-size: 20px;\n		}\n\n		.footer ul {\n			margin: 0;\n			padding: 0;\n		}\n\n		.footer ul li {\n			list-style: none;\n			margin-bottom: 10px;\n		}\n\n		.footer ul li a {\n			color: rgba(0, 0, 0, 1);\n		}\n\n\n		@media screen and (max-width: 500px) {}\n	</style>\n\n\n</head>\n\n<body width=\"100%\" style=\"margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;\">\n	<center style=\"width: 100%; background-color: #f1f1f1;\">\n		<div style=\"display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;\">\n			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n		</div>\n		<div style=\"max-width: 600px; margin: 0 auto;\" class=\"email-container\">\n			<!-- BEGIN BODY -->\n			<table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">\n				<tr>\n					<td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">\n						<table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tr>\n								<td class=\"logo\" style=\"text-align: center;\">\n									<h1>\n										<a href=\"http://localhost/admin.editrade.com/\">\n											<img src=\"http://localhost/admin.editrade.com/public/img/logo.png\" alt=\"EDITRADE LOGO\">\n										</a>\n									</h1>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 3em 0 2em 0;\">\n						<img src=\"http://localhost/admin.editrade.com/public/img/undraw_Checklist__re_2w7v.svg\" alt=\"Logo Activation\" style=\"width: 300px; max-width: 600px; height: auto; margin: auto; display: block;\">\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 2em 0 4em 0;\">\n						<table>\n							<tr>\n								<td>\n									<div class=\"text\" style=\"padding: 0 2.5em; text-align: center;\">\n										<h3>Activate Your Account</h3>\n										<h4><mark><a href=\"http://localhost/editrade.com/activate/adam.pm77%40gmail.com/5b5805c797a6fb090a43929590476897d1fe0209\">http://localhost/editrade.com/activate/adam.pm77%40gmail.com/5b5805c797a6fb090a43929590476897d1fe0209</a></mark></h4>\n									</div>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<!-- 1 Column Text + Button : END -->\n			</table>\n\n		</div>\n	</center>\n</body>\n\n</html>\n', 'yes', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `et_log_send_email_member`
--

CREATE TABLE `et_log_send_email_member` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail_to` varchar(255) DEFAULT NULL,
  `mail_subject` varchar(255) DEFAULT NULL,
  `mail_message` text DEFAULT NULL,
  `is_success` enum('yes','no') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_log_send_email_member`
--

INSERT INTO `et_log_send_email_member` (`id`, `mail_to`, `mail_subject`, `mail_message`, `is_success`, `created_at`, `created_by`) VALUES
(1, 'adam.pm77@gmail.com', 'CryptoProperty | OTP (One Time Password)', '<!DOCTYPE html>\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n\n<head>\n	<meta charset=\"utf-8\"> <!-- utf-8 works for most cases -->\n	<meta name=\"viewport\" content=\"width=device-width\"> <!-- Forcing initial-scale shouldn\'t be necessary -->\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <!-- Use the latest (edge) version of IE rendering engine -->\n	<meta name=\"x-apple-disable-message-reformatting\"> <!-- Disable auto-scale in iOS 10 Mail entirely -->\n	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->\n\n	<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700\" rel=\"stylesheet\">\n\n	<!-- CSS Reset : BEGIN -->\n	<style>\n		/* What it does: Remove spaces around the email design added by some email clients. */\n		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */\n		html,\n		body {\n			margin: 0 auto !important;\n			padding: 0 !important;\n			height: 100% !important;\n			width: 100% !important;\n			background: #f1f1f1;\n		}\n\n		/* What it does: Stops email clients resizing small text. */\n		* {\n			-ms-text-size-adjust: 100%;\n			-webkit-text-size-adjust: 100%;\n		}\n\n		/* What it does: Centers email on Android 4.4 */\n		div[style*=\"margin: 16px 0\"] {\n			margin: 0 !important;\n		}\n\n		/* What it does: Stops Outlook from adding extra spacing to tables. */\n		table,\n		td {\n			mso-table-lspace: 0pt !important;\n			mso-table-rspace: 0pt !important;\n		}\n\n		/* What it does: Fixes webkit padding issue. */\n		table {\n			border-spacing: 0 !important;\n			border-collapse: collapse !important;\n			table-layout: fixed !important;\n			margin: 0 auto !important;\n		}\n\n		/* What it does: Uses a better rendering method when resizing images in IE. */\n		img {\n			-ms-interpolation-mode: bicubic;\n		}\n\n		/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */\n		a {\n			text-decoration: none;\n		}\n\n		/* What it does: A work-around for email clients meddling in triggered links. */\n		*[x-apple-data-detectors],\n		/* iOS */\n		.unstyle-auto-detected-links *,\n		.aBn {\n			border-bottom: 0 !important;\n			cursor: default !important;\n			color: inherit !important;\n			text-decoration: none !important;\n			font-size: inherit !important;\n			font-family: inherit !important;\n			font-weight: inherit !important;\n			line-height: inherit !important;\n		}\n\n		/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */\n		.a6S {\n			display: none !important;\n			opacity: 0.01 !important;\n		}\n\n		/* What it does: Prevents Gmail from changing the text color in conversation threads. */\n		.im {\n			color: inherit !important;\n		}\n\n		/* If the above doesn\'t work, add a .g-img class to any image in question. */\n		img.g-img+div {\n			display: none !important;\n		}\n\n		/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */\n		/* Create one of these media queries for each additional viewport size you\'d like to fix */\n\n		/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */\n		@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {\n			u~div .email-container {\n				min-width: 320px !important;\n			}\n		}\n\n		/* iPhone 6, 6S, 7, 8, and X */\n		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n			u~div .email-container {\n				min-width: 375px !important;\n			}\n		}\n\n		/* iPhone 6+, 7+, and 8+ */\n		@media only screen and (min-device-width: 414px) {\n			u~div .email-container {\n				min-width: 414px !important;\n			}\n		}\n	</style>\n\n	<!-- CSS Reset : END -->\n\n	<!-- Progressive Enhancements : BEGIN -->\n	<style>\n		.primary {\n			background: #30e3ca;\n		}\n\n		.bg_white {\n			background: #ffffff;\n		}\n\n		.bg_light {\n			background: #fafafa;\n		}\n\n		.bg_black {\n			background: #000000;\n		}\n\n		.bg_dark {\n			background: rgba(0, 0, 0, .8);\n		}\n\n		.email-section {\n			padding: 2.5em;\n		}\n\n		/*BUTTON*/\n		.btn {\n			padding: 10px 15px;\n			display: inline-block;\n		}\n\n		.btn.btn-primary {\n			border-radius: 5px;\n			background: #30e3ca;\n			color: #ffffff;\n		}\n\n		.btn.btn-white {\n			border-radius: 5px;\n			background: #ffffff;\n			color: #000000;\n		}\n\n		.btn.btn-white-outline {\n			border-radius: 5px;\n			background: transparent;\n			border: 1px solid #fff;\n			color: #fff;\n		}\n\n		.btn.btn-black-outline {\n			border-radius: 0px;\n			background: transparent;\n			border: 2px solid #000;\n			color: #000;\n			font-weight: 700;\n		}\n\n		h1,\n		h2,\n		h3,\n		h4,\n		h5,\n		h6 {\n			font-family: \'Lato\', sans-serif;\n			color: #000000;\n			margin-top: 0;\n			font-weight: 400;\n		}\n\n		body {\n			font-family: \'Lato\', sans-serif;\n			font-weight: 400;\n			font-size: 15px;\n			line-height: 1.8;\n			color: rgba(0, 0, 0, .4);\n		}\n\n		a {\n			color: #30e3ca;\n		}\n\n		table {}\n\n		/*LOGO*/\n\n		.logo h1 {\n			margin: 0;\n		}\n\n		.logo h1 a {\n			color: #30e3ca;\n			font-size: 24px;\n			font-weight: 700;\n			font-family: \'Lato\', sans-serif;\n		}\n\n		/*HERO*/\n		.hero {\n			position: relative;\n			z-index: 0;\n		}\n\n		.hero .text {\n			color: rgba(0, 0, 0, .3);\n		}\n\n		.hero .text h2 {\n			color: #000;\n			font-size: 40px;\n			margin-bottom: 0;\n			font-weight: 400;\n			line-height: 1.4;\n		}\n\n		.hero .text h3 {\n			font-size: 24px;\n			font-weight: 300;\n		}\n\n		.hero .text h2 span {\n			font-weight: 600;\n			color: #30e3ca;\n		}\n\n\n		/*HEADING SECTION*/\n		.heading-section {}\n\n		.heading-section h2 {\n			color: #000000;\n			font-size: 28px;\n			margin-top: 0;\n			line-height: 1.4;\n			font-weight: 400;\n		}\n\n		.heading-section .subheading {\n			margin-bottom: 20px !important;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(0, 0, 0, .4);\n			position: relative;\n		}\n\n		.heading-section .subheading::after {\n			position: absolute;\n			left: 0;\n			right: 0;\n			bottom: -10px;\n			content: \'\';\n			width: 100%;\n			height: 2px;\n			background: #30e3ca;\n			margin: 0 auto;\n		}\n\n		.heading-section-white {\n			color: rgba(255, 255, 255, .8);\n		}\n\n		.heading-section-white h2 {\n			font-family: Lato;\n			line-height: 1;\n			padding-bottom: 0;\n		}\n\n		.heading-section-white h2 {\n			color: #ffffff;\n		}\n\n		.heading-section-white .subheading {\n			margin-bottom: 0;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(255, 255, 255, .4);\n		}\n\n\n		ul.social {\n			padding: 0;\n		}\n\n		ul.social li {\n			display: inline-block;\n			margin-right: 10px;\n		}\n\n		/*FOOTER*/\n\n		.footer {\n			border-top: 1px solid rgba(0, 0, 0, .05);\n			color: rgba(0, 0, 0, .5);\n		}\n\n		.footer .heading {\n			color: #000;\n			font-size: 20px;\n		}\n\n		.footer ul {\n			margin: 0;\n			padding: 0;\n		}\n\n		.footer ul li {\n			list-style: none;\n			margin-bottom: 10px;\n		}\n\n		.footer ul li a {\n			color: rgba(0, 0, 0, 1);\n		}\n\n\n		@media screen and (max-width: 500px) {}\n	</style>\n\n\n</head>\n\n<body width=\"100%\" style=\"margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;\">\n	<center style=\"width: 100%; background-color: #f1f1f1;\">\n		<div style=\"display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;\">\n			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n		</div>\n		<div style=\"max-width: 600px; margin: 0 auto;\" class=\"email-container\">\n			<!-- BEGIN BODY -->\n			<table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">\n				<tr>\n					<td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">\n						<table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tr>\n								<td class=\"logo\" style=\"text-align: center;\">\n									<h1>\n										<a href=\"http://localhost/editrade.com/\">\n											<img src=\"http://localhost/editrade.com/public/img/logo.png\" alt=\"CryptoProperty LOGO\">\n										</a>\n									</h1>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 3em 0 2em 0;\">\n						<img src=\"http://localhost/editrade.com/public/img/otp.png\" alt=\"Logo OTP\" style=\"width: 300px; max-width: 600px; height: auto; margin: auto; display: block;\">\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 2em 0 4em 0;\">\n						<table>\n							<tr>\n								<td>\n									<div class=\"text\" style=\"padding: 0 2.5em; text-align: center;\">\n										<h3>Please verify your One Time Password (OTP)</h3>\n										<h2><kbd>460720</kbd></h2>\n										<h3>Never Share this OTP to anyone</h3>\n									</div>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<!-- 1 Column Text + Button : END -->\n			</table>\n\n		</div>\n	</center>\n</body>\n\n</html>\n', 'yes', '2021-07-16 00:58:00', '1294a713-e596-11eb-abed-ea7075f67258'),
(2, 'adam.pm77@gmail.com', 'CryptoProperty | OTP (One Time Password)', '<!DOCTYPE html>\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n\n<head>\n	<meta charset=\"utf-8\"> <!-- utf-8 works for most cases -->\n	<meta name=\"viewport\" content=\"width=device-width\"> <!-- Forcing initial-scale shouldn\'t be necessary -->\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <!-- Use the latest (edge) version of IE rendering engine -->\n	<meta name=\"x-apple-disable-message-reformatting\"> <!-- Disable auto-scale in iOS 10 Mail entirely -->\n	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->\n\n	<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700\" rel=\"stylesheet\">\n\n	<!-- CSS Reset : BEGIN -->\n	<style>\n		/* What it does: Remove spaces around the email design added by some email clients. */\n		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */\n		html,\n		body {\n			margin: 0 auto !important;\n			padding: 0 !important;\n			height: 100% !important;\n			width: 100% !important;\n			background: #f1f1f1;\n		}\n\n		/* What it does: Stops email clients resizing small text. */\n		* {\n			-ms-text-size-adjust: 100%;\n			-webkit-text-size-adjust: 100%;\n		}\n\n		/* What it does: Centers email on Android 4.4 */\n		div[style*=\"margin: 16px 0\"] {\n			margin: 0 !important;\n		}\n\n		/* What it does: Stops Outlook from adding extra spacing to tables. */\n		table,\n		td {\n			mso-table-lspace: 0pt !important;\n			mso-table-rspace: 0pt !important;\n		}\n\n		/* What it does: Fixes webkit padding issue. */\n		table {\n			border-spacing: 0 !important;\n			border-collapse: collapse !important;\n			table-layout: fixed !important;\n			margin: 0 auto !important;\n		}\n\n		/* What it does: Uses a better rendering method when resizing images in IE. */\n		img {\n			-ms-interpolation-mode: bicubic;\n		}\n\n		/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */\n		a {\n			text-decoration: none;\n		}\n\n		/* What it does: A work-around for email clients meddling in triggered links. */\n		*[x-apple-data-detectors],\n		/* iOS */\n		.unstyle-auto-detected-links *,\n		.aBn {\n			border-bottom: 0 !important;\n			cursor: default !important;\n			color: inherit !important;\n			text-decoration: none !important;\n			font-size: inherit !important;\n			font-family: inherit !important;\n			font-weight: inherit !important;\n			line-height: inherit !important;\n		}\n\n		/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */\n		.a6S {\n			display: none !important;\n			opacity: 0.01 !important;\n		}\n\n		/* What it does: Prevents Gmail from changing the text color in conversation threads. */\n		.im {\n			color: inherit !important;\n		}\n\n		/* If the above doesn\'t work, add a .g-img class to any image in question. */\n		img.g-img+div {\n			display: none !important;\n		}\n\n		/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */\n		/* Create one of these media queries for each additional viewport size you\'d like to fix */\n\n		/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */\n		@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {\n			u~div .email-container {\n				min-width: 320px !important;\n			}\n		}\n\n		/* iPhone 6, 6S, 7, 8, and X */\n		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n			u~div .email-container {\n				min-width: 375px !important;\n			}\n		}\n\n		/* iPhone 6+, 7+, and 8+ */\n		@media only screen and (min-device-width: 414px) {\n			u~div .email-container {\n				min-width: 414px !important;\n			}\n		}\n	</style>\n\n	<!-- CSS Reset : END -->\n\n	<!-- Progressive Enhancements : BEGIN -->\n	<style>\n		.primary {\n			background: #30e3ca;\n		}\n\n		.bg_white {\n			background: #ffffff;\n		}\n\n		.bg_light {\n			background: #fafafa;\n		}\n\n		.bg_black {\n			background: #000000;\n		}\n\n		.bg_dark {\n			background: rgba(0, 0, 0, .8);\n		}\n\n		.email-section {\n			padding: 2.5em;\n		}\n\n		/*BUTTON*/\n		.btn {\n			padding: 10px 15px;\n			display: inline-block;\n		}\n\n		.btn.btn-primary {\n			border-radius: 5px;\n			background: #30e3ca;\n			color: #ffffff;\n		}\n\n		.btn.btn-white {\n			border-radius: 5px;\n			background: #ffffff;\n			color: #000000;\n		}\n\n		.btn.btn-white-outline {\n			border-radius: 5px;\n			background: transparent;\n			border: 1px solid #fff;\n			color: #fff;\n		}\n\n		.btn.btn-black-outline {\n			border-radius: 0px;\n			background: transparent;\n			border: 2px solid #000;\n			color: #000;\n			font-weight: 700;\n		}\n\n		h1,\n		h2,\n		h3,\n		h4,\n		h5,\n		h6 {\n			font-family: \'Lato\', sans-serif;\n			color: #000000;\n			margin-top: 0;\n			font-weight: 400;\n		}\n\n		body {\n			font-family: \'Lato\', sans-serif;\n			font-weight: 400;\n			font-size: 15px;\n			line-height: 1.8;\n			color: rgba(0, 0, 0, .4);\n		}\n\n		a {\n			color: #30e3ca;\n		}\n\n		table {}\n\n		/*LOGO*/\n\n		.logo h1 {\n			margin: 0;\n		}\n\n		.logo h1 a {\n			color: #30e3ca;\n			font-size: 24px;\n			font-weight: 700;\n			font-family: \'Lato\', sans-serif;\n		}\n\n		/*HERO*/\n		.hero {\n			position: relative;\n			z-index: 0;\n		}\n\n		.hero .text {\n			color: rgba(0, 0, 0, .3);\n		}\n\n		.hero .text h2 {\n			color: #000;\n			font-size: 40px;\n			margin-bottom: 0;\n			font-weight: 400;\n			line-height: 1.4;\n		}\n\n		.hero .text h3 {\n			font-size: 24px;\n			font-weight: 300;\n		}\n\n		.hero .text h2 span {\n			font-weight: 600;\n			color: #30e3ca;\n		}\n\n\n		/*HEADING SECTION*/\n		.heading-section {}\n\n		.heading-section h2 {\n			color: #000000;\n			font-size: 28px;\n			margin-top: 0;\n			line-height: 1.4;\n			font-weight: 400;\n		}\n\n		.heading-section .subheading {\n			margin-bottom: 20px !important;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(0, 0, 0, .4);\n			position: relative;\n		}\n\n		.heading-section .subheading::after {\n			position: absolute;\n			left: 0;\n			right: 0;\n			bottom: -10px;\n			content: \'\';\n			width: 100%;\n			height: 2px;\n			background: #30e3ca;\n			margin: 0 auto;\n		}\n\n		.heading-section-white {\n			color: rgba(255, 255, 255, .8);\n		}\n\n		.heading-section-white h2 {\n			font-family: Lato;\n			line-height: 1;\n			padding-bottom: 0;\n		}\n\n		.heading-section-white h2 {\n			color: #ffffff;\n		}\n\n		.heading-section-white .subheading {\n			margin-bottom: 0;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(255, 255, 255, .4);\n		}\n\n\n		ul.social {\n			padding: 0;\n		}\n\n		ul.social li {\n			display: inline-block;\n			margin-right: 10px;\n		}\n\n		/*FOOTER*/\n\n		.footer {\n			border-top: 1px solid rgba(0, 0, 0, .05);\n			color: rgba(0, 0, 0, .5);\n		}\n\n		.footer .heading {\n			color: #000;\n			font-size: 20px;\n		}\n\n		.footer ul {\n			margin: 0;\n			padding: 0;\n		}\n\n		.footer ul li {\n			list-style: none;\n			margin-bottom: 10px;\n		}\n\n		.footer ul li a {\n			color: rgba(0, 0, 0, 1);\n		}\n\n\n		@media screen and (max-width: 500px) {}\n	</style>\n\n\n</head>\n\n<body width=\"100%\" style=\"margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;\">\n	<center style=\"width: 100%; background-color: #f1f1f1;\">\n		<div style=\"display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;\">\n			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n		</div>\n		<div style=\"max-width: 600px; margin: 0 auto;\" class=\"email-container\">\n			<!-- BEGIN BODY -->\n			<table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">\n				<tr>\n					<td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">\n						<table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tr>\n								<td class=\"logo\" style=\"text-align: center;\">\n									<h1>\n										<a href=\"http://localhost/editrade.com/\">\n											<img src=\"http://localhost/editrade.com/public/img/logo.png\" alt=\"CryptoProperty LOGO\">\n										</a>\n									</h1>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 3em 0 2em 0;\">\n						<img src=\"http://localhost/editrade.com/public/img/otp.png\" alt=\"Logo OTP\" style=\"width: 300px; max-width: 600px; height: auto; margin: auto; display: block;\">\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 2em 0 4em 0;\">\n						<table>\n							<tr>\n								<td>\n									<div class=\"text\" style=\"padding: 0 2.5em; text-align: center;\">\n										<h3>Please verify your One Time Password (OTP)</h3>\n										<h2><kbd>733269</kbd></h2>\n										<h3>Never Share this OTP to anyone</h3>\n									</div>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<!-- 1 Column Text + Button : END -->\n			</table>\n\n		</div>\n	</center>\n</body>\n\n</html>\n', 'yes', '2021-07-16 00:59:23', '1294a713-e596-11eb-abed-ea7075f67258');

-- --------------------------------------------------------

--
-- Table structure for table `et_member`
--

CREATE TABLE `et_member` (
  `id` varchar(255) NOT NULL DEFAULT uuid() COMMENT 'uuid',
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_card_number` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `id_upline` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `country_code` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `otp` int(11) DEFAULT NULL,
  `is_active` enum('yes','no') DEFAULT 'no',
  `activation_code` varchar(255) DEFAULT NULL,
  `forgot_password_code` varchar(255) DEFAULT NULL,
  `is_founder` enum('yes','no') DEFAULT 'no',
  `cookies` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_member`
--

INSERT INTO `et_member` (`id`, `email`, `password`, `id_card_number`, `fullname`, `phone_number`, `id_upline`, `country_code`, `profile_picture`, `otp`, `is_active`, `activation_code`, `forgot_password_code`, `is_founder`, `cookies`, `ip_address`, `user_agent`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1294a713-e596-11eb-abed-ea7075f67258', 'adam.pm77@gmail.com', '$2y$10$NyMMzBU9MhhI2Ow1I3um8O1NzCH9snD/MpUnaFGicCDZsgtkPGzZS', '11111', 'Adam', '082114578976', NULL, NULL, NULL, 733269, 'yes', NULL, NULL, 'yes', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2021-07-16 00:57:04', '2021-07-16 00:59:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `et_member_balance`
--

CREATE TABLE `et_member_balance` (
  `id` varchar(255) NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `total_invest_trade_manager` decimal(15,8) DEFAULT 0.00000000,
  `count_trade_manager` smallint(6) DEFAULT 0,
  `total_invest_crypto_asset` decimal(15,8) DEFAULT 0.00000000,
  `count_crypto_asset` smallint(6) DEFAULT 0,
  `profit_asset` decimal(15,8) DEFAULT NULL,
  `profit` decimal(15,8) DEFAULT 0.00000000,
  `bonus` decimal(15,8) DEFAULT 0.00000000,
  `total_omset` decimal(15,8) DEFAULT 0.00000000,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_member_balance`
--

INSERT INTO `et_member_balance` (`id`, `id_member`, `total_invest_trade_manager`, `count_trade_manager`, `total_invest_crypto_asset`, `count_crypto_asset`, `profit_asset`, `profit`, `bonus`, `total_omset`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1294c065-e596-11eb-abed-ea7075f67258', '1294a713-e596-11eb-abed-ea7075f67258', '0.00000000', 0, '0.00000000', 0, NULL, '0.00000000', '0.00000000', '0.00000000', '2021-07-16 00:57:04', '2021-07-16 00:57:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `et_member_crypto_asset`
--

CREATE TABLE `et_member_crypto_asset` (
  `invoice` varchar(255) NOT NULL COMMENT 'INV-YMD-XXXXXX',
  `sequence` bigint(20) UNSIGNED DEFAULT NULL,
  `id_member` varchar(255) DEFAULT NULL,
  `id_package` smallint(5) UNSIGNED DEFAULT NULL,
  `payment_method` enum('coinpayment') DEFAULT NULL COMMENT 'coinpayment',
  `amount_usd` int(10) UNSIGNED DEFAULT NULL,
  `profit_self_per_day` decimal(15,8) DEFAULT NULL,
  `profit_upline_per_day` decimal(15,8) DEFAULT NULL,
  `profit_company_per_day` decimal(15,8) DEFAULT NULL,
  `currency1` enum('USDT') DEFAULT NULL COMMENT 'USDT',
  `currency2` enum('LTCT','USDT.ERC20','USDT.BEP20') DEFAULT NULL COMMENT 'LTCT | USDT.ERC20 | USDT.BEP20',
  `buyer_email` varchar(255) DEFAULT NULL,
  `buyer_name` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `state` enum('waiting payment','pending','active','inactive','cancel','expired') DEFAULT NULL COMMENT 'waiting payment | pending | active | inactive | cancel | expired',
  `txn_id` varchar(255) DEFAULT NULL,
  `amount_coin` decimal(15,8) DEFAULT NULL,
  `receiver_wallet_address` varchar(255) DEFAULT NULL,
  `timeout` bigint(20) UNSIGNED DEFAULT NULL,
  `checkout_url` varchar(255) DEFAULT NULL,
  `status_url` varchar(255) DEFAULT NULL,
  `qrcode_url` varchar(255) DEFAULT NULL,
  `expired_at` date DEFAULT NULL,
  `is_qualified` enum('yes','no') DEFAULT 'no',
  `is_royalty` enum('yes','no') DEFAULT 'no',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `et_member_reward`
--

CREATE TABLE `et_member_reward` (
  `id_member` varchar(255) NOT NULL COMMENT 'uuid',
  `reward_1` enum('yes','no') DEFAULT 'no',
  `reward_1_date` date DEFAULT NULL,
  `reward_1_done` enum('yes','no') DEFAULT 'no',
  `reward_2` enum('yes','no') DEFAULT 'no',
  `reward_2_date` date DEFAULT NULL,
  `reward_2_done` enum('yes','no') DEFAULT 'no',
  `reward_3` enum('yes','no') DEFAULT 'no',
  `reward_3_date` date DEFAULT NULL,
  `reward_3_done` enum('yes','no') DEFAULT 'no',
  `reward_4` enum('yes','no') DEFAULT 'no',
  `reward_4_date` date DEFAULT NULL,
  `reward_4_done` enum('yes','no') DEFAULT 'no',
  `reward_5` enum('yes','no') DEFAULT 'no',
  `reward_5_date` date DEFAULT NULL,
  `reward_5_done` enum('yes','no') DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_member_reward`
--

INSERT INTO `et_member_reward` (`id_member`, `reward_1`, `reward_1_date`, `reward_1_done`, `reward_2`, `reward_2_date`, `reward_2_done`, `reward_3`, `reward_3_date`, `reward_3_done`, `reward_4`, `reward_4_date`, `reward_4_done`, `reward_5`, `reward_5_date`, `reward_5_done`) VALUES
('1294a713-e596-11eb-abed-ea7075f67258', 'no', NULL, 'no', 'no', NULL, 'no', 'no', NULL, 'no', 'no', NULL, 'no', 'no', NULL, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `et_member_trade_manager`
--

CREATE TABLE `et_member_trade_manager` (
  `invoice` varchar(255) NOT NULL COMMENT 'INV-YMD-XXXXXX',
  `sequence` bigint(20) UNSIGNED DEFAULT NULL,
  `id_member` varchar(255) DEFAULT NULL,
  `id_package` smallint(5) UNSIGNED DEFAULT NULL,
  `payment_method` enum('coinpayment') DEFAULT NULL COMMENT 'coinpayment',
  `amount_usd` int(10) UNSIGNED DEFAULT NULL,
  `profit_self_per_day` decimal(15,8) DEFAULT NULL,
  `profit_upline_per_day` decimal(15,8) DEFAULT NULL,
  `profit_company_per_day` decimal(15,8) DEFAULT NULL,
  `currency1` enum('USDT') DEFAULT NULL COMMENT 'USDT',
  `currency2` enum('LTCT','USDT.ERC20','USDT.BEP20') DEFAULT NULL COMMENT 'LTCT | USDT.ERC20 | USDT.BEP20',
  `buyer_email` varchar(255) DEFAULT NULL,
  `buyer_name` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `state` enum('waiting payment','pending','active','inactive','cancel','expired') DEFAULT NULL COMMENT 'waiting payment | pending | active | inactive | cancel | expired',
  `txn_id` varchar(255) DEFAULT NULL,
  `amount_coin` decimal(15,8) DEFAULT NULL,
  `receiver_wallet_address` varchar(255) DEFAULT NULL,
  `timeout` bigint(20) UNSIGNED DEFAULT NULL,
  `checkout_url` varchar(255) DEFAULT NULL,
  `status_url` varchar(255) DEFAULT NULL,
  `qrcode_url` varchar(255) DEFAULT NULL,
  `expired_at` date DEFAULT NULL,
  `is_qualified` enum('yes','no') DEFAULT 'no',
  `is_royalty` enum('yes','no') DEFAULT 'no',
  `is_extend` enum('auto','manual') DEFAULT 'auto' COMMENT 'auto | manual',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_member_trade_manager`
--

INSERT INTO `et_member_trade_manager` (`invoice`, `sequence`, `id_member`, `id_package`, `payment_method`, `amount_usd`, `profit_self_per_day`, `profit_upline_per_day`, `profit_company_per_day`, `currency1`, `currency2`, `buyer_email`, `buyer_name`, `item_name`, `state`, `txn_id`, `amount_coin`, `receiver_wallet_address`, `timeout`, `checkout_url`, `status_url`, `qrcode_url`, `expired_at`, `is_qualified`, `is_royalty`, `is_extend`, `created_at`, `updated_at`, `deleted_at`) VALUES
('INV-20210716-000001', 1, '1294a713-e596-11eb-abed-ea7075f67258', 1, 'coinpayment', 1, '0.00250000', '0.00125000', '0.00125000', 'USDT', 'LTCT', 'adam.pm77@gmail.com', 'Adam', 'Starter Pack', 'waiting payment', 'CPFG6XWA7EUI2I9WSY5KDTEJ1B', '0.00822000', 'n3NmwF6rUsf4beh1VPdL4HZeort8WTy5rN', 7200, 'https://www.coinpayments.net/index.php?cmd=checkout&id=CPFG6XWA7EUI2I9WSY5KDTEJ1B&key=37fabf16293cae05169a3fe1f1877952', 'https://www.coinpayments.net/index.php?cmd=status&id=CPFG6XWA7EUI2I9WSY5KDTEJ1B&key=37fabf16293cae05169a3fe1f1877952', 'https://www.coinpayments.net/qrgen.php?id=CPFG6XWA7EUI2I9WSY5KDTEJ1B&key=37fabf16293cae05169a3fe1f1877952', '2022-07-16', 'no', 'no', 'auto', '2021-07-16 19:51:35', '2021-07-16 19:51:38', NULL),
('INV-20210716-000002', 2, '1294a713-e596-11eb-abed-ea7075f67258', 2, 'coinpayment', 2, '0.00600000', '0.00200000', '0.00200000', 'USDT', 'USDT.ERC20', 'adam.pm77@gmail.com', 'Adam', 'Sapphire Pack', 'waiting payment', 'CPFG2IMYQFU11XOPCZYYI7QVAJ', '6.10000000', '0x19673a0bebcc81584352d8c138d0dbc7d6b67157', 14400, 'https://www.coinpayments.net/index.php?cmd=checkout&id=CPFG2IMYQFU11XOPCZYYI7QVAJ&key=37389e79550d8544d2294f7e9a7ad651', 'https://www.coinpayments.net/index.php?cmd=status&id=CPFG2IMYQFU11XOPCZYYI7QVAJ&key=37389e79550d8544d2294f7e9a7ad651', 'https://www.coinpayments.net/qrgen.php?id=CPFG2IMYQFU11XOPCZYYI7QVAJ&key=37389e79550d8544d2294f7e9a7ad651', '2022-07-16', 'no', 'no', 'auto', '2021-07-16 20:49:57', '2021-07-16 20:50:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `et_member_wallet`
--

CREATE TABLE `et_member_wallet` (
  `id` varchar(255) NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `receive_coin` enum('bnb','trx','ltct') DEFAULT NULL COMMENT 'bnb | trx | ltct',
  `wallet_host` varchar(255) DEFAULT NULL,
  `wallet_address` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `et_member_withdraw`
--

CREATE TABLE `et_member_withdraw` (
  `id` varchar(255) NOT NULL COMMENT ' uuid',
  `invoice` varchar(255) DEFAULT NULL,
  `sequence` bigint(20) UNSIGNED DEFAULT NULL,
  `id_member` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `amount_1` decimal(15,8) UNSIGNED ZEROFILL DEFAULT NULL,
  `amount_2` decimal(15,8) UNSIGNED ZEROFILL DEFAULT NULL,
  `currency_1` enum('usdt') DEFAULT 'usdt' COMMENT 'usdt | bnb | trx | ltct',
  `currency_2` enum('bnb','trx','ltct') DEFAULT NULL COMMENT 'bnb | trx | ltct',
  `source` enum('profit','bonus') DEFAULT NULL COMMENT 'profit | bonus',
  `id_wallet` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `wallet_host` enum('binance mainnet','trustwallet','tokocrypto','indodax','tronlink mainnet','litecoin wallet testnet') DEFAULT NULL,
  `wallet_address` varchar(255) DEFAULT NULL,
  `state` enum('pending','success','cancel') DEFAULT NULL COMMENT 'pending | success | cancel',
  `tx_id` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `et_package_crypto_asset`
--

CREATE TABLE `et_package_crypto_asset` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL COMMENT 'ET-ABBR',
  `name` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL COMMENT 'usd',
  `profit_per_month_percent` float(15,8) DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_month_value` float(15,8) DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_day_percentage` float(15,8) DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_day_value` float(15,8) DEFAULT NULL,
  `contract_duration` int(11) DEFAULT NULL COMMENT 'day',
  `share_self_percentage` float(15,8) DEFAULT NULL,
  `share_self_value` float(15,8) DEFAULT NULL,
  `share_upline_percentage` float(15,8) DEFAULT NULL,
  `share_upline_value` float(15,8) DEFAULT NULL,
  `share_company_percentage` float(15,8) DEFAULT NULL,
  `share_company_value` float(15,8) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `is_active` enum('yes','no') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_package_crypto_asset`
--

INSERT INTO `et_package_crypto_asset` (`id`, `code`, `name`, `amount`, `profit_per_month_percent`, `profit_per_month_value`, `profit_per_day_percentage`, `profit_per_day_value`, `contract_duration`, `share_self_percentage`, `share_self_value`, `share_upline_percentage`, `share_upline_value`, `share_company_percentage`, `share_company_value`, `logo`, `sequence`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ET-CA-ASH', 'Ashoca Pack', 10000, 15.00000000, 1500.00000000, 0.50000000, 50.00000000, 365, 60.00000000, 30.00000000, 20.00000000, 10.00000000, 20.00000000, 10.00000000, NULL, 1, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL),
(2, 'ET-CA-BOU', 'Bougainvillea Pack', 20000, 15.00000000, 3000.00000000, 0.50000000, 100.00000000, 365, 65.00000000, 65.00000000, 17.50000000, 17.50000000, 17.50000000, 17.50000000, NULL, 2, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL),
(3, 'ET-CA-CLO', 'Clover Pack', 30000, 15.00000000, 4500.00000000, 0.50000000, 150.00000000, 365, 70.00000000, 105.00000000, 15.00000000, 22.50000000, 15.00000000, 22.50000000, NULL, 3, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL),
(4, 'ET-CA-DAH', 'Dahlia Pack', 50000, 15.00000000, 7500.00000000, 0.50000000, 250.00000000, 365, 75.00000000, 187.50000000, 12.50000000, 31.25000000, 12.50000000, 31.25000000, NULL, 4, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL),
(5, 'ET-CA-EDE', 'Edelweiss Pack', 75000, 15.00000000, 11250.00000000, 0.50000000, 375.00000000, 365, 80.00000000, 300.00000000, 10.00000000, 37.50000000, 10.00000000, 37.50000000, NULL, 5, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `et_package_trade_manager`
--

CREATE TABLE `et_package_trade_manager` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL COMMENT 'ET-ABBR',
  `name` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL COMMENT 'usd',
  `profit_per_month_percent` decimal(15,8) DEFAULT NULL COMMENT 'decimal 8',
  `profit_per_month_value` decimal(15,8) DEFAULT NULL COMMENT 'decimal 8',
  `profit_per_day_percentage` decimal(15,8) DEFAULT NULL COMMENT 'decimal 8',
  `profit_per_day_value` decimal(15,8) DEFAULT NULL COMMENT 'decimal 8',
  `contract_duration` int(11) DEFAULT NULL COMMENT 'day',
  `share_self_percentage` decimal(15,8) DEFAULT NULL COMMENT 'decimal 8',
  `share_self_value` decimal(15,8) DEFAULT NULL COMMENT 'decimal 8',
  `share_upline_percentage` decimal(15,8) DEFAULT NULL COMMENT 'decimal 8',
  `share_upline_value` decimal(15,8) DEFAULT NULL COMMENT 'decimal 8',
  `share_company_percentage` decimal(15,8) DEFAULT NULL COMMENT 'decimal 8',
  `share_company_value` decimal(15,8) DEFAULT NULL COMMENT 'decimal 8',
  `logo` varchar(255) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `is_active` enum('yes','no') DEFAULT 'no',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_package_trade_manager`
--

INSERT INTO `et_package_trade_manager` (`id`, `code`, `name`, `amount`, `profit_per_month_percent`, `profit_per_month_value`, `profit_per_day_percentage`, `profit_per_day_value`, `contract_duration`, `share_self_percentage`, `share_self_value`, `share_upline_percentage`, `share_upline_value`, `share_company_percentage`, `share_company_value`, `logo`, `sequence`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ET-TM-STA', 'Starter Pack', 1, '15.00000000', '0.15000000', '0.50000000', '0.00500000', 365, '50.00000000', '0.00250000', '25.00000000', '0.00125000', '25.00000000', '0.00125000', 'starter_logo.png', 1, 'yes', '2021-06-12 03:06:36', '2021-06-12 03:06:40', NULL),
(2, 'ET-TM-SAP', 'Sapphire Pack', 2, '15.00000000', '0.30000000', '0.50000000', '0.01000000', 365, '60.00000000', '0.00600000', '20.00000000', '0.00200000', '20.00000000', '0.00200000', 'sapphire_logo.png', 2, 'yes', '2021-06-12 03:09:28', '2021-06-12 03:09:31', NULL),
(3, 'ET-TM-RUB', 'Ruby Pack', 3, '15.00000000', '0.45000000', '0.50000000', '0.01500000', 365, '70.00000000', '0.01050000', '15.00000000', '0.00225000', '15.00000000', '0.00225000', 'ruby_logo.png', 3, 'yes', '2021-06-12 03:10:27', '2021-06-12 03:10:29', NULL),
(4, 'ET-TM-EME', 'Emerald Pack', 4, '15.00000000', '0.60000000', '0.50000000', '0.02000000', 365, '80.00000000', '0.01600000', '10.00000000', '0.00200000', '10.00000000', '0.00200000', 'emerald_logo.png', 4, 'yes', '2021-06-12 03:11:23', '2021-06-12 03:11:34', NULL),
(5, 'ET-TM-DIA', 'Diamond Pack', 5, '15.00000000', '0.75000000', '0.50000000', '0.02500000', 365, '90.00000000', '0.02250000', '5.00000000', '0.00125000', '5.00000000', '0.00125000', 'diamond_logo.png', 5, 'yes', '2021-06-12 03:12:35', '2021-06-12 03:12:37', NULL),
(6, 'ET-TM-CRO', 'Crown Pack', 0, '15.00000000', '0.00000000', '0.50000000', '0.00000000', 365, '90.00000000', '0.00000000', '5.00000000', '0.00000000', '5.00000000', '0.00000000', 'crown_logo.png', 6, 'yes', '2021-06-12 03:16:46', '2021-06-12 03:16:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `et_package_trade_manager_copy1`
--

CREATE TABLE `et_package_trade_manager_copy1` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL COMMENT 'ET-ABBR',
  `name` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL COMMENT 'usd',
  `profit_per_month_percent` float(15,8) DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_month_value` float(15,8) DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_day_percentage` float(15,8) DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_day_value` float(15,8) DEFAULT NULL,
  `contract_duration` int(11) DEFAULT NULL COMMENT 'day',
  `share_self_percentage` float(15,8) DEFAULT NULL,
  `share_self_value` float(15,8) DEFAULT NULL,
  `share_upline_percentage` float(15,8) DEFAULT NULL,
  `share_upline_value` float(15,8) DEFAULT NULL,
  `share_company_percentage` float(15,8) DEFAULT NULL,
  `share_company_value` float(15,8) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `is_active` enum('yes','no') DEFAULT 'no',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_package_trade_manager_copy1`
--

INSERT INTO `et_package_trade_manager_copy1` (`id`, `code`, `name`, `amount`, `profit_per_month_percent`, `profit_per_month_value`, `profit_per_day_percentage`, `profit_per_day_value`, `contract_duration`, `share_self_percentage`, `share_self_value`, `share_upline_percentage`, `share_upline_value`, `share_company_percentage`, `share_company_value`, `logo`, `sequence`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ET-TM-STA', 'Starter Pack', 100, 15.00000000, 15.00000000, 0.50000000, 0.50000000, 365, 50.00000000, 0.25000000, 25.00000000, 0.12500000, 25.00000000, 0.12500000, 'starter_logo.png', 1, 'yes', '2021-06-12 03:06:36', '2021-06-12 03:06:40', NULL),
(2, 'ET-TM-SAP', 'Sapphire Pack', 500, 15.00000000, 75.00000000, 0.50000000, 2.50000000, 365, 60.00000000, 1.50000000, 20.00000000, 0.50000000, 20.00000000, 0.50000000, 'sapphire_logo.png', 2, 'yes', '2021-06-12 03:09:28', '2021-06-12 03:09:31', NULL),
(3, 'ET-TM-RUB', 'Ruby Pack', 1000, 15.00000000, 150.00000000, 0.50000000, 5.00000000, 365, 70.00000000, 3.50000000, 15.00000000, 0.75000000, 15.00000000, 0.75000000, 'ruby_logo.png', 3, 'yes', '2021-06-12 03:10:27', '2021-06-12 03:10:29', NULL),
(4, 'ET-TM-EME', 'Emerald Pack', 5000, 15.00000000, 750.00000000, 0.50000000, 25.00000000, 365, 80.00000000, 20.00000000, 10.00000000, 2.50000000, 10.00000000, 2.50000000, 'emerald_logo.png', 4, 'yes', '2021-06-12 03:11:23', '2021-06-12 03:11:34', NULL),
(5, 'ET-TM-DIA', 'Diamond Pack', 10000, 15.00000000, 1500.00000000, 0.50000000, 50.00000000, 365, 90.00000000, 45.00000000, 5.00000000, 2.50000000, 5.00000000, 2.50000000, 'diamond_logo.png', 5, 'yes', '2021-06-12 03:12:35', '2021-06-12 03:12:37', NULL),
(6, 'ET-TM-CRO', 'Crown Pack', 0, 15.00000000, 0.00000000, 0.50000000, 0.00000000, 365, 90.00000000, 0.00000000, 5.00000000, 0.00000000, 5.00000000, 0.00000000, 'crown_logo.png', 6, 'yes', '2021-06-12 03:16:46', '2021-06-12 03:16:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `et_tree`
--

CREATE TABLE `et_tree` (
  `id_member` varchar(255) NOT NULL COMMENT 'uuid',
  `email` varchar(255) DEFAULT NULL,
  `id_upline` varchar(255) DEFAULT NULL COMMENT 'uuid',
  `lft` int(10) UNSIGNED DEFAULT NULL,
  `rgt` int(10) UNSIGNED DEFAULT NULL,
  `depth` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_tree`
--

INSERT INTO `et_tree` (`id_member`, `email`, `id_upline`, `lft`, `rgt`, `depth`) VALUES
('1294a713-e596-11eb-abed-ea7075f67258', 'adam.pm77@gmail.com', NULL, 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `et_unknown_balance`
--

CREATE TABLE `et_unknown_balance` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount_profit` decimal(15,8) DEFAULT NULL,
  `amount_bonus` decimal(15,8) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `et_unknown_balance`
--

INSERT INTO `et_unknown_balance` (`id`, `amount_profit`, `amount_bonus`, `updated_at`) VALUES
(1, '0.00000000', '0.00000000', '2021-06-29 07:35:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `et_admin`
--
ALTER TABLE `et_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_coinpayment_ipn_trade_manager`
--
ALTER TABLE `et_coinpayment_ipn_trade_manager`
  ADD PRIMARY KEY (`txn_id`);

--
-- Indexes for table `et_country`
--
ALTER TABLE `et_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_log_bonus_qualification_level`
--
ALTER TABLE `et_log_bonus_qualification_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_log_bonus_recruitment`
--
ALTER TABLE `et_log_bonus_recruitment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_log_bonus_royalty`
--
ALTER TABLE `et_log_bonus_royalty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_log_ipn_trade_manager`
--
ALTER TABLE `et_log_ipn_trade_manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_log_member_trade_manager`
--
ALTER TABLE `et_log_member_trade_manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_log_profit_crypto_asset`
--
ALTER TABLE `et_log_profit_crypto_asset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_log_profit_trade_manager`
--
ALTER TABLE `et_log_profit_trade_manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_log_send_email_admin`
--
ALTER TABLE `et_log_send_email_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_log_send_email_member`
--
ALTER TABLE `et_log_send_email_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_member`
--
ALTER TABLE `et_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_member_balance`
--
ALTER TABLE `et_member_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_member_crypto_asset`
--
ALTER TABLE `et_member_crypto_asset`
  ADD PRIMARY KEY (`invoice`) USING BTREE;

--
-- Indexes for table `et_member_reward`
--
ALTER TABLE `et_member_reward`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `et_member_trade_manager`
--
ALTER TABLE `et_member_trade_manager`
  ADD PRIMARY KEY (`invoice`) USING BTREE;

--
-- Indexes for table `et_member_wallet`
--
ALTER TABLE `et_member_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_member_withdraw`
--
ALTER TABLE `et_member_withdraw`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_package_crypto_asset`
--
ALTER TABLE `et_package_crypto_asset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_package_trade_manager`
--
ALTER TABLE `et_package_trade_manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_package_trade_manager_copy1`
--
ALTER TABLE `et_package_trade_manager_copy1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `et_tree`
--
ALTER TABLE `et_tree`
  ADD PRIMARY KEY (`id_member`) USING BTREE;

--
-- Indexes for table `et_unknown_balance`
--
ALTER TABLE `et_unknown_balance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `et_admin`
--
ALTER TABLE `et_admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `et_country`
--
ALTER TABLE `et_country`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `et_log_send_email_admin`
--
ALTER TABLE `et_log_send_email_admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `et_log_send_email_member`
--
ALTER TABLE `et_log_send_email_member`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `et_package_crypto_asset`
--
ALTER TABLE `et_package_crypto_asset`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `et_package_trade_manager`
--
ALTER TABLE `et_package_trade_manager`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `et_package_trade_manager_copy1`
--
ALTER TABLE `et_package_trade_manager_copy1`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `et_unknown_balance`
--
ALTER TABLE `et_unknown_balance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
