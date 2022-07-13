export let renderAdminForms = () => {

    /////////// Todo esto se repite siempre
    let adminForm = document.querySelector(".admin-form");
    let sendButton = document.querySelector(".send-button");

    sendButton.addEventListener("click", (event) => {

        event.preventDefault();

        let sendPostRequest = async () => {

            let data = new FormData(adminForm);

            for (var pair of data.entries()) {
                console.log(pair[0]+ ', ' + pair[1]); 
            }

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
                console.log(JSON.stringify(error));
            });
        };

        sendPostRequest();
    });  
        
};