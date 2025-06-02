<?php
session_start();
include(__DIR__ . "/conecta_db.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (
    isset($_POST['nomeResponsavel']) &&
    isset($_POST['emailResponsavel']) &&
    isset($_POST['senhaResponsavel']) &&
    isset($_POST['confirmaSenha']) &&
    isset($_POST['matriculaAluno']) &&
    isset($_POST['telefoneResponsavel'])
) {
    $nome     = $_POST['nomeResponsavel'];
    $email    = $_POST['emailResponsavel'];
    $senha    = $_POST['senhaResponsavel'];
    $confirma = $_POST['confirmaSenha'];
    $telefone = $_POST['telefoneResponsavel'];
    $matriculas = $_POST['matriculaAluno']; 

    if ($senha !== $confirma) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Senhas não coincidem'];
        header("Location: ../FRONT/html/paginaCadastroResponsavel.html");
        exit;
    }

    $regexSenhaForte = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^])[A-Za-z\d@$!%*?&#^]{8,}$/';

    if (!preg_match($regexSenhaForte, $senha)) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'A senha deve ter no mínimo 8 caracteres, incluindo letra maiúscula, minúscula, número e símbolo.'];
        header("Location: ../FRONT/html/paginaCadastroResponsavel.html");
        exit;
    }

    $oMysql = conecta_db();

    // Verifica duplicidade de e-mail
    $verificaEmail = $oMysql->prepare("SELECT COUNT(*) FROM tb_responsavel WHERE emailResponsavel = ? OR telefoneResponsavel = ?");
    $verificaEmail->bind_param("ss", $email, $telefone);
    $verificaEmail->execute();
    $verificaEmail->bind_result($existe);
    $verificaEmail->fetch();
    $verificaEmail->close();

    if ($existe > 0) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Email ou telefone já cadastrado'];
        header("Location: ../FRONT/html/paginaCadastroResponsavel.html");
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Após as outras validações
    if (!preg_match('/^\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}$/', $telefone)) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Formato de telefone inválido. Use (99) 99999-9999'];
        header("Location: ../FRONT/html/paginaCadastroResponsavel.html");
        exit;
    }

    // Insere na tb_usuario
    $sqlUsuario = "INSERT INTO tb_usuario (tipoUsuario) VALUES (1)";
    if ($oMysql->query($sqlUsuario)) {
        $idUsuario = $oMysql->insert_id;

        // Insere na tb_responsavel
        $stmt = $oMysql->prepare("INSERT INTO tb_responsavel (nomeResponsavel, emailResponsavel, senhaResponsavel, telefoneResponsavel, idUsuario)
                                  VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nome, $email, $senhaHash, $telefone, $idUsuario);
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
            $_SESSION['tipoUsuario'] = 1;
            $_SESSION['mensagem'] = ['tipo' => 'sucess', 'texto' => 'Responsável cadastrado'];
            header("Location: ../FRONT/html/paginaResponsavel.php");
            $oMysql->close();
            exit;

        } else {
            $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao cadastrar responsável'];
            header("Location: ../FRONT/html/paginaCadastroResponsavel.html");
            $oMysql->close();
            exit;
        }
    }

    $oMysql->close();
}
?>
