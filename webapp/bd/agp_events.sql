
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agp_events`
--

-- Banco de dados: `bd_events`


-- --------------------------------------------------------

--
-- Estrutura para tabela `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `type` enum('show','standup') NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `capacity` int(6) DEFAULT NULL,
  `local_address` varchar(255) DEFAULT NULL,
  `local_lat` double DEFAULT NULL,
  `local_lng` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`, `type`, `image`, `capacity`, `local_address`, `local_lat`, `local_lng`) VALUES
(1, 'Show de Rock', 'Banda XYZ em ação com hits clássicos!', '2023-12-01 20:00:00', 'show', 'images/show1.jpg', NULL, NULL, NULL, NULL),
(2, 'Stand-Up Comedy', 'Comediante ABC trazendo risadas inesquecíveis.', '2023-12-05 19:00:00', 'standup', 'images/standup1.jpg', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `last_attempt` timestamp NOT NULL DEFAULT current_timestamp(),
  `access_count` int(11) DEFAULT 0,
  `is_first_login` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `failed_attempts`, `last_attempt`, `access_count`, `is_first_login`) VALUES
(6, 'thur7', 'thur7@gmail.com', '$2y$10$so8ddiaXnzrW5PErjvQJvem5UDIax1L.Yvo8yiEeIpK29SURNJS9q', 0, '2025-11-06 14:55:40', 1, 0);

--
-- Índices para tabelas despejadas
--

--
-- Arquivo antigo: agp_events.sql
-- OBS: Este arquivo foi mantido apenas como referência histórica.
-- O projeto agora usa um único script canônico: bd/bd_events_create.sql
-- Você pode excluir este arquivo com segurança se já tiver o banco criado/importado
-- (A migração/estrutura completa está em bd/bd_events_create.sql)
