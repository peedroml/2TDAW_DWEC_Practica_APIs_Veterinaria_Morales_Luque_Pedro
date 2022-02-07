"use strict"

//Seleccionamos el contenedor de las noticias
const contentNoti = document.querySelector("#contenedorNot");

//Array de meses del año
const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

//Hacemos la funcion para construir los contenedores de las noticias
const hijosNoticias = (id_noticia,titulo, contenido, imagen, fInserccion) => {
    //Contenedor padre
    let div_padre = document.createElement("div");

    //Titulo de la noticia
    let titulo_noticia = document.createElement("h3");
    titulo_noticia.innerText = titulo;

    //Contenido resumido de la noticia
    let contenido_noticia = document.createElement("p");
    let contenido_txt = contenido.substr(0, 105);
    contenido_noticia.innerText = contenido_txt;

    //Imagen de la noticia
    let imagen_noticia = document.createElement("img");
    imagen_noticia.src = `../../img/noticias/${imagen}`;

    //Fecha de inserccion de la noticia
    let fecha_inserccion = document.createElement("p");
    let fecha = fInserccion.split("-");
    let mes_introducido = (fecha[1]) - 1;
    let dia_introducido = fecha[2].replace(/^(0+)/g, '');
    fecha_inserccion.innerText = `${dia_introducido} de ${meses[mes_introducido]} del año ${fecha[0]} `;

    //Hacemos el formulario para ver la noticia completa
    let formulario = document.createElement("form");
    formulario.classList.add("form_noticias")
    formulario.action = "pagina_dinamica.php";
    formulario.method = "post";

    //Primer input
    let input_1 = document.createElement("input");
    input_1.type = "hidden";
    input_1.name = "id_noticia";
    input_1.value = id_noticia;

    formulario.appendChild(input_1);

    //Segundo input
    let input_2 = document.createElement("input");
    input_2.type = "hidden";
    input_2.name = "enlacePagina";
    input_2.value = "noticias.php";

    formulario.appendChild(input_2);

    //Tercer input
    let input_3 = document.createElement("input");
    input_3.type = "submit";
    input_3.name = "ver";
    input_3.value = "Ver noticia completa";

    formulario.appendChild(input_3);

    //Añadimos todos los elementos al div padre
    div_padre.appendChild(titulo_noticia)
    div_padre.appendChild(contenido_noticia)
    div_padre.appendChild(imagen_noticia)
    div_padre.appendChild(fecha_inserccion)
    div_padre.appendChild(formulario)

    return div_padre;
}


if (sessionStorage.length === 0) {
    //La primera vez que se carge la pagina, se metera todo en el sesion
    (async () => {
        const request = await fetch("../insertar/pedirServidor.php");
        
        //Cogemos los datos que nos devuelve nuestro archivo
        const datos_noticias = await request.json();

        datos_noticias.forEach(
            (noticia) => {
                //Metemos los datos en el session storage
                sessionStorage.setItem("NOTI_" + noticia["titulo"].replaceAll(" ", "-"), JSON.stringify(noticia));
            }
        )

        Object.values(sessionStorage).forEach(
            (noticia)=>{
                contentNoti.appendChild(hijosNoticias(noticia["id"],noticia["titulo"], noticia["contenido"], noticia["imagen"], noticia["fecha_publicacion"]))
            }
        )
    })();
} else {
    //En el caso de que ya haya datos en el session storage, se cargaran en la aplicacion
    Object.values(sessionStorage).forEach(
        (noticia) => {
            contentNoti.appendChild(hijosNoticias(noticia["id"],noticia["titulo"], noticia["contenido"], noticia["imagen"], noticia["fecha_publicacion"]));
        }
    )
}