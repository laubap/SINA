<?php
session_start();
include "../PROJETO/conecta_db.php";

// Verifica se é coordenador
if ($_SESSION['tipoUsuario'] != 3) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Acesso restrito a coordenadores'];
    header("Location: ../FRONT/html/paginaCoordenador.php");
    exit;
}

// Processa o formulário de cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oMysql = conecta_db();
    
    $nomeTurma = trim($_POST['nomeTurma']);
    $sala = intval($_POST['sala']);
    $idProfessor = intval($_POST['idProfessor']);

    // Validação básica
    if (empty($nomeTurma) || $sala <= 0 || $idProfessor <= 0) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Preencha todos os campos corretamente'];
        header("Location: cadastroTurma.php");
        exit;
    }

    // Inserção no banco
    $sql = "INSERT INTO tb_turma (Nome, Sala, Professor_Usuario_idUsuario) VALUES (?, ?, ?)";
    $stmt = $oMysql->prepare($sql);
    $stmt->bind_param("sii", $nomeTurma, $sala, $idProfessor);
    
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Turma cadastrada com sucesso!'];
        header("Location: ../FRONT/html/paginaCoordenador.php");
    } else {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao cadastrar turma: ' . $stmt->error];
        header("Location: cadastroTurma.php");
    }
    
    $stmt->close();
    exit;
}

// Se não for POST, mostra o formulário
$oMysql = conecta_db();
$professores = $oMysql->query("SELECT idUsuario, nomeProfessor FROM tb_professor");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Nova Turma</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Cadastrar Nova Turma</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="nomeTurma">Nome da Turma</label>
                                <input type="text" class="form-control" id="nomeTurma" name="nomeTurma" required>
                            </div>
                            <div class="form-group">
                                <label for="sala">Número da Sala</label>
                                <input type="number" class="form-control" id="sala" name="sala" required min="1">
                            </div>
                            <div class="form-group">
                                <label for="idProfessor">Professor Responsável</label>
                                <select class="form-control" id="idProfessor" name="idProfessor" required>
                                    <option value="">Selecione um professor</option>
                                    <?php while($prof = $professores->fetch_assoc()): ?>
                                        <option value="<?= $prof['idUsuario'] ?>"><?= htmlspecialchars($prof['nomeProfessor']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                            <a href="../FRONT/html/paginaCoordenador.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>