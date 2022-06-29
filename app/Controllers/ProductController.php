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

	}

?>
