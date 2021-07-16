/*
 Navicat Premium Data Transfer

 Source Server         : MySql
 Source Server Type    : MySQL
 Source Server Version : 100419
 Source Host           : localhost:3306
 Source Schema         : editradedb

 Target Server Type    : MySQL
 Target Server Version : 100419
 File Encoding         : 65001

 Date: 17/07/2021 00:50:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for et_admin
-- ----------------------------
DROP TABLE IF EXISTS `et_admin`;
CREATE TABLE `et_admin`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `role` enum('developer','owner','admin','marketing','staff') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `forgot_password_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cookies` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `otp` int UNSIGNED NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_admin
-- ----------------------------
INSERT INTO `et_admin` VALUES (1, 'adam.pm77@gmail.com', '$2y$10$YysMw8.jKVUn5.bSMioNNurFK/sFahRZ/EoE9l049VHWmEGA6r7h6', 'Adam PM', 'developer', 'yes', NULL, 'IfNG62YRH5NZXe1sCMBdU0mozjPW8gJ8juyiIE3YRfcHrCiQDBqoTm791M0nhDFL', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', 407274, '2021-06-06 00:35:15', '2021-07-16 00:48:50', NULL, NULL, 1, NULL);
INSERT INTO `et_admin` VALUES (4, 'adam.pm59@gmail.com', '$2y$10$yvrSrpUCLsbutbwJv6GvAuf1b/UpzmKcXhSbjD8mVa4m0V1ijArTe', 'adam', 'admin', 'yes', NULL, NULL, NULL, NULL, NULL, '2021-06-08 23:00:00', '2021-06-17 04:32:24', '2021-06-17 04:32:24', 1, 1, 1);
INSERT INTO `et_admin` VALUES (5, 'adam.pm59@gmail.com', '$2y$10$.YgEFdZVUSZRUOXo7VT04ugKLHTWOppq8TZfQWHP1NoCv1c3W/vS.', 'Adam PM 2', 'admin', 'yes', NULL, NULL, NULL, NULL, NULL, '2021-06-17 04:33:59', '2021-06-17 04:33:59', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for et_coinpayment_ipn_trade_manager
-- ----------------------------
DROP TABLE IF EXISTS `et_coinpayment_ipn_trade_manager`;
CREATE TABLE `et_coinpayment_ipn_trade_manager`  (
  `txn_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(15, 8) NULL DEFAULT NULL,
  `receiver_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `state` enum('waiting payment','pending','active','inactive','cancel','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'waiting payment | pending | active | inactive | cancel | expired',
  `status_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`txn_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_coinpayment_ipn_trade_manager
-- ----------------------------
INSERT INTO `et_coinpayment_ipn_trade_manager` VALUES ('CPFG2IMYQFU11XOPCZYYI7QVAJ', 6.10000000, '0x19673a0bebcc81584352d8c138d0dbc7d6b67157', 'waiting payment', NULL, '2021-07-16 20:49:57', '2021-07-16 20:49:57', NULL);
INSERT INTO `et_coinpayment_ipn_trade_manager` VALUES ('CPFG6XWA7EUI2I9WSY5KDTEJ1B', 0.00822000, 'n3NmwF6rUsf4beh1VPdL4HZeort8WTy5rN', 'waiting payment', NULL, '2021-07-16 19:51:35', '2021-07-16 19:51:35', NULL);

-- ----------------------------
-- Table structure for et_country
-- ----------------------------
DROP TABLE IF EXISTS `et_country`;
CREATE TABLE `et_country`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 246 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_country
-- ----------------------------
INSERT INTO `et_country` VALUES (1, 'Afghanistan', 'AF');
INSERT INTO `et_country` VALUES (2, 'Åland Islands', 'AX');
INSERT INTO `et_country` VALUES (3, 'Albania', 'AL');
INSERT INTO `et_country` VALUES (4, 'Algeria', 'DZ');
INSERT INTO `et_country` VALUES (5, 'American Samoa', 'AS');
INSERT INTO `et_country` VALUES (6, 'Andorra', 'AD');
INSERT INTO `et_country` VALUES (7, 'Angola', 'AO');
INSERT INTO `et_country` VALUES (8, 'Anguilla', 'AI');
INSERT INTO `et_country` VALUES (9, 'Antarctica', 'AQ');
INSERT INTO `et_country` VALUES (10, 'Antigua and Barbuda', 'AG');
INSERT INTO `et_country` VALUES (11, 'Argentina', 'AR');
INSERT INTO `et_country` VALUES (12, 'Armenia', 'AM');
INSERT INTO `et_country` VALUES (13, 'Aruba', 'AW');
INSERT INTO `et_country` VALUES (14, 'Australia', 'AU');
INSERT INTO `et_country` VALUES (15, 'Austria', 'AT');
INSERT INTO `et_country` VALUES (16, 'Azerbaijan', 'AZ');
INSERT INTO `et_country` VALUES (17, 'Bahamas', 'BS');
INSERT INTO `et_country` VALUES (18, 'Bahrain', 'BH');
INSERT INTO `et_country` VALUES (19, 'Bangladesh', 'BD');
INSERT INTO `et_country` VALUES (20, 'Barbados', 'BB');
INSERT INTO `et_country` VALUES (21, 'Belarus', 'BY');
INSERT INTO `et_country` VALUES (22, 'Belgium', 'BE');
INSERT INTO `et_country` VALUES (23, 'Belize', 'BZ');
INSERT INTO `et_country` VALUES (24, 'Benin', 'BJ');
INSERT INTO `et_country` VALUES (25, 'Bermuda', 'BM');
INSERT INTO `et_country` VALUES (26, 'Bhutan', 'BT');
INSERT INTO `et_country` VALUES (27, 'Bolivia', 'BO');
INSERT INTO `et_country` VALUES (28, 'Bosnia and Herzegovina', 'BA');
INSERT INTO `et_country` VALUES (29, 'Botswana', 'BW');
INSERT INTO `et_country` VALUES (30, 'Bouvet Island', 'BV');
INSERT INTO `et_country` VALUES (31, 'Brazil', 'BR');
INSERT INTO `et_country` VALUES (32, 'British Indian Ocean Territory', 'IO');
INSERT INTO `et_country` VALUES (33, 'Brunei Darussalam', 'BN');
INSERT INTO `et_country` VALUES (34, 'Bulgaria', 'BG');
INSERT INTO `et_country` VALUES (35, 'Burkina Faso', 'BF');
INSERT INTO `et_country` VALUES (36, 'Burundi', 'BI');
INSERT INTO `et_country` VALUES (37, 'Cambodia', 'KH');
INSERT INTO `et_country` VALUES (38, 'Cameroon', 'CM');
INSERT INTO `et_country` VALUES (39, 'Canada', 'CA');
INSERT INTO `et_country` VALUES (40, 'Cape Verde', 'CV');
INSERT INTO `et_country` VALUES (41, 'Cayman Islands', 'KY');
INSERT INTO `et_country` VALUES (42, 'Central African Republic', 'CF');
INSERT INTO `et_country` VALUES (43, 'Chad', 'TD');
INSERT INTO `et_country` VALUES (44, 'Chile', 'CL');
INSERT INTO `et_country` VALUES (45, 'China', 'CN');
INSERT INTO `et_country` VALUES (46, 'Christmas Island', 'CX');
INSERT INTO `et_country` VALUES (47, 'Cocos (Keeling) Islands', 'CC');
INSERT INTO `et_country` VALUES (48, 'Colombia', 'CO');
INSERT INTO `et_country` VALUES (49, 'Comoros', 'KM');
INSERT INTO `et_country` VALUES (50, 'Congo', 'CG');
INSERT INTO `et_country` VALUES (51, 'Congo, Democratic Republic', 'CD');
INSERT INTO `et_country` VALUES (52, 'Cook Islands', 'CK');
INSERT INTO `et_country` VALUES (53, 'Costa Rica', 'CR');
INSERT INTO `et_country` VALUES (54, 'Cote D\"Ivoire', 'CI');
INSERT INTO `et_country` VALUES (55, 'Croatia', 'HR');
INSERT INTO `et_country` VALUES (56, 'Cuba', 'CU');
INSERT INTO `et_country` VALUES (57, 'Cyprus', 'CY');
INSERT INTO `et_country` VALUES (58, 'Czech Republic', 'CZ');
INSERT INTO `et_country` VALUES (59, 'Denmark', 'DK');
INSERT INTO `et_country` VALUES (60, 'Djibouti', 'DJ');
INSERT INTO `et_country` VALUES (61, 'Dominica', 'DM');
INSERT INTO `et_country` VALUES (62, 'Dominican Republic', 'DO');
INSERT INTO `et_country` VALUES (63, 'Ecuador', 'EC');
INSERT INTO `et_country` VALUES (64, 'Egypt', 'EG');
INSERT INTO `et_country` VALUES (65, 'El Salvador', 'SV');
INSERT INTO `et_country` VALUES (66, 'Equatorial Guinea', 'GQ');
INSERT INTO `et_country` VALUES (67, 'Eritrea', 'ER');
INSERT INTO `et_country` VALUES (68, 'Estonia', 'EE');
INSERT INTO `et_country` VALUES (69, 'Ethiopia', 'ET');
INSERT INTO `et_country` VALUES (70, 'Falkland Islands (Malvinas)', 'FK');
INSERT INTO `et_country` VALUES (71, 'Faroe Islands', 'FO');
INSERT INTO `et_country` VALUES (72, 'Fiji', 'FJ');
INSERT INTO `et_country` VALUES (73, 'Finland', 'FI');
INSERT INTO `et_country` VALUES (74, 'France', 'FR');
INSERT INTO `et_country` VALUES (75, 'French Guiana', 'GF');
INSERT INTO `et_country` VALUES (76, 'French Polynesia', 'PF');
INSERT INTO `et_country` VALUES (77, 'French Southern Territories', 'TF');
INSERT INTO `et_country` VALUES (78, 'Gabon', 'GA');
INSERT INTO `et_country` VALUES (79, 'Gambia', 'GM');
INSERT INTO `et_country` VALUES (80, 'Georgia', 'GE');
INSERT INTO `et_country` VALUES (81, 'Germany', 'DE');
INSERT INTO `et_country` VALUES (82, 'Ghana', 'GH');
INSERT INTO `et_country` VALUES (83, 'Gibraltar', 'GI');
INSERT INTO `et_country` VALUES (84, 'Greece', 'GR');
INSERT INTO `et_country` VALUES (85, 'Greenland', 'GL');
INSERT INTO `et_country` VALUES (86, 'Grenada', 'GD');
INSERT INTO `et_country` VALUES (87, 'Guadeloupe', 'GP');
INSERT INTO `et_country` VALUES (88, 'Guam', 'GU');
INSERT INTO `et_country` VALUES (89, 'Guatemala', 'GT');
INSERT INTO `et_country` VALUES (90, 'Guernsey', 'GG');
INSERT INTO `et_country` VALUES (91, 'Guinea', 'GN');
INSERT INTO `et_country` VALUES (92, 'Guinea-Bissau', 'GW');
INSERT INTO `et_country` VALUES (93, 'Guyana', 'GY');
INSERT INTO `et_country` VALUES (94, 'Haiti', 'HT');
INSERT INTO `et_country` VALUES (95, 'Heard Island and Mcdonald Islands', 'HM');
INSERT INTO `et_country` VALUES (96, 'Holy See (Vatican City State)', 'VA');
INSERT INTO `et_country` VALUES (97, 'Honduras', 'HN');
INSERT INTO `et_country` VALUES (98, 'Hong Kong', 'HK');
INSERT INTO `et_country` VALUES (99, 'Hungary', 'HU');
INSERT INTO `et_country` VALUES (100, 'Iceland', 'IS');
INSERT INTO `et_country` VALUES (101, 'India', 'IN');
INSERT INTO `et_country` VALUES (102, 'Indonesia', 'ID');
INSERT INTO `et_country` VALUES (103, 'Iran', 'IR');
INSERT INTO `et_country` VALUES (104, 'Iraq', 'IQ');
INSERT INTO `et_country` VALUES (105, 'Ireland', 'IE');
INSERT INTO `et_country` VALUES (106, 'Isle of Man', 'IM');
INSERT INTO `et_country` VALUES (107, 'Israel', 'IL');
INSERT INTO `et_country` VALUES (108, 'Italy', 'IT');
INSERT INTO `et_country` VALUES (109, 'Jamaica', 'JM');
INSERT INTO `et_country` VALUES (110, 'Japan', 'JP');
INSERT INTO `et_country` VALUES (111, 'Jersey', 'JE');
INSERT INTO `et_country` VALUES (112, 'Jordan', 'JO');
INSERT INTO `et_country` VALUES (113, 'Kazakhstan', 'KZ');
INSERT INTO `et_country` VALUES (114, 'Kenya', 'KE');
INSERT INTO `et_country` VALUES (115, 'Kiribati', 'KI');
INSERT INTO `et_country` VALUES (116, 'Korea (North)', 'KP');
INSERT INTO `et_country` VALUES (117, 'Korea (South)', 'KR');
INSERT INTO `et_country` VALUES (118, 'Kosovo', 'XK');
INSERT INTO `et_country` VALUES (119, 'Kuwait', 'KW');
INSERT INTO `et_country` VALUES (120, 'Kyrgyzstan', 'KG');
INSERT INTO `et_country` VALUES (121, 'Laos', 'LA');
INSERT INTO `et_country` VALUES (122, 'Latvia', 'LV');
INSERT INTO `et_country` VALUES (123, 'Lebanon', 'LB');
INSERT INTO `et_country` VALUES (124, 'Lesotho', 'LS');
INSERT INTO `et_country` VALUES (125, 'Liberia', 'LR');
INSERT INTO `et_country` VALUES (126, 'Libyan Arab Jamahiriya', 'LY');
INSERT INTO `et_country` VALUES (127, 'Liechtenstein', 'LI');
INSERT INTO `et_country` VALUES (128, 'Lithuania', 'LT');
INSERT INTO `et_country` VALUES (129, 'Luxembourg', 'LU');
INSERT INTO `et_country` VALUES (130, 'Macao', 'MO');
INSERT INTO `et_country` VALUES (131, 'Macedonia', 'MK');
INSERT INTO `et_country` VALUES (132, 'Madagascar', 'MG');
INSERT INTO `et_country` VALUES (133, 'Malawi', 'MW');
INSERT INTO `et_country` VALUES (134, 'Malaysia', 'MY');
INSERT INTO `et_country` VALUES (135, 'Maldives', 'MV');
INSERT INTO `et_country` VALUES (136, 'Mali', 'ML');
INSERT INTO `et_country` VALUES (137, 'Malta', 'MT');
INSERT INTO `et_country` VALUES (138, 'Marshall Islands', 'MH');
INSERT INTO `et_country` VALUES (139, 'Martinique', 'MQ');
INSERT INTO `et_country` VALUES (140, 'Mauritania', 'MR');
INSERT INTO `et_country` VALUES (141, 'Mauritius', 'MU');
INSERT INTO `et_country` VALUES (142, 'Mayotte', 'YT');
INSERT INTO `et_country` VALUES (143, 'Mexico', 'MX');
INSERT INTO `et_country` VALUES (144, 'Micronesia', 'FM');
INSERT INTO `et_country` VALUES (145, 'Moldova', 'MD');
INSERT INTO `et_country` VALUES (146, 'Monaco', 'MC');
INSERT INTO `et_country` VALUES (147, 'Mongolia', 'MN');
INSERT INTO `et_country` VALUES (148, 'Montserrat', 'MS');
INSERT INTO `et_country` VALUES (149, 'Morocco', 'MA');
INSERT INTO `et_country` VALUES (150, 'Mozambique', 'MZ');
INSERT INTO `et_country` VALUES (151, 'Myanmar', 'MM');
INSERT INTO `et_country` VALUES (152, 'Namibia', 'NA');
INSERT INTO `et_country` VALUES (153, 'Nauru', 'NR');
INSERT INTO `et_country` VALUES (154, 'Nepal', 'NP');
INSERT INTO `et_country` VALUES (155, 'Netherlands', 'NL');
INSERT INTO `et_country` VALUES (156, 'Netherlands Antilles', 'AN');
INSERT INTO `et_country` VALUES (157, 'New Caledonia', 'NC');
INSERT INTO `et_country` VALUES (158, 'New Zealand', 'NZ');
INSERT INTO `et_country` VALUES (159, 'Nicaragua', 'NI');
INSERT INTO `et_country` VALUES (160, 'Niger', 'NE');
INSERT INTO `et_country` VALUES (161, 'Nigeria', 'NG');
INSERT INTO `et_country` VALUES (162, 'Niue', 'NU');
INSERT INTO `et_country` VALUES (163, 'Norfolk Island', 'NF');
INSERT INTO `et_country` VALUES (164, 'Northern Mariana Islands', 'MP');
INSERT INTO `et_country` VALUES (165, 'Norway', 'NO');
INSERT INTO `et_country` VALUES (166, 'Oman', 'OM');
INSERT INTO `et_country` VALUES (167, 'Pakistan', 'PK');
INSERT INTO `et_country` VALUES (168, 'Palau', 'PW');
INSERT INTO `et_country` VALUES (169, 'Palestinian Territory, Occupied', 'PS');
INSERT INTO `et_country` VALUES (170, 'Panama', 'PA');
INSERT INTO `et_country` VALUES (171, 'Papua New Guinea', 'PG');
INSERT INTO `et_country` VALUES (172, 'Paraguay', 'PY');
INSERT INTO `et_country` VALUES (173, 'Peru', 'PE');
INSERT INTO `et_country` VALUES (174, 'Philippines', 'PH');
INSERT INTO `et_country` VALUES (175, 'Pitcairn', 'PN');
INSERT INTO `et_country` VALUES (176, 'Poland', 'PL');
INSERT INTO `et_country` VALUES (177, 'Portugal', 'PT');
INSERT INTO `et_country` VALUES (178, 'Puerto Rico', 'PR');
INSERT INTO `et_country` VALUES (179, 'Qatar', 'QA');
INSERT INTO `et_country` VALUES (180, 'Reunion', 'RE');
INSERT INTO `et_country` VALUES (181, 'Romania', 'RO');
INSERT INTO `et_country` VALUES (182, 'Russian Federation', 'RU');
INSERT INTO `et_country` VALUES (183, 'Rwanda', 'RW');
INSERT INTO `et_country` VALUES (184, 'Saint Helena', 'SH');
INSERT INTO `et_country` VALUES (185, 'Saint Kitts and Nevis', 'KN');
INSERT INTO `et_country` VALUES (186, 'Saint Lucia', 'LC');
INSERT INTO `et_country` VALUES (187, 'Saint Pierre and Miquelon', 'PM');
INSERT INTO `et_country` VALUES (188, 'Saint Vincent and the Grenadines', 'VC');
INSERT INTO `et_country` VALUES (189, 'Samoa', 'WS');
INSERT INTO `et_country` VALUES (190, 'San Marino', 'SM');
INSERT INTO `et_country` VALUES (191, 'Sao Tome and Principe', 'ST');
INSERT INTO `et_country` VALUES (192, 'Saudi Arabia', 'SA');
INSERT INTO `et_country` VALUES (193, 'Senegal', 'SN');
INSERT INTO `et_country` VALUES (194, 'Serbia', 'RS');
INSERT INTO `et_country` VALUES (195, 'Montenegro', 'ME');
INSERT INTO `et_country` VALUES (196, 'Seychelles', 'SC');
INSERT INTO `et_country` VALUES (197, 'Sierra Leone', 'SL');
INSERT INTO `et_country` VALUES (198, 'Singapore', 'SG');
INSERT INTO `et_country` VALUES (199, 'Slovakia', 'SK');
INSERT INTO `et_country` VALUES (200, 'Slovenia', 'SI');
INSERT INTO `et_country` VALUES (201, 'Solomon Islands', 'SB');
INSERT INTO `et_country` VALUES (202, 'Somalia', 'SO');
INSERT INTO `et_country` VALUES (203, 'South Africa', 'ZA');
INSERT INTO `et_country` VALUES (204, 'South Georgia and the South Sandwich Islands', 'GS');
INSERT INTO `et_country` VALUES (205, 'Spain', 'ES');
INSERT INTO `et_country` VALUES (206, 'Sri Lanka', 'LK');
INSERT INTO `et_country` VALUES (207, 'Sudan', 'SD');
INSERT INTO `et_country` VALUES (208, 'Suriname', 'SR');
INSERT INTO `et_country` VALUES (209, 'Svalbard and Jan Mayen', 'SJ');
INSERT INTO `et_country` VALUES (210, 'Swaziland', 'SZ');
INSERT INTO `et_country` VALUES (211, 'Sweden', 'SE');
INSERT INTO `et_country` VALUES (212, 'Switzerland', 'CH');
INSERT INTO `et_country` VALUES (213, 'Syrian Arab Republic', 'SY');
INSERT INTO `et_country` VALUES (214, 'Taiwan, Province of China', 'TW');
INSERT INTO `et_country` VALUES (215, 'Tajikistan', 'TJ');
INSERT INTO `et_country` VALUES (216, 'Tanzania', 'TZ');
INSERT INTO `et_country` VALUES (217, 'Thailand', 'TH');
INSERT INTO `et_country` VALUES (218, 'Timor-Leste', 'TL');
INSERT INTO `et_country` VALUES (219, 'Togo', 'TG');
INSERT INTO `et_country` VALUES (220, 'Tokelau', 'TK');
INSERT INTO `et_country` VALUES (221, 'Tonga', 'TO');
INSERT INTO `et_country` VALUES (222, 'Trinidad and Tobago', 'TT');
INSERT INTO `et_country` VALUES (223, 'Tunisia', 'TN');
INSERT INTO `et_country` VALUES (224, 'Turkey', 'TR');
INSERT INTO `et_country` VALUES (225, 'Turkmenistan', 'TM');
INSERT INTO `et_country` VALUES (226, 'Turks and Caicos Islands', 'TC');
INSERT INTO `et_country` VALUES (227, 'Tuvalu', 'TV');
INSERT INTO `et_country` VALUES (228, 'Uganda', 'UG');
INSERT INTO `et_country` VALUES (229, 'Ukraine', 'UA');
INSERT INTO `et_country` VALUES (230, 'United Arab Emirates', 'AE');
INSERT INTO `et_country` VALUES (231, 'United Kingdom', 'GB');
INSERT INTO `et_country` VALUES (232, 'United States', 'US');
INSERT INTO `et_country` VALUES (233, 'United States Minor Outlying Islands', 'UM');
INSERT INTO `et_country` VALUES (234, 'Uruguay', 'UY');
INSERT INTO `et_country` VALUES (235, 'Uzbekistan', 'UZ');
INSERT INTO `et_country` VALUES (236, 'Vanuatu', 'VU');
INSERT INTO `et_country` VALUES (237, 'Venezuela', 'VE');
INSERT INTO `et_country` VALUES (238, 'Viet Nam', 'VN');
INSERT INTO `et_country` VALUES (239, 'Virgin Islands, British', 'VG');
INSERT INTO `et_country` VALUES (240, 'Virgin Islands, U.S.', 'VI');
INSERT INTO `et_country` VALUES (241, 'Wallis and Futuna', 'WF');
INSERT INTO `et_country` VALUES (242, 'Western Sahara', 'EH');
INSERT INTO `et_country` VALUES (243, 'Yemen', 'YE');
INSERT INTO `et_country` VALUES (244, 'Zambia', 'ZM');
INSERT INTO `et_country` VALUES (245, 'Zimbabwe', 'ZW');

-- ----------------------------
-- Table structure for et_log_bonus_qualification_level
-- ----------------------------
DROP TABLE IF EXISTS `et_log_bonus_qualification_level`;
CREATE TABLE `et_log_bonus_qualification_level`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `id_downline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `type_package` enum('trade manager','crypto asset') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'trade manager | crypto asset',
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `package_amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `state` enum('get bonus','correction bonus') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'get bonus | correction bonus',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_bonus_qualification_level
-- ----------------------------

-- ----------------------------
-- Table structure for et_log_bonus_recruitment
-- ----------------------------
DROP TABLE IF EXISTS `et_log_bonus_recruitment`;
CREATE TABLE `et_log_bonus_recruitment`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `id_downline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `type_package` enum('trade manager','crypto asset') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'trade manager | crypto asset',
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `package_amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `state` enum('get bonus','correction bonus') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'get bonus | correction bonus',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_bonus_recruitment
-- ----------------------------

-- ----------------------------
-- Table structure for et_log_bonus_royalty
-- ----------------------------
DROP TABLE IF EXISTS `et_log_bonus_royalty`;
CREATE TABLE `et_log_bonus_royalty`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `id_downline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `type_package` enum('trade manager','crypto asset') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'trade manager | crypto asset',
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `package_amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `state` enum('get bonus','correction bonus') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'get bonus | correction bonus',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_bonus_royalty
-- ----------------------------

-- ----------------------------
-- Table structure for et_log_ipn_trade_manager
-- ----------------------------
DROP TABLE IF EXISTS `et_log_ipn_trade_manager`;
CREATE TABLE `et_log_ipn_trade_manager`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `ipn_version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ipn_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ipn_mode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ipn_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `merchant` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` int NULL DEFAULT NULL,
  `status_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `txn_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `currency1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `currency2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount1` decimal(15, 8) NULL DEFAULT NULL,
  `amount2` decimal(15, 8) NULL DEFAULT NULL,
  `fee` decimal(15, 8) NULL DEFAULT NULL,
  `buyer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `item_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `received_amount` decimal(15, 8) NULL DEFAULT NULL,
  `received_confirms` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_ipn_trade_manager
-- ----------------------------

-- ----------------------------
-- Table structure for et_log_member_trade_manager
-- ----------------------------
DROP TABLE IF EXISTS `et_log_member_trade_manager`;
CREATE TABLE `et_log_member_trade_manager`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'no invoice',
  `amount_invest` int NULL DEFAULT NULL,
  `amount_transfer` decimal(15, 8) NULL DEFAULT NULL,
  `currency_transfer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `txn_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `state` enum('waiting payment','pending','active','inactive','cancel','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_member_trade_manager
-- ----------------------------
INSERT INTO `et_log_member_trade_manager` VALUES ('925c363e-e634-11eb-abed-ea7075f67258', '1294a713-e596-11eb-abed-ea7075f67258', 'INV-20210716-000001', 1, 0.00822000, 'LTCT', 'CPFG6XWA7EUI2I9WSY5KDTEJ1B', 'waiting payment', '[2021-07-16 19:51:35] Member adam.pm77@gmail.com Pick Package Starter Pack. Waiting for Payment Transfer', '2021-07-16 19:51:35', NULL);
INSERT INTO `et_log_member_trade_manager` VALUES ('bbe94059-e63c-11eb-abed-ea7075f67258', '1294a713-e596-11eb-abed-ea7075f67258', 'INV-20210716-000002', 2, 6.10000000, 'USDT.ERC20', 'CPFG2IMYQFU11XOPCZYYI7QVAJ', 'waiting payment', '[2021-07-16 20:49:57] Member adam.pm77@gmail.com Pick Package Sapphire Pack. Waiting for Payment Transfer', '2021-07-16 20:49:57', NULL);

-- ----------------------------
-- Table structure for et_log_profit_crypto_asset
-- ----------------------------
DROP TABLE IF EXISTS `et_log_profit_crypto_asset`;
CREATE TABLE `et_log_profit_crypto_asset`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `id_downline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `type_package` enum('trade manager','crypto asset') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'trade manager | crypto asset',
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `package_amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `state` enum('get bonus','correction bonus') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'get bonus | correction bonus',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_profit_crypto_asset
-- ----------------------------

-- ----------------------------
-- Table structure for et_log_profit_trade_manager
-- ----------------------------
DROP TABLE IF EXISTS `et_log_profit_trade_manager`;
CREATE TABLE `et_log_profit_trade_manager`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `profit` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `state` enum('get bonus','correction bonus') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'get bonus | correction bonus',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_profit_trade_manager
-- ----------------------------

-- ----------------------------
-- Table structure for et_log_send_email_admin
-- ----------------------------
DROP TABLE IF EXISTS `et_log_send_email_admin`;
CREATE TABLE `et_log_send_email_admin`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `mail_to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mail_subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mail_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `is_success` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_send_email_admin
-- ----------------------------
INSERT INTO `et_log_send_email_admin` VALUES (1, 'adam.pm77@gmail.com', 'EDI TRADE | OTP (One Time Password)', '<!DOCTYPE html>\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n\n<head>\n	<meta charset=\"utf-8\"> <!-- utf-8 works for most cases -->\n	<meta name=\"viewport\" content=\"width=device-width\"> <!-- Forcing initial-scale shouldn\'t be necessary -->\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <!-- Use the latest (edge) version of IE rendering engine -->\n	<meta name=\"x-apple-disable-message-reformatting\"> <!-- Disable auto-scale in iOS 10 Mail entirely -->\n	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->\n\n	<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700\" rel=\"stylesheet\">\n\n	<!-- CSS Reset : BEGIN -->\n	<style>\n		/* What it does: Remove spaces around the email design added by some email clients. */\n		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */\n		html,\n		body {\n			margin: 0 auto !important;\n			padding: 0 !important;\n			height: 100% !important;\n			width: 100% !important;\n			background: #f1f1f1;\n		}\n\n		/* What it does: Stops email clients resizing small text. */\n		* {\n			-ms-text-size-adjust: 100%;\n			-webkit-text-size-adjust: 100%;\n		}\n\n		/* What it does: Centers email on Android 4.4 */\n		div[style*=\"margin: 16px 0\"] {\n			margin: 0 !important;\n		}\n\n		/* What it does: Stops Outlook from adding extra spacing to tables. */\n		table,\n		td {\n			mso-table-lspace: 0pt !important;\n			mso-table-rspace: 0pt !important;\n		}\n\n		/* What it does: Fixes webkit padding issue. */\n		table {\n			border-spacing: 0 !important;\n			border-collapse: collapse !important;\n			table-layout: fixed !important;\n			margin: 0 auto !important;\n		}\n\n		/* What it does: Uses a better rendering method when resizing images in IE. */\n		img {\n			-ms-interpolation-mode: bicubic;\n		}\n\n		/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */\n		a {\n			text-decoration: none;\n		}\n\n		/* What it does: A work-around for email clients meddling in triggered links. */\n		*[x-apple-data-detectors],\n		/* iOS */\n		.unstyle-auto-detected-links *,\n		.aBn {\n			border-bottom: 0 !important;\n			cursor: default !important;\n			color: inherit !important;\n			text-decoration: none !important;\n			font-size: inherit !important;\n			font-family: inherit !important;\n			font-weight: inherit !important;\n			line-height: inherit !important;\n		}\n\n		/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */\n		.a6S {\n			display: none !important;\n			opacity: 0.01 !important;\n		}\n\n		/* What it does: Prevents Gmail from changing the text color in conversation threads. */\n		.im {\n			color: inherit !important;\n		}\n\n		/* If the above doesn\'t work, add a .g-img class to any image in question. */\n		img.g-img+div {\n			display: none !important;\n		}\n\n		/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */\n		/* Create one of these media queries for each additional viewport size you\'d like to fix */\n\n		/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */\n		@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {\n			u~div .email-container {\n				min-width: 320px !important;\n			}\n		}\n\n		/* iPhone 6, 6S, 7, 8, and X */\n		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n			u~div .email-container {\n				min-width: 375px !important;\n			}\n		}\n\n		/* iPhone 6+, 7+, and 8+ */\n		@media only screen and (min-device-width: 414px) {\n			u~div .email-container {\n				min-width: 414px !important;\n			}\n		}\n	</style>\n\n	<!-- CSS Reset : END -->\n\n	<!-- Progressive Enhancements : BEGIN -->\n	<style>\n		.primary {\n			background: #30e3ca;\n		}\n\n		.bg_white {\n			background: #ffffff;\n		}\n\n		.bg_light {\n			background: #fafafa;\n		}\n\n		.bg_black {\n			background: #000000;\n		}\n\n		.bg_dark {\n			background: rgba(0, 0, 0, .8);\n		}\n\n		.email-section {\n			padding: 2.5em;\n		}\n\n		/*BUTTON*/\n		.btn {\n			padding: 10px 15px;\n			display: inline-block;\n		}\n\n		.btn.btn-primary {\n			border-radius: 5px;\n			background: #30e3ca;\n			color: #ffffff;\n		}\n\n		.btn.btn-white {\n			border-radius: 5px;\n			background: #ffffff;\n			color: #000000;\n		}\n\n		.btn.btn-white-outline {\n			border-radius: 5px;\n			background: transparent;\n			border: 1px solid #fff;\n			color: #fff;\n		}\n\n		.btn.btn-black-outline {\n			border-radius: 0px;\n			background: transparent;\n			border: 2px solid #000;\n			color: #000;\n			font-weight: 700;\n		}\n\n		h1,\n		h2,\n		h3,\n		h4,\n		h5,\n		h6 {\n			font-family: \'Lato\', sans-serif;\n			color: #000000;\n			margin-top: 0;\n			font-weight: 400;\n		}\n\n		body {\n			font-family: \'Lato\', sans-serif;\n			font-weight: 400;\n			font-size: 15px;\n			line-height: 1.8;\n			color: rgba(0, 0, 0, .4);\n		}\n\n		a {\n			color: #30e3ca;\n		}\n\n		table {}\n\n		/*LOGO*/\n\n		.logo h1 {\n			margin: 0;\n		}\n\n		.logo h1 a {\n			color: #30e3ca;\n			font-size: 24px;\n			font-weight: 700;\n			font-family: \'Lato\', sans-serif;\n		}\n\n		/*HERO*/\n		.hero {\n			position: relative;\n			z-index: 0;\n		}\n\n		.hero .text {\n			color: rgba(0, 0, 0, .3);\n		}\n\n		.hero .text h2 {\n			color: #000;\n			font-size: 40px;\n			margin-bottom: 0;\n			font-weight: 400;\n			line-height: 1.4;\n		}\n\n		.hero .text h3 {\n			font-size: 24px;\n			font-weight: 300;\n		}\n\n		.hero .text h2 span {\n			font-weight: 600;\n			color: #30e3ca;\n		}\n\n\n		/*HEADING SECTION*/\n		.heading-section {}\n\n		.heading-section h2 {\n			color: #000000;\n			font-size: 28px;\n			margin-top: 0;\n			line-height: 1.4;\n			font-weight: 400;\n		}\n\n		.heading-section .subheading {\n			margin-bottom: 20px !important;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(0, 0, 0, .4);\n			position: relative;\n		}\n\n		.heading-section .subheading::after {\n			position: absolute;\n			left: 0;\n			right: 0;\n			bottom: -10px;\n			content: \'\';\n			width: 100%;\n			height: 2px;\n			background: #30e3ca;\n			margin: 0 auto;\n		}\n\n		.heading-section-white {\n			color: rgba(255, 255, 255, .8);\n		}\n\n		.heading-section-white h2 {\n			font-family: Lato;\n			line-height: 1;\n			padding-bottom: 0;\n		}\n\n		.heading-section-white h2 {\n			color: #ffffff;\n		}\n\n		.heading-section-white .subheading {\n			margin-bottom: 0;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(255, 255, 255, .4);\n		}\n\n\n		ul.social {\n			padding: 0;\n		}\n\n		ul.social li {\n			display: inline-block;\n			margin-right: 10px;\n		}\n\n		/*FOOTER*/\n\n		.footer {\n			border-top: 1px solid rgba(0, 0, 0, .05);\n			color: rgba(0, 0, 0, .5);\n		}\n\n		.footer .heading {\n			color: #000;\n			font-size: 20px;\n		}\n\n		.footer ul {\n			margin: 0;\n			padding: 0;\n		}\n\n		.footer ul li {\n			list-style: none;\n			margin-bottom: 10px;\n		}\n\n		.footer ul li a {\n			color: rgba(0, 0, 0, 1);\n		}\n\n\n		@media screen and (max-width: 500px) {}\n	</style>\n\n\n</head>\n\n<body width=\"100%\" style=\"margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;\">\n	<center style=\"width: 100%; background-color: #f1f1f1;\">\n		<div style=\"display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;\">\n			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n		</div>\n		<div style=\"max-width: 600px; margin: 0 auto;\" class=\"email-container\">\n			<!-- BEGIN BODY -->\n			<table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">\n				<tr>\n					<td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">\n						<table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tr>\n								<td class=\"logo\" style=\"text-align: center;\">\n									<h1>\n										<a href=\"http://localhost/admin.editrade.com/\">\n											<img src=\"http://localhost/admin.editrade.com/public/img/logo.png\" alt=\"EDITRADE LOGO\">\n										</a>\n									</h1>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 3em 0 2em 0;\">\n						<img src=\"http://localhost/admin.editrade.com/public/img/otp.png\" alt=\"Logo OTP\" style=\"width: 300px; max-width: 600px; height: auto; margin: auto; display: block;\">\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 2em 0 4em 0;\">\n						<table>\n							<tr>\n								<td>\n									<div class=\"text\" style=\"padding: 0 2.5em; text-align: center;\">\n										<h3>Please verify your One Time Password (OTP)</h3>\n										<h2><kbd>407274</kbd></h2>\n										<h3>Never Share this OTP to anyone</h3>\n									</div>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<!-- 1 Column Text + Button : END -->\n			</table>\n\n		</div>\n	</center>\n</body>\n\n</html>\n', 'yes', NULL, NULL);
INSERT INTO `et_log_send_email_admin` VALUES (2, 'adam.pm77@gmail.com', 'EDI TRADE | Account Activation', '<!DOCTYPE html>\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n\n<head>\n	<meta charset=\"utf-8\"> <!-- utf-8 works for most cases -->\n	<meta name=\"viewport\" content=\"width=device-width\"> <!-- Forcing initial-scale shouldn\'t be necessary -->\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <!-- Use the latest (edge) version of IE rendering engine -->\n	<meta name=\"x-apple-disable-message-reformatting\"> <!-- Disable auto-scale in iOS 10 Mail entirely -->\n	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->\n\n	<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700\" rel=\"stylesheet\">\n\n	<!-- CSS Reset : BEGIN -->\n	<style>\n		/* What it does: Remove spaces around the email design added by some email clients. */\n		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */\n		html,\n		body {\n			margin: 0 auto !important;\n			padding: 0 !important;\n			height: 100% !important;\n			width: 100% !important;\n			background: #f1f1f1;\n		}\n\n		/* What it does: Stops email clients resizing small text. */\n		* {\n			-ms-text-size-adjust: 100%;\n			-webkit-text-size-adjust: 100%;\n		}\n\n		/* What it does: Centers email on Android 4.4 */\n		div[style*=\"margin: 16px 0\"] {\n			margin: 0 !important;\n		}\n\n		/* What it does: Stops Outlook from adding extra spacing to tables. */\n		table,\n		td {\n			mso-table-lspace: 0pt !important;\n			mso-table-rspace: 0pt !important;\n		}\n\n		/* What it does: Fixes webkit padding issue. */\n		table {\n			border-spacing: 0 !important;\n			border-collapse: collapse !important;\n			table-layout: fixed !important;\n			margin: 0 auto !important;\n		}\n\n		/* What it does: Uses a better rendering method when resizing images in IE. */\n		img {\n			-ms-interpolation-mode: bicubic;\n		}\n\n		/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */\n		a {\n			text-decoration: none;\n		}\n\n		/* What it does: A work-around for email clients meddling in triggered links. */\n		*[x-apple-data-detectors],\n		/* iOS */\n		.unstyle-auto-detected-links *,\n		.aBn {\n			border-bottom: 0 !important;\n			cursor: default !important;\n			color: inherit !important;\n			text-decoration: none !important;\n			font-size: inherit !important;\n			font-family: inherit !important;\n			font-weight: inherit !important;\n			line-height: inherit !important;\n		}\n\n		/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */\n		.a6S {\n			display: none !important;\n			opacity: 0.01 !important;\n		}\n\n		/* What it does: Prevents Gmail from changing the text color in conversation threads. */\n		.im {\n			color: inherit !important;\n		}\n\n		/* If the above doesn\'t work, add a .g-img class to any image in question. */\n		img.g-img+div {\n			display: none !important;\n		}\n\n		/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */\n		/* Create one of these media queries for each additional viewport size you\'d like to fix */\n\n		/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */\n		@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {\n			u~div .email-container {\n				min-width: 320px !important;\n			}\n		}\n\n		/* iPhone 6, 6S, 7, 8, and X */\n		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n			u~div .email-container {\n				min-width: 375px !important;\n			}\n		}\n\n		/* iPhone 6+, 7+, and 8+ */\n		@media only screen and (min-device-width: 414px) {\n			u~div .email-container {\n				min-width: 414px !important;\n			}\n		}\n	</style>\n\n	<!-- CSS Reset : END -->\n\n	<!-- Progressive Enhancements : BEGIN -->\n	<style>\n		.primary {\n			background: #30e3ca;\n		}\n\n		.bg_white {\n			background: #ffffff;\n		}\n\n		.bg_light {\n			background: #fafafa;\n		}\n\n		.bg_black {\n			background: #000000;\n		}\n\n		.bg_dark {\n			background: rgba(0, 0, 0, .8);\n		}\n\n		.email-section {\n			padding: 2.5em;\n		}\n\n		/*BUTTON*/\n		.btn {\n			padding: 10px 15px;\n			display: inline-block;\n		}\n\n		.btn.btn-primary {\n			border-radius: 5px;\n			background: #30e3ca;\n			color: #ffffff;\n		}\n\n		.btn.btn-white {\n			border-radius: 5px;\n			background: #ffffff;\n			color: #000000;\n		}\n\n		.btn.btn-white-outline {\n			border-radius: 5px;\n			background: transparent;\n			border: 1px solid #fff;\n			color: #fff;\n		}\n\n		.btn.btn-black-outline {\n			border-radius: 0px;\n			background: transparent;\n			border: 2px solid #000;\n			color: #000;\n			font-weight: 700;\n		}\n\n		h1,\n		h2,\n		h3,\n		h4,\n		h5,\n		h6 {\n			font-family: \'Lato\', sans-serif;\n			color: #000000;\n			margin-top: 0;\n			font-weight: 400;\n		}\n\n		body {\n			font-family: \'Lato\', sans-serif;\n			font-weight: 400;\n			font-size: 15px;\n			line-height: 1.8;\n			color: rgba(0, 0, 0, .4);\n		}\n\n		a {\n			color: #30e3ca;\n		}\n\n		table {}\n\n		/*LOGO*/\n\n		.logo h1 {\n			margin: 0;\n		}\n\n		.logo h1 a {\n			color: #30e3ca;\n			font-size: 24px;\n			font-weight: 700;\n			font-family: \'Lato\', sans-serif;\n		}\n\n		/*HERO*/\n		.hero {\n			position: relative;\n			z-index: 0;\n		}\n\n		.hero .text {\n			color: rgba(0, 0, 0, .3);\n		}\n\n		.hero .text h2 {\n			color: #000;\n			font-size: 40px;\n			margin-bottom: 0;\n			font-weight: 400;\n			line-height: 1.4;\n		}\n\n		.hero .text h3 {\n			font-size: 24px;\n			font-weight: 300;\n		}\n\n		.hero .text h2 span {\n			font-weight: 600;\n			color: #30e3ca;\n		}\n\n\n		/*HEADING SECTION*/\n		.heading-section {}\n\n		.heading-section h2 {\n			color: #000000;\n			font-size: 28px;\n			margin-top: 0;\n			line-height: 1.4;\n			font-weight: 400;\n		}\n\n		.heading-section .subheading {\n			margin-bottom: 20px !important;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(0, 0, 0, .4);\n			position: relative;\n		}\n\n		.heading-section .subheading::after {\n			position: absolute;\n			left: 0;\n			right: 0;\n			bottom: -10px;\n			content: \'\';\n			width: 100%;\n			height: 2px;\n			background: #30e3ca;\n			margin: 0 auto;\n		}\n\n		.heading-section-white {\n			color: rgba(255, 255, 255, .8);\n		}\n\n		.heading-section-white h2 {\n			font-family: Lato;\n			line-height: 1;\n			padding-bottom: 0;\n		}\n\n		.heading-section-white h2 {\n			color: #ffffff;\n		}\n\n		.heading-section-white .subheading {\n			margin-bottom: 0;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(255, 255, 255, .4);\n		}\n\n\n		ul.social {\n			padding: 0;\n		}\n\n		ul.social li {\n			display: inline-block;\n			margin-right: 10px;\n		}\n\n		/*FOOTER*/\n\n		.footer {\n			border-top: 1px solid rgba(0, 0, 0, .05);\n			color: rgba(0, 0, 0, .5);\n		}\n\n		.footer .heading {\n			color: #000;\n			font-size: 20px;\n		}\n\n		.footer ul {\n			margin: 0;\n			padding: 0;\n		}\n\n		.footer ul li {\n			list-style: none;\n			margin-bottom: 10px;\n		}\n\n		.footer ul li a {\n			color: rgba(0, 0, 0, 1);\n		}\n\n\n		@media screen and (max-width: 500px) {}\n	</style>\n\n\n</head>\n\n<body width=\"100%\" style=\"margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;\">\n	<center style=\"width: 100%; background-color: #f1f1f1;\">\n		<div style=\"display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;\">\n			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n		</div>\n		<div style=\"max-width: 600px; margin: 0 auto;\" class=\"email-container\">\n			<!-- BEGIN BODY -->\n			<table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">\n				<tr>\n					<td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">\n						<table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tr>\n								<td class=\"logo\" style=\"text-align: center;\">\n									<h1>\n										<a href=\"http://localhost/admin.editrade.com/\">\n											<img src=\"http://localhost/admin.editrade.com/public/img/logo.png\" alt=\"EDITRADE LOGO\">\n										</a>\n									</h1>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 3em 0 2em 0;\">\n						<img src=\"http://localhost/admin.editrade.com/public/img/undraw_Checklist__re_2w7v.svg\" alt=\"Logo Activation\" style=\"width: 300px; max-width: 600px; height: auto; margin: auto; display: block;\">\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 2em 0 4em 0;\">\n						<table>\n							<tr>\n								<td>\n									<div class=\"text\" style=\"padding: 0 2.5em; text-align: center;\">\n										<h3>Activate Your Account</h3>\n										<h4><mark><a href=\"http://localhost/editrade.com/activate/adam.pm77%40gmail.com/5b5805c797a6fb090a43929590476897d1fe0209\">http://localhost/editrade.com/activate/adam.pm77%40gmail.com/5b5805c797a6fb090a43929590476897d1fe0209</a></mark></h4>\n									</div>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<!-- 1 Column Text + Button : END -->\n			</table>\n\n		</div>\n	</center>\n</body>\n\n</html>\n', 'yes', NULL, NULL);

-- ----------------------------
-- Table structure for et_log_send_email_member
-- ----------------------------
DROP TABLE IF EXISTS `et_log_send_email_member`;
CREATE TABLE `et_log_send_email_member`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `mail_to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mail_subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mail_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `is_success` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_send_email_member
-- ----------------------------
INSERT INTO `et_log_send_email_member` VALUES (1, 'adam.pm77@gmail.com', 'CryptoProperty | OTP (One Time Password)', '<!DOCTYPE html>\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n\n<head>\n	<meta charset=\"utf-8\"> <!-- utf-8 works for most cases -->\n	<meta name=\"viewport\" content=\"width=device-width\"> <!-- Forcing initial-scale shouldn\'t be necessary -->\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <!-- Use the latest (edge) version of IE rendering engine -->\n	<meta name=\"x-apple-disable-message-reformatting\"> <!-- Disable auto-scale in iOS 10 Mail entirely -->\n	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->\n\n	<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700\" rel=\"stylesheet\">\n\n	<!-- CSS Reset : BEGIN -->\n	<style>\n		/* What it does: Remove spaces around the email design added by some email clients. */\n		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */\n		html,\n		body {\n			margin: 0 auto !important;\n			padding: 0 !important;\n			height: 100% !important;\n			width: 100% !important;\n			background: #f1f1f1;\n		}\n\n		/* What it does: Stops email clients resizing small text. */\n		* {\n			-ms-text-size-adjust: 100%;\n			-webkit-text-size-adjust: 100%;\n		}\n\n		/* What it does: Centers email on Android 4.4 */\n		div[style*=\"margin: 16px 0\"] {\n			margin: 0 !important;\n		}\n\n		/* What it does: Stops Outlook from adding extra spacing to tables. */\n		table,\n		td {\n			mso-table-lspace: 0pt !important;\n			mso-table-rspace: 0pt !important;\n		}\n\n		/* What it does: Fixes webkit padding issue. */\n		table {\n			border-spacing: 0 !important;\n			border-collapse: collapse !important;\n			table-layout: fixed !important;\n			margin: 0 auto !important;\n		}\n\n		/* What it does: Uses a better rendering method when resizing images in IE. */\n		img {\n			-ms-interpolation-mode: bicubic;\n		}\n\n		/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */\n		a {\n			text-decoration: none;\n		}\n\n		/* What it does: A work-around for email clients meddling in triggered links. */\n		*[x-apple-data-detectors],\n		/* iOS */\n		.unstyle-auto-detected-links *,\n		.aBn {\n			border-bottom: 0 !important;\n			cursor: default !important;\n			color: inherit !important;\n			text-decoration: none !important;\n			font-size: inherit !important;\n			font-family: inherit !important;\n			font-weight: inherit !important;\n			line-height: inherit !important;\n		}\n\n		/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */\n		.a6S {\n			display: none !important;\n			opacity: 0.01 !important;\n		}\n\n		/* What it does: Prevents Gmail from changing the text color in conversation threads. */\n		.im {\n			color: inherit !important;\n		}\n\n		/* If the above doesn\'t work, add a .g-img class to any image in question. */\n		img.g-img+div {\n			display: none !important;\n		}\n\n		/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */\n		/* Create one of these media queries for each additional viewport size you\'d like to fix */\n\n		/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */\n		@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {\n			u~div .email-container {\n				min-width: 320px !important;\n			}\n		}\n\n		/* iPhone 6, 6S, 7, 8, and X */\n		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n			u~div .email-container {\n				min-width: 375px !important;\n			}\n		}\n\n		/* iPhone 6+, 7+, and 8+ */\n		@media only screen and (min-device-width: 414px) {\n			u~div .email-container {\n				min-width: 414px !important;\n			}\n		}\n	</style>\n\n	<!-- CSS Reset : END -->\n\n	<!-- Progressive Enhancements : BEGIN -->\n	<style>\n		.primary {\n			background: #30e3ca;\n		}\n\n		.bg_white {\n			background: #ffffff;\n		}\n\n		.bg_light {\n			background: #fafafa;\n		}\n\n		.bg_black {\n			background: #000000;\n		}\n\n		.bg_dark {\n			background: rgba(0, 0, 0, .8);\n		}\n\n		.email-section {\n			padding: 2.5em;\n		}\n\n		/*BUTTON*/\n		.btn {\n			padding: 10px 15px;\n			display: inline-block;\n		}\n\n		.btn.btn-primary {\n			border-radius: 5px;\n			background: #30e3ca;\n			color: #ffffff;\n		}\n\n		.btn.btn-white {\n			border-radius: 5px;\n			background: #ffffff;\n			color: #000000;\n		}\n\n		.btn.btn-white-outline {\n			border-radius: 5px;\n			background: transparent;\n			border: 1px solid #fff;\n			color: #fff;\n		}\n\n		.btn.btn-black-outline {\n			border-radius: 0px;\n			background: transparent;\n			border: 2px solid #000;\n			color: #000;\n			font-weight: 700;\n		}\n\n		h1,\n		h2,\n		h3,\n		h4,\n		h5,\n		h6 {\n			font-family: \'Lato\', sans-serif;\n			color: #000000;\n			margin-top: 0;\n			font-weight: 400;\n		}\n\n		body {\n			font-family: \'Lato\', sans-serif;\n			font-weight: 400;\n			font-size: 15px;\n			line-height: 1.8;\n			color: rgba(0, 0, 0, .4);\n		}\n\n		a {\n			color: #30e3ca;\n		}\n\n		table {}\n\n		/*LOGO*/\n\n		.logo h1 {\n			margin: 0;\n		}\n\n		.logo h1 a {\n			color: #30e3ca;\n			font-size: 24px;\n			font-weight: 700;\n			font-family: \'Lato\', sans-serif;\n		}\n\n		/*HERO*/\n		.hero {\n			position: relative;\n			z-index: 0;\n		}\n\n		.hero .text {\n			color: rgba(0, 0, 0, .3);\n		}\n\n		.hero .text h2 {\n			color: #000;\n			font-size: 40px;\n			margin-bottom: 0;\n			font-weight: 400;\n			line-height: 1.4;\n		}\n\n		.hero .text h3 {\n			font-size: 24px;\n			font-weight: 300;\n		}\n\n		.hero .text h2 span {\n			font-weight: 600;\n			color: #30e3ca;\n		}\n\n\n		/*HEADING SECTION*/\n		.heading-section {}\n\n		.heading-section h2 {\n			color: #000000;\n			font-size: 28px;\n			margin-top: 0;\n			line-height: 1.4;\n			font-weight: 400;\n		}\n\n		.heading-section .subheading {\n			margin-bottom: 20px !important;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(0, 0, 0, .4);\n			position: relative;\n		}\n\n		.heading-section .subheading::after {\n			position: absolute;\n			left: 0;\n			right: 0;\n			bottom: -10px;\n			content: \'\';\n			width: 100%;\n			height: 2px;\n			background: #30e3ca;\n			margin: 0 auto;\n		}\n\n		.heading-section-white {\n			color: rgba(255, 255, 255, .8);\n		}\n\n		.heading-section-white h2 {\n			font-family: Lato;\n			line-height: 1;\n			padding-bottom: 0;\n		}\n\n		.heading-section-white h2 {\n			color: #ffffff;\n		}\n\n		.heading-section-white .subheading {\n			margin-bottom: 0;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(255, 255, 255, .4);\n		}\n\n\n		ul.social {\n			padding: 0;\n		}\n\n		ul.social li {\n			display: inline-block;\n			margin-right: 10px;\n		}\n\n		/*FOOTER*/\n\n		.footer {\n			border-top: 1px solid rgba(0, 0, 0, .05);\n			color: rgba(0, 0, 0, .5);\n		}\n\n		.footer .heading {\n			color: #000;\n			font-size: 20px;\n		}\n\n		.footer ul {\n			margin: 0;\n			padding: 0;\n		}\n\n		.footer ul li {\n			list-style: none;\n			margin-bottom: 10px;\n		}\n\n		.footer ul li a {\n			color: rgba(0, 0, 0, 1);\n		}\n\n\n		@media screen and (max-width: 500px) {}\n	</style>\n\n\n</head>\n\n<body width=\"100%\" style=\"margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;\">\n	<center style=\"width: 100%; background-color: #f1f1f1;\">\n		<div style=\"display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;\">\n			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n		</div>\n		<div style=\"max-width: 600px; margin: 0 auto;\" class=\"email-container\">\n			<!-- BEGIN BODY -->\n			<table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">\n				<tr>\n					<td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">\n						<table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tr>\n								<td class=\"logo\" style=\"text-align: center;\">\n									<h1>\n										<a href=\"http://localhost/editrade.com/\">\n											<img src=\"http://localhost/editrade.com/public/img/logo.png\" alt=\"CryptoProperty LOGO\">\n										</a>\n									</h1>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 3em 0 2em 0;\">\n						<img src=\"http://localhost/editrade.com/public/img/otp.png\" alt=\"Logo OTP\" style=\"width: 300px; max-width: 600px; height: auto; margin: auto; display: block;\">\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 2em 0 4em 0;\">\n						<table>\n							<tr>\n								<td>\n									<div class=\"text\" style=\"padding: 0 2.5em; text-align: center;\">\n										<h3>Please verify your One Time Password (OTP)</h3>\n										<h2><kbd>460720</kbd></h2>\n										<h3>Never Share this OTP to anyone</h3>\n									</div>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<!-- 1 Column Text + Button : END -->\n			</table>\n\n		</div>\n	</center>\n</body>\n\n</html>\n', 'yes', '2021-07-16 00:58:00', '1294a713-e596-11eb-abed-ea7075f67258');
INSERT INTO `et_log_send_email_member` VALUES (2, 'adam.pm77@gmail.com', 'CryptoProperty | OTP (One Time Password)', '<!DOCTYPE html>\n<html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">\n\n<head>\n	<meta charset=\"utf-8\"> <!-- utf-8 works for most cases -->\n	<meta name=\"viewport\" content=\"width=device-width\"> <!-- Forcing initial-scale shouldn\'t be necessary -->\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <!-- Use the latest (edge) version of IE rendering engine -->\n	<meta name=\"x-apple-disable-message-reformatting\"> <!-- Disable auto-scale in iOS 10 Mail entirely -->\n	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->\n\n	<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700\" rel=\"stylesheet\">\n\n	<!-- CSS Reset : BEGIN -->\n	<style>\n		/* What it does: Remove spaces around the email design added by some email clients. */\n		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */\n		html,\n		body {\n			margin: 0 auto !important;\n			padding: 0 !important;\n			height: 100% !important;\n			width: 100% !important;\n			background: #f1f1f1;\n		}\n\n		/* What it does: Stops email clients resizing small text. */\n		* {\n			-ms-text-size-adjust: 100%;\n			-webkit-text-size-adjust: 100%;\n		}\n\n		/* What it does: Centers email on Android 4.4 */\n		div[style*=\"margin: 16px 0\"] {\n			margin: 0 !important;\n		}\n\n		/* What it does: Stops Outlook from adding extra spacing to tables. */\n		table,\n		td {\n			mso-table-lspace: 0pt !important;\n			mso-table-rspace: 0pt !important;\n		}\n\n		/* What it does: Fixes webkit padding issue. */\n		table {\n			border-spacing: 0 !important;\n			border-collapse: collapse !important;\n			table-layout: fixed !important;\n			margin: 0 auto !important;\n		}\n\n		/* What it does: Uses a better rendering method when resizing images in IE. */\n		img {\n			-ms-interpolation-mode: bicubic;\n		}\n\n		/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */\n		a {\n			text-decoration: none;\n		}\n\n		/* What it does: A work-around for email clients meddling in triggered links. */\n		*[x-apple-data-detectors],\n		/* iOS */\n		.unstyle-auto-detected-links *,\n		.aBn {\n			border-bottom: 0 !important;\n			cursor: default !important;\n			color: inherit !important;\n			text-decoration: none !important;\n			font-size: inherit !important;\n			font-family: inherit !important;\n			font-weight: inherit !important;\n			line-height: inherit !important;\n		}\n\n		/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */\n		.a6S {\n			display: none !important;\n			opacity: 0.01 !important;\n		}\n\n		/* What it does: Prevents Gmail from changing the text color in conversation threads. */\n		.im {\n			color: inherit !important;\n		}\n\n		/* If the above doesn\'t work, add a .g-img class to any image in question. */\n		img.g-img+div {\n			display: none !important;\n		}\n\n		/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */\n		/* Create one of these media queries for each additional viewport size you\'d like to fix */\n\n		/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */\n		@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {\n			u~div .email-container {\n				min-width: 320px !important;\n			}\n		}\n\n		/* iPhone 6, 6S, 7, 8, and X */\n		@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {\n			u~div .email-container {\n				min-width: 375px !important;\n			}\n		}\n\n		/* iPhone 6+, 7+, and 8+ */\n		@media only screen and (min-device-width: 414px) {\n			u~div .email-container {\n				min-width: 414px !important;\n			}\n		}\n	</style>\n\n	<!-- CSS Reset : END -->\n\n	<!-- Progressive Enhancements : BEGIN -->\n	<style>\n		.primary {\n			background: #30e3ca;\n		}\n\n		.bg_white {\n			background: #ffffff;\n		}\n\n		.bg_light {\n			background: #fafafa;\n		}\n\n		.bg_black {\n			background: #000000;\n		}\n\n		.bg_dark {\n			background: rgba(0, 0, 0, .8);\n		}\n\n		.email-section {\n			padding: 2.5em;\n		}\n\n		/*BUTTON*/\n		.btn {\n			padding: 10px 15px;\n			display: inline-block;\n		}\n\n		.btn.btn-primary {\n			border-radius: 5px;\n			background: #30e3ca;\n			color: #ffffff;\n		}\n\n		.btn.btn-white {\n			border-radius: 5px;\n			background: #ffffff;\n			color: #000000;\n		}\n\n		.btn.btn-white-outline {\n			border-radius: 5px;\n			background: transparent;\n			border: 1px solid #fff;\n			color: #fff;\n		}\n\n		.btn.btn-black-outline {\n			border-radius: 0px;\n			background: transparent;\n			border: 2px solid #000;\n			color: #000;\n			font-weight: 700;\n		}\n\n		h1,\n		h2,\n		h3,\n		h4,\n		h5,\n		h6 {\n			font-family: \'Lato\', sans-serif;\n			color: #000000;\n			margin-top: 0;\n			font-weight: 400;\n		}\n\n		body {\n			font-family: \'Lato\', sans-serif;\n			font-weight: 400;\n			font-size: 15px;\n			line-height: 1.8;\n			color: rgba(0, 0, 0, .4);\n		}\n\n		a {\n			color: #30e3ca;\n		}\n\n		table {}\n\n		/*LOGO*/\n\n		.logo h1 {\n			margin: 0;\n		}\n\n		.logo h1 a {\n			color: #30e3ca;\n			font-size: 24px;\n			font-weight: 700;\n			font-family: \'Lato\', sans-serif;\n		}\n\n		/*HERO*/\n		.hero {\n			position: relative;\n			z-index: 0;\n		}\n\n		.hero .text {\n			color: rgba(0, 0, 0, .3);\n		}\n\n		.hero .text h2 {\n			color: #000;\n			font-size: 40px;\n			margin-bottom: 0;\n			font-weight: 400;\n			line-height: 1.4;\n		}\n\n		.hero .text h3 {\n			font-size: 24px;\n			font-weight: 300;\n		}\n\n		.hero .text h2 span {\n			font-weight: 600;\n			color: #30e3ca;\n		}\n\n\n		/*HEADING SECTION*/\n		.heading-section {}\n\n		.heading-section h2 {\n			color: #000000;\n			font-size: 28px;\n			margin-top: 0;\n			line-height: 1.4;\n			font-weight: 400;\n		}\n\n		.heading-section .subheading {\n			margin-bottom: 20px !important;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(0, 0, 0, .4);\n			position: relative;\n		}\n\n		.heading-section .subheading::after {\n			position: absolute;\n			left: 0;\n			right: 0;\n			bottom: -10px;\n			content: \'\';\n			width: 100%;\n			height: 2px;\n			background: #30e3ca;\n			margin: 0 auto;\n		}\n\n		.heading-section-white {\n			color: rgba(255, 255, 255, .8);\n		}\n\n		.heading-section-white h2 {\n			font-family: Lato;\n			line-height: 1;\n			padding-bottom: 0;\n		}\n\n		.heading-section-white h2 {\n			color: #ffffff;\n		}\n\n		.heading-section-white .subheading {\n			margin-bottom: 0;\n			display: inline-block;\n			font-size: 13px;\n			text-transform: uppercase;\n			letter-spacing: 2px;\n			color: rgba(255, 255, 255, .4);\n		}\n\n\n		ul.social {\n			padding: 0;\n		}\n\n		ul.social li {\n			display: inline-block;\n			margin-right: 10px;\n		}\n\n		/*FOOTER*/\n\n		.footer {\n			border-top: 1px solid rgba(0, 0, 0, .05);\n			color: rgba(0, 0, 0, .5);\n		}\n\n		.footer .heading {\n			color: #000;\n			font-size: 20px;\n		}\n\n		.footer ul {\n			margin: 0;\n			padding: 0;\n		}\n\n		.footer ul li {\n			list-style: none;\n			margin-bottom: 10px;\n		}\n\n		.footer ul li a {\n			color: rgba(0, 0, 0, 1);\n		}\n\n\n		@media screen and (max-width: 500px) {}\n	</style>\n\n\n</head>\n\n<body width=\"100%\" style=\"margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;\">\n	<center style=\"width: 100%; background-color: #f1f1f1;\">\n		<div style=\"display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;\">\n			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n		</div>\n		<div style=\"max-width: 600px; margin: 0 auto;\" class=\"email-container\">\n			<!-- BEGIN BODY -->\n			<table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">\n				<tr>\n					<td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">\n						<table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n							<tr>\n								<td class=\"logo\" style=\"text-align: center;\">\n									<h1>\n										<a href=\"http://localhost/editrade.com/\">\n											<img src=\"http://localhost/editrade.com/public/img/logo.png\" alt=\"CryptoProperty LOGO\">\n										</a>\n									</h1>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 3em 0 2em 0;\">\n						<img src=\"http://localhost/editrade.com/public/img/otp.png\" alt=\"Logo OTP\" style=\"width: 300px; max-width: 600px; height: auto; margin: auto; display: block;\">\n					</td>\n				</tr><!-- end tr -->\n				<tr>\n					<td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 2em 0 4em 0;\">\n						<table>\n							<tr>\n								<td>\n									<div class=\"text\" style=\"padding: 0 2.5em; text-align: center;\">\n										<h3>Please verify your One Time Password (OTP)</h3>\n										<h2><kbd>733269</kbd></h2>\n										<h3>Never Share this OTP to anyone</h3>\n									</div>\n								</td>\n							</tr>\n						</table>\n					</td>\n				</tr><!-- end tr -->\n				<!-- 1 Column Text + Button : END -->\n			</table>\n\n		</div>\n	</center>\n</body>\n\n</html>\n', 'yes', '2021-07-16 00:59:23', '1294a713-e596-11eb-abed-ea7075f67258');

-- ----------------------------
-- Table structure for et_member
-- ----------------------------
DROP TABLE IF EXISTS `et_member`;
CREATE TABLE `et_member`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT uuid COMMENT 'uuid',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_card_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_upline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `country_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `otp` int NULL DEFAULT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `activation_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `forgot_password_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_founder` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `cookies` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_member
-- ----------------------------
INSERT INTO `et_member` VALUES ('1294a713-e596-11eb-abed-ea7075f67258', 'adam.pm77@gmail.com', '$2y$10$NyMMzBU9MhhI2Ow1I3um8O1NzCH9snD/MpUnaFGicCDZsgtkPGzZS', '11111', 'Adam', '082114578976', NULL, NULL, NULL, 733269, 'yes', NULL, NULL, 'yes', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2021-07-16 00:57:04', '2021-07-16 00:59:33', NULL);

-- ----------------------------
-- Table structure for et_member_balance
-- ----------------------------
DROP TABLE IF EXISTS `et_member_balance`;
CREATE TABLE `et_member_balance`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `total_invest_trade_manager` decimal(15, 8) NULL DEFAULT 0.00000000,
  `count_trade_manager` smallint NULL DEFAULT 0,
  `total_invest_crypto_asset` decimal(15, 8) NULL DEFAULT 0.00000000,
  `count_crypto_asset` smallint NULL DEFAULT 0,
  `profit_asset` decimal(15, 8) NULL DEFAULT NULL,
  `profit` decimal(15, 8) NULL DEFAULT 0.00000000,
  `bonus` decimal(15, 8) NULL DEFAULT 0.00000000,
  `total_omset` decimal(15, 8) NULL DEFAULT 0.00000000,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_member_balance
-- ----------------------------
INSERT INTO `et_member_balance` VALUES ('1294c065-e596-11eb-abed-ea7075f67258', '1294a713-e596-11eb-abed-ea7075f67258', 0.00000000, 0, 0.00000000, 0, NULL, 0.00000000, 0.00000000, 0.00000000, '2021-07-16 00:57:04', '2021-07-16 00:57:04', NULL);

-- ----------------------------
-- Table structure for et_member_crypto_asset
-- ----------------------------
DROP TABLE IF EXISTS `et_member_crypto_asset`;
CREATE TABLE `et_member_crypto_asset`  (
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'INV-YMD-XXXXXX',
  `sequence` bigint UNSIGNED NULL DEFAULT NULL,
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_package` smallint UNSIGNED NULL DEFAULT NULL,
  `payment_method` enum('coinpayment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'coinpayment',
  `amount_usd` int UNSIGNED NULL DEFAULT NULL,
  `profit_self_per_day` decimal(15, 8) NULL DEFAULT NULL,
  `profit_upline_per_day` decimal(15, 8) NULL DEFAULT NULL,
  `profit_company_per_day` decimal(15, 8) NULL DEFAULT NULL,
  `currency1` enum('USDT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'USDT',
  `currency2` enum('LTCT','USDT.ERC20','USDT.BEP20') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'LTCT | USDT.ERC20 | USDT.BEP20',
  `buyer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buyer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `state` enum('waiting payment','pending','active','inactive','cancel','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'waiting payment | pending | active | inactive | cancel | expired',
  `txn_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount_coin` decimal(15, 8) NULL DEFAULT NULL,
  `receiver_wallet_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `timeout` bigint UNSIGNED NULL DEFAULT NULL,
  `checkout_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `qrcode_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `expired_at` date NULL DEFAULT NULL,
  `is_qualified` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `is_royalty` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`invoice`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_member_crypto_asset
-- ----------------------------

-- ----------------------------
-- Table structure for et_member_reward
-- ----------------------------
DROP TABLE IF EXISTS `et_member_reward`;
CREATE TABLE `et_member_reward`  (
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `reward_1` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `reward_1_date` date NULL DEFAULT NULL,
  `reward_1_done` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `reward_2` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `reward_2_date` date NULL DEFAULT NULL,
  `reward_2_done` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `reward_3` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `reward_3_date` date NULL DEFAULT NULL,
  `reward_3_done` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `reward_4` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `reward_4_date` date NULL DEFAULT NULL,
  `reward_4_done` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `reward_5` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `reward_5_date` date NULL DEFAULT NULL,
  `reward_5_done` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  PRIMARY KEY (`id_member`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_member_reward
-- ----------------------------
INSERT INTO `et_member_reward` VALUES ('1294a713-e596-11eb-abed-ea7075f67258', 'no', NULL, 'no', 'no', NULL, 'no', 'no', NULL, 'no', 'no', NULL, 'no', 'no', NULL, 'no');

-- ----------------------------
-- Table structure for et_member_trade_manager
-- ----------------------------
DROP TABLE IF EXISTS `et_member_trade_manager`;
CREATE TABLE `et_member_trade_manager`  (
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'INV-YMD-XXXXXX',
  `sequence` bigint UNSIGNED NULL DEFAULT NULL,
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_package` smallint UNSIGNED NULL DEFAULT NULL,
  `payment_method` enum('coinpayment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'coinpayment',
  `amount_usd` int UNSIGNED NULL DEFAULT NULL,
  `profit_self_per_day` decimal(15, 8) NULL DEFAULT NULL,
  `profit_upline_per_day` decimal(15, 8) NULL DEFAULT NULL,
  `profit_company_per_day` decimal(15, 8) NULL DEFAULT NULL,
  `currency1` enum('USDT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'USDT',
  `currency2` enum('LTCT','USDT.ERC20','USDT.BEP20') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'LTCT | USDT.ERC20 | USDT.BEP20',
  `buyer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buyer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `state` enum('waiting payment','pending','active','inactive','cancel','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'waiting payment | pending | active | inactive | cancel | expired',
  `txn_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount_coin` decimal(15, 8) NULL DEFAULT NULL,
  `receiver_wallet_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `timeout` bigint UNSIGNED NULL DEFAULT NULL,
  `checkout_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `qrcode_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `expired_at` date NULL DEFAULT NULL,
  `is_qualified` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `is_royalty` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `is_extend` enum('auto','manual') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'auto' COMMENT 'auto | manual',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`invoice`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_member_trade_manager
-- ----------------------------
INSERT INTO `et_member_trade_manager` VALUES ('INV-20210716-000001', 1, '1294a713-e596-11eb-abed-ea7075f67258', 1, 'coinpayment', 1, 0.00250000, 0.00125000, 0.00125000, 'USDT', 'LTCT', 'adam.pm77@gmail.com', 'Adam', 'Starter Pack', 'waiting payment', 'CPFG6XWA7EUI2I9WSY5KDTEJ1B', 0.00822000, 'n3NmwF6rUsf4beh1VPdL4HZeort8WTy5rN', 7200, 'https://www.coinpayments.net/index.php?cmd=checkout&id=CPFG6XWA7EUI2I9WSY5KDTEJ1B&key=37fabf16293cae05169a3fe1f1877952', 'https://www.coinpayments.net/index.php?cmd=status&id=CPFG6XWA7EUI2I9WSY5KDTEJ1B&key=37fabf16293cae05169a3fe1f1877952', 'https://www.coinpayments.net/qrgen.php?id=CPFG6XWA7EUI2I9WSY5KDTEJ1B&key=37fabf16293cae05169a3fe1f1877952', '2022-07-16', 'no', 'no', 'auto', '2021-07-16 19:51:35', '2021-07-16 19:51:38', NULL);
INSERT INTO `et_member_trade_manager` VALUES ('INV-20210716-000002', 2, '1294a713-e596-11eb-abed-ea7075f67258', 2, 'coinpayment', 2, 0.00600000, 0.00200000, 0.00200000, 'USDT', 'USDT.ERC20', 'adam.pm77@gmail.com', 'Adam', 'Sapphire Pack', 'waiting payment', 'CPFG2IMYQFU11XOPCZYYI7QVAJ', 6.10000000, '0x19673a0bebcc81584352d8c138d0dbc7d6b67157', 14400, 'https://www.coinpayments.net/index.php?cmd=checkout&id=CPFG2IMYQFU11XOPCZYYI7QVAJ&key=37389e79550d8544d2294f7e9a7ad651', 'https://www.coinpayments.net/index.php?cmd=status&id=CPFG2IMYQFU11XOPCZYYI7QVAJ&key=37389e79550d8544d2294f7e9a7ad651', 'https://www.coinpayments.net/qrgen.php?id=CPFG2IMYQFU11XOPCZYYI7QVAJ&key=37389e79550d8544d2294f7e9a7ad651', '2022-07-16', 'no', 'no', 'auto', '2021-07-16 20:49:57', '2021-07-16 20:50:04', NULL);

-- ----------------------------
-- Table structure for et_member_wallet
-- ----------------------------
DROP TABLE IF EXISTS `et_member_wallet`;
CREATE TABLE `et_member_wallet`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `receive_coin` enum('bnb','trx','ltct') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'bnb | trx | ltct',
  `wallet_host` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `wallet_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_member_wallet
-- ----------------------------

-- ----------------------------
-- Table structure for et_member_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `et_member_withdraw`;
CREATE TABLE `et_member_withdraw`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT ' uuid',
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sequence` bigint UNSIGNED NULL DEFAULT NULL,
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `amount_1` decimal(15, 8) UNSIGNED ZEROFILL NULL DEFAULT NULL,
  `amount_2` decimal(15, 8) UNSIGNED ZEROFILL NULL DEFAULT NULL,
  `currency_1` enum('usdt') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'usdt' COMMENT 'usdt | bnb | trx | ltct',
  `currency_2` enum('bnb','trx','ltct') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'bnb | trx | ltct',
  `source` enum('profit','bonus') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'profit | bonus',
  `id_wallet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `wallet_host` enum('binance mainnet','trustwallet','tokocrypto','indodax','tronlink mainnet','litecoin wallet testnet') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `wallet_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `state` enum('pending','success','cancel') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'pending | success | cancel',
  `tx_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_member_withdraw
-- ----------------------------

-- ----------------------------
-- Table structure for et_package_crypto_asset
-- ----------------------------
DROP TABLE IF EXISTS `et_package_crypto_asset`;
CREATE TABLE `et_package_crypto_asset`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'ET-ABBR',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount` int NULL DEFAULT NULL COMMENT 'usd',
  `profit_per_month_percent` float(15, 8) NULL DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_month_value` float(15, 8) NULL DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_day_percentage` float(15, 8) NULL DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_day_value` float(15, 8) NULL DEFAULT NULL,
  `contract_duration` int NULL DEFAULT NULL COMMENT 'day',
  `share_self_percentage` float(15, 8) NULL DEFAULT NULL,
  `share_self_value` float(15, 8) NULL DEFAULT NULL,
  `share_upline_percentage` float(15, 8) NULL DEFAULT NULL,
  `share_upline_value` float(15, 8) NULL DEFAULT NULL,
  `share_company_percentage` float(15, 8) NULL DEFAULT NULL,
  `share_company_value` float(15, 8) NULL DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sequence` int NULL DEFAULT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_package_crypto_asset
-- ----------------------------
INSERT INTO `et_package_crypto_asset` VALUES (1, 'ET-CA-ASH', 'Ashoca Pack', 10000, 15.00000000, 1500.00000000, 0.50000000, 50.00000000, 365, 60.00000000, 30.00000000, 20.00000000, 10.00000000, 20.00000000, 10.00000000, NULL, 1, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);
INSERT INTO `et_package_crypto_asset` VALUES (2, 'ET-CA-BOU', 'Bougainvillea Pack', 20000, 15.00000000, 3000.00000000, 0.50000000, 100.00000000, 365, 65.00000000, 65.00000000, 17.50000000, 17.50000000, 17.50000000, 17.50000000, NULL, 2, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);
INSERT INTO `et_package_crypto_asset` VALUES (3, 'ET-CA-CLO', 'Clover Pack', 30000, 15.00000000, 4500.00000000, 0.50000000, 150.00000000, 365, 70.00000000, 105.00000000, 15.00000000, 22.50000000, 15.00000000, 22.50000000, NULL, 3, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);
INSERT INTO `et_package_crypto_asset` VALUES (4, 'ET-CA-DAH', 'Dahlia Pack', 50000, 15.00000000, 7500.00000000, 0.50000000, 250.00000000, 365, 75.00000000, 187.50000000, 12.50000000, 31.25000000, 12.50000000, 31.25000000, NULL, 4, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);
INSERT INTO `et_package_crypto_asset` VALUES (5, 'ET-CA-EDE', 'Edelweiss Pack', 75000, 15.00000000, 11250.00000000, 0.50000000, 375.00000000, 365, 80.00000000, 300.00000000, 10.00000000, 37.50000000, 10.00000000, 37.50000000, NULL, 5, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);

-- ----------------------------
-- Table structure for et_package_trade_manager
-- ----------------------------
DROP TABLE IF EXISTS `et_package_trade_manager`;
CREATE TABLE `et_package_trade_manager`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'ET-ABBR',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount` int NULL DEFAULT NULL COMMENT 'usd',
  `profit_per_month_percent` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `profit_per_month_value` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `profit_per_day_percentage` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `profit_per_day_value` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `contract_duration` int NULL DEFAULT NULL COMMENT 'day',
  `share_self_percentage` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `share_self_value` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `share_upline_percentage` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `share_upline_value` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `share_company_percentage` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `share_company_value` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sequence` int NULL DEFAULT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_package_trade_manager
-- ----------------------------
INSERT INTO `et_package_trade_manager` VALUES (1, 'ET-TM-STA', 'Starter Pack', 1, 15.00000000, 0.15000000, 0.50000000, 0.00500000, 365, 50.00000000, 0.00250000, 25.00000000, 0.00125000, 25.00000000, 0.00125000, 'starter_logo.png', 1, 'yes', '2021-06-12 03:06:36', '2021-06-12 03:06:40', NULL);
INSERT INTO `et_package_trade_manager` VALUES (2, 'ET-TM-SAP', 'Sapphire Pack', 2, 15.00000000, 0.30000000, 0.50000000, 0.01000000, 365, 60.00000000, 0.00600000, 20.00000000, 0.00200000, 20.00000000, 0.00200000, 'sapphire_logo.png', 2, 'yes', '2021-06-12 03:09:28', '2021-06-12 03:09:31', NULL);
INSERT INTO `et_package_trade_manager` VALUES (3, 'ET-TM-RUB', 'Ruby Pack', 3, 15.00000000, 0.45000000, 0.50000000, 0.01500000, 365, 70.00000000, 0.01050000, 15.00000000, 0.00225000, 15.00000000, 0.00225000, 'ruby_logo.png', 3, 'yes', '2021-06-12 03:10:27', '2021-06-12 03:10:29', NULL);
INSERT INTO `et_package_trade_manager` VALUES (4, 'ET-TM-EME', 'Emerald Pack', 4, 15.00000000, 0.60000000, 0.50000000, 0.02000000, 365, 80.00000000, 0.01600000, 10.00000000, 0.00200000, 10.00000000, 0.00200000, 'emerald_logo.png', 4, 'yes', '2021-06-12 03:11:23', '2021-06-12 03:11:34', NULL);
INSERT INTO `et_package_trade_manager` VALUES (5, 'ET-TM-DIA', 'Diamond Pack', 5, 15.00000000, 0.75000000, 0.50000000, 0.02500000, 365, 90.00000000, 0.02250000, 5.00000000, 0.00125000, 5.00000000, 0.00125000, 'diamond_logo.png', 5, 'yes', '2021-06-12 03:12:35', '2021-06-12 03:12:37', NULL);
INSERT INTO `et_package_trade_manager` VALUES (6, 'ET-TM-CRO', 'Crown Pack', 0, 15.00000000, 0.00000000, 0.50000000, 0.00000000, 365, 90.00000000, 0.00000000, 5.00000000, 0.00000000, 5.00000000, 0.00000000, 'crown_logo.png', 6, 'yes', '2021-06-12 03:16:46', '2021-06-12 03:16:49', NULL);

-- ----------------------------
-- Table structure for et_package_trade_manager_copy1
-- ----------------------------
DROP TABLE IF EXISTS `et_package_trade_manager_copy1`;
CREATE TABLE `et_package_trade_manager_copy1`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'ET-ABBR',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount` int NULL DEFAULT NULL COMMENT 'usd',
  `profit_per_month_percent` float(15, 8) NULL DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_month_value` float(15, 8) NULL DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_day_percentage` float(15, 8) NULL DEFAULT NULL COMMENT 'float decimal 8',
  `profit_per_day_value` float(15, 8) NULL DEFAULT NULL,
  `contract_duration` int NULL DEFAULT NULL COMMENT 'day',
  `share_self_percentage` float(15, 8) NULL DEFAULT NULL,
  `share_self_value` float(15, 8) NULL DEFAULT NULL,
  `share_upline_percentage` float(15, 8) NULL DEFAULT NULL,
  `share_upline_value` float(15, 8) NULL DEFAULT NULL,
  `share_company_percentage` float(15, 8) NULL DEFAULT NULL,
  `share_company_value` float(15, 8) NULL DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sequence` int NULL DEFAULT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_package_trade_manager_copy1
-- ----------------------------
INSERT INTO `et_package_trade_manager_copy1` VALUES (1, 'ET-TM-STA', 'Starter Pack', 100, 15.00000000, 15.00000000, 0.50000000, 0.50000000, 365, 50.00000000, 0.25000000, 25.00000000, 0.12500000, 25.00000000, 0.12500000, 'starter_logo.png', 1, 'yes', '2021-06-12 03:06:36', '2021-06-12 03:06:40', NULL);
INSERT INTO `et_package_trade_manager_copy1` VALUES (2, 'ET-TM-SAP', 'Sapphire Pack', 500, 15.00000000, 75.00000000, 0.50000000, 2.50000000, 365, 60.00000000, 1.50000000, 20.00000000, 0.50000000, 20.00000000, 0.50000000, 'sapphire_logo.png', 2, 'yes', '2021-06-12 03:09:28', '2021-06-12 03:09:31', NULL);
INSERT INTO `et_package_trade_manager_copy1` VALUES (3, 'ET-TM-RUB', 'Ruby Pack', 1000, 15.00000000, 150.00000000, 0.50000000, 5.00000000, 365, 70.00000000, 3.50000000, 15.00000000, 0.75000000, 15.00000000, 0.75000000, 'ruby_logo.png', 3, 'yes', '2021-06-12 03:10:27', '2021-06-12 03:10:29', NULL);
INSERT INTO `et_package_trade_manager_copy1` VALUES (4, 'ET-TM-EME', 'Emerald Pack', 5000, 15.00000000, 750.00000000, 0.50000000, 25.00000000, 365, 80.00000000, 20.00000000, 10.00000000, 2.50000000, 10.00000000, 2.50000000, 'emerald_logo.png', 4, 'yes', '2021-06-12 03:11:23', '2021-06-12 03:11:34', NULL);
INSERT INTO `et_package_trade_manager_copy1` VALUES (5, 'ET-TM-DIA', 'Diamond Pack', 10000, 15.00000000, 1500.00000000, 0.50000000, 50.00000000, 365, 90.00000000, 45.00000000, 5.00000000, 2.50000000, 5.00000000, 2.50000000, 'diamond_logo.png', 5, 'yes', '2021-06-12 03:12:35', '2021-06-12 03:12:37', NULL);
INSERT INTO `et_package_trade_manager_copy1` VALUES (6, 'ET-TM-CRO', 'Crown Pack', 0, 15.00000000, 0.00000000, 0.50000000, 0.00000000, 365, 90.00000000, 0.00000000, 5.00000000, 0.00000000, 5.00000000, 0.00000000, 'crown_logo.png', 6, 'yes', '2021-06-12 03:16:46', '2021-06-12 03:16:49', NULL);

-- ----------------------------
-- Table structure for et_tree
-- ----------------------------
DROP TABLE IF EXISTS `et_tree`;
CREATE TABLE `et_tree`  (
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_upline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `lft` int UNSIGNED NULL DEFAULT NULL,
  `rgt` int UNSIGNED NULL DEFAULT NULL,
  `depth` int UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id_member`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_tree
-- ----------------------------
INSERT INTO `et_tree` VALUES ('1294a713-e596-11eb-abed-ea7075f67258', 'adam.pm77@gmail.com', NULL, 1, 2, 0);

-- ----------------------------
-- Table structure for et_unknown_balance
-- ----------------------------
DROP TABLE IF EXISTS `et_unknown_balance`;
CREATE TABLE `et_unknown_balance`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount_profit` decimal(15, 8) NULL DEFAULT NULL,
  `amount_bonus` decimal(15, 8) NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_unknown_balance
-- ----------------------------
INSERT INTO `et_unknown_balance` VALUES (1, 0.00000000, 0.00000000, '2021-06-29 07:35:36');

SET FOREIGN_KEY_CHECKS = 1;
