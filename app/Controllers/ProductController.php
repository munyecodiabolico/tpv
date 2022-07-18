<?php

	namespace app\Controllers;

	require_once 'app/Models/Product.php';

	use app\Models\Product;


	class ProductController	{

		protected $producto;

		public function __construct() {
			$this->producto = new Product();
		}

		public function index($category) {
			return $this->producto->index($category);
		}

		public function show($id) {
			return $this->producto->show($id);
		}

		public function delete($id) {
			return $this->producto->delete($id);
		}
		
		public function store($id, $nombre) {
			return $this->producto->store($id, $nombre);
		}

	}

?>
