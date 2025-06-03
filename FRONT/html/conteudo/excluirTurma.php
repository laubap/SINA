<?php
session_start();
include "../../../BACK/conecta_db.php";

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

// Verifica se a turma tem alunos vinculados
$temAlunos = $oMysql->query("SELECT COUNT(*) as total FROM tb_aluno WHERE idTurma = $idTurma")->fetch_assoc()['total'];

if ($temAlunos > 0) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Não é possível excluir turma com alunos vinculados'];
    header("Location: ../paginaCoordenador.php");
    exit;
}

// Exclui a turma
$sql = "DELETE FROM tb_turma WHERE idTurma = ?";
$stmt = $oMysql->prepare($sql);
$stmt->bind_param("i", $idTurma);

if ($stmt->execute()) {
    $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Turma excluída com sucesso!'];
} else {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao excluir turma: ' . $stmt->error];
}

$stmt->close();
header("Location: ../paginaCoordenador.php");
exit;