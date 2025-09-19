<?php

class filialController{
    public function listar(){
        require_once(__DIR__ . '/../models/filialModel.php');

        $filialModel = new filialModel();

        $filiais = $filialModel->buscar(null);

        echo json_encode($filiais);
    }
}