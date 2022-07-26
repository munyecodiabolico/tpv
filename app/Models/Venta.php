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

		public function show($venta_id) {

			$query =  "SELECT * FROM ventas WHERE id = $venta_id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		}

		public function venta_activa($venta_id) {

			$query =  "SELECT 	ventas.id,	
								numero_ticket AS ticket,
								fecha_emision,
								hora_emision,
								precio_total_base AS total_base,
								precio_total_iva AS iva,
								precio_total AS total,
								metodos_pagos.nombre AS metodo_pago,
								mesas.numero AS numero_mesa
								FROM `ventas` 
								INNER JOIN mesas ON mesas.id = ventas.mesa_id
								INNER JOIN metodos_pagos ON metodos_pagos.id = ventas.metodo_pago_id
								WHERE ventas.activo = 1 AND ventas.id = $venta_id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		}

		public function articulos_venta($venta_id) {

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
								WHERE ventas.id = $venta_id AND tickets.activo = 1
								GROUP BY tickets.precio_id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}


		public function filtrar($fecha, $mesa) {

			if($mesa == null) {
				
				$query =  "SELECT 	ventas.id, numero_ticket AS ticket,
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
		public function safe_venta($mesa, $base, $iva, $total, $numero_ticket, $metodo_pago, $mesa_ocupada) {
			
			$query =  "INSERT INTO ventas
						VALUES (NULL, $numero_ticket, $base,
								$total - $base, $total, $metodo_pago,
								$mesa, CURDATE(), DATE_FORMAT(NOW(), '%H:%i:%S'),
								1, NOW(), NOW(), (TIMESTAMPDIFF(MINUTE,'$mesa_ocupada',NOW())))";
						
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();
			$venta_id = $this->pdo->lastInsertId();

			return $venta_id;

		}

		public function safeFakeVenta($mesa, $base, $iva, $total, $numero_ticket, $metodo_pago, $mesa_ocupada, $date, $time, $plus_random_timestamp) {
			
			$query =  "INSERT INTO ventas
						VALUES (NULL, $numero_ticket, $base,
								$total - $base, $total, $metodo_pago,
								$mesa, '$date', '$time',
								1, '$plus_random_timestamp', '$plus_random_timestamp', (TIMESTAMPDIFF(MINUTE,'$mesa_ocupada', '$plus_random_timestamp')))";
						
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();
			$venta_id = $this->pdo->lastInsertId();

			return $venta_id;

		}


		public function getChartData($chart_data){

			switch($chart_data) {
				
				case 'sales_by_hour':
					$query =  "SELECT	HOUR(creado) AS labels,
										COUNT(id) AS quantity,
										SUM(precio_total) AS data
										FROM ventas
										GROUP BY HOUR(creado)
										ORDER BY labels";
					break;
	
				case 'sales_by_day':
	
					$query =  "SELECT	COUNT(id) AS quantity,
										DAYNAME(creado) AS labels,
										SUM(precio_total_base) AS data
										FROM ventas
										GROUP BY labels
										ORDER BY FIELD(labels, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo')";
	
					break;
	
				case 'sales_by_month':
					
					$query ="SELECT	COUNT(id) AS quantity,
									MONTHNAME(creado) AS labels,
									SUM(precio_total) AS data
									FROM ventas
									GROUP BY labels
									ORDER BY FIELD(labels, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre')";
		   
	
					break;
	
				case 'sales_by_year':
	
					$query ="SELECT	year(creado) AS labels,
									COUNT(id) AS quantity,
									SUM(precio_total) AS data
									FROM ventas
									GROUP BY labels
									ORDER BY labels";

					break;
	
				case 'popular_payment_methods':
	
					$query ="SELECT metodos_pagos.nombre AS labels,
									COUNT(metodos_pagos.nombre) AS data FROM ventas
									INNER JOIN metodos_pagos ON metodos_pagos.id = ventas.metodo_pago_id
									GROUP BY ventas.metodo_pago_id
									ORDER BY ventas.metodo_pago_id";

					break;
	
				case 'average_service_duration':
	
					$query ="SELECT mesas.numero AS labels,
									ROUND(AVG(duracion_servicio)) AS data
									FROM `ventas`
									INNER JOIN mesas ON mesas.id = ventas.mesa_id
									GROUP BY mesas.id
									ORDER BY data DESC";
	
					break;
				
				case 'average_sale_year':

					$query ="SELECT	
									YEAR(creado) AS labels,
									ROUND(avg(precio_total),2) AS data
									FROM ventas
									GROUP BY labels
									ORDER BY labels";
	
					break;

				case 'average_sale_month':

					$query ="SELECT	
							MONTHNAME(creado) AS labels,
							ROUND(avg(precio_total),2) AS data
							FROM ventas
							GROUP BY labels
							ORDER BY FIELD(labels, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre')";
	
					break;
				
				case 'average_sale_day':

						$query ="SELECT
								DAYNAME(creado) AS labels,
								ROUND(avg(precio_total),2) AS data
								FROM ventas
								GROUP BY labels
								ORDER BY FIELD(labels, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo')";
		
						break;
			}
		
			
			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();
	
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function listadoVentas() {

			$query =  "SELECT	ventas.id AS id,
								ventas.numero_ticket AS numero_ticket,
								ventas.precio_total_base AS precio_base,
								ventas.precio_total_iva AS precio_total_iva,
								ventas.precio_total AS precio_total,
								metodos_pagos.nombre AS metodo_pago,
								mesas.numero AS mesa,
								ventas.fecha_emision AS fecha_emision,
								ventas.hora_emision AS hora_emision,
								ventas.duracion_servicio AS duracion_servicio
								FROM `ventas`
								INNER JOIN metodos_pagos ON metodos_pagos.id = ventas.metodo_pago_id
								INNER JOIN mesas ON mesas.id = ventas.mesa_id";

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

	}

?>