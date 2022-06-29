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
		
	}

?>