<?php

	namespace app\Controllers;

	require_once 'app/Models/Ticket.php';

	use app\Models\Ticket;

	class TicketController {

		protected $ticket;

		public function __construct() {  
			$this->ticket = new Ticket();
		}

		public function index($mesa) {
			return $this->ticket->index($mesa);
		}

		public function total($mesa) {
			return $this->ticket->total($mesa);
		}

		public function addProduct($price_id, $table_id){
			return $this->ticket->addProduct($price_id, $table_id);
		}

		public function addFakeProduct($price_id, $table_id, $timestamp){
			return $this->ticket->addFakeProduct($price_id, $table_id, $timestamp);
		}

		public function deleteProduct($ticket_id, $table_id){
			return $this->ticket->deleteProduct($ticket_id, $table_id);
		}
		
		public function deleteAllProducts($table_id){
			return $this->ticket->deleteAllProducts($table_id);
		}

		public function metodoPago(){
			return $this->ticket->metodoPago();
		}

		public function closeTicketVenta($table_id, $venta_id){
			return $this->ticket->closeTicketVenta($table_id, $venta_id);
		}

		public function closeFakeTicketVenta($table_id, $venta_id, $timestamp){
			return $this->ticket->closeFakeTicketVenta($table_id, $venta_id, $timestamp);
		}

		public function mesa_ocupada($mesa) {
			return $this->ticket->mesa_ocupada($mesa);
		}
	}

?>
