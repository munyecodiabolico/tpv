export let renderTickets = () => {


    /////////// Todo esto se repite siempre
    let deleteProducts = document.querySelectorAll(".delete-product");
    let deleteAllProducts = document.querySelector(".delete-all-products");
    


    ////// Borrar un producto del ticket

    deleteProducts.forEach(deleteProduct => {

        deleteProduct.addEventListener("click", (event) => {
            console.log(deleteProduct);
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
                    
                })
                // Si da error, mostramos el error en el CATCH
                .catch ( error =>  {
                    console.log(JSON.stringify(error));
                });
            };
            // Llamamos a la funcion
            sendPostRequest();
        });  
    });




    ////// Borrar todos los productos que hay en un ticket

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
                
            })
            // Si da error, mostramos el error en el CATCH
            .catch ( error =>  {
                console.log(JSON.stringify(error));
            });
        };
        // Llamamos a la funcion
        sendPostRequest();
    });  
        

};