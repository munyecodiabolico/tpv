<!--
    Este archivo es lo mas cercano a un enrutador.
    Todas las llamadas javascript iran en este archivo.
-->

<?php

    require_once 'app/Controllers/TicketController.php';
    require_once 'app/Controllers/TableController.php';
    require_once 'app/Controllers/VentaController.php';
  
    use app\Controllers\TicketController;
    use app\Controllers\TableController;
    use app\Controllers\VentaController;
    
    // Le digo que voy a aceptar datos json y va juntamente con *******
    header("Content-Type: application/json");

    if(isset($_GET['data'])){
        $json = json_decode($_GET['data']);
    }else{
        // ****** Capturamos todos los datos en la variable json que vienen via metodo POST a traves de la funcion FETCH de javascript
        $json = json_decode(file_get_contents('php://input'));
    }


    //  $json->route es como si escribiera " data["route"] = 'addProduct'" en el archivo products.js;
    if(isset($json->route)) {

        switch($json->route) {

            case 'addProduct':

                $ticket = new TicketController();
                $mesa = new TableController();

                $newProduct = $ticket->addProduct($json->price_id, $json->table_id);
                $total = $ticket->total($json->table_id);
                $mesa->mesa_update($json->table_id, 1);

                $response = array(
                    'status' => 'ok',
                    'newProduct' => $newProduct,
                    'total' => $total
                );

                echo json_encode($response);

                break;

            case 'deleteProduct':

                $ticket = new TicketController();
                $mesa = new TableController();

                $delete_product = $ticket->deleteProduct($json->ticket_id, $json->table_id);
                $total = $ticket->total($json->table_id);
                
                if (empty($total['total_base'])) {
                    $mesa->mesa_update($json->table_id, 0);
                }
                $response = array(
                    'status' => 'ok',
                    'total' => $total
                );

                echo json_encode($response);

                break;

            case 'deleteAllProducts':

                $ticket = new TicketController();
                $mesa = new TableController();

                $delete_products = $ticket->deleteAllProducts($json->table_id);
                $mesa->mesa_update($json->table_id, 0);
                
                $response = array(
                    'status' => 'ok',
                    'total' => $total
                );

                echo json_encode($response);

                break;
    
            case 'pagoVenta':

                $ticket = new TicketController();
                $mesa = new TableController();
                $venta = new VentaController();

                $total = $ticket->total($json->table_id);
                $last_ticket = $venta->last_ticket();
                $mesa_ocupada = $ticket->mesa_ocupada($json->table_id);
                $venta_id = $venta->safe_venta($json->table_id,
                                            $total['total_base'],
                                            $total['valor_iva'],
                                            $total['total'],
                                            $last_ticket,
                                            $json->metodo_pago,
                                            $mesa_ocupada['creado']
                                        );
                $closeTicketVenta = $ticket->closeTicketVenta($json->table_id, $venta_id);
                $mesa->mesa_update($json->table_id, 0);
                
                $response = array(
                    'status' => 'ok',
                    'total' => $total
                );

                echo json_encode($response);

                break;
        }


    } else {
        echo json_encode(array('error' => 'No action'));
    }    
    
?>