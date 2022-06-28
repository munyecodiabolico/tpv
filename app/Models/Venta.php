<?php

	namespace app\Models;
	
	require_once 'core/Connection.php';

	use PDO;
	
	use core\Connection;

	class Venta extends Connection{

		public function index(){

			$query =  "SELECT 	numero_ticket AS ticket,
								precio_total AS total,
								hora_emision AS hora,
								mesas.numero AS numero_mesa
								FROM `ventas` 
								INNER JOIN mesas ON mesas.id = ventas.mesa_id
								WHERE ventas.activo = 1;";
					
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

		public function venta_activa($ticket){

			$query =  "SELECT 	numero_ticket AS ticket,
								precio_total_base AS total_base,
								precio_total_iva AS iva,
								precio_total AS total,
								metodos_pagos.nombre AS metodo_pago,
								mesas.numero AS numero_mesa
								FROM `ventas` 
								INNER JOIN mesas ON mesas.id = ventas.mesa_id
								INNER JOIN metodos_pagos ON metodos_pagos.id = ventas.metodo_pago_id
								WHERE ventas.activo = 1 AND ventas.numero_ticket = $ticket;";
					
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		}
		
	}

?>