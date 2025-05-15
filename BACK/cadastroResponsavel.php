<?php
include(__DIR__ . "/conecta_db.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (
    isset($_POST['nomeResponsavel']) &&
    isset($_POST['emailResponsavel']) &&
    isset($_POST['senhaResponsavel']) &&
    isset($_POST['confirmaSenha']) &&
    isset($_POST['matriculaAluno'])
) {
    $nome     = $_POST['nomeResponsavel'];
    $email    = $_POST['emailResponsavel'];
    $senha    = $_POST['senhaResponsavel'];
    $confirma = $_POST['confirmaSenha'];
    $matriculas = $_POST['matriculaAluno']; // ← agora é array

    if ($senha !== $confirma) {
        die("As senhas não coincidem.");
    }

    $oMysql = conecta_db();

    // Verifica duplicidade de e-mail
    $verificaEmail = $oMysql->prepare("SELECT COUNT(*) FROM tb_responsavel WHERE emailResponsavel = ?");
    $verificaEmail->bind_param("s", $email);
    $verificaEmail->execute();
    $verificaEmail->bind_result($existe);
    $verificaEmail->fetch();
    $verificaEmail->close();

    if ($existe > 0) {
        die("Este e-mail já está cadastrado.");
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere na tb_usuario
    $sqlUsuario = "INSERT INTO tb_usuario (tipoUsuario) VALUES (1)";
    if ($oMysql->query($sqlUsuario)) {
        $idUsuario = $oMysql->insert_id;

        // Insere na tb_responsavel
        $stmt = $oMysql->prepare("INSERT INTO tb_responsavel (nomeResponsavel, emailResponsavel, senhaResponsavel, idUsuario)
                                  VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nome, $email, $senhaHash, $idUsuario);
        if ($stmt->execute()) {
            $stmt->close();

            foreach ($matriculas as $matricula) {
                $matricula = trim($matricula);

                $check = $oMysql->prepare("SELECT matriculaAluno FROM tb_aluno WHERE matriculaAluno = ?");
                $check->bind_param("s", $matricula);
                $check->execute();
                $check->store_result();

                if ($check->num_rows > 0) {
                    $vinc = $oMysql->prepare("INSERT INTO tb_responsavel_aluno (idUsuario, matriculaAluno) VALUES (?, ?)");
                    $vinc->bind_param("is", $idUsuario, $matricula);
                    $vinc->execute();
                    $vinc->close();
                }

                $check->close();
            }

            header("Location: ../FRONT/html/paginaResponsavel.html");
            exit;

        } else {
            echo "Erro ao cadastrar responsável: " . $stmt->error;
        }

    } else {
        echo "Erro ao cadastrar usuário: " . $oMysql->error;
    }

    $oMysql->close();
}
?>
