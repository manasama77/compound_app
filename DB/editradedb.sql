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

 Date: 21/07/2021 02:42:01
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
  `state` enum('get','correction') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'get | correction',
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
  `state` enum('get','correction') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'get | correction',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'X get bonus recruitment of member (x) 000 USDT',
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_profit_trade_manager
-- ----------------------------
INSERT INTO `et_log_profit_trade_manager` VALUES ('767f1a31-e751-11eb-9ae2-037645f91062', '1294a713-e596-11eb-abed-ea7075f67258', 'INV-20210718-000001', '1', 'Starter Pack', 0.00250000, '', 'Adam (adam.pm77@gmail.com) get daily profit from trade manager package Starter Pack for 0.00250000 USDT', '2021-07-18 05:51:03');
INSERT INTO `et_log_profit_trade_manager` VALUES ('767f62b2-e751-11eb-9ae2-037645f91062', NULL, 'INV-20210718-000001', '1', 'Starter Pack', 0.00125000, '', 'Unknown Balance get daily profit from downline Adam (adam.pm77@gmail.com) trade manager package Starter Pack for 0.00125000 USDT', '2021-07-18 05:51:03');
INSERT INTO `et_log_profit_trade_manager` VALUES ('767f8752-e751-11eb-9ae2-037645f91062', NULL, 'INV-20210718-000001', '1', 'Starter Pack', 0.00125000, '', 'Unknown Balance get daily profit from downline Adam (adam.pm77@gmail.com) trade manager package Starter Pack for 0.00125000 USDT', '2021-07-18 05:51:03');
INSERT INTO `et_log_profit_trade_manager` VALUES ('88d0c636-e749-11eb-9ae2-037645f91062', '1294a713-e596-11eb-abed-ea7075f67258', 'INV-20210718-000001', '1', 'Starter Pack', 0.00250000, '', 'Adam (adam.pm77@gmail.com) get daily profit from trade manager package Starter Pack for 0.00250000 USDT', '2021-07-18 04:54:17');
INSERT INTO `et_log_profit_trade_manager` VALUES ('88d17471-e749-11eb-9ae2-037645f91062', NULL, 'INV-20210718-000001', '1', 'Starter Pack', 0.00125000, '', 'Unknown Balance get daily profit from downline Adam (adam.pm77@gmail.com) trade manager package Starter Pack for 0.00125000 USDT', '2021-07-18 04:54:17');
INSERT INTO `et_log_profit_trade_manager` VALUES ('88d18b32-e749-11eb-9ae2-037645f91062', NULL, 'INV-20210718-000001', '1', 'Starter Pack', 0.00125000, '', 'Unknown Balance get daily profit from downline Adam (adam.pm77@gmail.com) trade manager package Starter Pack for 0.00125000 USDT', '2021-07-18 04:54:17');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_send_email_admin
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_send_email_member
-- ----------------------------

-- ----------------------------
-- Table structure for et_member
-- ----------------------------
DROP TABLE IF EXISTS `et_member`;
CREATE TABLE `et_member`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'uuid',
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
  `profit_asset` decimal(15, 8) NULL DEFAULT 0.00000000,
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

-- ----------------------------
-- Table structure for et_member_wallet
-- ----------------------------
DROP TABLE IF EXISTS `et_member_wallet`;
CREATE TABLE `et_member_wallet`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `coin_type` enum('BNB.BSC','TRX','LTCT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'BNB.BSC | TRX | LTCT',
  `wallet_label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
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
  `currency_1` enum('USDT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'USDT' COMMENT 'USDT',
  `currency_2` enum('BNB.BSC','TRX','LTCT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'BNB.BSC | TRX | LTCT',
  `source` enum('profit','bonus') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'profit | bonus',
  `id_wallet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `wallet_label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
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
INSERT INTO `et_unknown_balance` VALUES (1, 0.00000000, 0.00000000, '2021-07-20 00:51:19');

SET FOREIGN_KEY_CHECKS = 1;
