/*
 Navicat Premium Data Transfer

 Source Server         : Docker - MariaDB
 Source Server Type    : MySQL
 Source Server Version : 100309
 Source Host           : 172.17.0.2:3306
 Source Schema         : lojavirtualdb

 Target Server Type    : MySQL
 Target Server Version : 100309
 File Encoding         : 65001

 Date: 10/09/2018 00:58:37
*/


CREATE DATABASE lojavirtualdb;
USE lojavirtualdb;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for caracteristicas
-- ----------------------------
DROP TABLE IF EXISTS `caracteristicas`;
CREATE TABLE `caracteristicas`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ativo` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Verifica se esta ativo: 1 - Ativo / 2 - Inativo',
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of caracteristicas
-- ----------------------------
INSERT INTO `caracteristicas` VALUES (1, 2, 'Branco', '2018-09-04 03:35:06', '2018-09-04 03:35:06');
INSERT INTO `caracteristicas` VALUES (2, 1, 'Preto', '2018-09-04 03:37:48', '2018-09-04 03:37:48');
INSERT INTO `caracteristicas` VALUES (3, 1, 'Móveis', '2018-09-04 03:38:15', '2018-09-04 03:38:15');
INSERT INTO `caracteristicas` VALUES (4, 1, 'marrom', '2018-09-04 03:38:32', '2018-09-04 03:38:32');
INSERT INTO `caracteristicas` VALUES (5, 1, 'Smart TV', '2018-09-04 03:38:49', '2018-09-04 03:38:49');
INSERT INTO `caracteristicas` VALUES (6, 1, 'LED', '2018-09-04 03:39:21', '2018-09-04 03:39:21');
INSERT INTO `caracteristicas` VALUES (7, 1, 'Plástico', '2018-09-04 03:40:19', '2018-09-04 03:40:19');
INSERT INTO `caracteristicas` VALUES (8, 1, 'Ferro', '2018-09-04 03:40:29', '2018-09-04 03:40:29');
INSERT INTO `caracteristicas` VALUES (9, 1, 'Samsung', '2018-09-04 03:40:45', '2018-09-04 03:40:45');
INSERT INTO `caracteristicas` VALUES (10, 1, 'LG', '2018-09-04 03:40:52', '2018-09-04 03:40:52');
INSERT INTO `caracteristicas` VALUES (11, 1, 'HP', '2018-09-04 03:41:19', '2018-09-04 03:41:19');
INSERT INTO `caracteristicas` VALUES (12, 1, 'Notebook', '2018-09-04 03:44:20', '2018-09-04 03:55:56');
INSERT INTO `caracteristicas` VALUES (13, 1, 'Dell', '2018-09-09 17:11:59', '2018-09-09 17:11:59');
INSERT INTO `caracteristicas` VALUES (14, 1, 'Multimídea', '2018-09-09 17:12:18', '2018-09-09 17:12:18');

-- ----------------------------
-- Table structure for carrinhos
-- ----------------------------
DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE `carrinhos`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Verifica o status: 1 - Em andamento / 2 - Finalizado',
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `dt_finalizado` datetime(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `entrega` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `carrinhos_id_user_foreign`(`id_user`) USING BTREE,
  CONSTRAINT `carrinhos_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of carrinhos
