<?php

	namespace app\Controllers;

	require_once 'app/Models/MetodoPago.php';

	use app\Models\MetodoPago;

	class MetodoPagoController {

		protected $metodo_pago;

		public function __construct() {  
			$this->metodo_pago = new MetodoPago();
		}

		public function index() {
			return $this->metodo_pago->index();
		}

	}

?>