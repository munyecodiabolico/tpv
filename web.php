<!--
    Este archivo es lo mas cercano a un enrutador.
    Todas las llamadas javascript iran en este archivo.
-->

<?php

    require_once 'app/Controllers/TicketController.php';
  
    use app\Controllers\TicketController;
    
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

                $newProduct = $ticket->addProduct($json->price_id, $json->table_id);

                $response = array(
                    'status' => 'ok',
                    'newProduct' => $newProduct,
                );

                echo json_encode($response);

                break;
        
        }


    } else {
        echo json_encode(array('error' => 'No action'));
    }    
    
?>