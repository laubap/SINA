<?php
session_start();
include "../../../BACK/conecta_db.php";

// Verifica se é coordenador
if ($_SESSION['tipoUsuario'] != 3) {
    header("Location: ../paginaCoordenador.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matriculaAluno = (int)$_POST['matriculaAluno'];
    $idResponsavel = (int)$_POST['idResponsavel'];

    $oMysql = conecta_db();
    $remove = $oMysql->prepare("DELETE FROM tb_responsavel_aluno WHERE idUsuario = ? AND matriculaAluno = ?");
    $remove->bind_param("ii", $idResponsavel, $matriculaAluno);
    
    if ($remove->execute()) {
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Associação removida com sucesso!'];
    } else {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao remover associação: ' . $remove->error];
    }
    
    $remove->close();
    $oMysql->close();
}

header("Location: ../paginaCoordenador.php");
exit;
?>