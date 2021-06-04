-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 26-Nov-2020 às 14:57
-- Versão do servidor: 5.7.31
-- versão do PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `control_vehicles`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'COMBUSTÍVEL', 'Abastecimento, combustíveis fósseis, combustíveis químicos, biocombustíveis\r\n', '2020-11-12 18:45:58', '2020-11-12 18:45:58'),
(2, 'QUILOMETRAGEM', 'Custo em Km\'s', '2020-11-12 18:45:58', '2020-11-12 18:45:58'),
(3, 'MANUTENÇÃO', 'Serviços de manutenção. Inclui aquisição de peças', '2020-11-13 13:42:59', '2020-11-13 13:42:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `category_expense`
--

DROP TABLE IF EXISTS `category_expense`;
CREATE TABLE IF NOT EXISTS `category_expense` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `expense_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_expense_category_id_foreign` (`category_id`),
  KEY `category_expense_expense_id_foreign` (`expense_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `drivers`
--

DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_driver` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hab` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `drivers`
--

INSERT INTO `drivers` (`id`, `name_driver`, `cpf`, `hab`, `created_at`, `updated_at`) VALUES
(1, 'SEM MOTORISTA', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(10) NOT NULL,
  `name_expense` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unitary_value` decimal(10,2) NOT NULL,
  `amount` int(10) NOT NULL,
  `discount` decimal(4,2) NOT NULL,
  `amount_paid` decimal(10,2) GENERATED ALWAYS AS (((`unitary_value` * `amount`) * (1 - (`discount` / 100)))) VIRTUAL,
  `data` datetime NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_vehicle_id_foreign` (`vehicle_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_04_30_200343_create_vehicles_table', 1),
(5, '2020_05_09_175702_create_solicitacoes_table', 1),
(6, '2020_10_19_111620_create_permissions_table', 1),
(7, '2020_10_19_111733_create_roles_table', 1),
(15, '2020_10_22_105605_create_categories_table', 2),
(16, '2020_10_22_105911_create_expenses_table', 2),
(17, '2020_10_22_110200_create_category_expense_table', 2),
(23, '2020_10_22_125237_create_drivers_table', 3),
(24, '2020_10_22_145004_add_motorista_id_table_vehicles', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('duduvieiramattos@gmail.com', '$2y$10$K/mXMFvQoRag7a3BYvbBPurfVbtg8CSW2FI3EJ1xGSZcBomiHpWIW', '2020-11-09 21:13:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'Request', 'Solicita Veículo', NULL, NULL),
(2, 'Edit Request', 'Edita solicitação Pendente', NULL, NULL),
(3, 'Delete Request', 'Deleta solicitação Pendente', NULL, NULL),
(4, 'Authorize Request', 'Autoriza solicitações', NULL, NULL),
(5, 'Manages expenses', 'Administra despesas(Cadastra, edita e deleta categorias. Cadastra, edita e deleta custo)', NULL, NULL),
(6, 'Manages drivers', 'Administra motoristas(Cadastra, edita e deleta motoristas)', NULL, NULL),
(7, 'Manages sectors', 'Administra setores', NULL, NULL),
(8, 'Access reports', 'Visualiza e exporta relatórios do sistema.', NULL, NULL),
(9, 'View ADM dashboard', 'Visualiza Dashboard com informações para o ADM', NULL, NULL),
(10, 'View USER dashboard', 'Visualiza Dashboard com informações para o USER', NULL, NULL),
(11, 'Manages Users', 'Cadastra, edita e deleta usuário.', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`) VALUES
(48, 4, 1),
(49, 4, 2),
(50, 1, 1),
(51, 2, 1),
(52, 3, 1),
(53, 5, 1),
(54, 6, 1),
(55, 7, 1),
(56, 8, 1),
(57, 9, 1),
(58, 11, 1),
(59, 1, 2),
(60, 2, 2),
(61, 3, 2),
(62, 5, 2),
(63, 6, 2),
(64, 7, 2),
(65, 8, 2),
(66, 9, 2),
(67, 1, 3),
(68, 2, 3),
(69, 3, 3),
(70, 8, 3),
(71, 10, 3),
(72, 1, 4),
(73, 2, 4),
(74, 3, 4),
(75, 10, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'SUPER ADM', 'Infraestrutura, administrador geral. Nível 1.', NULL, NULL),
(2, 'ADM', 'Serviços Gerais, administrador de frota. Nível 2.', NULL, NULL),
(3, 'MANAGER', 'Gestores Administrativos, ADM Financeiro, ADM Custos, etc. Nível 3.', NULL, NULL),
(4, 'USER REQUEST', 'Gestores de setor ou responsáveis autorizados, responsáveis por solicitar frota. Nível 4', NULL, NULL),
(0, 'NO ROLE', 'Usuário sem permissões', '2020-10-26 19:40:07', '2020-10-26 19:40:07');

-- --------------------------------------------------------

--
-- Estrutura da tabela `role_user`
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  KEY `role_user_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `updated_at`, `created_at`) VALUES
(25, 1, 1, '2020-10-30 20:09:52', '2020-10-30 20:09:52');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sectors`
--

DROP TABLE IF EXISTS `sectors`;
CREATE TABLE IF NOT EXISTS `sectors` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `cc` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `sectors`
--

INSERT INTO `sectors` (`id`, `cc`, `sector`) VALUES
(1, '00', 'CENTRO CIRURGICO'),
(2, '002', 'NAC NIR'),
(3, '003', 'TERAPIA OCUPACIONAL'),
(4, '004', 'ESTOMATERAPIA'),
(5, '005', 'CUIDADO PALIATIVO'),
(6, '006', 'GERENCIA DE RISCOS'),
(7, '01', 'UNIDADE DE INTERNAMENTO A EMERGENCIA'),
(8, '02', 'AMBULATORIO'),
(9, '03', 'CONSULTORIOS'),
(10, '04', 'UNIDADE TERAPIA INTENSIVA'),
(11, '05', 'PAD - PROGRAMA DE ATENDIMENTO DOMICILIAR'),
(12, '06', 'LABORATORIO'),
(13, '07', 'IMAGENOLOGIA'),
(14, '08', 'FISIOTERAPIA'),
(15, '09', 'SERVICO SOCIAL'),
(16, '10', 'NUTRICAO'),
(17, '11', 'CENTRO DE MATERIAL'),
(18, '12', 'FARMACIA'),
(19, '13', 'ROUPARIA'),
(20, '14', 'OUVIDORIA'),
(21, '15', 'CENTRO DE ESTUDOS'),
(22, '16', '(CCIH) COMISSAO DE CONTROLE DE INFECCAO HOSPITALAR'),
(23, '17', 'SAME'),
(24, '18', '(UVE) UNIDADE DE VIGILANCIA EPIDEMIOLOGICA'),
(25, '19', 'EDUCACAO CONTINUADA'),
(26, '20', 'ENFERMAGEM'),
(27, '21', 'CONTAS MEDICAS'),
(28, '22', 'SERVICOS GERAIS'),
(29, '23', 'ALMOXARIFADO GERAL'),
(30, '24', 'SECAO DE DESENVOLVIMENTO DE PESSOAS'),
(31, '25', 'NUCLEO DE CUSTOS'),
(32, '26', 'LICITACAO'),
(33, '27', '(NTIC) INFORMATICA'),
(34, '28', 'CONTABILIDADE'),
(35, '29', 'SETOR PESSOAL'),
(36, '30', 'ADMINISTRACAO GERAL'),
(37, '31', 'UNIDADE DE INTERNAMENTO B'),
(38, '32', 'UNIDADE DE NTERNAMENTO C'),
(39, '33', 'UNIDADE DE INTERNAMENTO D'),
(40, '34', 'UNIDADE DE INTERNAMENTO E'),
(41, '35', 'UNIDADE DE INTERNAMENTO F'),
(42, '36', 'DIRECAO CLINICA'),
(43, '37', 'DIRECAO TECNICA'),
(44, '38', 'DIRECAO ADMINISTRATIVA E FINANCEIRA'),
(45, '39', 'HOSPITAL DIA'),
(46, '40', 'ALMOXARIFADO MATERIAL HOSPITALAR'),
(47, '41', 'LIMPEZA'),
(48, '42', '(ASDIN) ACESSORIA E DESENVOLVIMENTO INSTITUCIONAL'),
(49, '43', 'AGENCIA TRANFUSIONAL'),
(50, '44', 'ENDOSCOPIA'),
(51, '45', 'RECEPCAO'),
(52, '46', 'VIGILANCIA'),
(53, '47', 'TRANSPORTE'),
(54, '48', 'MANUTENCAO'),
(55, '49', 'ASSESSORIA DE COMUNICACAO'),
(56, '50', 'REPROGRAFIA'),
(57, '51', 'PABX');

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacoes`
--

DROP TABLE IF EXISTS `solicitacoes`;
CREATE TABLE IF NOT EXISTS `solicitacoes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `namesolicitante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nameramal` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nameroteiro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namefinalidade` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datahorasaida` datetime NOT NULL,
  `datahoraretorno` datetime DEFAULT NULL,
  `nameusuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `veiculo` int(12) NOT NULL,
  `datahorasaidaautorizada` datetime DEFAULT NULL,
  `datahoraretornoautorizada` datetime DEFAULT NULL,
  `kminicial` int(11) DEFAULT NULL,
  `kmfinal` int(11) DEFAULT NULL,
  `kmtotal` int(11) GENERATED ALWAYS AS ((`kmfinal` - `kminicial`)) VIRTUAL,
  `autorizacao` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` date NOT NULL,
  `statussolicitacao` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `solicitacoes_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sector_id` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `sector_id` (`sector_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `sector_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '27', 'teste', 'teste@teste.com', NULL, '$2y$10$OBf0swSbByJNFMOJ1RetYu0nDbb4I2d7MY4tNQ/g4VQUG4em8QHpS', 'nPgIvwGOYKcey4JFY231nxDVQd5RHUygkNu59RXDhVCBYWckBgbAZfHdhORM', '2020-10-19 16:50:50', '2020-11-26 17:47:31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `brand` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `placa` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int(10) UNSIGNED NOT NULL,
  `km` int(12) NOT NULL,
  `situacao` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicles_placa_unique` (`placa`),
  KEY `vehicles_driver_id_foreign` (`driver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `vehicles`
--

INSERT INTO `vehicles` (`id`, `driver_id`, `brand`, `model`, `placa`, `year`, `km`, `situacao`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gerador', '-', '-', 2020, 0, 'EM USO', 'Gerador de energia. Manter situação \"EM USO\"', '2020-11-03 11:51:42', '2020-11-03 11:51:42'),
(2, 1, 'Não atribuído', ' ', ' ', 2020, 0, 'null', 'Opção para viagens perdidas. Manter situação \"null\"', '2020-11-03 13:01:06', '2020-11-03 13:01:06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
