<?php 

// Verifica se o usuário está logado
if(!isset($_SESSION['tipoUsuario']) || !isset($_SESSION['usuario'])) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Usuário não logado'];
    header("Location: ../loginbase.html");
    exit;
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/paginaCadastro.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <title>Sina</title>
</head>
<body>
    <div class="blocoPrincipal">
        <div class="login">

            <h1>CADASTRO DE ALUNO</h1>
            <p class="descricao">
                Faça o cadastro no <strong>SINA</strong> <br>
                de um  <strong>aluno</strong>
            </p>

            <form action="../../../BACK/cadastroAluno.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="nomeAluno" class="inputLogin" placeholder="Digite o nome do aluno" required>
    <input type="number" name="matriculaAluno" class="inputLogin" placeholder="Digite a matrícula do aluno" required>
    <input type="text" name="informacaoAluno" class="inputLogin" placeholder="Digite as informações do aluno" required> 
    <input type="number" name="turmaAluno" class="inputLogin" placeholder="Digite a turma do aluno" required> 
    <input type="date" name="dataNascAluno" class="inputLogin" placeholder="Digite a matrícula do aluno" required>
    <input type="file" name="fotoAluno" class="inputLogin" accept="image/*" required>
    <button type="submit" class="loginButton">Cadastre-se</button>
    <a href="index.html" class="loginButton">Sair</a>
</form>
            
        </div>
    </div>
</body>
</html>
