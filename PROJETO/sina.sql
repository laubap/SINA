CREATE DATABASE IF NOT EXISTS sina;
USE sina;

CREATE TABLE tb_usuario (
    idUsuario INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(45) NOT NULL,
    Email VARCHAR(45) NOT NULL,
    tipoUsuario INT NOT NULL
);

CREATE TABLE tb_coordenador (
    Usuario_idUsuario INT PRIMARY KEY,
    FOREIGN KEY (Usuario_idUsuario) REFERENCES tb_usuario(idUsuario)
);

CREATE TABLE tb_professor (
    Usuario_idUsuario INT PRIMARY KEY,
    FOREIGN KEY (Usuario_idUsuario) REFERENCES tb_usuario(idUsuario)
);

CREATE TABLE tb_responsavel (
    idUsuario INT PRIMARY KEY,
    FOREIGN KEY (idUsuario) REFERENCES tb_usuario(idUsuario)
);

CREATE TABLE tb_turma (
    idTurma INT PRIMARY KEY AUTO_INCREMENT,
    Sala INT NOT NULL,
    Nome VARCHAR(45),
    Professor_Usuario_idUsuario INT NOT NULL,
    FOREIGN KEY (Professor_Usuario_idUsuario) REFERENCES tb_professor(Usuario_idUsuario)
);

CREATE TABLE tb_aluno (
    idAluno INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(45) NOT NULL,
    Idade INT,
    dataNasc DATE,
    Turma_idTurma INT,
    FOREIGN KEY (Turma_idTurma) REFERENCES tb_turma(idTurma)
);

CREATE TABLE tb_responsavel_aluno (
    Aluno_idAluno INT,
    Responsavel_idUsuario INT,
    PRIMARY KEY (Aluno_idAluno, Responsavel_idUsuario),
    FOREIGN KEY (Aluno_idAluno) REFERENCES tb_aluno(idAluno),
FOREIGN KEY (Responsavel_idUsuario) REFERENCES tb_responsavel(idUsuario)
);

CREATE TABLE tb_ficha (
    Aluno_idAluno INT,
    Aluno_Turma_idTurma INT,
    necessidadeMedica VARCHAR(200),
    necessidadeComportamental VARCHAR(200),
    PRIMARY KEY (Aluno_idAluno, Aluno_Turma_idTurma),
    FOREIGN KEY (Aluno_idAluno) REFERENCES tb_aluno(idAluno),
    FOREIGN KEY (Aluno_Turma_idTurma) REFERENCES tb_turma(idTurma)
);

CREATE TABLE tb_comunicado (
    Turma_idTurma INT,
    Turma_Professor_Usuario_idUsuario INT,
    Data DATE,
    Descricao VARCHAR(200),
    PRIMARY KEY (Turma_idTurma, Turma_Professor_Usuario_idUsuario, Data),
    FOREIGN KEY (Turma_idTurma) REFERENCES tb_turma(idTurma),
    FOREIGN KEY (Turma_Professor_Usuario_idUsuario) REFERENCES tb_professor(Usuario_idUsuario)
);
