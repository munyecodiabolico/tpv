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

			$query =  "SELECT 	mesas.id AS MESA,
								productos_categorias.nombre AS CATEGORIA,
								productos.nombre AS PRODUCTO, productos.id,
								precios.precio_base AS BASE_IMPONIBLE,
								iva.tipo_iva AS IVA,
								productos.imagen_url AS IMAGEN
								FROM ventas
								INNER JOIN tickets ON tickets.venta_id = ventas.id
								INNER JOIN precios ON precios.id = tickets.precio_id
								INNER JOIN mesas ON mesas.id = tickets.mesa_id
								INNER JOIN productos ON productos.id = precios.producto_id
								INNER JOIN iva ON iva.id = precios.iva_id
								INNER JOIN productos_categorias ON productos_categorias.id = productos.categoria_id
								WHERE ventas.numero_ticket = $ticket AND tickets.activo = 1
								ORDER BY tickets.id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

	}

?>