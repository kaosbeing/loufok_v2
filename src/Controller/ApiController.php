<?php

class ApiController {
    public static function allLoufokeries() {
        try {
            $loufokeries = LoufokerieModel::getInstance()->findAll();
            $data = [];
            foreach ($loufokeries as $loufokerie) {
                $contributions = ContributionModel::getInstance()->findByOrdered(["id_loufokerie" => $loufokerie["id"]]);
                $loufokerie["contributions"] = $contributions;
                array_push($data, $loufokerie);
            }
            $data = json_encode($data);
            header('Content-Type: application/json');
            echo $data;
            exit;
        } catch (PDOException $e) {
            // Handle database connection errors
            http_response_code(500);
            echo 'Internal Server Error';
            exit;
        }
    }

    public static function loufokerie(int $id) {
        try {
            $loufokerie = LoufokerieModel::getInstance()->find($id);
            $contributions = ContributionModel::getInstance()->findBy(["id_loufokerie" => $loufokerie["id"]]);

            $data = [];

            $loufokerie["joueurs"] = JoueurModel::getInstance()->GetAllNamesFromLoufokerie($id);
            $loufokerie["contributions"] = $contributions;
            array_push($data, $loufokerie);

            $data = json_encode($data);
            header('Content-Type: application/json');
            echo $data;
            exit;
        } catch (PDOException $e) {
            // Handle database connection errors
            http_response_code(500);
            echo 'Internal Server Error';
            exit;
        }
    }
};
