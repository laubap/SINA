<?php
session_start();

if (isset($_POST['idTurma'])) {
    $_SESSION['idTurmaSelecionada'] = intval($_POST['idTurma']);
    $_SESSION['mensagem'] = ['tipo' => 'sucess', 'texto' => 'Turma Selecionada'];
    header("Location: ../FRONT/html/paginaProfessor.php");
    exit;
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID não recebido']);
}
