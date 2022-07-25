export let renderVentas = () => {

    /////////// Todo esto se repite siempre
    let pagoVentas = document.querySelectorAll(".pago-venta");
    let ticketContainer = document.querySelector(".list-group");
    let totals = document.querySelector(".totals");
    let exportSaleToExcel = document.querySelector(".export-sale-to-excel");

    ////// Borrar un producto del ticket

    pagoVentas.forEach(pagoVenta => {

        pagoVenta.addEventListener("click", (event) => {
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

                        let products = ticketContainer.querySelectorAll('li:not(.add-product-layout)');

                        ticketContainer.querySelector('.no-products').classList.remove('d-none');
    
                        totals.querySelector('.iva-percent').innerHTML = '';
                        totals.querySelector('.base').innerHTML = 0;
                        totals.querySelector('.iva').innerHTML = 0;
                        totals.querySelector('.total').innerHTML = 0;
    
                        products.forEach(product => {
                            product.remove();
                        });
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

    if(exportSaleToExcel) {

        exportSaleToExcel.addEventListener("click", (event) => {
                
            let sendPostRequest = async () => {
                
                let data = {};
                data["route"] = 'exportSaleToExcel';
                data["venta_id"] = exportSaleToExcel.dataset.sale;

                let response = await fetch('web.php', {
                    headers: {
                        'Accept': 'application/json',
                    },
                    method: 'POST',
                    body: JSON.stringify(data)
                })
                .then(response => {
                
                    if (!response.ok) throw response;

                    return response.json();
                })
                .then(json => {

                   
                })
                .catch ( error =>  {
                    console.log(error);
                });
            };

            sendPostRequest();
        }); 
    }
};