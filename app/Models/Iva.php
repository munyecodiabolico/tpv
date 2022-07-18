<?php

	namespace app\Models;
	
	require_once 'core/Connection.php';

	use PDO;
	
	use core\Connection;


	class Iva extends Connection {

        public function index() {

			$query = "SELECT * FROM iva WHERE activo = 1";
					
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		}

        public function store($id, $tipo_iva, $vigente) {

			if (empty($id)) {
				
				$query = "INSERT INTO iva (tipo_iva, vigente, activo, creado, actualizado, multiplicador)
						VALUES ($tipo_iva, $vigente, 1, NOW(), NOW(), 1+($tipo_iva/100))";
                       

				$stmt = $this->pdo->prepare($query);
				$result = $stmt->execute();
				$id = $this->pdo->lastInsertId();
			
			} else {

				$query = "UPDATE iva SET tipo_iva = $tipo_iva, vigente = $vigente, multiplicador = 1+(/100), actualizado = NOW() WHERE id = $id";
				
				$stmt = $this->pdo->prepare($query);
				$result = $stmt->execute();
				
				

			};
			
			$query = "SELECT * FROM iva WHERE id = $id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		
		}


		public function show($id) {
			
			$query = "SELECT * FROM iva WHERE id = $id";
				
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}

		public function delete($id) {
			
			$query = "UPDATE iva SET vigente = 0, activo = 0, actualizado = NOW() WHERE id = $id";
				
				
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}
		
	}

?>