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



<div class="pagina">
    <h2>Lista de Alunos</h2>
    <p>Aqui estão os alunos cadastrados no sistema.</p>

    <?php


    session_start();
    include "../../../PROJETO/conecta_db.php";
    $oMysql = conecta_db(); 



#RESPONSAVEL

    if($_SESSION['tipoUsuario'] == 1){
        $sql = "SELECT 
                a.*
                FROM tb_aluno a
                JOIN tb_responsavel_aluno ra ON ra.matriculaAluno = a.matriculaAluno
                WHERE ra.idUsuario =".$_SESSION['usuario']."
                ORDER BY a.nomeAluno ASC";
    }


#PROFESSOR

    if($_SESSION['tipoUsuario'] == 2){
        if (!isset($_SESSION['idTurmaSelecionada'])) {
            $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Nenhuma turma selecionada'];
            exit;
        }
        $sql = "SELECT *
                FROM tb_aluno
                WHERE idTurma =".$_SESSION['idTurmaSelecionada']."
                ORDER BY nomeAluno ASC";
    }


#COORDENADOR

    if($_SESSION['tipoUsuario'] == 3){
        $sql = "SELECT *
                FROM tb_aluno
                ORDER BY nomeAluno ASC";
    }


    $resultado = $oMysql->query($sql);


    if ($resultado->num_rows > 0) {
    echo '<div class="container-turmas">';

        while ($aluno = $resultado->fetch_assoc()) {


            if($_SESSION['tipoUsuario'] == 1){
            
    
            ?>
            <form method="POST" action="../../BACK/set_aluno.php" style="display: inline;">
                <input type="hidden" name="matriculaAluno" value="<?= $aluno['matriculaAluno'] ?>">
                <button type="submit" class="card-turma">
                    <?= htmlspecialchars($aluno['NomeAluno']) ?>
                </button>
            </form>
            <?php
            }




            if($_SESSION['tipoUsuario'] == 2 || $_SESSION['tipoUsuario'] == 3){
            
    
            ?>
            <form method="POST" action="conteudo/paginaAluno.php" style="display: inline;">
                <input type="hidden" name="matriculaAluno" value="<?= $aluno['matriculaAluno'] ?>">
                <button type="submit" class="card-turma">
                    <?= htmlspecialchars($aluno['NomeAluno']) ?>
                </button>
            </form>
            <?php
            }
            
        }

    }









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