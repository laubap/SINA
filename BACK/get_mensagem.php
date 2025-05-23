<?php

#Arquivo para receber as mensagens de erro ou sucesso do php e enviar para JS em json


session_start();

if (isset($_SESSION['mensagem'])) {
    echo json_encode($_SESSION['mensagem']);
    unset($_SESSION['mensagem']);
} else {
    echo json_encode(null);
}
?>
