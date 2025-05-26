<div class="pagina">
    <h2>Configurações</h2>
    <p>Atualize as informações de sua conta</p></br>

    <?php
    
    include "../../../PROJETO/conecta_db.php";
    $oMysql = conecta_db();

    session_start();

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