<?php
session_start();
include(__DIR__ . "/conecta_db.php");

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];


    //Tratamento de erros para conexão do bando de dados
    //Se n conseguir conectar ao banco, vai criar uma exceçao e o catch vai pegar, enviando erro para o get_mensagem.php

    try {
        $db = conecta_db();

        if (!$db) {
            throw new Exception("Erro ao conectar ao banco de dados");
        }
    }
    catch (Exception $e) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao conectar ao banco de dados.'];
        header("Location: ../FRONT/html/loginbase.html");
        exit;
    }


    // Tabelas para a consulta do login

    $consultasDisponiveis = [
        'coordenador' => ['tb_coordenador', 'emailCoordenador', 'senhaCoordenador', 3, 'paginaCoordenador.php'],
        'professor' => ['tb_professor', 'emailProfessor', 'senhaProfessor', 2, 'paginaProfessor.php'],
        'responsavel' => ['tb_responsavel', 'emailResponsavel', 'senhaResponsavel', 1, 'paginaResponsavel.php']
    ];

    //recebe por POST o tipo de login do arquivo loginBase.js
    $tipoLogin = $_POST['tipoUsuario'] ?? null;


    //Filtra o login, fazendo a busca apenas na tabela do tipo de usuario selecionado
    if ($tipoLogin && isset($consultasDisponiveis[$tipoLogin])) {
        $consultas = [$consultasDisponiveis[$tipoLogin]];
    }





    foreach ($consultas as [$tabela, $campoEmail, $campoSenha, $tipo, $pagina]) {
        $query = "SELECT u.idUsuario, u.tipoUsuario, c.$campoSenha 
                  FROM tb_usuario u 
                  JOIN $tabela c ON u.idUsuario = c.idUsuario 
                  WHERE c.$campoEmail = ? AND u.tipoUsuario = ?";

        $stmt = $db->prepare($query);
        $stmt->bind_param("si", $email, $tipo);
        $stmt->execute();
        $stmt->bind_result($idUsuario, $tipoUsuario, $senhaHash);

        if ($stmt->fetch()) {
            if (password_verify($senha, $senhaHash)) {
                $_SESSION['usuario'] = $idUsuario;
                $_SESSION['tipoUsuario'] = $tipoUsuario;

                header("Location: ../FRONT/html/$pagina");
                exit;
            } else {

                // Se a senha estiver errada vai criar uma mensagem de erro e enviar para o get_mensagem.php, para ser usado no alert.js
                $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Senha incorreta'];
                header("Location: ../FRONT/html/loginbase.html");
                exit;
            }
        }

        $stmt->close();
    }

    // Se o usuario n for encontrado dentro das 3 listas, vai criar uma mensagem de erro e enviar para o get_mensagem.php para ser usado no alert.js
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Usuário não encontrado'];
    header("Location: ../FRONT/html/loginbase.html");
    $db->close();
    exit;
}
?>

