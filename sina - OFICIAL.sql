-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 12:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sina`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_aluno`
--

CREATE TABLE `tb_aluno` (
  `matriculaAluno` int(11) NOT NULL,
  `NomeAluno` varchar(45) NOT NULL,
  `dataNasc` date DEFAULT NULL,
  `idTurma` int(11) DEFAULT NULL,
  `fotoAluno` varchar(255) DEFAULT NULL COMMENT 'Caminho/nome do arquivo da foto do aluno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_aluno`
--

INSERT INTO `tb_aluno` (`matriculaAluno`, `NomeAluno`, `dataNasc`, `idTurma`, `fotoAluno`) VALUES
(1, 's', '0000-00-00', 1, NULL),
(2, 'd', '0000-00-00', 1, NULL),
(3, 'Lucas', '2005-07-19', 2, '683a0f7ca4d04.jpg'),
(4, 'Valentina', '2005-07-19', 3, '683a0fc84b505.jpeg'),
(5, 'Luis', '2005-05-16', 3, '683a2bda76cc5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_comunicado`
--

CREATE TABLE `tb_comunicado` (
  `idComunicado` int(11) NOT NULL,
  `idTurma` int(11) NOT NULL,
  `idProfessor` int(11) NOT NULL,
  `Data` datetime NOT NULL DEFAULT current_timestamp(),
  `Descricao` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_comunicado`
--

INSERT INTO `tb_comunicado` (`idComunicado`, `idTurma`, `idProfessor`, `Data`, `Descricao`) VALUES
(2, 1, 5, '2025-05-18 12:40:45', 'Texto do comunicado'),
(3, 1, 5, '2025-05-18 13:16:29', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n				AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n                AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n                AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n                AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n                AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\n                AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'),
(5, 2, 16, '2025-05-27 20:31:36', 'oi');

-- --------------------------------------------------------

--
-- Table structure for table `tb_coordenador`
--

CREATE TABLE `tb_coordenador` (
  `cpfCoordenador` varchar(14) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `nomeCoordenador` varchar(100) NOT NULL,
  `emailCoordenador` varchar(100) NOT NULL,
  `senhaCoordenador` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_coordenador`
--

INSERT INTO `tb_coordenador` (`cpfCoordenador`, `idUsuario`, `nomeCoordenador`, `emailCoordenador`, `senhaCoordenador`) VALUES
('13341797947', 13, 'laura', 'l@gmial.com', '$2y$10$RHSZSa7ziAmY4ZVFR5Pxteg2C3vdxsvxnAt0tLhCSuWXoazqfgaMe'),
('08899666997', 19, 'leles', 'lele@gmail.com', '$2y$10$xxIpLRu5P7cJPHsoutbJI.OYAcS94q.8XkoSwRskVDW4lEivp0jNO'),
('10947563938', 22, 'Leonardo Smijtink', 'leosmkkkk@gmail.com', '$2y$10$BbZnIMzYgUAUSY5AumF.S.UbcCYVmjrtYW7jghfm8dRM0Avsz2aMW');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fichamedica`
--

CREATE TABLE `tb_fichamedica` (
  `idFichaMedica` int(11) NOT NULL,
  `matriculaAluno` int(11) NOT NULL,
  `tipoSanguineo` varchar(3) DEFAULT NULL,
  `alergias` text DEFAULT NULL,
  `medicacoes` text DEFAULT NULL,
  `planoSaude` varchar(100) DEFAULT NULL,
  `numeroPlano` varchar(50) DEFAULT NULL,
  `contatoEmergencia` varchar(100) DEFAULT NULL,
  `telefoneEmergencia` varchar(20) DEFAULT NULL,
  `parentescoEmergencia` varchar(50) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_fichamedica`
--

INSERT INTO `tb_fichamedica` (`idFichaMedica`, `matriculaAluno`, `tipoSanguineo`, `alergias`, `medicacoes`, `planoSaude`, `numeroPlano`, `contatoEmergencia`, `telefoneEmergencia`, `parentescoEmergencia`, `observacoes`, `dataAtualizacao`) VALUES
(1, 4, 'A+', 'Amendoim', 'Sertralina 150mg', 'Unimed', '', '', '', '', '', '2025-05-30 21:56:43'),
(2, 5, '', '', '', '', '', '', '', '', '', '2025-05-30 22:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `tb_professor`
--

CREATE TABLE `tb_professor` (
  `nomeProfessor` varchar(100) NOT NULL,
  `emailProfessor` varchar(100) NOT NULL,
  `senhaProfessor` varchar(100) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_professor`
--

INSERT INTO `tb_professor` (`nomeProfessor`, `emailProfessor`, `senhaProfessor`, `idUsuario`) VALUES
('laura', 'laura@gmail.com', '$2y$10$hO0ED/TwsJzP9csJioJhY.VfBev7KzUoVXw5Y2zuRdU27JEPxAuOC', 5),
('laura', 'lauraaa@gmail.com', '$2y$10$2YBWz92/lwOF/MP1IQ/VwO56FAjyuUPBjyheJwOOvGen5uisn.XBO', 6),
('leo', 'leo@gmail.com', '$2y$10$xLPzRhk9cjvUHelaVwNx/.unoRRCURJQKlJ2xdSqRPbWJYzHeeDTm', 16),
('Leonardo Smijtink', 'leosmkk@gmail.com', '$2y$10$zU2VltvMLkEq5ZwgU0cHseigdtI9dZSkn.UXsyo4SvmAxsXSxuta6', 20),
('Leonardo Smijtink', 'leosmkkk@gmail.com', '$2y$10$.qsNTNm71FmH5g5qKXN3y.KE1S6f5M27Sv.24th0lWfUDIEhQzJFS', 21);

-- --------------------------------------------------------

--
-- Table structure for table `tb_responsavel`
--

CREATE TABLE `tb_responsavel` (
  `idUsuario` int(11) NOT NULL,
  `nomeResponsavel` varchar(100) NOT NULL,
  `emailResponsavel` varchar(100) NOT NULL,
  `senhaResponsavel` varchar(255) NOT NULL,
  `telefoneResponsavel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_responsavel`
--

INSERT INTO `tb_responsavel` (`idUsuario`, `nomeResponsavel`, `emailResponsavel`, `senhaResponsavel`, `telefoneResponsavel`) VALUES
(8, 'lolo', 'lololololo@gmail.com', '$2y$10$zWvgmNBa3bLKhIa.sBf.Se3wHq.uK0FDoFvI3g9dRsnUVyI/qeTXC', '0'),
(9, 'fifi', 'fifi@gmail.com', '$2y$10$j4T6zu5/Vb5yvAul21h0Vu9NOn15/vZYoP34SJGa.WdaRFvi.XLw2', '0'),
(10, 'fernan', 'fernan@gmail.com', '$2y$10$/vLbrSHHxOUqck35RHH1XuXf/NeT5QPcgUAdF7oVpx1FWy89outg6', '0'),
(11, 'bebe', 'bebe@gmail.com', '$2y$10$Dk4eHaxARC4MUSTSFTVNFO.MGRiSPnF.j7bnDZuXqyJ3vh5hldu5W', '0'),
(15, 'leadros', 'leandro@gmail.com', '$2y$10$MASOEfkF8XxxA/GHx9NLhuTRvsZliefEtSsIMLfE6VmJebdQq1VEC', '0'),
(23, 'Julia', 'j4btt@gmail.com', '$2y$10$l0w5kyeSHcFSB5ihqHFOJ.C8S5eGyN.ygpqh0/fF/o9gVJgZHXfQi', '41987903613'),
(24, 'Joao', 'joca@gmail.com', '$2y$10$NJ.3wSSTPP6nlBEk9yeaVOZmAeu2NFrgTwcQQQzgZpYS7HbtnvnNG', ''),
(27, 'antonella', 'antonella@gmail.com', '$2y$10$SuA6nXmsRUdcFX3uvwD3xOn2NBHPn3/z6ZAHNc3d1orHpRR6m9Jha', '(41) 6666-6666');

-- --------------------------------------------------------

--
-- Table structure for table `tb_responsavel_aluno`
--

CREATE TABLE `tb_responsavel_aluno` (
  `matriculaAluno` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_responsavel_aluno`
--

INSERT INTO `tb_responsavel_aluno` (`matriculaAluno`, `idUsuario`) VALUES
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(2, 11),
(2, 15),
(2, 27),
(3, 24),
(4, 23);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tipo_usuario`
--

CREATE TABLE `tb_tipo_usuario` (
  `idTipoUsuario` int(11) NOT NULL,
  `nomeTipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_tipo_usuario`
--

INSERT INTO `tb_tipo_usuario` (`idTipoUsuario`, `nomeTipo`) VALUES
(1, 'Responsável'),
(2, 'Professor'),
(3, 'Coordenador');

-- --------------------------------------------------------

--
-- Table structure for table `tb_turma`
--

CREATE TABLE `tb_turma` (
  `idTurma` int(11) NOT NULL,
  `Sala` int(11) NOT NULL,
  `Nome` varchar(45) DEFAULT NULL,
  `idProfessor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_turma`
--

INSERT INTO `tb_turma` (`idTurma`, `Sala`, `Nome`, `idProfessor`) VALUES
(1, 233, '1a', 2),
(2, 12, '2b', 6),
(3, 6, '3A', 21);

-- --------------------------------------------------------

--
-- Table structure for table `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `idUsuario` int(11) NOT NULL,
  `tipoUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_usuario`
--

INSERT INTO `tb_usuario` (`idUsuario`, `tipoUsuario`) VALUES
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(15, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(16, 2),
(20, 2),
(21, 2),
(12, 3),
(13, 3),
(14, 3),
(17, 3),
(18, 3),
(19, 3),
(22, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_aluno`
--
ALTER TABLE `tb_aluno`
  ADD PRIMARY KEY (`matriculaAluno`),
  ADD KEY `Turma_idTurma` (`idTurma`);

--
-- Indexes for table `tb_comunicado`
--
ALTER TABLE `tb_comunicado`
  ADD PRIMARY KEY (`idComunicado`),
  ADD KEY `Turma_idTurma` (`idTurma`),
  ADD KEY `Turma_Professor_Usuario_idUsuario` (`idProfessor`);

--
-- Indexes for table `tb_coordenador`
--
ALTER TABLE `tb_coordenador`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `emailCoordenador` (`emailCoordenador`);

--
-- Indexes for table `tb_fichamedica`
--
ALTER TABLE `tb_fichamedica`
  ADD PRIMARY KEY (`idFichaMedica`),
  ADD KEY `matriculaAluno` (`matriculaAluno`);

--
-- Indexes for table `tb_professor`
--
ALTER TABLE `tb_professor`
  ADD UNIQUE KEY `uq_email_professor` (`emailProfessor`),
  ADD KEY `fk_professor_usuario` (`idUsuario`);

--
-- Indexes for table `tb_responsavel`
--
ALTER TABLE `tb_responsavel`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `emailResponsavel` (`emailResponsavel`);

--
-- Indexes for table `tb_responsavel_aluno`
--
ALTER TABLE `tb_responsavel_aluno`
  ADD PRIMARY KEY (`matriculaAluno`,`idUsuario`),
  ADD KEY `idUsuario` (`idUsuario`) USING BTREE;

--
-- Indexes for table `tb_tipo_usuario`
--
ALTER TABLE `tb_tipo_usuario`
  ADD PRIMARY KEY (`idTipoUsuario`);

--
-- Indexes for table `tb_turma`
--
ALTER TABLE `tb_turma`
  ADD PRIMARY KEY (`idTurma`),
  ADD KEY `Professor_Usuario_idUsuario` (`idProfessor`);

--
-- Indexes for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `fk_usuario_tipo` (`tipoUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_aluno`
--
ALTER TABLE `tb_aluno`
  MODIFY `matriculaAluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_comunicado`
--
ALTER TABLE `tb_comunicado`
  MODIFY `idComunicado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_fichamedica`
--
ALTER TABLE `tb_fichamedica`
  MODIFY `idFichaMedica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_responsavel`
--
ALTER TABLE `tb_responsavel`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tb_turma`
--
ALTER TABLE `tb_turma`
  MODIFY `idTurma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_aluno`
--
ALTER TABLE `tb_aluno`
  ADD CONSTRAINT `tb_aluno_ibfk_1` FOREIGN KEY (`idTurma`) REFERENCES `tb_turma` (`idTurma`);

--
-- Constraints for table `tb_comunicado`
--
ALTER TABLE `tb_comunicado`
  ADD CONSTRAINT `tb_comunicado_ibfk_1` FOREIGN KEY (`idTurma`) REFERENCES `tb_turma` (`idTurma`),
  ADD CONSTRAINT `tb_comunicado_ibfk_2` FOREIGN KEY (`idProfessor`) REFERENCES `tb_professor` (`idUsuario`);

--
-- Constraints for table `tb_coordenador`
--
ALTER TABLE `tb_coordenador`
  ADD CONSTRAINT `tb_coordenador_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `tb_usuario` (`idUsuario`);

--
-- Constraints for table `tb_fichamedica`
--
ALTER TABLE `tb_fichamedica`
  ADD CONSTRAINT `tb_fichamedica_ibfk_1` FOREIGN KEY (`matriculaAluno`) REFERENCES `tb_aluno` (`matriculaAluno`);

--
-- Constraints for table `tb_professor`
--
ALTER TABLE `tb_professor`
  ADD CONSTRAINT `fk_professor_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `tb_usuario` (`idUsuario`);

--
-- Constraints for table `tb_responsavel`
--
ALTER TABLE `tb_responsavel`
  ADD CONSTRAINT `fk_responsavel_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `tb_usuario` (`idUsuario`);

--
-- Constraints for table `tb_responsavel_aluno`
--
ALTER TABLE `tb_responsavel_aluno`
  ADD CONSTRAINT `tb_responsavel_aluno_ibfk_1` FOREIGN KEY (`matriculaAluno`) REFERENCES `tb_aluno` (`matriculaAluno`),
  ADD CONSTRAINT `tb_responsavel_aluno_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `tb_responsavel` (`idUsuario`);

--
-- Constraints for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `fk_usuario_tipo` FOREIGN KEY (`tipoUsuario`) REFERENCES `tb_tipo_usuario` (`idTipoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
