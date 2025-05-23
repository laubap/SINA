<?php

#Destruir informações da session quando usuário clicar em sair, impossibilitando q seja possível voltar para a página

session_start();
session_unset(); // limpa todas as variáveis de sessão
session_destroy();
header("Location: ../FRONT/html/index.html");
exit();
?>
