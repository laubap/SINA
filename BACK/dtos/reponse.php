<?php 

require 'enums/status.php';

class ResponseClass {

    public static function answerWithBody($message, Status $status) {
        header('Content-Type: application/json');
        http_response_code($status->value);
        echo json_encode($message);
    }

    public static function answer($message, Status $status) {
        header('Content-Type: application/json');
        http_response_code($status->value);
        echo json_encode(['message' => $message]);
    } 

    public static function ifNull(...$values) {

        for ($i = 0 ; $i < count($values) ; $i+=2) {

            $key = $values[$i];
            $value = $values[$i + 1];
            
            if ($value == null) {

                ResponseClass::answer(
                    "A variavel $key nao pode ser null", 
                    Status::BAD_REQUEST
                );

                return false;

            }

        }

        return true;

    }

}

?>
