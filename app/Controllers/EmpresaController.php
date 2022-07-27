<?php

	namespace app\Controllers;

	require_once 'app/Models/Empresa.php';

	use app\Models\Empresa;


	class EmpresaController {

		protected $empresa;

		public function __construct() {  
			$this->empresa = new Empresa();
		}

		public function index() {
			return $this->empresa->index();
		}

		public function show($id) {
			return $this->empresa->show($id);
		}

		public function delete($id) {
			return $this->empresa->delete($id);
		}
		
		public function store($json) {
			return $this->empresa->store($json);
		}

	}

?>
