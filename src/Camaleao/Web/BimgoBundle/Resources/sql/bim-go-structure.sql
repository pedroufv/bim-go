-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2016 at 09:07 AM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bim-go`
--

-- --------------------------------------------------------

--
-- Table structure for table `cidade`
--

CREATE TABLE IF NOT EXISTS `cidade` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `estado` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razaoSocial` varchar(200) NOT NULL,
  `nomeFantasia` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `cnpj` int(14) NOT NULL,
  `inscricaoEstadual` int(9) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `endereco` int(11) NOT NULL,
  `criadoPor` int(11) NOT NULL,
  `dataCriado` datetime NOT NULL,
  `modificadoPor` int(11) NOT NULL,
  `dataModificacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `endereco` (`endereco`),
  KEY `criadoPor` (`criadoPor`,`modificadoPor`),
  KEY `modificadoPor` (`modificadoPor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3001 ;

-- --------------------------------------------------------

--
-- Table structure for table `endereco`
--

CREATE TABLE IF NOT EXISTS `endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logradouro` varchar(200) NOT NULL,
  `numero` int(11) NOT NULL,
  `complemento` varchar(200) NOT NULL,
  `bairro` varchar(200) NOT NULL,
  `cidade` int(11) NOT NULL,
  `cep` varchar(200) NOT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cidade` (`cidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `uf` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `funcionario`
--

