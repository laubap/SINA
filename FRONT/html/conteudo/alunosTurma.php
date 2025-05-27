<?php
session_start();
include "../../../PROJETO/conecta_db.php";

// Verifica se há uma turma selecionada
if (!isset($_SESSION['idTurmaSelecionada'])) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Nenhuma turma selecionada'];
    header("Location: /SINA/FRONT/html/paginaProfessor.php");
    exit;
}

$oMysql = conecta_db();
$idTurma = $_SESSION['idTurmaSelecionada'];

// Busca os dados da turma
$turma = $oMysql->query("SELECT * FROM tb_turma WHERE idTurma = $idTurma")->fetch_assoc();

// Busca os alunos da turma
$alunos = $oMysql->query("
    SELECT * 
    FROM tb_aluno 
    WHERE Turma_idTurma = $idTurma
    ORDER BY nomeAluno ASC
");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alunos da Turma</title>
    <link rel="stylesheet" href="../../css/paginaCadastro.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <div class="pagina">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Alunos da Turma: <?= htmlspecialchars($turma['Nome'] ?? '') ?></h2>
            <a href="../paginaProfessor.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-<?= $_SESSION['mensagem']['tipo'] ?>">
                <?= $_SESSION['mensagem']['texto'] ?>
            </div>
            <?php unset($_SESSION['mensagem']); ?>
        <?php endif; ?>

        <div class="container-alunos">
            <?php if ($alunos->num_rows > 0): ?>
                <?php while ($aluno = $alunos->fetch_assoc()): ?>
                    <div class="card-aluno">
                        <div class="aluno-avatar">
                            <?php
                            $foto = !empty($aluno['fotoAluno']) ? 
                                "../../../PROJETO/uploads/alunos/{$aluno['fotoAluno']}" : 
                                "../../../PROJETO/assets/avatar-default.png";
                            ?>
                            <img src="<?= $foto ?>" alt="Foto do aluno" 
                                 onerror="this.src='../../../PROJETO/assets/avatar-default.png'">
                        </div>
                        <div class="aluno-info">
                            <h4><?= htmlspecialchars($aluno['NomeAluno']) ?></h4>
                            <p>Matrícula: <?= htmlspecialchars($aluno['matriculaAluno']) ?></p>
                        </div>
                        <div class="aluno-actions">
                            <a href="detalhesAluno.php?id=<?= $aluno['matriculaAluno'] ?>" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Ver detalhes
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Nenhum aluno encontrado nesta turma.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .container-alunos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card-aluno {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            align-items: center;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .card-aluno:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .aluno-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
            border: 2px solid #eee;
        }

        .aluno-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .aluno-info {
            flex-grow: 1;
        }

        .aluno-info h4 {
            margin: 0;
            color: #333;
        }

        .aluno-info p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
    </style>
</body>
</html>