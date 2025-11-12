-- Script de criação do banco e tabelas para o projeto
-- Arquivo: bd/bd_events_create.sql
-- Gera o banco de dados `bd_events` com as tabelas `users` e `events`.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@OLD_COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Criar banco
CREATE DATABASE IF NOT EXISTS `bd_events` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_events`;

-- Tabela: users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `last_attempt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `access_count` int(11) DEFAULT 0,
  `is_first_login` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela: events
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `type` enum('show','standup') NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `capacity` int(6) DEFAULT NULL,
  `local_address` varchar(255) DEFAULT NULL,
  `local_lat` double DEFAULT NULL,
  `local_lng` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados de exemplo (substitua senhas por hash real conforme necessário)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `failed_attempts`, `last_attempt`, `access_count`, `is_first_login`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$so8ddiaXnzrW5PErjvQJvem5UDIax1L.Yvo8yiEeIpK29SURNJS9q', 0, '2025-11-06 14:55:40', 1, 0);

INSERT INTO `events` (`id`, `title`, `description`, `date`, `type`, `image`, `capacity`, `local_address`, `local_lat`, `local_lng`) VALUES
(1, 'Show de Rock', 'Banda XYZ em ação com hits clássicos!', '2023-12-01 20:00:00', 'show', 'images/show1.jpg', NULL, NULL, NULL, NULL),
(2, 'Stand-Up Comedy', 'Comediante ABC trazendo risadas inesquecíveis.', '2023-12-05 19:00:00', 'standup', 'images/standup1.jpg', NULL, NULL, NULL, NULL);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Como importar (PowerShell):
-- 1) Criar banco (se necessário):
-- & 'C:\xampp\mysql\bin\mysql.exe' -u root -p -e "CREATE DATABASE IF NOT EXISTS bd_events CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
-- 2) Importar o script:
-- & 'C:\xampp\mysql\bin\mysql.exe' -u root -p bd_events < "C:\xampp\htdocs\webapp\bd\bd_events_create.sql"
