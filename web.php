<?php

    require_once 'app/Controllers/TicketController.php';
    require_once 'app/Controllers/TableController.php';
    require_once 'app/Controllers/VentaController.php';
    require_once 'app/Controllers/IvaController.php';
    require_once 'app/Controllers/MetodoPagoController.php';
    require_once 'app/Controllers/ProductCategoryController.php';
    require_once 'app/Controllers/ProductController.php';
    require_once 'app/Controllers/PrecioController.php';
    use app\Controllers\TicketController;
    use app\Controllers\TableController;
    use app\Controllers\VentaController;
    use app\Controllers\IvaController;
    use app\Controllers\MetodoPagoController;
    use app\Controllers\ProductCategoryController;
    use app\Controllers\ProductController;
    use app\Controllers\PrecioController;
    
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
            
            case 'storeTable':

                $table = new TableController();
                $new_table = $table->store($json->id, $json->numero, $json->ubicacion, $json->pax);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id,
                    'newElement' => $new_table
                );

                echo json_encode($response);

                break;
            
            case 'showTable':

                $table = new TableController();
                $table = $table->show($json->id);
                
                $response = array(
                    'status' => 'ok',
                    'element' => $table,
                );

                echo json_encode($response);

                break;
            
            case 'deleteTable':

                $table = new TableController();
                $table->delete($json->id);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id
                );

                echo json_encode($response);

                break;

                
                
            // casos para la administracion del IVA

            case 'storeIva':

                $iva = new IvaController();
                $new_iva = $iva->store($json->id, $json->tipo_iva, $json->vigente);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id,
                    'newElement' => $new_iva
                );

                echo json_encode($response);

                break;
            
            case 'showIva':

                $iva = new IvaController();
                $iva = $iva->show($json->id);
                
                $response = array(
                    'status' => 'ok',
                    'element' => $iva,
                );

                echo json_encode($response);

                break;
            
            case 'deleteIva':

                $iva = new IvaController();
                $iva->delete($json->id);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id
                );

                echo json_encode($response);

                break;


            // casos para la administracion de los metodos de pago

            case 'storeMetodoPago':

                $metodo_pago = new MetodoPagoController();
                $new_metodo_pago = $metodo_pago->store($json->id, $json->nombre);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id,
                    'newElement' => $new_metodo_pago
                );

                echo json_encode($response);

                break;
            
            case 'showMetodoPago':

                $metodo_pago = new MetodoPagoController();
                $metodo_pago = $metodo_pago->show($json->id);
                
                $response = array(
                    'status' => 'ok',
                    'element' => $metodo_pago,
                );

                echo json_encode($response);

                break;
            
            case 'deleteMetodoPago':

                $metodo_pago = new MetodoPagoController();
                $metodo_pago->delete($json->id);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id
                );

                echo json_encode($response);

                break;


            // casos para la administracion de las categorias de productos

            case 'storeProductCategory':

                $categoria = new ProductCategoryController();

                if(isset($json->imagen_url->name)){
                    $imagen_url = "/upload/category/".$json->imagen_url->name;               
                }else{
                    $imagen_url = null;
                }

                $new_categoria = $categoria->store($json->id, $json->nombre, $imagen_url);
                
                $response = array(
                    'status' => 'ok',
                    'id' => $json->id,
                    'newElement' => $new_categoria
                );

                echo json_encode($response);

                break;
            
            case 'showProductCategory':

                $categoria = new ProductCategoryController();
                $categoria = $categoria->show($json->id);
                
                $response = array(
                    'status' => 'ok',
                    'element' => $categoria,
                );

                echo json_encode($response);

                break;
            
            case 'deleteProductCategory':

                $categoria = new ProductCategoryController();
                $categoria->delete($json->id);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id
                );

                echo json_encode($response);

                break;


            // casos para la administracion de productos

            case 'storeProducto':

                $producto = new ProductController();
                $precio = new PrecioController();
                
                if(isset($json->imagen_url->name)){
                    $imagen_url = "/upload/product/".$json->imagen_url->name;               
                }else{
                    $imagen_url = null;
                }

                $new_producto_id = $producto->store($json->id, $json->nombre, $json->categoria_id, $json->visible, $imagen_url);
                $new_precio = $precio->store($new_producto_id, $json->iva_id, $json->precio);
                $new_producto = $producto->show($new_producto_id);
                
                $response = array(
                    'status' => 'ok',
                    'id' => $json->id,
                    'newElement' => $new_producto
                );

                echo json_encode($response);

                break;
            
            case 'showProducto':

                $producto = new ProductController();
                $producto = $producto->show($json->id);
                
                $response = array(
                    'status' => 'ok',
                    'element' => $producto,
                );

                echo json_encode($response);

                break;
            
            case 'deleteProducto':

                $producto = new ProductController();
                $precio = new PrecioController();

                $producto->delete($json->id);
                $precio->delete($json->id);

                $response = array(
                    'status' => 'ok',
                    'id' => $json->id
                );

                echo json_encode($response);

                break;

            case 'getSaleChartData':
        
                $sale = new VentaController();
                $data = $sale->getChartData($json->chart_data);
                
                foreach($data as $value){
                    $response['labels'][] = isset($value['labels']) ? $value['labels'] : null;
                    $response['data'][] = isset($value['data']) ? $value['data'] : null;
                    $response['quantity'][] = isset($value['quantity']) ? $value['quantity'] : null;
                }

                echo json_encode($response);
                
                break;
            
                
            case 'getTicketChartData':

                $ticket = new TicketController();
                $data = $ticket->getChartData($json->chart_data);
                
                foreach($data as $value){
                    $response['labels'][] = isset($value['labels']) ? $value['labels'] : null;
                    $response['data'][] = isset($value['data']) ? $value['data'] : null;
                    $response['quantity'][] = isset($value['quantity']) ? $value['quantity'] : null;
                }

                echo json_encode($response);
                
                break;

            

        }

    } else {
        echo json_encode(array('error' => 'No action'));
    }    
    
?>