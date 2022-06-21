<?php

namespace app\Models;
require_once 'core/Connection.php';

use PDO;
use core\Connection;

class Ticket extends Connection{

	public function index($mesa){

        $query =
            "SELECT mesas.id AS MESA, productos_categorias.nombre AS CATEGORIA, productos.nombre AS PRODUCTO, productos.id,
                    precios.precio_base AS BASE_IMPONIBLE, iva.tipo_iva AS IVA, productos.imagen_url AS IMAGEN FROM tickets
                    INNER JOIN precios ON precios.id = tickets.precio_id
                    INNER JOIN mesas ON mesas.id = tickets.mesa_id
                    INNER JOIN productos ON productos.id = precios.producto_id
                    INNER JOIN iva ON iva.id = precios.iva_id
                    INNER JOIN productos_categorias ON productos_categorias.id = productos.categoria_id
                    WHERE mesas.id = $mesa AND venta_id IS NULL AND tickets.activo = 1";
                
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>