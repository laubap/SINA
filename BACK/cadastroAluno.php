<?php
session_start();
include(__DIR__ . "/conecta_db.php");
$oMysql = conecta_db(); 

if(isset($_POST['nomeAluno']) && isset($_POST['dataNasc'])){
    $nomeAluno = $_POST['nomeAluno'];
    $dataNasc = $_POST['dataNasc'];
    $idTurma = $_POST['idTurma'];
    


#teste prepared statement pra evitar sql injection
    $query = "INSERT INTO tb_aluno (nomeAluno, dataNasc, idTurma)
                VALUES (?, ?, ?)";

    $stmt = $oMysql->prepare($query);
    $stmt->bind_param("ssi", $nomeAluno, $dataNasc, $idTurma);
    
    if($stmt->execute()){
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Aluno criado'];
        header("Location: ../FRONT/html/paginaCoordenador.php");
        exit;
    } else {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro na criação de aluno'];
        header("Location: ../FRONT/html/paginaCoordenador.php");
        exit;
    }
    $stmt->close();
}
?>