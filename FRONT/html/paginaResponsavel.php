<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  

<!-- LINK CSS-->  
  
  <link rel="stylesheet" href="../css/paginaResponsavel.css">
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
  integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
<!-- LINK JS-->

  <script src="../js/loginbase.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../js/alert.js"></script>
  
  
  <title>Sina</title>
</head>

<?php
    session_start();
    if((!isset($_SESSION['tipoUsuario'])) or ($_SESSION['tipoUsuario'] != 1)){
      $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Usuário responsável não logado'];
      header("Location: loginbase.html");
      exit;
    }


    echo '<pre>';
print_r($_SESSION);
echo '</pre>';

?>

<body>
  <div class="main">
    <div class="navegador">
      <img class="logo" src="../imagens/Sem título.jpeg" alt="Logo">
      <a href="#" class="nav-link" onclick="carregarConteudo('agenda')">Agenda</a>
      <a href="#" class="nav-link" onclick="carregarConteudo('configuracoes')">Configurações</a>
      <a href="../../BACK/logout.php" class="nav-link">Sair</a>
    </div>

    <!-- aqui é carregado o conteúdo dos menus na mesma pagina -->
    <div id="conteudo" class="conteudo">
      <p>Bem-vindo! Selecione uma opção no menu.</p>
    </div>
  </div>
  <script src="conteudo/js/carregaconteudo.js"></script>
</body>
</html>
