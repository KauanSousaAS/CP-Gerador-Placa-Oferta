-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/11/2025 às 20:56
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_pdo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_filial`
--

CREATE TABLE `tb_filial` (
  `id_filial` int(11) NOT NULL,
  `filial` char(2) NOT NULL,
  `uf` char(2) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_filial`
--

INSERT INTO `tb_filial` (`id_filial`, `filial`, `uf`, `status`) VALUES
(1, 'CP', 'PR', 1),
(2, 'RD', 'PR', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_filial_produto`
--

CREATE TABLE `tb_filial_produto` (
  `fk_produto` int(11) NOT NULL,
  `fk_filial` int(11) NOT NULL,
  `ultimo_exibir` datetime NOT NULL,
  `estoque_filial` int(10) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_filial_produto`
--

INSERT INTO `tb_filial_produto` (`fk_produto`, `fk_filial`, `ultimo_exibir`, `estoque_filial`, `status`) VALUES
(10, 1, '2025-09-25 14:24:01', 0, 1),
(12, 1, '2025-09-25 14:24:04', 0, 1),
(11, 1, '2025-09-25 14:24:09', 0, 1),
(10, 2, '2025-09-29 14:33:54', 0, 1),
(11, 2, '2025-09-29 14:33:57', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_item`
--

CREATE TABLE `tb_item` (
  `codigo` int(5) NOT NULL,
  `fk_produto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_item`
--

INSERT INTO `tb_item` (`codigo`, `fk_produto`) VALUES
(15264, 12),
(11111, 13),
(22222, 14),
(33333, 15),
(44444, 15),
(55555, 16),
(62625, 11),
(15966, 10),
(15263, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_log`
--

CREATE TABLE `tb_log` (
  `id_log` int(11) NOT NULL,
  `fk_produto` int(11) NOT NULL,
  `fk_usuario` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `data_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_preco`
--

CREATE TABLE `tb_preco` (
  `preco` float(10,2) NOT NULL,
  `quantidade` int(3) NOT NULL,
  `uf` char(2) NOT NULL,
  `fk_produto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_preco`
--

INSERT INTO `tb_preco` (`preco`, `quantidade`, `uf`, `fk_produto`) VALUES
(230.90, 1, 'PR', 12),
(250.90, 1, 'MS', 12),
(1.00, 1, 'MS', 13),
(1.00, 1, 'MS', 15),
(1.00, 1, 'MS', 16),
(111.11, 11, 'PR', 13),
(444.44, 449, 'PR', 15),
(555.55, 55, 'PR', 16),
(55.90, 1, 'PR', 14),
(52.90, 5, 'PR', 14),
(49.90, 10, 'PR', 14),
(65.90, 1, 'MS', 14),
(62.90, 5, 'MS', 14),
(59.90, 10, 'MS', 14),
(100.00, 1, 'PR', 11),
(110.00, 1, 'MS', 11),
(95.00, 5, 'PR', 11),
(105.00, 5, 'MS', 11),
(90.00, 10, 'PR', 11),
(100.00, 10, 'MS', 11),
(199.90, 1, 'PR', 10),
(210.90, 1, 'MS', 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_produto`
--

CREATE TABLE `tb_produto` (
  `id_produto` int(11) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `venda` char(2) NOT NULL,
  `manual` tinyint(1) NOT NULL,
  `volume` char(2) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_produto`
--

INSERT INTO `tb_produto` (`id_produto`, `descricao`, `venda`, `manual`, `volume`, `status`) VALUES
(10, 'PRODUTO UNITARIO MANUAL EDITADO', 'UN', 0, 'UN', 1),
(11, 'PRODUTO MANUAL QUANTIDADE', 'QN', 1, 'CX', 1),
(12, 'PRODUTO AUTOMATICO UNITARIO POR METRO', 'UN', 0, 'MT', 1),
(13, 'PRODUTO 11111 TESTE', 'UN', 0, 'UN', 1),
(14, 'PRODUTO 22222 QUANTIDADE', 'QN', 0, 'UN', 1),
(15, 'PRODUTO 33333 E 44444 CODIGO MULTIPLO', 'UN', 0, 'UN', 1),
(16, 'PRODUTO 55555 MANUAL', 'UN', 0, 'UN', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `token` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `nome`, `login`, `senha`, `token`, `status`) VALUES
(2, 'Admin', 'admin', '$2y$10$MFVLBKzMay.aF8ovwL3WW.zdyW3jWJ5JE2POt4hwthtMz.4b8HVg2', '0afb8900b3cd6f1a4116dfbbff27d282', 1),
(3, 'Joao', 'joao', '$2y$10$neYGIlc2W39cYVNd6l3cWukZZ2Y66IupaQTP1GrCmwU8Bfrh1ibea', '7b279ca960f197c96459adfdffc54bdc', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_filial`
--
ALTER TABLE `tb_filial`
  ADD PRIMARY KEY (`id_filial`);

--
-- Índices de tabela `tb_filial_produto`
--
ALTER TABLE `tb_filial_produto`
  ADD KEY `fk_filial` (`fk_filial`),
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices de tabela `tb_item`
--
ALTER TABLE `tb_item`
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices de tabela `tb_log`
--
ALTER TABLE `tb_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_produto` (`fk_produto`),
  ADD KEY `fk_usuario` (`fk_usuario`);

--
-- Índices de tabela `tb_preco`
--
ALTER TABLE `tb_preco`
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices de tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_filial`
--
ALTER TABLE `tb_filial`
  MODIFY `id_filial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_filial_produto`
--
ALTER TABLE `tb_filial_produto`
  ADD CONSTRAINT `tb_filial_produto_ibfk_1` FOREIGN KEY (`fk_filial`) REFERENCES `tb_filial` (`id_filial`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_filial_produto_ibfk_2` FOREIGN KEY (`fk_produto`) REFERENCES `tb_produto` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_item`
--
ALTER TABLE `tb_item`
  ADD CONSTRAINT `tb_item_ibfk_1` FOREIGN KEY (`fk_produto`) REFERENCES `tb_produto` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_log`
--
ALTER TABLE `tb_log`
  ADD CONSTRAINT `tb_log_ibfk_1` FOREIGN KEY (`fk_produto`) REFERENCES `tb_produto` (`id_produto`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_log_ibfk_2` FOREIGN KEY (`fk_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Restrições para tabelas `tb_preco`
--
ALTER TABLE `tb_preco`
  ADD CONSTRAINT `tb_preco_ibfk_1` FOREIGN KEY (`fk_produto`) REFERENCES `tb_produto` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
