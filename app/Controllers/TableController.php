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

		public function show($id) {
			return $this->table->show($id);
		}

		public function show($id) {
			return $this->table->show($id);
		}

		public function store($id,$numero, $ubicacion, $pax) {
			return $this->table->store($id);
		}

		public function delete($id) {
			return $this->table->delete($id);
		}

	}

?>
