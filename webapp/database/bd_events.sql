-- ================================================
-- AGP Events - Script Completo de Banco de Dados
-- ================================================
-- Este script cria toda a estrutura necessária para
-- a plataforma de eventos AGP Events.
--
-- Banco: bd_events
-- Versão: 1.0
-- Última atualização: 13 de novembro de 2025
-- ================================================

-- DROP DATABASE IF EXISTS bd_events;
-- CREATE DATABASE IF NOT EXISTS bd_events;
-- USE bd_events;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ========== TABELA: users ==========
-- Armazena informações de autenticação e controle de acesso

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `failed_attempts` int(11) DEFAULT 0 COMMENT 'Contador de tentativas falhadas de login',
  `last_attempt` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Último login (sucesso ou falha)',
  `access_count` int(11) DEFAULT 0 COMMENT 'Total de logins bem-sucedidos',
  `is_first_login` tinyint(1) DEFAULT 1 COMMENT 'Indica se é o primeiro acesso (força alteração de senha)',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========== TABELA: events ==========
-- Armazena informações dos eventos

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL COMMENT 'Título do evento',
  `description` text COMMENT 'Descrição detalhada do evento',
  `date` datetime NOT NULL COMMENT 'Data e hora do evento',
  `type` enum('show','standup','palestra','workshop','conferencia') NOT NULL DEFAULT 'show' COMMENT 'Tipo/categoria do evento',
  `image` varchar(255) COMMENT 'Caminho da imagem do evento',
  `capacity` int(6) COMMENT 'Capacidade máxima de pessoas',
  `local_address` varchar(255) COMMENT 'Endereço do local do evento',
  `local_lat` double COMMENT 'Latitude da localização (Google Maps)',
  `local_lng` double COMMENT 'Longitude da localização (Google Maps)',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_date` (`date`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========== DADOS DE TESTE ==========

-- Usuário de teste
-- Username: admin
-- Password: admin123 (hash: $2y$10$so8ddiaXnzrW5PErjvQJvem5UDIax1L.Yvo8yiEeIpK29SURNJS9q)
INSERT INTO `users` (`username`, `email`, `password`, `is_first_login`, `access_count`) 
VALUES ('admin', 'admin@agpevents.local', '$2y$10$so8ddiaXnzrW5PErjvQJvem5UDIax1L.Yvo8yiEeIpK29SURNJS9q', 0, 1)
ON DUPLICATE KEY UPDATE `access_count` = `access_count`;

-- Eventos de teste
INSERT INTO `events` (`title`, `description`, `date`, `type`, `capacity`, `local_address`, `local_lat`, `local_lng`) 
VALUES 
(
  'Show de Rock - Banda XYZ',
  'Prepare-se para uma noite inesquecível com a banda XYZ tocando seus maiores sucessos! Um show imperdível com toda a energia e emoção que você espera.',
  '2025-12-15 20:00:00',
  'show',
  500,
  'Espaço das Artes, São Paulo, SP',
  -23.5505,
  -46.6333
),
(
  'Stand-Up Comedy - Noite de Risos',
  'Comediante ABC apresenta seu novo especial cheio de humor, crítica social e muita zoação. Prepare a barriguinha para rir!',
  '2025-12-10 19:30:00',
  'standup',
  200,
  'Teatro Municipal, Rio de Janeiro, RJ',
  -22.9068,
  -43.1729
),
(
  'Palestra: Tendências em Tecnologia 2026',
  'Especialistas do setor discutem as principais tendências e inovações que vão marcar 2026. Aprenda com os melhores do mercado.',
  '2025-12-20 14:00:00',
  'palestra',
  300,
  'Centro de Convenções, Belo Horizonte, MG',
  -19.8267,
  -43.9449
),
(
  'Workshop: Desenvolvimento Web Avançado',
  'Workshop prático de 4 horas onde você aprenderá técnicas avançadas de desenvolvimento web com React e Node.js.',
  '2025-12-22 09:00:00',
  'workshop',
  50,
  'Campus da Universidade Federal, Brasília, DF',
  -15.7942,
  -47.8822
)
ON DUPLICATE KEY UPDATE `updated_at` = CURRENT_TIMESTAMP;

-- ========== FIM DO SCRIPT ==========

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
COMMIT;
