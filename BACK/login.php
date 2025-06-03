<?php
session_start();
include(__DIR__ . "/conecta_db.php");

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        $db = conecta_db();
        if (!$db) {
            throw new Exception("Erro ao conectar ao banco de dados");
        }
    } catch (Exception $e) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao conectar ao banco de dados.'];
        header("Location: ../FRONT/html/loginbase.html");
        exit;
    }

    $consultasDisponiveis = [
        'coordenador' => ['tb_coordenador', 'emailCoordenador', 'senhaCoordenador', 3, 'paginaCoordenador.php'],
        'professor' => ['tb_professor', 'emailProfessor', 'senhaProfessor', 2, 'paginaProfessor.php'],
        'responsavel' => ['tb_responsavel', 'emailResponsavel', 'senhaResponsavel', 1, 'paginaResponsavel.php']
    ];

    $tipoLogin = $_POST['tipoUsuario'] ?? null;

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
                $_SESSION['idUsuario'] = $idUsuario;  // LINHA ADICIONADA
                
                header("Location: ../FRONT/html/$pagina");
                exit;
            } else {
                $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Senha incorreta'];
                header("Location: ../FRONT/html/loginbase.html");
                exit;
            }
        }
        $stmt->close();
    }

    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Usuário não encontrado'];
    header("Location: ../FRONT/html/loginbase.html");
    $db->close();
    exit;
}
?>