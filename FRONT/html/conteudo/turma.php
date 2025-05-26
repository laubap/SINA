<div class="pagina">
    <h2>Lista de Turmas</h2>
    <p>Aqui estão as turmas cadastradas no sistema</p>




    <?php

    session_start();

#TURMAS



    include "../../../PROJETO/conecta_db.php";

    $oMysql = conecta_db(); 

    #query para selecionar todos as turmas da tb_turma
    #essa query vai selecionar somente as turmas relacionadas ao id do usuário logado

    if($_SESSION['tipoUsuario'] == 1){
        $sql = "SELECT *
                FROM tb_turma
                WHERE idProfessor = ".$_SESSION['usuario'];
    }

    if($_SESSION['tipoUsuario'] == 2){
        $sql = "SELECT *
                FROM tb_turma
                WHERE idProfessor = ".$_SESSION['usuario'];
    }

    if($_SESSION['tipoUsuario'] == 3){
        $sql = "SELECT *
                FROM tb_turma";
    }


    $resultado = $oMysql->query($sql);



    #transformar todo o conteúdo da tb_comunicado em linhas e, se houver comunicado, printar

    if ($resultado->num_rows > 0) {
    echo '<div class="container-turmas">';

    while ($turma = $resultado->fetch_assoc()) {
        ?>
        <form method="POST" action="../../BACK/set_turma.php" style="display: inline;">
            <input type="hidden" name="idTurma" value="<?= $turma['idTurma'] ?>">
            <button type="submit" class="card-turma">
                <?= htmlspecialchars($turma['Nome']) ?>
            </button>
        </form>
        <?php
    }

    echo '</div>';
}
    

    #se n tiver turma registrada, aparecer erro e fechar conexão com banco
    
    else {
        echo "<p>Nenhuma turma encontrada.</p>";
    }

    $oMysql->close();

    ?>

</div>



<style>

    .pagina {
        margin-left: 20vh;
    }



/* Estilo dos cards de turma */
.container-turmas {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* centraliza os cards quando tem poucos */
    gap: 20px;
    margin-top: 20px;
}

.card-turma {
    width: 300px;
    height: 140px;
    border: 1px solid #ddd;
    border-radius: 12px;
    background-color: #f4f4f4;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: bold;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    text-align: center;
}


.card-turma:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    background-color: #e9f0ff;
}


</style>