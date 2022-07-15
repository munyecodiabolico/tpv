<?php

	namespace app\Models;

	require_once 'core/Connection.php';

	use PDO;

	use core\Connection;

	
	class Ticket extends Connection
	{

		public function index($mesa) {

			$query =	"SELECT tickets.id AS TICKET, mesas.id AS MESA, productos_categorias.nombre AS CATEGORIA, productos.nombre AS PRODUCTO, productos.id,
							precios.precio_base AS BASE_IMPONIBLE, iva.tipo_iva AS IVA, productos.imagen_url AS IMAGEN FROM tickets
							INNER JOIN precios ON precios.id = tickets.precio_id
							INNER JOIN mesas ON mesas.id = tickets.mesa_id
							INNER JOIN productos ON productos.id = precios.producto_id
							INNER JOIN iva ON iva.id = precios.iva_id
							INNER JOIN productos_categorias ON productos_categorias.id = productos.categoria_id
							WHERE mesas.id = $mesa AND venta_id IS NULL AND tickets.activo = 1
							ORDER BY tickets.id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

		public function addProduct($price_id, $table_id) 
		{

			$query =  "INSERT INTO tickets (precio_id, mesa_id, activo, creado, actualizado)
						VALUES (". $price_id.", ".$table_id.", 1, NOW(), NOW())";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();
			$id = $this->pdo->lastInsertId();

			$query =  "SELECT tickets.id AS id, productos.nombre AS nombre, precios.precio_base AS precio_base, productos.imagen_url 
			AS imagen_url, productos_categorias.nombre AS categoria
			FROM tickets 
			INNER JOIN precios ON tickets.precio_id = precios.id 
			INNER JOIN productos ON precios.producto_id = productos.id 
			INNER JOIN productos_categorias ON productos.categoria_id = productos_categorias.id
			WHERE tickets.id = ".$id;

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		public function metodoPago()
		{
			$query = "SELECT id AS ID, nombre AS METODO FROM metodos_pagos WHERE activo = 1";
			
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();
			return $result;
		}

		public function deleteProduct($ticket_id, $table_id) 
		{
 
			$query =  "UPDATE tickets SET activo=0
						WHERE id = $ticket_id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return 'ok';
		}

		public function deleteAllProducts($table_id) 
		{

			$query =  "UPDATE tickets SET activo=0
						WHERE mesa_id = $table_id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return 'ok';
		}

		public function closeTicketVenta($table_id, $venta_id) 
		{
 
			$query =  "UPDATE tickets SET venta_id=$venta_id, actualizado = NOW()
						WHERE mesa_id = $table_id AND activo = 1";
						
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return 'ok';
		}

		public function total($mesa) {

			$query =	"SELECT	tickets.mesa_id AS mesa, SUM(precio_base) AS total_base,
							ROUND(SUM(precio_base*multiplicador),2) AS total, 
							ROUND(SUM(precio_base*multiplicador) - SUM(precio_base), 2) AS iva_total,
							iva.tipo_iva AS valor_iva 
							FROM tickets
							INNER JOIN precios ON precios.id = tickets.precio_id
							INNER JOIN iva ON iva.id = precios.iva_id
							WHERE tickets.mesa_id = $mesa AND tickets.venta_id IS NULL AND tickets.activo = 1
							GROUP BY iva.tipo_iva";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		}
		
		// Obtencion de la duracion de servicio de una mesa en minutos
		public function mesa_ocupada ($mesa) {

			$query = "SELECT creado FROM tickets where mesa_id=$mesa AND venta_id IS NULL ORDER BY id ASC LIMIT 1";
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		
		}
		
	}

?>
