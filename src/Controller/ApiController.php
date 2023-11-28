<?php

class ApiController {
    public static function allLoufokeries() {
        try {
            $loufokeries = LoufokerieModel::getInstance()->findAll();
            $response = [];
            foreach ($loufokeries as $loufokerie) {
                array_push($response, $loufokerie);
            }

            ApiController::sendData($response);
            exit;
        } catch (PDOException $e) {
            // Handle responsebase connection errors
            http_response_code(500);
            echo 'Internal Server Error';
            exit;
        }
    }

    public static function loufokerie(int $id) {
        try {
            $loufokerie = LoufokerieModel::getInstance()->find($id);

            if (!$loufokerie) {
                http_response_code(404);
                $response = [
                    "status" => 404,
                    "message" => "Not Loufokerie found for this ID"
                ];
            } else {
                $response["status"] = 200;
                $loufokerie["joueurs"] = JoueurModel::getInstance()->GetAllNamesFromLoufokerie($id);
                $loufokerie["contributions"] = ContributionModel::getInstance()->getArrayFullOfEmptyStringsExceptItsNotEmpty($id);
                array_push($response, $loufokerie);
            }

            ApiController::sendData($response);
            exit;
        } catch (PDOException $e) {
            // Handle responsebase connection errors
            http_response_code(500);
            echo 'Internal Server Error';
            exit;
        }
    }

    public static function like(int $id) {
        try {
            $response = [];
            $response = json_encode($response);
            header('Content-Type: application/json');
            echo $response;
            exit;
        } catch (PDOException $e) {
            // Handle responsebase connection errors
            http_response_code(500);
            echo 'Internal Server Error';
            exit;
        }
    }

    public static function sendData($data) {
        $data = json_encode($data);
        header('Content-Type: application/json');
        echo $data;
    }
};
