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
    <h2>Configurações</h2>
    <p>Atualize as informações de sua conta</p></br>

    <?php
    
    include "../../../PROJETO/conecta_db.php";
    $oMysql = conecta_db();

    session_start();

    // Verifica se o usuário está logado
    if(!isset($_SESSION['tipoUsuario']) || !isset($_SESSION['usuario'])) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Usuário não logado'];
        header("Location: ../loginbase.html");
        exit;
    }

#PERFIS DE USUÁRIO
#RESPONSAVEL

    if($_SESSION['tipoUsuario'] == 1){
        $sql = "SELECT * FROM tb_responsavel WHERE idUsuario = ".$_SESSION['usuario'];
    }

#PROFESSOR

    if($_SESSION['tipoUsuario'] == 2){
        $sql = "SELECT * FROM tb_professor WHERE idUsuario = ".$_SESSION['usuario'];
    }

#COORDENADOR

    if($_SESSION['tipoUsuario'] == 3){
        $sql = "SELECT * FROM tb_coordenador WHERE idUsuario = ".$_SESSION['usuario'];
    }
    

    $resultado = $oMysql->query($sql);

    $nome = "";
	$email = "";
	$senha = "";
    $cpf = "";


#RESPONSAVEL 
    
    if($_SESSION['tipoUsuario'] == 1){
		if($resultado){
			while($linha = $resultado->fetch_object()){
				$nome = $linha->nomeResponsavel;
				$email = $linha->emailResponsavel;
				$senha = $linha->senhaResponsavel;
			}
		} 

        ?>
        <form method="POST"
                action="../../BACK/updateConta.php?idUsuario=<?php echo $_SESSION['usuario']; ?>"
            style="display: flex; flex-direction: column; min-height: 70vh; align-items: center">

            <div class="form-group">
                <label for="nomeResponsavel" class="t1">Nome completo</label>
                <input class="form-control"
                style="width: 400px;"
                type="text"
                id="nomeResponsavel"
                name="nomeResponsavel"
                value="<?php echo $nome ?>"
                required>
            </div>

            <div class="form-group">
                <label for="emailResponsavel" class="t1">Email</label>
                <input class="form-control"
                style="width: 400px;"
                type="email"
                id="emailResponsavel"
                name="emailResponsavel"
                value="<?php echo $email ?>"
                required>
            </div>

            <div class="form-group">
                <label for="senhaResponsavel" class="t1">Senha</label>
                <input class="form-control"
                style="width: 400px;"
                type="password"
                id="senhaResponsavel"
                name="senhaResponsavel"
                placeholder="Redefinir senha"
                required>
            </div>

            <button type="submit" class="btn btn-outline-primary">Editar</button>

        </form>
    <?php }

    
    
#PROFESSOR
    
    if($_SESSION['tipoUsuario'] == 2){
		if($resultado){
			while($linha = $resultado->fetch_object()){
				$nome = $linha->nomeProfessor;
				$email = $linha->emailProfessor;
				$senha = $linha->senhaProfessor;
			}
		} 

        ?>
        <form method="POST"
                action="../../BACK/updateConta.php?idUsuario=<?php echo $_SESSION['usuario']; ?>"
            style="display: flex; flex-direction: column; min-height: 70vh; align-items: center">

            <div class="form-group">
                <label for="nomeProfessor" class="t1">Nome completo</label>
                <input class="form-control"
                style="width: 400px;"
                type="text"
                id="nomeProfessor"
                name="nomeProfessor"
                value="<?php echo $nome ?>"
                required>
            </div>

            <div class="form-group">
                <label for="emailProfessor" class="t1">Email</label>
                <input class="form-control"
                style="width: 400px;"
                type="email"
                id="emailProfessor"
                name="emailProfessor"
                value="<?php echo $email ?>"
                required>
            </div>

            <div class="form-group">
                <label for="senhaProfessor" class="t1">Senha</label>
                <input class="form-control"
                style="width: 400px;"
                type="password"
                id="senhaProfessor"
                name="senhaProfessor"
                placeholder="Redefinir senha"
                required>
            </div>

            <button type="submit" class="btn btn-outline-primary">Editar</button>

        </form>
    <?php }



#COORDENADOR

    if($_SESSION['tipoUsuario'] == 3){
		if($resultado){
			while($linha = $resultado->fetch_object()){
				$nome = $linha->nomeCoordenador;
				$email = $linha->emailCoordenador;
				$senha = $linha->senhaCoordenador;
                $cpf = $linha->cpfCoordenador;
			}
		} 

        ?>
        <form method="POST"
                action="../../BACK/updateConta.php?idUsuario=<?php echo $_SESSION['usuario']; ?>"
            style="display: flex; flex-direction: column; min-height: 70vh; align-items: center">

            <div class="form-group">
                <label for="nomeCoordenador" class="t1">Nome completo</label>
                <input class="form-control"
                style="width: 400px;"
                type="text"
                id="nomeCoordenador"
                name="nomeCoordenador"
                value="<?php echo $nome ?>"
                required>
            </div>

            <div class="form-group">
                <label for="emailCoordenador" class="t1">Email</label>
                <input class="form-control"
                style="width: 400px;"
                type="email"
                id="emailCoordenador"
                name="emailCoordenador"
                value="<?php echo $email ?>"
                required>
            </div>

            <div class="form-group">
                <label for="cpfCoordenador" class="t1">CPF</label>
                <input class="form-control"
                style="width: 400px;"
                type="text"
                id="cpfCoordenador"
                name="cpfCoordenador"
                value="<?php echo $cpf ?>"
                readonly>
            </div>

            <div class="form-group">
                <label for="senhaCoordenador" class="t1">Senha</label>
                <input class="form-control"
                style="width: 400px;"
                type="password"
                id="senhaCoordenador"
                name="senhaCoordenador"
                placeholder="Redefinir senha"
                required>
            </div>

            <button type="submit" class="btn btn-outline-primary">Editar</button>

        </form>
    <?php }
    
    
    ?>




</div>


<style>


    .pagina {
        margin-left: 20vh;

    }

    .t1 {
        text-align: left;
    }

</style>