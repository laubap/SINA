<?php
session_start();
include "../../../BACK/conecta_db.php";

$oMysql = conecta_db();

// Verifica se o usuário está logado como responsável (tipoUsuario 1)
if(!isset($_SESSION['tipoUsuario']) || $_SESSION['tipoUsuario'] != 1 || !isset($_SESSION['usuario'])) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Acesso não autorizado'];
    header("Location: ../loginbase.html");
    exit;
}

// Verifica se idUsuario está na sessão (adicionado esta verificação)
if(!isset($_SESSION['idUsuario'])) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'ID do usuário não encontrado'];
    header("Location: paginaResponsavel.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vinc'])) {
    
    $matriculaAluno = trim($_POST['matriculaAluno']);
    $idUsuario = $_SESSION['idUsuario']; // Usa o ID da sessão

    // Verifica se o aluno existe
    $checkAluno = $oMysql->prepare("SELECT matriculaAluno FROM tb_aluno WHERE matriculaAluno = ?");
    $checkAluno->bind_param("s", $matriculaAluno);
    
    if (!$checkAluno->execute()) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao verificar aluno: ' . $oMysql->error];
        header("Location: ../paginaResponsavel.php");
        exit;
    }
    
    $checkAluno->store_result();

    if ($checkAluno->num_rows === 0) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Matrícula não encontrada'];
        $checkAluno->close();
        header("Location: ../paginaResponsavel.php");
        exit;
    }
    $checkAluno->close();

    // Verifica se a associação já existe
    $checkAssoc = $oMysql->prepare("SELECT * FROM tb_responsavel_aluno WHERE matriculaAluno = ? AND idUsuario = ?");
    $checkAssoc->bind_param("si", $matriculaAluno, $idUsuario);
    
    if (!$checkAssoc->execute()) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao verificar associação: ' . $oMysql->error];
        header("Location: ../paginaResponsavel.php");
        exit;
    }
    
    $checkAssoc->store_result();

    if ($checkAssoc->num_rows > 0) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Esta associação já existe'];
        $checkAssoc->close();
        header("Location: ../paginaResponsavel.php");
        exit;
    }
    $checkAssoc->close();

    // Cria a associação
    $insert = $oMysql->prepare("INSERT INTO tb_responsavel_aluno (matriculaAluno, idUsuario) VALUES (?, ?)");
    $insert->bind_param("si", $matriculaAluno, $idUsuario);

    if ($insert->execute()) {
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Aluno associado com sucesso!'];
    } else {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao associar: ' . $insert->error];
    }
    $insert->close();
    header("Location: ../paginaResponsavel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../../css/paginaCadastro.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- LINK JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../js/alert.js"></script>
    <title>SINA - Associar Aluno</title>
</head>

<body>
    <div style="display: flex; flex-direction: column; min-height: 70vh; align-items: center; justify-content: center;">
        <div class="text-center">
            <h1>Associar Aluno</h1>
            <p class="descricao">
                Associe um aluno à sua conta no <strong>SINA</strong>
            </p>

            <?php if(isset($_SESSION['mensagem'])): ?>
                <div class="alert alert-<?= $_SESSION['mensagem']['tipo'] === 'erro' ? 'danger' : 'success' ?>">
                    <?= $_SESSION['mensagem']['texto'] ?>
                </div>
                <?php unset($_SESSION['mensagem']); ?>
            <?php endif; ?>

            <form action="conteudo/paginaAssociarAluno.php" method="POST">
                <div class="form-group">
                    <input class="form-control"
                    style="width: 400px;"
                    type="number"
                    id="matriculaAluno"
                    name="matriculaAluno"
                    placeholder="Digite a matrícula do aluno"
                    required>
                </div>

                <button type="submit" name="vinc" class="btn btn-outline-primary">Associar Aluno</button>
                <a href="paginaResponsavel.php" class="btn btn-outline-secondary">Voltar</a>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

<style>
.descricao {
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.btn {
    margin-right: 10px;
    min-width: 150px;
}
</style>