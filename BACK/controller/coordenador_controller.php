<?php

require_once '../backend/dtos/response.php';
require_once '../backend/repository/empresa_repository.php';
require_once '../backend/utils/update.php';
require_once '../backend/enums/status.php';

class CoordenadorController{

    public static function rotas($segment){
        return match ($segment){
            'login' => self::login(
                    json_decode(file_get_contents('php://input'))
            ),
            'create' => self::login(
                    json_decode(file_get_contents('php://input'))
            ),
            'collect' => self::login(
                $_GET['id']
            ),
            'modify' => self::login(
                    json_decode(file_get_contents('php://input'))
            ),
            'delete' => self::login(
                $_GET['id']
            ),
            default => http_response_code(Status::NOT_FOUND->value)
        };
    }

    private static function login($request) {

        $esta_valido = ResponseClass::ifNull(
            "request", $request,
            "cnpj", $request->cnpj,
            "senha", $request->senha
        );

        if (!$esta_valido) {

            return;

        }

        $coordenador = EmpresaRepository::login(
            $request->cnpj, 
            $request->senha
        );

        if (!$coordenador) {

            ResponseClass::answer(
                "Cnpj ou senha incorretos", 
                Status::UNAUTHORIZED
            );
            return;

        }

        ResponseClass::answerWithBody(
            $empresa,
            Status::OK
        );

    }

    private static function create($request) {
         
        $esta_valido = ResponseClass::ifNull(
            "request", $request,
            "nome", $request->nome,
            "cpf", $request->cpf,
            "senha", $request->senha,
          
        );
    
        if (!$esta_valido) {
            return;
        }
    
        if (CoordenadorRepository::existsByCpf($request->cnpj)) {
            ResponseClass::answer([
                "erro" => "CNPJ já cadastrado",
                "cnpj" => $request->cnpj
            ], Status::CONFLICT);
            return;
        }
    
    
        try {
            $created = EmpresaRepository::create(
                $request->nome,
                $request->email,
                $request->cpf,
                $request->senha,
            );
    
            if (!$created) {
                throw new Exception("Falha ao inserir no banco de dados");
            }
    
            ResponseClass::answerWithBody(
                EmpresaRepository::login($request->cpf, $request->senha),
                Status::CREATED
            );
    
        } catch (Exception $e) {
            ResponseClass::answer([
                "erro" => "Erro ao cria",
                "detalhes" => $e->getMessage()
            ], Status::INTERNAL_SERVER_ERROR);
        }
    }


    private static function delete($id) {

        $esta_valido = ResponseClass::ifNull(
            "id", $id
        );

        if (!$esta_valido) {

            return;

        }

        $coordenador = EmpresaRepository::coleta($id);

        if (!$coordenador) {

            ResponseClass::answer(
                "Nenhum encontrado com este id",
                Status::NOT_FOUND
            );

            return;

        }

        EmpresaRepository::delete($id);

        $coordenador = EmpresaRepository::coleta($id);

        if ($coordenador) {

            ResponseClass::answer(
                "Algum erro ocorreu enquanto a empresa era deletada",
                Status::INTERNAL_SERVER_ERROR
            );

            return;

        }

        ResponseClass::answer(
            "coordenador deletada com sucesso",
            Status::OK
        );

    }



    public static function modify($request) {
        global $pdo;
    
        if (empty($request->id)) {
            ResponseClass::answer(['message' => 'ID não fornecido'], Status::BAD_REQUEST);
            return;
        }
    
        $updateFields = [];
        $params = [':id' => $request->id];
    
     
        if (!empty($request->nome)) {
            $updateFields[] = "nome = :nome";
            $params[':nome'] = $request->nome;
        }
        if (!empty($request->cpf)) {
            $updateFields[] = "cpf = :cpf";
            $params[':cpf'] = $request->cpf;
        }
        if (!empty($request->email)) {
            $updateFields[] = "email = :email";
            $params[':email'] = $request->email;
        }
        if (!empty($request->senha)) {
            $updateFields[] = "senha = :senha";
            $params[':senha'] = $request->senha;
        }
    
        if (empty($updateFields)) {
            ResponseClass::answer(['message' => 'Nenhum campo para atualizar'], Status::BAD_REQUEST);
            return;
        }
    
        $query = "UPDATE coordenador SET " . implode(", ", $updateFields) . " WHERE id = :id AND excluido IS NULL";
        $stmt = $pdo->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
    
        $result = $stmt->execute();
    
        if ($result) {
            ResponseClass::answer(['message' => 'atualizado com sucesso'], Status::OK);
        } else {
            ResponseClass::answer(['message' => 'Erro ao atualizar '], Status::INTERNAL_SERVER_ERROR);
        }
    }


}

