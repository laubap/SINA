<?php
require_once 'connection.php';
require_once '../backend/utils/update.php';

class CoordenadorRepository{

    public static function create($nome, $cpf, $senha, $email){

        global $pdo;

        $stmt = $pdo -> prepare(
            "
            INSERT INTO coordenador(
                nome,
                cpf,
                senha,
                email
            VALUES(
                :nome,
                :cpf,
                :senha,
                :email   
            )
            "
        );

        $stmt-> bindParam("nome", $nome);
        $stmt-> bindParam("cpf",$cpf);
        $stmt-> bindParam("senha", $senha);
        $stmt-> bindParam("email",$email);

        return $stmt-> execute();

    }


    public static function login($cpf, $senha){

        global $pdo;

        $stmt = $pdo-> prepare(
            "
                SELECT
                    id,
                    nome,
                    cpf,
                    senha,
                    email
                FROM
                    coordenador
                WHERE
                    cpf = :cpf
                    AND senha = :senha
                    AND excluido IS NULL
            "
        );

        $stmt->bindParam("cpf", $cpf);
        $stmt->bindParam("senha", $senha);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

    public static function deleta($id){

        global $pdo;

        $stmt = $pdo->prepare(
            "
                UPDATE
                    coordenador
                SET
                    excluido = UTC_TIMESTAMP()
                WHERE
                    id: id
                    AND excluido IS NULL
            "
        );

        $stmt->bindParam("id", id);

        return $stmt->execute();
    }

    public static function modifica($request, $update_statemente){

        global $pdo;

        $stmt = $pdo->prepare(
            "
                UPDATE
                    coordenador
                SET
                    $update_statement
                WHERE
                    id = :id
                    AND excluido IS NULL
            "
        );

        if (isset($request->nome) && $request->nome !== null) {
            $stmt->bindParam(':nome', $request->nome);
        }

        if (isset($request->cpf) && $request->cpf !== null) {
            $stmt->bindParam(':cpf', $request->cpf);
        }

        if (isset($request->email) && $request->email !== null) {
            $stmt->bindParam(':email', $request->email);
        }

        if (isset($request->senha) && $request->senha !== null) {
            $stmt->bindParam(':senha', $request->senha);
        }

        return $stmt->execute();

    }

    public static function coleta($id){
        global $pdo;

        $stmt = $pdo->prepare(
            "
                SELECT 
                    id,
                    nome,
                    cpf,
                    criado
                FROM
                    coordenador
                WHERE
                    id = :id
                    AND excluido IS NULL

            "
        );

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function existsByCpf($cpf) {
        global $pdo;
    
        $stmt = $pdo->prepare("
            SELECT id 
            FROM coordenador 
            WHERE cpf = :cpf 
            AND excluido IS NULL
        ");
        $stmt->bindParam(":cpf", $cpf);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
    
}

