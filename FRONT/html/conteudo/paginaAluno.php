    <?php
    session_start();
    include "../../../BACK/conecta_db.php";
    $oMysql = conecta_db();

    // Verificação da matrícula
    if (!isset($_POST['matriculaAluno']) && !isset($_SESSION['matriculaAlunoSelecionada'])) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Aluno não selecionado'];
        switch ($_SESSION['tipoUsuario']) {
            case 1: header('Location: ../paginaResponsavel.php'); break;
            case 2: header('Location: ../paginaProfessor.php'); break;
            case 3: header('Location: ../paginaCoordenador.php'); break;
            default: header('Location: ../index.html');
        }
        exit;
    }

    $matriculaAluno = isset($_POST['matriculaAluno']) ? (int)$_POST['matriculaAluno'] : (int)$_SESSION['matriculaAlunoSelecionada'];
    $_SESSION['matriculaAlunoSelecionada'] = $matriculaAluno;

    // Ficha médica
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_medical'])) {
        $tipoSanguineo = $oMysql->real_escape_string($_POST['tipoSanguineo'] ?? '');
        $alergias = $oMysql->real_escape_string($_POST['alergias'] ?? '');
        $medicacoes = $oMysql->real_escape_string($_POST['medicacoes'] ?? '');
        $planoSaude = $oMysql->real_escape_string($_POST['planoSaude'] ?? '');
        $numeroPlano = $oMysql->real_escape_string($_POST['numeroPlano'] ?? '');
        $contatoEmergencia = $oMysql->real_escape_string($_POST['contatoEmergencia'] ?? '');
        $telefoneEmergencia = $oMysql->real_escape_string($_POST['telefoneEmergencia'] ?? '');
        $parentescoEmergencia = $oMysql->real_escape_string($_POST['parentescoEmergencia'] ?? '');
        $observacoes = $oMysql->real_escape_string($_POST['observacoes'] ?? '');

        // Verifica se existe uma ficha médica para o aluno
        $checkSql = "SELECT idFichaMedica FROM tb_fichamedica WHERE matriculaAluno = ?";
        $stmt = $oMysql->prepare($checkSql);
        $stmt->bind_param("i", $matriculaAluno);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows > 0) {
            $sql = "UPDATE tb_fichamedica SET 
                    tipoSanguineo = ?,
                    alergias = ?,
                    medicacoes = ?,
                    planoSaude = ?,
                    numeroPlano = ?,
                    contatoEmergencia = ?,
                    telefoneEmergencia = ?,
                    parentescoEmergencia = ?,
                    observacoes = ?
                    WHERE matriculaAluno = ?";
        } else {
            $sql = "INSERT INTO tb_fichamedica (
                    tipoSanguineo, alergias, medicacoes, planoSaude, numeroPlano,
                    contatoEmergencia, telefoneEmergencia, parentescoEmergencia, observacoes, matriculaAluno
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        }
        
        $stmt = $oMysql->prepare($sql);
        $params = [$tipoSanguineo, $alergias, $medicacoes, $planoSaude, $numeroPlano,
                $contatoEmergencia, $telefoneEmergencia, $parentescoEmergencia, $observacoes, $matriculaAluno];
        
        if (count($params) === 9) { // For update
            $stmt->bind_param("ssssssssi", ...$params);
        } else { // For insert
            $stmt->bind_param("sssssssssi", ...$params);
        }
        
        if ($stmt->execute()) {
            $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Ficha médica atualizada com sucesso!'];
            if($_SESSION['tipoUsuario'] == 1){
                header("Location: ../paginaResponsavel.php");
                exit;
            }
            if($_SESSION['tipoUsuario'] == 3){
                header("Location: ../paginaCoordenador.php");
                exit;
            }
        } else {
            $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao atualizar ficha médica: ' . $stmt->error];
        }
    }

    // Busca dados do aluno
    $sqlAluno = "SELECT * FROM tb_aluno WHERE matriculaAluno = ?";
    $stmt = $oMysql->prepare($sqlAluno);
    $stmt->bind_param("s", $matriculaAluno);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Aluno não encontrado'];
        switch ($_SESSION['tipoUsuario']) {
            case 1:
                header('Location: ../paginaResponsavel.php');
                break;
            case 2:
                header('Location: ../paginaProfessor.php');
                break;
            case 3:
                header('Location: ../paginaCoordenador.php');
                break;
            default:
                header('Location: ../index.php'); // Fallback
        }
        exit;
    }

    $aluno = $resultado->fetch_assoc();

    // Busca dados dos responsáveis
    $sqlResponsavel = "SELECT u.nomeResponsavel, u.emailResponsavel, u.telefoneResponsavel
                    FROM tb_responsavel u
                    JOIN tb_responsavel_aluno ra ON u.idUsuario = ra.idUsuario
                    WHERE ra.matriculaAluno = ?";
    $stmt = $oMysql->prepare($sqlResponsavel);
    $stmt->bind_param("i", $matriculaAluno);
    $stmt->execute();
    $responsaveis = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Consulta Ficha Médica
    $sqlFichaMedica = "SELECT * FROM tb_fichamedica WHERE matriculaAluno = ?";
    $stmt = $oMysql->prepare($sqlFichaMedica);
    $stmt->bind_param("i", $matriculaAluno);
    $stmt->execute();
    $fichaMedica = $stmt->get_result()->fetch_assoc();

    // Busca dados da turma
    $turma = null;
    if (!empty($aluno['idTurma'])) {
        $sqlTurma = "SELECT Nome FROM tb_turma WHERE idTurma = ?";
        $stmt = $oMysql->prepare($sqlTurma);
        $stmt->bind_param("i", $aluno['idTurma']);
        $stmt->execute();
        $turma = $stmt->get_result()->fetch_assoc();
    }


    // Verifica se a foto existe
    $basePath = "/SINA/PROJETO/";
    $fotoPath = $basePath . "uploads/alunos/" . ($aluno['fotoAluno'] ?? '');
    $fotoExists = !empty($aluno['fotoAluno']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoPath);
    $imagemAluno = $fotoExists ? $fotoPath : $basePath . "assets/avatar-default.png";
    ?>




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

    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informações do Aluno - <?= htmlspecialchars($aluno['NomeAluno']) ?></title>
        <link rel="stylesheet" href="../css/paginaCadastro.css">
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../js/alert.js"></script>
    </head>
    <body>
        <div class="pagina-aluno">
            <div class="header-aluno">
                <button onclick="window.history.back()" class="btn-voltar">
                    <i class="fas fa-arrow-left"></i> Voltar
                </button>
                <h2>Informações do Aluno</h2>
            </div>

            <div class="container-aluno">
                <div class="row">
                    <!-- Left Column - Profile Info -->
                    <div class="col-md-4">
                        <div class="card-perfil">
                            <div class="avatar-container">
                                <img src="<?= $imagemAluno ?>" alt="Foto do aluno" 
                                    onerror="this.src='<?= $basePath ?>assets/avatar-default.png'" 
                                    class="avatar-img">
                            </div>
                            <div class="info-basica">
                                <h3><?= htmlspecialchars($aluno['NomeAluno']) ?></h3>
                                <p><strong>Matrícula:</strong> <?= $aluno['matriculaAluno'] ?></p>
                                <p><strong>Turma:</strong> <?= (!empty($turma['Nome'])) ? htmlspecialchars($turma['Nome']) : 'Não informada' ?>
                                <p><strong>Nascimento:</strong> <?= date('d/m/Y', strtotime($aluno['dataNasc'])) ?></p>
                            </div>
                        </div>

                        <div class="card-responsaveis mt-4">
                            <h4>Responsáveis</h4>
                            <?php if (!empty($responsaveis)): ?>
                                <ul class="lista-responsaveis">
                                    <?php foreach ($responsaveis as $responsavel): ?>
                                        <li>
                                            <strong><?= htmlspecialchars($responsavel['nomeResponsavel']) ?></strong><br>
                                            <?= htmlspecialchars($responsavel['telefoneResponsavel']) ?><br>
                                            <?= htmlspecialchars($responsavel['emailResponsavel']) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>Nenhum responsável associado</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Right Column - Details -->
                    <div class="col-md-8">
                        <!-- Medical Information Display -->
                        <div class="card-ficha-medica">
                            <h4>Ficha Médica</h4>
                            <?php if ($fichaMedica): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Tipo Sanguíneo:</strong> <?= htmlspecialchars($fichaMedica['tipoSanguineo'] ?? 'Não informado') ?></p>
                                        <p><strong>Alergias:</strong> <?= nl2br(htmlspecialchars($fichaMedica['alergias'] ?? 'Nenhuma')) ?></p>
                                        <p><strong>Medicações:</strong> <?= nl2br(htmlspecialchars($fichaMedica['medicacoes'] ?? 'Nenhuma')) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Plano de Saúde:</strong> <?= htmlspecialchars($fichaMedica['planoSaude'] ?? 'Não possui') ?></p>
                                        <p><strong>Número do Plano:</strong> <?= htmlspecialchars($fichaMedica['numeroPlano'] ?? 'Não informado') ?></p>
                                        <p><strong>Última Atualização:</strong> <?= date('d/m/Y H:i', strtotime($fichaMedica['dataAtualizacao'])) ?></p>
                                    </div>
                                </div>
                                <div class="contato-emergencia mt-3">
                                    <h5>Contato de Emergência</h5>
                                    <p><strong>Nome:</strong> <?= htmlspecialchars($fichaMedica['contatoEmergencia'] ?? 'Não informado') ?></p>
                                    <p><strong>Telefone:</strong> <?= htmlspecialchars($fichaMedica['telefoneResponsavel'] ?? 'Não informado') ?></p>
                                    <p><strong>Parentesco:</strong> <?= htmlspecialchars($fichaMedica['parentescoEmergencia'] ?? 'Não informado') ?></p>
                                </div>
                                <div class="mt-3">
                                    <p><strong>Observações:</strong></p>
                                    <div class="observacoes-box"><?= nl2br(htmlspecialchars($fichaMedica['observacoes'] ?? 'Nenhuma observação')) ?></div>
                                </div>
                            <?php else: ?>
                                <p>Nenhuma informação médica cadastrada</p>
                            <?php endif; ?>
                        </div>

                        <!-- Medical Information Edit Form (for authorized users) -->
                        <?php if ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 3): ?>
                        <div class="card-edit-medical mt-4">
                            <h4><?= $fichaMedica ? 'Editar' : 'Cadastrar' ?> Ficha Médica</h4>
                            <form method="POST" action="">
                                <input type="hidden" name="update_medical" value="1">
                                <input type="hidden" name="matriculaAluno" value="<?= $matriculaAluno ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tipo Sanguíneo</label>
                                            <select name="tipoSanguineo" class="form-control">
                                                <option value="">Selecione</option>
                                                <option value="A+" <?= ($fichaMedica['tipoSanguineo'] ?? '') == 'A+' ? 'selected' : '' ?>>A+</option>
                                                <option value="A-" <?= ($fichaMedica['tipoSanguineo'] ?? '') == 'A-' ? 'selected' : '' ?>>A-</option>
                                                <option value="B+" <?= ($fichaMedica['tipoSanguineo'] ?? '') == 'B+' ? 'selected' : '' ?>>B+</option>
                                                <option value="B-" <?= ($fichaMedica['tipoSanguineo'] ?? '') == 'B-' ? 'selected' : '' ?>>B-</option>
                                                <option value="AB+" <?= ($fichaMedica['tipoSanguineo'] ?? '') == 'AB+' ? 'selected' : '' ?>>AB+</option>
                                                <option value="AB-" <?= ($fichaMedica['tipoSanguineo'] ?? '') == 'AB-' ? 'selected' : '' ?>>AB-</option>
                                                <option value="O+" <?= ($fichaMedica['tipoSanguineo'] ?? '') == 'O+' ? 'selected' : '' ?>>O+</option>
                                                <option value="O-" <?= ($fichaMedica['tipoSanguineo'] ?? '') == 'O-' ? 'selected' : '' ?>>O-</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Alergias</label>
                                            <textarea name="alergias" class="form-control" rows="3"><?= htmlspecialchars($fichaMedica['alergias'] ?? '') ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Medicações</label>
                                            <textarea name="medicacoes" class="form-control" rows="3"><?= htmlspecialchars($fichaMedica['medicacoes'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Plano de Saúde</label>
                                            <input type="text" name="planoSaude" class="form-control" value="<?= htmlspecialchars($fichaMedica['planoSaude'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Número do Plano</label>
                                            <input type="text" name="numeroPlano" class="form-control" value="<?= htmlspecialchars($fichaMedica['numeroPlano'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Contato de Emergência</label>
                                            <input type="text" name="contatoEmergencia" class="form-control" value="<?= htmlspecialchars($fichaMedica['contatoEmergencia'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Telefone Emergência</label>
                                            <input type="text" name="telefoneEmergencia" class="form-control" value="<?= htmlspecialchars($fichaMedica['telefoneEmergencia'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Parentesco</label>
                                            <input type="text" name="parentescoEmergencia" class="form-control" value="<?= htmlspecialchars($fichaMedica['parentescoEmergencia'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Observações</label>
                                    <textarea name="observacoes" class="form-control" rows="3"><?= htmlspecialchars($fichaMedica['observacoes'] ?? '') ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Salvar Alterações
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <style>
        .pagina-aluno {
            margin-left: 20vh;
            padding: 20px;
        }

        .header-aluno {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .btn-voltar {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            margin-right: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-voltar:hover {
            background-color: #5a6268;
        }

        .container-aluno {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .card-perfil {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .avatar-container {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info-basica h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .info-basica p {
            margin-bottom: 8px;
            color: #555;
        }

        .card-responsaveis, .card-ficha-medica, .card-edit-medical {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .card-responsaveis h4, .card-ficha-medica h4, .card-edit-medical h4 {
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .lista-responsaveis {
            list-style-type: none;
            padding-left: 0;
        }

        .lista-responsaveis li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .contato-emergencia {
            background-color: #fff8e1;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .contato-emergencia h5 {
            color: #ff9800;
            margin-bottom: 10px;
        }

        .observacoes-box {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            min-height: 80px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        </style>
    </body>
    </html>