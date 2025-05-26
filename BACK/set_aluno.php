<?php
session_start();

if (isset($_POST['matriculaAluno'])) {
    $_SESSION['alunoSelecionado'] = intval($_POST['matriculaAluno']);
    $_SESSION['mensagem'] = ['tipo' => 'sucess', 'texto' => 'Aluno Selecionado'];
    header("Location: ../FRONT/html/paginaResponsavel.php");
    exit;
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID não recebido']);
}