-- ----------------------------
INSERT INTO `carrinhos` VALUES (1, 2, 2, 328.12, '2018-09-10 03:52:41', '2018-09-09 18:55:43', '2018-09-10 03:52:41', 'SQS 205 Bloco I apto 204');
INSERT INTO `carrinhos` VALUES (2, 2, 2, 45.00, '2018-09-10 03:55:43', '2018-09-10 03:55:35', '2018-09-10 03:55:43', 'SQS 205 Bloco I apto 204');

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ativo` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Verifica se a categoria esta ativa: 1 - Ativa / 2 - Inativa',
  `tipo` int(11) NOT NULL COMMENT 'Tipo de Link: 1-Cat Pai / 2-SubCategoria',
  `id_cat_pai` int(10) UNSIGNED NULL DEFAULT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `categorias_id_cat_pai_foreign`(`id_cat_pai`) USING BTREE,
  CONSTRAINT `categorias_id_cat_pai_foreign` FOREIGN KEY (`id_cat_pai`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES (1, 1, 1, NULL, 'Eletronicos', '2018-09-02 20:12:02', '2018-09-02 20:12:02');
INSERT INTO `categorias` VALUES (3, 1, 1, NULL, 'Cozinha', '2018-09-02 20:20:24', '2018-09-02 20:20:24');
INSERT INTO `categorias` VALUES (8, 1, 2, 14, 'Mouse', '2018-09-02 21:18:04', '2018-09-03 03:44:25');
INSERT INTO `categorias` VALUES (13, 1, 1, NULL, 'Escritório', '2018-09-03 03:39:44', '2018-09-03 03:39:44');
INSERT INTO `categorias` VALUES (14, 1, 1, NULL, 'Informática', '2018-09-03 03:43:51', '2018-09-03 03:43:51');
INSERT INTO `categorias` VALUES (15, 1, 2, 14, 'Teclado', '2018-09-05 03:09:20', '2018-09-05 03:09:20');
INSERT INTO `categorias` VALUES (16, 1, 2, 13, 'Luminária', '2018-09-05 03:09:50', '2018-09-05 03:09:50');
INSERT INTO `categorias` VALUES (17, 1, 1, NULL, 'Banheiro', '2018-09-05 03:10:58', '2018-09-05 03:10:58');
INSERT INTO `categorias` VALUES (18, 1, 2, 17, 'Ducha de Banho', '2018-09-05 03:11:46', '2018-09-05 03:11:46');

-- ----------------------------
-- Table structure for lista_carrinhos
-- ----------------------------
DROP TABLE IF EXISTS `lista_carrinhos`;
CREATE TABLE `lista_carrinhos`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_carrinho` int(10) UNSIGNED NOT NULL,
  `id_prod` int(10) UNSIGNED NOT NULL,
  `qde` int(11) NULL DEFAULT NULL,
  `preco` decimal(10, 2) NULL DEFAULT NULL,
  `preco_total` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `lista_carrinhos_id_carrinho_foreign`(`id_carrinho`) USING BTREE,
  INDEX `lista_carrinhos_id_prod_foreign`(`id_prod`) USING BTREE,
  CONSTRAINT `lista_carrinhos_id_carrinho_foreign` FOREIGN KEY (`id_carrinho`) REFERENCES `carrinhos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `lista_carrinhos_id_prod_foreign` FOREIGN KEY (`id_prod`) REFERENCES `produtos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lista_carrinhos
