<?php

	namespace app\Controllers;

	require_once 'app/Models/Precio.php';

	use app\Models\Precio;

	class PrecioController {

		protected $metodo_pago;

		public function __construct() {  
			$this->precio = new Precio();
		}

		public function show($id) {
			return $this->precio->show($id);
		}

		public function delete($id) {
			return $this->precio->delete($id);
		}
		
		public function store($id, $producto_id, $iva_id, $precio) {
			return $this->precio->store($id, $producto_id, $iva_id, $precio);
		}

	}

?>