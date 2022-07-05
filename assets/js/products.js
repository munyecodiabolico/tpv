export let renderProducts = () => {

    let addProducts = document.querySelectorAll(".add-product");

    addProducts.forEach(addProduct => {

        addProduct.addEventListener("click", (event) => {
            console.log(addProduct);
            // Una llamada async va siempre acompañada de un await
            let sendPostRequest = async () => {
                
                // Pasamos los datos en un json
                let data = {};
                // Metemos los datos del json
                // clave - valor
                data["route"] = 'addProduct';
                data["price_id"] = addProduct.dataset.price;
                data["table_id"] = addProduct.dataset.table;
    
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
                .catch ( error =>  {
                    console.log(JSON.stringify(error));
                });
            };
            // Llamamos a la funcion
            sendPostRequest();
        });  
    });
        

};