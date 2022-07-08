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

			$last_ticket_number = $this->venta->last_ticket();
			$date = date("ymd");
			   	
			if(strpos($last_ticket_number['numero_ticket'], $date) !== false){
				$ticket = $last_ticket_number['numero_ticket'] + 1;
			} else {
				$ticket = $date . "0001";
			};
		 
			return $ticket;
		}
		
		public function safe_venta($mesa, $base, $iva, $total, $numero_ticket, $metodo_pago, $mesa_ocupada) {
			return $this->venta->safe_venta($mesa, $base, $iva, $total, $numero_ticket, $metodo_pago, $mesa_ocupada);
		}
	}

?>
