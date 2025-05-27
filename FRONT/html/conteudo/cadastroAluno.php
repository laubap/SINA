<div class="pagina">
<?php
session_start();
include "../../../PROJETO/conecta_db.php";
$oMysql = conecta_db(); 

$turmas = $oMysql->query("SELECT * FROM tb_turma");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../css/paginaCadastro.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- LINK JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alert.js"></script>
</head>

<body>
    <div style="display: flex; flex-direction: column; min-height: 70vh; align-items: center">
        <div>
            <h1>Cadastro de aluno</h1>
            <p class="descricao">
                Faça o cadastro no <strong>SINA</strong> <br>
                de um <strong>aluno</strong>
            </p>

            <form action="http://localhost/SINA/BACK/cadastroAluno.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input class="form-control"
                    style="width: 400px;"
                    type="text"
                    id="nomeAluno"
                    name="nomeAluno"
                    placeholder="Digite o nome do aluno"
                    required>
                </div>

                <div class="form-group">
                    <select class="form-control" name="idTurma" style="width: 400px;">
                        <option value="">Selecione uma turma</option>
                        <?php while($row = $turmas->fetch_assoc()): ?>
                            <option value="<?= $row['idTurma'] ?>"><?= $row['Nome'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <input class="form-control"
                    style="width: 400px;"
                    type="date"
                    id="dataNasc"
                    name="dataNasc"
                    required>
                </div>

                <div class="form-group">
                    <label for="fotoAluno">Foto do Aluno:</label>
                    <input class="form-control"
                    style="width: 400px;"
                    type="file"
                    id="fotoAluno"
                    name="fotoAluno"
                    accept="image/*">
                </div>

                <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
            </form>
        </div>
    </div>
</body>
</div>

<style>
.pagina {
    margin-left: 20vh;
}
</style>