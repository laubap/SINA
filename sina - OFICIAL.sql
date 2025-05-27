-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/05/2025 às 01:45
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sina`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_aluno`
--

CREATE TABLE `tb_aluno` (
  `matriculaAluno` int(11) NOT NULL,
  `NomeAluno` varchar(45) NOT NULL,
  `dataNasc` date DEFAULT NULL,
  `idTurma` int(11) DEFAULT NULL,
  `fotoAluno` varchar(255) DEFAULT NULL COMMENT 'Caminho/nome do arquivo da foto do aluno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_aluno`
--

INSERT INTO `tb_aluno` (`matriculaAluno`, `NomeAluno`, `dataNasc`, `idTurma`, `fotoAluno`) VALUES
(1, 's', '0000-00-00', 1, NULL),
(2, 'd', '0000-00-00', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_comunicado`
--

CREATE TABLE `tb_comunicado` (
  `idComunicado` int(11) NOT NULL,
  `idTurma` int(11) NOT NULL,
  `idProfessor` int(11) NOT NULL,
  `Data` datetime NOT NULL DEFAULT current_timestamp(),
  `Descricao` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_comunicado`
--

INSERT INTO `tb_comunicado` (`idComunicado`, `idTurma`, `idProfessor`, `Data`, `Descricao`) VALUES
(2, 1, 5, '2025-05-18 12:40:45', 'Texto do comunicado'),
(3, 1, 5, '2025-05-18 13:16:29', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n				AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n                AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n                AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n                AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n                AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n                AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'),
(5, 2, 16, '2025-05-27 20:31:36', 'oi');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_coordenador`
--

CREATE TABLE `tb_coordenador` (
  `cpfCoordenador` varchar(14) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `nomeCoordenador` varchar(100) NOT NULL,
  `emailCoordenador` varchar(100) NOT NULL,
  `senhaCoordenador` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_coordenador`
--

INSERT INTO `tb_coordenador` (`cpfCoordenador`, `idUsuario`, `nomeCoordenador`, `emailCoordenador`, `senhaCoordenador`) VALUES
('13341797947', 13, 'laura', 'l@gmial.com', '$2y$10$RHSZSa7ziAmY4ZVFR5Pxteg2C3vdxsvxnAt0tLhCSuWXoazqfgaMe'),
('08899666997', 19, 'leles', 'lele@gmail.com', '$2y$10$xxIpLRu5P7cJPHsoutbJI.OYAcS94q.8XkoSwRskVDW4lEivp0jNO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_ficha`
--

CREATE TABLE `tb_ficha` (
  `Aluno_idAluno` int(11) NOT NULL,
  `Aluno_Turma_idTurma` int(11) NOT NULL,
  `necessidadeMedica` varchar(200) DEFAULT NULL,
  `necessidadeComportamental` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_professor`
--

CREATE TABLE `tb_professor` (
  `nomeProfessor` varchar(100) NOT NULL,
  `emailProfessor` varchar(100) NOT NULL,
  `senhaProfessor` varchar(100) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_professor`
--

INSERT INTO `tb_professor` (`nomeProfessor`, `emailProfessor`, `senhaProfessor`, `idUsuario`) VALUES
('laura', 'laura@gmail.com', '$2y$10$hO0ED/TwsJzP9csJioJhY.VfBev7KzUoVXw5Y2zuRdU27JEPxAuOC', 5),
('laura', 'lauraaa@gmail.com', '$2y$10$2YBWz92/lwOF/MP1IQ/VwO56FAjyuUPBjyheJwOOvGen5uisn.XBO', 6),
('leo', 'leo@gmail.com', '$2y$10$xLPzRhk9cjvUHelaVwNx/.unoRRCURJQKlJ2xdSqRPbWJYzHeeDTm', 16);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_responsavel`
--

CREATE TABLE `tb_responsavel` (
  `idUsuario` int(11) NOT NULL,
  `nomeResponsavel` varchar(100) NOT NULL,
  `emailResponsavel` varchar(100) NOT NULL,
  `senhaResponsavel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_responsavel`
--

INSERT INTO `tb_responsavel` (`idUsuario`, `nomeResponsavel`, `emailResponsavel`, `senhaResponsavel`) VALUES
(8, 'lolo', 'lololololo@gmail.com', '$2y$10$zWvgmNBa3bLKhIa.sBf.Se3wHq.uK0FDoFvI3g9dRsnUVyI/qeTXC'),
(9, 'fifi', 'fifi@gmail.com', '$2y$10$j4T6zu5/Vb5yvAul21h0Vu9NOn15/vZYoP34SJGa.WdaRFvi.XLw2'),
(10, 'fernan', 'fernan@gmail.com', '$2y$10$/vLbrSHHxOUqck35RHH1XuXf/NeT5QPcgUAdF7oVpx1FWy89outg6'),
(11, 'bebe', 'bebe@gmail.com', '$2y$10$Dk4eHaxARC4MUSTSFTVNFO.MGRiSPnF.j7bnDZuXqyJ3vh5hldu5W'),
(15, 'leadros', 'leandro@gmail.com', '$2y$10$MASOEfkF8XxxA/GHx9NLhuTRvsZliefEtSsIMLfE6VmJebdQq1VEC');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_responsavel_aluno`
--

CREATE TABLE `tb_responsavel_aluno` (
  `matriculaAluno` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_responsavel_aluno`
--

INSERT INTO `tb_responsavel_aluno` (`matriculaAluno`, `idUsuario`) VALUES
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(2, 11),
(2, 15);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_tipo_usuario`
--

CREATE TABLE `tb_tipo_usuario` (
  `idTipoUsuario` int(11) NOT NULL,
  `nomeTipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_tipo_usuario`
--

INSERT INTO `tb_tipo_usuario` (`idTipoUsuario`, `nomeTipo`) VALUES
(1, 'Responsável'),
(2, 'Professor'),
(3, 'Coordenador');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_turma`
--

CREATE TABLE `tb_turma` (
  `idTurma` int(11) NOT NULL,
  `Sala` int(11) NOT NULL,
  `Nome` varchar(45) DEFAULT NULL,
  `idProfessor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_turma`
--

INSERT INTO `tb_turma` (`idTurma`, `Sala`, `Nome`, `idProfessor`) VALUES
(1, 233, '1a', 2),
(2, 12, '2b', 16);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `idUsuario` int(11) NOT NULL,
  `tipoUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`idUsuario`, `tipoUsuario`) VALUES
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(15, 1),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(16, 2),
(12, 3),
(13, 3),
(14, 3),
(17, 3),
(18, 3),
(19, 3);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_aluno`
--
ALTER TABLE `tb_aluno`
  ADD PRIMARY KEY (`matriculaAluno`),
  ADD KEY `Turma_idTurma` (`idTurma`);

--
-- Índices de tabela `tb_comunicado`
--
ALTER TABLE `tb_comunicado`
  ADD PRIMARY KEY (`idComunicado`),
  ADD KEY `Turma_idTurma` (`idTurma`),
  ADD KEY `Turma_Professor_Usuario_idUsuario` (`idProfessor`);

--
-- Índices de tabela `tb_coordenador`
--
ALTER TABLE `tb_coordenador`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `emailCoordenador` (`emailCoordenador`);

--
-- Índices de tabela `tb_ficha`
--
ALTER TABLE `tb_ficha`
  ADD PRIMARY KEY (`Aluno_idAluno`,`Aluno_Turma_idTurma`),
  ADD KEY `Aluno_Turma_idTurma` (`Aluno_Turma_idTurma`);

--
-- Índices de tabela `tb_professor`
--
ALTER TABLE `tb_professor`
  ADD UNIQUE KEY `uq_email_professor` (`emailProfessor`),
  ADD KEY `fk_professor_usuario` (`idUsuario`);

--
-- Índices de tabela `tb_responsavel`
--
ALTER TABLE `tb_responsavel`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `emailResponsavel` (`emailResponsavel`);

--
-- Índices de tabela `tb_responsavel_aluno`
--
ALTER TABLE `tb_responsavel_aluno`
  ADD PRIMARY KEY (`matriculaAluno`,`idUsuario`),
  ADD KEY `idUsuario` (`idUsuario`) USING BTREE;

--
-- Índices de tabela `tb_tipo_usuario`
--
ALTER TABLE `tb_tipo_usuario`
  ADD PRIMARY KEY (`idTipoUsuario`);

--
-- Índices de tabela `tb_turma`
--
ALTER TABLE `tb_turma`
  ADD PRIMARY KEY (`idTurma`),
  ADD KEY `Professor_Usuario_idUsuario` (`idProfessor`);

--
-- Índices de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `fk_usuario_tipo` (`tipoUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_aluno`
--
ALTER TABLE `tb_aluno`
  MODIFY `matriculaAluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_comunicado`
--
ALTER TABLE `tb_comunicado`
  MODIFY `idComunicado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_responsavel`
--
ALTER TABLE `tb_responsavel`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `tb_turma`
--
ALTER TABLE `tb_turma`
  MODIFY `idTurma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_aluno`
--
ALTER TABLE `tb_aluno`
  ADD CONSTRAINT `tb_aluno_ibfk_1` FOREIGN KEY (`idTurma`) REFERENCES `tb_turma` (`idTurma`);

--
-- Restrições para tabelas `tb_comunicado`
--
ALTER TABLE `tb_comunicado`
  ADD CONSTRAINT `tb_comunicado_ibfk_1` FOREIGN KEY (`idTurma`) REFERENCES `tb_turma` (`idTurma`),
  ADD CONSTRAINT `tb_comunicado_ibfk_2` FOREIGN KEY (`idProfessor`) REFERENCES `tb_professor` (`idUsuario`);

--
-- Restrições para tabelas `tb_coordenador`
--
ALTER TABLE `tb_coordenador`
  ADD CONSTRAINT `tb_coordenador_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `tb_usuario` (`idUsuario`);

--
-- Restrições para tabelas `tb_ficha`
--
ALTER TABLE `tb_ficha`
  ADD CONSTRAINT `tb_ficha_ibfk_1` FOREIGN KEY (`Aluno_idAluno`) REFERENCES `tb_aluno` (`matriculaAluno`),
  ADD CONSTRAINT `tb_ficha_ibfk_2` FOREIGN KEY (`Aluno_Turma_idTurma`) REFERENCES `tb_turma` (`idTurma`);

--
-- Restrições para tabelas `tb_professor`
--
ALTER TABLE `tb_professor`
  ADD CONSTRAINT `fk_professor_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `tb_usuario` (`idUsuario`);

--
-- Restrições para tabelas `tb_responsavel`
--
ALTER TABLE `tb_responsavel`
  ADD CONSTRAINT `fk_responsavel_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `tb_usuario` (`idUsuario`);

--
-- Restrições para tabelas `tb_responsavel_aluno`
--
ALTER TABLE `tb_responsavel_aluno`
  ADD CONSTRAINT `tb_responsavel_aluno_ibfk_1` FOREIGN KEY (`matriculaAluno`) REFERENCES `tb_aluno` (`matriculaAluno`),
  ADD CONSTRAINT `tb_responsavel_aluno_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `tb_responsavel` (`idUsuario`);

--
-- Restrições para tabelas `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `fk_usuario_tipo` FOREIGN KEY (`tipoUsuario`) REFERENCES `tb_tipo_usuario` (`idTipoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
