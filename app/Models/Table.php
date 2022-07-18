<?php

	namespace app\Models;
	
	require_once 'core/Connection.php';

	use PDO;
	
	use core\Connection;

	
	class Table extends Connection {

		public function index() {

			$query = "SELECT * FROM mesas WHERE activo = 1";
					
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		}

		public function nro_mesa($mesa) {

			$query = "SELECT numero FROM mesas WHERE id = $mesa";
					
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		
		}

		public function mesa_update($mesa, $estado) {

			$query = "UPDATE mesas SET estado = $estado, actualizado = NOW() WHERE id = $mesa";
				
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return 'ok';
		
		}

		public function store($id, $numero, $ubicacion, $pax) {

			if (empty($id)) {
				
				$query = "INSERT INTO mesas (numero, ubicacion, pax, estado, activo, creado, actualizado)
						VALUES ($numero,'$ubicacion', $pax, 0, 1, NOW(), NOW())";

				$stmt = $this->pdo->prepare($query);
				$result = $stmt->execute();
				$id = $this->pdo->lastInsertId();
			
			} else {

				$query = "UPDATE mesas SET numero = $numero, ubicacion = '$ubicacion', pax = $pax, actualizado = NOW() WHERE id = $id";
				
				$stmt = $this->pdo->prepare($query);
				$result = $stmt->execute();

			};
			
			$query = "SELECT * FROM mesas WHERE id = $id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		
		}


		public function show($id) {
			
			$query = "SELECT * FROM mesas WHERE id = $id";
				
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}

		public function delete($id) {
			
			$query = "UPDATE mesas SET estado = 0, creado = NOW(), actualizado = NOW() WHERE id = $id";
				
				
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}
	
	}

?>
