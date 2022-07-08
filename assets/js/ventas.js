export let renderVentas = () => {


    /////////// Todo esto se repite siempre
    let pagoVentas = document.querySelectorAll(".pago-venta");


    ////// Borrar un producto del ticket

    pagoVentas.forEach(pagoVenta => {

        pagoVenta.addEventListener("click", (event) => {
            console.log(pagoVenta);
            // Una llamada async va siempre acompañada de un await

            let sendPostRequest = async () => {
                /////////// Todo esto se repite siempre

                // Pasamos los datos en un json
                let data = {};
                // Metemos los datos del json
                // clave - valor
                // Estos datos los recogemos de los campos data del html
                data["route"] = 'pagoVenta';
                data["metodo_pago"] = pagoVenta.dataset.metodopago;
                data["table_id"] = pagoVenta.dataset.table;

                // Enviamos los datos
                let response = await fetch('web.php', {
                    // Aceptamos que el servidor nos devuelva json
                    headers: {
                        'Accept': 'application/json',
                    },
                    // El metodo de envio es POST
                    method: 'POST',
                    // Pasamos los datos en formato json
                    body: JSON.stringify(data)
                })
                    // Convertimos la respuesta a json
                    .then(response => {
                        // sI da error, mostramos el error en el CATCH
                        if (!response.ok) throw response;
                        // Si no da error, devolvemos la respuesta
                        return response.json();
                    })
                    .then(json => {

                    })
                    // Si da error, mostramos el error en el CATCH
                    .catch(error => {
                        console.log(JSON.stringify(error));
                    });
            };
            // Llamamos a la funcion
            sendPostRequest();
        });
    });


};