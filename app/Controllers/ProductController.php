<?php

	namespace app\Controllers;

	require_once 'app/Models/Product.php';
	require_once 'app/Services/ExcelService.php';

	use app\Models\Product;
	use app\Services\ExcelService;

	class ProductController	{

		protected $producto;

		public function __construct() {
			$this->producto = new Product();
		}

		public function index() {
			return $this->producto->index();
		}	

		public function filter($category) {
			return $this->producto->filter($category);
		}

		public function show($id) {
			return $this->producto->show($id);
		}

		public function delete($id) {
			return $this->producto->delete($id);
		}

		// Accedemos al metodo filtrarCategoria de la clase Producto y le pasamos el parametro $categoria
		// Nos devuelve un array con los productos filtrados por categoria
		public function filtrar($categoria,$visible) {
			return $this->producto->filtrar($categoria,$visible);
		}
		
		public function store($id, $nombre, $categoria, $visible, $imagen_url) {
			return $this->producto->store($id, $nombre, $categoria, $visible, $imagen_url);
		}

		public function exportProductToExcel(){
			$excel_service = new ExcelService();

			$productos = $this->producto->index();
			$excel_service->exportTableToExcel('productos', $productos);
		}

	}

?>
