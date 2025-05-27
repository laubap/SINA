<?php
session_start();
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

    $regexSenhaForte = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^])[A-Za-z\d@$!%*?&#^]{8,}$/';

    if (!preg_match($regexSenhaForte, $senha)) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'A senha deve ter no mínimo 8 caracteres, incluindo letra maiúscula, minúscula, número e símbolo.'];
        header("Location: ../FRONT/html/paginaCadastroProfessor.html");
        exit;
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
            $_SESSION['mensagem'] = ['tipo' => 'sucess', 'texto' => 'Professor cadastrado'];
            header("Location: ../FRONT/html/paginaProfessor.php");
            exit;
        } else {
            $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao cadastrar Professor'];
        header("Location: ../FRONT/html/paginaCadastroProfessor.html");
        exit;
        }
        $stmt->close();
    } else {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao cadastrar usuario'];
        header("Location: ../FRONT/html/paginaCadastroProfessor.html");
        exit;
    }

    $oMysql->close();
}
?>
