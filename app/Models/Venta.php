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

		public function total_media($fecha, $mesa) {

			$query =  "SELECT
							ROUND( SUM( precio_total ), 2 ) AS total,
							(
							SELECT
								ROUND( AVG( suma_total ), 2 ) AS promedio_dia 
							FROM
								(
								SELECT
									SUM( precio_total ) AS suma_total,
									DAYNAME( fecha_emision ) AS fecha 
								FROM
									ventas 
								WHERE
									DAYNAME( fecha_emision ) = DAYNAME( '$fecha' ) 
									AND activo = 1
								GROUP BY
									fecha_emision 
								) media 
							GROUP BY
								fecha 
							) AS media 
						FROM
							`ventas` 
						WHERE
							fecha_emision = '$fecha' 
							AND ventas.activo = 1";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		}


		// Esta funcion nos da el ultimo numero de ticket generado para cada venta
		public function last_ticket() {

			$query =  "SELECT numero_ticket FROM ventas WHERE activo=1
						ORDER BY id DESC LIMIT 1";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		}

		// Esta funcion graba la venta
		public function safe_venta($mesa, $base, $iva, $total, $numero_ticket, $metodo_pago) {

			$query =  "INSERT INTO ventas
						VALUES (NULL, $numero_ticket, $base, $iva, $total, $metodo_pago, $mesa, CURDATE(), DATE_FORMAT(NOW(), '%H:%i:%S'), 1, NOW(), NOW())";
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		}

	}

?>