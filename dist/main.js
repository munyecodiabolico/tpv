(()=>{"use strict";document.querySelectorAll(".add-product").forEach((e=>{e.addEventListener("click",(t=>{console.log(e),(async()=>{let t={route:"addProduct"};t.price_id=e.dataset.price,t.table_id=e.dataset.table,await fetch("web.php",{headers:{Accept:"application/json"},method:"POST",body:JSON.stringify(t)}).then((e=>{if(!e.ok)throw e;return e.json()})).then((e=>{})).catch((e=>{console.log(JSON.stringify(e))}))})()}))})),(()=>{let e=document.querySelectorAll(".delete-product"),t=document.querySelector(".delete-all-products");e.forEach((e=>{e.addEventListener("click",(t=>{console.log(e),(async()=>{let t={route:"deleteProduct"};t.ticket_id=e.dataset.ticketid,t.table_id=e.dataset.table,await fetch("web.php",{headers:{Accept:"application/json"},method:"DELETE",body:JSON.stringify(t)}).then((e=>{if(!e.ok)throw e;return e.json()})).then((e=>{})).catch((e=>{console.log(JSON.stringify(e))}))})()}))})),t.addEventListener("click",(e=>{(async()=>{let e={route:"deleteAllProducts"};e.table_id=t.dataset.table,await fetch("web.php",{headers:{Accept:"application/json"},method:"DELETE",body:JSON.stringify(e)}).then((e=>{if(!e.ok)throw e;return e.json()})).then((e=>{})).catch((e=>{console.log(JSON.stringify(e))}))})()}))})(),document.querySelectorAll(".pago-venta").forEach((e=>{e.addEventListener("click",(t=>{console.log(e),(async()=>{let t={route:"pagoVenta"};t.metodo_pago=e.dataset.metodopago,t.table_id=e.dataset.table,await fetch("web.php",{headers:{Accept:"application/json"},method:"POST",body:JSON.stringify(t)}).then((e=>{if(!e.ok)throw e;return e.json()})).then((e=>{})).catch((e=>{console.log(JSON.stringify(e))}))})()}))}))})();