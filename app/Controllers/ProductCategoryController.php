<?php

	namespace app\Controllers;

	require_once 'app/Models/ProductCategory.php';

	use app\Models\ProductCategory;


	class ProductCategoryController {

		protected $categoria;

		public function __construct() {  
			$this->categoria = new ProductCategory();
		}

		public function index() {
			return $this->categoria->index();
		}

		public function filter() {
			return $this->categoria->filter();
		}
		
		public function show($id) {
			return $this->categoria->show($id);
		}

		public function delete($id) {
			return $this->categoria->delete($id);
		}
		
		public function store($id, $nombre) {
			return $this->categoria->store($id, $nombre);
		}

	}

?>