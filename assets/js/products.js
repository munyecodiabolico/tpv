export let renderProducts = () => {

    /////////// Todo esto se repite siempre
    let addProducts = document.querySelectorAll(".add-product");
    let addProductLayout = document.querySelector(".add-product-layout");
    let ticketContainer = document.querySelector(".list-group");
    let totals = document.querySelector(".totals");
    
    addProducts.forEach(addProduct => {

        addProduct.addEventListener("click", (event) => {
            // Una llamada async va siempre acompañada de un await

            let sendPostRequest = async () => {
    /////////// Todo esto se repite siempre


                // Pasamos los datos en un json
                let data = {};
                // Metemos los datos del json
                // clave - valor
                // Estos datos los recogemos de los campos data del html
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

                    let product = addProductLayout.cloneNode(true);
    
                    product.querySelector('.delete-product').dataset.ticketid = json.newProduct.id;
                    product.querySelector('.img-ticket').src =  json.newProduct.imagen_url;
                    product.querySelector('.categoria-prod').innerHTML =  json.newProduct.categoria;
                    product.querySelector('.nombre-prod').innerHTML =  json.newProduct.nombre;
                    product.querySelector('.precio-prod').innerHTML =  json.newProduct.precio_base;
                    product.classList.remove('d-none', 'add-product-layout');
    
                    totals.querySelector('.iva-percent').innerHTML = json.total.valor_iva;
                    totals.querySelector('.base').innerHTML = json.total.total_base;
                    totals.querySelector('.iva').innerHTML = json.total.iva_total;
                    totals.querySelector('.total').innerHTML = json.total.total;
    
                    if(ticketContainer.querySelector('.no-products')){
                        ticketContainer.querySelector('.no-products').classList.add('d-none');
                        ticketContainer.appendChild(product);
                    }else{
                        ticketContainer.appendChild(product);
                    }
    
                    document.dispatchEvent(new CustomEvent('renderTicket'));
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
        


};