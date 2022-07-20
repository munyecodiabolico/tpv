<?php

	namespace app\Models;
	
	require_once 'core/Connection.php';

	use PDO;
	
	use core\Connection;


	class Product extends Connection {

		public function index() {

			$query =  "SELECT	productos.id as id,
								productos.nombre as nombre,
								productos.imagen_url as imagen_url,
								productos_categorias.nombre as categoria,
								precios.precio_base as precio, iva.tipo_iva as iva, productos.visible as visible FROM productos 
								INNER JOIN productos_categorias ON productos_categorias.id = productos.categoria_id
								INNER JOIN precios ON precios.producto_id = productos.id
								INNER JOIN iva ON iva.id = precios.iva_id
								where productos.activo = 1";
					
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

		public function filter($category) {

			$query =  "SELECT productos.imagen_url, productos.nombre, precios.id AS precio_id FROM productos
			INNER JOIN precios ON precios.producto_id = productos.id
			WHERE categoria_id = $category and precios.vigente = 1";
					
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

		public function store($id, $nombre, $categoria, $visible) {
			if (empty($id)) {
				
				$query = "INSERT INTO productos (nombre, categoria_id, visible, activo, creado, actualizado)
						VALUES ('$nombre', $categoria, $visible, 1, NOW(), NOW())";
				

				$stmt = $this->pdo->prepare($query);
				$result = $stmt->execute();
				$id = $this->pdo->lastInsertId();
			
			} else {

				$query = "UPDATE productos SET nombre = '$nombre', categoria_id = $categoria, visible = $visible, actualizado = NOW() WHERE id = $id";
				
				$stmt = $this->pdo->prepare($query);
				$result = $stmt->execute();

			};

			return $id;
		
		}

		public function show($id) {
			
			$query = "SELECT * FROM productos WHERE id = $id";
			
			file_put_contents('ficheroshow.txt', $query);
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}

		public function delete($id) {
			
			$query = "UPDATE productos SET activo = 0, actualizado = NOW() WHERE id = $id";
				
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}
		
	}

?>
