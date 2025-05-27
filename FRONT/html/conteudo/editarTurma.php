<?php
session_start();
include "../../../PROJETO/conecta_db.php";

// Verifica se é coordenador
if ($_SESSION['tipoUsuario'] != 3) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Acesso restrito a coordenadores'];
    header("Location: ../paginaCoordenador.php");
    exit;
}

if (!isset($_GET['id'])) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Turma não especificada'];
    header("Location: ../paginaCoordenador.php");
    exit;
}

$idTurma = intval($_GET['id']);
$oMysql = conecta_db();

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeTurma = trim($_POST['nomeTurma']);
    $sala = intval($_POST['sala']);
    $idProfessor = intval($_POST['idProfessor']);

    // Validação
    if (empty($nomeTurma) || $sala <= 0 || $idProfessor <= 0) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Preencha todos os campos corretamente'];
        header("Location: editarTurma.php?id=$idTurma");
        exit;
    }

    // Atualização no banco
    $sql = "UPDATE tb_turma SET Nome = ?, Sala = ?, Professor_Usuario_idUsuario = ? WHERE idTurma = ?";
    $stmt = $oMysql->prepare($sql);
    $stmt->bind_param("siii", $nomeTurma, $sala, $idProfessor, $idTurma);
    
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Turma atualizada com sucesso!'];
        header("Location: ../paginaCoordenador.php");
    } else {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao atualizar turma: ' . $stmt->error];
        header("Location: editarTurma.php?id=$idTurma");
    }
    
    $stmt->close();
    exit;
}

// Busca os dados da turma
$turma = $oMysql->query("SELECT * FROM tb_turma WHERE idTurma = $idTurma")->fetch_assoc();
if (!$turma) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Turma não encontrada'];
    header("Location: ../paginaCoordenador.php");
    exit;
}

// Busca a lista de professores
$professores = $oMysql->query("SELECT idUsuario, nomeProfessor FROM tb_professor");
?>

<!-- HTML similar ao cadastroTurma.php, mas preenchendo os valores existentes -->