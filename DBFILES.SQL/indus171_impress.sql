-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Fev-2021 às 05:12
-- Versão do servidor: 10.4.17-MariaDB
-- versão do PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `indus171_impress`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `impress_orders`
--

CREATE TABLE `impress_orders` (
  `id` int(11) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT 'Produto vendido pela Industria IMPRESS',
  `value` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '0',
  `epp` varchar(255) NOT NULL DEFAULT '0',
  `pg` varchar(255) NOT NULL DEFAULT '0',
  `timep` varchar(255) NOT NULL DEFAULT 'Não_informado',
  `cancelmsg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `impress_products`
--

CREATE TABLE `impress_products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT 'Produto vendido pela Industria IMPRESS',
  `vm` varchar(255) NOT NULL DEFAULT '0',
  `vp` varchar(255) NOT NULL DEFAULT '0',
  `fv` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '0',
  `timep` varchar(255) NOT NULL DEFAULT 'Não_informado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `impress_users`
--

CREATE TABLE `impress_users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL DEFAULT '@impress',
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT 'Não_Informado',
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `permissions` varchar(255) NOT NULL,
  `canbuy` varchar(255) NOT NULL DEFAULT '1',
  `buylimit` varchar(255) NOT NULL DEFAULT '-1',
  `banned` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `impress_users`
--

INSERT INTO `impress_users` (`id`, `fname`, `lname`, `username`, `email`, `contact`, `cpf`, `company`, `address`, `password`, `status`, `permissions`, `canbuy`, `buylimit`, `banned`) VALUES
(1, 'Kayo', 'Oliveira', 'kayooliveira', 'g.kayooliveira123@gmail.com', '21990850443', '04334128360', 'Impress', 'Rua 01', 'kayooliveira', '1', 'all', '1', '-1', '0'),
(2, 'Kayo', 'Oliveira', 'kayooliveira2', 'g.kayooliveira1234@gmail.com', '21990850443', '04334128365', 'Impress', 'Rua 01', 'kayooliveira', '0', 'all', '1', '-1', '0'),
(3, 'Kayo', 'Oliveira', 'kayooliveira3', 'g.kayooliveira12345@gmail.com', '21990850443', '04334128366', 'Impress', 'Rua 01', 'kayooliveira', '1', 'all', '1', '-1', '0');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `impress_orders`
--
ALTER TABLE `impress_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `impress_products`
--
ALTER TABLE `impress_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `impress_users`
--
ALTER TABLE `impress_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `impress_orders`
--
ALTER TABLE `impress_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `impress_products`
--
ALTER TABLE `impress_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `impress_users`
--
ALTER TABLE `impress_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
