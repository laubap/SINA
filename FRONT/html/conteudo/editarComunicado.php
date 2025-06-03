<!-- LINK CSS -->

    <link rel="stylesheet" href="../css/paginaCadastro.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />



<!-- LINK JS -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alert.js"></script>

<?php
session_start();

// Verifica se o usuário está logado
if(!isset($_SESSION['tipoUsuario']) || !isset($_SESSION['usuario'])) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Usuário não logado'];
    header("Location: ../loginbase.html");
    exit;
}


include "../../../BACK/conecta_db.php";
$oMysql = conecta_db(); 



if(isset($_POST['descricao'])){
    $idTurma = $_SESSION['idTurmaSelecionada'];
    $idProfessor = $_SESSION['usuario'];
    $descricao = $_POST['descricao'];


    #prepared statement contra sql inject
    $query = "UPDATE tb_comunicado 
              SET idTurma = ?, 
                  idProfessor = ?,
                  Descricao = ?
              WHERE idComunicado = ?";

    $stmt = $oMysql->prepare($query);

    #"iisi" = "INT, INT, STRING, INT"
    $stmt->bind_param("iisi", $idTurma, $idProfessor, $descricao, $_GET['idComunicado']);
    

    #se a query foi realizada, acionar mensagem de sucesso, senão erro
    if($stmt->execute()){
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Comunicado editado'];
        $fallback = "../FRONT/index.html";
        $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;
        header("Location: $anterior");
        exit;
    } else {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao editar comunicado'];
        $fallback = "../FRONT/index.html";
        $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;
        header("Location: $anterior");
        exit;
    }
    $stmt->close();
}
?>

<div class="pagina">
    <h2>Editar Comunicado</h2>
    <br>

    <?php
    
    # Verificar se há turma selecionada
    if (!isset($_SESSION['idTurmaSelecionada'])) {
        echo "<p style='color: red;'>Erro: Nenhuma turma selecionada!</p>";
        echo "<a href='lista_turmas.php'>Selecionar Turma</a>";
        exit;
    }
    ?>

    <form method="POST" action="conteudo/editarComunicado.php">
        <textarea
            name="descricao"
            rows="4"
            cols="50"
            maxlength="500"
            style="width: 800px; height: 250px"
            required></textarea>

        <br><br>
        <button type="submit" class="btn btn-outline-primary">Editar</button>
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