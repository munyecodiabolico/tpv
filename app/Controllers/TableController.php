<?php

	namespace app\Controllers;

	require_once 'app/Models/Table.php';

	use app\Models\Table;


	class TableController {

		protected $table;

		public function __construct() {  
			$this->table = new Table();
		}

		public function index() {
			return $this->table->index();
		}

		public function nro_mesa($mesa) {
			return $this->table->nro_mesa($mesa);
		}

		public function mesa_update($mesa, $estado) {
			return $this->table->mesa_update($mesa, $estado);
		}

		public function add_mesa($mesa, $ubicacion, $pax) {
			return $this->table->add_mesa($mesa, $ubicacion, $pax);
		}
	}

?>
