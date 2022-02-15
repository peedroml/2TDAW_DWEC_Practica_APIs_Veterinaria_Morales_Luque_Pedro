//Input submit
const submit = document.querySelector("#enviar_nueva_noticia");

//Inputs informacion
const id = document.querySelector("#id_noti")
const titulo = document.querySelector("#titulo");
const fecha = document.querySelector("#fecha")
const contenido = document.querySelector("#contenido")
const imagen = document.querySelector("#imagen")

//Añadimos el evento al boton de enviar
submit.addEventListener("click",
    ()=>{
        const titulo = titulo.value;

        const imagen = "noticia_"+id+".jpg";

        const ID_NOTICIA = "NOTI_" + titulo.replaceAll(" ", "-");

        const datos_noticia = {
            "id":id.value,
            "titulo":titulo,
            "contenido":contenido.value.trim(),
            "imagen": imagen,
            "fecha":fecha.value
        }

        sessionStorage.setItem(ID_NOTICIA,JSON.stringify(datos_noticia));
    }
)