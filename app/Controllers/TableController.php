<?php

namespace app\Controllers;

class TableController {

    protected $saludo;

	public function __construct(){  

		$this->saludo = "hola";

	}

	public function index(){

        $mesas = [
            "1" => [
                "numero" => "1",
                "estado" => "1"
            ],
            "2" => [
                "numero" => "2",
                "estado" => "0"
            ],
            "3" => [
                "numero" => "3",
                "estado" => "1"
            ]
        ];

        return $mesas;
	}
}

?>