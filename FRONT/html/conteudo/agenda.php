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
    <script src="js/carregaconteudo.js"></script>

<div class="pagina">
    <h2>Agenda</h2>
    <p>Comunicados Da Turma</p>

    <?php

include "../../../BACK/conecta_db.php";

    $oMysql = conecta_db(); 



    session_start();

    if(!isset($_SESSION['tipoUsuario']) || !isset($_SESSION['usuario'])) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Usuário não logado'];
        header("Location: ../loginbase.html");
        exit;
    }

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
                JOIN tb_aluno a ON a.idTurma = t.idTurma
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
            
            #definir botões de editar e excluir vazios
            $botoes = "";


#Se o tipo de usuario for "responsável" vai aparecer os comunicados sem as opções e editar e excluir

            if($_SESSION['tipoUsuario'] == 1){

            #template comunicado
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



#Se o tipo de usuario for "professor" ou "coordenador" vai aparecer os comunicados com as opções e editar e excluir

            if($_SESSION['tipoUsuario'] == 2 || $_SESSION['tipoUsuario'] == 3){

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
