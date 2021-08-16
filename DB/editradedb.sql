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

 Date: 16/08/2021 14:58:31
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
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_admin
-- ----------------------------
INSERT INTO `et_admin` VALUES (1, 'adam.pm77@gmail.com', '$2y$10$YysMw8.jKVUn5.bSMioNNurFK/sFahRZ/EoE9l049VHWmEGA6r7h6', 'Adam PM', 'developer', 'yes', NULL, 'IfNG62YRH5NZXe1sCMBdU0mozjPW8gJ8juyiIE3YRfcHrCiQDBqoTm791M0nhDFL', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0', 226902, '2021-06-06 00:35:15', '2021-08-16 01:24:13', NULL, NULL, 1, NULL);
INSERT INTO `et_admin` VALUES (6, 'arifsuyanto165@gmail.com', '$2y$10$hH9O9dDe9kGLxhAxYhEpIuDjpJyCBluSl5kK3XqsIoiSaLdUeWNTa', 'Arif Suyanto', 'admin', 'yes', NULL, NULL, '180.252.94.8', 'Mozilla/5.0 (Linux; Android 10; SM-N770F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Mobile Safari/537.36', 760019, '2021-07-28 23:06:10', '2021-08-06 15:37:40', NULL, 1, 6, NULL);
INSERT INTO `et_admin` VALUES (7, 'edisurachman99@gmail.com', '$2y$10$DUXtmw8Dy2lNfIihgM6PteGP472AAT310NtMkY5WtcKKidTxlOJki', 'Edi', 'owner', 'yes', NULL, NULL, NULL, NULL, 845309, '2021-08-06 13:27:01', '2021-08-06 13:27:01', NULL, 1, 1, NULL);

-- ----------------------------
-- Table structure for et_app_config
-- ----------------------------
DROP TABLE IF EXISTS `et_app_config`;
CREATE TABLE `et_app_config`  (
  `email_admin_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_alias_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_admin_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_alias_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `wa_admin_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `wa_admin_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `limit_reward_1` int NULL DEFAULT NULL,
  `limit_reward_2` int NULL DEFAULT NULL,
  `limit_reward_3` int NULL DEFAULT NULL,
  `limit_reward_4` int NULL DEFAULT NULL,
  `limit_reward_5` int NULL DEFAULT NULL,
  `target_reward_1` int NULL DEFAULT NULL,
  `target_reward_2` int NULL DEFAULT NULL,
  `target_reward_3` int NULL DEFAULT NULL,
  `target_reward_4` int NULL DEFAULT NULL,
  `target_reward_5` int NULL DEFAULT NULL,
  `limit_withdraw` int NULL DEFAULT NULL,
  `min_crown` int NULL DEFAULT NULL,
  `bonus_sponsor` int NULL DEFAULT NULL,
  `bonus_ql` int NULL DEFAULT NULL,
  `bonus_g2` int NULL DEFAULT NULL,
  `bonus_g3_g7` int NULL DEFAULT NULL,
  `bonus_g8_g11` decimal(30, 2) NULL DEFAULT NULL,
  `potongan_wd_external` int NULL DEFAULT NULL,
  `potongan_wd_internal` int NULL DEFAULT NULL,
  `potongan_transfer` int NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_app_config
-- ----------------------------
INSERT INTO `et_app_config` VALUES ('noreply@cryptoperty.id', 'CryptoPerty Test', 'admin@cryptoperty.id', 'Admin CryptoPerty', '6281219869989', '6281219869989', 4300000, 1941000, 675000, 100000, 24000, 700, 2100, 17250, 38000, 70000, 1, 11000, 10, 5, 3, 1, 0.50, 10, 5, 1);

-- ----------------------------
-- Table structure for et_bank
-- ----------------------------
DROP TABLE IF EXISTS `et_bank`;
CREATE TABLE `et_bank`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 69 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_bank
-- ----------------------------
INSERT INTO `et_bank` VALUES (1, '009', 'Bank BNI');
INSERT INTO `et_bank` VALUES (2, '110', 'Bank Jabar');
INSERT INTO `et_bank` VALUES (3, '111', 'Bank DKI');
INSERT INTO `et_bank` VALUES (4, '112', 'Bank BPD DIY');
INSERT INTO `et_bank` VALUES (5, '113', 'Bank Jateng');
INSERT INTO `et_bank` VALUES (6, '114', 'Bank Jatim');
INSERT INTO `et_bank` VALUES (7, '115', 'Bank BPD Jambi');
INSERT INTO `et_bank` VALUES (8, '116', 'Bank BPD Aceh');
INSERT INTO `et_bank` VALUES (9, '117', 'Bank Sumut');
INSERT INTO `et_bank` VALUES (10, '118', 'Bank Nagari');
INSERT INTO `et_bank` VALUES (11, '119', 'Bank Riau');
INSERT INTO `et_bank` VALUES (12, '120', 'Bank Sumsel');
INSERT INTO `et_bank` VALUES (13, '121', 'Bank Lampung');
INSERT INTO `et_bank` VALUES (14, '122', 'Bank Kalsel');
INSERT INTO `et_bank` VALUES (15, '124', 'Bank BPD Kaltim');
INSERT INTO `et_bank` VALUES (16, '125', 'Bank BPD Kalteng');
INSERT INTO `et_bank` VALUES (17, '126', 'Bank Sulsel');
INSERT INTO `et_bank` VALUES (18, '127', 'Bank Sulut');
INSERT INTO `et_bank` VALUES (19, '128', 'Bank BPD NTB');
INSERT INTO `et_bank` VALUES (20, '129', 'Bank BPD Bali');
INSERT INTO `et_bank` VALUES (21, '130', 'Bank NTT');
INSERT INTO `et_bank` VALUES (22, '131', 'Bank Maluku');
INSERT INTO `et_bank` VALUES (23, '132', 'Bank Papua');
INSERT INTO `et_bank` VALUES (24, '133', 'Bank Bengkulu');
INSERT INTO `et_bank` VALUES (25, '135', 'Bank Sultra');
INSERT INTO `et_bank` VALUES (26, '145', 'Bank Nusantara Parahyangan');
INSERT INTO `et_bank` VALUES (27, '146', 'Bank Swadesi');
INSERT INTO `et_bank` VALUES (28, '147', 'Bank Muamalat');
INSERT INTO `et_bank` VALUES (29, '151', 'Bank Mestika');
INSERT INTO `et_bank` VALUES (30, '157', 'Bank Maspion');
INSERT INTO `et_bank` VALUES (31, '161', 'Bank Ganesha');
INSERT INTO `et_bank` VALUES (32, '167', 'Bank Kesawan');
INSERT INTO `et_bank` VALUES (33, '212', 'Bank Saudara HS 1906');
INSERT INTO `et_bank` VALUES (34, '426', 'Bank Mega');
INSERT INTO `et_bank` VALUES (35, '427', 'Bank Jasa Jakarta');
INSERT INTO `et_bank` VALUES (36, '441', 'Bank Bukopin');
INSERT INTO `et_bank` VALUES (37, '451', 'Bank Syariah Mandiri');
INSERT INTO `et_bank` VALUES (38, '485', 'Bank Bumiputera');
INSERT INTO `et_bank` VALUES (39, '494', 'Bank Agroniaga');
INSERT INTO `et_bank` VALUES (40, '506', 'Bank Syariah Mega Indonesia');
INSERT INTO `et_bank` VALUES (41, '513', 'Bank Ina Perdana');
INSERT INTO `et_bank` VALUES (42, '536', 'Bank UIB');
INSERT INTO `et_bank` VALUES (43, '542', 'Bank Artos Indonesia');
INSERT INTO `et_bank` VALUES (44, '553', 'Bank Mayora');
INSERT INTO `et_bank` VALUES (45, '558', 'Bank Eksekutif');
INSERT INTO `et_bank` VALUES (46, '558', 'BPR KS');
INSERT INTO `et_bank` VALUES (47, '567', 'Bank Harda');
INSERT INTO `et_bank` VALUES (48, '950', 'Bank Commonwealth');
INSERT INTO `et_bank` VALUES (49, '002', 'Bank BRI');
INSERT INTO `et_bank` VALUES (50, '008', 'Bank Mandiri');
INSERT INTO `et_bank` VALUES (51, '011', 'Bank Danamon');
INSERT INTO `et_bank` VALUES (52, '013', 'Bank Permata');
INSERT INTO `et_bank` VALUES (53, '014', 'Bank BCA');
INSERT INTO `et_bank` VALUES (54, '016', 'Bank BII');
INSERT INTO `et_bank` VALUES (55, '019', 'Bank Panin');
INSERT INTO `et_bank` VALUES (56, '020', 'Bank Arta Niaga Kencana');
INSERT INTO `et_bank` VALUES (57, '022', 'Bank Niaga');
INSERT INTO `et_bank` VALUES (58, '023', 'Bank UOB Buana');
INSERT INTO `et_bank` VALUES (59, '026', 'LippoBank');
INSERT INTO `et_bank` VALUES (60, '028', 'Bank NISP');
INSERT INTO `et_bank` VALUES (61, '037', 'Bank Artha Graha');
INSERT INTO `et_bank` VALUES (62, '050', 'Standard Chartered Bank');
INSERT INTO `et_bank` VALUES (63, '052', 'Bank ABN AMRO');
INSERT INTO `et_bank` VALUES (64, '076', 'Bank Bumi Arta');
INSERT INTO `et_bank` VALUES (65, '087', 'Bank Ekonomi');
INSERT INTO `et_bank` VALUES (66, '089', 'Bank Haga');
INSERT INTO `et_bank` VALUES (67, '093', 'Bank IFI');
INSERT INTO `et_bank` VALUES (68, '097', 'Bank Mayapada');

-- ----------------------------
-- Table structure for et_coinpayment_fee
-- ----------------------------
DROP TABLE IF EXISTS `et_coinpayment_fee`;
CREATE TABLE `et_coinpayment_fee`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `coin_type` enum('BNB.BSC','TRX','LTCT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'USDT.BSC | BNB.BEP20 | TRX | LTCT',
  `fee` decimal(15, 8) NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_coinpayment_fee
-- ----------------------------
INSERT INTO `et_coinpayment_fee` VALUES (1, 'BNB.BSC', 0.00100000, '2021-07-23 05:24:26');
INSERT INTO `et_coinpayment_fee` VALUES (2, 'TRX', 0.20000000, '2021-07-23 05:24:14');
INSERT INTO `et_coinpayment_fee` VALUES (3, 'LTCT', 0.00100000, '2021-07-23 05:25:27');

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
-- Table structure for et_konfigurasi_crypto_asset
-- ----------------------------
DROP TABLE IF EXISTS `et_konfigurasi_crypto_asset`;
CREATE TABLE `et_konfigurasi_crypto_asset`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_package_crypto_asset` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_aktif` datetime NOT NULL,
  `profit_per_month_percent` float(15, 8) NOT NULL COMMENT 'float decimal 8',
  `profit_per_month_value` float(15, 8) NOT NULL COMMENT 'float decimal 8',
  `profit_per_day_percentage` float(15, 8) NOT NULL COMMENT 'float decimal 8',
  `profit_per_day_value` float(15, 8) NOT NULL,
  `share_self_percentage` float(15, 8) NOT NULL,
  `share_self_value` float(15, 8) NOT NULL,
  `share_upline_percentage` float(15, 8) NOT NULL,
  `share_upline_value` float(15, 8) NOT NULL,
  `share_company_percentage` float(15, 8) NOT NULL,
  `share_company_value` float(15, 8) NOT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no' COMMENT 'yes | no',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_konfigurasi_crypto_asset
-- ----------------------------
INSERT INTO `et_konfigurasi_crypto_asset` VALUES (1, '1', '2021-08-04 00:00:00', 15.00000000, 1500.00000000, 0.50000000, 50.00000000, 60.00000000, 30.00000000, 20.00000000, 10.00000000, 20.00000000, 10.00000000, 'yes', '2021-08-03 20:58:13', '2021-08-03 21:01:40', NULL);
INSERT INTO `et_konfigurasi_crypto_asset` VALUES (2, '2', '2021-08-04 00:00:00', 15.00000000, 3000.00000000, 0.50000000, 100.00000000, 65.00000000, 65.00000000, 17.50000000, 17.50000000, 17.50000000, 17.50000000, 'yes', '2021-08-03 20:59:13', '2021-08-03 21:01:43', NULL);
INSERT INTO `et_konfigurasi_crypto_asset` VALUES (3, '3', '2021-08-04 00:00:00', 15.00000000, 4500.00000000, 0.50000000, 150.00000000, 70.00000000, 105.00000000, 15.00000000, 22.50000000, 15.00000000, 22.50000000, 'yes', '2021-08-03 21:00:08', '2021-08-03 21:01:43', NULL);
INSERT INTO `et_konfigurasi_crypto_asset` VALUES (4, '4', '2021-08-04 00:00:00', 15.00000000, 7500.00000000, 0.50000000, 250.00000000, 75.00000000, 187.50000000, 12.50000000, 31.25000000, 12.50000000, 31.25000000, 'yes', '2021-08-03 21:00:54', '2021-08-03 21:01:43', NULL);
INSERT INTO `et_konfigurasi_crypto_asset` VALUES (5, '5', '2021-08-04 00:00:00', 15.00000000, 11250.00000000, 0.50000000, 375.00000000, 80.00000000, 300.00000000, 10.00000000, 37.50000000, 10.00000000, 37.50000000, 'yes', '2021-08-03 21:01:22', '2021-08-03 21:01:43', NULL);

-- ----------------------------
-- Table structure for et_konfigurasi_trade_manager
-- ----------------------------
DROP TABLE IF EXISTS `et_konfigurasi_trade_manager`;
CREATE TABLE `et_konfigurasi_trade_manager`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_package_trade_manager` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_aktif` datetime NOT NULL,
  `profit_per_month_percent` float(15, 8) NOT NULL COMMENT 'float decimal 8',
  `profit_per_month_value` float(15, 8) NOT NULL COMMENT 'float decimal 8',
  `profit_per_day_percentage` float(15, 8) NOT NULL COMMENT 'float decimal 8',
  `profit_per_day_value` float(15, 8) NOT NULL,
  `share_self_percentage` float(15, 8) NOT NULL,
  `share_self_value` float(15, 8) NOT NULL,
  `share_upline_percentage` float(15, 8) NOT NULL,
  `share_upline_value` float(15, 8) NOT NULL,
  `share_company_percentage` float(15, 8) NOT NULL,
  `share_company_value` float(15, 8) NOT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no' COMMENT 'yes | no',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_konfigurasi_trade_manager
-- ----------------------------
INSERT INTO `et_konfigurasi_trade_manager` VALUES (1, '1', '2021-07-31 00:00:00', 15.00000000, 15.00000000, 0.50000000, 0.50000000, 50.00000000, 0.25000000, 25.00000000, 0.12500000, 25.00000000, 0.12500000, 'yes', '2021-07-30 08:48:29', '2021-08-03 23:07:47', NULL);
INSERT INTO `et_konfigurasi_trade_manager` VALUES (2, '2', '2021-07-31 00:00:00', 15.00000000, 75.00000000, 0.50000000, 2.50000000, 60.00000000, 1.50000000, 20.00000000, 0.50000000, 20.00000000, 0.50000000, 'yes', '2021-07-30 09:24:42', '2021-07-30 09:29:39', NULL);
INSERT INTO `et_konfigurasi_trade_manager` VALUES (3, '3', '2021-07-31 00:00:00', 15.00000000, 150.00000000, 0.50000000, 5.00000000, 70.00000000, 3.50000000, 15.00000000, 0.75000000, 15.00000000, 0.75000000, 'yes', '2021-07-30 09:25:07', '2021-07-30 09:29:39', NULL);
INSERT INTO `et_konfigurasi_trade_manager` VALUES (4, '4', '2021-07-31 00:00:00', 15.00000000, 750.00000000, 0.50000000, 25.00000000, 80.00000000, 20.00000000, 10.00000000, 2.50000000, 10.00000000, 2.50000000, 'yes', '2021-07-30 09:25:29', '2021-07-30 09:29:39', NULL);
INSERT INTO `et_konfigurasi_trade_manager` VALUES (5, '5', '2021-07-31 00:00:00', 15.00000000, 1500.00000000, 0.50000000, 50.00000000, 85.00000000, 42.50000000, 7.50000000, 3.75000000, 7.50000000, 3.75000000, 'yes', '2021-07-30 09:27:58', '2021-07-30 09:29:39', NULL);
INSERT INTO `et_konfigurasi_trade_manager` VALUES (6, '6', '2021-07-31 00:00:00', 15.00000000, 0.00000000, 0.50000000, 0.00000000, 90.00000000, 0.00000000, 5.00000000, 0.00000000, 5.00000000, 0.00000000, 'yes', '2021-07-30 09:29:22', '2021-07-30 09:29:39', NULL);
INSERT INTO `et_konfigurasi_trade_manager` VALUES (7, '1', '2021-08-04 00:00:00', 10.00000000, 10.00000000, 0.33333334, 0.33333334, 50.00000000, 0.16666667, 25.00000000, 0.08333333, 25.00000000, 0.08333333, 'no', '2021-08-03 21:29:49', '2021-08-03 23:07:45', NULL);

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
  `id_konfigurasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `package_amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `bonus_amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
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
  `id_konfigurasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `package_amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `bonus_amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
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
  `id_konfigurasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `package_amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `bonus_amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
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
-- Table structure for et_log_member_crypto_asset
-- ----------------------------
DROP TABLE IF EXISTS `et_log_member_crypto_asset`;
CREATE TABLE `et_log_member_crypto_asset`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'no invoice',
  `amount_invest` int NULL DEFAULT NULL,
  `amount_transfer` decimal(15, 8) NULL DEFAULT NULL,
  `currency_transfer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `txn_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `state` enum('waiting payment','pending','active','inactive','cancel','expired','extend') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_log_member_crypto_asset
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
  `state` enum('waiting payment','pending','active','inactive','cancel','expired','extend') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  `member_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `member_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `member_user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_downline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `downline_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `downline_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `downline_user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `id_konfigurasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `persentase` decimal(15, 8) NULL DEFAULT NULL COMMENT '%',
  `profit` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `state` enum('self','downline','company','correction') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'self | downline | company | correction',
  `is_unpaid` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'yes',
  `release_date` date NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'X get profit',
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
  `member_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `member_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `member_user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_downline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `downline_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `downline_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `downline_user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'no invoice',
  `id_package` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `id_konfigurasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `persentase` decimal(15, 8) NULL DEFAULT NULL COMMENT '%',
  `profit` decimal(15, 8) NULL DEFAULT NULL COMMENT 'USDT',
  `state` enum('self','downline','company','correction') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'self | downline | company | correction',
  `is_unpaid` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'yes | no',
  `release_date` date NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'X get profit',
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
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_card_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `postal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_bank` bigint NULL DEFAULT NULL,
  `no_rekening` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_upline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `country_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `otp` int NULL DEFAULT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `activation_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `forgot_password_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_founder` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `is_kyc` enum('no','yes','check') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `cookies` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `foto_ktp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `foto_pegang_ktp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alasan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
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
  `total_invest_trade_manager` decimal(20, 8) NULL DEFAULT 0.00000000,
  `count_trade_manager` smallint NULL DEFAULT 0,
  `total_invest_crypto_asset` decimal(20, 8) NULL DEFAULT 0.00000000,
  `count_crypto_asset` smallint NULL DEFAULT 0,
  `profit_paid` decimal(20, 8) NULL DEFAULT 0.00000000,
  `profit_unpaid` decimal(20, 8) NULL DEFAULT 0.00000000,
  `bonus` decimal(20, 8) NULL DEFAULT 0.00000000,
  `ratu` decimal(20, 8) NULL DEFAULT 0.00000000,
  `self_omset` decimal(20, 8) NULL DEFAULT 0.00000000,
  `downline_omset` decimal(20, 8) NULL DEFAULT 0.00000000,
  `total_omset` decimal(20, 8) NOT NULL DEFAULT 0.00000000,
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
  `sequence` bigint UNSIGNED NOT NULL,
  `payment_method` enum('coinpayment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'coinpayment',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_package` smallint UNSIGNED NOT NULL,
  `id_konfigurasi` bigint NOT NULL,
  `package_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `receiver_wallet_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `txn_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount_1` int UNSIGNED NOT NULL,
  `amount_2` decimal(15, 8) NULL DEFAULT NULL,
  `currency1` enum('USDT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'USDT',
  `currency2` enum('LTCT','USDT.ERC20','USDT.BEP20') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'LTCT | USDT.ERC20 | USDT.BEP20',
  `state` enum('waiting payment','pending','active','inactive','cancel','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'waiting payment | pending | active | inactive | cancel | expired',
  `timeout` bigint UNSIGNED NULL DEFAULT NULL,
  `receive_amount` decimal(15, 8) NULL DEFAULT 0.00000000,
  `qrcode_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `checkout_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `expired_payment` datetime NULL DEFAULT NULL,
  `expired_package` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_qualified` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `is_royalty` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `amount_profit` decimal(15, 8) NULL DEFAULT 0.00000000,
  `can_claim` enum('no','yes') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'no',
  `profit_per_month_percent` decimal(15, 8) NOT NULL,
  `profit_per_month_value` decimal(15, 8) NOT NULL,
  `profit_per_day_percentage` decimal(15, 8) NOT NULL,
  `profit_per_day_value` decimal(15, 8) NOT NULL,
  `share_self_percentage` decimal(15, 8) NOT NULL,
  `share_self_value` decimal(15, 8) NOT NULL,
  `share_upline_percentage` decimal(15, 8) NOT NULL,
  `share_upline_value` decimal(15, 8) NOT NULL,
  `share_company_percentage` decimal(15, 8) NOT NULL,
  `share_company_value` decimal(15, 8) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
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
  `sequence` bigint UNSIGNED NOT NULL,
  `payment_method` enum('coinpayment') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'coinpayment',
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_package` smallint UNSIGNED NOT NULL,
  `id_konfigurasi` bigint NOT NULL,
  `package_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `receiver_wallet_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `txn_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount_1` int UNSIGNED NOT NULL,
  `amount_2` decimal(15, 8) NULL DEFAULT NULL,
  `currency1` enum('USDT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'USDT',
  `currency2` enum('LTCT','USDT.ERC20','USDT.BEP20') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'LTCT | USDT.ERC20 | USDT.BEP20',
  `state` enum('waiting payment','pending','active','inactive','cancel','expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'waiting payment | pending | active | inactive | cancel | expired',
  `timeout` bigint UNSIGNED NULL DEFAULT NULL,
  `receive_amount` decimal(15, 8) NULL DEFAULT 0.00000000,
  `qrcode_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `checkout_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `expired_payment` datetime NULL DEFAULT NULL,
  `expired_package` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_qualified` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `is_royalty` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'no',
  `is_extend` enum('auto','manual') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'auto' COMMENT 'auto | manual',
  `profit_per_month_percent` decimal(15, 8) NOT NULL,
  `profit_per_month_value` decimal(15, 8) NOT NULL,
  `profit_per_day_percentage` decimal(15, 8) NOT NULL,
  `profit_per_day_value` decimal(15, 8) NOT NULL,
  `share_self_percentage` decimal(15, 8) NOT NULL,
  `share_self_value` decimal(15, 8) NOT NULL,
  `share_upline_percentage` decimal(15, 8) NOT NULL,
  `share_upline_value` decimal(15, 8) NOT NULL,
  `share_company_percentage` decimal(15, 8) NOT NULL,
  `share_company_value` decimal(15, 8) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
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
  `invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'WD-XXXXXXXX',
  `sequence` bigint UNSIGNED NULL DEFAULT NULL,
  `id_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `amount_1` decimal(15, 8) NULL DEFAULT NULL,
  `amount_2` decimal(15, 8) NULL DEFAULT NULL,
  `currency_1` enum('USDT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'USDT' COMMENT 'USDT',
  `currency_2` enum('BNB.BSC','TRX','LTCT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'BNB.BSC | TRX | LTCT',
  `source` enum('profit_paid','bonus') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'profit | bonus',
  `id_wallet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'uuid',
  `wallet_label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `wallet_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `state` enum('pending','success','cancel') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'pending | success | cancel',
  `tx_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`invoice`) USING BTREE
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
  `contract_duration` int NULL DEFAULT NULL COMMENT 'day',
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sequence` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_package_crypto_asset
-- ----------------------------
INSERT INTO `et_package_crypto_asset` VALUES (1, 'ET-CA-ASH', 'Ashoca', 10000, 365, 'ashoca_logo.png', 1, '2021-06-12 03:33:40', '2021-06-12 03:33:40');
INSERT INTO `et_package_crypto_asset` VALUES (2, 'ET-CA-BOU', 'Bougainvillea', 20000, 365, 'bougainvillea_logo.png', 2, '2021-06-12 03:33:40', '2021-06-12 03:33:40');
INSERT INTO `et_package_crypto_asset` VALUES (3, 'ET-CA-CLO', 'Clover', 30000, 365, 'clover_logo.png', 3, '2021-06-12 03:33:40', '2021-06-12 03:33:40');
INSERT INTO `et_package_crypto_asset` VALUES (4, 'ET-CA-DAH', 'Dahlia', 50000, 365, 'dahlia_logo.png', 4, '2021-06-12 03:33:40', '2021-06-12 03:33:40');
INSERT INTO `et_package_crypto_asset` VALUES (5, 'ET-CA-EDE', 'Edelweiss', 75000, 365, 'edelweiss_logo.png', 5, '2021-06-12 03:33:40', '2021-06-12 03:33:40');

-- ----------------------------
-- Table structure for et_package_crypto_asset_test
-- ----------------------------
DROP TABLE IF EXISTS `et_package_crypto_asset_test`;
CREATE TABLE `et_package_crypto_asset_test`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'ET-ABBR',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount` int NULL DEFAULT NULL COMMENT 'usd',
  `profit_per_month_percent` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `profit_per_month_value` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `profit_per_day_percentage` decimal(15, 8) NULL DEFAULT NULL COMMENT 'decimal 8',
  `profit_per_day_value` decimal(15, 8) NULL DEFAULT NULL,
  `contract_duration` int NULL DEFAULT NULL COMMENT 'day',
  `share_self_percentage` decimal(15, 8) NULL DEFAULT NULL,
  `share_self_value` decimal(15, 8) NULL DEFAULT NULL,
  `share_upline_percentage` decimal(15, 8) NULL DEFAULT NULL,
  `share_upline_value` decimal(15, 8) NULL DEFAULT NULL,
  `share_company_percentage` decimal(15, 8) NULL DEFAULT NULL,
  `share_company_value` decimal(15, 8) NULL DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sequence` int NULL DEFAULT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_package_crypto_asset_test
-- ----------------------------
INSERT INTO `et_package_crypto_asset_test` VALUES (1, 'ET-CA-ASH', 'Ashoca Pack', 1, 15.00000000, 0.15000000, 0.50000000, 0.00500000, 365, 60.00000000, 0.00300000, 20.00000000, 0.00100000, 20.00000000, 0.00100000, 'ashoca_logo.png', 1, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);
INSERT INTO `et_package_crypto_asset_test` VALUES (2, 'ET-CA-BOU', 'Bougainvillea Pack', 2, 15.00000000, 0.30000000, 0.50000000, 0.01000000, 365, 65.00000000, 0.00650000, 17.50000000, 0.00175000, 17.50000000, 0.00175000, 'bougainvillea_logo.png', 2, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);
INSERT INTO `et_package_crypto_asset_test` VALUES (3, 'ET-CA-CLO', 'Clover Pack', 3, 15.00000000, 0.45000000, 0.50000000, 0.01500000, 365, 70.00000000, 0.01050000, 15.00000000, 0.00225000, 15.00000000, 0.00225000, 'clover_logo.png', 3, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);
INSERT INTO `et_package_crypto_asset_test` VALUES (4, 'ET-CA-DAH', 'Dahlia Pack', 5, 15.00000000, 0.75000000, 0.50000000, 0.02500000, 365, 75.00000000, 0.01875000, 12.50000000, 0.00312500, 12.50000000, 0.00312500, 'dahlia_logo.png', 4, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);
INSERT INTO `et_package_crypto_asset_test` VALUES (5, 'ET-CA-EDE', 'Edelweiss Pack', 8, 15.00000000, 1.20000000, 0.50000000, 0.04000000, 365, 80.00000000, 0.03200000, 10.00000000, 0.00400000, 10.00000000, 0.00400000, 'edelweiss_logo.png', 5, 'yes', '2021-06-12 03:33:40', '2021-06-12 03:33:40', NULL);

-- ----------------------------
-- Table structure for et_package_trade_manager
-- ----------------------------
DROP TABLE IF EXISTS `et_package_trade_manager`;
CREATE TABLE `et_package_trade_manager`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'ET-ABBR',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount` int NULL DEFAULT NULL COMMENT 'usd',
  `contract_duration` int NULL DEFAULT NULL COMMENT 'day',
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sequence` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_package_trade_manager
-- ----------------------------
INSERT INTO `et_package_trade_manager` VALUES (1, 'ET-TM-STA', 'Starter', 100, 365, 'starter_logo.png', 1, '2021-06-12 03:06:36', '2021-06-12 03:06:40');
INSERT INTO `et_package_trade_manager` VALUES (2, 'ET-TM-SAP', 'Sapphire', 500, 365, 'sapphire_logo.png', 2, '2021-06-12 03:09:28', '2021-06-12 03:09:31');
INSERT INTO `et_package_trade_manager` VALUES (3, 'ET-TM-RUB', 'Ruby', 1000, 365, 'ruby_logo.png', 3, '2021-06-12 03:10:27', '2021-06-12 03:10:29');
INSERT INTO `et_package_trade_manager` VALUES (4, 'ET-TM-EME', 'Emerald', 5000, 365, 'emerald_logo.png', 4, '2021-06-12 03:11:23', '2021-06-12 03:11:34');
INSERT INTO `et_package_trade_manager` VALUES (5, 'ET-TM-DIA', 'Diamond', 10000, 365, 'diamond_logo.png', 5, '2021-06-12 03:12:35', '2021-06-12 03:12:37');
INSERT INTO `et_package_trade_manager` VALUES (6, 'ET-TM-CRO', 'Crown', 0, 365, 'crown_logo.png', 6, '2021-06-12 03:16:46', '2021-06-12 03:16:49');

-- ----------------------------
-- Table structure for et_package_trade_manager_test
-- ----------------------------
DROP TABLE IF EXISTS `et_package_trade_manager_test`;
CREATE TABLE `et_package_trade_manager_test`  (
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
-- Records of et_package_trade_manager_test
-- ----------------------------
INSERT INTO `et_package_trade_manager_test` VALUES (1, 'ET-TM-STA', 'Starter Pack', 1, 15.00000000, 0.15000000, 0.50000000, 0.00500000, 365, 50.00000000, 0.00250000, 25.00000000, 0.00125000, 25.00000000, 0.00125000, 'starter_logo.png', 1, 'yes', '2021-06-12 03:06:36', '2021-06-12 03:06:40', NULL);
INSERT INTO `et_package_trade_manager_test` VALUES (2, 'ET-TM-SAP', 'Sapphire Pack', 2, 15.00000000, 0.30000000, 0.50000000, 0.01000000, 365, 60.00000000, 0.00600000, 20.00000000, 0.00200000, 20.00000000, 0.00200000, 'sapphire_logo.png', 2, 'yes', '2021-06-12 03:09:28', '2021-06-12 03:09:31', NULL);
INSERT INTO `et_package_trade_manager_test` VALUES (3, 'ET-TM-RUB', 'Ruby Pack', 3, 15.00000000, 0.45000000, 0.50000000, 0.01500000, 365, 70.00000000, 0.01050000, 15.00000000, 0.00225000, 15.00000000, 0.00225000, 'ruby_logo.png', 3, 'yes', '2021-06-12 03:10:27', '2021-06-12 03:10:29', NULL);
INSERT INTO `et_package_trade_manager_test` VALUES (4, 'ET-TM-EME', 'Emerald Pack', 4, 15.00000000, 0.60000000, 0.50000000, 0.02000000, 365, 80.00000000, 0.01600000, 10.00000000, 0.00200000, 10.00000000, 0.00200000, 'emerald_logo.png', 4, 'yes', '2021-06-12 03:11:23', '2021-06-12 03:11:34', NULL);
INSERT INTO `et_package_trade_manager_test` VALUES (5, 'ET-TM-DIA', 'Diamond Pack', 5, 15.00000000, 0.75000000, 0.50000000, 0.02500000, 365, 85.00000000, 0.02125000, 7.50000000, 0.00187500, 7.50000000, 0.00187500, 'diamond_logo.png', 5, 'yes', '2021-06-12 03:12:35', '2021-06-12 03:12:37', NULL);
INSERT INTO `et_package_trade_manager_test` VALUES (6, 'ET-TM-CRO', 'Crown Pack', 0, 15.00000000, 0.00000000, 0.50000000, 0.00000000, 365, 90.00000000, 0.00000000, 5.00000000, 0.00000000, 5.00000000, 0.00000000, 'crown_logo.png', 6, 'yes', '2021-06-12 03:16:46', '2021-06-12 03:16:49', NULL);

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
  `amount_profit_paid` decimal(30, 8) NULL DEFAULT 0.00000000,
  `amount_profit_unpaid` decimal(30, 8) NULL DEFAULT 0.00000000,
  `amount_bonus` decimal(30, 8) NULL DEFAULT 0.00000000,
  `amount_ratu` decimal(30, 8) NULL DEFAULT 0.00000000,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of et_unknown_balance
-- ----------------------------
INSERT INTO `et_unknown_balance` VALUES (1, 0.00000000, 0.00000000, 0.00000000, 0.00000000, '2021-08-16 14:58:19');

SET FOREIGN_KEY_CHECKS = 1;
