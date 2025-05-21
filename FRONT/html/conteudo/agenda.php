<div class="pagina">
    <h2>Agenda</h2>
    <p>Comunicados Da Turma</p>


<!-- Comando php para botão "criar comunicado" aparecer somente para professor -->

    <?php
    session_start();

    if($_SESSION['tipoUsuario'] == 2)
    {
    ?>

<div class="botao">
    <a href="">
        <button class="btn btn-success">Criar Comunicado</button>
    </a>
</div>
<br>
    <?php
    }
    ?>





    <br>    

<!-- COMUNICADOS -->

    <?php

    include "../../../PROJETO/conecta_db.php";

    $oMysql = conecta_db(); 



    #query para selecionar todos os comunicados da tb_comunicado

    $sql = "SELECT c.*, p.nomeProfessor 
            FROM tb_comunicado c
            JOIN tb_professor p ON c.idProfessor = p.idUsuario
            ORDER BY Data DESC";

    $resultado = $oMysql->query($sql);



    #transformar todo o conteúdo da tb_comunicado em linhas e, se houver comunicado, printar

    if ($resultado->num_rows > 0) {
        while ($linha = $resultado->fetch_assoc()) {


            #no banco a data está em date-time, dividir em variável "data" e "hora"
            $data = date('d/m', strtotime($linha['Data'])); 
            $hora = date('H:i', strtotime($linha['Data']));


            #printar template do comunicado
            echo '
            <div class="comunicado">
                <div class="comunicado-header">
                    <div>'.$linha['nomeProfessor'].'</div>
                    <div>'.$data.' - '.$hora.'</div>
                </div>
                <div class="comunicado-body">
                    ' . nl2br($linha['Descricao']) . '
                </div>
            </div>';
        }
    }
    

    #se n tiver comunicado registrado, aparecer erro e fechar conexão com banco
    
    else {
        echo "<p>Nenhum comunicado encontrado.</p>";
    }

    $oMysql->close();
    ?>
</div>


<!-- CSS -->

<style>


    /* template comunicado */
    .pagina {
        margin-left: 20vh;
    }

    .comunicado {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        max-width: 100%;
    }

    .comunicado-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    .comunicado-body {
        color: #555;
        text-align: justify;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
    }




    /* Botão */

    .botao {
        text-align: justify;
    }

</style>
