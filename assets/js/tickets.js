export let renderTickets = () => {


    /////////// Todo esto se repite siempre
    let deleteProducts = document.querySelectorAll(".delete-product");
    let deleteAllProducts = document.querySelector(".delete-all-products");
    let ticketContainer = document.querySelector(".list-group");
    let totals = document.querySelector(".totals");
    
    document.addEventListener("renderTicket",( event =>{
        renderTickets();
    }), {once: true});

    ////// Borrar un producto del ticket

    deleteProducts.forEach(deleteProduct => {

        deleteProduct.addEventListener("click", (event) => {
            // Una llamada async va siempre acompañada de un await

            let sendPostRequest = async () => {
            /////////// Todo esto se repite siempre

                // Pasamos los datos en un json
                let data = {};
                // Metemos los datos del json
                // clave - valor
                // Estos datos los recogemos de los campos data del html
                data["route"] = 'deleteProduct';
                data["ticket_id"] = deleteProduct.dataset.ticketid;
                data["table_id"] = deleteProduct.dataset.table;
    
                // Enviamos los datos
                let response = await fetch('web.php', {
                    // Aceptamos que el servidor nos devuelva json
                    headers: {
                        'Accept': 'application/json',
                    },
                    // El metodo de envio es POST
                    method: 'DELETE',
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

                    deleteProduct.parentElement.remove();

                    if(json.total == false){

                        ticketContainer.querySelector('.no-products').classList.remove('d-none');
                        totals.querySelector('.iva-percent').innerHTML = '';
                        totals.querySelector('.base').innerHTML = 0;
                        totals.querySelector('.iva').innerHTML = 0;
                        totals.querySelector('.total').innerHTML = 0;
                        
                    }else{
                        totals.querySelector('.iva-percent').innerHTML = json.total.valor_iva;
                        totals.querySelector('.base').innerHTML = json.total.total_base;
                        totals.querySelector('.iva').innerHTML = json.total.iva_total;
                        totals.querySelector('.total').innerHTML = json.total.total;
                    }
                })
                // Si da error, mostramos el error en el CATCH
                .catch ( error =>  {
                    console.log(error);
                });
            };
            // Llamamos a la funcion
            sendPostRequest();
        });  
    });


    ////// Borrar todos los productos que hay en un ticket

    if(deleteAllProducts){

        deleteAllProducts.addEventListener("click", (event) => {
            // Una llamada async va siempre acompañada de un await

            let sendPostRequest = async () => {
            /////////// Todo esto se repite siempre

                // Pasamos los datos en un json
                let data = {};
                // Metemos los datos del json
                // clave - valor
                // Estos datos los recogemos de los campos data del html
                data["route"] = 'deleteAllProducts';
                data["table_id"] = deleteAllProducts.dataset.table;

                // Enviamos los datos
                let response = await fetch('web.php', {
                    // Aceptamos que el servidor nos devuelva json
                    headers: {
                        'Accept': 'application/json',
                    },
                    // El metodo de envio es POST
                    method: 'DELETE',
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
                .catch ( error =>  {
                    console.log(error);
                });
            };
            // Llamamos a la funcion
            sendPostRequest();
        });     
    }
};