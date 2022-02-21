//Input submit
const submit = document.querySelector("#enviar_nueva_noticia");

//Inputs informacion
const id = document.querySelector("#id_noti")
const titulo = document.querySelector("#titulo");
const fecha = document.querySelector("#fecha")
const contenido = document.querySelector("#contenido")
const imagen = document.querySelector("#imagen")

//Formulario
const formu = document.querySelector("#formu");

//Añadimos el evento al boton de enviar
submit.addEventListener("click",
    async(evento)=>{
        evento.preventDefault();
        if(titulo.value.trim()!=="" && contenido.value.trim()!=="" && imagen.value.trim()!=="" && fecha.value.trim()!==""){
            const datos_noticia = new URLSearchParams(new FormData(formu));
            const respuesta = await fetch("../insertar_noticia_nueva.php",
                {
                    method:"POST",
                    body:datos_noticia,
                }
            )
            const id_noti = await respuesta.json();

            const datos_noti = {
                "id":id_noti.id,
                "titulo":titulo.value.trim(),
                "contenido":contenido.value.trim(),
                "imagen": imagen.value.trim(),
                "fecha_publicacion":fecha.value.trim()
            }

            sessionStorage.setItem("NOTI_"+titulo.value.trim().replaceAll(" ", "-"),JSON.stringify(datos_noti));
            formu.reset();
        }

    }
)