<?php
    if(isset($_POST['nome'])){
        $oMysql = conecta_db();
        $query = "UPDATE tb_usuario 
            SET Nome = '".$_POST['nome']."',
                Email = '".$_POST['email']."',
                tipoUsuario = ".$_POST['tipo_usuario']."
            WHERE idUsuario = ".$_GET['teste_id'];
        $resultado = $oMysql->query($query);
        header('location: index.php');
    }
    
    // Get current user data
    $oMysql = conecta_db();
    $query = "SELECT * FROM tb_usuario WHERE idUsuario = ".$_GET['teste_id'];
    $resultado = $oMysql->query($query);
    $usuario = $resultado->fetch_object();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Editar Usuário</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Editar Usuário - ID: <?php echo $_GET['teste_id']; ?></h2>
  <p>Atualize os campos abaixo:</p>    

    <form method="POST" action="index.php?page=2&teste_id=<?php echo $_GET['teste_id']; ?>">
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" 
                   value="<?php echo $usuario->Nome; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" 
                   value="<?php echo $usuario->Email; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de Usuário</label>
            <select name="tipo_usuario" class="form-control" required>
                <option value="1" <?php echo $usuario->tipoUsuario == 1 ? 'selected' : ''; ?>>Estudante</option>
                <option value="2" <?php echo $usuario->tipoUsuario == 2 ? 'selected' : ''; ?>>Professor</option>
                <option value="3" <?php echo $usuario->tipoUsuario == 3 ? 'selected' : ''; ?>>Coordenador</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
</body>
</html>