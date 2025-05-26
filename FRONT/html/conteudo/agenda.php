<script src="js/carregaconteudo.js"></script>

<div class="pagina">
    <h2>Agenda</h2>
    <p>Comunicados Da Turma</p>

    <?php

include "../../../PROJETO/conecta_db.php";

    $oMysql = conecta_db(); 



    session_start();


    #Comando php para botão "criar comunicado" aparecer somente para professor

    if($_SESSION['tipoUsuario'] == 2)
    {
        #verificar se há turma selecionada
    if (!isset($_SESSION['idTurmaSelecionada'])) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Nenhuma turma selecionada'];
        exit;
    }
    ?>

<div class="botao">
    <a href="#" onclick="carregarConteudo('criarComunicado')">
        <button class="btn btn-outline-primary">Criar Comunicado</button>
    </a>
</div>
<br>

    <?php
    }
    ?>
    <br>    




<!-- COMUNICADOS -->

    <?php



    #query para selecionar todos os comunicados da tb_comunicado
    #essa query vai selecionar somente os comunicados relacionados ao id do usuário logado

    #responsável

    if($_SESSION['tipoUsuario'] == 1){
        $sql = "SELECT 
                c.*, p.nomeProfessor, t.nome as nomeTurma
                FROM tb_comunicado c
                JOIN tb_professor p ON c.idProfessor = p.idUsuario
                JOIN tb_turma t ON c.idTurma = t.idTurma
                JOIN tb_aluno a ON a.Turma_idTurma = t.idTurma
                JOIN tb_responsavel_aluno ra ON ra.matriculaAluno = a.matriculaAluno
                WHERE ra.idUsuario = ".$_SESSION['usuario']."
                ORDER BY c.Data DESC";
    }


    #professor

    if($_SESSION['tipoUsuario'] == 2){
        $sql = "SELECT 
            c.*, p.nomeProfessor, t.nome as nomeTurma
            FROM tb_comunicado c
            JOIN tb_professor p ON c.idProfessor = p.idUsuario
            JOIN tb_turma t ON c.idTurma = t.idTurma
            WHERE c.idProfessor = ".$_SESSION['usuario']."
            AND c.idTurma = ".$_SESSION['idTurmaSelecionada']."
            ORDER BY c.Data DESC";
    }

    

    #coordenador

    if($_SESSION['tipoUsuario'] == 3){
        $sql = "SELECT 
            c.*, p.nomeProfessor, t.nome as nomeTurma
            FROM tb_comunicado c
            JOIN tb_professor p ON c.idProfessor = p.idUsuario
            JOIN tb_turma t ON c.idTurma = t.idTurma
            ORDER BY c.Data DESC";
    }

    $resultado = $oMysql->query($sql);



    #transformar todo o conteúdo da tb_comunicado em linhas e, se houver comunicado, printar

    if ($resultado->num_rows > 0) {
        while ($linha = $resultado->fetch_assoc()) {


            #no banco a data está em date-time, dividir em variável "data" e "hora"
            $data = date('d/m', strtotime($linha['Data'])); 
            $hora = date('H:i', strtotime($linha['Data']));

            if($_SESSION['tipoUsuario'] == 1){
            echo '<div class="comunicado">
                    <div class="comunicado-header">
                        <div>Prof. '.$linha['nomeProfessor'].' - '.$linha['nomeTurma'].'</div>
                        <div>'.$data.' - '.$hora.'</div>
                    </div>
                    <div class="comunicado-body">
                        ' . nl2br($linha['Descricao']) . '
                    </div>
                </div>';
            }


            if($_SESSION['tipoUsuario'] == 2 or 3){

                $botoes = "<a 
                class='btn btn-outline-success'
                href='#' 
                onclick=\"carregarConteudo('editarComunicado', { // Inicia a função com o nome da página e um objeto de parâmetros
                    idComunicado: ".$linha['idComunicado']."      // Passa o ID do comunicado como parte do objeto
                })\"
                >Alterar</a>";


                $botoes .= "<a
                            class='btn btn-outline-danger'
                            href='../../BACK/deleteComunicado.php?idComunicado=".$linha['idComunicado']."'>Excluir</a>";
            
        

            #printar template do comunicado
            echo '<div class="comunicado">
                    <div class="comunicado-header">
                        <div>Prof. '.$linha['nomeProfessor'].' - '.$linha['nomeTurma'].'</div>
                        <div>'.$data.' - '.$hora.'</div>
                        <div>'.$botoes.'</div>
                    </div>
                    <div class="comunicado-body">
                        ' . nl2br($linha['Descricao']) . '
                    </div>
                </div>';
            }
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


    .pagina {
        margin-left: 20vh;
    }


    /* template comunicado */

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




    /* Botão criar comunicado */

    .botao {
        text-align: justify;
    }



</style>
