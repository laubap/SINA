CREATE TABLE tb_tipo_usuario (
    idTipo INT PRIMARY KEY AUTO_INCREMENT,
    descricao VARCHAR(50) NOT NULL
);

INSERT INTO tb_tipo_usuario (descricao) VALUES 
('Estudante'), ('Professor'), ('Coordenador');

ALTER TABLE tb_usuario 
MODIFY COLUMN tipoUsuario INT,
ADD CONSTRAINT fk_tipo_usuario 
FOREIGN KEY (tipoUsuario) REFERENCES tb_tipo_usuario(idTipo);