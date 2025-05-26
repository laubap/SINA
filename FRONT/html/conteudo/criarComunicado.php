<?php
session_start();
include "../../../PROJETO/conecta_db.php";
$oMysql = conecta_db(); 

if(isset($_POST['descricao'])){
    $idTurma = $_SESSION['idTurmaSelecionada'];
    $idProfessor = $_SESSION['usuario'];
    $descricao = $_POST['descricao'];
    


#teste prepared statement pra evitar sql injection
    $query = "INSERT INTO tb_comunicado (idTurma, idProfessor, Descricao) VALUES (?, ?, ?)";
    $stmt = $oMysql->prepare($query);
    $stmt->bind_param("iis", $idTurma, $idProfessor, $descricao);
    
    if($stmt->execute()){
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Comunicado Criado'];
        header("Location: ../paginaProfessor.php");
        exit;
    } else {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro na criação do comunicado'];
        header("Location: ../paginaProfessor.php");
        exit;
    }
    $stmt->close();
}
?>

<div class="pagina">
    <h2>Criar Comunicado</h2>
    <br>

    <?php
    
    // Verificar se há turma selecionada
    if (!isset($_SESSION['idTurmaSelecionada'])) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Nenhuma turma selecionada'];
        header("Location: ../paginaProfessor.php");
        exit;
    }
    ?>

    <form method="POST" action="conteudo/criarComunicado.php">
        <textarea
            name="descricao"
            rows="4"
            cols="50"
            maxlength="500"
            placeholder="Digite seu comunicado"
            style="width: 800px; height: 250px"
            required></textarea>

        <br><br>
        <button type="submit" class="btn btn-outline-primary">Criar</button>
    </form>
</div>

<style>
.pagina {
    margin-left: 20vh;
}
</style>

<?php
$oMysql->close();
?>