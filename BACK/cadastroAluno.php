<?php
session_start();
include(__DIR__ . "/conecta_db.php");
$oMysql = conecta_db(); 

// Configurações do upload
$pastaDestino = __DIR__ . '/../PROJETO/uploads/alunos/';
$tamanhoMaximo = 2 * 1024 * 1024; // 2MB
$extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];

// Verifica e cria a pasta de uploads se não existir
if (!file_exists($pastaDestino)) {
    mkdir($pastaDestino, 0777, true);
}

if(isset($_POST['nomeAluno']) && isset($_POST['dataNasc'])) {
    $nomeAluno = $_POST['nomeAluno'];
    $dataNasc = $_POST['dataNasc'];
    $idTurma = $_POST['idTurma'];
    $nomeUnico = null;

    // Processamento do upload da imagem
    if(isset($_FILES['fotoAluno']) && $_FILES['fotoAluno']['error'] == UPLOAD_ERR_OK) {
        $arquivo = $_FILES['fotoAluno'];
        
        // Validações de segurança
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        
        // Verifica a extensão do arquivo
        if(!in_array($extensao, $extensoesPermitidas)) {
            $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Tipo de arquivo não permitido. Use apenas JPG, JPEG, PNG ou GIF.'];
            header("Location: ../FRONT/html/paginaCoordenador.php");
            exit;
        }
        
        // Verifica o tamanho do arquivo
        if($arquivo['size'] > $tamanhoMaximo) {
            $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Arquivo muito grande. Tamanho máximo permitido: 2MB.'];
            header("Location: ../FRONT/html/paginaCoordenador.php");
            exit;
        }
        
        // Gera um nome único para o arquivo
        $nomeUnico = uniqid() . '.' . $extensao;
        
        // Move o arquivo para o destino
        if(!move_uploaded_file($arquivo['tmp_name'], $pastaDestino . $nomeUnico)) {
            $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao salvar a imagem.'];
            header("Location: ../FRONT/html/paginaCoordenador.php");
            exit;
        }
    }

    // Prepared statement para inserir no banco
    $query = "INSERT INTO tb_aluno (nomeAluno, dataNasc, idTurma, fotoAluno)
              VALUES (?, ?, ?, ?)";

    $stmt = $oMysql->prepare($query);
    $stmt->bind_param("ssis", $nomeAluno, $dataNasc, $idTurma, $nomeUnico);
    
    if($stmt->execute()) {
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Aluno criado com sucesso!'];
    } else {
        // Se houve erro, remove a imagem que foi upada (se existir)
        if($nomeUnico && file_exists($pastaDestino . $nomeUnico)) {
            unlink($pastaDestino . $nomeUnico);
        }
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro na criação do aluno: ' . $stmt->error];
    }
    
    $stmt->close();
    header("Location: ../FRONT/html/paginaCoordenador.php");
    exit;
}
?>