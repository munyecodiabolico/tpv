<?php

	namespace app\Controllers;

	require_once 'app/Models/Venta.php';

	use app\Models\Venta;


	class VentaController {

		protected $venta;

		public function __construct() {
			$this->venta = new Venta();
		}

		public function index() {
			return $this->venta->index();
		}

		public function venta_activa($ticket) {
			return $this->venta->venta_activa($ticket);
		}

		public function filtrar($fecha, $mesa) {
			return $this->venta->filtrar($fecha, $mesa);
		}

		public function articulos_venta($ticket) {
			return $this->venta->articulos_venta($ticket);
		}

		public function total_media($fecha, $mesa) {
			return $this->venta->total_media($fecha, $mesa);
		}

		public function last_ticket() {
			return $this->venta->last_ticket();
		}
		
		function newSale($tickets) {
       
			$date = date("ymd");
			$last_ticket = end($tickets);
			   
			// A partir de php 8.0 se puede usar la función str_contains() para no tener que hacer !== false
	
			if(strpos($last_ticket, $date) !== false){
				$ticket = $last_ticket + 1;
			} else {
				$ticket = $date . "0001";
			};
		 
			return $ticket;
		}
	}

?>
