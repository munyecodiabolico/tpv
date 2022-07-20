<?php

	namespace app\Models;
	
	require_once 'core/Connection.php';

	use PDO;
	
	use core\Connection;

	class Precio extends Connection {

		public function store($producto_id, $iva_id, $precio) {

			$query ="UPDATE precios SET vigente = 0 WHERE producto_id = $producto_id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			$query = "INSERT INTO precios (producto_id, iva_id, activo, precio_base, vigente, creado, actualizado)
					VALUES ($producto_id, $iva_id, 1, $precio, 1, NOW(), NOW())";
			
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return 'ok';
		
		}

		public function show($id) {
			
			$query = "SELECT * FROM metodos_pagos WHERE id = $id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}

		public function delete($id) {
			
			$query = "UPDATE precios SET vigente = 0, activo = 0, actualizado = NOW() WHERE producto_id = $id";
				
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}

		public function isValid($producto_id, $precio, $iva_id) {
			
			$query = "SELECT * FROM precios WHERE producto_id = $producto_id AND vigente = 1 AND iva_id = $iva_id AND precio_base = $precio";
				
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}
	
	}

?>