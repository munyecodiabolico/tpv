<?php

	namespace app\Models;

	require_once 'core/Connection.php';

	use PDO;

	use core\Connection;


	class Venta extends Connection {

		public function index() {

			$query =  "SELECT 	numero_ticket AS ticket,
									precio_total AS total,
									SUBSTRING(hora_emision,1,5) AS hora,
									mesas.numero AS numero_mesa
									FROM `ventas` 
									INNER JOIN mesas ON mesas.id = ventas.mesa_id
									WHERE ventas.activo = 1;";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

		public function venta_activa($ticket) {

			$query =  "SELECT 	numero_ticket AS ticket,
									precio_total_base AS total_base,
									precio_total_iva AS iva,
									precio_total AS total,
									metodos_pagos.nombre AS metodo_pago,
									mesas.numero AS numero_mesa
									FROM `ventas` 
									INNER JOIN mesas ON mesas.id = ventas.mesa_id
									INNER JOIN metodos_pagos ON metodos_pagos.id = ventas.metodo_pago_id
									WHERE ventas.activo = 1 AND ventas.numero_ticket = $ticket";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		}

		public function articulos_venta($ticket) {

			$query =  "SELECT 	productos_categorias.nombre AS CATEGORIA,
								productos.nombre AS PRODUCTO, productos.id,
								COUNT(tickets.precio_id) AS numero_productos,
								SUM(precios.precio_base) AS BASE_IMPONIBLE,
								productos.imagen_url AS IMAGEN
								FROM ventas
								INNER JOIN tickets ON tickets.venta_id = ventas.id
								INNER JOIN precios ON precios.id = tickets.precio_id
								INNER JOIN productos ON productos.id = precios.producto_id
								INNER JOIN productos_categorias ON productos_categorias.id = productos.categoria_id
								WHERE ventas.numero_ticket = $ticket AND tickets.activo = 1
								GROUP BY tickets.precio_id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}


		public function filtrar($fecha, $mesa) {

			if($mesa == null) {
				
				$query =  "SELECT 	numero_ticket AS ticket,
				precio_total AS total,
				SUBSTRING(hora_emision,1,5) AS hora,
				mesas.numero AS numero_mesa
				FROM `ventas` 
				INNER JOIN mesas ON mesas.id = ventas.mesa_id
				WHERE fecha_emision = '$fecha' AND ventas.activo = 1;";

			}  else {
				$query =  "SELECT 	numero_ticket AS ticket,
				precio_total AS total,
				SUBSTRING(hora_emision,1,5) AS hora,
				mesas.numero AS numero_mesa
				FROM `ventas` 
				INNER JOIN mesas ON mesas.id = ventas.mesa_id
				WHERE mesas.numero = $mesa AND fecha_emision = '$fecha' AND ventas.activo = 1;";

			}


			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

	}

?>