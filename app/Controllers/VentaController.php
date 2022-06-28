<?php

	namespace app\Controllers;

	require_once 'app/Models/Venta.php';

	use app\Models\Venta;

	class VentaController {

		protected $venta;

		public function __construct(){  
			$this->venta = new Venta();
		}

		public function index(){
			return $this->venta->index();
		}

		public function venta_activa($ticket){
			return $this->venta->venta_activa($ticket);
		}
		
	}
