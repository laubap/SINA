<?php
session_start();
include(__DIR__ . "/conecta_db.php");

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $db = conecta_db();

    // Verifica em cada tabela
    $consultas = [
        ['tb_coordenador', 'emailCoordenador', 'senhaCoordenador', 3, 'paginaCoordenador.php'],
        ['tb_professor', 'emailProfessor', 'senhaProfessor', 2, 'paginaProfessor.php'],
        ['tb_responsavel', 'emailResponsavel', 'senhaResponsavel', 1, 'paginaResponsavel.php']
    ];

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
                die("Senha incorreta.");
            }
        }

        $stmt->close();
    }

    echo "Usuário não encontrado.";
    $db->close();
}
?>

