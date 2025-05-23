<?php

#Destruir informações ada session quando fazer logout

session_start();
session_unset(); // limpa todas as variáveis de sessão
session_destroy();
header("Location: ../FRONT/html/index.html");
exit();
?>
