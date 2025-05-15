<?php
include(__DIR__ . "/conecta_db.php");

if (
    isset($_POST['nomeProfessor']) &&
    isset($_POST['emailProfessor']) &&
    isset($_POST['senhaProfessor']) &&
    isset($_POST['confirmaSenha'])
) {
    $nome     = $_POST['nomeProfessor'];
    $email    = $_POST['emailProfessor'];
    $senha    = $_POST['senhaProfessor'];
    $confirma = $_POST['confirmaSenha'];

    if ($senha !== $confirma) {
        die("As senhas não coincidem.");
    }

    $oMysql = conecta_db();

    //verifica se o usuario ja possui conta
    $verificaEmail = $oMysql->prepare("SELECT COUNT(*) FROM tb_professor WHERE emailProfessor = ?");
    $verificaEmail->bind_param("s", $email);
    $verificaEmail->execute();
    $verificaEmail->bind_result($existe);
    $verificaEmail->fetch();
    $verificaEmail->close();

    if ($existe > 0) {
        die("Este e-mail já está cadastrado.");
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // insere em tb_usuario
    $sqlUsuario = "INSERT INTO tb_usuario (tipoUsuario) VALUES (2)";
    if ($oMysql->query($sqlUsuario) === TRUE) {
        $idUsuario = $oMysql->insert_id;

        // insere em tb_professor
        $sqlProfessor = "INSERT INTO tb_professor (nomeProfessor, emailProfessor, senhaProfessor, idUsuario)
                         VALUES (?, ?, ?, ?)";
        $stmt = $oMysql->prepare($sqlProfessor);
        $stmt->bind_param("sssi", $nome, $email, $senhaHash, $idUsuario);

        if ($stmt->execute()) {
            header("Location: ../FRONT/html/paginaProfessor.html");
            exit;
        } else {
            echo "Erro ao cadastrar professor: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro ao cadastrar usuário: " . $oMysql->error;
    }

    $oMysql->close();
}
?>
