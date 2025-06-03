<?php
session_start();
include "../../../BACK/conecta_db.php";

// Verifica se é coordenador
if ($_SESSION['tipoUsuario'] != 3) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Acesso restrito a coordenadores'];
    header("Location: ../paginaCoordenador.php");
    exit;
}

if (!isset($_GET['id'])) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Turma não especificada'];
    header("Location: ../paginaCoordenador.php");
    exit;
}

$idTurma = intval($_GET['id']);
$oMysql = conecta_db();

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeTurma = trim($_POST['nomeTurma']);
    $sala = intval($_POST['sala']);
    $idProfessor = intval($_POST['idProfessor']);

    // Validação
    if (empty($nomeTurma) || $sala <= 0 || $idProfessor <= 0) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Preencha todos os campos corretamente'];
        header("Location: editarTurma.php?id=$idTurma");
        exit;
    }

    // Atualização no banco
    $sql = "UPDATE tb_turma SET Nome = ?, Sala = ?, idProfessor = ? WHERE idTurma = ?";
    $stmt = $oMysql->prepare($sql);
    $stmt->bind_param("siii", $nomeTurma, $sala, $idProfessor, $idTurma);
    
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Turma atualizada com sucesso!'];
        header("Location: ../paginaCoordenador.php");
    } else {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao atualizar turma: ' . $stmt->error];
        header("Location: editarTurma.php?id=$idTurma");
    }
    
    $stmt->close();
    exit;
}

// Busca os dados da turma
$turma = $oMysql->query("SELECT * FROM tb_turma WHERE idTurma = $idTurma")->fetch_assoc();
if (!$turma) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Turma não encontrada'];
    header("Location: ../paginaCoordenador.php");
    exit;
}

// Busca a lista de professores
$professores = $oMysql->query("SELECT idUsuario, nomeProfessor FROM tb_professor");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Turma</title>
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
                        <h4>Editar Turma</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['mensagem']) && is_array($_SESSION['mensagem'])): ?>
                            <div class="alert alert-<?= ($_SESSION['mensagem']['tipo'] ?? '') == 'erro' ? 'danger' : 'success' ?> alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['mensagem']['texto'] ?? '') ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['mensagem']); ?>
                        <?php endif; ?>

                        <form method="POST" action="editarTurma.php?id=<?= $idTurma ?>">
                            <div class="form-group">
                                <label for="nomeTurma">Nome da Turma</label>
                                <input type="text" class="form-control" id="nomeTurma" name="nomeTurma" 
                                       value="<?= htmlspecialchars($turma['Nome'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="sala">Número da Sala</label>
                                <input type="number" class="form-control" id="sala" name="sala" 
                                       value="<?= htmlspecialchars($turma['Sala'] ?? '') ?>" required min="1">
                            </div>
                            <div class="form-group">
                                <label for="idUsuario">Professor Responsável</label>
                                <select class="form-control" id="idProfessor" name="idProfessor" required>
                                    <option value="">Selecione um professor</option>
                                    <?php if(isset($professores)): ?>
                                        <?php while($prof = $professores->fetch_assoc()): ?>
                                            <option value="<?= $prof['idUsuario'] ?>" 
                                                <?= (isset($turma['Professor_Usuario_idUsuario']) && $prof['idUsuario'] == $turma['Professor_Usuario_idUsuario']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($prof['nomeProfessor'] ?? '') ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            <a href="../paginaCoordenador.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>