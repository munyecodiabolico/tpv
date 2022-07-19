<?php

	namespace app\Models;
	
	require_once 'core/Connection.php';

	use PDO;
	
	use core\Connection;

	class Precio extends Connection {

		public function store($id, $producto_id, $iva_id, $precio) {

			if (empty($id)) {
				
				$query = "INSERT INTO metodos_pagos (nombre, activo, creado, actualizado)
						VALUES ('$nombre', 1, NOW(), NOW())";
						file_put_contents('ficherostore', $query);
                       

				$stmt = $this->pdo->prepare($query);
				$result = $stmt->execute();
				$id = $this->pdo->lastInsertId();
			
			} else {

				$query = "UPDATE metodos_pagos SET nombre = '$nombre', actualizado = NOW() WHERE id = $id";
				file_put_contents('ficheroupdate', $query);
				$stmt = $this->pdo->prepare($query);
				$result = $stmt->execute();
				
				

			};
			
			$query = "SELECT * FROM metodos_pagos WHERE id = $id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		
		}

		public function show($id) {
			
			$query = "SELECT * FROM metodos_pagos WHERE id = $id";
			file_put_contents('ficherodelete', $query);
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}

		public function delete($id) {
			
			$query = "UPDATE metodos_pagos SET activo = 0, actualizado = NOW() WHERE id = $id";
				
				
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}
	
	}

?>