<?php
include(__DIR__ . "/conecta_db.php");

function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($i = 0; $i < $t; $i++) {
            $soma += $cpf[$i] * (($t + 1) - $i);
        }
        $digito = ((10 * $soma) % 11) % 10;
        if ($cpf[$i] != $digito) {
            return false;
        }
    }

    return true;
}

if (
    isset($_POST['cpfCoordenador']) &&
    isset($_POST['nomeCoordenador']) &&
    isset($_POST['emailCoordenador']) &&
    isset($_POST['senhaCoordenador']) &&
    isset($_POST['confirmaSenha'])
) {
    $cpf     = $_POST['cpfCoordenador'];
    $nome    = $_POST['nomeCoordenador'];
    $email   = $_POST['emailCoordenador'];
    $senha   = $_POST['senhaCoordenador'];
    $confirm = $_POST['confirmaSenha'];

    if ($senha !== $confirm) {
        die("As senhas não coincidem.");
    }

    if (!validarCPF($cpf)) {
        die("CPF inválido.");
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $db = conecta_db();

    // Verifica duplicidade de email
    $checkEmail = $db->prepare("SELECT COUNT(*) FROM tb_coordenador WHERE emailCoordenador = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->bind_result($existeEmail);
    $checkEmail->fetch();
    $checkEmail->close();

    if ($existeEmail > 0) {
        die("Este e-mail já está cadastrado.");
    }

    // Verifica duplicidade de CPF
    $checkCPF = $db->prepare("SELECT COUNT(*) FROM tb_coordenador WHERE cpfCoordenador = ?");
    $checkCPF->bind_param("s", $cpf);
    $checkCPF->execute();
    $checkCPF->bind_result($existeCPF);
    $checkCPF->fetch();
    $checkCPF->close();

    if ($existeCPF > 0) {
        die("Este CPF já está cadastrado.");
    }

    // Insere na tb_usuario
    $sqlUsuario = "INSERT INTO tb_usuario (tipoUsuario) VALUES (3)";
    if ($db->query($sqlUsuario)) {
        $idUsuario = $db->insert_id;

        // Insere na tb_coordenador
        $stmt = $db->prepare("INSERT INTO tb_coordenador 
            (cpfCoordenador, idUsuario, nomeCoordenador, emailCoordenador, senhaCoordenador) 
            VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("sisss", $cpf, $idUsuario, $nome, $email, $senhaHash);

        if ($stmt->execute()) {
            header("Location: ../FRONT/html/paginaCoordenador.html");
            exit;
        } else {
            echo "Erro ao cadastrar coordenador: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro ao cadastrar usuário: " . $db->error;
    }

    $db->close();
}
?>
