-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 08-Jan-2025 às 12:48
-- Versão do servidor: 5.7.44
-- versão do PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `teste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_item`
--

DROP TABLE IF EXISTS `categoria_item`;
CREATE TABLE IF NOT EXISTS `categoria_item` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(4) NOT NULL,
  `item` varchar(200) NOT NULL,
  `min` int(1) DEFAULT NULL,
  `max` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_item` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_opcao`
--

DROP TABLE IF EXISTS `item_opcao`;
CREATE TABLE IF NOT EXISTS `item_opcao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `opcao` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_item_fk` (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_cirurgia` datetime NOT NULL,
  `alergia` text COLLATE utf8mb4_unicode_ci,
  `ativo` int(1) NOT NULL DEFAULT '1',
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_opcao`
--

DROP TABLE IF EXISTS `pedido_opcao`;
CREATE TABLE IF NOT EXISTS `pedido_opcao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `opcao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_item` (`id_item`),
  KEY `pedido_opcao_ibfk_3` (`id_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `perfil` int(11) NOT NULL,
  `id_consultorio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `id_consultorio` (`id_consultorio`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `usuario`, `senha`, `perfil`, `id_consultorio`) VALUES
(1, 'Gustavo Nobrega', 'gnobrega', 'adcd7048512e64b48da55b027577886ee5a36350', 1, NULL);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `categoria_item`
--
ALTER TABLE `categoria_item`
  ADD CONSTRAINT `categoria_item` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `item_opcao`
--
ALTER TABLE `item_opcao`
  ADD CONSTRAINT `id_item_fk` FOREIGN KEY (`id_item`) REFERENCES `categoria_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `pedido_opcao`
--
ALTER TABLE `pedido_opcao`
  ADD CONSTRAINT `pedido_opcao_ibfk_3` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