-- ----------------------------
INSERT INTO `lista_carrinhos` VALUES (1, 1, 12, 1, 188.12, 188.12, '2018-09-09 18:55:43', '2018-09-09 18:55:43');
INSERT INTO `lista_carrinhos` VALUES (2, 1, 13, 2, 70.00, 140.00, '2018-09-09 18:55:46', '2018-09-09 18:56:16');
INSERT INTO `lista_carrinhos` VALUES (3, 2, 9, 1, 45.00, 45.00, '2018-09-10 03:55:35', '2018-09-10 03:55:35');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (9, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (10, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (12, '2018_09_02_015815_create_categorias_table', 2);
INSERT INTO `migrations` VALUES (13, '2018_09_04_030616_create_caracteristicas_table', 3);
INSERT INTO `migrations` VALUES (16, '2018_09_04_035132_create_produtos_table', 4);
INSERT INTO `migrations` VALUES (17, '2018_09_05_042836_vin_prod_carac', 4);
INSERT INTO `migrations` VALUES (18, '2018_09_05_210747_vin_prod_categ', 5);
INSERT INTO `migrations` VALUES (21, '2018_09_07_203604_create_carrinhos_table', 6);
INSERT INTO `migrations` VALUES (22, '2018_09_07_211937_create_lista_carrinhos_table', 6);
INSERT INTO `migrations` VALUES (23, '2018_09_09_183540_update_carrinhos_table', 6);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for produtos
-- ----------------------------
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ativo` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Verifica se esta ativo: 1 - Ativo / 2 - Inativo',
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `preco` decimal(10, 2) NOT NULL,
  `url_imagem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produtos
-- ----------------------------
INSERT INTO `produtos` VALUES (5, 1, 'TV 40', 3599.80, '5.jpeg', 'testando', '2018-09-05 21:56:06', '2018-09-07 05:00:46');
INSERT INTO `produtos` VALUES (7, 1, 'Mesa para Escritório', 310.10, '7.jpeg', 'rests', '2018-09-07 01:59:15', '2018-09-08 20:40:11');
INSERT INTO `produtos` VALUES (9, 1, 'Pilha A4', 45.00, '9.jpeg', 'rests', '2018-09-07 02:11:49', '2018-09-08 17:58:13');
INSERT INTO `produtos` VALUES (10, 1, 'Caneta Azul', 10.00, '10.jpeg', 'Somente  Caracteríticas do Produto\r\n\r\n\r\nA caneta que é sinônimo de qualidade conhecida no mundo inteiro!\r\nCorpo hexagonal que assegura o conforto na escrita e transparente para visualização da tinta\r\nTinta de alta qualidade, que seca rapidamente evitando borrões na escrita.\r\nDurabilidade: Escreve até 2 Km\r\nEscrita macia\r\n\r\n\r\nA BIC e o Meio Ambiente\r\nProduto fabricado com a quantidade certa de matéria-prima para uso prolongado e seguro\r\nNão contém PVC.\r\n\r\n\r\nEspecificações\r\nPonta média de 1 mm, largura da linha 0,4mm\r\nTampa e plug da mesma cor da tinta.\r\nTampa ventilada em conformidade com padrão ISO\r\nBola de Tungstênio, esfera perfeita e muito resistente.\r\n\r\n\r\nEmbalagem\r\nContém 50 unidades na cor azul', '2018-09-08 06:40:06', '2018-09-08 06:40:06');
INSERT INTO `produtos` VALUES (11, 1, 'Sofá Cama - Arizon', 1280.00, '11.jpeg', 'Cor 	Cinza\r\nGarantia 	3 Meses\r\nConteúdo da Embalagem 	1 Sofá-Cama\r\nModelo 	Premium\r\nMaterial 	Estrutura em madeira de reflorestamento (eucalipto e pinus) seca e tratada, chapas de OSB com sistemas flexíveis compostos por percintas elásticas, assento espuma D33, encosto espuma D26, manta de poliéster siliconizada e revestimento em tecido suede.\r\nDescrição do Tamanho 	Aberto: Altura 88 cm Largura 190 cm Profundidade 96 cm/ Fechado: Altura 46 cm Largura 190 cm Profundidade 120 cm\r\nNecessita Montagem? 	Não\r\nEstrutura do Assento 	Espuma\r\nPeso suportado pelo produto (kg) 	120.00', '2018-09-08 06:42:05', '2018-09-08 06:42:05');
INSERT INTO `produtos` VALUES (12, 1, 'Mouse Gamer', 188.12, '12.jpeg', 'Características:\r\n\r\n- Marca: Razer\r\n\r\n- Modelo: RZ01-00940100-R3M1 \r\n\r\n \r\n\r\nEspecificações:\r\n\r\n- Sensor Óptico: 6400 dpi 4G\r\n\r\n- Cor: Preto\r\n\r\n- Iluminação Laranja\r\n\r\n- Scroll vertical\r\n\r\n- Interface USB 2.0\r\n\r\n- 3 Botões Personalizáveis tipo Hyperresponse\r\n\r\n- Pezinhos de teflon (PTFE)\r\n\r\n- Compatível com Windows e Mac\r\n\r\n- Extremamente rápido: até 200\"/s e 50g\r\n\r\n- Ultrapolling de 1.000Hz e tempo de resposta de 1ms\r\n\r\n \r\n\r\nConteúdo da Embalagem:\r\n\r\n- 01 Mouse Gamer Krait\r\n\r\n\r\n\r\nGarantia\r\n12 meses de garantia\r\n\r\nPeso\r\n320 gramas (bruto com embalagem)', '2018-09-08 16:29:05', '2018-09-08 16:29:05');
INSERT INTO `produtos` VALUES (13, 1, 'Teclado Gamer', 70.00, '13.jpeg', 'Teclado com fio para uso diário no escritório e em casa\r\n\r\nO teclado com fio da Dell fornece uma solução de teclado conveniente para uso diário no escritório e em casa. O layout completo do teclado com teclas tipo chiclete permite digitação confortável e eficiente, o que é excelente para uso diário em praticamente qualquer tarefa que você esteja fazendo.\r\n\r\nTeclas multimídia para ações e comandos rápidos\r\n\r\nAs teclas multimídia convenientes permitem que você acesse funções com facilidade, como reproduzir, pausar, voltar e avançar além de controlar o volume.\r\n\r\nDesign confortável e centralizado\r\n\r\nCom um design compacto, porém de tamanho normal e ainda com um teclado numérico, o teclado com fio da Dell é ideal para ambientes domésticos e uso em escritórios. Com uma estrutura durável e teclas silenciosas, foi projetado com o objetivo de fornecer conforto para as demandas diárias do uso de desktops. O teclado com fio da Dell também tem um apoio para as mãos que pode ser comprado separadamente.', '2018-09-09 17:11:34', '2018-09-09 17:19:16');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ativo` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Verifica se o Usuario esta ativo: 1 - Ativo / 2 - Inativo',
  `perfil` int(11) NOT NULL DEFAULT 2 COMMENT 'Tipo de Perfil: 1 - Administrador / 2 - Usuario',
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cep` int(11) NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 1, 1, 'Administrador para Teste', 'admin@teste.com', '$2y$10$sElcW12jQKlwqG8xa5pD5Ojj7mZCyHT8dz28BuWe7iVXYuCCyXSZ2', '0tN8V!%.Qo$h-xEElQeO$VD', NULL, NULL, 'Qd0SfnvsI2B3k33oKS3f8Qsow2C9MNJdqSwUa8DsxVy2GQyoWhHz6r86eEAI', '2018-09-01 23:38:54', '2018-09-01 23:38:54');
INSERT INTO `users` VALUES (2, 1, 2, 'Teste Usuario', 'teste@teste.com', '$2y$10$YZJZDhU9fa2QCpLaBF7XFeozbclWPH0lvi60B5zihFIq31qRqf/Xu', '@lkM-vMDwKC-wfipNW', 'SQS 205 Bloco I apto 204', NULL, 'EsyWOqY3iFeKJMjFpc1xlrBTuhDkukh5HBEIelAOPws9mJMBjZhyFJ0KBmg1', '2018-09-02 00:55:55', '2018-09-10 03:30:20');
INSERT INTO `users` VALUES (3, 1, 2, 'Joao Usuario Teste', 'joao@teste.com', '$2y$10$qF71gSvV05JZS.tc76oKPu9xdzzpWEq66i8iMgZQHHc9.84VQrhFO', '4Qbvrxstc&Dh/uSPnuCaD1PDk&l?r5#fqaHDF6+bJA1Te@dTun0&1J/i?8kp2e', 'SHIN Teste endereco do joao', 71515413, NULL, '2018-09-04 02:21:21', '2018-09-04 02:31:33');
INSERT INTO `users` VALUES (5, 1, 2, 'carlos H morcelli', 'carlos@teste.com', '$2y$10$lciYr5fXN/7A08ixfblAVOcIhc.ugdCkw16SVhmwVdWhp.923Gs.e', 'sjTX10PS.edxs3N7$41se/zJG!gnrb!lEI#F%lBB1R$CZSnbb%b1Hu?msL*%BnJfV/doh!Ri+', 'Moro em Taguatinga nas Qna 18 não atualmente', 71000000, 'VJklrsettrOhpdDT3mTp0LQy9XWqwzRDnHopO1gjWOKE0RHbsi9diJPN2dGc', '2018-09-04 02:32:33', '2018-09-04 02:32:33');

-- ----------------------------
-- Table structure for vin_prod_carac
-- ----------------------------
DROP TABLE IF EXISTS `vin_prod_carac`;
CREATE TABLE `vin_prod_carac`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_prod` int(10) UNSIGNED NOT NULL,
  `id_carac` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `vin_prod_carac_id_prod_foreign`(`id_prod`) USING BTREE,
  INDEX `vin_prod_carac_id_carac_foreign`(`id_carac`) USING BTREE,
  CONSTRAINT `vin_prod_carac_id_carac_foreign` FOREIGN KEY (`id_carac`) REFERENCES `caracteristicas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `vin_prod_carac_id_prod_foreign` FOREIGN KEY (`id_prod`) REFERENCES `produtos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 123 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vin_prod_carac
-- ----------------------------
INSERT INTO `vin_prod_carac` VALUES (105, 7, 4, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (106, 7, 3, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (107, 9, 10, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (108, 9, 2, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (109, 10, 2, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (110, 11, 8, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (111, 11, 4, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (112, 11, 3, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (113, 12, 11, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (114, 12, 6, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (115, 12, 2, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (116, 13, 13, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (117, 13, 14, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (118, 5, 8, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (119, 5, 6, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (120, 5, 4, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (121, 5, 3, NULL, NULL);
INSERT INTO `vin_prod_carac` VALUES (122, 5, 5, NULL, NULL);

-- ----------------------------
-- Table structure for vin_prod_categ
-- ----------------------------
DROP TABLE IF EXISTS `vin_prod_categ`;
CREATE TABLE `vin_prod_categ`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_prod` int(10) UNSIGNED NOT NULL,
  `id_categ` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `vin_prod_categ_id_prod_foreign`(`id_prod`) USING BTREE,
  INDEX `vin_prod_categ_id_categ_foreign`(`id_categ`) USING BTREE,
  CONSTRAINT `vin_prod_categ_id_categ_foreign` FOREIGN KEY (`id_categ`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `vin_prod_categ_id_prod_foreign` FOREIGN KEY (`id_prod`) REFERENCES `produtos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 77 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vin_prod_categ
-- ----------------------------
INSERT INTO `vin_prod_categ` VALUES (67, 7, 13, NULL, NULL);
INSERT INTO `vin_prod_categ` VALUES (68, 9, 1, NULL, NULL);
INSERT INTO `vin_prod_categ` VALUES (69, 10, 13, NULL, NULL);
INSERT INTO `vin_prod_categ` VALUES (70, 11, 13, NULL, NULL);
INSERT INTO `vin_prod_categ` VALUES (71, 12, 14, NULL, NULL);
INSERT INTO `vin_prod_categ` VALUES (72, 12, 8, NULL, NULL);
INSERT INTO `vin_prod_categ` VALUES (73, 13, 14, NULL, NULL);
INSERT INTO `vin_prod_categ` VALUES (74, 13, 15, NULL, NULL);
INSERT INTO `vin_prod_categ` VALUES (75, 5, 1, NULL, NULL);
INSERT INTO `vin_prod_categ` VALUES (76, 5, 13, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
