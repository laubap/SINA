<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['tipoUsuario']) || !isset($_SESSION['usuario'])) {
    header('Content-Type: application/json');
    die(json_encode([
        'status' => 'erro', 
        'mensagem' => 'Acesso não autorizado. Faça login novamente.'
    ]));
}

// Verifica se o ID da turma foi recebido
if (!isset($_POST['idTurma'])) {
    header('Content-Type: application/json');
    die(json_encode([
        'status' => 'erro', 
        'mensagem' => 'ID da turma não foi recebido.'
    ]));
}

// Valida e sanitiza o ID da turma
$idTurma = filter_var($_POST['idTurma'], FILTER_VALIDATE_INT);
if ($idTurma === false || $idTurma <= 0) {
    header('Content-Type: application/json');
    die(json_encode([
        'status' => 'erro', 
        'mensagem' => 'ID da turma inválido.'
    ]));
}

// Armazena o ID da turma na sessão
$_SESSION['idTurmaSelecionada'] = $idTurma;
$_SESSION['mensagem'] = [
    'tipo' => 'sucesso', 
    'texto' => 'Turma selecionada com sucesso!'
];

// Determina a página de redirecionamento baseada no tipo de usuário
$paginasRedirecionamento = [
    1 => '../FRONT/html/paginaResponsavel.php',  // Responsável
    2 => '../FRONT/html/paginaProfessor.php',    // Professor
    3 => '../FRONT/html/paginaCoordenador.php'   // Coordenador
];

// Verifica se o tipo de usuário é válido
if (!isset($paginasRedirecionamento[$_SESSION['tipoUsuario']])) {
    header('Content-Type: application/json');
    die(json_encode([
        'status' => 'erro', 
        'mensagem' => 'Tipo de usuário não reconhecido.'
    ]));
}

// Redireciona para a página apropriada
$redirectUrl = $paginasRedirecionamento[$_SESSION['tipoUsuario']];
header("Location: $redirectUrl");
exit;