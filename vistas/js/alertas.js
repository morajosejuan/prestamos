const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e){
    e.preventDefault();
    let data = new FormData(this);
    let method = this.getAttribute("method");
    let action = this.getAttribute("action");
    let tipo = this.getAttribute("data-form");
    
    let encabezados = new Headers();
    let config = {
        method: method,
        Headers: encabezados,
        mode: 'cors',
        cache: 'no-cache',
        body: data,
    }

    let texto_alerta;
    if(tipo=="save"){
        texto_alerta="Los datos se van a Guardar en el sistema";

    }else if(tipo=="delete"){
        texto_alerta="Los datos se van a elimiar del sistema";

    }else if(tipo=="update"){
        texto_alerta="Los datos se van a actualizar en el sistema";

    }else if(tipo=="search"){
        texto_alerta="Se eliminara el termino de busqueda y tendra que escribir uno nuevo";

    }else if(tipo=="loans"){
        texto_alerta="Desea remover los datos selecionados para prestamo o reservaciones";

    }else{
        texto_alerta="Quiere realizar la operación solicitada";
    }

    Swal.fire({
        title: '¿Estas seguro?',
        text: texto_alerta,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
           fetch(action,config)
           .then(respuesta=>respuesta.json())
           .then(respuesta=>{
                return alertas_ajax(respuesta);
           })
        }
    });

}

formularios_ajax.forEach(formularios=>{
    formularios.addEventListener("submit",enviar_formulario_ajax);
});

function alertas_ajax(alerta){
    if(alerta.Alerta==="simple"){
        Swal.fire({           
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
          });
    }else if(alerta.Alerta==="recargar"){

            Swal.fire({
                title: alerta.Titulo,
                text: alerta.Texto,
                type: alerta.Tipo,
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });

    }else if(alerta.Alerta==="limpiar"){
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(".FormularioAjax").reset();
            }
        });

    }else if(alerta.Alerta==="redireccionar"){
        window.location.href=alerta.URL;

    }
}