-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 04/04/2016 às 17:35
-- Versão do servidor: 5.5.47-0ubuntu0.14.04.1
-- Versão do PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `bim-go`
--

--
-- Fazendo dump de dados para tabela `destinatario_tipo`
--

INSERT INTO `destinatario_tipo` (`id`, `nome`, `descricao`, `papel`) VALUES
(1, 'Todos os usuários', 'Todos os usuários', 1002),
(2, 'Todos os clientes', 'Todos os clientes', 1002),
(3, 'Todas as empresas', 'Todas as empresas', 1002),
(4, 'Empresas associadas', 'Empresas associadas', 1002),
(5, 'Empresas não associadas', 'Empresas não associadas', 1002),
(6, 'Todos os clientes', 'Todos os clientes', 1004),
(7, 'Todos os funcionários', 'Todos os funcionários', 1004),
(8, 'Todos os usuários', 'Todos os usuários', 999),
(9, 'Todas as empresas', 'Todas as empresas', 999);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