CREATE TABLE IF NOT EXISTS `funcionario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `empresa` int(11) NOT NULL,
  `endereco` int(11) NOT NULL,
  `criadoPor` int(11) NOT NULL,
  `dataCriacao` datetime NOT NULL,
  `modificadoPor` int(11) NOT NULL,
  `dataModificacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `empresa` (`empresa`),
  KEY `endereco` (`endereco`),
  KEY `criadoPor` (`criadoPor`,`modificadoPor`),
  KEY `modificadoPor` (`modificadoPor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notificacao`
--

CREATE TABLE IF NOT EXISTS `notificacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `remetente` int(11) NOT NULL,
  `destinatario` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `remetente` (`remetente`,`destinatario`),
  KEY `destinatario` (`destinatario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pagamento`
--

CREATE TABLE IF NOT EXISTS `pagamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor` float(10,2) NOT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `empresa` (`empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `papel`
--

CREATE TABLE IF NOT EXISTS `papel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `pai` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pai` (`pai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `produto`
--

CREATE TABLE IF NOT EXISTS `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `ean` varchar(13) DEFAULT NULL,
  `empresa` int(11) NOT NULL,
  `criadoPor` int(11) NOT NULL,
  `dataCriado` datetime NOT NULL,
  `modificadoPor` int(11) NOT NULL,
  `dataModificacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `empresa` (`empresa`),
  KEY `fk_usuarioid_produto_criadopor` (`criadoPor`) USING BTREE,
  KEY `fk_usuarioid_produto_modificadopor` (`modificadoPor`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `produto_promocao`
--

CREATE TABLE IF NOT EXISTS `produto_promocao` (
  `produto` int(11) NOT NULL,
  `promocao` int(11) NOT NULL,
  `valor` float(10,2) NOT NULL,
  PRIMARY KEY (`produto`,`promocao`),
  KEY `produto` (`produto`,`promocao`),
  KEY `promocao` (`promocao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promocao`
--

CREATE TABLE IF NOT EXISTS `promocao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  `empresa` int(11) NOT NULL,
  `criadoPor` int(11) NOT NULL,
  `dataCriado` datetime NOT NULL,
  `modificadoPor` int(11) NOT NULL,
  `dataModificacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `empresa` (`empresa`),
  KEY `fk_usuarioid_promocao_criadopor` (`criadoPor`),
  KEY `fk_usuarioid_promocao_modificadopor` (`modificadoPor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `segmento`
--

CREATE TABLE IF NOT EXISTS `segmento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `segmento_empresa`
--

CREATE TABLE IF NOT EXISTS `segmento_empresa` (
  `segmento` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  PRIMARY KEY (`segmento`,`empresa`),
  KEY `segmento` (`segmento`,`empresa`),
  KEY `empresa` (`empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `token` varchar(32) NOT NULL,
  `registrationId` varchar(255) NOT NULL,
  `papel` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`),
  UNIQUE KEY `email` (`email`),
  KEY `papel` (`papel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario_empresa_papel`
--

CREATE TABLE IF NOT EXISTS `usuario_empresa_papel` (
  `idUsuario` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idPapel` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`,`idEmpresa`,`idPapel`),
  KEY `idUsuario` (`idUsuario`,`idEmpresa`,`idPapel`),
  KEY `idEmpresa` (`idEmpresa`,`idPapel`),
  KEY `idPapel` (`idPapel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cidade`
--
ALTER TABLE `cidade`
  ADD CONSTRAINT `fk_estadoid_cidade` FOREIGN KEY (`estado`) REFERENCES `estado` (`id`);

--
-- Constraints for table `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_enderecoid_empresa` FOREIGN KEY (`endereco`) REFERENCES `endereco` (`id`),
  ADD CONSTRAINT `fk_usuariarioid_criadopor` FOREIGN KEY (`criadoPor`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_usuariarioid_modificapor` FOREIGN KEY (`modificadoPor`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `fk_cidadeid_endereco` FOREIGN KEY (`cidade`) REFERENCES `cidade` (`id`);

--
-- Constraints for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `fk_empresaid_funcionario` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`),
  ADD CONSTRAINT `fk_enderecoid_funcionario` FOREIGN KEY (`endereco`) REFERENCES `endereco` (`id`),
  ADD CONSTRAINT `fk_usuariarioid__funcionario_criadopor` FOREIGN KEY (`criadoPor`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_usuariarioid__funcionario_modificadopor` FOREIGN KEY (`modificadoPor`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `notificacao`
--
ALTER TABLE `notificacao`
  ADD CONSTRAINT `fk_usuarioid_destinatario` FOREIGN KEY (`destinatario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_usuarioid_remetente` FOREIGN KEY (`remetente`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `fk_empresaid_pagamento` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`);

--
-- Constraints for table `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `fk_empresaid_produto` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`),
  ADD CONSTRAINT `fk_usuarioid_criadopor_produto` FOREIGN KEY (`criadoPor`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_usuarioid_modificaopor_produto` FOREIGN KEY (`modificadoPor`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `produto_promocao`
--
ALTER TABLE `produto_promocao`
  ADD CONSTRAINT `fk_produtoid_produto_promocao` FOREIGN KEY (`produto`) REFERENCES `produto` (`id`),
  ADD CONSTRAINT `fk_promocaoid_produto_promocao` FOREIGN KEY (`promocao`) REFERENCES `promocao` (`id`);

--
-- Constraints for table `promocao`
--
ALTER TABLE `promocao`
  ADD CONSTRAINT `fk_empresaid_promocao` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`),
  ADD CONSTRAINT `fk_usuarioid_criadopor_promocao` FOREIGN KEY (`criadoPor`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_usuarioid_modificadopor_promocao` FOREIGN KEY (`modificadoPor`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `segmento_empresa`
--
ALTER TABLE `segmento_empresa`
  ADD CONSTRAINT `fk_empresaid_segmento_empresa` FOREIGN KEY (`empresa`) REFERENCES `empresa` (`id`),
  ADD CONSTRAINT `fk_segmentoid_segmento_empresa` FOREIGN KEY (`segmento`) REFERENCES `segmento` (`id`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fik_papelid_usuario` FOREIGN KEY (`papel`) REFERENCES `papel` (`id`);

--
-- Constraints for table `usuario_empresa_papel`
--
ALTER TABLE `usuario_empresa_papel`
  ADD CONSTRAINT `usuario_empresa_papel_ibfk_idempresa` FOREIGN KEY (`idEmpresa`) REFERENCES `endereco` (`id`),
  ADD CONSTRAINT `usuario_empresa_papel_ibfk_idpapel` FOREIGN KEY (`idPapel`) REFERENCES `papel` (`id`),
  ADD CONSTRAINT `usuario_empresa_papel_ibfk_idusuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
