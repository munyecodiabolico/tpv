<?php

	namespace app\Models;
	
	require_once 'core/Connection.php';

	use PDO;
	
	use core\Connection;


	class Product extends Connection {

		public function index($category) {

			$query =  "SELECT productos.imagen_url, productos.nombre, precios.id AS precio_id FROM productos
			INNER JOIN precios ON precios.producto_id = productos.id
			WHERE categoria_id = $category and precios.vigente = 1";
					
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}
		
	}

?>
