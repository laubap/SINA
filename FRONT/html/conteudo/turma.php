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

<div class="pagina">
    <h2>Lista de Turmas</h2>
    <p>Aqui estão as turmas cadastradas no sistema</p>

    <?php
    session_start();
    include "../../../PROJETO/conecta_db.php";
    $oMysql = conecta_db(); 

    // Verifica se o usuário está logado
    if(!isset($_SESSION['tipoUsuario']) || !isset($_SESSION['usuario'])) {
        die("Acesso não autorizado");
    }

    // Prepara a consulta SQL conforme o tipo de usuário
    switch($_SESSION['tipoUsuario']) {
        case 1: // Responsável
        case 2: // Professor
            // Usa prepared statement para segurança
            $sql = "SELECT t.* 
                    FROM tb_turma t
                    INNER JOIN tb_professor p ON t.Professor_Usuario_idUsuario = p.idUsuario
                    WHERE p.idUsuario = ?";
            $stmt = $oMysql->prepare($sql);
            $stmt->bind_param("i", $_SESSION['usuario']);
            $stmt->execute();
            $resultado = $stmt->get_result();
            break;
            
        case 3: // Coordenador
            $sql = "SELECT * FROM tb_turma";
            $resultado = $oMysql->query($sql);
            break;
            
        default:
            die("Tipo de usuário inválido");
    }

    if ($resultado->num_rows > 0) {
        echo '<div class="container-turmas">';

        while ($turma = $resultado->fetch_assoc()) {
            ?>
            <form method="POST" action="../../BACK/set_turma.php" style="display: inline;">
                <input type="hidden" name="idTurma" value="<?= htmlspecialchars($turma['idTurma']) ?>">
                <button type="submit" class="card-turma">
                    <div class="turma-info">
                        <h3><?= htmlspecialchars($turma['Nome']) ?></h3>
                        <p>Sala: <?= htmlspecialchars($turma['Sala']) ?></p>
                    </div>
                </button>
            </form>
            <?php
        }

        echo '</div>';
    } else {
        echo '<div class="alert alert-info">Nenhuma turma encontrada.</div>';
    }

    // Fecha a conexão
    if(isset($stmt)) {
        $stmt->close();
    }
    $oMysql->close();
    ?>
</div>

<style>
    .pagina {
        margin-left: 20vh;
        padding: 20px;
    }

    /* Estilo dos cards de turma */
    .container-turmas {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }

    .card-turma {
        width: 300px;
        min-height: 140px;
        border: 1px solid #ddd;
        border-radius: 12px;
        background-color: #f4f4f4;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
        text-align: center;
        padding: 15px;
    }

    .card-turma:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        background-color: #e9f0ff;
    }

    .turma-info {
        width: 100%;
    }

    .turma-info h3 {
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    .turma-info p {
        margin: 0;
        color: #666;
        font-size: 16px;
    }
</style>